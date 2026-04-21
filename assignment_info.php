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


$SEl1_1= "";
$SEl1_2= "";
$SEl1_3= "";
$SEl1_4= "";
$SEl1_5= "";
$SEl1_6= "";
$SEl1_7= "";


$SEl2_1= "";
$SEl2_2= "";
$SEl2_3= "";
$SEl2_4= "";
$SEl2_5= "";
$SEl2_6= "";
$SEl2_7= "";



dsip_midashi("実習機関リスト");

$_POST['選択事業年度']=$_SESSION['KANRI_NENDO'];

if (!isset($_POST['選択実習種別'])) {
    $SEl2_1= "selected";
    $_POST['選択実習種別']="ソーシャルワーク実習Ⅰ";
} else {
    if ($_POST['選択実習種別']=="ソーシャルワーク実習Ⅰ"){
    $SEl2_1= "selected";
    }
    if ($_POST['選択実習種別']=="ソーシャルワーク実習Ⅱ"){
    $SEl2_2= "selected";
    }
    if ($_POST['選択実習種別']=="精神保健福祉援助実習Ⅰ"){
    $SEl2_3= "selected";
    }
    if ($_POST['選択実習種別']=="精神保健福祉援助実習Ⅱ"){
    $SEl2_4= "selected";
    }
}


?>
<form action='assignment_info.php' method='post'>
<table class ="table">
  <tr>
    <td>
      <h5>事業年度:<?php echo $_POST['選択事業年度'];?></h5>

    </td>
    <td class="text-right">
      <h5><label for="kubun-select">実習種別:</label>
        <select name="選択実習種別" id="kubun-select">
          <option value="ソーシャルワーク実習Ⅰ" <?php echo $SEl2_1;?>>ソーシャルワーク実習Ⅰ</option>
          <option value="ソーシャルワーク実習Ⅱ" <?php echo $SEl2_2;?>>ソーシャルワーク実習Ⅱ</option>
          <option value="精神保健福祉援助実習Ⅰ" <?php echo $SEl2_3;?>>精神保健福祉援助実習Ⅰ</option>
          <option value="精神保健福祉援助実習Ⅱ" <?php echo $SEl2_4;?>>精神保健福祉援助実習Ⅱ</option>

        </select>
      </h5>
    </td>
    <td class="text-left">
      <button type='submit' class='btn btn-outline-primary btn-sm'>再表示</button>
    </form>
    </td>
  </tr>
</table>


<?php


try {
  // DBへ接続

  $dbh = new PDO(DSN, DB_USER, DB_PASS);
  // SQL作成





$sql = "select tbl_institution.法人ID as s法人ID,tbl_institution.法人名 as s法人名,tbl_institution.施設名 as s施設名 ,tbl_institution.実習種別1 as s実習種別1,tbl_institution.実習種別2 as s実習種別2,tbl_institution.所在地 as s所在地, 事業年度,当該年度の受入人数 ,配属数 from tbl_institution left outer join tbl_assignment on (tbl_institution.法人ID = tbl_assignment.法人ID)  where ((tbl_institution.実習種別1='".$_POST['選択実習種別']."') OR (tbl_institution.実習種別2='".$_POST['選択実習種別']."')) AND 事業年度='".$_POST['選択事業年度']."'";




$cnt = 0;




?>

  <table class="table table-bordered border-secondary">

    <tr>
      <td width="5%" class="text-center align-middle"><span class="fw600">No.</span></td>
      <td class="text-center align-middle"><span class="fw600">年度</span></td>
      <td class="text-center align-middle"><span class="fw600">実習種別1</span></td>
      <td class="text-center align-middle"><span class="fw600">実習種別2</span></td>
      <td class="text-center align-middle"><span class="fw600">法人名</span></td>
      <td class="text-center align-middle"><span class="fw600">施設名</span></td>
      <td class="text-center align-middle"><span class="fw600">所在地</span></td>
      <td class="text-center align-middle"><span class="fw600">当該年度の受入人数</span></td>
      <td class="text-center align-middle"><span class="fw600">現在の配属数</span></td>
      <td width="80px" class="text-center align-middle"><span class="fw600">配属情報</span></td>

    </tr>


    <?php

    $res = $dbh->query($sql);
    foreach ($res as $value) {
      $cnt = $cnt + 1;
      $GLOBALS['法人ID'] = $value['s法人ID'];
      $GLOBALS['実習種別1'] = $value['s実習種別1'];
      $GLOBALS['実習種別2'] = $value['s実習種別2'];
      $GLOBALS['法人名'] = $value['s法人名'];
      $GLOBALS['施設名'] = $value['s施設名'];
      $GLOBALS['所在地'] = $value['s所在地'];
      $GLOBALS['当該年度の受入人数'] = $value['当該年度の受入人数'];
      $GLOBALS['配属数'] = $value['配属数'];



    ?>
      <tr>
        <td class="text-center align-middle"><?php echo $cnt; ?></td>
        <td class="text-left align-middle"><?php echo $_POST['選択事業年度']; ?></td>
        <td class="text-left align-middle"><?php echo $実習種別1; ?></td>
        <td class="text-left align-middle"><?php echo $実習種別2; ?></td>
        <td class="text-left align-middle"><?php echo $法人名; ?></td>
        <td class="text-left align-middle"><?php echo $施設名; ?></td>
        <td class="text-left align-middle"><?php echo $所在地; ?></td>
        <td class="text-center align-middle"><?php echo $当該年度の受入人数; ?></td>
        <td class="text-center align-middle"><?php echo $配属数; ?></td>

        <form action='assignment_info_detail.php' method='post'>
          <td class="text-center align-middle">
            <input type='hidden' name='事業年度' value="<?PHP echo $_POST['選択事業年度']; ?>">
            <input type='hidden' name='選択実習種別' value="<?PHP echo $_POST['選択実習種別']; ?>">
            <input type='hidden' name='法人ID' value="<?PHP echo $法人ID; ?>">
            <button type='submit' class='btn btn-outline-primary btn-sm'>配属情報</button>
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


  <?php

  // 接続を閉じる
  $dbh = null;



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