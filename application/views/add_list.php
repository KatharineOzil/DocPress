<?php $this->load->view('header'); ?>

<div class="login-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text login-title">添加教师名单</h2>
  </div>
  <div class="mdl-card__supporting-text">
	姓名之间请用空格隔开，例如：AAA BBB
  </div>

  <div class="mdl-card__supporting-text">
    <form action="#" class="login-form">
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="user_list" name="user_list">
        <label class="mdl-textfield__label" for="user_list">教师名单</label>
      </div>
      <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
        确认
      </button>
    </form>
  </div>
</div>

<script>

$('.login-form').submit(function() {
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
