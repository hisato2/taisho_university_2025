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


$ACTION = "student_list.php";

require('./disp_parts/header.php');


/*require('header_w.php');*/
require('data_keep.php');




$sta = "0";
$student_number = $_SESSION['SEL_STUDENT_NUMBER'];
$title = $_SESSION['SEL_SHEET_TITLE'];
$column = $_SESSION['SEL_COLUMN'];

tbl_status_check($_SESSION['SEL_STUDENT_NUMBER'], "4"); //学年は関係ない





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

/*$_SESSION['EMAIL'] 
  $_SESSION['NAME'] 
  $_SESSION['KUBUN']
  $_SESSION['SEL_STUDENT_NUMBER'] 
  */



tbl_practice_plan_READ($student_number, $_SESSION['SEL_SHEET_TITLE'], "教員");

tbl_profile_READ($_SESSION['SEL_STUDENT_NUMBER']);


$実習種別 = $_SESSION['SEL_SHEET_TITLE'];
$種別 = $_SESSION['SEL_SHEET_TITLE']; //このことで良いと思う

$学籍番号 = $_SESSION['SEL_STUDENT_NUMBER'];
//$氏名 = $_SESSION['NAME'];


$study_area = "";


dsip_midashi("実習計画表（" . $name . "）");
dsip_koumoku($title);



form_submit("registration.php");

?>
<table class="table table-bordered border-secondary table_tunagi">

  <tr>
    <td width="100px" class="fw700c">学籍番号:</td>
    <td width="300px"><?php echo $student_number; ?></td>
    <td width="100px" class="fw700c">氏名:</td>
    <td><?php echo $氏名; ?></td>
    <td width="100px" class="fw700c">かな:</td>
    <td><?php echo $かな; ?> </td>

  </tr>

</table>
<table class="table  table-bordered border-secondary table_tunagi">

  <tr>
    <td width="100px" class="fw700c">法人名:</td>
    <td width="300px">
      <?php _inputv("法人名", $法人名, "text", "", "", "48"); ?>
    </td>
    <td width="150px" class="fw700c">実習施設・機関名:</td>
    <td width="300px">
      <?php _inputv("施設名", $施設名, "text", "", "", "48"); ?>
    </td>
  </tr>


</table>
<table class="table  table-bordered border-secondary table_tunagi">

  <tr>
    <td width="100px" class="fw700c">実施期間:</td>
    <td width="300px">
      <?php _inputv("実習開始日", $実習開始日, "text", "", "", ""); ?>


    </td>

    <td width="50px" class="fw700c">
      <?php echo "～"; ?>
    </td>

    <td width="300px">
      <?php _inputv("実習終了日", $実習終了日, "text", "", "", ""); ?>
    </td>

  </tr>
</table>

<br>
<table class="table table-bordered border-secondary">
  <tr>
    <td><?php dsip_koumoku6("実習に関わるこれまでの準備状況"); ?></td>
  </tr>
  <tr>
    <td><?php _inputv("準備状況", $準備状況, "textarea", $study_area, "h200", "255"); ?></td>
  </tr>

  <tr>
    <td><?php dsip_koumoku6("実習の動機・目的"); ?></td>
  </tr>
  <tr>
    <td><?php _inputv("動機目的", $準備状況, "textarea", $study_area, "h200", "255"); ?></td>
  </tr>
  <tr>
    <td><?php dsip_koumoku6("実習課題"); ?></td>
  </tr>
  <tr>
    <td><?php _inputv("課題概要", $課題概要, "textarea", $study_area, "h200", "255"); ?></td>
  </tr>

</table>



<?php dsip_koumoku6("実習課題"); ?>

<table class="table table-bordered border-secondary">




  <tr>
    <td width="10%" class="fw700c">時期</td>
    <td width="37%" class="fw700c">実習課題</td>
    <td width="37%" class="fw700c">学ぶための具体的方法</td>
    <td width="16%" class="fw700c">備考</td>
  </tr>

  <tr>
    <td><?php _inputv("実習時期", $実習時期, "textarea", $study_area, "h400", "255"); ?></td>
    <td><?php _inputv("実習課題", $実習課題, "textarea", $study_area, "h400", "255"); ?></td>
    <td><?php _inputv("実習方法", $実習方法, "textarea", $study_area, "h400", "255"); ?></td>
    <td><?php _inputv("備考", $備考, "textarea", $study_area, "h400", "255"); ?></td>
  </tr>


</table>

<h6>教員からのコメント <span class="fs80"></span></h6>
<table class="table table-bordered border-secondary">
  <tr>
    <td><?php _inputv("comments_of_teacher", $comments_of_teacher, "textarea", "edit", "", "255"); ?></td>
  </tr>
</table>



<?php




$student_number = $_SESSION['SEL_STUDENT_NUMBER'];
$title = $_SESSION['SEL_SHEET_TITLE'];
$column = $_SESSION['SEL_COLUMN'];

?>




<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $_SESSION['SEL_STUDENT_NUMBER']; ?>">
<input type='hidden' name='SHEET_TITLE' value="<?PHP echo $_SESSION['SEL_SHEET_TITLE'];; ?>">



<input type='hidden' name='practice_plan_title' value="<?PHP echo $title; ?>">
<input type='hidden' name='TABLE' value="tbl_practice_plan">
<input type='hidden' name='METHOD' value="COMMENT_UP">
<!--comments_of_teacher-->





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
      if (strpos(" 2 3 4 ",  $sta) == true) {
        $dis = "";
      } else {
        $dis = "disabled";
      }
      btn_submit("要修正", "fix", $column, $dis);
      ?>
    </td>

    <td>
      <?php

      if (strpos(" 2 3 4 ", $sta) == true) {
        $dis = ""; //承認できる
      } else {
        $dis = "disabled";
      }
      btn_submit("承認", "approve", $column, $dis);
      ?>
    </td>
    <td>
      <?php btn_return("student_list.php", "戻る"); ?>
    </td>

  </tr>
</table>

<?php
echo "</form>";


require('./disp_parts/footer.php');
exit;
?>