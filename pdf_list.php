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

$ACTION="index.php";
require('./disp_parts/headerNon.php');


//////////何年度の表の提出状況を表示するか


dsip_midashi("出力先施設リスト");

$student_number = "";



$事業年度 = $_SESSION['NENDO'];


?>

<?php
/////////////////////////////////////////////////////////////////////////////////////////////

try {
  // DBへ接続

  $dbh = new PDO(DSN, DB_USER, DB_PASS);

  $sql = "SELECT tbl_institution.法人名 AS iii_a_F,tbl_institution.施設名 AS iii_a_G,tbl_institution.管理者 AS iii_a_K,";

  $sql = $sql . "tbl_assignment.配属情報ID AS iii_a_ID,";
  $sql = $sql . "tbl_institution.管理者役職名 AS iii_a_J,";
  $sql = $sql . "tbl_assignment.事業年度 AS iii_c_A,";
  $sql = $sql . "tbl_institution.形態 AS iii_a_V,";

  $sql = $sql . "tbl_assignment.実習種別1 AS iii_c_O,";
  $sql = $sql . "tbl_assignment.氏名1 AS iii_c_Q,";
  $sql = $sql . "tbl_assignment.学年1 AS iii_c_R,";
  $sql = $sql . "tbl_assignment.実習開始日1 AS iii_c_T,";
  $sql = $sql . "tbl_assignment.実習終了日1 AS iii_c_U,";
  $sql = $sql . "tbl_assignment.総実習時間1 AS iii_c_V,";

  $sql = $sql . "tbl_assignment.実習種別2 AS iii_c_AA,";
  $sql = $sql . "tbl_assignment.氏名2 AS iii_c_AC,";
  $sql = $sql . "tbl_assignment.学年2 AS iii_c_AD,";
  $sql = $sql . "tbl_assignment.実習開始日2 AS iii_c_AE,";
  $sql = $sql . "tbl_assignment.実習終了日2 AS iii_c_AF,";
  $sql = $sql . "tbl_assignment.総実習時間2 AS iii_c_AH,";

  $sql = $sql . "tbl_assignment.実習種別3 AS iii_c_AM,";
  $sql = $sql . "tbl_assignment.氏名3 AS iii_c_AO,";
  $sql = $sql . "tbl_assignment.学年3 AS iii_c_AP,";
  $sql = $sql . "tbl_assignment.実習開始日3 AS iii_c_AQ,";
  $sql = $sql . "tbl_assignment.実習終了日3 AS iii_c_AR,";
  $sql = $sql . "tbl_assignment.総実習時間3 AS iii_c_AT,";

  $sql = $sql . "tbl_assignment.実習種別4 AS iii_c_AY,";
  $sql = $sql . "tbl_assignment.氏名4 AS iii_c_BA,";
  $sql = $sql . "tbl_assignment.学年4 AS iii_c_BB,";
  $sql = $sql . "tbl_assignment.実習開始日4 AS iii_c_BC,";
  $sql = $sql . "tbl_assignment.実習終了日4 AS iii_c_BD,";
  $sql = $sql . "tbl_assignment.総実習時間4 AS iii_c_BF,";


  $sql = $sql . "tbl_assignment.実習種別5 AS iii_c_BK,";
  $sql = $sql . "tbl_assignment.氏名5 AS iii_c_BM,";
  $sql = $sql . "tbl_assignment.学年5 AS iii_c_BN,";
  $sql = $sql . "tbl_assignment.実習開始日5 AS iii_c_BP,";
  $sql = $sql . "tbl_assignment.実習終了日5 AS iii_c_BQ,";
  $sql = $sql . "tbl_assignment.総実習時間5 AS iii_c_BR";

  $sql = $sql . " FROM tbl_assignment JOIN tbl_institution ON tbl_assignment.法人ID=tbl_institution.法人ID";
  $sql = $sql . " where tbl_assignment.事業年度='" . $事業年度 . "'";



  /*
$sql = $sql."tbl_assignment.配属情報ID AS iii_a_ID,";
$sql = $sql."tbl_institution.管理者役職名 AS iii_a_K,";
$sql = $sql."tbl_assignment.事業年度 AS iii_c_A,";
$sql = $sql."tbl_institution.形態 AS iii_a_V,";

$sql = $sql."tbl_assignment.実習種別1 AS iii_c_O,";
$sql = $sql."tbl_assignment.氏名1 AS iii_c_Q,";
$sql = $sql."tbl_assignment.学年1 AS iii_c_R,";
$sql = $sql."tbl_assignment.実習開始日1 AS iii_c_T,";
$sql = $sql."tbl_assignment.実習終了日1 AS iii_c_U,";
$sql = $sql."tbl_assignment.総実習時間1 AS iii_c_V,";

$sql = $sql."tbl_assignment.実習種別2 AS iii_c_AA,";
$sql = $sql."tbl_assignment.氏名2 AS iii_c_AC,";
$sql = $sql."tbl_assignment.学年2 AS iii_c_AD,";
$sql = $sql."tbl_assignment.実習開始日2 AS iii_c_AE,";
$sql = $sql."tbl_assignment.実習終了日2 AS iii_c_AF,";
$sql = $sql."tbl_assignment.総実習時間2 AS iii_c_AH,";

$sql = $sql."tbl_assignment.実習種別3 AS iii_c_AM,";
$sql = $sql."tbl_assignment.氏名3 AS iii_c_AO,";
$sql = $sql."tbl_assignment.学年3 AS iii_c_AP,";
$sql = $sql."tbl_assignment.実習開始日3 AS iii_c_AQ,";
$sql = $sql."tbl_assignment.実習終了日3 AS iii_c_AR,";
$sql = $sql."tbl_assignment.総実習時間3 AS iii_c_AT,";

$sql = $sql."tbl_assignment.実習種別4 AS iii_c_AY,";
$sql = $sql."tbl_assignment.氏名4 AS iii_c_BA,";
$sql = $sql."tbl_assignment.学年4 AS iii_c_BB,";
$sql = $sql."tbl_assignment.実習開始日4 AS iii_c_BC,";
$sql = $sql."tbl_assignment.実習終了日4 AS iii_c_BD,";
$sql = $sql."tbl_assignment.総実習時間4 AS iii_c_BF,";


$sql = $sql."tbl_assignment.実習種別5 AS iii_c_BK,";
$sql = $sql."tbl_assignment.氏名5 AS iii_c_BM,";
$sql = $sql."tbl_assignment.学年5 AS iii_c_BN,";
$sql = $sql."tbl_assignment.実習開始日5 AS iii_c_BP,";
$sql = $sql."tbl_assignment.実習終了日5 AS iii_c_BQ,";
$sql = $sql."tbl_assignment.総実習時間5 AS iii_c_BR";
*/




  $cnt = 0;

  $配属人数=0;


?>




  <table class="table table-bordered border-secondary">

    <tr>
      <td class="text-center align-middle"><span class="fw600">No.</span></td>
      <td class="text-center align-middle"><span class="fw600">法人名</span></td>
      <td class="text-center align-middle"><span class="fw600">施設名</span></td>
      <td class="text-center align-middle"><span class="fw600">管理者</span></td>
      <td class="text-center align-middle"><span class="fw600">配属人数</span></td>
      <td class="text-center align-middle"><span class="fw600">PDF出力</span></td>
    </tr>


    <?php



    $res = $dbh->query($sql);



    foreach ($res as $value) {
      $cnt = $cnt + 1;

      $配属人数=0;


    if ($value['iii_c_Q']<>"") {
      $配属人数=1;
    }

    if ($value['iii_c_AC']<>"") {
      $配属人数=2;
    }

    if ($value['iii_c_AO']<>"") {
      $配属人数=3;


    }

    if ($value['iii_c_BA']<>"") {
      $配属人数=4;
    }
    if ($value['iii_c_BM']<>"") {
      $配属人数=5;
    }



    ?>
      <tr>

        <td class="text-center align-middle"><?php echo $cnt; ?></td>
        <td class="text-center align-middle"><?php echo $value['iii_a_F']; ?></td>
        <td class="text-center align-middle"><?php echo $value['iii_a_G']; ?></td>
        <td class="text-center align-middle"><?php echo $value['iii_a_K']; ?></td>
        <td class="text-center align-middle"><?php echo $配属人数; ?></td>
        <td class="text-center align-middle"><?php
        echo "<form target='_blank' action='pdf_output.php' method='post'>";
        echo "<input type='hidden' name='配属情報ID' value=". $value['iii_a_ID'] .">";
        echo "<button type='submit' class='btn btn-outline-primary btn-sm'>出力</button>";
        echo "</form>";
        ?>
      </td></tr>
  <?php
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
    die();
  }
  ?>
  </table>
  <?php

  // 接続を閉じる
  $dbh = null;



  //STOP($student_number,$name, $adresse,$logement,$tel);



  ?>



  <table class="table">
    <tr>
      <td>
        <?php btn_return("index.php", "戻る"); ?>
      </td>
    </tr>
  </table>

  <?PHP





  require('./disp_parts/footer.php');
  exit;
  ?>