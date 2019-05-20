<div class="site-demo-title" style="width: 60%;">
	<form class="layui-form" lay-filter='activity' action="/">
		<input type="hidden" value="<?php echo $data['id'];?>" id='aid' name="aid">
		<div>
			<!-- 开始上传活动图片 -->
			<div>
				<label class="layui-form-label"></label>
				<div class="uploadButton showTips" data-tips='tipsForPoster' data-width='400' data-height='277' data-type='poster' id='posterUpload'>
					<img src="<?php echo isset($data['detail']['poster']) && $data['detail']['poster']?$data['detail']['poster']:'http://img.someet.cc/Fh8n2ij-_xq4D7HUPyHIFfy629F7'; ?>" width="100%">
				</div>
				<input type="hidden" name="poster" id='poster' value="">
				<!-- <div class="layui-btn demoMore uploadButton" data-type='group_code'  id='groupCodeUpload'>上传群二维码</div>
				<input type="hidden" name="group_code" id='group_code' value=""> -->
			</div>
			<br>
			<!-- 开始上传活动图片结束 -->
			<!-- dts开始 -->
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">DTS:</label>
			      <div class="layui-input-inline">
			        <select name="updated_by" lay-filter='dtsSelect' lay-verify="required" lay-search="">
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
			      <div class="layui-input-inline showTips">
			        <select name="co_founder1" lay-filter='co_founder' id="co_founder" lay-search="">
			          <option value="">选择发起人</option>
			        </select>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">搜索联合发起人:</label>
			      <div class="layui-input-block">
				      <input type="text" id='searchCoFounderInput' autocomplete="off" placeholder="昵称,ID,手机号,微信ID" class="layui-input showTips" style='max-width: 10rem;' data-tips='tipsForCofounder'>
				  </div>
			    </div>
			    <div class="layui-inline">
			    	<div class="layui-btn" id='searchFounderForCo'>搜索</div>
			    </div>
			</div>
		</div>
		<!-- 发起人主动填写 -->
		<!-- <div>
			<div class="layui-form-item">
			    <div class="layui-inline">
			      <label class="layui-form-label">联合发起人:</label>
			      <div class="layui-input-block">
				      <input type="text" name="field8"  lay-verify="title" autocomplete="off" placeholder="请输入联合发起人" class="layui-input" style='max-width: 10rem;'>
				  </div>
			    </div>
			</div>
		</div> -->
		<!-- 发起人主动填写 -->
		<!-- 联合发起人结束 -->
		<!-- 添加活动嘉宾开始 -->
		<div class="layui-form-item">
		    <div class="layui-form-item" pane="">
			    <label class="layui-form-label"></label>
			    <div class="layui-input-block">
			      <input data-tips='tipsForJb' type="checkbox" <?php echo isset($data['detail']['field7'][0])?"checked='checked'":'';?> name="haveGuest" id='haveGuestCheck' lay-filter='haveGuest' lay-skin="primary" title="添加活动嘉宾">
			    </div>
			    <div id="haveGuest" style="<?php echo isset($data['detail']['field7'][0])?'':'display:none;';?>">
			    	<div class="layui-form-item">
					    <label class="layui-form-label">嘉宾昵称:</label>
					    <div class="layui-input-block">
					      <input type="text" name="field7[]" id='jname' autocomplete="off" placeholder="请输入嘉宾昵称"
					      value="<?php echo isset($data['detail']['field7'][0])?$data['detail']['field7'][0]:'';?>" class="layui-input" style='max-width: 10rem;'>
					    </div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">嘉宾头像:</label>
						 <div class="layui-form-item">
	                        <label class="layui-form-label"></label>
	                        <div class="layui-input-inline">
	                            <div class="layui-upload-list" style="margin:0;">
	                                <img src="<?php echo isset($data['detail']['field7'][1])?$data['detail']['field7'][1]:'';?>" id="headimgurl" width="100%" class="layui-upload-img">
	                            </div>
	                            <!-- 上传头像后需要给此隐藏输入框赋值----上传头像值 -->
	                            <input id='jheadimgurl' type="hidden" name="field7[]"  value="<?php echo isset($data['detail']['field7'][1])?$data['detail']['field7'][1]:'';?>">
	                            <br>
	                            <div class="layui-input-inline layui-btn-container">
		                            <div class="layui-btn layui-btn-primary uploadButton" data-width='150' data-height='150' data-type='jiabin' id="editimg">上传头像</div>
		                        </div>
	                        </div>
	                        <div class="layui-form-item layui-form-text">
							    <label class="layui-form-label">嘉宾介绍:</label>
							    <div class="layui-input-block">
							      <textarea id='jdesc' name="field7[]" placeholder="请输入内容" class="layui-textarea" name="desc"><?php echo isset($data['detail']['field7'][2])?trim($data['detail']['field7'][2]):'';?></textarea>
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
			          <?php if($data['tagName']){?>
				          <option value="<?php echo $data['tagName']['id'];?>"><?php echo $data['tagName']['name'];?></option>
				      <?php }?>
			        </select>
			      </div>
			    </div>
			</div>
		</div>
		<!-- 开始选择分类结束 -->
		
		<!-- 选择系列开始 -->
		<div>
			<div class="layui-form-item">
				<label class="layui-form-label">活动系列:</label>
				<div class="layui-input-block">
					<select name="sequence_id" id='sequence' lay-filter='sequence' lay-filter="aihao">
						<option value="0">选择活动系列</option>
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
			        <input type="text" name="title" data-tips='tipsForTitle' lay-verify="required" class="layui-input showTips">
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">副标题:</label>
			      <div class="layui-input-inline">
			        <input type="text" name="desc" data-tips='tipsForDesc' lay-verify="required" class="layui-input showTips">
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
			      <input type="text" data-tips='tipsForContent' name="content" placeholder="输入活动文案" autocomplete="off" lay-verify="required" class="layui-input showTips">
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
			        <input  type="number" name="peoples" value="0" lay-verify="required" class="layui-input showTips" data-tips='tipsForPeople'>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">理想人数:</label>
			      <div class="layui-input-inline">
			        <input type="number" name="ideal_number" value="0" lay-verify="required" class="layui-input showTips" data-tips='tipsForPeople'>
			      </div>
			    </div>
			    <div class="layui-inline">
			      <label class="layui-form-label">人数上限:</label>
			      <div class="layui-input-inline">
			        <input type="number" name="ideal_number_limit" value="0" lay-verify="required" class="layui-input showTips" data-tips='tipsForPeople'>
			      </div>
			    </div>
			</div>
		</div>
		<!-- 报名人数结束 -->
		<!-- 活动时间设置 -->
		<div>
			<div class="layui-inline showTips" data-tips='tipsForTime'>
		      <label class="layui-form-label">开始时间</label>
		      <div class="layui-input-inline">
		        <input type="text" lay-verify="required" class="layui-input showTips" name='start_time' id="start_time" placeholder="yyyy-MM-dd HH:mm:ss">
		      </div>
		    </div>
		    <div class="layui-inline showTips" data-tips='tipsForTime'>
		      <label class="layui-form-label">结束时间</label>
		      <div class="layui-input-inline">
		        <input type="text" lay-verify="required" class="layui-input showTips" name='end_time' id="end_time" placeholder="yyyy-MM-dd HH:mm:ss">
		      </div>
		    </div>
		</div>
		<!-- 活动时间设置结束 -->
		<!-- 活动场地开始 -->
		<div>
			<div class="haveAddress showTips" data-tips='tipsForAddress'>
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
		        <input data-tips='tipsForCost' type="number" name="cost" value="0" required class="layui-input showTips">
		      </div>
		    </div>
		</div>
		<!-- 收费金额结束 -->
		<!-- 收费明细 -->
		<div>
			<div class="layui-form-item">
			    <label class="layui-form-label">收费明细:</label>
			    <div class="layui-input-block">
			      <input type="text" name="cost_list showTips" placeholder="" autocomplete="off" data-tips='tipsForCostList' class="layui-input">
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
			    这是Someet活动发起人，发起的#       <input style="max-width: 15rem;" type="text" name="header_title" placeholder="" autocomplete="off" class="layui-input showTips" data-tips='tipsForHeadTitle'>        #活动
			    我期待遇见       <input style="max-width: 15rem;" type="text" name="header_people" placeholder="" autocomplete="off" class="layui-input showTips" data-tips='tipsForHeadTitle'>        的小伙伴！
			    </div>
			</div>
		</div>
		<!-- 活动性详情结束 -->
		<!-- 活动详情 -->
		<div>
			<label class="layui-form-label">活动详情:</label>
			<div class="layui-input-block showTips" id='details' data-tips='tipsForDetail'>
				<textarea class="showTips" data-tips='tipsForDetail' name="details" id="details" style="display: none;"><?php echo isset($data['detail']['details'])?$data['detail']['details']:'';?></textarea>
			</div>
		</div>
		<!-- 活动详情 -->
		<!-- 设置问题 -->
		<div class="layui-form-item">
		    <label class="layui-form-label">筛选问题</label>
		    <?php if($data['detail']['question']){?>
		    	<div class="layui-input-block" id='question'>
		    	<?php foreach ($data['detail']['question'] as $row) {?>
		    		
				      <input type="text" name="question[<?php echo $row['id'];?>]" autocomplete="off" placeholder="请输入活动流程" value="<?php echo $row['label'];?>" class="layui-input showTips" data-tips='tipsForQuestion'>
		    	<?php }?>
		    	</div>
		    <?php }else{?>
		    	<div class="layui-input-block" id='question'>
			      <input type="text" name="question[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input showTips" data-tips='tipsForQuestion'>
			    </div>
		    <?php }?>
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
		    <!-- <div class="layui-input-block" id='review'>
		      <input type="text" name="review[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input">
		    </div> -->
		    <?php if($data['detail']['review']){?>
		    	<div class="layui-input-block" id='review'>
		    	<?php foreach ($data['detail']['review'] as $row) {?>
				      <input type="text" name="review[]" autocomplete="off" placeholder="请输入活动流程" value="<?php echo $row;?>" class="layui-input showTips" data-tips='tipsForLc'>
		    	<?php }?>
		    	</div>
		    <?php }else{?>
		    	<div class="layui-input-block" id='review'>
			      <input type="text" name="review[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input showTips" data-tips='tipsForLc'>
			    </div>
		    <?php }?>
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
		    <!-- <div class="layui-input-block" id='field6'>
		      <input type="text" name="field6[]" autocomplete="off" placeholder="请输入注意事项" class="layui-input">
		    </div> -->
		    <?php if($data['detail']['field6']){?>
		    	<div class="layui-input-block" id='field6'>
		    	<?php foreach ($data['detail']['field6'] as $row) {?>
				      <input type="text" name="field6[]" autocomplete="off" placeholder="请输入注意事项" value="<?php echo $row;?>" class="layui-input showTips" data-tips='tipsForField6'>
		    	<?php }?>
		    	</div>
		    <?php }else{?>
		    	<div class="layui-input-block" id='review'>
			      <input type="text" name="field6[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input showTips" data-tips='tipsForField6'>
			    </div>
		    <?php }?>
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
<!-- 		    <div class="layui-input-block" id='field2'>
		      <input type="text" name="field2[]" autocomplete="off" placeholder="请输入活动提示" class="layui-input">
		    </div> -->
		    <?php if($data['detail']['field2']){?>
		    	<div class="layui-input-block" id='field2'>
		    	<?php foreach ($data['detail']['field2'] as $row) {?>
		    		
				      <input type="text" name="field2[]" autocomplete="off" placeholder="请输入注意事项" value="<?php echo $row;?>" class="layui-input showTips" data-tips='tipsForTips'>
		    	<?php }?>
		    	</div>
		    <?php }else{?>
		    	<div class="layui-input-block" id='review'>
			      <input type="text" name="field2[]" autocomplete="off" placeholder="请输入活动流程" class="layui-input showTips" data-tips='tipsForTips'>
			    </div>
		    <?php }?>
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
					<button lay-filter='activityForm' lay-submit class="layui-btn-warm layui-btn-lg" >提交审核</button>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="activityTips">
	<div class="tipsDiv tipsForTitle" style="display: block;">
        <div class="title-text prompt" date-name='title'>
            <span class="title-text-title">怎样给活动取一个好的活动名称?</span><br/>
            <br/><span style="color:rgb(251,103,61);">
                <p>一个清晰表明活动主题且有意思的标题更让人有了解的欲望</p>
                <br>
                <p>以下是填写范例：</p>
                <p>互川一封：五环内外的两个世界，探秘北五环culb里的神奇故事-#帝都夜游指南#</p>
                <p>阿汪：衣锦夜行之坐街夜谈聊聊红灯区女郎</p>
                <p>德川亮：时间流逝感工作坊，关于个人时间管理的探讨和实践</p>
            </span>
        </div>
	</div>
	<div class="tipsDiv tipsForPoster">
		<div class="prompt">
            <span class="title-text-title">应该添加什么样的活动标题图片?</span><br/>
            <span style="color:rgb(251,103,61);">
                <p>标题图是给用户的第一活动印象，清晰美观最重要，不能带文字或logo哦~</p>
                    <p>强烈建立上传800X455像素大小的横版图片</p>
            </span>
        </div>
	</div>
	<div class="tipsDiv tipsForHeadTitle">
		<div class="title-text prompt" date-name='title'>
			<p class="title-text-title">开门见山的介绍，让大家迅速了解你想找到什么样的小伙伴一起玩耍~</p>
	        <br/>
	        <span style="color:rgb(251,103,61);">
	            <p>以下是填写范例：</p>
	            <p>这是Someet活动发起人，德川亮发起的 #7天笔友实验# 活动</p>
	            <p>
	                “我期待遇见 理解真诚价值，和追求仪式感 的小伙伴！”
	            </p>
	            <br>
	            <p>这是Someet活动发起人，十四发起的 #胡同理发# 活动</p>
	            <p>“我期待遇见 不管什么发型都觉得自己帅 的小伙伴！”</p>
	        </span>
	    </div>
	</div>
	<div class="tipsForDetail">
		<div class="title-text prompt" date-name='title'>
			<p class="title-text-title"><strong>怎样描述活动详情?</strong></p>
	        <br/>
	        <span style="color:rgb(251,103,61);">
	            <p>好的活动介绍有助于用户更好的了解你的活动，我们鼓励在此处开展具体描述。</p><br/>
	            <p>文案中可以有什么：</p><br/>
	            <p>你想举办这场活动的初衷或者目的本场活动有什么亮点？  <br> 活动中小伙伴将能体验到什么？ <br>……</p>
	        </span>
	        <br>
	        <p class="title-text-title">如何添加活动图片？</p>
	        <br/>
	        <span style="color:rgb(251,103,61);">
	            <p>活动图片是用户在参加活动之前，对活动体验做预期判断的重要依据。</p>
	            <p>活动图片可以是过往活动现场的照片、合影、作品或者与活动主题相关的图片。</p>
	        </span>
	        <br>
	        <p class="title-text-title">添加活动图片的方法：</p><br/>
	        <span style="color:rgb(251,103,61);">
	            <p>方法一，请直接将你找到的活动图片（必须下载到本地）拖入左侧的文本框中（可以将浏览器窗口稍微缩小便于操作）；</p>
	            <p>方法二，点击工具栏中【上传图片】按钮，选择你所需要的图片，上传成功后图片默认出现在文案顶端，需拖动到想放的位置。</p>
	        </span>
	        <br>
	        <p>注意：</p>
	        <span style="color:rgb(251,103,61);">
	            <p>1、请避免使用含工作室、品牌logo的图片，也小心网站下载图片时的第三方水印哟；</p>
	            <p>2、文案内容统一用文字展示更简洁美观，文本不建议将文案内容以图片形式呈现。</p>
	        </span>
	    </div>
	</div>
	<div class="tipsDiv tipsForCofounder">
		<div class="title-text prompt" date-name='title'>
			<span style="color:rgb(251,103,61);">
	            <p class="title-text-title">什么是联合发起人？</p><br>
	            <p>联合发起人是与活动的主要发起人共同组织落地活动，并在前期承担具体的工作，有一定的贡献。</p><br>
	            <ul>
	                <li>如果你的联合发起人已绑定为Someet发起人，请填写Ta在Someet上的用户名，小海豹将会帮你添加；</li>
	                <li>如果你的联合发起人未绑定，请让Ta微信联系与你对接的小海豹进行绑定。</li>
	            </ul>
	            <!-- <p class="title-text-title">什么是嘉宾？</p><br>
	            <p>活动嘉宾不是活动的组织或开展者，而是您在活动中邀请的 “助攻者”，他的出现将使活动内容更加充实。</p> -->
	        </span>
	    </div>
	</div>
	<div class="tipsDiv tipsForCofounder">
		<div class="title-text prompt" date-name='title'>
			<span style="color:rgb(251,103,61);">
	            <p class="title-text-title">什么是嘉宾？</p><br>
	            <p>活动嘉宾不是活动的组织或开展者，而是您在活动中邀请的 “助攻者”，他的出现将使活动内容更加充实。</p>
	        </span>
	    </div>
	</div>
	<div class="tipsDiv tipsForTime">
		<div class="time-text prompt">
            <span style="color:rgb(251,103,61);">
                <p class="title-text-title">怎样选择活动时间?</p><p><br/>依据经验，大部分活动集中在周末的下午和晚上，如果你的活动适合工作日时间或者周末上午，我们也同样欢迎。</p><br>
                <p class="title-text-title">怎样控制活动的时长?</p><br/><p>我们建议一场活动的合理时长为2-3小时，需要您对活动内容进行合理的规划，有效的时间控制和紧凑的流程能够保证活动的顺利进行。</p>
            </span>
        </div>
	</div>
	<div class="tipsDiv tipsForAddress">
		<div class="address-text prompt">
            <span style="color:rgb(251,103,61);">
                <p class="title-text-title">怎样选择合适的活动场地?</p><br>
                <p>活动场地的挑选需符合活动特点，交通便利，易于找到。例如，是否要求场地的封闭性，对面积大小的要求等。</p><br>
                <p class="title-text-title">如果自己没有活动场地怎么办?</p><br>
                <p>请您勾选左侧“需要平台提供活动场地的选项”，我们会为有场地需求的活动提供合适的空间，保证活动的顺利进行。同时请您填写对活动场地的要求，并告知活动中可能存在的设备需求，如：投影仪、厨房等</p>
            </span>
        </div>
	</div>
	<div class="tipsDiv tipsForPeople">
		<div class="member-text prompt">
            <span style="color:rgb(251,103,61);">
                <p class="title-text-title">怎样控制活动人数，使活动体验更好?</p><br/>
                <p>事实证明，一个经验再丰富的主持人也很难hold住超过10人的活动现场。我们鼓励10人左右的小型活动，保证每个人体验均等的同时，也促进参与者之间产生深度互动</p>
            </span>
        </div>
	</div>
	<div class="tipsDiv tipsForCost">
		<div class="cost-text prompt" date-name='fee'>
            <span style="color:rgb(251,103,61);">
                <p class="title-text-title"><b>一场活动应该收取多少费用合适?</b></p><br/>
                <p>首先Someet平台的原则是不鼓励商业性强或有过多盈利空间的活动。</p>
                <p>如果活动不收费填“免费”即可；</p>
                <p>若收费，建议您将活动费用控制在成本之内，我们认可每个发起人为活动贡献的价值，但我们也相信钱的多少不应该是决定用户是否参加活动的核心，平台的问答筛选系统可以更好的让 “合适的小伙伴聚在一起”。</p><br>
                <p class="title-text-title">怎样向用户描述我们的活动成本?</p><br>
                <p>如果活动费用为80元/人，您可以这样描述：80元/人，15元用于场地费低消，10元用于购买饮品成本，55元用于制作甜点的原料成本（包含淀粉，发酵粉，奶油，水果等等）</p>
            </span>
        </div>
	</div>
	<div class="tipsDiv tipsForLc">
		<div class="review-text prompt t_text">
        <span style="color:rgb(251,103,61);">
                <p class="title-text-title">一场活动应该怎样设计?</p><br/>
                <p>活动形式新颖、有趣、仪式感强，可以吸引到更多高质量用户。</p>
                <p>如何设计一场活动的流程呢？在活动进行中，保证流程紧凑、不冷场，参与者之间能有较深的交流和互动，让所有人都能在活动中有所收获。</p><br/>
                <p>以下是填写范例：</p><br/>
                <p>活动:当我们谈论“外表”时，我们在谈论什么</p>
                <p>1、集合之后，先来自我介绍或其他破冰环节（此环节为平台默认环节）；</p>
                <p>2、大家品尝某款酒后开始分享感受 / 大家一起从X出发，先前往XX / 我会先给大家分享一些这个领域的常识和注意事项</p>
                <p>3、...</p>
                <p>4、...</p>
                <p>5、活动愉快结束，各自勾搭，各回各家</p><br>
                <p class="title-text-title">活动开始前为什么要设置破冰环节?我该怎么做?</p><br/>
                <p>破冰是为了能够让活动参与者在活动刚开始前能够迅速消除陌生感，相互熟悉，从而有利于活动的整体体验。</p>
                 <p>一个好的破冰环节可以有</p>
                 <p style="margin-left:2rem;">
                     <ul style="    margin-left: 1rem;">
                         <li >1.有趣的结合点让，让每个人的自我介绍自然发生</li>
                         <li>2.融合简单的小游戏，是消除陌生感的利器</li>
                     </ul>
                 </p>   
            </span>
        </div>
	</div>
	<div class="tipsDiv tipsForField6">
		<div class="tips-text prompt t_text" style="top:0rem;">
            <span style="color:rgb(251,103,61);">
                <p class="title-text-title">您还需要告诉用户什么?</p><br>
                <p>如果您的活动还在别的渠道发布，请您勾选第5项，并填写通过其他渠道报名的人数。</p><br/>
                <p>如果您的活动需要 户额外携带物品或者活动中需要特别注意什么事项，您可在左侧文本框内填写。</p><br>
                <p>以下是填写范例:</p><br>
                <p>例1、建议着休闲运动装，运动鞋，山里早晚温差大，备添加衣物，防晒霜，帽子。</p>
                <p>例2、准备方便爬山的鞋子，登山杖。 本次活动爬山约50分钟。</p>
                <p>例3、活动本身免费，但每人请带一份零食哦（3人分享量）。</p>
                <p>例4、请参加活动小伙伴们尽可能穿宽松的衣服。</p>
            </span>
        </div>
	</div>
	<div class="tipsDiv tipsForQuestion">
		<div class="tips-text prompt">
            <span style="color:rgb(251,103,61);">
                <p class="title-text-title">为什么设置筛选问题？</p><br>
                <p>合理设置筛选问题可以帮助您挑选出适合活动的参与者，并且能够侧面了解参与者参加活动的目的和需求。我们认为，同一场活动中的参与者是否契合，对活动主题的了解水平是否相近，会很大程度上影响活动体验。发起人可以设置3个问题让报名者回答，根据回答来最终决定活动参与者。</p><br/>
                <p>我们为您准备了1个问题，您可以根据自己的需要进行更改，与活动相关的开放式问题可以帮助您更多的了解报名的用户，从而达到一个好的匹配效果。</p><br>
                <p>合适的问题举例：</p>
                <p>1、你喜欢的电影类型是什么，为什么呢？</p>
                <p>2、你经历过印象最深刻的一次骑行是什么样的？</p>
                <p>3、近半年看的最喜欢的书是什么？</p>
                <p>4、跟我分享三首近期最常听的歌吧！</p>
                <br>
                <p>不提倡的问题形式</p>
                <p>1、命题简单只能回答”是”或”否”；如：你喜欢攀岩吗？</p>
                <p>2、带有工作室、公司名称的问题，如：你之前是否参加XX工作室的活动？</p>
                <p>3、未和小海豹进行沟通，直接收集用户基础信息，如姓名、性别、电话等；</p>
                <p>4、直接露出发起人个人或工作的联系方式等信息。</p>
            </span>
        </div>
	</div>
</div>
<script type="text/javascript" src='/layui/js/modules/cropper.js'></script>
<script type="text/javascript">
var form = layui.form;
var isReady = 0; 
var layedit = layui.layedit;
var editIndex = layedit.build('details',{
	height:600,
	tool: ['strong','left', 'center', 'right','image'],
	uploadImage:{url: '/back/upload/upload-image?type=text', type: 'post'}
}); //建立编辑器
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
//活动的ID用于编辑活动 
var id = $('#aid').val();
var token = $('#access_token').val();
$.ajaxSettings.beforeSend = function(xhr,request){
    xhr.setRequestHeader('Authorization','Bearer '+token);
}
var _csrf = $('#_csrf').val();
//设置一个控制提交的变量
var isSub = 0;
// 增加填写活动的提示框
$('.showTips').click(function(){
	// 获取对应点击的组件高度
	showTips($(this))
})
$('.showTips').focus(function(){
	// 获取对应点击的组件高度
	showTips($(this))
})
function showTips(obj){
	var height = obj.offset().top
	height-=20;
	console.log(height)
	var tname = obj.data('tips');
	$('.activityTips').css({'top':height+'px'})
	$('.activityTips').show()
	$('.tipsDiv').hide();
	$('.'+tname).show();
}

// DOMSubtreeModified
$("iframe[textarea=details]").contents().find("body").keyup(function(){
	// 监听输入框事件
	var obj = $('#LAY_layedit_1');
	var height = obj.offset().top
	height-=20;
	console.log(height)
	var tname = obj.data('tips');
	$('.activityTips').css({'top':height+'px'})
	$('.activityTips').show()
	$('.tipsDiv').hide();
	$('.'+tname).show();
});
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
        ,area:'900px'  //弹窗宽度
        ,url: "/back/upload/upload-image"  //图片上传接口返回和（layui 的upload 模块）返回的JOSN一样
        ,done: function(url,type){ //上传完毕回调
        	if(type=='jiabin'){
        		$('#jheadimgurl').val(url)
            	$("#headimgurl").attr('src',url);
        	}else if(type == 'poster'){
        		$("#poster").val(url);
        		$('#posterUpload').children('img').attr('src',url)
        	}else if(type == 'group_code'){
        		$('#group_code').val(url);
        	}
        	layer.closeAll();
            
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
//搜索联合发起人
$('#searchFounderForCo').click(function(){
	var val = $('#searchCoFounderInput').val();
	var data ={
		  	data:{
		  		type:'co_founder',
				val:val
		  	},
		  	obj:'#co_founder',
		  	type:'get',
		  	url:'/back/member/get-user-search',
		  	act:'founder'
		  }
	httpRequest(data);  
})
//监听提交
form.on('submit(activityForm)', function(data){
	data.field.details = layedit.getContent(editIndex);
	// console.log(data.field.details)
	// return false;
	if(isSub == 0){
		isSub = 1;
		if($('#haveGuestCheck').val()){
			var jname = $('#jname').val()
			var jheadimgurl = $('#jheadimgurl').val();
			var jdesc = $('#jdesc').val()
			if(!jname || !jheadimgurl || !jdesc){
				isSub = 0;
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
				isSub = 0;
				if(res.data.status == 1){
					layer.msg('操作成功');
					window.location.href = '/activity/index'
				}else{
					layer.msg('操作失败');
				}
				
			},
			error:function(){
				isSub = 0;
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
	var str = '<input type="text" name="'+ele+'['+index+']" autocomplete="off" class="layui-input" placeholder="请输入文本内容">';
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
					str+='<option value="0">选择活动系列</option><option value="'+val.sequence_id+'">'+val.title+'</option>'
				}else if(data.act == 'founder'){

					if(index == 0){
						str+='<option selected="selected" value="'+val.id+'">'+val.username+'</option>'
						
					}else{
						str+='<option value="'+val.id+'">'+val.username+'</option>'
					}
					getFounderSpaceAndXl(val.id)
					
				}else if(data.act == 'space'){
					str+='<option value="0">选择活动场地</option><option value="'+val.id+'">'+val.name+'</option>'
				}else if(data.act == 'co_founder'){
					if(index == 0){
						str+='<option selected="selected" value="'+val.id+'">'+val.username+'</option>'
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
//获取一选区的发起人场地和系列
function getFounderSpaceAndXl(id){
	var dataForXl ={
			data:{
				user_id:id
		  	},
		  	obj:'#sequence',
		  	type:'get',
		  	url:'/back/activity/get-sequence',
			act:'sequence'
	}
	var dataForSpace ={
			data:{
				user_id:id,
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
}
//预设赋值‘
if(id>0){
	$("select[name='updated_by']").val("<?php echo $data['detail']['updated_by'];?>")
	$("select[name='address']").val("<?php echo $data['detail']['space_spot_id'];?>")
	$("select[name='created_by']").append('<option selected="selected" value="'+"<?php echo $data['detail']['created_by'];?>"+'">'+"<?php echo $data['detail']['username'];?>"+'</option>');
	getFounderSpaceAndXl("<?php echo $data['detail']['created_by'];?>")
	$("select[name='co_founder1']").append('<option selected="selected" value="'+"<?php echo $data['detail']['co_founder1'];?>"+'">'+"<?php echo $data['detail']['co_username'];?>"+'</option>');
	$("select[name='type_id']").val("<?php echo $data['detail']['type_id'];?>")
	$("select[name='tag_id']").val("<?php echo $data['detail']['tag_id'];?>")
	$("select[name='space_spot_id']").append('<option selected="selected" value="'+"<?php echo $data['detail']['space_spot_id'];?>"+'">'+"<?php echo $data['detail']['spacename'];?>"+'</option>');
	//默认分类
	$("select[name='created_by']").val("<?php echo $data['detail']['created_by'];?>")
	form.val("activity", {
		'title':"<?php echo $data['detail']['title'];?>",
		'poster':"<?php echo $data['detail']['poster'];?>",
		'desc':"<?php echo $data['detail']['desc'];?>",
		'content':"<?php echo $data['detail']['content'];?>",
		'peoples':"<?php echo $data['detail']['peoples'];?>",
		'ideal_number':"<?php echo $data['detail']['ideal_number'];?>",
		'ideal_number_limit':"<?php echo $data['detail']['ideal_number_limit'];?>",
		'start_time':"<?php echo date('Y-m-d H:i:s',$data['detail']['start_time']);?>",
		'end_time':"<?php echo date('Y-m-d H:i:s',$data['detail']['end_time']);?>",
		'cost_list':"<?php echo $data['detail']['cost_list'];?>",
		'cost':"<?php echo $data['detail']['cost'];?>",
		'header_title':"<?php echo $data['detail']['header_title'];?>",
		'header_people':"<?php echo $data['detail']['header_people'];?>",
		'co_founder1':'<?php echo $data['detail']['co_founder1'];?>'
	})
	form.render();
}  
isReady = 1;  
</script>