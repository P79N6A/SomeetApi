<div class="space-div">
	<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
		<legend>分类详情</legend>
	</fieldset>

	<fieldset class="layui-elem-field">
		<legend style="color:red;">修改/添加分类</legend>
		<div class="layui-field-box">
			<form id='spaceForm' lay-filter='spaceForm' class="layui-form" action="/">
				<div>
					<div class="layui-form-item">
					    <label class="layui-form-label">分类名称</label>
					    <div class="layui-input-block">
					      <input type="text" name="name" id='name' autocomplete="off" placeholder="请输入名称" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">选择父类</label>
					    <div class="layui-input-block">
					      <select name="city" lay-verify="required">
					        <option value=""></option>
					        <option value="0">北京</option>
					        <option value="1">上海</option>
					        <option value="2">广州</option>
					        <option value="3">深圳</option>
					        <option value="4">杭州</option>
					      </select>
					    </div>
				  	</div>
				  	<div class="layui-form-item">
				  		<label class="layui-form-label">分类图片</label>
					  	<div class="layui-input-inline layui-btn-container" style="display: flex;">
			                <div>
			                	<img src="http://backend.someet.cc/static/image/wechat.jpg" class="classify-img">
			                	<div style="" class="uploadButton layui-btn classify-btn" data-type='share_img'>上传分享图片</div>
			                </div>
			                <div>
			                	<img src="http://backend.someet.cc/static/image/wechat.jpg" class="classify-img">
			                	<div style="" class="uploadButton layui-btn classify-btn" data-type='type_img'>上传专题图片</div>
			                </div>
			                <div>
			                	<img src="http://backend.someet.cc/static/image/wechat.jpg" class="classify-img">
			                	<div style="" class="uploadButton layui-btn classify-btn" data-type='icon_img'>上传icon图片</div>
			                </div>
			            </div>
			        </div>
			        <div class="layui-form-item">
					    <label class="layui-form-label">分享标题</label>
					    <div class="layui-input-block">
					      <input type="text" id='address' name="address" autocomplete="off" placeholder="请输入分享标题" class="layui-input">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">分享文案</label>
					    <div class="layui-input-block">
					      <input type="text" id='address' name="address" autocomplete="off" placeholder="请输入信息" class="layui-input">
					    </div>
					</div>
					<input type="hidden" id='classify_id' value="<?php echo $id;?>" name="id">
				</div>
			</form>
		</div>
	</fieldset>
</div>
<script type="text/javascript" src='/layui/js/modules/cropper.js'></script>
<script type="text/javascript">
	var form = layui.form; 
	form.render();
	//图片上传
	layui.config({
	    base: '/layui/js/' //layui自定义layui组件目录
	}).use(['form','croppers'], function () {
	    var $ = layui.jquery
	        ,form = layui.form
	        ,croppers = layui.croppers
	        ,layer= layui.layer;

	    //创建一个头像上传组件
	    croppers.render({
	         elem: '.uploadButton'
	        ,saveW:150     //保存宽度
	        ,saveH:150
	        ,mark:1/1    //选取比例
	        ,area:'900px'  //弹窗宽度
	        ,url: "/back/upload/upload-image"  //图片上传接口返回和（layui 的upload 模块）返回的JOSN一样
	        ,done: function(url,type){ //上传完毕回调
	        	if(type=='jiabin'){
	        		$('#jheadimgurl').val(url)
	            	$("#headimgurl").attr('src',url);
	        	}else if(type == 'poster'){
	        		$("#poster").val(url);
	        	}else if(type == 'group_code'){
	        		$('#group_code').val(url);
	        	}
	            
	        },
	        extEle:''
	    });
	});
</script>
