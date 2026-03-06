<?php

require_once('../../files/config_db_taisho2025.php');
require_once('./common/function.php');
require_once('./disp_parts/msg.php');



//データベースへ接続、テーブルがない場合は作成

//POSTのValidate。
if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    dsip_msg("入力された値が不正です。<br>再度入力をお願いします");
    btn_history_back();

    exit;


}


//パスワードの正規表現
if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

} else {

    dsip_msg("パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。記号は使えません。<br>再度入力をお願いします。");
      btn_history_back();

    exit;
}

//登録処理
try {
  $email = $_POST['email'];
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // 更新する値と該当のIDを配列に格納する
  $sql = "UPDATE tbl_profile SET password = '" . $password . "' WHERE email = ?";



  $stmt = $pdo->prepare($sql);
  $stmt->execute([$email]);

  dsip_msg("パスワードを設定しました");
  btn_return("index.php", "戻る");
  exit;


} catch (\Exception $e) {


  dsip_msg("再設定失敗しました。再度入力をおねがいします");
    btn_history_back();
  exit;


}
