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


$ACTION="student_list.php";


require('./disp_parts/headerNon.php');
require('data_keep.php');




tbl_profile_READ($_SESSION['SEL_STUDENT_NUMBER']);

$sta = "0";

$student_number = $_SESSION['SEL_STUDENT_NUMBER'];


dsip_midashi("配属登録された施設リスト（".$name."）");

try {
  // DBへ接続

  $dbh = new PDO(DSN, DB_USER, DB_PASS);
  // SQL作成

  
  $sql = "select 事業年度,tbl_institution.法人ID,tbl_institution.法人名,tbl_institution.施設名,tbl_institution.実習種別1,tbl_institution.実習種別2,tbl_institution.管理者,tbl_institution.管理者役職名,tbl_institution.実習窓口担当者名 FROM tbl_assignment JOIN tbl_institution ON tbl_assignment.法人ID=tbl_institution.法人ID where ((学籍番号1='" . $student_number ."') OR (学籍番号2='" . $student_number ."') OR (学籍番号3='" . $student_number ."') OR (学籍番号4='" . $student_number ."') OR (学籍番号5='" . $student_number ."')) AND 事業年度='".$_SESSION['NENDO']."'";


  $cnt = 0;

?>

  <table class="table table-bordered border-secondary">

    <tr>
      <td width="5%" class="text-center align-middle"><span class="fw600">No.</span></td>
      <td class="text-center align-middle"><span class="fw600">法人名</span></td>
      <td class="text-center align-middle"><span class="fw600">施設名</span></td>
      <td class="text-center align-middle"><span class="fw600">実習種別1</span></td>
      <td class="text-center align-middle"><span class="fw600">実習種別2</span></td>
      <td class="text-center align-middle"><span class="fw600">管理者</span></td>
      
      <td class="text-center align-middle"><span class="fw600">窓口担当者</span></td>
      <td class="text-center align-middle"><span class="fw600">詳細</span></td>
    </tr>


    <?php

    $res = $dbh->query($sql);
    foreach ($res as $value) {


        $cnt = $cnt + 1;
        $GLOBALS['法人ID']=$value['法人ID'];
        $GLOBALS['実習種別1']=$value['実習種別1'];
        $GLOBALS['実習種別2']=$value['実習種別2'];
        $GLOBALS['法人名']=$value['法人名'];
        $GLOBALS['施設名']=$value['施設名'];

        $GLOBALS['管理者']=$value['管理者'];
        $GLOBALS['管理者役職名']=$value['管理者役職名'];
        $GLOBALS['実習窓口担当者名']=$value['実習窓口担当者名'];




    ?>
      <tr>
        <td class="text-center align-middle"><?php echo $cnt; ?></td>
        <td class="text-left align-middle"><?php echo $法人名; ?></td>
        <td class="text-left align-middle"><?php echo $施設名; ?></td>
        <td class="text-left align-middle"><?php echo $実習種別1; ?></td>
        <td class="text-left align-middle"><?php echo $実習種別2; ?></td>

        <td class="text-left align-middle"><?php echo $管理者."<br>(".$管理者役職名.")"; ?></td>
        <td class="text-left align-middle"><?php echo $実習窓口担当者名; ?></td>

        <form action='indicate_sheet_equipment_outline.php' method='post'>
          <td class="text-center align-middle">
            <input type='hidden' name='法人ID' value="<?PHP echo $GLOBALS['法人ID']; ?>">
            <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
          </td>
        </form>

    </tr>


      </tr>
  <?php
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
    die();
  }
  ?>
  </table>


  <h5>現在登録<?php echo $cnt;?>件です</h5>

  <table class="table">
    <tr>
      <td>
        <?php btn_return("student_list.php", "戻る"); ?>
      </td>
    </tr>
  </table>


<?php
  require('./disp_parts/footer.php');
  exit;

?>