<?php

require_once('./files/config_db_taisho2025.php');
require_once('./common/function.php');
require_once('./disp_parts/msg.php');



$key = '長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵';
$plain_text = $_POST['email'];
$c_t = openssl_encrypt($plain_text, 'AES-128-ECB', $key);
$address = str_replace("+","|",$c_t );


mb_language("Japanese");
mb_internal_encoding("UTF-8");


$subject = 'パスワードの再設定';
$email_body = "以下のリンクよりパスワードの再設定をしてください。";
$email_body = $email_body . "<a href=https://welfare.tais.ac.jp/resetting.php?add=". $address.">パスワード再設定</a>";



$to = $plain_text;
$title = $subject;
$message = $email_body;

$headers = "From:password_reset@welfare.tais.ac.jp";
$headers .= "\r\n";
$headers .= "Content-type: text/html;";




if (mb_send_mail($to, $title, $message, $headers)) {

    dsip_msg("メールアドレスにパスワード再設定画面のリンクを送信しました<br>メールが届かない場合、迷惑メールフォルダに格納されている場合があります");
    btn_return("index.php", "戻る");
    exit;


}
?>
