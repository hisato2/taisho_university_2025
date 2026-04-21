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
  case "sta_adv":
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


tbl_self_assessment_READ($student_number, $_SESSION['SEL_SHEET_TITLE'], "教員");

tbl_profile_READ($student_number);
$氏名 = $GLOBALS['name'];
$かな = $GLOBALS['kana'];


require_once('./common/target.php');





if ($column == "self_sw1") {
  $評価項目1 = SW1_TARGET_01;
  $評価項目2 = SW1_TARGET_02;
  $評価項目3 = SW1_TARGET_03;
  $評価項目4 = SW1_TARGET_04;
  $評価項目5 = SW1_TARGET_05;
  $評価項目6 = SW1_TARGET_06;
  $評価項目7 = SW1_TARGET_07;
  $評価項目8 = SW1_TARGET_08;
  $評価項目9 = SW1_TARGET_09;
  $評価項目10 = SW1_TARGET_10;
  $評価項目11 = SW1_TARGET_11;
  $評価項目12 = SW1_TARGET_12;
}

if ($column == "self_sw2") {
  $評価項目1 = SW2_TARGET_01;
  $評価項目2 = SW2_TARGET_02;
  $評価項目3 = SW2_TARGET_03;
  $評価項目4 = SW2_TARGET_04;
  $評価項目5 = SW2_TARGET_05;
  $評価項目6 = SW2_TARGET_06;
  $評価項目7 = SW2_TARGET_07;
  $評価項目8 = SW2_TARGET_08;
  $評価項目9 = SW2_TARGET_09;
  $評価項目10 = SW2_TARGET_10;
  $評価項目11 = SW2_TARGET_11;
  $評価項目12 = SW2_TARGET_12;
}





if ($column == "self_mental1") {

  $評価項目1 = SWLF_MENTAL1_01;
  $評価項目2 = SWLF_MENTAL1_02;
  $評価項目3 = SWLF_MENTAL1_03;
  $評価項目4 = SWLF_MENTAL1_04;
  $評価項目5 = SWLF_MENTAL1_05;
  $評価項目6 = SWLF_MENTAL1_06;
  $評価項目7 = SWLF_MENTAL1_07;
  $評価項目8 = SWLF_MENTAL1_08;
  $評価項目9 = SWLF_MENTAL1_09;
  $評価項目10 = SWLF_MENTAL1_10;
  $評価項目11 = SWLF_MENTAL1_11;
  $評価項目12 = SWLF_MENTAL1_12;
}
if ($column == "self_mental2") {
  $評価項目1 = SWLF_MENTAL2_01;
  $評価項目2 = SWLF_MENTAL2_02;
  $評価項目3 = SWLF_MENTAL2_03;
  $評価項目4 = SWLF_MENTAL2_04;
  $評価項目5 = SWLF_MENTAL2_05;
  $評価項目6 = SWLF_MENTAL2_06;
  $評価項目7 = SWLF_MENTAL2_07;
  $評価項目8 = SWLF_MENTAL2_08;
  $評価項目9 = SWLF_MENTAL2_09;
  $評価項目10 = SWLF_MENTAL2_10;
  $評価項目11 = SWLF_MENTAL2_11;
  $評価項目12 = SWLF_MENTAL2_12;
}



$総合評価項目 = "総合評価（上記の評価を踏まえて、評定すること）";






/*$_SESSION['EMAIL']
  $_SESSION['NAME']
  $_SESSION['KUBUN']
  $_SESSION['SEL_STUDENT_NUMBER']
  */




$実習種別 = $_SESSION['SEL_SHEET_TITLE'];
//$種別 = $_SESSION['SEL_SHEET_TITLE']; //このことで良いと思う
$学籍番号 = $_SESSION['SEL_STUDENT_NUMBER'];


$氏名表記 = $氏名 . "（" . $かな . "）";



if ($実習開始日 <> "") {
  $実習開始日 = date('Y年m月d日', strtotime($実習開始日));
}
if ($実習終了日 <> "") {
  $実習終了日 = date('Y年m月d日', strtotime($実習終了日));
}

$study_area = "";

$student_number = $_SESSION['SEL_STUDENT_NUMBER'];
$title = $_SESSION['SEL_SHEET_TITLE'];
$column = $_SESSION['SEL_COLUMN'];


$cnt = 0;


dsip_midashi("自己評価表（" . $氏名 . "）");
dsip_koumoku($title);



form_submit("registration.php");



?>




<table class="table table-bordered border-secondary">

  <tr>
    <td rowspan=2 width="10%" class="table_komoku">Ⅰ 実習生</td>
    <td rowspan=2 width="36%" class="table_komoku2">社会福祉学科</td>
    <td width="10%" class="table_komoku">学籍番号</td>
    <td colspan=3 width="44%" class="table_komoku">氏名（ふりがな）</td>
  </tr>

  <tr>
    <td width="10%" class="table_komoku2"><?php _inputv("学籍番号", $学籍番号, "text", "", "", ""); ?></td>
    <td colspan=3 width="44%" class="table_komoku2"><?php _inputv("氏名", $氏名表記, "text", "", "", ""); ?></td>
  </tr>
</table>



<table class="table table-bordered border-secondary">
  <tr>
    <td rowspan=2 width="10%" class="table_komoku">Ⅱ 実習先</td>
    <td width="30%" class="table_komoku">法人名</td>
    <td width="30%" class="table_komoku">施設名</td>
    <td width="30%" class="table_komoku">施設種別</td>
  </tr>

  <tr>




    <td class="table_komoku2"><?php echo "<input type='hidden' name='法人名' value='" . $法人名 . "'>";
                              echo nl2br($法人名); ?></td>
    <td class="table_komoku2"><?php echo "<input type='hidden' name='施設名' value='" . $施設名 . "'>";
                              echo nl2br($施設名); ?></td>
    <td class="table_komoku2"><?php echo "<input type='hidden' name='施設種別' value='" . $施設種別 . "'>";
                              echo nl2br($法人名); ?></td>
  </tr>
</table>




<table class="table table-bordered border-secondary">
  <tr>
    <td rowspan=2 width="10%" class="table_komoku">Ⅲ 実習先<br>責任者</td>
    <td colspan=2 width="45%" class="table_komoku">施設・機関長氏名</td>
    <td colspan=2 width="45%" class="table_komoku">実習指導者氏名</td>
  </tr>


  <tr>
    <td class="table_komoku2"><?php _inputv("実習先責任者", $実習先責任者, "text", "", "", ""); ?></td>
    <td class="table_komoku" width="10%">先生</td>
    <td class="table_komoku2"><?php _inputv("実習先指導者名", $実習先指導者名, "text", "", "", ""); ?></td>
    <td class="table_komoku" width="10%">先生</td>
  </tr>


</table>
<table class="table table-bordered border-secondary">
  <tr>
    <td class="table_komoku" rowspan=3 width="10%">Ⅳ 実習生の<br>出勤状況</td>
    <td class="table_komoku" colspan=1 width="22.5%">実習期間</td>
    <td class="table_komoku" colspan=1 width="22.5%">出勤日数</td>
    <td class="table_komoku" colspan=1 width="22.5%">欠勤日数</td>
    <td class="table_komoku" colspan=1 width="22.5%">遅刻早退</td>
  </tr>



  <tr>
    <td class="table_komoku2">
      <table>
        <tr>
          <td width="80px">自（始）</td>
          <td><?php _inputv("実習開始日", $実習開始日, "text", "", "", ""); ?></td>
        </tr>
      </table>
    </td>
    <td class="table_komoku" rowspan=2>
      <table>
        <tr>
          <td width="80px">計</td>
          <td><?php _inputv("出勤日数", $出勤日数, "text", "", "", ""); ?></td>
          <td>日</td>
        </tr>
      </table>
    </td>
    <td class="table_komoku2">
      <table>
        <tr>
          <td width="80px">病欠</td>
          <td><?php _inputv("病気日", $病気日, "text", "", "", ""); ?></td>
          <td>日</td>
        </tr>
      </table>
    </td>
    <td class="table_komoku2">
      <table>
        <tr>
          <td width="80px">遅刻</td>
          <td><?php _inputv("遅刻日", $遅刻日, "text", "", "", ""); ?></td>
          <td>日</td>
        </tr>
      </table>
    </td>
  </tr>





  <tr>
    <td class="table_komoku2">
      <table>
        <tr>
          <td width="80px">至（終）</td>
          <td><?php _inputv("実習終了日", $実習終了日, "text", "", "", ""); ?></td>
        </tr>
      </table>
    </td>

    <td class="table_komoku2">
      <table>
        <tr>
          <td width="80px">事故</td>
          <td><?php _inputv("事故日", $事故日, "text", "", "", ""); ?></td>
          <td>日</td>
        </tr>
      </table>
    </td>
    <td class="table_komoku2">
      <table>
        <tr>
          <td width="80px">早退</td>
          <td><?php _inputv("早退日", $早退日, "text", "", "", ""); ?></td>
          <td>日</td>
        </tr>
      </table>
    </td>
  </tr>
</table>


<table class="table table-bordered border-secondary">
  <tr>
    <td class="table_komoku">Ⅴ 評価（評価基準:5.優れている　4.やや優れている　3.普通　2.やや劣る　1.劣る）</td>
  </tr>
</table>


<table class="table table-bordered border-secondary">
  <tr>
    <td class="table_komoku" width="5%">No.</td>

    <td class="table_komoku" width="80%">評価項目</td>

    <td class="table_komoku" width="15%">評価点</td>
  </tr>


  <tr>
    <td class="table_komoku"><?php $cnt = $cnt + 1;
                              echo $cnt; ?></td>

    <td class="table_komoku2"><?php echo "<input type='hidden' name='評価項目1' value='" . $評価項目1 . "'>";
                              echo nl2br($評価項目1); ?></td>

    <td class="table_komoku"><?php _inputvt("評価点1", $評価点1, "text", "", "", ""); ?></td>
  </tr>
  <tr>
    <td class="table_komoku"><?php $cnt = $cnt + 1;
                              echo $cnt; ?></td>
    <td class="table_komoku2"><?php echo "<input type='hidden' name='評価項目2' value='" . $評価項目2 . "'>";
                              echo nl2br($評価項目2); ?></td>
    <td class="table_komoku"><?php _inputvt("評価点2", $評価点2, "text", "", "", ""); ?></td>
  </tr>
  <tr>
    <td class="table_komoku"><?php $cnt = $cnt + 1;
                              echo $cnt; ?></td>
    <td class="table_komoku2"><?php echo "<input type='hidden' name='評価項目3' value='" . $評価項目3 . "'>";
                              echo nl2br($評価項目3); ?></td>
    <td class="table_komoku"><?php _inputvt("評価点3", $評価点3, "text", "", "", ""); ?></td>
  </tr>
  <tr>
    <td class="table_komoku"><?php $cnt = $cnt + 1;
                              echo $cnt; ?></td>
    <td class="table_komoku2"><?php echo "<input type='hidden' name='評価項目4' value='" . $評価項目4 . "'>";
                              echo nl2br($評価項目4); ?></td>
    <td class="table_komoku"><?php _inputvt("評価点4", $評価点4, "text", "", "", ""); ?></td>
  </tr>

  <?php if ($評価項目5 <> "") { ?>
    <tr>
      <td class="table_komoku"><?php $cnt = $cnt + 1;
                                echo $cnt; ?></td>
      <td class="table_komoku2"><?php echo "<input type='hidden' name='評価項目5' value='" . $評価項目5 . "'>";
                                echo nl2br($評価項目5); ?></td>
      <td class="table_komoku"><?php _inputvt("評価点5", $評価点5, "text", "", "", ""); ?></td>
    </tr>
  <?php } else {
    echo "<input type='hidden' name='評価項目5'  value=''>";
    echo "<input type='hidden' name='評価点5'  value=''>";
  } ?>

  <?php if ($評価項目6 <> "") { ?>
    <tr>
      <td class="table_komoku"><?php $cnt = $cnt + 1;
                                echo $cnt; ?></td>
      <td class="table_komoku2"><?php echo "<input type='hidden' name='評価項目6' value='" . $評価項目6 . "'>";
                                echo nl2br($評価項目6); ?></td>
      <td class="table_komoku"><?php _inputvt("評価点6", $評価点6, "text", "", "", ""); ?></td>
    </tr>
  <?php } else {
    echo "<input type='hidden' name='評価項目6'  value=''>";
    echo "<input type='hidden' name='評価点6'  value=''>";
  } ?>

  <?php if ($評価項目7 <> "") { ?>
    <tr>
      <td class="table_komoku"><?php $cnt = $cnt + 1;
                                echo $cnt; ?></td>
      <td class="table_komoku2"><?php echo "<input type='hidden' name='評価項目7' value='" . $評価項目7 . "'>";
                                echo nl2br($評価項目7); ?></td>
      <td class="table_komoku"><?php _inputvt("評価点7", $評価点7, "text", "", "", ""); ?></td>
    </tr>
  <?php } else {
    echo "<input type='hidden' name='評価項目7'  value=''>";
    echo "<input type='hidden' name='評価点7'  value=''>";
  } ?>

  <?php if ($評価項目8 <> "") { ?>
    <tr>
      <td class="table_komoku"><?php $cnt = $cnt + 1;
                                echo $cnt; ?></td>
      <td class="table_komoku2"><?php echo "<input type='hidden' name='評価項目8' value='" . $評価項目8 . "'>";
                                echo nl2br($評価項目8); ?></td>
      <td class="table_komoku"><?php _inputvt("評価点8", $評価点8, "text", "", "", ""); ?></td>
    </tr>
  <?php } else {
    echo "<input type='hidden' name='評価項目8'  value=''>";
    echo "<input type='hidden' name='評価点8'  value=''>";
  } ?>


  <?php if ($評価項目9 <> "") { ?>
    <tr>
      <td class="table_komoku"><?php $cnt = $cnt + 1;
                                echo $cnt; ?></td>
      <td class="table_komoku2"><?php echo "<input type='hidden' name='評価項目9' value='" . $評価項目9 . "'>";
                                echo nl2br($評価項目9); ?></td>
      <td class="table_komoku"><?php _inputvt("評価点9", $評価点9, "text", "", "", ""); ?></td>
    </tr>

  <?php } else {
    echo "<input type='hidden' name='評価項目9'  value=''>";
    echo "<input type='hidden' name='評価点9'  value=''>";
  } ?>

  <?php if ($評価項目10 <> "") { ?>
    <tr>
      <td class="table_komoku"><?php $cnt = $cnt + 1;
                                echo $cnt; ?></td>
      <td class="table_komoku2"><?php echo "<input type='hidden' name='評価項目10' value='" . $評価項目10 . "'>";
                                echo nl2br($評価項目10); ?></td>
      <td class="table_komoku"><?php _inputvt("評価点10", $評価点10, "text", "", "", ""); ?></td>
    </tr>
  <?php } else {
    echo "<input type='hidden' name='評価項目10'  value=''>";
    echo "<input type='hidden' name='評価点10'  value=''>";
  } ?>

  <?php if ($評価項目11 <> "") { ?>
    <tr>
      <td class="table_komoku"><?php $cnt = $cnt + 1;
                                echo $cnt; ?></td>
      <td class="table_komoku2"><?php echo "<input type='hidden' name='評価項目11' value='" . $評価項目11 . "'>";
                                echo nl2br($評価項目11); ?></td>
      <td class="table_komoku"><?php _inputvt("評価点11", $評価点11, "text", "", "", ""); ?></td>
    </tr>
  <?php } else {
    echo "<input type='hidden' name='評価項目11'  value=''>";
    echo "<input type='hidden' name='評価点11'  value=''>";
  } ?>

  <?php if ($評価項目12 <> "") { ?>
    <tr>
      <td class="table_komoku"><?php $cnt = $cnt + 1;
                                echo $cnt; ?></td>
      <td class="table_komoku2"><?php echo "<input type='hidden' name='評価項目12' value='" . $評価項目12 . "'>";
                                echo nl2br($評価項目12); ?></td>
      <td class="table_komoku"><?php _inputvt("評価点12", $評価点12, "text", "", "", ""); ?></td>
    </tr>
  <?php } else {
    echo "<input type='hidden' name='評価項目12'  value=''>";
    echo "<input type='hidden' name='評価点12'  value=''>";
  } ?>


</table>


<table class="table table-bordered border-secondary">
  <tr>
    <td width="5%" class="table_komoku"><?php $cnt = $cnt + 1;
                                        echo $cnt; ?></td>
    <td width="80%" class="table_komoku2"><?php echo "<input type='hidden' name='総合評価項目' value='" . $総合評価項目 . "'>";
                                          echo nl2br($総合評価項目); ?></td>
    <td width="15%" class="table_komoku"><?php _inputvt("総合評価点", $総合評価点, "text", "", "", ""); ?></td>
  </tr>
</table>



<table class="table table-bordered border-secondary">
  <tr>
    <td class="table_komoku2">
      <p>（自己評価）<br>*学修行動計画「リフレクション・シート」の入力内容を踏まえて記入すること。</p>
    </td>
  </tr>


  <tr>
    <td class="table_komoku2"><?php _inputv("自己評価", $自己評価, "textarea", "", "h200", "255"); ?></td>
  </tr>
</table>




<h6>教員からのコメント <span class="fs80"></span></h6>
<table class="table table-bordered border-secondary">
  <tr>
    <td><?php _inputv("comments_of_teacher", $comments_of_teacher, "textarea", "edit", "", "255"); ?></td>
  </tr>
</table>



<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $_SESSION['SEL_STUDENT_NUMBER']; ?>">
<input type='hidden' name='SHEET_TITLE' value="<?PHP echo $_SESSION['SEL_SHEET_TITLE'];; ?>">



<input type='hidden' name='self_assessmen_title' value="<?PHP echo $title; ?>">
<input type='hidden' name='TABLE' value="tbl_self_assessment">
<input type='hidden' name='METHOD' value="COMMENT_UP">




<input type='hidden' name='配属情報テーブルID' value="<?PHP echo $配属情報テーブルID; ?>">
<input type='hidden' name='種別' value="<?PHP echo $種別; ?>">



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

      if (strpos(" 2 3 4 ", $sta) == true) {
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