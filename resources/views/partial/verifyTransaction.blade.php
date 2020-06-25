<blockquote class="blockquote text-center titleAction">
    <p class="mb-0">تایید تراکنش</p>
    <footer class="blockquote-footer"><cite title="Source Title">
        </cite></footer>
</blockquote>


<div class="col-lg-6">


    <form class="form-horizontal" action="{{route('verify',['id'=>$order_id])}}" id="verifyTransaction" method="post">

        @csrf
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">verify</button>
            </div>
        </div>
    </form>


</div>

<div class="col-lg-6" id="verifyResult">


    <pre id="verifyRequest" style="display:none; color:green; font-size: 10px; font-weight: bold;"></pre>

    <pre id="verifyResponse" style="display:none; color:green; font-size: 10px; font-weight: bold;"></pre>


    <script>


        $(document).on('submit', '#verifyTransaction', function (e) {


            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');


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


                    var el_up = document.getElementById("GFG_UP");
                    var verifyRequest = document.getElementById("verifyRequest");
                    var verifyResponse = document.getElementById("verifyResponse");
                    //
                    var obj = result.request;
                    var obj2 = result.response;

                    verifyRequest.innerHTML = JSON.stringify(obj, undefined, 4);
                    verifyResponse.innerHTML = JSON.stringify(obj2, undefined, 4);

                    $("#verifyRequest").show();
                    $("#verifyResponse").show();


                },
                error: function (error) {
                    console.log(error);
                }
            });
        });


    </script>


</div>