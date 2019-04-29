<div class="view-detail">
	<form lay-filter='useridcard' class="layui-form" action='/'>
		<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;color:red;">
		  <legend>验证审核身份</legend>
		</fieldset>
		<ul class="layui-timeline">
			<li class="layui-timeline-item">
				<i class="layui-icon layui-timeline-axis"></i>
				<div class="layui-timeline-content layui-text">
					<h3 class="layui-timeline-title">真实姓名</h3>
					<div style="margin-left: 1.5rem;">
				      <input type="text" name="real_name"  autocomplete="off" placeholder="请输入真实姓名" class="layui-input">
				    </div>
				</div>
			</li>
			<li class="layui-timeline-item">
				<i class="layui-icon layui-timeline-axis"></i>
				<div class="layui-timeline-content layui-text">
					<h3 class="layui-timeline-title">身份证号码</h3>
					<div style="margin-left: 1.5rem;">
				      <input type="text" name="idcard" autocomplete="off" placeholder="请输入身份证号码" class="layui-input">
				    </div>
				</div>
			</li>
			<li class="layui-timeline-item">
				<i class="layui-icon layui-timeline-axis"></i>
				<div class="layui-timeline-content layui-text">
					<h3 class="layui-timeline-title">上传身份证正反面照</h3>
					<div class="useridcard-upload">
						<div>
							<img class="startUpload" src="http://img.someet.cc/Fh8n2ij-_xq4D7HUPyHIFfy629F7" width="100%">
							<input type="hidden" value="" name="idcard_A" class='idcard_AB'>
						</div>
						<div>
							<img class="startUpload" src="http://img.someet.cc/Fh8n2ij-_xq4D7HUPyHIFfy629F7" width="100%">
							<input type="hidden" value="" name="idcard_B" class='idcard_AB'>
						</div>
					</div>
				</div>
			</li>
		</ul>
		<div class="view-detail-button">
			<button lay-submit class="layui-btn layui-btn-lg" lay-filter='subIDcard'>保存</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	var $=layui.jquery;
	var token = $('#access_token').val();
	$.ajaxSettings.beforeSend = function(xhr,request){
	    xhr.setRequestHeader('Authorization','Bearer '+token);
	}
	var form = layui.form
	form.render();
	//上传活动图片
	var upload = layui.upload;
	//执行实例
	var imgIndex = 0;
	var files;
	var isSub = 0;
	//存储上传活动图片的地
	var uploadInst = upload.render({
		elem: '.startUpload' //绑定元素
		,multiple: true
		,size:500
		,number:9
		,auto:true
		,drag:true
		,acceptMime: 'image/*'
		,url: '/back/upload/upload-file' //上传接口
		,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
		    layer.load(); //上传loading
		}
		,choose: function(obj){
			//将每次选择的文件追加到文件队列
			files = obj.pushFile();
			//预读本地文件，如果是多文件，则会遍历。(不支持ie8/9)
			obj.preview(function(index, file, result){
				if(file.size > 2000*1000){
					layer.msg('文件大小不得超过2M', {icon: 2}); 
					delete files[index];
				}else if(imgIndex >1){
					layer.msg('最多上传1张图片', {icon: 2}); 
					return false;
				}else{
					$('.startUpload')[imgIndex].src=result
					
				}
			});
		}
		,done: function(res,index, upload){
			//上传完毕回调
			console.log(imgIndex)
			var url = res.data.url;
			if(imgIndex == 0) $('input[name=idcard_A]').val(url);
			if(imgIndex == 1) $('input[name=idcard_B]').val(url);
			delete files[index];
			imgIndex++;
			layer.closeAll('loading');
		}
		,error: function(){
			//请求异常回调
		}
	});
	form.on('submit(subIDcard)', function(data){
		console.log(data.field)
		if(isSub == 0){
			if(!data.field.real_name){
				layer.msg('填写真实姓名')
				return false
			}
			if(!data.field.idcard){
				layer.msg('填写身份证号码')
				return false
			}
			if(!data.field.idcard_A || !data.field.idcard_B){
				layer.msg('上传身份证照片')
				return false
			}
			isSub == 1;
			$.ajax({
				url:'/back/member/founder-check',
				type:'post',
				data:data.field,
				success:function(res){
					console.log(res)
					if(res.data.status == 1){
						layer.msg('已提交审核，请等待')
						setTimeOut(function(){
							window.location.href = '/founder/index'
						},2000)
					}
					// window.location.href = '/activity/index'
				},
				error:function(){
					isSub == 0;
					console.log('error')
				}
			})
		}
		
		return false;
	});
</script>