<div class="view-detail">
	<input type="hidden" value="<?php echo $aid;?>" id='aid' name="">
	<div class="view-detail-button answer-title">
		#<?php echo $activity['id'];?> <?php echo $activity['title'];?>  <?php echo $activity['user']['username'];?>
	</div>
	<div class="view-detail-info-box">
		<div style="padding: 20px; background-color: #F2F2F2;">
			<div class="layui-row layui-col-space15" id='answer-box-top'>
				<!-- 卡片开始 -->
			    <!-- 卡片结束 -->
			    <?php echo $count == 0?'<h6 style="font-size: 3rem;">没有人报名</h6>':'';?>
			</div>
			<div id="answer-list-more">
		    	
		    </div>
		</div> 
	</div>
</div>
<script type="text/javascript" ></script>
<script type="text/javascript">
	var $ = layui.$;
	var count = "<?php echo $count;?>"
if(Number(count) != 0){
	var answer,layer= layui.layer;
	var token = $('#access_token').val();
	$.ajaxSettings.beforeSend = function(xhr,request){
	    xhr.setRequestHeader('Authorization','Bearer '+token);
	}
	var id = $('#aid').val();
	var laypage = layui.laypage;
	layui.config({
    	base: '/layui/js/' //layui自定义layui组件目录
	}).use(['answer'], function () {
	    var $ = layui.jquery;
	    answer = layui.answer;
	});
	laypage.render({
	    elem: 'answer-list-more' //注意，这里的 test1 是 ID，不用加 # 号
	    ,count: count //数据总数，从服务端得到
	    ,limit:1
	    ,jump: function(obj, first){
	    	layer.load();
		    //obj包含了当前分页的所有参数，比如：
		    // console.log(obj.curr); //得到当前页，以便向服务端请求对应页的数据。
		    // console.log(obj.limit); //得到每页显示的条数
		    getMore(obj.curr,obj.limit)
		    //首次不执行
		    if(!first){
		      //do something
		    }
		}
	});
	function getMore(page,limit){
		$.ajax({
			url:'/back/activity/get-more-answer',
			data:{
				id:id,
				page:page,
				limit:limit
			},
			success:function(res){
				layer.closeAll();
				renderAnswer(answer,res.data)
			},
			error:function(){
				layer.msg('error')
			}
		})
	}
	var element = layui.element

	function renderAnswer(answer,data){
		$('#answer-box-top').html(' ')
		//创建一个头像上传组件
	    answer.render({
	         data:data
	    })
	}
}
</script>