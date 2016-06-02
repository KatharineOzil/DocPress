<?php $this->load->view('header2'); ?>

	<div class="col-xs-8 col-xs-offset-2">
		<h4>教师名单</h4>

		<div id="list">
			<form class="form-horizontal" role="form" id="list-form">
				<div class="form-group">
					<label for="" class="col-xs-2 control-label">教师名单</label>
					<div class="col-xs-10">
						<input type="text" class="form-control" id="user_list" name="user_list">
						姓名之间请用空格隔开<br/>
						例如：AAA BBB
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-offset-2 col-xs-3">
						<button type="submit" class="btn btn-primary btn-wide">确认</button>
					</div>
				</div>
			</form>
		</div>
		
	</div><!-- /.col-md-12: -->

<script>

$("#list-form").submit( function() {
	$("#user_list").parent().removeClass('has-error');

	if ($("#user_list").val() == "") {
		$("#user_list").parent().addClass('has-error');
		return false;
	}
	$.post('<?php echo site_url("ajax/teacher_list"); ?>', $(this).serialize(), function(data, status) {
		if (status == 'success') {
			alert(data);
			location.href = '<?php echo site_url(); ?>';
		}
	});
	return false;
});

</script>
<?php $this->load->view('footer'); ?>
