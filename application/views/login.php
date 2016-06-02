<?php $this->load->view('header1'); ?>

	<div class="col-xs-8 col-xs-offset-2">
		<h4>登录</h4>
		<div class="row pbl">
	        <div class="col-xs-2 col-xs-offset-2">
			<div id="level-switch">
	        	<input type="checkbox" checked data-toggle="switch" data-on-color="success" data-on-text="学生" data-off-text="老师" data-off-color="warning"/>
	        	</div>
		</div>
    	</div>
    	<div id="register-student">
			<form class="form-horizontal" role="form" id="student-register-form">
				<div class="form-group">
					<label for="student-sid" class="col-xs-2 control-label">学号</label>
					<div class="col-xs-10">
						<input type="text" class="form-control" id="student-sid" name="sid">
					</div>
				</div>
				<div class="form-group">
					<label for="student-password" class="col-xs-2 control-label">密码</label>
					<div class="col-xs-10">
						<input type="password" class="form-control" id="student-password" name="password">
					</div>
				</div>
				<input type="hidden" name="level" value="student">
				<div class="form-group">
					<div class="col-xs-offset-2 col-xs-3">
						<button type="submit" class="btn btn-primary btn-wide">登录</button>
					</div>
					<div class="col-xs-2">
						<a href="<?php echo site_url('register'); ?>" class="btn btn-default btn-wide">注册</a>
					</div>

					<div class="col-xs-offset-1 col-xs-1">
						<a href="<?php echo site_url('reset'); ?>" class="btn btn-default btn-wide">找回密码</a>
					</div>

				

				</div>
			</form>
		</div>
		<div id="register-teacher">
			<form class="form-horizontal" role="form" id="teacher-register-form">
				<div class="form-group">
					<label for="teacher-name" class="col-xs-2 control-label">姓名</label>
					<div class="col-xs-10">
						<input type="text" class="form-control" id="teacher-name" name="name">
					</div>
				</div>
				<div class="form-group">
					<label for="teacher-password" class="col-xs-2 control-label">密码</label>
					<div class="col-xs-10">
						<input type="password" class="form-control" id="teacher-password" name="password">
					</div>
				</div>
				<input type="hidden" name="level" value="teacher">
				<div class="form-group">
					<div class="col-xs-offset-2 col-xs-3">
						<button type="submit" class="btn btn-primary btn-wide">登录</button>
					</div>
					<div class="col-xs-2">
						<a href="<?php echo site_url('register'); ?>" class="btn btn-default btn-wide">注册</a>
					</div>
					<div class="col-xs-offset-1 col-xs-1">
						<a href="<?php echo site_url('reset'); ?>" class="btn btn-default btn-wide">找回密码</a>
					</div>
				</div>
			</form>
		</div>
	</div><!-- /.col-md-12 -->
	<div class="col-xs-10 col-xs-offset-3">
		<h6>Tips:建议使用如Chrome/firefox/opera等浏览器。</h6>
		<h6>请不要使用IE8及IE8内核的浏览器，如qq/360等浏览器.</h6>
	</div>
<script>
var levelSwitch = true;
$("#register-teacher").hide();
$("#level-switch").mousedown( function() {
	if (levelSwitch) {
		$("#register-student").hide();
		$("#register-teacher").show();
		levelSwitch = false;
	} else {
		$("#register-student").show();
		$("#register-teacher").hide();
		levelSwitch = true;
	}
});

$("#student-register-form").submit( function() {
	$("#student-sid").parent().removeClass('has-error');
	$("#student-password").parent().removeClass('has-error');

	if ($("#student-sid").val() == "") {
		$("#student-sid").parent().addClass('has-error');
		return false;
	}
	if ($("#student-password").val() == "") {
		$("#student-password").parent().addClass('has-error');
		return false;
	}

	$.post('<?php echo site_url("ajax/login"); ?>', $(this).serialize(), function(data, status) {
		if (status == 'success') {
			if (data == 'success') {
				location.href = '<?php echo site_url(); ?>';
			} else {
				alert(data);
			}
		}
	});
	return false;
});

$("#teacher-register-form").submit( function() {
	$("#teacher-password").parent().removeClass('has-error');
	$("#teacher-name").parent().removeClass('has-error');

	if ($("#teacher-password").val() == "") {
		$("#teacher-password").parent().addClass('has-error');
		return false;
	}
	if ($("#teacher-name").val() == "") {
		$("#teacher-name").parent().addClass('has-error');
		return false;
	}
	$.post('<?php echo site_url("ajax/login"); ?>', $(this).serialize(), function(data, status) {
		if (status == 'success') {
			if (data == 'success') {
				location.href = '<?php echo site_url(); ?>';
			} else {
				alert(data);
			}
		}
	});
	return false;
});
</script>
<?php $this->load->view('footer'); ?>
