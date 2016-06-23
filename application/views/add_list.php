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
<dialog class="mdl-dialog email">
<h4 class="mdl-dialog__title">邮箱设置</h4>
<div class="mdl-dialog__content">
  <p>
       修改发件邮箱账号、密码以及 SMTP 服务器。
  </p>
  <form action="#" id="email-setting">
      <div class="mdl-textfield mdl-js-textfield">
      <input class="mdl-textfield__input" type="text" id="smtp" name="smtp" value="<?php echo $email['smtp'];?>">
        <label class="mdl-textfield__label" for="smtp">smtp 服务器</label>
      </div>
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="email" name="email" value="<?php echo $email['email'];?>">
        <label class="mdl-textfield__label" for="email">发件箱</label>
      </div>
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="password" id="password" name="password" value="<?php echo $email['password'];?>">
        <label class="mdl-textfield__label" for="password">密码</label>
      </div>
  </form>
</div>
<div class="mdl-dialog__actions">
  <button type="button" class="mdl-button save">保存</button>
  <button type="button" class="mdl-button close">关闭</button>
</div>
</dialog>

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

function model_register(button, dialog, close) {
    if (!dialog.showModal) {
        dialogPolyfill.registerDialog(dialog);
    }
    button.addEventListener('click', function() {
        dialog.showModal();
    });
    close.addEventListener('click', function() {
        dialog.close();
    })
}

var button = document.querySelector('.email-button');
var dialog = document.querySelector('.email');
var close = document.querySelector('.close');
model_register(button, dialog, close);

$('.save').click(function() {
    var data = $('#email-setting').serialize();
    $.post("<?php echo site_url('/ajax/set_email'); ?>", data, function (resp) {
        alert(resp);
        dialog.close();
    });
})
</script>
<?php $this->load->view('footer'); ?>
