<?php $this->load->view('header'); ?>
<div class="login-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text login-title">找回密码</h2>
  </div>
  <div class="mdl-card__supporting-text">
  修改密码链接将发至校内邮箱，学生请输入学号，教师请输入学校邮箱开头，如：shukx
  </div>
  <div class="mdl-card__supporting-text">
    <form action="#" class="login-form">
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="sid" name="sid">
        <label class="mdl-textfield__label" for="sid">学号或姓名拼音</label>
      </div>
      <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
        找回
      </button>
    </form>
  </div>
</div>

<script>
$(".login-form").submit( function() {
	$.post('<?php echo site_url("ajax/reset"); ?>', $(this).serialize(), function(data, status) {
		alert(data);
	})
	return false;
})
</script>

<?php $this->load->view('footer'); ?>
