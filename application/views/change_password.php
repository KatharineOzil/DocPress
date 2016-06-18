<?php $this->load->view('header'); ?>
<div class="login-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text login-title">修改密码</h2>
  </div>
  <div class="mdl-card__supporting-text">
    <form action="#" class="login-card-form">
      <div>
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="password" id="old_password" name="old_password">
        <label class="mdl-textfield__label" for="sid">旧密码</label>
      </div>
      </div>
      <div>
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="password" id="new_password" name="new_password">
        <label class="mdl-textfield__label" for="sid">新密码</label>
      </div>
      </div>
      <div>
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="password" id="confirm" name="confirm">
        <label class="mdl-textfield__label" for="sid">重复新密码</label>
      </div>
      </div>
      <div>
      <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
        修改密码
      </button>
      </div>
    </form>
  </div>
</div>

<script>
$(".login-card-form").submit( function() {
        $.post('<?php echo site_url("ajax/change_password"); ?>', $(this).serialize(), function(data, status) {
                alert(data);
		if (data == '密码修改成功，请重新登录')
		{	
			location.href = '<?php echo site_url('logout'); ?>';
		} else {
			location.href = '<?php echo site_url('change_password'); ?>';
		}
	})
        return false;
})
</script>

<?php $this->load->view('footer'); ?>
