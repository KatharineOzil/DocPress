<?php $this->load->view('header'); ?>

<div class="add-homework-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">发布新作业</h2>
  </div>
  <div class="mdl-card__supporting-text">
    <form action="" class="add-homework-form" method="post" enctype="multipart/form-data">
      <div>
        <div class="mdl-textfield mdl-js-textfield">
          <input class="mdl-textfield__input" type="text" id="title" name="title">
          <label class="mdl-textfield__label" for="title">课程名称</label>
        </div>
      </div>
      <div>
        <div class="mdl-textfield mdl-js-textfield">
          <textarea class="mdl-textfield__input" type="text" rows= "3" id="content" name="content"></textarea>
          <label class="mdl-textfield__label" for="content">作业描述</label>
        </div>
      </div>
      <div>
        <div class="mdl-textfield mdl-js-textfield">
          <input class="mdl-textfield__input" type="text" id="hid" name="hid">
          <label class="mdl-textfield__label" for="hid" id="hid-label">教学班</label>
        </div>
      </div>
    <div>
    已有教学班列表：
    <?php
    if (isset($hid)) {
        foreach ($hid as $_ => $h) {
            echo '<span class="mdl-button mdl-js-button mdl-js-ripple-effect h_class" id="' . $h->hid . '">' . $h->hid . '</span>';
            echo '<div class="mdl-tooltip" for="' . $h->hid . '">' . $h->title . '</div>';
        }
    }?>
    </div>
    <br>
      <div>
 	    <strong style="color: #000">注意：同一门课程请务必多个教学班一起添加，不然检查作业的时候隔班检查不到</strong><br>
        如果教学班列表中没有所需教学班，请自行添加。同一门课程多个教学班请用/隔开。例如：A1234567/A2345678<br>
      </div>
	<div class="mdl-data-table__cell--non-numeric">
	  <input type="file" name="the_file" >
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
$('#hid').bind('focus keypress keydown focusout', function() {
  if ($(this).val() == "") {
    $('#hid-label').text('教学班');
  }
})

$('.h_class').click(function() {
  var data = $('#hid').val();
  if (data) {
    data = data + '/' + $(this).text();
  } else {
    data = $(this).text();
  }
  $('#hid').val(data);
  $('#hid').focus();
  $('#hid-label').text('');
})
</script>
<?php $this->load->view('footer'); ?>
