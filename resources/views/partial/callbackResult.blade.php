<blockquote class="blockquote text-center titleAction">
    <p class="mb-0">بازگشت از درگاه</p>
    <footer class="blockquote-footer"><cite title="Source Title">
        </cite></footer>
</blockquote>

<br>
<br>

<div class="col-lg-6" id="callbackResult">

    پرداخت کننده از  درگاه به آدرس
    <br>
    url:
    {{$url}}

    منتقل شد. اطلاعات روبرو دریافت شد
</div>

<div class="col-lg-6" id="callbackResult">
    {{--@php print_r($callbackResult,true) @endphp--}}

    @php
        echo '<pre>',print_r($callbackResult,1),'</pre>';
    @endphp


    {{--<script>--}}
    {{--// var el_up = document.getElementById("GFG_UP");--}}
    {{--// var el_down2 = document.getElementById("CALLBACKRESULT");--}}

    {{--var obj2 =@php echo $callbackResult @endphp;--}}

    {{--document.getElementById("CALLBACKRESULT").innerHTML = JSON.stringify(obj2, null, 4);--}}

    {{--el_down2.innerHTML = JSON.stringify(obj2, undefined, 4);--}}

    {{--</script>--}}


</div>










