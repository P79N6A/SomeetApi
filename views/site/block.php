<div class="errorDiv"><p>> <span>ERROR CODE</span>: "<i>HTTP STATUS ERROR</i>"</p>
<p>> <span>ERROR DESCRIPTION</span>: "<i>用户状态异常</i>"</p>
<p>> <span>ERROR POSSIBLY CAUSED BY</span>: [<b><?php echo isset($error_msg) && $error_msg?$error_msg:'您可能处于黑名单或者封禁状态，如有疑问，请联系客服';?></b>...]</p>
<p>> <span>SOME PAGES ON THIS SERVER THAT YOU DO HAVE PERMISSION TO ACCESS</span>: [<a href="/site/login" style='color:red;'>点此返回</a>]</p><p>> <span>HAVE A NICE DAY SIR AXLEROD :-)</span></p>
</div>
<script type="text/javascript">
	var str = document.getElementsByTagName('div')[0].innerHTML.toString();
	var i = 0;
	document.getElementsByTagName('div')[0].innerHTML = "";

	setTimeout(function() {
	    var se = setInterval(function() {
	        i++;
	        document.getElementsByTagName('div')[0].innerHTML = str.slice(0, i) + "|";
	        if (i == str.length) {
	            clearInterval(se);
	            document.getElementsByTagName('div')[0].innerHTML = str;
	        }
	    }, 5);
	},0);

</script>
