<div class="space-div">
	<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
		<legend>分类详情</legend>
	</fieldset>

	<fieldset class="layui-elem-field">
		<legend style="color:red;">修改/添加分类</legend>
		<div class="layui-field-box">
			<form id='spaceForm' lay-filter='spaceForm' class="layui-form" action="/">
				<input type="hidden" id='id' value="<?php echo $id;?>">
				<div>
					<div class="layui-form-item">
					    <label class="layui-form-label">分类名称</label>
					    <div class="layui-input-block">
					      <input type="text" name="name" lay-verify="required" id='name' autocomplete="off" value="<?php echo isset($c->name)?$c->name:'';?>" placeholder="请输入名称" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">选择父类</label>
					    <div class="layui-input-block">
					      <select name="pid" id='parentTop' lay-verify="required">
					        <option value="<?php echo $p->id;?>"><?php echo $p->name;?></option>
					      </select>
					    </div>
				  	</div>
				  	<div class="layui-form-item">
				  		<label class="layui-form-label">分类图片</label>
					  	<div class="layui-input-inline layui-btn-container" style="display: flex;">
			                <div>
			                	<img src="<?php echo isset($c->image)?$c->image:'http://backend.someet.cc/static/image/wechat.jpg';?>" id='image' class="classify-img">
			                	<div style="" class="uploadButton layui-btn classify-btn"  data-type='image'>上传分享图片</div>
			                	<input type="hidden" name='image' id='image_input' value="<?php echo isset($c->image)?$c->image:'';?>">
			                </div>
			            </div>
			        </div>
			        <div class="layui-form-item">
					    <label class="layui-form-label">标题</label>
					    <div class="layui-input-block">
					      <input type="text" id='address' name="name" autocomplete="off" placeholder="请输入分享标题" value="<?php echo isset($c->name)?$c->name:'';?>" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">英文标题</label>
					    <div class="layui-input-block">
					      <input type="text" id='english_name' value="<?php echo isset($c->english_name)?$c->english_name:'';?>" name="english_name" autocomplete="off" placeholder="请输入信息" class="layui-input">
					    </div>
					</div>
					<input type="hidden" id='classify_id' value="<?php echo $id;?>" name="id">
				</div>
				<br>
				<div>
					<div class="layui-form-item">
						<label class="layui-form-label"> </label>
						<div class="layui-inline">
							<button lay-filter='classifyForm' lay-submit class="layui-btn layui-btn-lg">提交</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</fieldset>
</div>
<script type="text/javascript" src='/layui/js/modules/cropper.js'></script>
<script type="text/javascript">
	var $ = layui.$
	var form = layui.form; 
	var id = $('#id').val();
	form.render();
	//上传活动图片
	var upload = layui.upload;
	//执行实例
	var files;
	var isSub = 0;
	//存储上传活动图片的地址
	var actImg = [];
	var uploadInst = upload.render({
		elem: '.uploadButton' //绑定元素
		,size:200
		,number:1
		,auto:true
		,acceptMime: 'image/*'
		,url: '/back/upload/upload-file' //上传接口
		,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
		    layer.load(); //上传loading
		}
		,done: function(res,index, upload){
			//上传完毕回调
			console.log(res)
			var url = res.data.url;
			var item = this.item;
			var type = item.context.dataset.type;
			$('#'+type+'_input').val(url);
			$('#'+type).attr('src',url);
			layer.closeAll('loading');
		}
		,error: function(){
			//请求异常回调
		}
	});
	//监听提交
	var token = $('#access_token').val();
	$.ajaxSettings.beforeSend = function(xhr,request){
	    xhr.setRequestHeader('Authorization','Bearer '+token);
	}
	if(id == 0){
		//获取父类id
		$.ajax({
			url:'/back/classify/get-top',
			type:'get',
			success:function(res){
				var str ='';
				if(res.data == 'error') return false;
				$.each(res.data,function(index,val){
					str+='<option value="'+val.id+'">'+val.name+'</option>'
				})
				$('#parentTop').append(str)
				form.render('select');
			},
			error:function(){
				console.log('error')
			}
		})
	}
	form.on('submit(classifyForm)', function(data){
		console.log(data.field)
		if(isSub == 0){
			isSub = 1;
			$.ajax({
				url:'/back/classify/create-sub',
				type:'post',
				data:data.field,
				success:function(res){
					console.log(res)
					window.location.href = '/classify/index'
				},
				error:function(){
					isSub = 0;
					console.log('error')
				}
			})
		}
		
		return false;
	});
</script>
