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


$ACTION = "master_list.php";


require('./disp_parts/headerNonlist.php');
/*require('./disp_parts/header.php');
require('data_keep.php');*/



//////////何年度の表の提出状況を表示するか

$pdo = new PDO(DSN, DB_USER, DB_PASS);

if ($_POST['table_name']=="") {
  $_POST['table_name']=$_session(['TABLE_NAME']);
}



$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SHOW COLUMNS FROM " . $_POST['table_name'];






$sth = $pdo->query($sql);
$aryColumn = $sth->fetchAll(PDO::FETCH_COLUMN);

$Col00 = $aryColumn[0];
$Col01 = $aryColumn[1];
$Col02 = $aryColumn[2];
$Col03 = $aryColumn[3];
$Col04 = $aryColumn[4];
$Col05 = $aryColumn[5];
$Col06 = $aryColumn[6];
$Col07 = $aryColumn[7];

$www = "";


if (isset($_POST['redisp'])) {
  if ($_POST['redisp'] == "redisp") {


    if ($_POST[$Col00] <> "") {
      if ($www == "") {
        $www = " where " . $Col00 . " LIKE '%" . $_POST[$Col00] . "%' ";
      } else {
        $www = $www . "AND " . $Col00 . " LIKE '%" . $_POST[$Col00] . "%' ";
      }
    }


    if ($_POST[$Col01] <> "") {
      if ($www == "") {
        $www = " where " . $Col01 . " LIKE '%" . $_POST[$Col01] . "%' ";
      } else {
        $www = $www . "AND " . $Col01 . " LIKE '%" . $_POST[$Col01] . "%' ";
      }
    }

    if ($_POST[$Col02] <> "") {
      if ($www == "") {
        $www = " where " . $Col02 . " LIKE '%" . $_POST[$Col02] . "%' ";
      } else {
        $www = $www . "AND " . $Col02 . " LIKE '%" . $_POST[$Col02] . "%' ";
      }
    }

    if ($_POST[$Col03] <> "") {
      if ($www == "") {
        $www = " where " . $Col03 . " LIKE '%" . $_POST[$Col03] . "%' ";
      } else {
        $www = $www . "AND " . $Col03 . " LIKE '%" . $_POST[$Col03] . "%' ";
      }
    }

    if ($_POST[$Col04] <> "") {
      if ($www == "") {
        $www = " where " . $Col04 . " LIKE '%" . $_POST[$Col04] . "%' ";
      } else {
        $www = $www . "AND " . $Col04 . " LIKE '%" . $_POST[$Col04] . "%' ";
      }
    }

    if ($_POST[$Col05] <> "") {
      if ($www == "") {
        $www = " where " . $Col05 . " LIKE '%" . $_POST[$Col05] . "%' ";
      } else {
        $www = $www . "AND " . $Col05 . " LIKE '%" . $_POST[$Col05] . "%' ";
      }
    }
    if ($_POST[$Col06] <> "") {
      if ($www == "") {
        $www = " where " . $Col06 . " LIKE '%" . $_POST[$Col06] . "%' ";
      } else {
        $www = $www . "AND " . $Col06 . " LIKE '%" . $_POST[$Col06] . "%' ";
      }
    }
  }
}


$_SESSION['TABLE_NAME'] = $_POST['table_name'];


dsip_midashi($_POST['table_title'] . "(" . $_POST['table_name'] . ")");




?>

<table class="table table-striped">

  <tr>
    <td width='60px'>
      KEY<br>WORD
    </td>
    <form action='master_disp.php' method='post'>


      <td width='50px'>
        <?php _inputv($Col00, "", "text", "edit", "", "255"); ?>
      </td>

      <td width='140px'>
        <?php _inputv($Col01, "", "text", "edit", "", "255"); ?>
      </td>

      <td width='50px'>
        <?php _inputv($Col02, "", "text", "edit", "", "255"); ?>
      </td>

      <td>
        <?php _inputv($Col03, "", "text", "edit", "", "255"); ?>
      </td>

      <td>
        <?php _inputv($Col04, "", "text", "edit", "", "255"); ?>
      </td>


      <td>
        <?php _inputv($Col05, "", "text", "edit", "", "255"); ?>
      </td>

      <td>
        <?php _inputv($Col06, "", "text", "edit", "", "255"); ?>
      </td>




      <td class="text-center align-middle" width='100px'>
        <input type='hidden' name='table_name' value="<?php echo $_POST['table_name']; ?>">
        <input type='hidden' name='table_title' value="<?php echo $_POST['table_title']; ?>">
        <button type='submit' name='redisp' value='redisp' class='btn btn-outline-primary btn-sm'>絞込</button>
      </td>
    </form>



  </tr>


  <tr>
    <td>
      No.
    </td>

    <td>【
      <?php echo $Col00; ?>
      】</td>


    <td>【
      <?php echo $Col01; ?>
      】</td>

    <td>【
      <?php echo $Col02; ?>
      】</td>

    <td>【
      <?php echo $Col03; ?>
      】</td>

    <td>【
      <?php echo $Col04; ?>
      】</td>


    <td>【
      <?php echo $Col05; ?>
      】 </td>


    <td>【
      <?php echo $Col06; ?>
      】 </td>


    <td>【
      詳細
      】 </td>

  </tr>

  <?php



  try {
    // DBへ接続

    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成

    $where = "whrer=";
    $sql = "select * from " . $_POST['table_name'] . $www;
    $cnt = 0;



    $res = $dbh->query($sql);
    foreach ($res as $value) {
      $cnt = $cnt + 1;

      $dat00 = $value[$Col00];
      $dat01 = $value[$Col01];
      $dat02 = $value[$Col02];
      $dat03 = $value[$Col03];
      $dat04 = $value[$Col04];
      $dat05 = $value[$Col05];
      $dat06 = $value[$Col06];
      $dat07 = $value[$Col07];




  ?>
      <tr>
        <td class="text-center align-middle"><?php echo $cnt; ?></td>
        <td class="text-left align-middle"><?php echo $dat00; ?></td>
        <td class="text-left align-middle"><?php echo $dat01; ?></td>
        <td class="text-left align-middle"><?php echo $dat02; ?></td>
        <td class="text-left align-middle"><?php echo $dat03; ?></td>
        <td class="text-left align-middle"><?php echo $dat04; ?></td>
        <td class="text-left align-middle"><?php echo $dat05; ?></td>

        <td class="text-left align-middle"><?php echo $dat06; ?></td>


        <form action='master_detail.php' method='post'>
          <td class="text-center align-middle">
            <input type='hidden' name='ID' value="<?PHP echo $dat00; ?>">
            <input type='hidden' name='table_name' value="<?php echo $_POST['table_name']; ?>">
            <input type='hidden' name='table_title' value="<?php echo $_POST['table_title']; ?>">
            <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
          </td>
        </form>

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
    <td>
      <?php btn_return("master_list.php", "戻る"); ?>
    </td>
  </tr>
</table>

<?PHP





require('./disp_parts/footer.php');
exit;
?>