<?php $this->load->view('header'); ?>

<div class="homework-detail-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text"><?php echo $work->title?> 作业检查情况&nbsp;&nbsp;</h2>
    <a class="mdl-navigation__link" href="javascript:history.go(-1)" class="btn btn-default"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect homework-detail-button">返回</button></a>
	<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="check_homework()">
	  开始检查
    </button>&nbsp;&nbsp;
    <div class="mdl-spinner mdl-js-spinner is-active check-load image-load-none"></div>
  </div>
  <div class="mdl-card__supporting-text">
    至少 3 个作业以上才可以生成图片查重结果。<br><br>
    灵敏度设置：
   <div class="process-container">
    准确
    <div class="process-bar">
      <input class="mdl-slider mdl-js-slider" id="range" type="range" min="10" max="100" value="10" tabindex="0" name="range">
    </div>
    灵敏
   </div>
    <br>
    <br>
  </div>
  <div class="mdl-card__actions mdl-card--border">
    <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect image-link" onclick="homework_tree()">
      生成图片查重结果
    </button>
    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="<?php echo site_url('welcome/homework_tree/' . $work->id);?>">
      查看图片查重结果
    </a>
    <div class="mdl-spinner mdl-js-spinner is-active image-load-none image-load-display"></div>
  </div>
  <div class="mdl-card__supporting-text">
    <pre><code id="result"></code></pre>
  </div>

</div>

<script>
function check_homework() {
    $('.check-load').removeClass('image-load-none');
    var url = "<?php echo site_url('welcome/ajax_check_homework/' . $work->id);?>";
    url += "?range=" + $("#range").val();
    $('#result').text('请等待...');
    $.get(url,
          function(data, status) {
              $('#result').text(data);
              $('.check-load').hide();
             $('.check-load').addClass('image-load-none');
          }
    )
}

function homework_tree() {
    $('.image-load-display').removeClass('image-load-none');
	$.get("<?php echo site_url('welcome/ajax_homework_tree/' . $work->id);?>",
	function (data, status) {
		alert(data);
		location.href = "<?php echo site_url('welcome/homework_tree/' . $work->id);?>";
	}
	)
}
</script>

<?php $this->load->view('footer'); ?>
