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

require('./disp_parts/header.php');



//////////何年度の表の提出状況を表示するか


dsip_midashi("年度更新");


$nenNW =  (string) date('Y', mktime(0, 0, 0, date('m') + 0, date('d') + 0, date('Y')));
$nenP1 =  (string) date('Y', mktime(0, 0, 0, date('m') + 0, date('d') + 0, date('Y') - 2));
$nenP2 =  (string) date('Y', mktime(0, 0, 0, date('m') + 0, date('d') + 0, date('Y') - 1));
$nenP3 =  (string) date('Y', mktime(0, 0, 0, date('m') + 0, date('d') + 0, date('Y') + 0));
$nenP4 =  (string) date('Y', mktime(0, 0, 0, date('m') + 0, date('d') + 0, date('Y') + 1));
$nenP5 =  (string) date('Y', mktime(0, 0, 0, date('m') + 0, date('d') + 0, date('Y') + 2));
$nenP6 =  (string) date('Y', mktime(0, 0, 0, date('m') + 0, date('d') + 0, date('Y') + 3));


form_submit("registration.php");

?>

<table class="table">
  <tr>
    <td class="text-center">


      <?php
      $SEl1_1 = "";
      $SEl1_2 = "";
      $SEl1_3 = "";
      $SEl1_4 = "";
      $SEl1_5 = "";
      $SEl1_6 = "";



      if ($_SESSION['NENDO'] == $nenP1) {
        $SEl1_1 = "selected";
      }
      if ($_SESSION['NENDO'] == $nenP2) {
        $SEl1_2 = "selected";
      }
      if ($_SESSION['NENDO'] == $nenP3) {
        $SEl1_3 = "selected";
      }
      if ($_SESSION['NENDO'] == $nenP4) {
        $SEl1_4 = "selected";
      }
      if ($_SESSION['NENDO'] == $nenP5) {
        $SEl1_5 = "selected";
      }
      if ($_SESSION['NENDO'] == $nenP6) {
        $SEl1_6 = "selected";
      }
      ?>

      <h5><label for="nend-select">事業年度:</label>
        <select name="事業年度" id="nend-select">
          <option value=<?php echo $nenNW; ?>><?php echo $nenNW; ?></option>
          <option value=<?php echo $nenP1 . " " . $SEl1_1; ?>><?php echo $nenP1; ?></option>
          <option value=<?php echo $nenP2 . " " . $SEl1_2; ?>><?php echo $nenP2; ?></option>
          <option value=<?php echo $nenP3 . " " . $SEl1_3; ?>><?php echo $nenP3; ?></option>
          <option value=<?php echo $nenP4 . " " . $SEl1_4; ?>><?php echo $nenP4; ?></option>
          <option value=<?php echo $nenP5 . " " . $SEl1_5; ?>><?php echo $nenP5; ?></option>
          <option value=<?php echo $nenP6 . " " . $SEl1_6; ?>><?php echo $nenP6; ?></option>
        </select>
      </h5>




    </td>

    <td class="text-center">



      <?php

      $SEl1_1 = "";
      $SEl1_2 = "";
      $SEl1_3 = "";
      $SEl1_4 = "";
      $SEl1_5 = "";
      $SEl1_6 = "";



      if ($_SESSION['KANRI_NENDO'] == $nenP1) {
        $SEl1_1 = "selected";
      }
      if ($_SESSION['KANRI_NENDO'] == $nenP2) {
        $SEl1_2 = "selected";
      }
      if ($_SESSION['KANRI_NENDO'] == $nenP3) {
        $SEl1_3 = "selected";
      }
      if ($_SESSION['KANRI_NENDO'] == $nenP4) {
        $SEl1_4 = "selected";
      }
      if ($_SESSION['KANRI_NENDO'] == $nenP5) {
        $SEl1_5 = "selected";
      }
      if ($_SESSION['KANRI_NENDO'] == $nenP6) {
        $SEl1_6 = "selected";
      }

      ?>


      <h5><label for="nend-select">管理用年度:</label>
        <select name="管理用年度" id="nend-select">
          <option value=<?php echo $nenNW; ?>><?php echo $nenNW; ?></option>
          <option value=<?php echo $nenP1 . " " . $SEl1_1; ?>><?php echo $nenP1; ?></option>
          <option value=<?php echo $nenP2 . " " . $SEl1_2; ?>><?php echo $nenP2; ?></option>
          <option value=<?php echo $nenP3 . " " . $SEl1_3; ?>><?php echo $nenP3; ?></option>
          <option value=<?php echo $nenP4 . " " . $SEl1_4; ?>><?php echo $nenP4; ?></option>
          <option value=<?php echo $nenP5 . " " . $SEl1_5; ?>><?php echo $nenP5; ?></option>
          <option value=<?php echo $nenP6 . " " . $SEl1_6; ?>><?php echo $nenP6; ?></option>
        </select>
      </h5>





    </td>

  </tr>

  <tr>
    <td class="text-center">事業年度は運用している事業年度です。新年事業開始時に更新します。</td>

    <td class="text-center">管理用年度は過去の配属情報を参照するとき等に変更します。</td>

  </tr>

</table>







<table class="table">
  <tr>

    <td class="text-center">

      <input type='hidden' name='TABLE' value="tbl_nendo">
      <input type='hidden' name='METHOD' value="UP_DATE">

      <?php btn_submit2("年度更新", "年度更新", ""); ?>

    </td>
    <td class="text-center">
      <?php btn_return("index.php", "戻る"); ?>
    </td>
  </tr>
</table>

<?PHP

echo "</form>";


require('./disp_parts/footer.php');
exit;
?>