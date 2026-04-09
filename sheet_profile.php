<?php
session_start();
if (!isset($_SESSION['EMAIL'])) {
  header("Location: index.php");
  exit;
}

function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

require_once('../../files/config_db_taisho2025.php');
require_once('./common/function.php');

$ACTION="select_sheet.php";
require('./disp_parts/header.php');
require('data_keep.php');







if (!isset($_POST['select_nen'])) {
  $_SESSION['SELECT_NEN'] = "1";
} else {
  $_SESSION['SELECT_NEN'] = intval($_POST['select_nen']);
}

$_SESSION['SELECT_NEN']=$_POST['select_nen'];

$student_number = $_SESSION['STUDENT_NUMBER'];
tbl_status_check($_SESSION['STUDENT_NUMBER'], $_SESSION['SELECT_NEN']);


$dis1 = "";
$dis2 = "";
$dis3 = "";
$dis4 = "";

switch ($_SESSION['SELECT_NEN']) {
  case "1":
    if (($GLOBALS['sta_prof']==4) or ($GLOBALS['sta_prof']==2)){
        $dis1 = "";
    }else{
        $dis1 = "edit";
    }
    break;
  case "2":
    if (($GLOBALS['sta_prof']==4) or ($GLOBALS['sta_prof']==2)){
        $dis2 = "";
    }else{
        $dis2 = "edit";
    }
    break;
  case "3":
    if (($GLOBALS['sta_prof']==4) or ($GLOBALS['sta_prof']==2)){
        $dis3= "";
    }else{
        $dis3 = "edit";
    }
    break;
  case "4":
    if (($GLOBALS['sta_prof']==4) or ($GLOBALS['sta_prof']==2)){
        $dis4= "";
    }else{
        $dis4 = "edit";
    }
    break;
}


//年度ごと
$sta = $GLOBALS['sta_prof'];
$sta = $GLOBALS['sta_go1Q'];
$sta = $GLOBALS['sta_go4Q'];
$sta = $GLOBALS['sta_rbas'];

//ここからは実習リフレクション
$sta = $GLOBALS['sta_rsw1'];
$sta = $GLOBALS['sta_rsw2'];
$sta = $GLOBALS['sta_rintern'];
$sta = $GLOBALS['sta_rmental1'];
$sta = $GLOBALS['sta_radv'];


//ここからは実習計画表の作成状態
$sta = $GLOBALS['sta_ssw1'];
$sta = $GLOBALS['sta_ssw2'];
$sta = $GLOBALS['sta_smental1'];
$sta = $GLOBALS['sta_smental2'];
$sta = $GLOBALS['sta_sadv'];

//ここからは自己評価表の作成状態
$sta = $GLOBALS['sta_jsw1']; //SW1自己評価
$sta = $GLOBALS['sta_jsw2']; //SW2自己評価
$sta = $GLOBALS['sta_jmental1'];
$sta = $GLOBALS['sta_jmental2'];
$sta = $GLOBALS['sta_jadv'];


tbl_profile_READ($_SESSION['STUDENT_NUMBER']);






dsip_midashi("プロフィール・シート　＜" . $_SESSION['SELECT_NEN'] . "年次＞");


//全学年次分読み込む
tbl_profile_detail_READ($student_number, 1);

$advanced_course1           = $advanced_course;
$roommate_club_activities1  = $roommate_club_activities;
$other_activities1          = $other_activities;
$affiliation_circle_campus1 = $affiliation_circle_campus;
$affiliation_circle_off_campus1 = $affiliation_circle_off_campus;

$training_overview1 = $training_overview;

$advanced_training_destination1 = $advanced_training_destination;
$internship_content1        = $internship_content;
$qualification1             = $qualification;
$sw_hope1                   = $sw_hope;
$psw_hope1                  = $psw_hope;
$adv_hope1                  = $adv_hope;
$things_to_consider1        = $things_to_consider;
$comments_of_teacher1       = $comments_of_teacher;


tbl_profile_detail_READ($student_number, 2);
$advanced_course2           = $advanced_course;
$roommate_club_activities2  = $roommate_club_activities;
$other_activities2          = $other_activities;
$affiliation_circle_campus2 = $affiliation_circle_campus;
$affiliation_circle_off_campus2 = $affiliation_circle_off_campus;
$training_overview2 = $training_overview;
$training_destination_12    = $training_destination_1;
$training_destination_22    = $training_destination_2;
$advanced_training_destination2 = $advanced_training_destination;
$internship_content2        = $internship_content;
$qualification2             = $qualification;
$sw_hope2                   = $sw_hope;
$psw_hope2                  = $psw_hope;
$adv_hope2                  = $adv_hope;
$things_to_consider2        = $things_to_consider;
$comments_of_teacher2       = $comments_of_teacher;


tbl_profile_detail_READ($student_number, 3);
$advanced_course3           = $advanced_course;
$roommate_club_activities3  = $roommate_club_activities;
$other_activities3          = $other_activities;
$affiliation_circle_campus3 = $affiliation_circle_campus;
$affiliation_circle_off_campus3 = $affiliation_circle_off_campus;

$training_overview3 = $training_overview;

$training_destination_13    = $training_destination_1;
$training_destination_23    = $training_destination_2;
$advanced_training_destination3 = $advanced_training_destination;
$internship_content3        = $internship_content;
$qualification3             = $qualification;
$sw_hope3                   = $sw_hope;
$psw_hope3                  = $psw_hope;
$adv_hope3                  = $adv_hope;
$things_to_consider3        = $things_to_consider;
$comments_of_teacher3       = $comments_of_teacher;

tbl_profile_detail_READ($student_number, 4);
$advanced_course4           = $advanced_course;
$roommate_club_activities4  = $roommate_club_activities;
$other_activities4          = $other_activities;
$affiliation_circle_campus4 = $affiliation_circle_campus;
$affiliation_circle_off_campus4 = $affiliation_circle_off_campus;

$training_overview4 = $training_overview;

$training_destination_14    = $training_destination_1;
$training_destination_24    = $training_destination_2;
$advanced_training_destination4 = $advanced_training_destination;
$internship_content4        = $internship_content;
$qualification4             = $qualification;
$sw_hope4                   = $sw_hope;
$psw_hope4                  = $psw_hope;
$adv_hope4                  = $adv_hope;
$things_to_consider4        = $things_to_consider;
$comments_of_teacher4       = $comments_of_teacher;


form_submit("registration.php");
?>
<table class="table table-bordered border-secondary">

<tr>
    <td width="20%"><span class="fw600">学生情報</span></td>
    <td width="20%" class="text-center"><span class="fw600">1年次</span></td>
    <td width="20%" class="text-center"><span class="fw600">2年次</span></td>
    <td width="20%" class="text-center"><span class="fw600">3年次</span></td>
    <td width="20%" class="text-center"><span class="fw600">4年次</span></td>
  </tr>


  <tr>
    <td width="20%"><span class="fw600">学担任教員名（ゼミ担当教員等）</span></td>
    <td width="20%" class="text-center"><?php echo $professor1;?></td>
    <td width="20%" class="text-center"><?php echo $professor2;?></td>
    <td width="20%" class="text-center"><?php echo $professor3;?></td>
    <td width="20%" class="text-center"><?php echo $professor4;?></td>
  </tr>


  <tr>
    <td><span class="fw600">室友会活動</span></td>
    <td><?php _inputv("roommate_club_activities1", $roommate_club_activities1, "textarea", $dis1, "h80","255"); ?></td>
    <td><?php _inputv("roommate_club_activities2", $roommate_club_activities2, "textarea", $dis2, "h80","255"); ?></td>
    <td><?php _inputv("roommate_club_activities3", $roommate_club_activities3, "textarea", $dis3, "h80","255"); ?></td>
    <td><?php _inputv("roommate_club_activities4", $roommate_club_activities4, "textarea", $dis4, "h80","255"); ?></td>

  </tr>

  <tr>
    <td><span class="fw600">室友会以外の社会福祉学科<br>での役割・活動</span></td>
    <td><?php _inputv("other_activities1", $other_activities1, "textarea", $dis1, "h80","255"); ?></td>
    <td><?php _inputv("other_activities2", $other_activities2, "textarea", $dis2, "h80","255"); ?></td>
    <td><?php _inputv("other_activities3", $other_activities3, "textarea", $dis3, "h80","255"); ?></td>
    <td><?php _inputv("other_activities4", $other_activities4, "textarea", $dis4, "h80","255"); ?></td>
  </tr>

  <tr>
    <td><span class="fw600">所属サークル・同好会（学内）</span></td>
    <td><?php _inputv("affiliation_circle_campus1", $affiliation_circle_campus1, "textarea", $dis1, "h80","255"); ?></td>
    <td><?php _inputv("affiliation_circle_campus2", $affiliation_circle_campus2, "textarea", $dis2, "h80","255"); ?></td>
    <td><?php _inputv("affiliation_circle_campus3", $affiliation_circle_campus3, "textarea", $dis3, "h80","255"); ?></td>
    <td><?php _inputv("affiliation_circle_campus4", $affiliation_circle_campus4, "textarea", $dis4, "h80","255"); ?></td>
  </tr>

  <tr>
    <td><span class="fw600">所属サークル・同好会（学外）</span></td>
    <td><?php _inputv("affiliation_circle_off_campus1", $affiliation_circle_off_campus1, "textarea", $dis1, "h80","255"); ?></td>
    <td><?php _inputv("affiliation_circle_off_campus2", $affiliation_circle_off_campus2, "textarea", $dis2, "h80","255"); ?></td>
    <td><?php _inputv("affiliation_circle_off_campus3", $affiliation_circle_off_campus3, "textarea", $dis3, "h80","255"); ?></td>
    <td><?php _inputv("affiliation_circle_off_campus4", $affiliation_circle_off_campus4, "textarea", $dis4, "h80","255"); ?></td>
  </tr>

  <tr>
    <td><span class="fw600">基礎ゼミナールⅠ・Ⅱ/<br>基礎実践・SW実習指導Ⅰ/<br>SW実習指導Ⅱ/<br>所属クラス</span></td>
    <td><?php _inputv("training_overview1", $training_overview1, "textarea", $dis1, "h80","255"); ?></td>
    <td><?php _inputv("training_overview2", $training_overview2, "textarea", $dis2, "h80","255"); ?></td>
    <td><?php _inputv("training_overview3", $training_overview3, "textarea", $dis3, "h80","255"); ?></td>
    <td><?php _inputv("training_overview4", $training_overview4, "textarea", $dis4, "h80","255"); ?></td>

  </tr>

  <tr>
    <td><span class="fw600">SW実習Ⅰの実習先</span></td>
    <td class="text-center"></td>
    <td><?php _inputv("training_destination_12", $training_destination_12, "textarea", $dis2, "h80","255"); ?></td>
    <td><?php _inputv("training_destination_13", $training_destination_13, "textarea", $dis3, "h80","255"); ?></td>
    <td><?php _inputv("training_destination_14", $training_destination_14, "textarea", $dis4, "h80","255"); ?></td>
  </tr>


  <tr>
    <td><span class="fw600">SW実習Ⅱの実習先</span></td>
    <td></td>
    <td><?php _inputv("training_destination_22", $training_destination_22, "textarea", $dis2, "h80","255"); ?></td>
    <td><?php _inputv("training_destination_23", $training_destination_23, "textarea", $dis3, "h80","255"); ?></td>
    <td><?php _inputv("training_destination_24", $training_destination_24, "textarea", $dis4, "h80","255"); ?></td>
  </tr>


<input type='hidden' name='advanced_training_destination1' value="">
<input type='hidden' name='advanced_training_destination2' value="">
<input type='hidden' name='advanced_training_destination3' value="">
<input type='hidden' name='advanced_training_destination4' value="">

<input type='hidden' name='advanced_course1' value="">
<input type='hidden' name='advanced_course2' value="">
<input type='hidden' name='advanced_course3' value="">
<input type='hidden' name='advanced_course4' value="">


  <tr>
    <td><span class="fw600">インターンシップ(教科)の<BR>活動内容</span></td>
    <td></td>

    <td><?php _inputv("internship_content2", $internship_content2, "textarea", $dis2, "h80","255"); ?></td>
    <td><?php _inputv("internship_content3", $internship_content3, "textarea", $dis3, "h80","255"); ?></td>
    <td><?php _inputv("internship_content4", $internship_content4, "textarea", $dis4, "h80","255"); ?></td>

  </tr>

  <tr>
    <td><span class="fw600">取得資格(外国語検定を含む)</span></td>
    <td><?php _inputv("qualification1", $qualification1, "textarea", $dis1, "h80","255"); ?></td>
    <td><?php _inputv("qualification2", $qualification2, "textarea", $dis2, "h80","255"); ?></td>
    <td><?php _inputv("qualification3", $qualification3, "textarea", $dis3, "h80","255"); ?></td>
    <td><?php _inputv("qualification4", $qualification4, "textarea", $dis4, "h80","255"); ?></td>
  </tr>

  <tr>
    <td><span class="fw600">社会福祉士受験資格の取得希望</span></td>

    <td><?php _inputv("sw_hope1", $sw_hope1, "textarea", $dis1, "h80","255"); ?></td>
    <td><?php _inputv("sw_hope2", $sw_hope2, "textarea", $dis2, "h80","255"); ?></td>
    <td><?php _inputv("sw_hope3", $sw_hope3, "textarea", $dis3, "h80","255"); ?></td>
    <td><?php _inputv("sw_hope4", $sw_hope4, "textarea", $dis4, "h80","255"); ?></td>
  </tr>

  <tr>
    <td><span class="fw600">精神保健福祉士受験資格の<br>取得希望</span></td>
    <td><?php _inputv("psw_hope1", $psw_hope1, "textarea",  $dis1, "h80","255"); ?></td>
    <td><?php _inputv("psw_hope2", $psw_hope2, "textarea",  $dis2, "h80","255"); ?></td>
    <td><?php _inputv("psw_hope3", $psw_hope3, "textarea",  $dis3, "h80","255"); ?></td>
    <td><?php _inputv("psw_hope4", $psw_hope4, "textarea",  $dis4, "h80","255"); ?></td>
  </tr>

  
<input type='hidden' name='adv_hope1' value="">
<input type='hidden' name='adv_hope2' value="">
<input type='hidden' name='adv_hope3' value="">
<input type='hidden' name='adv_hope4' value="">

  <tr>
    <td><span class="fw600">配慮を要する事項</span></td>

    <td><?php _inputv("things_to_consider1", $things_to_consider1, "textarea",  $dis1, "h80","255"); ?></td>
    <td><?php _inputv("things_to_consider2", $things_to_consider2, "textarea",  $dis2, "h80","255"); ?></td>
    <td><?php _inputv("things_to_consider3", $things_to_consider3, "textarea",  $dis3, "h80","255"); ?></td>
    <td><?php _inputv("things_to_consider4", $things_to_consider4, "textarea",  $dis4, "h80","255"); ?></td>

  </tr>



  <tr>
    <td><div  style="min-height:100px;"><span class="fw600">教員からのコメント</span></div></td>
    <td><?php echo $comments_of_teacher1; ?></td>
    <td><?php echo $comments_of_teacher2; ?></td>
    <td><?php echo $comments_of_teacher3; ?></td>
    <td><?php echo $comments_of_teacher4; ?></td>
  </tr>
  <tr>
</table>




<input type='hidden' name='TABLE' value="tbl_profile_detail">
<input type='hidden' name='METHOD' value="UP_DATE">
<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $_SESSION['STUDENT_NUMBER']; ?>">
<input type='hidden' name='SELECT_NEN' value="<?PHP echo  $_SESSION['SELECT_NEN'] ?>">

<br>
<br>

<p class="text-center">

<?php
  $GLOBALS['sta_prof']=strval($GLOBALS['sta_prof']);
  $column="profile_".$_SESSION['SELECT_NEN']
?>


  <?php echo "状態：" . $mr[$GLOBALS['sta_prof']]; ?>
</p>

<table class="table">
  <tr>
    <td>
      <?php

      if (strpos(" 0 1 3", $GLOBALS['sta_prof']) == true) {
                $dis = "";
            } else {
                $dis = "disabled";
            }
        btn_submit("下書き", "draft", $column, $dis);
      ?>
    </td>
    <td>
      <?php
      if (strpos(" 0 1 3", $GLOBALS['sta_prof']) == true) {
                $dis = "";
            } else {
                $dis = "disabled";
            }
      btn_submit("提出", "submit", $column, $dis);
      ?>
    </td>

    <td>
      <?php btn_return("select_sheet.php", "戻る"); ?>
    </td>
  </tr>
</table>
<?php


echo "</form>";

require('./disp_parts/footer.php');
exit;
?>