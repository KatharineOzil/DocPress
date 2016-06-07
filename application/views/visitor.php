<?php $this->load->view('header3'); ?>


	<div class="col-xs-8 col-xs-offset-2">
		<div>
			<h6>说明：平台提供为游客演示的功能。请来访者在下方选择所要使用的身份。</h6>
		</div>
		<div class="row pbl">
		    <div class="col-xs-2 col-xs-offset-2">
				<div id="level-switch">
		       	<input type="checkbox" checked data-toggle="switch" data-on-color="success" data-on-text="学生" data-off-text="老师" data-off-color="warning"/>
		      	</div>
		      </div>
		</div>

		<div id="stu_visitor">
			<form class="form-horizontal" role="form" id="student-register-form">
				<div class="form-group">
					<div class="col-xs-10">
						<input type="hidden" class="form-control" id="student-sid" name="id" value="1">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-10">
						<input type="hidden" class="form-control" id="student-password" name="password" value="1">
					</div>
				</div>

				<input type="hidden" name="level" value="student">
				<div class="form-group">
					<div class="col-xs-offset-2 col-xs-3">
						<button type="submit" class="btn btn-primary btn-wide">登录</button>
					</div>
				</div>
			</form>
		</div>

		<div id="tea_visitor">
			<form class="form-horizontal" role="form" id="teacher-register-form">
				<div class="form-group">
					<div class="col-xs-10">
						<input type="hidden" class="form-control" id="teacher_name" name="name" value="1">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-10">
						<input type="hidden" class="form-control" id="teacher-password" name="password" value="1">
					</div>
				</div>
				<input type="hidden" name="level" value="teacher">
				<div class="form-group">
					<div class="col-xs-offset-2 col-xs-3">
						<button type="submit" class="btn btn-primary btn-wide">登录</button>
					</div>
				</div>
			</form>
		</div>

	</div>



<script>
var levelSwitch = true;
$("#tea_visitor").hide();
$("#level-switch").mousedown( function() {
	if (levelSwitch) {
		$("#stu_visitor").hide();
		$("#tea_visitor").show();
		levelSwitch = false;
	} else {
		$("#stu_visitor").show();
		$("#tea_visitor").hide();
		levelSwitch = true;
	}
});

$("#student-register-form").submit( function() {
	$.post('<?php echo site_url("ajax/v_login"); ?>', $(this).serialize(), function(data, status) {
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
	$.post('<?php echo site_url("ajax/v_login"); ?>', $(this).serialize(), function(data, status) {
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
