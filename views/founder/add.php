<div class="site-demo-title">
	<form class="layui-form" action="/">
		<div>
			<!-- dts开始 -->
			<div class="layui-form-item">
			   	<!-- //获取上一场活动的dts -->
			   	<input type="hidden" name='updated_by' value="2961">
			    <div class="layui-inline">
			      <label class="layui-form-label">活动类型:</label>
			      <div class="layui-input-inline">
			        <select name="pma_type" lay-verify="required" lay-search="">
			          <option value="1">线上</option>
			          <option value="2">线下</option>
			        </select>
			      </div>
			    </div>
			</div>
			<!-- dts结束 -->
		</div>
		<!-- 发起人开始 -->
		<div>
			<input type="hidden" name="created_by" id='founder_id' value="<?php echo $data['user_id'];?>">
		</div>
		<!-- 发起人结束 -->
		<!-- 联合发起人开始 -->
		<div>
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">联合发起人:</label>
			      <div class="layui-input-block">
				      <input type="text" name="co_founder1"  lay-verify="title" autocomplete="off" placeholder="请输入联合发起人" class="layui-input" style='max-width: 10rem;'>
				  </div>
			    </div>
			</div>
		</div>
		<!-- 联合发起人结束 -->
		<!-- 添加活动嘉宾开始 -->
		<div class="layui-form-item">
		    <div class="layui-form-item" pane="">
			    <label class="layui-form-label"></label>
			    <div class="layui-input-block">
			      <input type="checkbox" name="haveGuest" id='haveGuestCheck' lay-filter='haveGuest' lay-skin="primary" title="添加活动嘉宾">
			    </div>
			    <div id="haveGuest" style="display: none;">
			    	<div class="layui-form-item">
					    <label class="layui-form-label">嘉宾昵称:</label>
					    <div class="layui-input-block">
					      <input type="text" name="field7[]" id='jname' autocomplete="off" placeholder="请输入嘉宾昵称" class="layui-input" style='max-width: 10rem;'>
					    </div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">嘉宾头像:</label>
						 <div class="layui-form-item">
	                        <label class="layui-form-label"></label>
	                        <div class="layui-input-inline">
	                            <div class="layui-upload-list" style="margin:0">
	                                <img src="" id="headimgurl" class="layui-upload-img">
	                            </div>
	                            <!-- 上传头像后需要给此隐藏输入框赋值----上传头像值 -->
	                            <input id='jheadimgurl' type="hidden" name="field7[]"  value=''>
	                            <br>
	                            <div class="layui-input-inline layui-btn-container">
		                            <div class="layui-btn layui-btn-primary uploadButton" data-type='jiabin' id="editimg">上传头像</div>
		                        </div>
	                        </div>
	                        <div class="layui-form-item layui-form-text">
							    <label class="layui-form-label">嘉宾介绍:</label>
							    <div class="layui-input-block">
							      <textarea id='jdesc' name="field7[]" placeholder="请输入内容" class="layui-textarea" name="desc"></textarea>
							    </div>
							</div>
	                        
	                    </div>
					</div>
			    </div>
			</div>
		</div>
		<!-- 添加活动嘉宾结束 -->
		<!-- 开始选择分类 -->
		<div>
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">一级分类:</label>
			      <div class="layui-input-inline">
			        <select name="type_id" lay-verify="required" lay-filter='parentType' lay-search="">
			          <option value="">选择一级分类</option>
			          <?php if($data['typelist']){foreach($data['typelist'] as $row){?>
				          <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
				      <?php }}?>
			        </select>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">二级分类:</label>
			      <div class="layui-input-inline">
			        <select name="tag_id" lay-verify="required" id='childType' lay-filter='childType' lay-search="">
			          <option value="">选择二级分类</option>
			        </select>
			      </div>
			    </div>
			</div>
		</div>
		<!-- 开始选择分类结束 -->
		<!-- 开始上传活动图片 -->
		<div>
			<label class="layui-form-label"></label>
			<div class="layui-upload-list" style="margin:0">
                <img src="" id="posterBox" class="layui-upload-img">
                <div class="layui-btn demoMore uploadButton" data-type='poster' id='posterUpload'>上传活动海报</div>
            </div>
			<input type="hidden" name="poster" id='poster' value="">
		</div>
		<br>
		<!-- 开始上传活动图片结束 -->
		<!-- 选择系列开始 -->
		<div>
			<div class="layui-form-item">
				<label class="layui-form-label">活动系列:</label>
				<div class="layui-input-block">
					<select name="sequence_id" id='sequence' lay-filter='sequence' lay-filter="aihao">
						<option value="">选择活动系列</option>
					</select>
				</div>
			</div>
		</div>
		<!-- 选择系列结束 -->
		<!-- 活动标题开始 -->
		<div>			  
		  	<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">标题:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="title" lay-verify="required" class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">副标题:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="desc" lay-verify="required" class="layui-input">
			      </div>
			    </div>
			</div>
		</div>
		<!-- 活动标题结束 -->
		<!-- 文案开始 -->
		<div>
			<div class="layui-form-item">
			    <label class="layui-form-label">文案:</label>
			    <div class="layui-input-block">
			      <input type="text" name="content" placeholder="输入活动文案" autocomplete="off" lay-verify="required" class="layui-input">
			    </div>
			</div>
		</div>
		<!-- 文案结束 -->
		<!-- 报名人数开始 -->
		<div>
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">报名名额:</label>
			      <div class="layui-input-inline">
			        <input type="number" name="peoples" value="0" lay-verify="required" class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">理想人数:</label>
			      <div class="layui-input-inline">
			        <input type="number" name="ideal_number" value="0" lay-verify="required" class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">人数上限:</label>
			      <div class="layui-input-inline">
			        <input type="number" name="ideal_number_limit" value="0" lay-verify="required" class="layui-input">
			      </div>
			    </div>
			</div>
		</div>
		<!-- 报名人数结束 -->
		<!-- 活动时间设置 -->
		<div>
			<div class="layui-inline">
		      <label class="layui-form-label">开始时间</label>
		      <div class="layui-input-inline">
		        <input type="text" lay-verify="required" class="layui-input" name='start_time' id="start_time" placeholder="yyyy-MM-dd HH:mm:ss">
		      </div>
		    </div>
		    <div class="layui-inline">
		      <label class="layui-form-label">结束时间</label>
		      <div class="layui-input-inline">
		        <input type="text" lay-verify="required" class="layui-input" name='end_time' id="end_time" placeholder="yyyy-MM-dd HH:mm:ss">
		      </div>
		    </div>
		</div>
		<!-- 活动时间设置结束 -->
		<!-- 活动场地开始 -->
		<div>
			<div class="haveAddress">
				<div class="layui-form-item">
				<label class="layui-form-label">选择场地</label>
				<div class="layui-input-block">
					<select name="space_spot_id" id='space_spot_id' lay-filter="address">
						<option value="">选择活动场地</option>
					</select>
				</div>
			</div>
			</div>
		</div>
		<!-- 活动场地结束 -->
		<!-- 收费金额 -->
		<div>
			<div class="layui-inline">
		      <label class="layui-form-label">活动费用:</label>
		      <div class="layui-input-inline">
		        <input type="number" name="cost" value="0" required class="layui-input">
		      </div>
		    </div>
		</div>
		<!-- 收费金额结束 -->
		<!-- 收费明细 -->
		<div>
			<div class="layui-form-item">
			    <label class="layui-form-label">收费明细:</label>
			    <div class="layui-input-block">
			      <input type="text" name="cost_list" placeholder="" autocomplete="off" class="layui-input">
			    </div>
			</div>
		</div>
		<!-- 收费明细结束 -->
		<!-- 活动详情开头 -->
		<div>
			<div class="layui-form-item">
				<label class="layui-form-label">开头详情:</label>
				<div class="layui-input-block">
					<br>
			    这是Someet活动发起人，发起的#       <input style="max-width: 15rem;" type="text" name="header_title" placeholder="" autocomplete="off" class="layui-input">        #活动
			    我期待遇见       <input style="max-width: 15rem;" type="text" name="header_people" placeholder="" autocomplete="off" class="layui-input">        的小伙伴！
			    </div>
			</div>
		</div>
		<!-- 活动性详情结束 -->
		<!-- 活动详情 -->
		<div>
			<label class="layui-form-label">活动详情:</label>
			<div class="layui-input-block">
				<textarea lay-verify="required" placeholder="请输入内容" class="layui-textarea" name="details"></textarea>
			</div>
			<div>
				<div class="layui-row actImgBoxDiv">
				    <div class="actImgBox grid-demo-bg1">
				    	<img src="" width="100%">
				    </div>
				    <div class="actImgBox grid-demo-bg1">
				    	<img src="" width="100%">
				    </div>
				    <div class="actImgBox grid-demo-bg1">
				    	<img src="" width="100%">
				    </div>
				    <div class="actImgBox grid-demo-bg1">
				    	<img src="" width="100%">
				    </div>
				    <div class="actImgBox grid-demo-bg1">
				    	<img src="" width="100%">
				    </div>
				    <div class="actImgBox grid-demo-bg1">
				    	<img src="" width="100%">
				    </div>
				    <div class="actImgBox grid-demo-bg1">
				    	<img src="" width="100%">
				    </div>
				    <div class="actImgBox grid-demo-bg1">
				    	<img src="" width="100%">
				    </div>
				    <div class="actImgBox grid-demo-bg1">
				    	<img src="" width="100%">
				    </div>
				</div>
			</div>
			<br>
			<div>
				<label class="layui-form-label"></label>
				<div type="button" class="layui-btn" id="actImg">
				  <i class="layui-icon">&#xe67c;</i>选择活动图片(可多选)
				</div>
				<div type="button" class="layui-btn" id="startUpload">
				  <i class="layui-icon">&#xe67c;</i>开始上传
				</div>
			</div>
		</div>
		<!-- 活动详情 -->
		<!-- 设置问题 -->
		<div class="layui-form-item">
		    <label class="layui-form-label">筛选问题</label>
		    <div class="layui-input-block" id='question'>
		      <input type="text" name="question[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input">
		    </div>
		    <br>
		    <div class="layui-inline">
		    	<label class="layui-form-label"> </label>
		    	<div  data-ele='question'  class="layui-btn addInput">增加筛选问题</div>
		    </div>
		</div>
		<!-- 设置问题 -->
		<!-- 活动流程 -->
		<div class="layui-form-item">
		    <label class="layui-form-label">活动流程</label>
		    <div class="layui-input-block" id='review'>
		      <input type="text" name="review[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input">
		    </div>
		    <br>
		    <div class="layui-inline">
		    	<label class="layui-form-label"> </label>
		    	<div  data-ele='review'  class="layui-btn addInput">增加活动流程</div>
		    </div>
		</div>
		<!-- 活动流程 -->
		<!-- 注意事项 -->
		<div class="layui-form-item">
		    <label class="layui-form-label">注意事项</label>
		    <div class="layui-input-block" id='field6'>
		      <input type="text" name="field6[]" autocomplete="off" placeholder="请输入注意事项" class="layui-input">
		    </div>
		    <br>
		    <div class="layui-inline">
		    	<label class="layui-form-label"> </label>
		    	<div data-ele='field6' class="layui-btn addInput">增加注意事项</div>
		    </div>
		</div>
		<!-- 注意事项 -->
		<!-- Tips -->
		<div class="layui-form-item">
		    <label class="layui-form-label">Tips</label>
		    <div class="layui-input-block" id='field2'>
		      <input type="text" name="field2[]" autocomplete="off" placeholder="请输入活动提示" class="layui-input">
		    </div>
		    <br>
		    <div class="layui-inline">
		    	<label class="layui-form-label"> </label>
		    	<div  data-ele='field2' class="layui-btn addInput">增加活动Tips</div>
		    </div>
		</div>
		<!-- tips -->
		<br>
		<br>
		<div>
			<div class="layui-form-item">
				<label class="layui-form-label"> </label>
				<div class="layui-inline">
					<button lay-filter='activityForm' lay-submit class="layui-btn layui-btn-lg">提交审核</button>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript" src='/layui/js/modules/cropper.js'></script>
<script type="text/javascript">
var form = layui.form; 
var dateHtml=layui.laydate;
//日期时间选择器
dateHtml.render({
	elem: '#start_time'
	,type: 'datetime'
});
dateHtml.render({
	elem: '#end_time'
	,type: 'datetime'
});
var $ = layui.$
var token = $('#access_token').val();
$.ajaxSettings.beforeSend = function(xhr,request){
    xhr.setRequestHeader('Authorization','Bearer '+token);
}
var _csrf = $('#_csrf').val();
//上传活动图片
var upload = layui.upload;
//执行实例
var imgIndex = 0;
var files;
var isSub = 0;
//存储上传活动图片的地址
var actImg = [];
var uploadInst = upload.render({
	elem: '#actImg' //绑定元素
	,multiple: true
	,size:500
	,number:9
	,auto:false
	,bindAction: '#startUpload'
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
			if(file.size > 500*1000){
				layer.msg('文件大小不得超过500kb', {icon: 2}); 
				delete files[index];
			}else if(imgIndex >8){
				layer.msg('最多上传9张图片', {icon: 2}); 
				return false;
			}else{
				$('.actImgBox img')[imgIndex].src=result
			}
		});
	}
	,done: function(res,index, upload){
		//上传完毕回调
		console.log(res)
		var url = res.data.url;
		actImg.push(url);
		delete files[index];
		layer.closeAll('loading');
		imgIndex++;
	}
	,error: function(){
		//请求异常回调
	}
});
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
        		$('#posterBox').attr('src',url);
        	}else if(type == 'group_code'){
        		$('#group_code').val(url);
        	}
            
        },
        extEle:''
    });
});
form.render();
//是否有活动嘉宾
form.on('checkbox(haveGuest)', function(data){
  if(data.elem.checked){
  	 $('#haveGuest').slideDown();
  }else{
  	$('#haveGuest').slideUp();
  }
});        

//分类选择框
form.on('select(parentType)', function(data){
  var pid = data.value;
  var data ={
  	data:{
  		id:pid
  	},
  	obj:'#childType',
  	type:'get',
  	url:'/back/activity/get-tag',
  	act:'typeAndTag'
  }
  httpRequest(data);
});
//监听发起人选择
form.on('select(founder)', function(data){
	var id = data.value;
	console.log(id)
	//请求该发起人的系列活动
	var data ={
		data:{
			user_id:id
	  	},
	  	obj:'#sequence',
	  	type:'get',
	  	url:'/back/activity/get-sequence',
  		act:'sequence'
	}
	httpRequest(data);  
});
//监听提交
form.on('submit(activityForm)', function(data){
	data.field.actImg = actImg;
	data.field._csrf = _csrf;
	if(!data.field.poster){
		layer.msg('请上传活动头图')
		return false;
	}
	console.log($('#haveGuestCheck').val())
	if(isSub == 0){
		isSub == 1;
		if($('#haveGuestCheck').val() == '1'){
			var jname = $('#jname').val()
			var jheadimgurl = $('#jheadimgurl').val();
			var jdesc = $('#jdesc').val()
			if(!jname || !jheadimgurl || !jdesc){
				layer.msg('选择了嘉宾就得填信息啊');
				return false;
			}
		}
		$.ajax({
			url:'/back/activity/create-act',
			type:'post',
			data:data.field,
			success:function(res){
				console.log(res)
				window.location.href = '/activity/index'
			},
			error:function(){
				isSub == 0;
				console.log('error')
			}
		})
	}
	
	return false;
});
//监听增加注意事项的事件
$('.addInput').click(function(){
	var ele = $(this).data('ele');
	var index = $('#'+ele).children('input').length;
	console.log(index)
	var str = '<input type="text" name="'+ele+'['+index+']" autocomplete="off" class="layui-input" placeholder="请输入文本内容">';
	$('#'+ele).append(str)
})
//获取发起人系列和场地
var founder_id = $('#founder_id').val();
var dataForXl ={
		data:{
			user_id:founder_id
	  	},
	  	obj:'#sequence',
	  	type:'get',
	  	url:'/back/activity/get-sequence',
		act:'sequence'
}
var dataForSpace ={
		data:{
			user_id:founder_id,
			type:'founder'
	  	},
	  	obj:'#space_spot_id',
	  	type:'get',
	  	url:'/back/space/get-space-list',
		act:'space'
}
//获取该发起人的系列名称
httpRequest(dataForXl);
//获取发起人的场地名称
httpRequest(dataForSpace);
function httpRequest(data){
	$.ajax({
		url:data.url,
		type:data.type,
		data:data.data,
		success:function(res){
			var str = '';
			$(data.obj).html(str)
			str = '';
			$.each(res.data,function(index,val){
				if(data.act == 'typeAndTag'){
					str+='<option value="'+val.id+'">'+val.name+'</option>'
				}else if(data.act == 'sequence'){
					str+='<option value="0">选择活动系列</option><option value="'+val.sequence_id+'">'+val.title+'</option>'
				}else if(data.act == 'founder'){

					if(index == 0){
						str+='<option selected="selected" value="'+val.id+'">'+val.username+'</option>'
						
					}else{
						str+='<option value="'+val.id+'">'+val.username+'</option>'
					}
					
				}else if(data.act == 'space'){
					str+='<option value="0">选择活动场地</option><option value="'+val.id+'">'+val.name+'</option>'
				}
				
			})
			
			$(data.obj).append(str)
			form.render('select');
			// form.render();
		},
		error:function(){
			layer.msg('抱歉，出错了', {icon: 2}); 
		}
	})
}     
</script>