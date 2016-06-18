<?php $this->load->view('header'); ?>

<div class="homework-detail-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text"><?php echo $work->title?> 作业检查情况&nbsp;&nbsp;</h2>
	<div>
	<input class="mdl-slider mdl-js-slider" type="range" id="s1" min="10" max="100" value="10" step="10">
	<br>
	准确&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;灵敏
	</div>
	<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="check_homework()">
	  开始检查
	</button>&nbsp;&nbsp;
    <div class="mdl-spinner mdl-js-spinner is-active check-load image-load-none"></div>
  </div>
  <div class="mdl-card__supporting-text">
	至少 3 个作业以上才可以生成图片查重结果。
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
	$.get("<?php echo site_url('welcome/ajax_check_homework/' . $work->id);?>",
	      function(data, status) {
		  $('#result').text(data);
		  $('.check-load').hide();
	      }
	)
}

function homework_tree() {
        $('.image-load-display').removeClass('image-load-none');
	$.get("<?php echo site_url('welcome/ajax_homework_tree/' . $work->title);?>",
	function (data, status) {
		alert(data);
		location.href = "<?php echo site_url('welcome/homework_tree/' . $work->id);?>";
	}
	)
}
</script>

<?php $this->load->view('footer'); ?>
