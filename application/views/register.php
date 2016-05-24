<?php $this->load->view('header'); ?>

	<div class="col-xs-8 col-xs-offset-2">
		<h4>注册</h4>
		<div class="row pbl">
	        <div class="col-xs-2 col-xs-offset-2" id="level-switch">
	        	<input type="checkbox" checked data-toggle="switch" data-on-color="success" data-on-text="学生" data-off-text="老师" data-off-color="warning"/>
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
				<div class="form-group">
					<label for="student-password" class="col-xs-2 control-label">重复密码</label>
					<div class="col-xs-10">
						<input type="password" class="form-control" id="student-password" name="password2">
					</div>
				</div>
				<div class="form-group">
					<label for="student-class" class="col-xs-2 control-label">班级</label>
					<div class="col-xs-10">
						<input type="text" class="form-control" id="student-class" name="class">
					</div>
				</div>
				<div class="form-group">
					<label for="student-name" class="col-xs-2 control-label">姓名</label>
					<div class="col-xs-10">
						<input type="text" class="form-control" id="student-name" name="name">
					</div>
				</div>
				
				<input type="hidden" name="level" value="student">
				<div class="form-group">
					<div class="col-xs-offset-2 col-xs-3">
						<button type="submit" class="btn btn-primary btn-wide">注册</button>
					</div>
					<div class="col-xs-2">
						<a href="<?php echo site_url('login'); ?>" class="btn btn-default btn-wide">登录</a>
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
                        		<label for="teacher-sid" class="col-xs-2 control-label">邮箱前缀</label>
                                        <div class="col-xs-10">
                                                <input type="text" class="form-control" id="teacher-sid" name="sid">
                                        说明：如wangm@cqupt.edu.cn
						请输入:wangm
					</div>
                                </div>
				<div class="form-group">
					<label for="teacher-password" class="col-xs-2 control-label">密码</label>
					<div class="col-xs-10">
						<input type="password" class="form-control" id="teacher-password" name="password">
					</div>
				</div>
				<div class="form-group">
					<label for="teacher-password" class="col-xs-2 control-label">重复密码</label>
					<div class="col-xs-10">
						<input type="password" class="form-control" id="teacher-password" name="password2">
					</div>
				</div>
				<input type="hidden" name="level" value="teacher">
				<div class="form-group">
					<div class="col-xs-offset-2 col-xs-3">
						<button type="submit" class="btn btn-primary btn-wide">注册</button>
					</div>
					<div class="col-xs-2">
						<a href="<?php echo site_url('login'); ?>" class="btn btn-default btn-wide">登录</a>
					</div>
				</div>
			</form>
		</div>
	</div><!-- /.col-md-12 -->

<script>
var levelSwitch = true;
$("#register-teacher").hide();
$("#level-switch").click( function() {
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
	$("#student-class").parent().removeClass('has-error');
	$("#student-name").parent().removeClass('has-error');
	
	if ($("#student-sid").val() == "") {
		$("#student-sid").parent().addClass('has-error');
		return false;
	}
	if ($("#student-password").val() == "") {
		$("#student-password").parent().addClass('has-error');
		return false;
	}
	if ($("#student-class").val() == "") {
		$("#student-class").parent().addClass('has-error');
		return false;
	}
	if ($("#student-name").val() == "") {
		$("#student-name").parent().addClass('has-error');
		return false;
	}
	

	$.post('<?php echo site_url("ajax/register"); ?>', $(this).serialize(), function(data, status) {
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
	$.post('<?php echo site_url("ajax/register"); ?>', $(this).serialize(), function(data, status) {
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
