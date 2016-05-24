<?php $this->load->view('header'); ?>

	<div class="col-xs-8 col-xs-offset-2">
		<h4>找回密码</h4>
		<div>修改密码链接将发至校内邮箱。</div><br>
		<div id="register-student">
			<form class="form-horizontal" role="form" id="reset-form">
				<div class="form-group">
					<label for="student-sid" class="col-xs-2 control-label">信息</label>
					<div class="col-xs-10">
						<input type="text" class="form-control" id="student-sid" name="sid">
						说明：学生请输入学号；<br/>
						      教师请输入姓名。
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-offset-2 col-xs-3">
						<button type="submit" class="btn btn-primary btn-wide">找回</button>
					</div>
				</div>
			</form>
		</div>
	</div><!-- /.col-md-12 -->

<script>

$("#reset-form").submit( function() {
	$.post('<?php echo site_url("ajax/reset"); ?>', $(this).serialize(), function(data, status) {
		alert(data);
	})
	return false;
})
</script>

<?php $this->load->view('footer'); ?>
