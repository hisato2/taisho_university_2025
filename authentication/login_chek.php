<?php
session_start();
require_once('../../../files/config_db_taisho2025.php');
require_once('../common/function.php');
require_once('../disp_parts/msg.php');





//POSTのvalidate
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

  dsip_msg("入力された値が不正です");
  btn_return("../index.php", "戻る");
  exit;
}
//DB内でPOSTされたメールアドレスを検索



try {
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $SQL = "select * from tbl_profile where email = '" . $_POST['email'] . "'";
  $stmt = $pdo->prepare($SQL);

  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}


//emailがDB内に存在しているか確認
if (!isset($row['email'])) {

  dsip_msg("メールアドレスが間違っています");
  btn_return("../index.php", "戻る");
  exit;
}



  if ($_POST['password'] == $row['password']) {


    session_regenerate_id(true); //session_idを新しく生成し、置き換える
    $_SESSION['EMAIL'] = $row['email'];
    $_SESSION['NAME'] = $row['name'];
    $_SESSION['KANA'] = $row['kana'];
    $_SESSION['KUBUN'] =  trim($row['kubun']);
    $_SESSION['STUDENT_NUMBER'] =  $row['student_number'];


    dsip_msg("仮パスワードです。プロフィール画面でパスワードの再設定をお願いします");
    btn_return("../index.php", "戻る");  
    
   
    exit;
  }




//パスワードの正規表現
if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
} else {


  dsip_msg("パスワードが間違っています");

  btn_return("../index.php", "戻る");
  exit;
}


///stop($password."***".$_POST['password']);

//パスワード確認後sessionにメールアドレスを渡す
if (password_verify($_POST['password'], $row['password'])) {

  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['EMAIL'] = $row['email'];
  $_SESSION['NAME'] = $row['name'];
  $_SESSION['KANA'] = $row['kana'];
  $_SESSION['KUBUN'] = trim($row['kubun']);
  $_SESSION['STUDENT_NUMBER'] = $row['student_number'];
  header("Location: ../index.php");
} else {



  dsip_msg("パスワードが間違っています");
  btn_return("../index.php", "戻る");
  exit;
}
