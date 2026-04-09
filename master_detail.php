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


$_POST['ID'] = $_POST['ID'] ?? $_SESSION['ID'] ?? "";
$_SESSION['ID'] = $_POST['ID'];

$_POST['TABLE_NAME'] = $_POST['TABLE_NAME'] ?? $_SESSION['TABLE_NAME'] ?? "";
$_SESSION['TABLE_NAME'] = $_POST['TABLE_NAME'];

$_POST['TABLE_TITLE'] = $_POST['TABLE_TITLE'] ?? $_SESSION['TABLE_TITLE'] ?? "";
$_SESSION['TABLE_TITLE'] = $_POST['TABLE_TITLE'];



if (!isset($_POST['ID'])) {
  $_POST['ID']=$_SESSION['ID'];
}ELSE{
  $_SESSION['ID'] = $_POST['ID'];
}




if (!isset($_POST['TABLE_NAME'])) {
  $_POST['TABLE_NAME']=$_SESSION['TABLE_NAME'];
}ELSE{
  $_SESSION['TABLE_NAME'] = $_POST['TABLE_NAME'];
}


if (!isset($_POST['TABLE_TITLE'])) {
  $_POST['TABLE_TITLE']=$_SESSION['TABLE_TITLE'];
}ELSE{
  $_SESSION['TABLE_TITLE'] = $_POST['TABLE_TITLE'];
}

$ACTION = "master_detail.php";


require('./disp_parts/header_master.php');

/*require('header_w.php');*/
require('data_keep.php');



$pdo = new PDO(DSN, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SHOW COLUMNS FROM " . $_POST['table_name'];
$sth = $pdo->query($sql);
$aryColumn = $sth->fetchAll(PDO::FETCH_COLUMN);



if (!isset($_POST['METHOD'])) {
  $_POST['METHOD'] = "";
}

if (!isset($_POST['title'])) {
  $_POST['title'] = "";
}





if ($_POST['METHOD'] == "UP_DATE")


  if ($_POST['OPERATION'] == "DELETE") {


try {

    $sql = "DELETE from " . $_POST['table_name'] . " WHERE " . $aryColumn[(0)] . "=" . $_POST['ID'];



    $stmt = $pdo->prepare($sql);

    $stmt->execute();
  } catch (\Exception $e) {

    dsip_koumoku($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る", "", "");
  }
  $mysqli = null;

  dsip_msg("削除しました");
  btn_return2("master_disp.php", "戻る", "table_name", $_POST['table_name'], $_POST['table_title']);
  exit;


  } elseif ($_POST['OPERATION'] == "EDIT") {

    try {

      $sql = "UPDATE " . $_POST['table_name'] . " SET ";

      for ($i = 2; $i < $_POST['colcount']; $i++) {
        $sql = $sql . $aryColumn[($i - 1)] . "='" . $_POST[$aryColumn[($i - 1)]] . "',";
      }
      $sql = $sql . $aryColumn[($i - 1)] . "='" . $_POST[$aryColumn[($i - 1)]] . "'";

      $sql = $sql . " WHERE " . $aryColumn[(0)] . "=" . $_POST['ID'];






      $stmt = $pdo->prepare($sql);

      $stmt->execute();
    } catch (\Exception $e) {

      dsip_koumoku($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る", "", "");
    }
    $mysqli = null;



    dsip_msg("更新しました");
    btn_return2("master_disp.php", "戻る", "table_name", $_POST['table_name'], $_POST['table_title']);
    exit;
  }






$_POST['METHOD'] = "";




$ID = $_POST['ID'];
$TABLE_NAME = $_POST['table_name'];
$TABLE_TITLE = $_POST['table_title'];


$_SESSION['TABLE_NAME']=$_POST['table_name'];
$_SESSION['TABLE_TITLE'] = $_POST['table_title'];




$pdo = new PDO(DSN, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

dsip_midashi($TABLE_TITLE . "(" . $TABLE_NAME . ")");

form_submit("master_detail.php");

$colcount = 0;
$coldat = array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",);



tbl_TABLE_READ($TABLE_NAME, $ID, $aryColumn, $colcount, $coldat);





?>

<table class="table table-striped">
  <tr>
    <td>項目</td>
    <td>内容</td>
  </tr>


  <?php

  for ($i = 1; $i <= $colcount; $i++) {
    echo "<tr>";
    echo "<td>" . $aryColumn[($i - 1)] . "</td>";
    echo "<td>";
    if ($i == 1) {
      echo  $coldat[($i - 1)];
    } else {
      _inputv($aryColumn[($i - 1)], $coldat[($i - 1)], "textarea", "edit", "", "512");
    }




    echo "</td>";
    echo "</tr>";
  }


  ?>


</table>


<input type='hidden' name='MASTER' value="MASTER">
<input type='hidden' name='table_name' value="<?PHP echo $TABLE_NAME; ?>">
<input type='hidden' name='table_title' value="<?PHP echo $TABLE_TITLE; ?>">
<input type='hidden' name='METHOD' value="UP_DATE">
<input type='hidden' name='ID' value="<?PHP echo $coldat[(0)]; ?>">
<input type='hidden' name='colcount' value="<?PHP echo $colcount; ?>">



<table class="table">
  <tr>
    <td style="vertical-align:middle;">

      <input type="radio" name="OPERATION" value="EDIT" checked><span style='font-size:20px'>変更する　　</span>
      <input type="radio" name="OPERATION" value="DELETE"><span style='font-size:20px'>削除する　　</span>

    </td>

    <td>
      <?php btn_submit2("変更/削除実行", "", ""); ?>
    </td>


    <td>
      <?php btn_return2("master_disp.php", "戻る", "table_name", $TABLE_NAME, $TABLE_TITLE); ?>
    </td>
  </tr>
</table>

<?PHP


echo "</form>";

require('./disp_parts/footer.php');
exit;
?>