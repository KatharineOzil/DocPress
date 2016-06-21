<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($title) ? $title : 'DocPress 作业提交系统'; ?></title>
    <style type="text/css">
      @font-face {
        font-family: 'Material Icons';
        font-style: normal;
        font-weight: 400;
        src: url(<?php echo base_url('static');?>/icon/icon.eot); /* For IE6-8 */
        src: local('Material Icons'),
             local('MaterialIcons-Regular'),
             url(<?php echo base_url('static');?>/icon/icon.woff2) format('woff2'),
             url(<?php echo base_url('static');?>/icon/icon.woff) format('woff'),
             url(<?php echo base_url('static');?>/icon/icon.ttf) format('truetype');
      }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url('static'); ?>/mdl/material.min.css">

    <!-- Loading Flat UI -->
    <link rel="stylesheet" href="<?php echo base_url('static'); ?>/css/style.css">

    <link rel="shortcut icon" href="<?php echo base_url('static'); ?>/img/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url('static'); ?>/js/vendor/html5shiv.js"></script>
      <script src="<?php echo base_url('static'); ?>/js/vendor/respond.min.js"></script>
      <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url('static'); ?>/js/vendor/jquery.min.js"></script>
    <script src="<?php echo base_url('static'); ?>/mdl/material.min.js"></script>
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
            mdl-layout--fixed-header">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <div class="mdl-layout-spacer">
      <h4>DocPress 作业提交系统</h4>
      </div>
      <?php if (isset($this->session->userdata['id'])) { ?>
        <a href="<?php echo site_url('/');?>" class="mdl-navigation__link">
          <?php if ($this->session->userdata['level'] == 'admin') {
            echo 'admin';
          } else {
            echo $this->session->userdata['name'];
          } ?>
        </a>
      <?php } ?>
    </div>
  </header>
  <div class="mdl-layout__drawer">
    <span class="mdl-layout-title"></span>
    <nav class="mdl-navigation">
      <a class="mdl-navigation__link" href="<?php echo site_url('/');?>"><i class="material-icons">home</i>主页</a>
      <?php if (isset($this->session->userdata['level']) && $this->session->userdata['level'] == 'admin') { ?>
        <a class="mdl-navigation__link" href="<?php echo site_url('add_list'); ?>"><i class="material-icons">turned_in_not</i>添加教师名单</a>
        <a class="mdl-navigation__link" href="<?php echo site_url('edit_list'); ?>"><i class="material-icons">mode_edit</i>修改教师名单</a>
        <a class="mdl-navigation__link email-button" href="##"><i class="material-icons">settings</i>邮箱设置</a>
      <?php }?>
      <?php if (isset($this->session->userdata['id'])) { ?>
        <?php if (isset($this->session->userdata['level']) && $this->session->userdata['level'] == 'teacher') { ?>
          <a class="mdl-navigation__link" href="<?php echo site_url('old_homework'); ?>"><i class="material-icons">check_circle</i>到期作业</a>
        <?php }?>
        <?php if (isset($this->session->userdata['level']) && $this->session->userdata['level'] == 'teacher') { ?>
          <a class="mdl-navigation__link" href="<?php echo site_url('new'); ?>"><i class="material-icons">turned_in_not</i>发布作业</a>
        <?php }?>
        <?php if (isset($this->session->userdata['level']) && $this->session->userdata['level'] != 'admin') { ?>
          <a class="mdl-navigation__link" href="<?php echo site_url('change_password'); ?>"><i class="material-icons">mode_edit</i>修改密码</a></li>
        <?php }?>
      <a class="mdl-navigation__link" href="<?php echo site_url('logout'); ?>"><i class="material-icons">power_settings_new</i>注销</a></li>
      <?php } else { ?>
       <a class="mdl-navigation__link" href="<?php echo site_url('login');?>"><i class="material-icons">account_circle</i>登录</a>
       <a class="mdl-navigation__link" href="<?php echo site_url('register');?>"><i class="material-icons">perm_identity</i>注册</a>
       <a class="mdl-navigation__link" href="<?php echo site_url('reset');?>"><i class="material-icons">reply</i>找回密码</a> 
      <?php }?>
<!--	<div class="mdl-layout-spacer"></div>
	<p class="mdl-nav"><br>All content copyright 
	<br/>Katharine && Ricter 
	<br/>© 2016 • All rights reserved.</p>
-->    </nav>
  </div>
  <main class="mdl-layout__content">
    <div class="pagea-content">
