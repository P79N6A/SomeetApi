<div id='msg'>
	<div class='msg'>
		1.呵呵呵呵呵
	</div>
	<div class='msg'>
		2.嘿嘿额嘿嘿额
	</div>
</div>
<input type="text" name="" id='myMsg'>
<button id='send'>发送</button>
</body>
<script type="text/javascript" src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
<script type="text/javascript">
var wsServer = 'ws://192.168.99.100:9501';
var websocket = new WebSocket(wsServer);
websocket.onopen = function (evt) {
    console.log("Connected to WebSocket server.");
};
websocket.onclose = function (evt) {
    console.log("Disconnected");
};

websocket.onmessage = function (evt) {
    console.log('Retrieved data from server: ' + evt.data);
    $('#msg').append("<div class='msg'>"+evt.data+"</div>");
};

websocket.onerror = function (evt, e) {
    console.log('Error occured: ' + evt.data);
};
$('#send').click(function(){
	var myMsg = $('#myMsg').val();
	if(!myMsg){
		alert('不能发送空信息')
		return false;
	}
	websocket.send(myMsg)
	// $('#msg').append("<div class='msg'>"+myMsg+"</div>");
	$('#myMsg').val('')
	console.log('发送完毕');
})
</script>