<?php $this->load->view('header2'); ?>

	<a href="<?php echo site_url(); ?>" class="btn btn-default">返回</a>
	<h4> 教师列表</h4>

	<table class="table table-hover">
		<thead>
			<tr>
				<th>教师姓名</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>

			<?php foreach ($list as $k => $user) {;?>
			<tr>
				<td><?php echo $user->name;?></td>
				<td><a href="<?php echo site_url('welcome/delete_teacher/').'/'.$user->name; ?>" onclick="return confirm('确定要删除吗？');">删除</a>
			</tr>
			<?php };?>


		</tbody>
	</table>

<?php $this->load->view('footer'); ?>
