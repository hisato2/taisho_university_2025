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

$ACTION="index.php";

require('./disp_parts/headerNonlist.php');

//////////何年度の表の提出状況を表示するか


if (!isset($_POST['SYUBETU'])) {
  $SYUBETU= "すべて";
} else {
  $SYUBETU= $_POST['SYUBETU'];
}


dsip_midashi("実習機関リスト");



try {
  // DBへ接続

  $dbh = new PDO(DSN, DB_USER, DB_PASS);
  // SQL作成

  $where = "whrer=";
  $sql = "select * from tbl_institution";
  $cnt = 0;

?>

  <table class="table table-bordered border-secondary">

    <tr>
      <td width="5%" class="text-center align-middle"><span class="fw600">No.</span></td>
      <td class="text-center align-middle"><span class="fw600">実習種別1</span></td>
      <td class="text-center align-middle"><span class="fw600">実習種別2</span></td>
      <td class="text-center align-middle"><span class="fw600">法人名</span></td>
      <td class="text-center align-middle"><span class="fw600">施設名</span></td>
      <td class="text-center align-middle"><span class="fw600">管理者</span></td>
      <td class="text-center align-middle"><span class="fw600">所在地</span></td>
      <td width="80px" class="text-center align-middle"><span class="fw600">機関詳細</span></td>
      <td width="95px" class="text-center align-middle"><span class="fw600">実習指導者</span></td>
    </tr>


    <?php

    $res = $dbh->query($sql);
    foreach ($res as $value) {
        $cnt = $cnt + 1;
        $GLOBALS['法人ID']=$value['法人ID'];
        $GLOBALS['施設区分']=$value['施設区分'];
        $GLOBALS['実習種別1']=$value['実習種別1'];
        $GLOBALS['実習種別1実日数']=$value['実習種別1実日数'];
        $GLOBALS['実習種別2']=$value['実習種別2'];
        $GLOBALS['実習種別2実日数']=$value['実習種別2実日数'];
        $GLOBALS['法人名']=$value['法人名'];
        $GLOBALS['施設名']=$value['施設名'];
        $GLOBALS['施設種別']=$value['施設種別'];
        $GLOBALS['設置者又は経営者']=$value['設置者又は経営者'];
        $GLOBALS['管理者']=$value['管理者'];
        $GLOBALS['管理者役職名']=$value['管理者役職名'];
        $GLOBALS['設置又は開始の年月日']=$value['設置又は開始の年月日'];
        $GLOBALS['実習施設提出年月日']=$value['実習施設提出年月日'];
        $GLOBALS['承諾書記載受入人数']=$value['承諾書記載受入人数'];
        $GLOBALS['当該年度の受入人数']=$value['当該年度の受入人数'];
        $GLOBALS['同時受入可能人数']=$value['同時受入可能人数'];
        $GLOBALS['郵便番号']=$value['郵便番号'];
        $GLOBALS['所在地']=$value['所在地'];
        $GLOBALS['最寄駅']=$value['最寄駅'];
        $GLOBALS['電話番号']=$value['電話番号'];

        $GLOBALS['FAX番号'] = $value['FAX番号'];
        $GLOBALS['MAIL'] = $value['MAIL'];
        $GLOBALS['URL'] = $value['URL'];

        $GLOBALS['実習窓口担当者名']=$value['実習窓口担当者名'];
        $GLOBALS['形態']=$value['形態'];
        $GLOBALS['土日祝実習の有無']=$value['土日祝実習の有無'];
        $GLOBALS['実習委託費以外の費用']=$value['実習委託費以外の費用'];
        $GLOBALS['備考']=$value['備考'];
        $GLOBALS['特記事項']=$value['特記事項'];
        $GLOBALS['日委託費']=$value['日委託費'];
        $GLOBALS['総委託費']=$value['総委託費'];
        $GLOBALS['今年度受入数']=$value['今年度受入数'];
        $GLOBALS['昨年度受入数']=$value['昨年度受入数'];
        $GLOBALS['一昨年度受入数']=$value['一昨年度受入数'];
        $GLOBALS['昨年度受入数']=$value['昨年度受入数'];



    ?>
      <tr>
        <td class="text-center align-middle"><?php echo $cnt; ?></td>
        <td class="text-left align-middle"><?php echo $実習種別1; ?></td>
        <td class="text-left align-middle"><?php echo $実習種別2; ?></td>
        <td class="text-left align-middle"><?php echo $法人名; ?></td>
        <td class="text-left align-middle"><?php echo $施設名; ?></td>
        <td class="text-left align-middle"><?php echo $管理者."<br>(".$管理者役職名.")"; ?></td>
        <td class="text-left align-middle"><?php echo $所在地; ?></td>

        <form action='practice_info_detail.php' method='post'>
          <td class="text-center align-middle">
            <input type='hidden' name='法人ID' value="<?PHP echo $GLOBALS['法人ID']; ?>">
            <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
          </td>
        </form>

        <form action='practice_info_installer.php' method='post'>
          <td class="text-center align-middle">
            <input type='hidden' name='法人ID' value="<?PHP echo $value['法人ID']; ?>">
            <input type='hidden' name='法人名' value="<?PHP echo $value['法人名']; ?>">
            <input type='hidden' name='施設名' value="<?PHP echo $GLOBALS['施設名']; ?>">
            <input type='hidden' name='施設区分' value="<?PHP echo $GLOBALS['施設区分']; ?>">
            <button type='submit' class='btn btn-outline-primary btn-sm'>指導者</button>
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


    <table class="table">

    <tr>
      <td class="text-right align-middle">
        <form action='practice_info_detail.php' method='post'>
            <input type='hidden' name='法人ID' value="9999999999">
            <button type='submit' class='btn btn-outline-primary btn-sm'>実習施設の新規追加</button>
        </form>
        </td>
    </tr>
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