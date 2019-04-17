<div class="site-demo-title">
	<form class="layui-form" action="/">
		<div>
			<!-- dts开始 -->
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">DTS:</label>
			      <div class="layui-input-inline">
			        <select name="updated_by" lay-verify="required" lay-search="">
			          <option value="">选择DTS</option>
			          <?php if($data['xhb']){foreach($data['xhb'] as $row){?>
				          <option value="<?php echo $row['id'];?>"><?php echo $row['username'];?></option>
				      <?php }}?>
			        </select>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">PMA类型:</label>
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
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">发起人:</label>
			      <div class="layui-input-inline">
			        <select name="created_by" lay-verify="required" lay-filter='founder' id="founder" lay-search="">
			          <option value="">选择发起人</option>
			        </select>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">搜索发起人:</label>
			      <div class="layui-input-block">
				      <input type="text" id='searchFounderInput' autocomplete="off" placeholder="昵称,ID,手机号,微信ID" class="layui-input" style='max-width: 10rem;'>
				  </div>
			    </div>
			    <div class="layui-inline">
			    	<div class="layui-btn" id='searchFounder'>搜索</div>
			    </div>
			</div>
		</div>
		<!-- 发起人结束 -->
		<!-- 联合发起人开始 -->
		<div>
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">联合发起人:</label>
			      <div class="layui-input-block">
				      <input type="text"  lay-verify="title" autocomplete="off" placeholder="请输入联合发起人" class="layui-input" style='max-width: 10rem;'>
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
			      <input type="checkbox" name="haveGuest" lay-filter='haveGuest' lay-skin="primary" title="添加活动嘉宾">
			    </div>
			    <div id="haveGuest" style="display: none;">
			    	<div class="layui-form-item">
					    <label class="layui-form-label">嘉宾昵称:</label>
					    <div class="layui-input-block">
					      <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入嘉宾昵称" class="layui-input" style='max-width: 10rem;'>
					    </div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">嘉宾头像:</label>
						 <div class="layui-form-item">
	                        <label class="layui-form-label"></label>
	                        <div class="layui-input-inline">
	                            <div class="layui-upload-list" style="margin:0">
	                                <img src="http://img.someet.cc/FpyzpZ09e26yoFnwIy3LlYqwmVCk" id="srcimgurl" class="layui-upload-img">
	                            </div>
	                            <!-- 上传头像后需要给此隐藏输入框赋值----上传头像值 -->
	                            <input type="hidden" name="guestHead" id='guestHead' value=''>
	                            <br>
	                            <div class="layui-input-inline layui-btn-container">
		                            <div class="layui-btn layui-btn-primary uploadButton" data-type='jiabin' id="editimg">上传头像</div >
		                        </div>
	                        </div>
	                        <div class="layui-form-item layui-form-text">
							    <label class="layui-form-label">嘉宾介绍:</label>
							    <div class="layui-input-block">
							      <textarea placeholder="请输入内容" class="layui-textarea" name="desc"></textarea>
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
			        <select name="modules" lay-verify="required" lay-filter='parentType' lay-search="">
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
			        <select name="modules" lay-verify="required" id='childType' lay-filter='childType' lay-search="">
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
			<div class="layui-btn demoMore uploadButton" data-type='poster' id='posterUpload'>上传活动海报</div>
			<input type="hidden" name="poster" id='poster' value="">
			<!-- <div class="layui-btn demoMore uploadButton" data-type='group_code'  id='groupCodeUpload'>上传群二维码</div>
			<input type="hidden" name="group_code" id='group_code' value=""> -->
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
		<!-- 活动所属组 -->
		<!-- <div>
			<div class="layui-form-item">
				<label class="layui-form-label">活动组:</label>
				<div class="layui-input-block">
					<select name="interest" lay-filter="aihao">
						<option value="">选择活动组</option>
						<option value="0">写作</option>
						<option value="1">阅读</option>
						<option value="2">游戏</option>
						<option value="3">音乐</option>
						<option value="4">旅行</option>
					</select>
				</div>
			</div>
		</div> -->
		<!-- 活动所属组结束 -->
		<!-- 活动标题开始 -->
		<div>			  
		  	<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">标题:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="title" required class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">副标题:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="desc" required class="layui-input">
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
			      <input type="text" name="content" placeholder="输入活动文案" autocomplete="off" class="layui-input">
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
			        <input type="number" name="peoples" value="0" required class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">理想人数:</label>
			      <div class="layui-input-inline">
			        <input type="number" name="ideal_number" value="0" required class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">人数上限:</label>
			      <div class="layui-input-inline">
			        <input type="number" name="ideal_number_limit" value="0" required class="layui-input">
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
		        <input type="text" class="layui-input" name='start_time' id="start_time" placeholder="yyyy-MM-dd HH:mm:ss">
		      </div>
		    </div>
		    <div class="layui-inline">
		      <label class="layui-form-label">结束时间</label>
		      <div class="layui-input-inline">
		        <input type="text" class="layui-input" name='end_time' id="end_time" placeholder="yyyy-MM-dd HH:mm:ss">
		      </div>
		    </div>
		</div>
		<!-- 活动时间设置结束 -->
		<!-- 活动场地开始 -->
		<div>
			<div class="layui-form-item">
			    <label class="layui-form-label">选择场地</label>
			    <div class="layui-input-block">
			      <input type="radio" name="space_spot_id" lay-filter='address' checked="" value="1" title="有">
			      <input type="radio" name="space_spot_id" lay-filter='address' value="0" title="无">
			    </div>
			</div>
			<div class="haveAddress">
				<div class="layui-form-item">
				<label class="layui-form-label">选择场地</label>
				<div class="layui-input-block">
					<select name="address" lay-filter="address">
						<option value="">选择活动场地</option>
						<option value="0">写作</option>
						<option value="1">阅读</option>
						<option value="2">游戏</option>
						<option value="3">音乐</option>
						<option value="4">旅行</option>
					</select>
				</div>
			</div>
			</div>
			<div class="noAddress address">
				<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">商圈:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="area" class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">场地:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="address" class="layui-input">
			      </div>
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
				<textarea placeholder="请输入内容" class="layui-textarea" name="detail"></textarea>
			</div>
			<div>
				<label class="layui-form-label">1234</label>
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
				  <i class="layui-icon">&#xe67c;</i>上传活动图片
				</div>
				<input type="hidden" name="poster" id='poster' value="">
			</div>
		</div>
		<!-- 活动详情 -->
		<!-- 活动流程 -->
		<div class="layui-form-item">
		    <label class="layui-form-label">活动流程</label>
		    <div class="layui-input-block" id='review'>
		      <input type="text" name="review[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input">
		    </div>
		    <br>
		    <div class="layui-inline">
		    	<label class="layui-form-label"> </label>
		    	<div lay-filter='activityForm' data-ele='review'  class="layui-btn addInput">增加活动流程</div>
		    </div>
		</div>
		<!-- 活动流程 -->
		<!-- 注意事项 -->
		<div class="layui-form-item">
		    <label class="layui-form-label">注意事项</label>
		    <div class="layui-input-block" id='filed6'>
		      <input type="text" name="filed6[]" autocomplete="off" placeholder="请输入注意事项" class="layui-input">
		    </div>
		    <br>
		    <div class="layui-inline">
		    	<label class="layui-form-label"> </label>
		    	<div lay-filter='activityForm' data-ele='filed6' class="layui-btn addInput">增加注意事项</div>
		    </div>
		</div>
		<!-- 注意事项 -->
		<!-- Tips -->
		<div class="layui-form-item">
		    <label class="layui-form-label">Tips</label>
		    <div class="layui-input-block" id='filed2'>
		      <input type="text" name="filed2[]" autocomplete="off" placeholder="请输入活动提示" class="layui-input">
		    </div>
		    <br>
		    <div class="layui-inline">
		    	<label class="layui-form-label"> </label>
		    	<div lay-filter='activityForm' data-ele='filed2' class="layui-btn addInput">增加活动Tips</div>
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
var _csrf = $('#_csrf').val();
//上传活动图片
var upload = layui.upload;
//执行实例
var imgIndex = 0;
var uploadInst = upload.render({
	elem: '#actImg' //绑定元素
	,multiple: true
	,url: '/back/upload/upload-image' //上传接口
	,choose: function(obj){
		//将每次选择的文件追加到文件队列
		var files = obj.pushFile();
		//预读本地文件，如果是多文件，则会遍历。(不支持ie8/9)
		obj.preview(function(index, file, result){
			if(file.size > 500*1000){
				layer.msg('文件大小不得超过500kb', {icon: 2}); 
				delete files[index];
			}else{
				$('.actImgBox img')[imgIndex].src=result
				imgIndex++;
			}
			
			// console.log(index); //得到文件索引
			// console.log(file); //得到文件对象
			// console.log(result); //得到文件base64编码，比如图片
			//这里还可以做一些 append 文件列表 DOM 的操作

			//obj.upload(index, file); //对上传失败的单个文件重新上传，一般在某个事件中使用
			//delete files[index]; //删除列表中对应的文件，一般在某个事件中使用
		});
		console.log(files)
	}
	,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
	    // console.log(obj)
	}
	,done: function(res){
		//上传完毕回调
		console.log(res)
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
        		$('#guestHead').val(url);
            	$("#srcimgurl").attr('src',url);
        	}else if(type == 'poster'){
        		$("#poster").val(url);
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
//是否有活动场地
form.on('radio(address)', function(data){
	if(data.value == 1){
		$('.haveAddress').slideDown();
		$('.noAddress').slideUp();
	}else{
		$('.noAddress').slideDown();
		$('.haveAddress').slideUp();
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
//监听搜索发起人信息
$('#searchFounder').click(function(){
	var val = $('#searchFounderInput').val();
	var data ={
		  	data:{
		  		type:'founder',
				val:val
		  	},
		  	obj:'#founder',
		  	type:'get',
		  	url:'/back/member/get-user-search',
		  	act:'founder'
		  }
	httpRequest(data);  
})
//监听提交
form.on('submit(activityForm)', function(data){
	console.log(data.field)
	console.log(JSON.stringify(data.field))
	data.field.detail = layedit.getContent(detailIndex);
	return false;
});
//监听增加注意事项的事件
$('.addInput').click(function(){
	var ele = $(this).data('ele');
	var str = '<input type="text" name="'+ele+'[]" autocomplete="off" class="layui-input" placeholder="请输入文本内容">';
	$('#'+ele).append(str)
})
function httpRequest(data){
	$.ajax({
		url:data.url,
		type:data.type,
		data:data.data,
		success:function(res){
			// if(data.act == 'sequence'){
			// 	var str ='<option value="0">未找到系列</option>';
			// }else{
			// 	var str ='<option value="0">选择确认的选项</option>';
			// }
			var str = '';
			$(data.obj).html(str)
			str = '';
			$.each(res.data,function(index,val){
				if(data.act == 'typeAndTag'){
					str+='<option value="'+val.id+'">'+val.name+'</option>'
				}else if(data.act == 'sequence'){
					str+='<option value="'+val.sequence_id+'">'+val.title+'</option>'
				}else if(data.act == 'founder'){

					if(index == 0){
						str+='<option selected="selected" value="'+val.id+'">'+val.username+'</option>'
						var dataForXl ={
								data:{
									user_id:297962
							  	},
							  	obj:'#sequence',
							  	type:'get',
							  	url:'/back/activity/get-sequence',
								act:'sequence'
							}
						httpRequest(dataForXl);
					}else{
						str+='<option value="'+val.id+'">'+val.username+'</option>'
					}
					
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