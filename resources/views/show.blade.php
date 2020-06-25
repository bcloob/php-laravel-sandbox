@extends('layouts.master')





@section('content')




    <div class="row">
        <blockquote class="blockquote text-center titleAction">
            <p class="mb-0">ایجاد تراکنش</p>
            <footer class="blockquote-footer"><cite title="Source Title">برای ایجاد تراکنش باید مقادیر زیر را کامل
                    کنید.</cite></footer>
        </blockquote>


        <div class="col-lg-6">


            <form class="form-horizontal" action="{{route('store')}}" id="snedPaymentApi" method="post"
                  data-content="snedPaymentApiButton" data-value="transferToGetWay">

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
                        <button type="submit"  id="snedPaymentApiButton" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>


        </div>

        <div class="col-lg-6" id="paymentResult">

            {!! $paymentAnswerHtml !!}

        </div>


    </div>






    <div class="row" hidden id="transferToGetWay">
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
            <div id="msg" class="en" style="display: none">Redirect to {{env('Call_Back_URL')}}</div>


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
            var submitButton = form.attr('data-content')
            var rowDisable = form.attr('data-value')

            $("#" + submitButton).attr("disabled", true);

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

                    if (result.status == 'OK') {

                        jQuery('#titleTranserToGetway').show();
                        jQuery('#paymentResult').html(result.paymentAnswer);
                        jQuery('#transferToPort').html(result.transferToPort);
                        $("#" + submitButton).attr("disabled", true);
                        $("#" + rowDisable).attr("hidden", false);


                    } else if (result.status == 'ERROR') {
                        jQuery('#paymentResult').html(result.paymentAnswer);
                        $("#" + submitButton).attr("disabled", false);


                    }


                },
                error: function (error) {
                    console.log(error);
                }
            });
        });


    </script>

@endsection

