<?php $this->load->view('header'); ?>

	<div class="col-xs-8 col-xs-offset-2">
		<h4>找回密码</h4>
		<!--<div>密码将发至学校的学生邮箱。</div><br>-->
		<div id="register-student">
			<form class="form-horizontal" role="form" id="reset-form">
				<div class="form-group">
					<label for="student-sid" class="col-xs-2 control-label">个人信息</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" value="<?php echo $this->session->userdata['sid'];?>" disabled="disabled">
						<input type="hidden" class="form-control" value="<?php echo $this->session->userdata['token'];?>" name="token">
					</div>
				</div>
				<div class="form-group">
					<label for="student-sid" class="col-xs-2 control-label">新密码</label>
					<div class="col-xs-8">
						<input type="password" class="form-control" name="password">
					</div>
					<br/>
					<br/>
					<label for="student-sid" class="col-xs-2 control-label">重复密码</label>
					<div class="col-xs-8">
						<input type="password" class="form-control" name="password_confirm">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-offset-4 col-xs-3">
						<button type="submit" class="btn btn-primary btn-wide">修改</button>
					</div>
				</div>
			</form>
		</div>
	</div><!-- /.col-md-12 -->

<script>

$("#reset-form").submit( function() {
	$.post('<?php echo site_url("ajax/reset_password"); ?>', $(this).serialize(), function(data, status) {
		alert(data);
		top.location = "index";
		
	})
	return false;
})
</script>

<?php $this->load->view('footer'); ?>
