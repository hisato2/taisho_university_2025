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


if (!isset($_POST['SQL_DATA'])){
    $_POST['SQL_DATA']="";
}


require_once('../../files/config_db_taisho2025.php');
require_once('./common/function.php');

$ACTION="index.php";

require('./disp_parts/header.php');


dsip_midashi("学生情報一括登録");



if (isset($_POST['mode']) and (strlen($_POST['SQL_DATA']))>92) {


  if ($_POST['mode'] == "INSERT") {
    $str_csv = $_POST['SQL_DATA'];

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
     
      $stmt = $pdo->prepare($str_csv);
      $stmt->execute();
    } catch (\Exception $e) {
      

      dsip_msg("学籍番号、あるいはメールアドレスが重複している可能性があります<br>".$e->getMessage());
      btn_return("bulk_registration.php","戻る");
      exit;


    }


      dsip_msg("追加しました");
      btn_return("index.php","戻る");
      exit;


  }

}




$stdn = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
$name = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
$emai = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
$pass = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
$kubun = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

$kubun2 = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');


if (isset($_POST['mode'])) {



  if ($_POST['mode'] == "bulk_data") {
    $str_csv = $_POST['bulk_data'];
    // カンマ区切りのデータを配列にする
    $fruits = explode("\n", $str_csv);

    $cnt = count($fruits);


    for ($i = 0; $i < $cnt; $i++) {

      $str_csv = $fruits[$i];
      $koumoki = explode(",", $str_csv);

      if (isset($koumoki[0])) {
        $stdn[$i]  = $koumoki[0];
      }
      if (isset($koumoki[1])) {
        $name[$i]  = $koumoki[1];
      }
      if (isset($koumoki[2])) {
        $emai[$i]  = $koumoki[2];
      }
      if (isset($koumoki[3])) {
        $pass[$i]  = $koumoki[3];
      }
      if (isset($koumoki[4])) {
        $kubun[$i]  = trim($koumoki[4]);
      }
    }
  }


  if ($_POST['mode'] == "clier") {
    $str_csv = "";
    // カンマ区切りのデータを配列にする
    

    $cnt = 70;

    for ($i = 0; $i < $cnt; $i++) {

      $str_csv = "";
      $koumoki = "";
      $stdn[$i]  = "";
      $name[$i]  = "";
      $emai[$i]  ="";
      $pass[$i]  ="";
    }
  }




}

//////////何年度の表の提出状況を表示するか


form_submit("bulk_registration.php");
?>
<table class="table">
  <tr>
    <td class="text-center align-middle bg-primary2">
      <span class="fw600">①CSV形式でリストを作成する<br>②CSVファイルをメモ帳で開く<br>③メモ帳で開いた内容を左の枠にコピー＆ペーストする<br></span>
      <span class="fw600">④学生の場合は区分を「学生」、<br>教員・事務局の場合は区分を「教員」とする</span>
    </td>
    <td>
      <div class="input-group mb-0">
        <textarea class="form-control" rows="10" cols="60" name="bulk_data"></textarea>
      </div>
    </td>
  </tr>
</table>

<table class="table">
  <tr>
    <td>
      <div class="text-center" style="height:100px">
        <button type='submit' class='btn btn-secondary w-200px'>読み込む</button>
        <input type='hidden' name='mode' value="bulk_data">
        </form>
      </div>
    </td>
  </tr>
</table>

<table class="table table-bordered border-secondary">
  <tr>

    <td><span class="fw600">学籍番号</span></td>
    <td><span class="fw600">氏名</span></td>
    <td><span class="fw600">メールアドレス</span></td>
    <td><span class="fw600">仮パスワード</span></td>
    <td><span class="fw600">区分</span></td>
  </tr>
  <?php

  $sql = "INSERT INTO `tbl_profile` (`student_number`, `name`, `email`, `password`, `kubun`) VALUES ";

  for ($i = 0; $i < 70; $i++) {
    if ($i > 0) {

      if ($stdn[$i] != "") {
        $sql = $sql . ",";
      }
    }

    echo "<tr height='26px'>";
    echo  "<td>" . $stdn[$i] . "</td>";
    echo  "<td>" . $name[$i] . "</td>";
    echo  "<td>" . $emai[$i] . "</td>";
    echo  "<td>" . $pass[$i] . "</td>";
    echo  "<td>" . $kubun[$i] . "</td>";
    echo "</tr>";

    if ($stdn[$i] != "") {
      $sql = $sql . "('" . $stdn[$i] . "','" . $name[$i] . "','" . $emai[$i] . "','" . $pass[$i] . "','" . $kubun[$i]."')";
    }
  }
  $sql = $sql . ";";


  echo "</table>";


  form_submit("bulk_registration.php");


  

  ?>


  <input type='hidden' name='SQL_DATA' value="<?php echo $sql; ?>">
  <input type='hidden' name='mode' value="INSERT">

  

  <table class="table">
    <tr>

      <td>
        <?php btn_submit("一括登録","","登録");?>
      </td>



      <?php form_submit("bulk_registration.php");?>
      <input type='hidden' name='mode' value="clear">

      <td>
  
      

      <?php btn_submit("初期化","","初期化");?>
      </td>


      <td>
        <?php btn_return("index.php", "戻る"); ?>
      </td>
    </tr>
  </table>

  <?PHP
  require('./disp_parts/footer.php');
  exit;
  ?>