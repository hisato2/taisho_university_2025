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

require_once('./files/config_db_taisho2025.php');
require_once('./common/function.php');


$ACTION = "select_sheet_practice.php";

require('./disp_parts/headerjs.php');



/*require('header_w.php');*/
require('data_keep.php');

$sta = "0";
$student_number = $_SESSION['STUDENT_NUMBER'];
$title = $_POST['title'];
$column = $_POST['column'];
$氏名 = $_SESSION['NAME'];
$かな = $_SESSION['KANA'];



tbl_status_check($_SESSION['STUDENT_NUMBER'], "4"); //学年は関係ない



switch ($column) {
  case "sch_sw1":
    $sta = $GLOBALS['sta_ssw1'];
    break;
  case "sch_sw2":
    $sta = $GLOBALS['sta_ssw2'];
    break;

  case "sch_mental1":
    $sta = $GLOBALS['sta_smental1'];
    break;
  case "sch_mental2":
    $sta = $GLOBALS['sta_smental2'];
    break;
  case "sch_advance":
    $sta = $GLOBALS['sta_sadv'];
    break;

  case "self_sw1":
    $sta = $GLOBALS['sta_jsw1'];
    break;
  case "self_sw2":
    $sta = $GLOBALS['sta_jsw2'];
    break;

  case "self_mental1":
    $sta = $GLOBALS['sta_jmental1'];
    break;
  case "self_mental2":
    $sta = $GLOBALS['sta_jmental2'];
    break;
  case "self_advance":
    $sta = $GLOBALS['sta_jadv'];
    break;
}

$実習種別 = $_POST['title'];

//配属情報テーブルを読む




$配属情報テーブルID = "";

$GLOBALS['配属情報テーブルID'] = "";
$GLOBALS['法人名'] = "";
$GLOBALS['施設名'] = "";
$GLOBALS['施設種別'] = "";
//$GLOBALS['学籍番号'] = "";

$GLOBALS['実習開始日'] = "";
$GLOBALS['実習終了日'] = "";

$GLOBALS['準備状況'] = "";
$GLOBALS['動機目的'] = "";
$GLOBALS['課題概要'] = "";

$GLOBALS['実習時期'] = "";
$GLOBALS['実習課題'] = "";
$GLOBALS['実習方法'] = "";
$GLOBALS['備考'] = "";

$GLOBALS['comments_of_teacher'] = "";


tbl_assignment_read2($student_number, $実習種別, "学生");


tbl_practice_plan_READ($student_number, $実習種別, "学生");



$study_area = "edit";

dsip_midashi("実習計画表");
dsip_koumoku($title);


form_submit("registration.php");
?>

<table class="mb-4 table-bordered border-secondary">
  <tr>
    <td height="40px" width="100px" class="fw700c">学籍番号:</td>
    <td width="200px" class="text-center"><?php echo $student_number; ?></td>
    <td width="100px" class="fw700c">氏名:</td>
    <td width="200px" class="text-center"><?php echo $氏名; ?></td>
    <td width="100px" class="fw700c">かな:</td>
    <td width="200px" class="text-center"><?php echo $かな; ?></td>
  </tr>
</table>

<table class="mb-4 table-bordered border-secondary">
  <tr>
    <td width="100px" class="fw700c">法人名:</td>
    <td width="300px">
      <?php _inputv("法人名", $法人名, "text", "edit", "", ""); ?>
    </td>
    <td width="150px" class="fw700c">実習施設・機関名:</td>
    <td width="300px">
      <?php _inputv("施設名", $施設名, "text", "edit", "", ""); ?>
    </td>
  </tr>
</table>


<table class="mb-4 table-bordered border-secondary">
  <tr>
    <td width="100px" class="fw700c">実施期間:</td>
    <td>

      <input name="実習開始日" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習開始日; ?> style="width:150px">
      <?php echo "～"; ?>
      <input name="実習終了日" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習終了日; ?> style="width:150px">


    </td>
  </tr>
</table>





<br>
<table class="table table-bordered border-secondary">
  <tr>
    <td><?php dsip_koumoku6("実習に関わるこれまでの準備状況"); ?></td>
  </tr>
  <tr>
    <td><?php _inputv("準備状況", $準備状況, "textarea", $study_area, "h200", "512"); ?></td>
  </tr>

  <tr>
    <td><?php dsip_koumoku6("実習の動機・目的"); ?></td>
  </tr>
  <tr>
    <td><?php _inputv("動機目的", $動機目的, "textarea", $study_area, "h200", "512"); ?></td>
  </tr>
  <tr>
    <td><?php dsip_koumoku6("実習課題"); ?></td>
  </tr>
  <tr>
    <td><?php _inputv("課題概要", $課題概要, "textarea", $study_area, "h200", "512"); ?></td>
  </tr>

</table>




<?php dsip_koumoku6("実習課題"); ?>

<table class="table table-bordered border-secondary">




  <tr>
    <td width="10%">時期(1024文字)</td>
    <td width="37%">実習課題(1024文字)</td>
    <td width="37%">学ぶための具体的方法(1024文字)</td>
    <td width="16%">備考(1024文字)</td>
  </tr>

  <tr>
    <td><?php _inputv("実習時期", $実習時期, "textarea", $study_area, "h400", "1024"); ?></td>
    <td><?php _inputv("実習課題", $実習課題, "textarea", $study_area, "h400", "1024"); ?></td>
    <td><?php _inputv("実習方法", $実習方法, "textarea", $study_area, "h400", "1024"); ?></td>
    <td><?php _inputv("備考", $備考, "textarea", $study_area, "h400", "1024"); ?></td>
  </tr>


</table>

<h6>教員からのコメント</h6>
<table class="table table-bordered border-secondary">
  <tr>
    <td><?php _inputv("comments_of_teacher", $comments_of_teacher, "textarea", "", "", "255"); ?></td>
  </tr>
</table>



<?php






$student_number = $_SESSION['STUDENT_NUMBER'];
$title = $_POST['title'];
$column = $_POST['column'];
$name = $_POST['name'];

?>




<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $_SESSION['STUDENT_NUMBER']; ?>">
<input type='hidden' name='SHEET_TITLE' value="<?PHP echo $_POST['title'];; ?>">



<input type='hidden' name='practice_plan_title' value="<?PHP echo $title; ?>">
<input type='hidden' name='TABLE' value="tbl_practice_plan">
<input type='hidden' name='METHOD' value="UP_DATE">



<input type='hidden' name='配属情報テーブルID' value="<?PHP echo $配属情報テーブルID; ?>">
<input type='hidden' name='施設種別' value="<?PHP echo $施設種別; ?>">
<input type='hidden' name='氏名' value="<?php echo $氏名; ?>">
<input type='hidden' name='かな' value="<?php echo $かな; ?>">



<p class="text-center">
  <?php echo "状態：" . $mr[$sta]; ?>
</p>
<?php
$sta = strval($sta);
?>

<table class="table">
  <tr>
    <td>
      <?php

      if (strpos(" 0 1 3", $sta) == true) {
        $dis = "";
      } else {
        $dis = "disabled";
      }
       btn_submit("下書き", "draft", $column, $dis);

      ?>
    </td>
    <td>
      <?php
      if (strpos(" 0 1 3", $sta) == true) {
        $dis = "";
      } else {
        $dis = "disabled";
      }
      btn_submit("提出", "submit", $column, $dis);
      ?>
    </td>

    <td>
      <?php btn_return("select_sheet_practice.php", "戻る"); ?>
    </td>
  </tr>
</table>
<?php

echo "</form>";

require('./disp_parts/footer.php');
exit;
?>