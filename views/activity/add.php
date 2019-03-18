<div class="site-demo-title">
	<form class="layui-form" action="">
		<div>
			<!-- dts开始 -->
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">DTS:</label>
			      <div class="layui-input-inline">
			        <select name="modules" lay-verify="required" lay-search="">
			          <option value="">选择DTS</option>
			          <option value="1">layer</option>
			          <option value="2">form</option>
			        </select>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">PMA:</label>
			      <div class="layui-input-inline">
			        <select name="modules" lay-verify="required" lay-search="">
			          <option value="">选择PMA</option>
			          <option value="1">layer</option>
			          <option value="2">form</option>
			        </select>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">PMA类型:</label>
			      <div class="layui-input-inline">
			        <select name="modules" lay-verify="required" lay-search="">
			          <option value="">选择pma类型</option>
			          <option value="1">layer</option>
			          <option value="2">form</option>
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
			        <select name="modules" lay-verify="required" lay-search="">
			          <option value="">选择发起人</option>
			          <option value="1">layer</option>
			          <option value="2">form</option>
			        </select>
			      </div>
			    </div>
			</div>
		</div>
		<!-- 发起人结束 -->
		<!-- 联合发起人开始 -->
		<div>
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">联合发起人:</label>
			      <div class="layui-input-inline">
			        <select name="modules" lay-verify="required" lay-search="">
			          <option value="">选择联合发起人</option>
			          <option value="1">layer</option>
			          <option value="2">form</option>
			        </select>
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
		                            <div class="layui-btn layui-btn-primary" id="editimg">上传头像</div >
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
			        <select name="modules" lay-verify="required" lay-search="">
			          <option value="">选择一级分类</option>
			          <option value="1">layer</option>
			          <option value="2">form</option>
			        </select>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">二级分类:</label>
			      <div class="layui-input-inline">
			        <select name="modules" lay-verify="required" lay-search="">
			          <option value="">选择二级分类</option>
			          <option value="1">layer</option>
			          <option value="2">form</option>
			        </select>
			      </div>
			    </div>
			</div>
		</div>
		<!-- 开始选择分类结束 -->
		<!-- 开始上传活动图片 -->
		<div>
			<label class="layui-form-label"></label>
			<div class="layui-btn demoMore" lay-data="{url: '/a/'}">上传活动图片</div>
			<div class="layui-btn demoMore" lay-data="{url: '/c/', accept: 'file',size:10}">上传群二维码</div>
		</div>
		<br>
		<!-- 开始上传活动图片结束 -->
		<!-- 选择系列开始 -->
		<div>
			<div class="layui-form-item">
				<label class="layui-form-label">活动系列:</label>
				<div class="layui-input-block">
					<select name="interest" lay-filter="aihao">
						<option value="">选择活动系列</option>
						<option value="0">写作</option>
						<option value="1">阅读</option>
						<option value="2">游戏</option>
						<option value="3">音乐</option>
						<option value="4">旅行</option>
					</select>
				</div>
			</div>
		</div>
		<!-- 选择系列结束 -->
		<!-- 活动所属组 -->
		<div>
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
		</div>
		<!-- 活动所属组结束 -->
		<!-- 活动标题开始 -->
		<div>			  
		  	<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">标题:</label>
			      <div class="layui-input-inline">
			        <input type="tel" name="phone" required class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">副标题:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="email" required class="layui-input">
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
			      <input type="text" name="identity" placeholder="" autocomplete="off" class="layui-input">
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
			        <input type="tel" name="number" value="0" required class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">理想人数:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="number" value="0" required class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">人数上限:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="number" value="0" required class="layui-input">
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
		        <input type="text" class="layui-input" id="start_time" placeholder="yyyy-MM-dd HH:mm:ss">
		      </div>
		    </div>
		    <div class="layui-inline">
		      <label class="layui-form-label">结束时间</label>
		      <div class="layui-input-inline">
		        <input type="text" class="layui-input" id="end_time" placeholder="yyyy-MM-dd HH:mm:ss">
		      </div>
		    </div>
		</div>
		<!-- 活动时间设置结束 -->
		<!-- 活动场地开始 -->
		<div>
			<div class="layui-form-item">
			    <label class="layui-form-label">选择场地</label>
			    <div class="layui-input-block">
			      <input type="radio" name="sex" lay-filter='address' checked="" value="1" title="有">
			      <input type="radio" name="sex" lay-filter='address' value="0" title="无">
			    </div>
			</div>
			<div class="haveAddress">
				<div class="layui-form-item">
				<label class="layui-form-label">选择场地</label>
				<div class="layui-input-block">
					<select name="interest" lay-filter="aihao">
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
			        <input type="tel" name="phone" class="layui-input">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">场地:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="email" class="layui-input">
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
		        <input type="tel" name="number" value="0" required class="layui-input">
		      </div>
		    </div>
		</div>
		<!-- 收费金额结束 -->
		<!-- 收费明细 -->
		<div>
			<div class="layui-form-item">
			    <label class="layui-form-label">收费明细:</label>
			    <div class="layui-input-block">
			      <input type="text" name="identity" placeholder="" autocomplete="off" class="layui-input">
			    </div>
			</div>
		</div>
		<!-- 收费明细结束 -->
		<!-- 活动详情开头 -->
		<div>
			<div class="layui-form-item">
				<label class="layui-form-label">收费明细:</label>
				<div class="layui-input-block">
					<br>
			    这是Someet活动发起人，发起的#       <input style="max-width: 15rem;" type="text" name="identity" placeholder="" autocomplete="off" class="layui-input">        #活动
			    我期待遇见       <input style="max-width: 15rem;" type="text" name="identity" placeholder="" autocomplete="off" class="layui-input">        的小伙伴！
			    </div>
			</div>
		</div>
		<!-- 活动性详情结束 -->
		<!-- 活动详情 -->
		<div>
			<label class="layui-form-label">活动详情:</label>
			<div class="layui-input-block">
				<textarea style="max-width: 20rem;" id="detail" style="display: none;"></textarea>
			</div>
		</div>
		<!-- 活动详情 -->
	</form>
</div>
<script type="text/javascript" src='/layui/js/modules/cropper.js'></script>
<script type="text/javascript">
//建立编辑器
var layedit = layui.layedit;
layedit.build('detail'); 
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
        elem: '#editimg'
        ,saveW:150     //保存宽度
        ,saveH:150
        ,mark:1/1    //选取比例
        ,area:'900px'  //弹窗宽度
        ,url: "/upload/upload-image"  //图片上传接口返回和（layui 的upload 模块）返回的JOSN一样
        ,done: function(url){ //上传完毕回调
            // $("#inputimgurl").val(url);
            $('#guestHead').val(url);
            $("#srcimgurl").attr('src',url);
        }
    });
});
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
</script>