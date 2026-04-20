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


/*require('header_w.php');*/
require('data_keep.php');

$student_number = $_SESSION['STUDENT_NUMBER'];

tbl_profile_READ($student_number);



dsip_midashi("個人情報");

form_submit("registration.php");


_input("氏名", "name", $name, "text", "", "");
_input("ふりがな", "kana", $kana, "text", "", "");
_input("現住所", "adresse", $adresse, "text", "", "");


if ($_SESSION['KUBUN'] <> "教員") {

  _input("現住所の最寄駅", "nearest_station", $nearest_station, "text", "", "");
  _input("最寄駅までの移動手段", "transportation", $transportation, "text", "", "");
  _input("最寄駅までの移動時間", "travel_time", $travel_time, "text", "", "");
  _input("帰省先住所", "hometown", $hometown, "text", "", "");

  _input("連絡先電話番号", "tel", $tel, "text", "", "");

  _input("担任教員名（ゼミ担当教員等）１学年", "professor1", $professor1, "text", "290px", "");
  _input("担任教員名（ゼミ担当教員等）２学年", "professor2", $professor2, "text", "290px", "");
  _input("担任教員名（ゼミ担当教員等）３学年", "professor3", $professor3, "text", "290px", "");
  _input("担任教員名（ゼミ担当教員等）４学年", "professor4", $professor4, "text", "290px", "");
} else {

  echo "<input  type='hidden' value='' name='nearest_station'>";
  echo "<input  type='hidden' value='' name='transportation'>";
  echo "<input  type='hidden' value='' name='travel_time'>";
  echo "<input  type='hidden' value='' name='hometown'>";
  _input("連絡先電話番号", "tel", $tel, "text", "", "");
  echo "<input  type='hidden' value='' name='professor1'>";
  echo "<input  type='hidden' value='' name='professor2'>";
  echo "<input  type='hidden' value='' name='professor3'>";
  echo "<input  type='hidden' value='' name='professor4'>";
}

_input("メールアドレス", "email", $email, "email", "", "");
_input("パスワード変更", "set_pass", "", "password", "", "");


?>
<p class='text-center'>パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。記号は使えません。</p>

<input type='hidden' name='TABLE' value="tbl_profile">
<input type='hidden' name='METHOD' value="UP_DATE">
<input type='hidden' name='ID' value="<?PHP echo $id; ?>">
<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $_SESSION['STUDENT_NUMBER']; ?>">


<table class="table">
  <tr>
    <td>
      <?php btn_submit2("個人情報登録", "", ""); ?>
    </td>
    <td>
      <?php btn_return("index.php", "戻る"); ?>
    </td>
  </tr>
</table>

<?PHP

echo "</form>";

require('./disp_parts/footer.php');
exit;
?>