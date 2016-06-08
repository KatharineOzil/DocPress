<?php $this->load->view('header'); ?>

<div class="login-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">找回密码</h2>
  </div>
  <div class="mdl-card__supporting-text">
    <form action="" class="login-card-form" method="post">
      <div>
        <div class="mdl-textfield mdl-js-textfield">
          <label class="mdl-textfield__label">个人信息</label>
          <input class="mdl-textfield__input" type="text" value="<?php echo $this->session->userdata['sid'];?>" disabled="disabled">
          <input type="hidden" class="form-control" value="<?php echo $this->session->userdata['token'];?>" name="token">
        </div>
      </div>
      <div>
        <div class="mdl-textfield mdl-js-textfield">
          <input class="mdl-textfield__input" type="password" id="password" name="password">
          <label class="mdl-textfield__label" for="password">新密码</label>
        </div>
      </div>
      <div>
        <div class="mdl-textfield mdl-js-textfield">
          <input class="mdl-textfield__input" type="password" id="password_confirm" name="password_confirm">
          <label class="mdl-textfield__label" for="password_confirm">新密码</label>
        </div>
      </div>
	  <div class="mdl-card__actions mdl-card--border">
	    <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
	      修改密码
	    </button>
	  </div>
    </form>
  </div>
</div>

<script>

$(".login-card-form").submit( function() {
	$.post('<?php echo site_url("ajax/reset_password"); ?>', $(this).serialize(), function(data, status) {
		alert(data);
		top.location = "index";
	})
	return false;
})
</script>

<?php $this->load->view('footer'); ?>
