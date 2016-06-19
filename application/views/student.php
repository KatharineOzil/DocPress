<?php 
$this->load->view('header'); 
if (!$works) {
?>
<div class="login-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">Warning</h2>
  </div>
  <div class="mdl-card__supporting-text">
    还没有需要提交的作业哦
  </div>
  <div class="mdl-card__actions mdl-card--border">
    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="javascript:alert('你有病吧(╯°Д°)╯（ ┻━┻')">
      提醒老师发布作业
    </a>
  </div>
</div>
<?php
}
foreach ($works as $key => $work) {
?>

<div class="submit-homework-card mdl-card mdl-shadow--2dp <?php echo $work->done ? 'homework-done' : ''; ?>">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">
    <?php 
    echo $work->title;
    echo $work->done ? '(已完成)' : '(未完成)';
    ?></h2>
  </div>
  <div class="mdl-card__supporting-text">
    <small>
    <?php
    if ($work->ddl > 0) {
        echo "截止时间：" . date('Y-m-d', $work->ddl);
    } else {
        echo "截止时间：不限制";
    }
    ?></small><br><br>
    <?php
	echo str_replace("\n", "<br>", $work->content);
	if ($work->attachment) {
		echo '<br><br><small>附件下载：<a href="'. base_url('attachment/' . $work->attachment) . '">查看附件</a></small>';
	}
    ?>
  </div>
  <div class="mdl-card__actions mdl-card--border">
    <div class="hide">
      <form class="homework-submit" action="<?php echo site_url('welcome/submit_homework/' . $work->id); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="the_file" id="homework-submit-image-<?php echo $work->id; ?>" onChange="homeworkSubmit(<?php echo $work->id; ?>)">
        <input type="submit" id="homework-submit-button-<?php echo $work->id; ?>">
      </form>
    </div>
    <span class="mdl-navigation__link teacher-name"><i class="material-icons">account_circle</i>&nbsp;<?php echo $work->name; ?></span>
    <?php 
    if(isset($work->feedback_file) && $work->feedback_file)
        echo '<a class="mdl-navigation__link" href="'. base_url('reply/' . $work->id . '/' . $work->feedback_file) . '">(查看教师批改反馈)</a>'; 
    ?>
    <a class="mdl-navigation__link">

    <?php if ($work->ddl < time() && $work->ddl !=0) { ?>
          <button class="submit-label mdl-button mdl-js-button" disabled>停止上交</button>
    <?php } else { ?>
        <?php if (!$work->done) { ?>
          <button class="submit-label mdl-button mdl-js-button mdl-button--primary" data-id="<?php echo $work->id; ?>">上交作业</button>
        <?php } else { ?>
          <button class="submit-label mdl-button mdl-js-button <?php echo $work->done ? 'homework-done-button' : 'mdl-button--primary';?>" data-id="<?php echo $work->id; ?>">重新上交</button>
        <?php } ?>
    <?php } ?>
    </a>
</div>
</div>
<?php } ?>


<script>
function homeworkSubmit(id)
{
	$("#homework-submit-button-"+id).click();
}
$(".submit-label").click(function(){
	var id = $(this).attr('data-id');
	$("#homework-submit-image-"+id).click();
})
</script>

<?php $this->load->view('footer'); ?>
