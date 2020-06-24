{{--<pre id="GFG_DOWN" style="color:green; font-size: 10px; font-weight: bold;"></pre>--}}
<pre id="CALLBACKRESULT" style="color:green; font-size: 10px; font-weight: bold;"></pre>

<script>
    var el_up = document.getElementById("GFG_UP");
    var el_down2 = document.getElementById("CALLBACKRESULT");

    var obj2 =@php echo $callbackResult->response @endphp;
    el_down2.innerHTML = JSON.stringify(obj2, undefined, 4);

</script>


