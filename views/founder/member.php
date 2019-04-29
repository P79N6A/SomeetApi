<div class="view-detail">
	<div class="view-detail-info-box">
		<ul class="layui-timeline">
			<li class="layui-timeline-item">
				<i class="layui-icon layui-timeline-axis">&#xe63f;</i>
				<div class="layui-timeline-content layui-text">
					<h3 class="layui-timeline-title">信息</h3>
					<div class="view-detail-left">
						<div>
							微信昵称： <span id='view-detail-nickname'><?php echo $data['username'];?></span>
						</div>
						<div>
							生日:<?php echo $data['profile']['birth_year'].'年'.$data['profile']['birth_month'].'月'.$data['profile']['birth_day'].'日';?>
						</div>
						<div>
							性别：<?php echo $data['profile']['sex'] == 1?'男':'女';?>
						</div>
						<div>
							授权时间：<?php echo date('Y-m-d',$data['created_at']);?>
						</div>
						<div>
							上次登录时间：<?php echo date('Y-m-d',$data['last_login_at']);?>
						</div>
					</div>
				</div>
			</li>
			<li class="layui-timeline-item">
				<i class="layui-icon layui-timeline-axis">&#xe63f;</i>
				<div class="layui-timeline-content layui-text">
					<h3 class="layui-timeline-title">资料</h3>
					<div class="view-detail-left">
						<div>
							<img class="view-detail-headimg" src="<?php echo $data['profile']['headimgurl'];?>">
						</div>
						<div>
							用户名：<?php echo $data['username'];?>
						</div>
						<div>
							真实姓名：<?php echo $data['realname'];?>
						</div>
						<div>
							手机号：<?php echo $data['mobile'];?>
						</div>
						<div>
							<?php echo $data['wechat_id'];?>
						</div>
					</div>
				</div>
			</li>
			<li class="layui-timeline-item">
				<i class="layui-icon layui-timeline-axis">&#xe63f;</i>
				<div class="layui-timeline-content">
					<h3 class="layui-timeline-title" style="font-size: 18px;font-weight: 500;color: #333;">标签</h3>
					<div class="layui-row layui-col-space10">
					    <div class="layui-col-xs2">
					      <div class="view-detail-tag-div">
					      	<ul class="view-detail-tag-ul">
					      		<li class="list-group-item-success">职业</li>
					      		<?php if(isset($data['tags']['zy']) && !empty($data['tags']['zy'])){foreach($data['tags']['zy'] as $row){?>
					      			<li class="list-group-item-info"><?php echo $row['tag_title'];?></li>
					      		<?php }}?>
					      	</ul>
					      </div>
					    </div>
					    <div class="layui-col-xs2">
					      <div class="view-detail-tag-div">
					      	<ul class="view-detail-tag-ul">
					      		<li class="list-group-item-success">个人技能</li>
					      		<?php if(isset($data['tags']['grjn']) && !empty($data['tags']['grjn'])){foreach($data['tags']['grjn'] as $row){?>
					      			<li class="list-group-item-info"><?php echo $row['tag_title'];?></li>
					      		<?php }}?>
					      	</ul>
					      </div>
					    </div>
					    <div class="layui-col-xs2">
					      <div class="view-detail-tag-div">
					      	<ul class="view-detail-tag-ul">
					      		<li class="list-group-item-success">个人属性</li>
					      		<?php if(isset($data['tags']['grsx']) && !empty($data['tags']['grsx'])){foreach($data['tags']['grsx'] as $row){?>
					      			<li class="list-group-item-info"><?php echo $row['tag_title'];?></li>
					      		<?php }}?>
					      	</ul>
					      </div>
					    </div>
					    <div class="layui-col-xs2">
					      <div class="view-detail-tag-div">
					      	<ul class="view-detail-tag-ul">
					      		<li class="list-group-item-success">特殊经历</li>
					      		<?php if(isset($data['tags']['tsjl']) && !empty($data['tags']['tsjl'])){foreach($data['tags']['tsjl'] as $row){?>
					      			<li class="list-group-item-info"><?php echo $row['tag_title'];?></li>
					      		<?php }}?>
					      	</ul>
					      </div>
					    </div>
					    <div class="layui-col-xs2">
					      <div class="view-detail-tag-div">
					      	<ul class="view-detail-tag-ul">
					      		<li class="list-group-item-success">人生态度</li>
					      		<?php if(isset($data['tags']['rstd']) && !empty($data['tags']['rstd'])){foreach($data['tags']['rstd'] as $row){?>
					      			<li class="list-group-item-info"><?php echo $row['tag_title'];?></li>
					      		<?php }}?>
					      	</ul>
					      </div>
					    </div>
					    <div class="layui-col-xs2">
					      <div class="view-detail-tag-div">
					      	<ul class="view-detail-tag-ul">
					      		<li class="list-group-item-success">偏好</li>
					      		<?php if(isset($data['tags']['ph']) && !empty($data['tags']['ph'])){foreach($data['tags']['ph'] as $row){?>
					      			<li class="list-group-item-info"><?php echo $row['tag_title'];?></li>
					      		<?php }}?>
					      	</ul>
					      </div>
					    </div>
					</div>
				</div>
			</li>
			<li class="layui-timeline-item">
				<i class="layui-icon layui-timeline-axis">&#xe63f;</i>
				<div class="layui-timeline-content layui-text">
					<h3 class="layui-timeline-title">发起人备注</h3>
					<p>
						1、职人/达人：</p><p>
						2、你认为ta常发活动的背后动机是：</p><p>
						3、与ta的沟通方式是（正常沟通/需要更加注意说话的逻辑避免被抓把柄……）</p><p>
						4、ta有哪些特点（如：对小海豹说话比较不客气/控场较差/总想设法赚钱/很会钻空子/容易挑刺……）</p><p>
						5、活动评价（体验很好，满分好评类型/有个人工作室，手工活动品质好/爱发狼杀/评分不低但是体验有待提升……）</p><p>
						6、需要特别注意的（如：控制活动的价格/活动数/理想人数/发起人是否被用户投诉过）</p><p>
					</p>
					<div>
						<textarea name="" required lay-verify="required" readonly="readonly" class="layui-textarea"></textarea>
					</div>
				</div>
			</li>
			<li class="layui-timeline-item">
				<i class="layui-icon layui-timeline-axis">&#xe63f;</i>
				<div class="layui-timeline-content layui-text">
					<h3 class="layui-timeline-title">报名记录</h3>
					<div class="layui-tab">
					  <ul class="layui-tab-title">
					    <li class="layui-this">发起活动</li>
					    <li>报名活动</li>
					     <li>黄牌记录</li>
					  </ul>
					  <div class="layui-tab-content">
					    <div class="layui-tab-item layui-show">
					    	<?php if(isset($data['activity']) && !empty($data['activity'])){foreach($data['activity'] as $row){?>
						    	<div class="layui-card view-detail-layui-card">
								  <div class="layui-card-header"><?php echo $row['title'];?></div>
								  <div class="layui-card-body">
								    <?php echo date('Y-m-d H:i:s',$row['start_time']);?>
								  </div>
								</div>
							<?php }}?>
					    </div>
					    <div class="layui-tab-item">
					    	<?php if(isset($data['answers']) && !empty($data['answers'])){foreach($data['answers'] as $row){?>
						    	<div class="layui-card view-detail-layui-card">
								  <div class="layui-card-header"><?php echo $row['title'];?></div>
								  <div class="layui-card-body">
								    <?php echo date('Y-m-d H:i:s',$row['start_time']);?>
								  </div>
								</div>
							<?php }}?>
					    </div>
					    <div class="layui-tab-item">
					    	<?php if(isset($data['yellowCard']) && !empty($data['yellowCard'])){foreach($data['yellowCard'] as $row){?>
						    	<div class="layui-card view-detail-layui-card">
								  <div class="layui-card-header"><?php echo $row['title'];?></div>
								  <div class="layui-card-body">
								    <?php echo date('Y-m-d H:i:s',$row['start_time']);?>
								  </div>
								</div>
							<?php }}else{?>
								暂时没有数据
							<?php }?>
					    </div>
					  </div>
					</div>
				</div>
			</li>

		</ul>
	</div>
</div>
<script type="text/javascript">
var form = layui.form; 
var element = layui.element;
var $ = layui.jquery;
var token = $('#access_token').val();
$.ajaxSettings.beforeSend = function(xhr,request){
    xhr.setRequestHeader('Authorization','Bearer '+token);
}
var _csrf = $('#_csrf').val()
var user_id = $('#user_id').val();
form.render();
</script>