<?php $this->load->view('header'); ?>

<a href="<?php echo site_url('homework_tree/' . $work->id); ?>" class="btn btn-primary">图形显示查重结果</a>

	<h4><?php echo $work->title?> 作业检查情况</h4>
	<pre><code><?php echo $result;?></code></pre>

<?php $this->load->view('footer'); ?>
