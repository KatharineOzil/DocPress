<?php $this->load->view('header'); ?>


<div class="login-card mdl-card mdl-shadow--2dp">
	<div class="mdl-card__title">
		<h2 class="mdl-card__title-text login-title">修改教师名单</h2>
	</div>
	<div class="mdl-card__supporting-text">
		<table class="mdl-data-table mdl-js-data-table detail-table">
			<thead>
				<tr>
					<th class="mdl-data-table__cell--non-numeric">教师姓名</th>
          <th class="mdl-data-table__cell--non-numeric">操作</th>
				</tr>
			</thead>
			<tbody>
        <?php foreach ($list as $k => $user) {;?>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $user->name;?></td>
          <td class="mdl-data-table__cell--non-numeric"><a href="<?php echo site_url('welcome/delete_teacher/').'/'.$user->name; ?>" onclick="return confirm('确定要删除吗？');">删除</a>
        </tr>
        <?php };?>
			</tbody>
		</table>
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
