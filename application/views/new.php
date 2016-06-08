<?php $this->load->view('header'); ?>

<div class="add-homework-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">发布新作业</h2>
  </div>
  <div class="mdl-card__supporting-text">
    <form action="" class="add-homework-form" method="post">
      <div>
        <div class="mdl-textfield mdl-js-textfield">
          <input class="mdl-textfield__input" type="text" id="title" name="title">
          <label class="mdl-textfield__label" for="title">课程名称</label>
        </div>
      </div>
      <div>
        <span>同一门课程多个教学班请用/隔开。例如：A1234567/A2345678</span>
        <div class="mdl-textfield mdl-js-textfield">
          <input class="mdl-textfield__input" type="text" id="hid" name="hid">
          <label class="mdl-textfield__label" for="hid">教学班</label>
        </div>
      </div>
      <div>
          教务在线课表中实践课的教学班号请取网址中jxb=后面字符串，例如：<br>
          <pre>http://jwzx/new/labkebiao/showjxbStuList.php?jxb=SJ06151942858”</pre>
          请输入"SJ06151942858"
      </div>
      <div>
        <div class="mdl-textfield mdl-js-textfield">
          <textarea class="mdl-textfield__input" type="text" rows= "3" id="content" name="content"></textarea>
          <label class="mdl-textfield__label" for="content">作业描述</label>
        </div>
      </div>
    </form>
  </div>
  <div class="mdl-card__actions mdl-card--border">
    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect add-homework">
      发布作业
    </a>
  </div>
</div>

<script>
$('.add-homework').click(function() {
  $('.add-homework-form').submit();
})

$('.add-homework-form').submit(function() {
	if ($('#title').val() == '') {
    alert('请将信息填写完整');
		return false;
	}
	if ($('#hid').val() == '') {
    alert('请将信息填写完整');
		return false;
	}
	if ($('#content').val() == '') {
    alert('请将信息填写完整');
		return false;
	}
  return true;
});
</script>
<?php $this->load->view('footer'); ?>
