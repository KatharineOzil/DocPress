<?php $this->load->view('header'); ?>

	<div class="col-xs-1 col-xs-offset-0" id="level-switch">
	    <input type="checkbox" checked data-toggle="switch" data-on-color="success" data-on-text="理论" data-off-text="实践" data-off-color="warning"/>
	</div>
	<br/>
	<br/>
	<div id="homeworks_nomal">
	<?php
		if (empty($works)) {
			echo "当前没有需要提交的作业哟！";
		}
		foreach ($works as $key => $work) {
			if($work->type == '0'){
	?>


		<div class="homework-item-box <?php echo $work->done ? 'homework-item-box-done' : 'homework-item-box-undone'; ?>">
			<div class="homework-item-title">
				<?php if ($work->done) { ?>
					<span class="fui-check"></span> <?php echo $work->title; ?>
					<br/>
					<?php 
					if($work->feedback_file)
						echo '<a href="'. base_url('reply/' . $work->feedback_file) . '">&nbsp&nbsp&nbsp(查看教师批改反馈)</a>'; 
					?>
				<?php } else { ?>
					<span class="fui-time"></span> <?php echo $work->title; ?>
				<?php } ?>
			</div>
			<div class="homework-item-time">
				<span class="fui-calendar"></span> <?php echo $work->create_time; ?>
			</div>
			<div class="clearfix"></div>
			<div class="homework-item-content">
				<?php echo $work->content; ?>
				<br/>
				<?php echo '<td><a href="' . base_url('attachment/' . $work->attachment) . '">下载附件</a></td>'; ?>
			</div>
			<div class="homework-item-toolbar">
				<ul>
					<li>
						<!-- <a href="' . base_url('reply/' . $work->id . '/' . $value->file_name) . '"> -->
					</li>
					<li>
						<span class="fui-user"></span> <?php echo $work->name; ?>
					</li>
					<?php if (!$work->done) { ?>
					<li class="submit-label" data-id="<?php echo $work->id; ?>">
						<span class="fui-clip"></span> 上交作业
					</li>
					<?php } else { ?>
					<li class="submit-label" data-id="<?php echo $work->id; ?>">
						<span class="fui-clip"></span> 重新上交
					</li>
					<li>
						<span class="fui-calendar"></span> <?php echo $work->submit_time; ?>上交
					</li>
					<?php } ?>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="hide">
				<form class="homework-submit" action="<?php echo site_url('welcome/submit_homework/' . $work->id); ?>" method="post" enctype="multipart/form-data">
					<input type="file" name="the_file" id="homework-submit-image-<?php echo $work->id; ?>" onChange="homeworkSubmit(<?php echo $work->id; ?>)">
					<input type="submit" id="homework-submit-button-<?php echo $work->id; ?>">
				</form>
			</div>
		</div>
	<?php
		}
	}
	?>
	</div>

		<div id="homeworks_final">
	<?php
		if (empty($works)) {
			echo "当前没有需要提交的作业哟！";
		}
		foreach ($works as $key => $work) {
			if($work->type == '1'){
	?>


		<div class="homework-item-box <?php echo $work->done ? 'homework-item-box-done' : 'homework-item-box-undone'; ?>">
			<div class="homework-item-title">
				<?php if ($work->done) { ?>
					<span class="fui-check"></span> <?php echo $work->title; ?>
					<br/>
					<?php 
					if($work->feedback_file)
						echo '<a href="'. base_url('reply/' . $work->feedback_file) . '">&nbsp&nbsp&nbsp(查看教师批改反馈)</a>'; 
					?>
				<?php } else { ?>
					<span class="fui-time"></span> <?php echo $work->title; ?>
				<?php } ?>
			</div>
			<div class="homework-item-time">
				<span class="fui-calendar"></span> <?php echo $work->create_time; ?>
			</div>
			<div class="clearfix"></div>
			<div class="homework-item-content">
				<?php echo $work->content; ?>
				<br/>
				<?php echo '<td><a href="' . base_url('attachment/' . $work->attachment) . '">下载附件</a></td>'; ?>
			</div>
			<div class="homework-item-toolbar">
				<ul>
					<li>
						<!-- <a href="' . base_url('reply/' . $work->id . '/' . $value->file_name) . '"> -->
					</li>
					<li>
						<span class="fui-user"></span> <?php echo $work->name; ?>
					</li>
					<?php if (!$work->done) { ?>
					<li class="submit-label" data-id="<?php echo $work->id; ?>">
						<span class="fui-clip"></span> 上交作业
					</li>
					<?php } else { ?>
					<li class="submit-label" data-id="<?php echo $work->id; ?>">
						<span class="fui-clip"></span> 重新上交
					</li>
					<li>
						<span class="fui-calendar"></span> <?php echo $work->submit_time; ?>上交
					</li>
					<?php } ?>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="hide">
				<form class="homework-submit" action="<?php echo site_url('welcome/submit_homework/' . $work->id); ?>" method="post" enctype="multipart/form-data">
					<input type="file" name="the_file" id="homework-submit-image-<?php echo $work->id; ?>" onChange="homeworkSubmit(<?php echo $work->id; ?>)">
					<input type="submit" id="homework-submit-button-<?php echo $work->id; ?>">
				</form>
			</div>
		</div>
	<?php
		}
	}
	?>
	</div>


<script>
function homeworkSubmit(id)
{
	$("#homework-submit-button-"+id).click();
}
$(".submit-label").click(function(){
	var id = $(this).attr('data-id');
	$("#homework-submit-image-"+id).click();
})

var levelSwitch = true;
$("#homeworks_final").hide();
$("#level-switch").click( function() {
	if (levelSwitch) {
		$("#homeworks_nomal").hide();
		$("#homeworks_final").show();
		levelSwitch = false;
	} else {
		$("#homeworks_nomal").show();
		$("#homeworks_final").hide();
		levelSwitch = true;
	}
});
</script>

<?php $this->load->view('footer'); ?>
