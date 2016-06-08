<?php $this->load->view('header'); ?>

<div class="login-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text login-title">学生登录</h2>
  </div>
  <div class="mdl-card__supporting-text">
    建议使用如 Chrome/Firefox/Opera 等浏览器，请不要使用 IE8 及 IE8 内核的浏览器，如 QQ/360 等浏览器。<br>
  </div>
  <div class="mdl-card__actions mdl-card--border login-card-form">
	<form action="#" class="login-form">
    <div>
  	  <div class="mdl-textfield mdl-js-textfield">
  	    <input class="mdl-textfield__input" type="text" id="username" name="username">
  	    <label class="mdl-textfield__label login-username" for="username">学号</label>
  	  </div>
    </div>
    <div>
     <div class="mdl-textfield mdl-js-textfield">
       <input class="mdl-textfield__input" type="password" id="password" name="password">
       <label class="mdl-textfield__label" for="password">密码</label>
     </div>
     <input type="hidden" value="student" name="level" class="login-type">
    </div>
    <div>
  	  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
  	  	登录
  	  </button>
  	  <a class="mdl-button mdl-js-button" href="<?php echo site_url('register'); ?>">
  	    注册
  	  </a>
  	  <a class="mdl-button mdl-js-button" href="<?php echo site_url('reset'); ?>">
  	    找回密码
  	  </a>
     </div>
	</form>
  </div>
  <div class="mdl-card__actions mdl-card--border">
  <span class="mdl-card__supporting-text">请点击右方 Menu 选择登录方式</span>
  </div>
  <div class="mdl-card__menu">
    <button id="demo-menu-lower-right"
	        class="mdl-button mdl-js-button mdl-button--icon">
	  <i class="material-icons">more_vert</i>
	</button>

	<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
	    for="demo-menu-lower-right">
	  <li class="mdl-menu__item student-login">学生登录</li>
	  <li class="mdl-menu__item teacher-login">教师登录</li>
    <li class="mdl-menu__item admin-login">管理员登录</li>
	</ul>
  </div>
</div>

<script>

$('.teacher-login').click(function() {
  $('.login-title').text('教师登录');
  $('.login-type').val('teacher');
  $('.login-username').text('姓名');
})

$('.student-login').click(function() {
  $('.login-title').text('学生登录');
  $('.login-type').val('student');
  $('.login-username').text('学号');
})

$('.admin-login').click(function() {
  $('.login-title').text('管理员登录');
  $('.login-type').val('admin');
  $('.login-username').text('账号');
})



$('.login-form').submit(function() {
  if ($('.login-type').val() == 'admin') {
    $.post('<?php echo site_url("ajax/admin"); ?>', $(this).serialize(), function(data, status) {
      if (status == 'success') {
        location.href = '<?php echo site_url(); ?>';
      }else{
        alert(data);
      }
    });
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
})
</script>
<?php $this->load->view('footer'); ?>
