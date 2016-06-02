<?php $this->load->view('header'); ?>

	 <a href="<?php echo site_url('new'); ?>" class="btn btn-primary">注册课程</a>
	<br/>
	<br/>
	<div>
	       <label class="col-xs-1.5 col-xs-offset-0 btn btn-primary">已注册课程</label>
	</div>
	<br/>
	<div id="homeworks_nomal">
	<?php
		foreach ($works as $key => $work) {
			//if($work->type == '0'){
	?>
		<div class="homework-item-box">
			<div class="homework-item-title">
				<span class="fui-list"></span> <?php echo $work->title . "($work->hid)"; ?>
			</div>
<!--			<div class="homework-item-time">
r			<span class="fui-calendar"></span> <php echo $work->create_time; ?>
			</div>
-->			<div class="clearfix"></div>
			<div class="homework-item-content">
				<?php echo $work->content; ?>
			</div>
		
			<div class="homework-item-toolbar">
				
				<ul>
					<li>
						<a href="<?php echo site_url('homework_detail/' . $work->id); ?>"><span class="fui-check"></span> <?php echo $work->count; ?>人上交(共 <?php echo $work->total_count;?> 人)</a>
					</li>
					<li>
						<a href="<?php echo site_url('welcome/download/' . $work->id); ?>"><span class="fui-clip"></span> 打包下载</a>
					</li>
					<li>
						<a href="<?php echo site_url('welcome/check_homework/' . $work->id); ?>"><span class="fui-clip"></span> 作业检查</a>
					</li>
					<li>
						<a href="<?php echo site_url('welcome/delete_homework/' . $work->id); ?>" onclick="return confirm('确定要删除吗？');"><span class="fui-trash"></span> 删除</a>
					</li>
					<li>
						<span class="fui-user"></span> <?php echo $work->name; ?>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
		</div>
	<?php
		}
	?>
	</div>

<!--	<div id="homeworks_final">
	<php
		foreach ($works as $key => $work) {
			if($work->type == '1'){
	?>
		<div class="homework-item-box">
			<div class="homework-item-title">
				<span class="fui-list"></span> <php echo $work->title . "($work->hid)"; ?>
			</div>
			<div class="homework-item-time">
				<span class="fui-calendar"></span> <php echo $work->create_time; ?>
-			</div>
-			<div class="clearfix"></div>
			<div class="homework-item-content">
				<php echo $work->content; ?>
				<br/>
				<php echo '<td><a href="' . base_url('attachment/' . $work->attachment) . '">查看附件</a></td>'; ?>
			</div>
-	
			<div class="homework-item-toolbar">
				
				<ul>
					<li>
						<a href="<php echo site_url('homework_detail/' . $work->id); ?>"><span class="fui-check"></span> <php echo $work->count; ?>人上交(共 <php echo $work->total_count;?> 人)</a>
					</li>
					<li>
						<a href="<php echo site_url('welcome/download/' . $work->id); ?>"><span class="fui-clip"></span> 打包下载</a>
					</li>
					<li>
						<a href="<php echo site_url('welcome/delete_homework/' . $work->id); ?>" onclick="return confirm('确定要删除吗？');"><span class="fui-trash"></span> 删除</a>
					</li>
					<li>
						<span class="fui-user"></span> <php echo $work->name; ?>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
		</div>
	<php
			}
		}
	?>
	</div>

<script>
//var levelSwitch = true;
//$("#homeworks_final").hide();
//$("#level-switch").click( function() {
//	if (levelSwitch) {
//		$("#homeworks_nomal").hide();
//		$("#homeworks_final").show();
//		levelSwitch = false;
//	} else {
//		$("#homeworks_nomal").show();
//		$("#homeworks_final").hide();
//		levelSwitch = true;
//	}
//});
</script>
-->

<?php $this->load->view('footer'); ?>
