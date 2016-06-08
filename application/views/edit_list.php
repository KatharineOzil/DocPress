<?php $this->load->view('header'); ?>


<div class="login-card mdl-card mdl-shadow--2dp">
	<div class="mdl-card__title">
		<h2 class="mdl-card__title-text login-title">修改教师名单</h2>
	</div>
	<div class="mdl-card__supporting-text">
		<table class="mdl-data-table mdl-js-data-table detail-table">
			<thead>
				<tr>
					<th class="mdl-data-table__cell--non-numeric">教师姓名</th>
          <th class="mdl-data-table__cell--non-numeric">操作</th>
				</tr>
			</thead>
			<tbody>
        <?php foreach ($list as $k => $user) {;?>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $user->name;?></td>
          <td class="mdl-data-table__cell--non-numeric"><a href="<?php echo site_url('welcome/delete_teacher/').'/'.$user->name; ?>" onclick="return confirm('确定要删除吗？');">删除</a>
        </tr>
        <?php };?>
			</tbody>
		</table>
	</div>
</div>


<?php $this->load->view('footer'); ?>
