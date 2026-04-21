<?php

session_start();
require_once('../files/config_db_taisho2025.php');
require_once('../common/function.php');
require_once('../disp_parts/msg.php');



//ステータス書込み




$dbh = new PDO(DSN, DB_USER, DB_PASS);


$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {

  $sql = "UPDATE tbl_profile SET ";
  $sql = $sql . "profile_1='" .$_GET['mode'] ."',";
  $sql = $sql . "profile_2='" .$_GET['mode'] ."',";
  $sql = $sql . "profile_3='" .$_GET['mode'] ."',";
  $sql = $sql . "profile_4='" .$_GET['mode'] ."',";
  $sql = $sql . "goal1Q_1='" .$_GET['mode'] ."',";
  $sql = $sql . "goal1Q_2='" .$_GET['mode'] ."',";
  $sql = $sql . "goal1Q_3='" .$_GET['mode'] ."',";
  $sql = $sql . "goal1Q_4='" .$_GET['mode'] ."',";
  $sql = $sql . "goal4Q_1='" .$_GET['mode'] ."',";
  $sql = $sql . "goal4Q_2='" .$_GET['mode'] ."',";
  $sql = $sql . "goal4Q_3='" .$_GET['mode'] ."',";
  $sql = $sql . "goal4Q_4='" .$_GET['mode'] ."',";
  $sql = $sql . "ref_base_1='" .$_GET['mode'] ."',";
  $sql = $sql . "ref_base_2='" .$_GET['mode'] ."',";
  $sql = $sql . "ref_base_3='" .$_GET['mode'] ."',";
  $sql = $sql . "ref_base_4='" .$_GET['mode'] ."',";

  $sql = $sql . "ref_sw1='" .$_GET['mode'] ."',";
  $sql = $sql . "ref_sw2='" .$_GET['mode'] ."',";
  $sql = $sql . "ref_intern='" .$_GET['mode'] ."',";
  $sql = $sql . "ref_mental1='" .$_GET['mode'] ."',";
  $sql = $sql . "ref_advance='" .$_GET['mode'] ."',";

  $sql = $sql . "sch_sw1='" .$_GET['mode'] ."',";
  $sql = $sql . "sch_sw2='" .$_GET['mode'] ."',";
  $sql = $sql . "sch_mental1='" .$_GET['mode'] ."',";
  $sql = $sql . "sch_mental2='" .$_GET['mode'] ."',";
  $sql = $sql . "sch_advance='" .$_GET['mode'] ."',";

  $sql = $sql . "self_sw1='" .$_GET['mode'] ."',";
  $sql = $sql . "self_sw2='" .$_GET['mode'] ."',";
  $sql = $sql . "self_mental1='" .$_GET['mode'] ."',";
  $sql = $sql . "self_mental2='" .$_GET['mode'] ."',";
  $sql = $sql . "self_advance='" .$_GET['mode'] ."'";


 $sql = $sql . " WHERE student_number='" . $_SESSION['STUDENT_NUMBER'] . "'";


  $stmt = $dbh->prepare($sql);
  $stmt->execute();
} catch (\Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}




      dsip_msg("ステータスを初期化しました");
      btn_return("../index.php", "戻る");




exit;
