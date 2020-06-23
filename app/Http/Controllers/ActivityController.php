<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Order;
use App\Repositories\OrderRepositoryInterface;
use App\Transformers\ActivitiyView;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Spatie\Fractal\Fractal;


class ActivityController extends Controller
{


    private $paymentEndpoint = 'https://api.idpay.ir/v1.1/payment';


    // space that we can use the repository from
    protected $model;

    public function __construct(OrderRepositoryInterface $model)
    {
        $this->model = $model;

    }


    /*
     * show all step payment
     */
    public function show($id = 0)
    {


        $activity = [];
        $order = [];
        $data = [];
        if ($id != 0) {
            $order = Order::where('id', $id)->first();
            $activity = Activity::where('order_id', $id)->get();
            $activity->toJson();

        }
        $data['activity'] = $activity;
        $data['order'] = $order;

        return view('show', $data);
    }

    /*
     * get input data and insert in database and connect to idpay and create transaction
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
            'callback' => 'http://127.0.0.1:8000/callback',
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


        if ($response->getStatusCode() == 201) {

            $this->model->update(['return_id' => $responseBody->id], $order->id);

        }


        //set value for activity table
        $activity = [
            'step' => 'create',
            'request' => json_encode($params),
            'response' => json_encode($responseBody)
        ];


        $activity = $this->model->createActivity($activity, $order->id);


        $activity = Fractal::create()->item($activity, new ActivitiyView())
            ->toArray();



        $html= view('partial.paymentAnswer')->with([
            'activity' => $activity,
        ])->render();

        return $html;

    }

    /*
     * after connect in API IDPay return this function
     */
    public function callback(Request $request)
    {


        //check pay amount is equal orginal amount
        $order = Order::where('id', $request->order_id)->first();
        if ($order->amount != $request->amount) {
            $request->request->add(['status' => 405]);
        }


        $request->request->add(['message' => $this->get_status_description($request->status)]);

        //set data for insert in activity table
        $activity = array(
            'order_id' => $request['order_id'],
            'step' => 'return',
            'request' => json_encode([]),
            'response' => json_encode($request->all())
        );
        Activity::insert($activity);


        return redirect()->route('show', $request['order_id']);

    }

    /*
     * set message
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
    public function verify(Request $request)
    {

        $params = [
            'id' => $request['id'],
            'order_id' => $request['order_id'],
        ];
        $order = order::where('id', $request['order_id'])->first();

        $_request['params'] = $params;
        $_request['url'] = 'POST: https://api.idpay.ir/v1.1/payment/verify';
        $_request['header'] = [
            'Content-Type' => 'application/json',
            "X-API-KEY" => $order['API_KEY'],
            'X-SANDBOX' => $order['sandbox']
        ];

        //connect to verify API IDPay
        $client = new Client();
        $res = $client->request('POST', 'https://api.idpay.ir/v1.1/payment/verify',
            [
                'json' => $params,
                'headers' => $_request['header'],
                'http_errors' => false

            ]);

        $response = json_decode($res->getBody());

        //double sppending
        if ($request['order_id'] != $response->order_id || $request['id'] != $response->id) {
            $response->status = 405;

        }

        //insert in activity table
        $activity = [
            'order_id' => $request['order_id'],
            'step' => 'verify',
            'request' => json_encode($_request),
            'response' => $res->getBody()
        ];
        $id = Activity::insertGetId($activity);

        //update staus
        Order::where('id', $params['order_id'])
            ->update(['status' => 'complete']);


        $data = Activity::where('id', $id)->first();
        $data->tojson();
        $data->request = json_decode($data->request);
        $data->response = json_decode($data->response);
        return $data;

    }

    public function store_callback(Request $request)
    {

        //insert in activity table
        $activity = [
            'order_id' => $request['order_id'],
            'step' => 'redirect',
            'request' => json_encode(['url ' . $request['link']]),
            'response' => json_encode([])
        ];
        Activity::insert($activity);


    }
}
