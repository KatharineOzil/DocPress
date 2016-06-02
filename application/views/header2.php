<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <title><?php echo isset($title) ? $title : '作业提交系统'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>static/css/vendor/bootstrap.min.css">

    <!-- Loading Flat UI -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>static/css/flat-ui.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>static/css/style.css">

    <link rel="shortcut icon" href="<?php echo base_url('static'); ?>/img/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url('static'); ?>/js/vendor/html5shiv.js"></script>
      <script src="<?php echo base_url('static'); ?>/js/vendor/respond.min.js"></script>
      <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url('static'); ?>/js/vendor/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('static'); ?>/js/flat-ui.min.js"></script>

    <script src="<?php echo base_url('static'); ?>/js/application.js"></script>
</head>
<body>
    <div id="header" class="container">
        <nav class="navbar navbar-inverse navbar-lg" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-7">
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <a class="navbar-brand" href="#">作业提交</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-7">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo site_url(); ?>">首页</a></li>
                    <?php if (isset($this->session->userdata['id'])) { ?>
                        <li><a href="<?php echo site_url('logout'); ?>">注销</a></li>
                    <?php } ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#"><?php echo $this->session->userdata['level'] ?></a></li>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </div>
    <div id="container" class="container">
