<?php $this->load->view('header'); ?>

<div class="login-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text login-title">学生注册</h2>
  </div>
  <div class="mdl-card__supporting-text login-card-form">
	<form action="#" class="login-form">
    <div class="login-class-div">
     <div class="mdl-textfield mdl-js-textfield">
       <input class="mdl-textfield__input" type="text" id="class" name="class">
       <label class="mdl-textfield__label" for="class">班级</label>
     </div>
    </div>
    <div>
     <div class="mdl-textfield mdl-js-textfield">
       <input class="mdl-textfield__input" type="text" id="name" name="name">
       <label class="mdl-textfield__label" for="name">姓名</label>
     </div>
    </div>
    <div>
  	  <div class="mdl-textfield mdl-js-textfield">
  	    <input class="mdl-textfield__input" type="text" id="username" name="username">
  	    <input type="hidden" name="level" class="login-type" value="student">
  	    <label class="mdl-textfield__label login-username" for="username">学号</label>
  	  </div>
    </div>
    <div>
     <div class="mdl-textfield mdl-js-textfield">
       <input class="mdl-textfield__input" type="password" id="password" name="password">
       <label class="mdl-textfield__label" for="password">密码</label>
     </div>
    </div>
    <div>
     <div class="mdl-textfield mdl-js-textfield">
       <input class="mdl-textfield__input" type="password" id="password" name="password2">
       <label class="mdl-textfield__label" for="password">重复密码</label>
     </div>
    </div>
    <div>
      	<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
  	  	注册
  	  </button>
     </div>
	</form>
  </div>
  <div class="mdl-card__actions mdl-card--border">
  <span class="mdl-card__supporting-text">请点击右方 Menu 选择注册方式</span>
  </div>
  <div class="mdl-card__menu">
    <button id="demo-menu-lower-right"
	        class="mdl-button mdl-js-button mdl-button--icon">
	  <i class="material-icons">more_vert</i>
	</button>
	<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
	    for="demo-menu-lower-right">
	  <li class="mdl-menu__item student-login">学生注册</li>
	  <li class="mdl-menu__item teacher-login">教师注册</li>
	</ul>
  </div>
</div>

<script>
$('.teacher-login').click(function() {
  $('.login-title').text('教师注册');
  $('.login-username').text('邮箱前缀，如：shukx');
  $('.login-class-div').hide();
  $('.login-type').val('teacher');
})

$('.student-login').click(function() {
  $('.login-title').text('学生注册');
  $('.login-username').text('学号');
  $('.login-class-div').show();
  $('.login-type').val('student');
})


$('.login-form').submit(function() {
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
})
</script>
<?php $this->load->view('footer'); ?>
