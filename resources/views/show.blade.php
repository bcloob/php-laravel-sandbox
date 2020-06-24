@extends('layouts.master')





@section('content')




    <div class="row">
        <blockquote class="blockquote text-center titleAction">
            <p class="mb-0">ایجاد تراکنش</p>
            <footer class="blockquote-footer"><cite title="Source Title">برای ایجاد تراکنش باید مقادیر زیر را کامل
                    کنید.</cite></footer>
        </blockquote>


        <div class="col-lg-6">


            <form class="form-horizontal" action="{{route('store')}}" id="snedPaymentApi" method="post">

                @csrf
                <div class="form-group">
                    <label class="control-label col-sm-3" for="{{__('sandbox.api_key')}}">{{__('sandbox.api_key')}}
                        :</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="api_key" placeholder="Enter email" name="api_key">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="{{__('sandbox.name')}}">{{__('sandbox.name')}}:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" placeholder="Enter password" name="name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3"
                           for="{{__('sandbox.phone_number')}}">{{__('sandbox.phone_number')}}:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="phone_number" placeholder="Enter phone_number"
                               name="phone_number">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="{{__('sandbox.email')}}">{{__('sandbox.email')}}:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="{{__('sandbox.amount')}}">{{__('sandbox.amount')}}
                        :</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="amount" placeholder="Enter amount" name="amount">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="{{__('sandbox.reseller')}}">{{__('sandbox.reseller')}}
                        :</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="reseller" placeholder="Enter reseller_code"
                               name="reseller">
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-sm-3" for="{{__('sandbox.sanbox')}}">{{__('sandbox.sanbox')}}
                        :</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="sandbox" id="exampleFormControlSelect2">
                            <option value="1">YES</option>
                            <option value="0">NO</option>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>


        </div>

        <div class="col-lg-6" id="paymentResult">

            {!! $paymentAnswerHtml !!}

        </div>


    </div>






    <div class="row">
        <blockquote class="blockquote text-center titleAction" id="titleTranserToGetway">
            <p class="mb-0">انتقال به درگاه</p>
            <footer class="blockquote-footer"><cite title="Source Title">
                </cite></footer>
        </blockquote>


        <div class="col-lg-6" id="transferToPort">

            {!! $transferToPortHtml !!}

        </div>

        <div class="col-lg-6" id="transferToPortWait">

            {!! $callbackHtml !!}


            <div id="timing" class="en"></div>
            <div id="msg"  class="en" style="display: none">Redirect to {{env('Call_Back_URL')}}</div>




        </div>

    </div>





    <div class="row">

        {!! $callbackResultHtml !!}

    </div>







    <div class="row">

        {!! $verifyTansactionHtml !!}

    </div>









    <script>

        $(document).on('submit', '#snedPaymentApi', function (e) {


            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');
            // var content = form.attr('data-div');
            // var create_button = $(form).parent().children('.create_button').attr('id');

            alert(url)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: url,


                method: 'post',
                data: form.serialize(),
                success: function (result) {

                    jQuery('#titleTranserToGetway').show();
                    jQuery('#paymentResult').html(result.paymentAnswer);
                    jQuery('#transferToPort').html(result.transferToPort);

                },
                error: function (error) {
                    console.log(error);
                }
            });
        });


    </script>

@endsection






{{--@section('title', 'Payment')--}}

{{--@section('content')--}}


{{--<div id="loader"--}}
{{--style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">--}}
{{--<img src='{{asset('image/images.png')}}' width="64" height="64"/>--}}
{{--<br>Loading..--}}
{{--</div>--}}


{{--@if(is_array($activity))--}}
{{--<div class="row">--}}
{{--<div class="title"><h3>ایجاد تراکنش</h3></div>--}}
{{--<div class="col-md-6">--}}
{{--<div id="form" class="row">--}}

{{--<div class=" row col-md-12">--}}
{{--{{ Form::label('APIKEY', 'APIKEY', ['class' => 'col-md-3']) }}--}}

{{--{{ Form::text('APIKEY',Null,['class' => ' col-md-5']) }}--}}
{{--</div>--}}
{{--<div class=" row col-md-12">--}}
{{--{{ Form::label('Sandbox', 'آزمایشگاه', ['class' => 'col-md-3']) }}--}}

{{--<input id="sandbox" name="sandbox" value="1" type="checkbox"></input>--}}
{{--</div>--}}
{{--<div class="row col-md-12">--}}
{{--{{ Form::label('Name', 'نام', ['class' => 'col-md-3']) }}--}}
{{--{{ Form::text('name',Null,['class' => ' col-md-5']) }}--}}

{{--</div>--}}
{{--<div class="row col-md-12">--}}
{{--{{ Form::label('Phone', 'تلفن', ['class' => 'col-md-3']) }}--}}
{{--{{ Form::text('phone',Null,['class' => ' col-md-5']) }}--}}

{{--</div>--}}

{{--<div class="row col-md-12">--}}
{{--{{ Form::label('Mail', 'ایمیل', ['class' => 'col-md-3']) }}--}}
{{--{{ Form::text('mail',Null,['class' => ' col-md-5']) }}--}}

{{--</div>--}}
{{--<div class="row col-md-12">--}}
{{--{{ Form::label('Amount', 'قیمت', ['class' => 'col-md-3']) }}--}}
{{--{{ Form::text('amount',Null,['class' => ' col-md-5']) }}--}}

{{--</div>--}}
{{--<div class="row col-md-12">--}}
{{--{{ Form::label('Reseller', 'کد نمایندگی', ['class' => 'col-md-3']) }}--}}
{{--{{ Form::text('reseller',Null,['class' => ' col-md-5']) }}--}}

{{--</div>--}}
{{--<button onclick="payment_new()">Payment</button>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="col-md-6 " id="create" style="display: none">--}}
{{--<lable class="col-md-3">درخواست</lable>--}}
{{--<textarea id="request-create" style="direction: ltr"></textarea>--}}
{{--<lable class="col-md-3">پاسخ</lable>--}}
{{--<textarea id="response-create" style="direction: ltr"></textarea>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--<div class="col-md-6 callback" id="callback-link" style="display: none">--}}
{{--<button><span onClick="a_onClick()" data-link="" data-id="" data-orderId="" id="callback-button">انتقال به لینک دریافت شده</span>--}}
{{--</button>--}}

{{--</div>--}}
{{--<div class="col-md-6">--}}

{{--</div>--}}
{{--</div>--}}


{{--@elseif(isset($activity) && is_object($activity))--}}

{{--@foreach($activity as $key=>$val)--}}
{{--@if($val->step=='create')--}}

{{--<div class="row">--}}
{{--<div class="title"><h3>ایجاد تراکنش</h3></div>--}}
{{--<div class="col-md-6">--}}
{{--<div id="form" class="row">--}}

{{--<div class=" row col-md-12">--}}
{{--{{ Form::label('APIKEY', 'APIKEY', ['class' => 'col-md-3']) }}--}}

{{--{{ Form::text('APIKEY',$order->API_KEY,['readonly','class' => ' col-md-5']) }}--}}
{{--</div>--}}
{{--<div class=" row col-md-12">--}}
{{--{{ Form::label('Sandbox', 'آزمایشگاه', ['class' => 'col-md-3']) }}--}}
{{--@if($order->sandbox==1)--}}
{{--<input name="sandbox" type="checkbox" checked>--}}

{{--@else--}}
{{--<input name="sandbox" type="checkbox">--}}

{{--@endif--}}
{{--</div>--}}
{{--<div class="row col-md-12">--}}
{{--{{ Form::label('Name', 'نام', ['class' => 'col-md-3']) }}--}}
{{--{{ Form::text('name',$order->name,['readonly','class' => ' col-md-5']) }}--}}

{{--</div>--}}
{{--<div class="row col-md-12">--}}
{{--{{ Form::label('Phone', 'تلفن', ['class' => 'col-md-3']) }}--}}
{{--{{ Form::text('phone',$order->phone,['readonly','class' => ' col-md-5']) }}--}}

{{--</div>--}}

{{--<div class="row col-md-12">--}}
{{--{{ Form::label('Mail', 'ایمیل', ['class' => 'col-md-3']) }}--}}
{{--{{ Form::text('mail',$order->mail,['readonly','class' => ' col-md-5']) }}--}}

{{--</div>--}}
{{--<div class="row col-md-12">--}}
{{--{{ Form::label('Amount', 'قیمت', ['class' => 'col-md-3']) }}--}}
{{--{{ Form::text('amount',$order->amount,['readonly','class' => ' col-md-5']) }}--}}

{{--</div>--}}
{{--<div class="row col-md-12">--}}
{{--{{ Form::label('Reseller', 'کد نمایندگی', ['class' => 'col-md-3']) }}--}}
{{--{{ Form::text('reseller',$order->reseller,['readonly','class' => ' col-md-5']) }}--}}

{{--</div>--}}
{{--<button disabled="true" onclick="payment_new()" readonly="readonly">Payment</button>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="col-md-6 " id="create">--}}
{{--<lable>درخواست</lable>--}}

{{--<textarea class="result" id="request-create" style="direction: ltr">--}}

{{--</textarea>--}}
{{--<script>--}}
{{--var r =@php echo $val->request @endphp;--}}
{{--var textedJson = JSON.stringify(r, undefined, 4);--}}
{{--$('#request-create').text(textedJson);--}}
{{--</script>--}}

{{--<lable>پاسخ</lable>--}}
{{--<textarea id="response-create" style="direction: ltr">--}}

{{--</textarea>--}}
{{--<script>--}}
{{--var r =@php echo $val->response @endphp;--}}
{{--var textedJson = JSON.stringify(r, undefined, 4);--}}
{{--$('#response-create').text(textedJson);--}}
{{--</script>--}}
{{--</div>--}}
{{--</div>--}}
{{--@endif--}}
{{--@if($val->step=='redirect')--}}

{{--<div class="row">--}}

{{--<div class="title"><h3>انتقال به درگاه</h3></div>--}}
{{--<div class="col-md-6 callback">--}}
{{--<button disabled>انتقال به لینک دریافت شده</button>--}}

{{--</div>--}}
{{--<div class="col-md-6">--}}
{{--<lable>Callback</lable>--}}
{{--<textarea id="request-callback">--}}
{{--</textarea>--}}
{{--<script>--}}
{{--var r =@php echo $val->request @endphp;--}}
{{--var textedJson = JSON.stringify(r, undefined, 4);--}}
{{--$('#request-callback').text(textedJson);--}}
{{--</script>--}}
{{--</div>--}}
{{--</div>--}}
{{--@endif--}}

{{--@if($val->step=='return')--}}
{{--<div class="row">--}}
{{--<div class="title"><h3>بازگشت از از درگاه</h3></div>--}}

{{--<div class="col-md-6">return</div>--}}
{{--<div class="col-md-6">--}}
{{--{{ Form::label('مقدار بازگشتی از درگاه', 'مقدار بازگشتی از درگاه') }}--}}
{{--@php $response=json_decode($val->response,JSON_PRETTY_PRINT) @endphp--}}
{{--<div style="direction: ltr">--}}
{{--<textarea id="response-return">@php print_r($response) @endphp </textarea>--}}

{{--<script>--}}
{{--var r =@php echo $val->response @endphp;--}}
{{--var textedJson = JSON.stringify(r, undefined, 4);--}}
{{--$('#response-return').text(textedJson);--}}
{{--</script>--}}

{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--@if(sizeof($activity)==3)--}}
{{--<div class="row">--}}
{{--<div class="title"><h3>تایید تراکنش</h3></div>--}}
{{--<div class="col-md-6">--}}
{{--@php $response=json_decode($val->response) @endphp--}}
{{--@if($response->status==10)--}}
{{--<div id="verifyButton">--}}
{{--<button onclick="verify('{{$response->id}}','{{$response->order_id}}')">--}}
{{--تایید پرداخت--}}
{{--</button>--}}
{{--</div>--}}

{{--@else--}}
{{--@if(isset($response->status))){{$response->status}}--}}
{{--@endif--}}
{{--@endif--}}
{{--</div>--}}

{{--<div class="col-md-6" id="verify">--}}

{{--@if($val->step=='verify')--}}

{{--@endif--}}
{{--</div>--}}
{{--@endif--}}

{{--@endif--}}
{{--@if($val->step=='verify')--}}
{{--<div class="row">--}}
{{--<div class="title"><h3>تایید تراکنش</h3></div>--}}
{{--<div class="col-md-6">--}}
{{--<button>تایید پرداخت</button>--}}

{{--</div>--}}
{{--<div class="col-md-6" id="verify">--}}
{{--{{ Form::label('درخواست', 'درخواست', ['class' => 'col-md-3']) }}--}}
{{--<textarea id="request-verify"> </textarea>--}}
{{--<script>--}}
{{--var r =@php echo $val->request @endphp;--}}
{{--var textedJson = JSON.stringify(r, undefined, 4);--}}
{{--$('#request-verify').text(textedJson);--}}
{{--</script>--}}


{{--{{ Form::label('پاسخ', 'پاسخ', ['class' => 'col-md-3']) }}--}}

{{--<textarea id="response-verify"></textarea>--}}
{{--<script>--}}
{{--var r =@php echo $val->response @endphp;--}}
{{--var textedJson = JSON.stringify(r, undefined, 4);--}}
{{--$('#response-verify').text(textedJson);--}}
{{--</script>--}}
{{--</div>--}}
{{--@endif--}}

{{--@endforeach--}}
{{--@endif--}}

{{--@endsection--}}
{{--@section('footer')--}}

{{--<script>--}}

{{--$(document).ready(function () {--}}
{{--// document is loaded and DOM is ready--}}
{{--alert("document is ready");--}}
{{--});--}}

{{--function a_onClick() {--}}
{{--link = ($('#callback-button').attr('data-link'));--}}
{{--order_id = ($('#callback-button').attr('data-orderId'));--}}
{{--id = ($('callback-button').attr('data-id'));--}}
{{--$.ajaxSetup({--}}
{{--headers: {--}}
{{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--}--}}
{{--});--}}
{{--$.ajax({--}}
{{--method: "post",--}}
{{--url: "{{ route('store_callback') }}",--}}
{{--data: {--}}
{{--link: link,--}}
{{--order_id: order_id,--}}
{{--id: id--}}
{{--},--}}
{{--success: function (responce) {--}}
{{--$("#loader").hide();--}}

{{--window.location.replace(link);--}}

{{--},--}}
{{--beforeSend: function () {--}}
{{--// Show image container--}}
{{--$("#loader").show();--}}
{{--},--}}
{{--})--}}

{{--}--}}

{{--function payment_new() {--}}


{{--var inputs = $('#form :input');--}}
{{--var values = {};--}}
{{--inputs.each(function () {--}}

{{--values[this.name] = $(this).val();--}}
{{--});--}}
{{--if ($('#sandbox').is(':checked')) {--}}

{{--values['sandbox'] = 1;--}}
{{--} else {--}}
{{--values['sandbox'] = 0;--}}
{{--}--}}
{{--$.ajaxSetup({--}}
{{--headers: {--}}
{{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--}--}}
{{--});--}}
{{--$.ajax({--}}
{{--method: "post",--}}
{{--url: "{{ route('store') }}",--}}
{{--data: {values},--}}
{{--success: function (response) {--}}
{{--$("#loader").hide();--}}

{{--$('#create').show();--}}


{{--var request = response.request;--}}
{{--var _response = response.response;--}}


{{--var textedJson = JSON.stringify(request, undefined, 4);--}}
{{--$('#request-create').text(textedJson);--}}


{{--var textedJson = JSON.stringify(_response, undefined, 4);--}}
{{--$('#response-create').text(textedJson);--}}

{{--$('#callback-link').show();--}}
{{--$('#callback-button').attr('data-id', _response.id);--}}
{{--$('#callback-button').attr('data-link', _response.link);--}}
{{--$('#callback-button').attr('data-orderid', response.order_id);--}}

{{--},--}}
{{--beforeSend: function () {--}}
{{--// Show image container--}}
{{--$("#loader").show();--}}
{{--},--}}
{{--})--}}
{{--}--}}

{{--function verify(id, order_id) {--}}
{{--$.ajaxSetup({--}}
{{--headers: {--}}
{{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--}--}}
{{--});--}}
{{--$.ajax({--}}
{{--method: "POST",--}}
{{--url: "{{route('verify')}}",--}}
{{--data: {--}}
{{--id: id,--}}
{{--order_id: order_id--}}
{{--},--}}
{{--success: function (response) {--}}
{{--$('#loader').hide();--}}
{{--$('#verifyButton').html('<button>تایید پرداخت</button>');--}}
{{--var request = response.request;--}}
{{--var _response = response.response;--}}


{{--var textedJsonRequest = JSON.stringify(request, undefined, 4);--}}


{{--var textedJsonResponse = JSON.stringify(_response, undefined, 4);--}}
{{--var output = '<lable class="col-md-3">درخواست</lable>\n' +--}}
{{--'                <textarea id="request-verifyl" style="direction: ltr">' + textedJsonRequest + '</textarea>\n' +--}}
{{--'                <lable class="col-md-3">پاسخ</lable>\n' +--}}
{{--'                <textarea id="response-verify" style="direction: ltr">' + textedJsonResponse + '</textarea>';--}}
{{--$('#verify').html(output)--}}
{{--}, beforeSend: function () {--}}
{{--// Show image container--}}
{{--$("#loader").show();--}}
{{--},--}}
{{--})--}}

{{--}--}}

{{--</script>--}}
{{--@endsection--}}
