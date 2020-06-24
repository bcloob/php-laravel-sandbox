<pre id="GFG_DOWN" style="color:green; font-size: 10px; font-weight: bold;"></pre>
<pre id="GFG_DOWN2" style="color:green; font-size: 10px; font-weight: bold;"></pre>

<script>
    var el_up = document.getElementById("GFG_UP");
    var el_down = document.getElementById("GFG_DOWN");
    var el_down2 = document.getElementById("GFG_DOWN2");

    var obj =@php echo $activity['data']['request'] @endphp;
    var obj2 =@php echo $activity['data']['response'] @endphp;


        el_down.innerHTML = JSON.stringify(obj, undefined, 4);
        el_down2.innerHTML = JSON.stringify(obj2, undefined, 4);

</script>


