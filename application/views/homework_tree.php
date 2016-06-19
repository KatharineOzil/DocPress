<?php $this->load->view('header'); ?>

<div class="homework-detail-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text"><?php echo $work->title?> 作业相似关系</h2>
  </div>

  <div class="mdl-card__supporting-text">
   <img src="<?php echo base_url("upload/DrawT/$work->id.svg")?>" style="width: 100%"/ onerror="$(this).hide();$(this).parent().text('暂时没有生成图片')">
  </div>
</div>
	
	
<?php $this->load->view('footer'); ?>
