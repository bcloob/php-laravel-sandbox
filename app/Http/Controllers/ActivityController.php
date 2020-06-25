<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Order;
use App\Repositories\OrderRepositoryInterface;
use App\Transformers\ActivitiyView;
use App\Transformers\CallBackResultArry;
use App\Transformers\FaildActivitiyView;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Constraint\Callback;
use Spatie\Fractal\Fractal;


class ActivityController extends Controller
{


    private $paymentEndpoint = 'https://api.idpay.ir/v1.1/payment';
    private $calbackUrl;


    // space that we can use the repository from
    protected $model;

    public function __construct(OrderRepositoryInterface $model)
    {
        $this->calbackUrl=env('Call_Back_URL');
        $this->model = $model;

    }


    /**
     * @param null $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function show($id = null)
    {

        $paymentAnswerHtml = '';
        $callbackHtml = '';
        $transferToPortHtml = '';
        $callbackResultHtml = '';
        $verifyTansactionHtml = '';


        if ($id !== null) {

            $order = Order::find($id);
            $activityCreate = $order->activities->where('step', 'create')->last();
            $callbackResult = $order->activities->where('step', 'return')->last();

            $activityCreate = Fractal::create()->item($activityCreate, new ActivitiyView())
                ->toArray();


            $paymentAnswerHtml = view('partial.paymentAnswer')->with([
                'activity' => $activityCreate,
            ])->render();

            $transferToPortHtml = view('partial.transferToPort')->with([
                'link' => $activityCreate['data']['link'],
                'order_id' => $order->id,
            ])->render();


            $callbackHtml = view('partial.callback')->with([
                'url' => json_decode($activityCreate['data']['response'])->link,
            ])->render();



            $callbackResultArray = Fractal::create()->item($callbackResult->response, new CallBackResultArry())
                ->toArray();

//            dd($callbackResultArray['data']);
            $callbackResultHtml = view('partial.callbackResult')->with([
                'callbackResult' => $callbackResultArray['data'],
                'url' => json_decode($activityCreate['data']['response'])->link,

            ])->render();



            $verifyTansactionHtml = view('partial.verifyTransaction')->with([
                'callbackResult' => $callbackResult,
                'order_id' => $order->id,
            ])->render();


        }


        return view('show')
            ->with(
                [
                    'paymentAnswerHtml' => $paymentAnswerHtml,
                    'transferToPortHtml' => $transferToPortHtml,
                    'callbackHtml' => $callbackHtml,
                    'callbackResultHtml' => $callbackResultHtml,
                    'verifyTansactionHtml' => $verifyTansactionHtml,
                ]
            );

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function store(Request $request)
    {

        $order = $this->model->create($request->toArray());

        $params = [
            'order_id' => $order->id,
            'API_KEY' => $request->api_key,
            'sandbox' => $request->sandbox,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'amount' => $request->amount,
            'reseller' => $request->reseller,
            'status' => 'processing',
            'callback' => $this->calbackUrl,
            'desc' => 'توضیحات پرداخت کننده',

        ];

        $header = [
            'Content-Type' => 'application/json',
            "X-API-KEY" => $params['API_KEY'],
            'X-SANDBOX' => $params['sandbox']
        ];



        $client = new Client();
        $response = $client->request('POST', $this->paymentEndpoint,
            [
                'json' => $params,
                'headers' => $header,
                'http_errors' => false
            ]);


        $responseBody = json_decode($response->getBody());
        $activity = [
            'step' => 'create',
            'request' => json_encode($params),
            'response' => json_encode($responseBody)
        ];

        $activity = $this->model->createActivity($activity, $order->id);


        if ($response->getStatusCode() == 201) {

            $this->model->update(['return_id' => $responseBody->id], $order->id);
            $activity = Fractal::create()->item($activity, new ActivitiyView())
                ->toArray();

            $paymentAnswer = view('partial.paymentAnswer')->with([
                'activity' => $activity,
            ])->render();


            $transferToPort = view('partial.transferToPort')->with([
                'link' => $activity['data']['link'],
                'order_id' => $order->id,
                'callBackUrl' => $this->calbackUrl,
            ])->render();

            return \response()->json(['status' => 'OK', 'paymentAnswer' => $paymentAnswer, 'transferToPort' => $transferToPort, 'message' => 'salam khosh amadi']);


        }else{

            $activity = Fractal::create()->item($activity, new FaildActivitiyView())
                ->toArray();

            $paymentAnswer = view('partial.paymentAnswer')->with([
                'activity' => $activity,
            ])->render();


            return \response()->json(['status' => 'ERROR', 'paymentAnswer' => $paymentAnswer, 'message' => 'salam khosh amadi']);


        }


    }


    public function payment(Request $request, $id)
    {

        $order = Order::find($id);
        $activity = [
            'step' => 'redirect',
            'request' => $order->activities->last()->request,
            'response' => json_encode([]),
        ];

        $activity = $this->model->createActivity($activity, $order->id);
        return \response()->json(['status' => 'OK', 'link' => $request->link,'message' => 'salam khosh amadi']);
    }


    /*
     * after connect in API IDPay return this function
     */
    public function callback(Request $request)
    {


        $activity = array(
            'order_id' => $request['order_id'],
            'step' => 'return',
            'request' => json_encode([]),
            'response' => json_encode($request->all())
        );

        $this->model->createActivity($activity, $request->order_id);
        return redirect()->route('show', $request['order_id']);

    }

    /**
     * @param $status
     * @return string
     */
    public function get_status_description($status)
    {
        switch ($status) {
            case 1:
                return 'پرداخت انجام نشده است';
                break;
            case 2:
                return 'پرداخت ناموفق بوده است';
                break;
            case 3:
                return 'خطا رخ داده است';
                break;
            case 4:
                return 'بلوکه شده';
                break;
            case 5:
                return 'برگشت به پرداخت کننده';
                break;
            case 6:
                return 'برگشت خورده سیستمی';
                break;
            case 7:
                return 'انصراف از پرداخت';
                break;
            case 8:
                return 'به درگاه پرداخت منتقل شد';
                break;
            case 10:
                return 'در انتظار تایید پرداخت';
                break;
            case 100:
                return 'پرداخت تایید شده است';
                break;
            case 101:
                return 'پرداخت قبلا تایید شده است';
                break;

            case 200:
                return 'به دریافت کننده واریز شد';
                break;
            case 405:
                return 'تایید پرداخت امکان پذیر نیست.';
                break;

        }

    }

    /*
     * connect to verify API IDPay and check double spendding
     */
    public function verify(Request $request, $id)
    {


        $order = Order::find($id);


        $params = [
            'id' => json_decode($order->activities->where('step', 'create')->last()->response)->id,
            'order_id' => $order->id,
        ];



        $header = [
            'Content-Type' => 'application/json',
            "X-API-KEY" => $order['API_KEY'],
            'X-SANDBOX' => $order['sandbox']
        ];


        //connect to verify API IDPay
        $client = new Client();

        $request = [
            'json' => $params,
            'headers' => $header,
            'http_errors' => false

        ];

        $res = $client->request('POST', 'https://api.idpay.ir/v1.1/payment/verify', $request);

        $response = json_decode($res->getBody());

        $activity = array(
            'step' => 'verify',
            'request' => json_encode($request),
            'response' => json_encode($response)
        );

        $activity = $this->model->createActivity($activity, $order->id);
        return \response()->json(['status' => 'OK', 'request' => json_decode($activity['request']), 'response' => json_decode($activity['response']),'message' => 'salam khosh amadi']);

    }

//    public function store_callback(Request $request)
//    {
//
//        //insert in activity table
//        $activity = [
//            'order_id' => $request['order_id'],
//            'step' => 'redirect',
//            'request' => json_encode(['url ' . $request['link']]),
//            'response' => json_encode([])
//        ];
//        Activity::insert($activity);
//
//
//    }
}
