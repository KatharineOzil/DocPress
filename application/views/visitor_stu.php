<?php $this->load->view('header3'); ?>

	<div class="row pbl">
	    <div class="col-xs-1 col-xs-offset-0">
			<div id="level-switch">
	       	<input type="checkbox" checked data-toggle="switch" data-on-color="success" data-on-text="学生" data-off-text="老师" data-off-color="warning"/>
	      	</div>
	</div>
	<div class="col-xs-11.5 col-xs-offset-2">
		<h6>说明：平台提供为游客演示的功能。请来访者在左边选择所要使用的身份。</h6>
	</div>

	<div id="student">
		<div class="homework-item-box homework-item-box-done">
			<div class="homework-item-title">
				<span class="fui-check"></span> 已提交作业
					<br/>
					<!--Todo reply  -->
			</div>
			<div class="clearfix"></div>
			<div class="homework-item-content">
				已提交作业样式示例
			</div>
			<div class="homework-item-toolbar">
				<ul>
					<li>
						<span class="fui-user"></span> A老师
					</li>
					<li class="submit-label">
						<span class="fui-clip"></span> 重新上交
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
		</div>

		<div class="homework-item-box homework-item-box-undone">
			<div class="homework-item-title">
				<span class="fui-time"></span> 未提交作业
			</div>
			<div class="clearfix"></div>
			<div class="homework-item-content">
				未提交作业样式示例
			</div>
			<div class="homework-item-toolbar">
				<ul>
					<li>
						<span class="fui-user"></span> A老师
					</li>
					<li class="submit-label" >
						<span class="fui-clip"></span> 上交作业
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>




	
<script>
	var levelSwitch = true;
	$("#teacher").hide();
	$("#level-switch").mousedown( function() {
	if (levelSwitch) {
		$("#student").hide();
		$("#teacher").show();
		levelSwitch = false;
	} else {
		$("#student").show();
		$("#teacher").hide();
		levelSwitch = true;
	}
});
</script>	

<?php $this->load->view('footer'); ?>