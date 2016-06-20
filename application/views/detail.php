<?php $this->load->view('header'); ?>

<div class="homework-detail-card mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h4 class="mdl-card__title-text">作业详情</h4>
    <a class="mdl-navigation__link" href="<?php echo site_url('/'); ?>" class="btn btn-default"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect homework-detail-button">返回</button></a>
    <a class="mdl-navigation__link" href="<?php echo site_url('check_homework/' . $work->id); ?>" class="btn btn-primary"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect homework-detail-button">作业查重</button></a>
    <a class="mdl-navigation__link" href="javascript:save_score()" class="btn btn-default"><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored homework-detail-button">保存成绩</button></a>
    <a class="mdl-navigation__link" href="<?php echo site_url('welcome/down_score/' . $work->id); ?>" class="btn btn-default"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect homework-detail-button">
      成绩下载
    </button></a>

  </div>
  <div class="mdl-card__supporting-text detail-table-container">

	<?php
	if (empty($work->submissions)){
		echo "当前没有人提交作业！";
	} else {
	?>
    <h4 class="mdl-card__title-text">
        <?php echo $work->title; ?> 提交列表
    </h4>
	<table class="mdl-data-table mdl-js-data-table detail-table">
		<thead>
			<tr>
				<th class="mdl-data-table__cell--non-numeric">姓名（学号）</th>
				<th class="mdl-data-table__cell--non-numeric">教学班号</th>
				<th class="mdl-data-table__cell--non-numeric">提交时间</th>
				<th class="mdl-data-table__cell--non-numeric">反馈</th>
				<th class="mdl-data-table__cell--non-numeric">下载</th>
				<th class="mdl-data-table__cell--non-numeric">评分</th>
			</tr>
		</thead>
		<tbody>
			<?php 
        foreach ($work->submissions as $key => $value) {
				$hwid = explode('_', $value->file_name);
				$hid = $hwid[0];
				echo '<tr>';
				echo '<td class="mdl-data-table__cell--non-numeric">' . $value->user->name . ' (' . $value->user->id . ')</td>';
				echo '<td class="mdl-data-table__cell--non-numeric">' . $hid . '</td>';
				echo '<td class="mdl-data-table__cell--non-numeric">' . str_replace(' 00:00:00', '', $value->submit_time) . '</td>';
				if($value->feedback_file) {
				    echo '<td class="mdl-data-table__cell--non-numeric"><a href="##" class="submit-label-feedback mdl-navigation__link" data-id="' . $value->id . '"><i class="material-icons">done</i></a></td>';
				} else {
				    echo '<td class="mdl-data-table__cell--non-numeric"><a href="##" class="submit-label-feedback mdl-navigation__link" data-id="' . $value->id . '">上传</a></td>';
				}
                echo '<td class="mdl-data-table__cell--non-numeric"><a class="mdl-navigation__link" href="' . base_url('upload/' . $work->id . '/' . $value->file_name) . '"><i class="material-icons">arrow_downward</i></a></td>';
            ?>
            <td class="mdl-data-table__cell--non-numeric">
                <div class="mdl-textfield mdl-js-textfield score-div">
                <input class="mdl-textfield__input score-div-input" tabindex=1 type="text" pattern="(:?[0-9]{1,2}|100)" id="<?php echo $value->user->id;?>" name="score[<?php echo $value->user->id;?>]" value="<?php echo $value->score; ?>">
                    <span class="mdl-textfield__error score-div-span">成绩必须是数字且在 0-100 之间</span>
                </div>
            </td>
            <div class="hide">
				<form class="homework-submit" action="<?php echo site_url('welcome/submit_feedback/' . $value->id); ?>" method="post" enctype="multipart/form-data">
					<input type="file" name="the_file" id="homework-submit-image-<?php echo $value->id; ?>" onChange="homeworkSubmit(<?php echo $value->id; ?>)">
					<input type="submit" id="homework-submit-button-<?php echo $value->id; ?>">
				</form>
            </div>
            </tr>
			<?php }}?>

		</tbody>
    </table>

	<h4><?php echo $work->title; ?> 未提交列表</h4>
	<table class="mdl-data-table mdl-js-data-table detail-table">
		<thead>
			<tr>
				<th class="mdl-data-table__cell--non-numeric">姓名（学号）</th>
				<th class="mdl-data-table__cell--non-numeric">教学班号</th>
				<th class="mdl-data-table__cell--non-numeric">姓名（学号）</th>
				<th class="mdl-data-table__cell--non-numeric">教学班号</th>
			</tr>
		</thead>
		<tbody>
        <?php
            $i = 0;
            foreach ($work->not_submissions as $key => $value) {
                if ($i % 2 == 0) {
                    echo '<tr>';
                    echo '<td class="mdl-data-table__cell--non-numeric">' . $value->name . ' (' . $value-> sid . ')</td>';
                    echo '<td class="mdl-data-table__cell--non-numeric">' . $value->hid . '</td>';
                } else {
                    echo '<td class="mdl-data-table__cell--non-numeric">' . $value->name . ' (' . $value-> sid . ')</td>';
                    echo '<td class="mdl-data-table__cell--non-numeric">' . $value->hid . '</td>';
                    echo '</tr>';
                }
                $i++;
            }
            if ($i % 2 == 1) {
                echo '<td></td><td></td></tr>';
            }
         ?>
		</tbody>
	</table>
  </div>
</div>
<script>
function homeworkSubmit(id)
{
	$("#homework-submit-button-"+id).click();
}
$(".submit-label-feedback").click(function(){
	var id = $(this).attr('data-id');
	$("#homework-submit-image-"+id).click();
})

function save_score() {
    var url = '<?php echo site_url('ajax/save_score/' . $work->id);?>';
    var inputs = $('.score-div-input');
    var score_arr = [].map.call(inputs, function (input) {
        var input = $(input);
        var name = input.attr('name');
        var score = input.val();
        if (score != "") {
            return name + '=' + score;
        }
    })
    var post_arr = [];
    for (var i=0; i<score_arr.length; i++) {
        if (score_arr[i] != undefined) {
            post_arr.push(score_arr[i]);
        }
    }
    if (post_arr.length != 0) {
        $.post(url, post_arr.join('&'), function (data) {
            alert(data);
        });
    } else {
        alert('还没有任何评分需要保存');
    }
}
</script>

<?php $this->load->view('footer'); ?>
