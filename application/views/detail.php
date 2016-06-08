<?php $this->load->view('header'); ?>

<div class="homework-detail-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h4 class="mdl-card__title-text">作业详情</h4>
    <a class="mdl-navigation__link" href="<?php echo site_url('/'); ?>" class="btn btn-default"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect homework-detail-button">返回</button></a>
    <a class="mdl-navigation__link" href="<?php echo site_url('check_homework/' . $work->id); ?>" class="btn btn-primary"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect homework-detail-button">作业查重</button></a>

  </div>
  <div class="mdl-card__supporting-text">

	<?php
	if (empty($work->submissions)){ 
		echo "当前没有人提交作业！";
	} else {
	?>
  <h4 class="mdl-card__title-text"><?php echo $work->hid; ?> 提交列表</h4>
	<table class="mdl-data-table mdl-js-data-table detail-table">
		<thead>
			<tr>
				<th class="mdl-data-table__cell--non-numeric">学号</th>
				<th class="mdl-data-table__cell--non-numeric">姓名</th>
				<th class="mdl-data-table__cell--non-numeric">教学班号</th>
				<th class="mdl-data-table__cell--non-numeric">下载链接</th>
				<th class="mdl-data-table__cell--non-numeric">批改反馈</th>
				<th class="mdl-data-table__cell--non-numeric">批改状态</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			foreach ($work->submissions as $key => $value) {
				$hwid = explode('_', $value->file_name);
				$hid = $hwid[0];
				echo '<tr>';
				echo '<td class="mdl-data-table__cell--non-numeric">' . $value->user->id . '</td>';
				echo '<td class="mdl-data-table__cell--non-numeric">' . $value->user->name . '</td>';
				echo '<td class="mdl-data-table__cell--non-numeric">' . $hid . '</td>';
				echo '<td class="mdl-data-table__cell--non-numeric"><a class="mdl-navigation__link" href="' . base_url('upload/' . $work->title . '/' . $value->file_name) . '">点击下载</a></td>';
				echo '<td class="mdl-data-table__cell--non-numeric"><a href="##" class="submit-label-feedback mdl-navigation__link" data-id="' . $value->id . '">上传反馈</a></td>';
				echo '<td class="mdl-data-table__cell--non-numeric">';

				if($value->feedback_file)
					echo '已反馈';
				else
					echo '未反馈';
				echo '</td>';
			} ?>
			<div class="hide">
				<form class="homework-submit" action="<?php echo site_url('welcome/submit_feedback/' . $value->id); ?>" method="post" enctype="multipart/form-data">
					<input type="file" name="the_file" id="homework-submit-image-<?php echo $value->id; ?>" onChange="homeworkSubmit(<?php echo $value->id; ?>)">
					<input type="submit" id="homework-submit-button-<?php echo $value->id; ?>">
				</form>
			</div><?php }?>

		</tbody>
	</table>

	<h4><?php echo $work->hid; ?> 未提交列表</h4>
	<table class="mdl-data-table mdl-js-data-table detail-table">
		<thead>
			<tr>
				<th class="mdl-data-table__cell--non-numeric">学号</th>
				<th class="mdl-data-table__cell--non-numeric">姓名</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($work->not_submissions as $key => $value) {
				echo '<tr>';
				echo '<td class="mdl-data-table__cell--non-numeric">' . $value->sid . '</td>';
				echo '<td class="mdl-data-table__cell--non-numeric">' . $value->name . '</td>';
			} ?>
		</tbody>
	</table>
  </div>
</div>
<script>
function homeworkSubmit(id)
{
	$("#homework-submit-button-"+id).click();
}
$(".submit-label-feedback").click(function(){
	var id = $(this).attr('data-id');
	$("#homework-submit-image-"+id).click();
})
</script>

<?php $this->load->view('footer'); ?>
