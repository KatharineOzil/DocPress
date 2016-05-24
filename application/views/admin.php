<?php $this->load->view('header'); ?>

	<div class="col-xs-8 col-xs-offset-2">
		<h4>管理员登录</h4>
    	<div id="admin">
			<form class="form-horizontal" role="form" id="admin-form">
				<div class="form-group">
					<label for="id" class="col-xs-2 control-label">账号</label>
					<div class="col-xs-10">
						<input type="text" class="form-control" id="id" name="id">
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-xs-2 control-label">密码</label>
					<div class="col-xs-10">
						<input type="password" class="form-control" id="password" name="password">
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

	</div><!-- /.col-md-12 -->

<script>
$("#admin-form").submit( function() {
	$("#id").parent().removeClass('has-error');
	$("#password").parent().removeClass('has-error');

	if ($("#id").val() == "") {
		$("#id").parent().addClass('has-error');
		return false;
	}
	if ($("#password").val() == "") {
		$("#password").parent().addClass('has-error');
		return false;
	}
	$.post('<?php echo site_url("ajax/admin"); ?>', $(this).serialize(), function(data, status) {
		if (status == 'success') {
			location.href = '<?php echo site_url(); ?>';
		}else{
			alert(data);
		}
	});
	return false;
	
});

</script>
<?php $this->load->view('footer'); ?>
