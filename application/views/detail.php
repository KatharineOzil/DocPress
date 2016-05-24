<?php $this->load->view('header'); ?>
	
	<a href="<?php echo site_url(); ?>" class="btn btn-default">返回</a>
	<h4><?php echo $work->hid; ?> 提交列表</h4>
	<?php if (empty($work->submissions)){ 
		echo "当前没有人提交作业！";}
		else{?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>学号</th>
				<th>姓名</th>
				<th>提交时间</th>
				<th>下载链接</th>
				<th>批改反馈</th>
				<th>批改状态</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			//if (empty($works->submissions)) {
			//echo "暂时没人提交作业！";
			//}
			//else{
			foreach ($work->submissions as $key => $value) {
				//print_r($work->submissions);
				echo '<tr>';
				echo '<td>' . $value->user->id . '</td>';
				echo '<td>' . $value->user->name . '</td>';
				echo '<td>' . $value->time . '</td>';
				echo '<td><a href="' . base_url('upload/' . $work->title . '/' . $work->hid . '/' . $value->file_name) . '">点击下载</a></td>';
				//echo '<td><input type="file" name="the_file" onchange=""></td>';
				echo '<td><a class="submit-label" data-id="' . $value->id . '">上传反馈</a></td>';
				echo '<td>';

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
	<table class="table table-hover">
		<thead>
			<tr>
				<th>学号</th>
				<th>姓名</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($work->not_submissions as $key => $value) {
				echo '<tr>';
				echo '<td>' . $value->sid . '</td>';
				echo '<td>' . $value->name . '</td>';
				//echo '<td>' . $value->class . '</td>';
			} ?>
		</tbody>
	</table>

	<script>
function homeworkSubmit(id)
{
	$("#homework-submit-button-"+id).click();
}
$(".submit-label").click(function(){
	var id = $(this).attr('data-id');
	$("#homework-submit-image-"+id).click();
})
</script>

<?php $this->load->view('footer'); ?>
