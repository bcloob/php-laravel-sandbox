<form class="form-horizontal" action="{{route('payment',['id'=>$order_id])}}" id="transferToPortRequest">


    <input type="hidden" name="link" value="{{$link}}">
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </div>
</form>


<script>
    $(document).on('submit', '#transferToPortRequest', function (e) {

        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');


        var timing;
        var myTimer;

        begin()


        function begin() {
            timing = 3;
            $('#timing').html('درحال انتقال به درگاه ' + timing);
            // $('#begin').prop('disabled', true);
            myTimer = setInterval(function () {
                --timing;
                $('#timing').html('درحال انتقال به درگاه ' + timing);
                if (timing === 0) {
                    // alert('Too late! Try again');
                    clearInterval(myTimer);



                    //
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

                            window.location.replace(result);

                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });


                }
            }, 1000);
        }

    });


</script>



