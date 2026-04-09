<?php
session_start();
if (!isset($_SESSION['EMAIL'])) {
  header("Location: index.php");
  exit;
}

function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

require_once('../../files/config_db_taisho2025.php');
require_once('./common/function.php');

$ACTION="index.php";

require('./disp_parts/header.php');

dsip_midashi("学生情報一括登録");


// ============================
// 初期化
// ============================
$stdn = array_fill(0,70,"");
$name = array_fill(0,70,"");
$emai = array_fill(0,70,"");
$pass = array_fill(0,70,"");
$kubun = array_fill(0,70,"");

$bulk_data = $_POST['bulk_data'] ?? "";
$mode = $_POST['mode'] ?? "";


// ============================
// 読み込み
// ============================
if ($mode === "bulk_data") {

  $lines = explode("\n", $bulk_data);

  foreach ($lines as $i => $line) {

    $line = trim($line);
    if ($line === "") continue;

    $cols = explode(",", $line);

    $stdn[$i]  = $cols[0] ?? "";
    $name[$i]  = $cols[1] ?? "";
    $emai[$i]  = $cols[2] ?? "";
    $pass[$i]  = $cols[3] ?? "";
    $kubun[$i] = trim($cols[4] ?? "");
  }
}


// ============================
// 登録処理
// ============================
if ($mode === "INSERT") {

  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  try {

    $sql = $_POST['SQL_DATA'] ?? "";

    if ($sql !== "") {
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
    }

    dsip_msg("登録しました");
    btn_return("index.php","戻る");
    exit;

  } catch (Exception $e) {

    dsip_msg("エラー<br>".$e->getMessage());
    btn_return("bulk_registration.php","戻る");
    exit;
  }
}


// ============================
// 初期化
// ============================
if ($mode === "clear") {
  $bulk_data = "";
}


// ============================
// form開始
// ============================
form_submit("bulk_registration.php");
?>

<table class="table">
<tr>
<td class="text-center align-middle bg-primary2">
CSVを貼り付け
</td>
<td>
<textarea class="form-control" rows="10" name="bulk_data"><?=h($bulk_data)?></textarea>
</td>
</tr>
</table>

<div class="text-center">
<button type="submit" name="mode" value="bulk_data" class="btn btn-secondary">
読み込む
</button>

<button type="submit" name="mode" value="clear" class="btn btn-warning">
初期化
</button>
</div>

<hr>


<!-- ============================
表示＋SQL生成
============================ -->
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
$first = true;

for ($i = 0; $i < 70; $i++) {

  echo "<tr height='26px'>";
  echo "<td>" . h($stdn[$i]) . "</td>";
  echo "<td>" . h($name[$i]) . "</td>";
  echo "<td>" . h($emai[$i]) . "</td>";
  echo "<td>" . h($pass[$i]) . "</td>";
  echo "<td>" . h($kubun[$i]) . "</td>";
  echo "</tr>";

  if ($stdn[$i] != "") {

    if (!$first) {
      $sql .= ",";
    }

    $sql .= "('"
      . $stdn[$i] . "','"
      . $name[$i] . "','"
      . $emai[$i] . "','"
      . $pass[$i] . "','"
      . $kubun[$i]
      . "')";

    $first = false;
  }
}

// ★ここを変更（セミコロン削除してこれに置換）
$sql .= " ON DUPLICATE KEY UPDATE 
name=VALUES(name),
email=VALUES(email),
password=VALUES(password),
kubun=VALUES(kubun);";

echo "</table>";
?>


<!-- SQL送信用 -->
<input type="hidden" name="SQL_DATA" value="<?=h($sql)?>">

<hr>

<div class="text-center">
<button type="submit" name="mode" value="INSERT" class="btn btn-primary">
一括登録
</button>
</div>

<?php
echo "</form>";

require('./disp_parts/footer.php');
exit;
?>