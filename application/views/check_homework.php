<?php $this->load->view('header'); ?>


<div class="homework-detail-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text"><?php echo $work->title?> 作业检查情况</h2>
  </div>
  <div class="mdl-card__actions mdl-card--border">
    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="<?php echo site_url('homework_tree/' . $work->id); ?>">
      图形显示查重结果
    </a>
  </div>
  <div class="mdl-card__supporting-text">
    <pre><code><?php echo $result;?></code></pre>
  </div>

</div>


<?php $this->load->view('footer'); ?>
