<?php $this->load->view('header');
if (!$works) {
?>
<div class="login-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">Warning</h2>
  </div>
  <div class="mdl-card__supporting-text">
    还没有发布过作业
  </div>
  <div class="mdl-card__actions mdl-card--border">
    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="<?php echo site_url('new');?>">
      发布作业
    </a>
  </div>
</div>
<?php
}
foreach ($works as $key => $work) {
?>
<div class="homework-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text"><?php echo $work->title . "($work->hid)"; ?></h2>
  </div>
  <div class="mdl-card__supporting-text">
  	<?php echo $work->content; ?>
  </div>
  <div class="mdl-card__actions mdl-card--border">
    <a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" href="<?php echo site_url('homework_detail/' . $work->id); ?>">
    <?php echo $work->count; ?>人上交(共 <?php echo $work->total_count;?> 人)
    </a>
    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="<?php echo site_url('welcome/check_homework/' . $work->id); ?>">
      作业检查
    </a>
  </div>
  <div class="mdl-card__menu">
    <button id="menu-<?php echo $work->id;?>" class="mdl-button mdl-js-button mdl-button--icon">
    <i class="material-icons">more_vert</i>
  </button>

  <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
      for="menu-<?php echo $work->id;?>">
    <li class="mdl-menu__item student-login" onclick="if (confirm('确定要删除吗？')) {location.href='<?php echo site_url('welcome/delete_homework/' . $work->id);?>'};">
      <a class="mdl-navigation__link">删除</a>
    </li>
    <li class="mdl-menu__item student-login"><a class="mdl-navigation__link" href="<?php echo site_url('welcome/download/' . $work->id); ?>">
      打包下载
    </a></li>
  </ul>
  </div>
</div>
<?php } ?>

<?php $this->load->view('footer'); ?>
