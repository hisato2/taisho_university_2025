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
require_once('./common/target.php');
$ACTION = "student_list.php";
require('./disp_parts/header.php');
require('data_keep.php');




$title = $_SESSION['SEL_SHEET_TITLE'];

$student_number = $_SESSION['SEL_STUDENT_NUMBER'];
tbl_status_check($_SESSION['SEL_STUDENT_NUMBER'], ""); //年は関係ない
tbl_profile_READ($_SESSION['SEL_STUDENT_NUMBER']);

tbl_reflection_intern_READ($student_number, $title); {


  $インターンコメント = $GLOBALS['comments_of_teacher'];


  $GLOBALS['sw_target01～12'] = "";
  $GLOBALS['sw_conversion01～12'] = "";
  $GLOBALS['intern_target01～12'] = "";
  $GLOBALS['intern_conversion01～12'] = "";
}




switch ($title) {
  case "ソーシャルワーク実習Ⅰ": //2年次で行う

    tbl_goal_sheet_1q_READ($student_number, 2);

    $column = "ref_sw1";
    $school_year = 2;
    $staus = $GLOBALS['sta_rsw1'];
    $kadai = "ソーシャルワーク実習Ⅱにむけて";

    break;
  case "ソーシャルワーク実習Ⅱ": //3年次で行う
    tbl_goal_sheet_1q_READ($student_number, 4);
    $column = "ref_sw2";
    $school_year = 4;
    $staus = $GLOBALS['sta_rsw2'];
    $kadai = "次のインターンシップ OR ソーシャルワーク実習までに";

    break;
  case "インターンシップⅠ":
    tbl_goal_sheet_1q_READ($student_number, 2);
    $column = "ref_intern";
    $staus = $GLOBALS['sta_rintern'];
    $kadai = "次のインターンシップ OR ソーシャルワーク実習までに";
    break;


  case "精神実習Ⅰ（単独）/インターンシップⅡ":
    tbl_goal_sheet_1q_READ($student_number, 3);
    $column = "ref_mental1";
    $staus = $GLOBALS['sta_rmental1'];
    $kadai = "次のインターンシップ OR ソーシャルワーク実習までに";
    break;


  case "アドバンス・クラス/精神実習Ⅱ（単独）":
    tbl_goal_sheet_1q_READ($student_number, 4);
    $column = "ref_advance";
    $staus = $GLOBALS['sta_radv'];
    $kadai = "大学卒業後に";
    break;
}




echo "<br>";
dsip_midashi("学修行動計画(" . $title . "・リフレクション・シート)（" . $name . "）");




if ($column == "ref_sw1") {
  $実習共通目標1 =  SW1_TARGET_01;
  $実習共通目標2 =  SW1_TARGET_02;
  $実習共通目標3 =  SW1_TARGET_03;
  $実習共通目標4 =  SW1_TARGET_04;
  $実習共通目標5 =  SW1_TARGET_05;
  $実習共通目標6 =  SW1_TARGET_06;
  $実習共通目標7 =  SW1_TARGET_07;
  $実習共通目標8 =  SW1_TARGET_08;
  $実習共通目標9 =  SW1_TARGET_09;
  $実習共通目標10 =  SW1_TARGET_10;
  $実習共通目標11 =  SW1_TARGET_11;
  $実習共通目標12 =  SW1_TARGET_12;

  $実習自己目標1 = $sw_conversion01;
  $実習自己目標2 = $sw_conversion02;
  $実習自己目標3 = $sw_conversion03;
  $実習自己目標4 = $sw_conversion04;
  $実習自己目標5 = $sw_conversion05;
  $実習自己目標6 = $sw_conversion06;
  $実習自己目標7 = $sw_conversion07;
  $実習自己目標8 = $sw_conversion08;
  $実習自己目標9 = $sw_conversion09;
  $実習自己目標10 = "";
  $実習自己目標11 = "";
  $実習自己目標12 = "";
}




if ($column == "ref_sw2") {
  $実習共通目標1 =  SW2_TARGET_01;
  $実習共通目標2 =  SW2_TARGET_02;
  $実習共通目標3 =  SW2_TARGET_03;
  $実習共通目標4 =  SW2_TARGET_04;
  $実習共通目標5 =  SW2_TARGET_05;
  $実習共通目標6 =  SW2_TARGET_06;
  $実習共通目標7 =  SW2_TARGET_07;
  $実習共通目標8 =  SW2_TARGET_08;
  $実習共通目標9 =  SW2_TARGET_09;
  $実習共通目標10 =  SW2_TARGET_10;
  $実習共通目標11 =  SW2_TARGET_11;
  $実習共通目標12 =  SW2_TARGET_12;

  $実習自己目標1 =  $実習自己目標1;
  $実習自己目標2 =  $実習自己目標2;;
  $実習自己目標3 =  $実習自己目標3;
  $実習自己目標4 =  $実習自己目標4;
  $実習自己目標5 =  $実習自己目標5;
  $実習自己目標6 =  $実習自己目標6;
  $実習自己目標7 =  $実習自己目標7;
  $実習自己目標8 =  $実習自己目標8;
  $実習自己目標9 =  $実習自己目標9;
  $実習自己目標10 =  $実習自己目標10;
  $実習自己目標11 =  $実習自己目標11;
  $実習自己目標12 =  $実習自己目標12;
}



if ($column == "ref_intern") {

  $実習共通目標1 = $intern_target01;
  $実習共通目標2 = $intern_target02;
  $実習共通目標3 = $intern_target03;
  $実習共通目標4 = $intern_target04;
  $実習共通目標5 = $intern_target05;
  $実習共通目標6 = $intern_target06;
  $実習共通目標7 = $intern_target07;
  $実習共通目標8 = $intern_target08;
  $実習共通目標9 = $intern_target09;
  $実習共通目標10 = $intern_target10;
  $実習共通目標11 = $intern_target11;
  $実習共通目標12 = $intern_target12;

  $実習自己目標1 = $intern_conversion01;
  $実習自己目標2 = $intern_conversion02;
  $実習自己目標3 = $intern_conversion03;
  $実習自己目標4 = $intern_conversion04;
  $実習自己目標5 = $intern_conversion05;
  $実習自己目標6 = $intern_conversion06;
  $実習自己目標7 = $intern_conversion07;
  $実習自己目標8 = $intern_conversion08;
  $実習自己目標9 = $intern_conversion09;
  $実習自己目標10 = $intern_conversion10;
  $実習自己目標11 = $intern_conversion11;
  $実習自己目標12 = $intern_conversion12;
}


if ($column == "ref_mental1") {
  $実習共通目標1 = $intern_target01;
  $実習共通目標2 = $intern_target02;
  $実習共通目標3 = $intern_target03;
  $実習共通目標4 = $intern_target04;
  $実習共通目標5 = $intern_target05;
  $実習共通目標6 = $intern_target06;
  $実習共通目標7 = $intern_target07;
  $実習共通目標8 = $intern_target08;
  $実習共通目標9 = $intern_target09;
  $実習共通目標10 = $intern_target10;
  $実習共通目標11 = $intern_target11;
  $実習共通目標12 = $intern_target12;

  $実習自己目標1 = $intern_conversion01;
  $実習自己目標2 = $intern_conversion02;
  $実習自己目標3 = $intern_conversion03;
  $実習自己目標4 = $intern_conversion04;
  $実習自己目標5 = $intern_conversion05;
  $実習自己目標6 = $intern_conversion06;
  $実習自己目標7 = $intern_conversion07;
  $実習自己目標8 = $intern_conversion08;
  $実習自己目標9 = $intern_conversion09;
  $実習自己目標10 = $intern_conversion10;
  $実習自己目標11 = $intern_conversion11;
  $実習自己目標12 = $intern_conversion12;
}

if ($column == "ref_advance") {
  $実習共通目標1 = $intern_target01;
  $実習共通目標2 = $intern_target02;
  $実習共通目標3 = $intern_target03;
  $実習共通目標4 = $intern_target04;
  $実習共通目標5 = $intern_target05;
  $実習共通目標6 = $intern_target06;
  $実習共通目標7 = $intern_target07;
  $実習共通目標8 = $intern_target08;
  $実習共通目標9 = $intern_target09;
  $実習共通目標10 = $intern_target10;
  $実習共通目標11 = $intern_target11;
  $実習共通目標12 = $intern_target12;

  $実習自己目標1 = $intern_conversion01;
  $実習自己目標2 = $intern_conversion02;
  $実習自己目標3 = $intern_conversion03;
  $実習自己目標4 = $intern_conversion04;
  $実習自己目標5 = $intern_conversion05;
  $実習自己目標6 = $intern_conversion06;
  $実習自己目標7 = $intern_conversion07;
  $実習自己目標8 = $intern_conversion08;
  $実習自己目標9 = $intern_conversion09;
  $実習自己目標10 = $intern_conversion10;
  $実習自己目標11 = $intern_conversion11;
  $実習自己目標12 = $intern_conversion12;
}




form_submit("registration.php");
?>
<table class="table table-bordered border-secondary">

  <tr>
    <td width="13.5%" rowspan=2 class='text-top'><span class="fw600">1.共通の到達目標</span></td>
    <td width="13.5%" rowspan=2 class='text-top'><span class="fw600">2.「共通の到達目標」を踏まえた、あなたの到達目標</span></td>
    <td colspan=3 class="text-center text-top color_td1"><span class="fw600">3.学修行動の振り返り</span></td>
    <td width="13.5%" rowspan=2 class='text-top color_td1'><span class="fw600">4.「あなたの到達目標」達成に向けて、"<?php echo $kadai; ?>"、あなたがさらにやること、努力すること</span></td>
  </tr>
  <tr>
    <td width="13.5%" class='text-top color_td1'><span class="fw600">①.共通の目標達成度評価(評価基準表に基づき自己評価)</span></td>
    <td width="13.5%" class='text-top color_td1'><span class="fw600">③.①に関して、あなたが獲得できたこと、達成できたこと、できるようになったこと（「2.あなたの達成目標」に関連付けて記述）</span></td>
    <td width="13.5%" class='text-top color_td1'><span class="fw600">③.①に関して、達成・獲得に至らなかったこと（「2.あなたの達成目標」に関連付けて記述）</span></td>
  </tr>


  <?php




  echo "<tr>";
  echo "<td class='text-top wbr'>";

  echo "<input type='hidden' name='共通目標1' value='" . $実習共通目標1 . "'>";
  echo nl2br($実習共通目標1);


  echo "</td>";
  echo "<td class='text-top wbr'>";

  echo "<input type='hidden' name='自己目標1' value='" . $実習自己目標1 . "'>";
  echo nl2br($実習自己目標1);



  echo "</td>";
  echo "<td  class='color_td1'>";
  _inputv("自己評価1", $実習自己評価1, "textarea", "", "h200", "255");
  echo "</td>";
  echo "<td class='color_td1'>";
  _inputv("出来た1", $実習出来た1, "textarea", "", "h200", "255");
  echo "</td>";
  echo "<td class='color_td1'>";
  _inputv("出来ず1", $実習出来ず1, "textarea", "", "h200", "255");
  echo "</td>";
  echo "<td class='color_td1'>";
  _inputv("今後課題1", $実習今後課題1, "textarea", "", "h200", "255");
  echo "</td></tr>";



  if ($実習共通目標2 <> "") {
    echo "<tr>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='共通目標2' value='" . $実習共通目標2 . "'>";
    echo nl2br($実習共通目標2);

    echo "</td>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='自己目標2' value='" . $実習自己目標2 . "'>";
    echo nl2br($実習自己目標2);

    echo "</td>";
    echo "<td  class='color_td1'>";
    _inputv("自己評価2", $実習自己評価2, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来た2", $実習出来た2, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来ず2", $実習出来ず2, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("今後課題2", $実習今後課題2, "textarea", "", "h200", "255");
    echo "</td></tr>";
  }






  if ($実習共通目標3 <> "") {



    echo "<tr>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='共通目標3' value='" . $実習共通目標3 . "'>";
    echo nl2br($実習共通目標3);

    echo "</td>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='自己目標3' value='" . $実習自己目標3 . "'>";
    echo nl2br($実習自己目標3);

    echo "</td>";
    echo "<td  class='color_td1'>";
    _inputv("自己評価3", $実習自己評価3, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来た3", $実習出来た3, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来ず3", $実習出来ず3, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("今後課題3", $実習今後課題3, "textarea", "", "h200", "255");
    echo "</td></tr>";
  }



  if ($実習共通目標4 <> "") {

    echo "<tr>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='共通目標4' value='" . $実習共通目標4 . "'>";
    echo nl2br($実習共通目標4);

    echo "</td>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='自己目標4' value='" . $実習自己目標4 . "'>";
    echo nl2br($実習自己目標4);

    echo "</td>";
    echo "<td  class='color_td1'>";
    _inputv("自己評価4", $実習自己評価4, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来た4", $実習出来た4, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来ず4", $実習出来ず4, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("今後課題4", $実習今後課題4, "textarea", "", "h200", "255");
    echo "</td></tr>";
  }






  if ($実習共通目標5 <> "") {




    echo "<tr>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='共通目標5' value='" . $実習共通目標5 . "'>";
    echo nl2br($実習共通目標5);

    echo "</td>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='自己目標5' value='" . $実習自己目標5 . "'>";
    echo nl2br($実習自己目標5);

    echo "</td>";
    echo "<td  class='color_td1'>";
    _inputv("自己評価5", $実習自己評価5, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来た5", $実習出来た5, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来ず5", $実習出来ず5, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("今後課題5", $実習今後課題5, "textarea", "", "h200", "255");
    echo "</td></tr>";
  }



  if ($実習共通目標6 <> "") {

    echo "<tr>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='共通目標6' value='" . $実習共通目標6 . "'>";
    echo nl2br($実習共通目標6);

    echo "</td>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='自己目標6' value='" . $実習自己目標6 . "'>";
    echo nl2br($実習自己目標6);


    echo "</td>";
    echo "<td  class='color_td1'>";
    _inputv("自己評価6", $実習自己評価6, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来た6", $実習出来た6, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来ず6", $実習出来ず6, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("今後課題6", $実習今後課題6, "textarea", "", "h200", "255");
    echo "</td></tr>";
  }


  if ($実習共通目標7 <> "") {



    echo "<tr>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='共通目標7' value='" . $実習共通目標7 . "'>";
    echo nl2br($実習共通目標7);
    echo "</td>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='自己目標7' value='" . $実習自己目標7 . "'>";
    echo nl2br($実習自己目標7);

    echo "</td>";
    echo "<td  class='color_td1'>";
    _inputv("自己評価7", $実習自己評価7, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来た7", $実習出来た7, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来ず7", $実習出来ず7, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("今後課題7", $実習今後課題7, "textarea", "", "h200", "255");
    echo "</td></tr>";
  }




  if ($実習共通目標8 <> "") {


    echo "<tr>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='共通目標8' value='" . $実習共通目標8 . "'>";
    echo nl2br($実習共通目標8);

    echo "</td>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='自己目標8' value='" . $実習自己目標8 . "'>";
    echo nl2br($実習自己目標8);

    echo "</td>";
    echo "<td  class='color_td1'>";
    _inputv("自己評価8", $実習自己評価8, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来た8", $実習出来た8, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来ず8", $実習出来ず8, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("今後課題8", $実習今後課題8, "textarea", "", "h200", "255");
    echo "</td></tr>";
  }



  if ($実習共通目標9 <> "") {


    echo "<tr>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='共通目標9' value='" . $実習共通目標9 . "'>";
    echo nl2br($実習共通目標9);

    echo "</td>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='自己目標9' value='" . $実習自己目標9 . "'>";
    echo nl2br($実習自己目標9);

    echo "</td>";
    echo "<td  class='color_td1'>";
    _inputv("自己評価9", $実習自己評価9, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来た9", $実習出来た9, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来ず9", $実習出来ず9, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("今後課題9", $実習今後課題9, "textarea", "", "h200", "255");
    echo "</td></tr>";
  }



  if ($実習共通目標10 <> "") {
    echo "<tr>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='共通目標10' value='" . $実習共通目標10 . "'>";
    echo nl2br($実習共通目標10);

    echo "</td>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='自己目標10' value='" . $実習自己目標10 . "'>";
    echo nl2br($実習自己目標10);

    echo "</td>";
    echo "<td  class='color_td1'>";
    _inputv("自己評価10", $実習自己評価10, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来た10", $実習出来た10, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来ず10", $実習出来ず10, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("今後課題10", $実習今後課題10, "textarea", "", "h200", "255");
    echo "</td></tr>";
  }



  if ($実習共通目標11 <> "") {

    echo "<tr>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='共通目標11' value='" . $実習共通目標11 . "'>";
    echo nl2br($実習共通目標11);

    echo "</td>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='自己目標11' value='" . $実習自己目標11 . "'>";
    echo nl2br($実習自己目標11);

    echo "</td>";
    echo "<td  class='color_td1'>";
    _inputv("自己評価11", $実習自己評価11, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来た11", $実習出来た11, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来ず11", $実習出来ず11, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("今後課題11", $実習今後課題11, "textarea", "", "h200", "255");
    echo "</td></tr>";
  }


  if ($実習共通目標12 <> "") {

    echo "<tr>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='共通目標12' value='" . $実習共通目標12 . "'>";
    echo nl2br($実習共通目標12);

    echo "</td>";
    echo "<td class='text-top wbr'>";
    echo "<input type='hidden' name='自己目標12' value='" . $実習自己目標12 . "'>";
    echo nl2br($実習自己目標12);

    echo "</td>";
    echo "<td  class='color_td1'>";
    _inputv("自己評価12", $実習自己評価12, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来た12", $実習出来た12, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("出来ず12", $実習出来ず12, "textarea", "", "h200", "255");
    echo "</td>";
    echo "<td class='color_td1'>";
    _inputv("今後課題12", $実習今後課題12, "textarea", "", "h200", "255");
    echo "</td></tr>";
  }



  ?>
</table>


<h6>教員からのコメント <span class="fs80"></span></h6>
<table class="table table-bordered border-secondary">
  <tr>
    <td><?php _inputv("comments_of_teacher", $インターンコメント, "textarea", "edit", "", "255"); ?></td>
  </tr>
</table>




<input type='hidden' name='TABLE' value="tbl_reflection_intern">
<input type='hidden' name='METHOD' value="COMMENT_UP">
<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $student_number; ?>">
<input type='hidden' name='SHEET_TITLE' value="<?PHP echo $title ?>">


<br>
<br>
<?PHP



?>



<p class="text-center">
  <?php echo "状態：" . $mr[$staus]; ?>
</p>
<?php
$staus = strval($staus);
?>

<table class="table">
  <tr>

    <td>
      <?php
      if (strpos(" 2 3 4 ", $staus) == true) {
        $dis = "";
      } else {
        $dis = "disabled";
      }
      btn_submit("要修正", $column, $dis);
      ?>
    </td>

    <td>
      <?php


      if (strpos(" 2 3 4 ",  $staus) == true) {
        $dis = ""; //承認できる
      } else {
        $dis = "disabled";
      }
      btn_submit("承認", $column, $dis);
      ?>
    </td>
    <td>
      <?php btn_return("student_list.php", "戻る"); ?>
    </td>

  </tr>
</table>


<?php
require('./disp_parts/footer.php');
exit;
?>