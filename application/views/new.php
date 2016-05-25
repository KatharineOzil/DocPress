<?php $this->load->view('header'); ?>

	<div class="col-xs-8 col-xs-offset-2">
		<h4>发布新作业</h4>
		<div class="row pbl">
			<div class="col-xs-5 col-xs-offset-2" id="level-switch">
	        	<input type="checkbox" checked data-toggle="switch" data-on-color="success" data-on-text="理论" data-off-text="实验" data-off-color="warning"/>
	        </div>
	    </div>

		<form class="form-horizontal" role="form" id="new-homework-form" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="homework-title" class="col-xs-2 control-label">课程名称</label>
				<div class="col-xs-10">
					<input type="text" class="form-control" id="homework-title" name="title">
				</div>
			</div>

			<div class="form-group">
				<label for="homework-type" class="col-xs-2 control-label" action="post">类型</label>
				&nbsp&nbsp&nbsp&nbsp
				<input id="1" type="radio" name="type" value="0" /> 理论课
				&nbsp&nbsp
				<input id="1" type="radio" name="type" value="1" /> 实践课
			</div>

	        <div class="form-group">
				<label for="homework-hid" class="col-xs-2 control-label">教学班</label>
				<div class="col-xs-10">
					<input type="text" class="form-control" id="homework-hid" name="hid">
				</div>
			</div>

			<div id="hid-tips"> 
				<div class="form-group">
					<label for="homework-content" class="col-xs-2 control-label">教学班说明</label>
					<div class="col-xs-10">
					同一门课程多个教学班请用“/”隔开。例如：
					<br/>
					A1234567/A2345678
					</div>
				</div>
			</div>

			<div id="tips"> 
				<div class="form-group">
					<label for="homework-content" class="col-xs-2 control-label">说明</label>
					<div class="col-xs-10">
					教务在线课表中实践课的教学班号请取网址中jxb=后面字符串，例如：
					<br/>
					“http://jwzx.cqupt.edu.cn/new/labkebiao/showjxbStuList.php?jxb=SJ06151942858”
					<br/>
					请输入"SJ06151942858"
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="homework-content" class="col-xs-2 control-label">描述</label>
				<div class="col-xs-10">
					<textarea class="form-control" id="homework-content" name="content" rows="1"></textarea>
				</div>
			</div>

			<div class="form-group">
				<label for="homework-attachment" class="col-xs-2 control-label">附件</label>
				<div class="col-xs-10">
					<input type="file" name="the_file" id="homework-attachment">
				</div>
			</div>

			<div class="form-group">
				<div class="col-xs-offset-2 col-xs-3">
					<button type="submit" class="btn btn-primary btn-wide">发布</button>
				</div>
			</div>
		</form>
	</div><!-- /.col-md-12: -->

<script>


$("#new-homework-form").submit( function() {
	$("#homework-title").parent().removeClass('has-error');
	$("#homework-hid").parent().removeClass('has-error');
	$("#homework-content").parent().removeClass('has-error');
	$("#homework-type").parent().removeClass('has-error');

	if ($("#homework-title").val() == "") {
		$("#homework-title").parent().addClass('has-error');
		return false;
	}
	if ($("#homework-hid").val() == "") {
		$("#homework-hid").parent().addClass('has-error');
		return false;
	}
	if ($("#homework-content").val() == "") {
		$("#homework-content").parent().addClass('has-error');
		return false;
	}

});

var levelSwitch = true;
$("#tips").hide();
$("#level-switch").click( function() {
	if (levelSwitch) {
		$("#tips").show();
		levelSwitch = false;
	} else {
		$("#tips").hide();
		levelSwitch = true;
	}
});



</script>
<?php $this->load->view('footer'); ?>
