<?php
// *********************************************************************
// 
// 初期設定
// 
// *********************************************************************
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


require_once('tcpdf/tcpdf.php');
require_once('fpdi/src/autoload.php');

use setasign\Fpdi\TcpdfFpdi;

$pdf = new TcpdfFpdi();
$pdf->SetMargins(0, 0, 0);
$pdf->SetCellPadding(0);
$pdf->SetAutoPageBreak(false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);




$_REQUEST["iii_a_AA"] = "";
$_REQUEST["iii_a_AB"] =  "";

$_REQUEST["iii_a_F"] =  "";
$_REQUEST["iii_a_G"] =  "";
$_REQUEST["iii_a_K"] = "";
//$_REQUEST["iii_a_J"] =  $value['iii_a_J'];


$_REQUEST["iii_a_ID"] =  "";
$_REQUEST["iii_c_A"] =  "";
$_REQUEST["iii_a_V"] =  "";

$_REQUEST["iii_c_O"] =  "";
$_REQUEST["iii_c_Q"] =  "";
$_REQUEST["iii_c_R"] =  "";
$_REQUEST["iii_c_T"] =  "";
$_REQUEST["iii_c_U"] =  "";
$_REQUEST["iii_c_V"] =  "";
$_REQUEST["iii_c_AA"] =   "";
$_REQUEST["iii_c_AC"] =   "";
$_REQUEST["iii_c_AD"] =   "";
$_REQUEST["iii_c_AE"] =   "";
$_REQUEST["iii_c_AF"] =   "";
$_REQUEST["iii_c_AH"] =   "";

$_REQUEST["iii_c_AM"] =   "";
$_REQUEST["iii_c_AO"] =   "";
$_REQUEST["iii_c_AP"] =   "";
$_REQUEST["iii_c_AQ"] =   "";
$_REQUEST["iii_c_AR"] =   "";
$_REQUEST["iii_c_AT"] =   "";

$_REQUEST["iii_c_AY"] =   "";
$_REQUEST["iii_c_BA"] =   "";
$_REQUEST["iii_c_BB"] =   "";
$_REQUEST["iii_c_BC"] =   "";
$_REQUEST["iii_c_BD"] =   "";
$_REQUEST["iii_c_BF"] =   "";


$_REQUEST["iii_c_BK"] =   "";
$_REQUEST["iii_c_BM"] =   "";
$_REQUEST["iii_c_BN"] =   "";
$_REQUEST["iii_c_BP"] =   "";
$_REQUEST["iii_c_BQ"] =   "";
$_REQUEST["iii_c_BR"] =   "";

$_REQUEST["iii_c_BM"] =  "";


$_REQUEST["iii_c_S"] =  "";
$_REQUEST["iii_c_AE"] =  "";
$_REQUEST["iii_c_AQ"] =  "";
$_REQUEST["iii_c_BC"] =  "";
$_REQUEST["iii_c_BO"] =  "";



$_REQUEST["iii_a_B"] =  "";
$_REQUEST["iii_a_C"] =  "";
$_REQUEST["iii_a_E"] =  "";
$_REQUEST["iii_a_D"] =  "";





$_REQUEST["iii_a_AA"] = "";
$_REQUEST["iii_a_AB"] =  "";

$_REQUEST["iii_a_F"] =  "";
$_REQUEST["iii_a_G"] =  "";
$_REQUEST["iii_a_K"] = "";
//$_REQUEST["iii_a_J"] =  $value['iii_a_J'];


$item["iii_a_ID"] =  "";
$item["iii_c_A"] =  "";
$item["iii_a_V"] =  "";

$item["iii_c_O"] =  "";
$item["iii_c_Q"] =  "";
$item["iii_c_R"] =  "";
$item["iii_c_T"] =  "";
$item["iii_c_U"] =  "";
$item["iii_c_V"] =  "";
$item["iii_c_AA"] =   "";
$item["iii_c_AC"] =   "";
$item["iii_c_AD"] =   "";
$item["iii_c_AE"] =   "";
$item["iii_c_AF"] =   "";
$item["iii_c_AH"] =   "";

$item["iii_c_AM"] =   "";
$item["iii_c_AO"] =   "";
$item["iii_c_AP"] =   "";
$item["iii_c_AQ"] =   "";
$item["iii_c_AR"] =   "";
$item["iii_c_AT"] =   "";

$item["iii_c_AY"] =   "";
$item["iii_c_BA"] =   "";
$item["iii_c_BB"] =   "";
$item["iii_c_BC"] =   "";
$item["iii_c_BD"] =   "";
$item["iii_c_BF"] =   "";


$item["iii_c_BK"] =   "";
$item["iii_c_BM"] =   "";
$item["iii_c_BN"] =   "";
$item["iii_c_BP"] =   "";
$item["iii_c_BQ"] =   "";
$item["iii_c_BR"] =   "";

$item["iii_c_BM"] =  "";


$item["iii_c_S"] =  "";
$item["iii_c_AE"] =  "";
$item["iii_c_AQ"] =  "";
$item["iii_c_BC"] =  "";
$item["iii_c_BO"] =  "";



$item["iii_a_B"] =  "";
$item["iii_a_C"] =  "";
$item["iii_a_E"] =  "";
$item["iii_a_D"] =  "";



try {
  // DBへ接続
  $dbh = new PDO(DSN, DB_USER, DB_PASS);


  $sql = "SELECT tbl_institution.法人名 AS iii_a_F,";
  $sql = $sql . "tbl_institution.施設名 AS iii_a_G,";
  $sql = $sql . "tbl_institution.管理者 AS iii_a_K,";
  $sql = $sql . "tbl_institution.実習種別1 AS iii_a_B,";
  $sql = $sql . "tbl_institution.実習種別1実日数 AS iii_a_C,";
  $sql = $sql . "tbl_institution.実習種別2 AS iii_a_D,";
  $sql = $sql . "tbl_institution.実習種別2実日数 AS iii_a_E,";
  $sql = $sql . "tbl_institution.日委託費 AS iii_a_AA,";
  $sql = $sql . "tbl_institution.総委託費 AS iii_a_AB,";
  $sql = $sql . "tbl_institution.管理者役職名 AS iii_a_J,";
  $sql = $sql . "tbl_institution.形態 AS iii_a_V,";


  $sql = $sql . "tbl_assignment.配属情報ID AS iii_a_ID,";
  $sql = $sql . "tbl_assignment.事業年度 AS iii_c_A,";


  $sql = $sql . "tbl_assignment.実習種別1 AS iii_c_O,";
  $sql = $sql . "tbl_assignment.氏名1 AS iii_c_Q,";
  $sql = $sql . "tbl_assignment.学年1 AS iii_c_R,";
  $sql = $sql . "tbl_assignment.実習開始日1 AS iii_c_T,";
  $sql = $sql . "tbl_assignment.実習終了日1 AS iii_c_U,";
  $sql = $sql . "tbl_assignment.総実習時間1 AS iii_c_V,";
  $sql = $sql . "tbl_assignment.担当教員1 AS iii_c_S,";


  $sql = $sql . "tbl_assignment.実習種別2 AS iii_c_AA,";
  $sql = $sql . "tbl_assignment.氏名2 AS iii_c_AC,";
  $sql = $sql . "tbl_assignment.学年2 AS iii_c_AD,";
  $sql = $sql . "tbl_assignment.実習開始日2 AS iii_c_AF,";
  $sql = $sql . "tbl_assignment.実習終了日2 AS iii_c_AG,";
  $sql = $sql . "tbl_assignment.総実習時間2 AS iii_c_AH,";
  $sql = $sql . "tbl_assignment.担当教員2 AS iii_c_AE,";


  $sql = $sql . "tbl_assignment.実習種別3 AS iii_c_AM,";
  $sql = $sql . "tbl_assignment.氏名3 AS iii_c_AO,";
  $sql = $sql . "tbl_assignment.学年3 AS iii_c_AP,";
  $sql = $sql . "tbl_assignment.実習開始日3 AS iii_c_AR,";
  $sql = $sql . "tbl_assignment.実習終了日3 AS iii_c_AS,";
  $sql = $sql . "tbl_assignment.総実習時間3 AS iii_c_AT,";
  $sql = $sql . "tbl_assignment.担当教員3 AS iii_c_AQ,";


  $sql = $sql . "tbl_assignment.実習種別4 AS iii_c_AY,";
  $sql = $sql . "tbl_assignment.氏名4 AS iii_c_BA,";
  $sql = $sql . "tbl_assignment.学年4 AS iii_c_BB,";
  $sql = $sql . "tbl_assignment.実習開始日4 AS iii_c_BD,";
  $sql = $sql . "tbl_assignment.実習終了日4 AS iii_c_BE,";
  $sql = $sql . "tbl_assignment.総実習時間4 AS iii_c_BF,";
  $sql = $sql . "tbl_assignment.担当教員4 AS iii_c_BC,";


  $sql = $sql . "tbl_assignment.実習種別5 AS iii_c_BK,";
  $sql = $sql . "tbl_assignment.氏名5 AS iii_c_BM,";
  $sql = $sql . "tbl_assignment.学年5 AS iii_c_BN,";
  $sql = $sql . "tbl_assignment.実習開始日5 AS iii_c_BP,";
  $sql = $sql . "tbl_assignment.実習終了日5 AS iii_c_BQ,";
  $sql = $sql . "tbl_assignment.総実習時間5 AS iii_c_BR,";
  $sql = $sql . "tbl_assignment.担当教員5 AS iii_c_BO";




  $sql = $sql . " FROM tbl_assignment JOIN tbl_institution ON tbl_assignment.法人ID=tbl_institution.法人ID";
  $sql = $sql . " where tbl_assignment.配属情報ID=" . $_POST['配属情報ID'];






  //STOP($sql);

  $res = $dbh->query($sql);


  foreach ($res as $value) {

    $配属人数 = 3;

    if ($value['iii_c_BA'] <> "") {
      $配属人数 = 4;
    }
    if ($value['iii_c_BM'] <> "") {
      $配属人数 = 5;
    }
  }
} catch (PDOException $e) {
  echo $e->getMessage();
  die();
}




$_REQUEST["iii_a_AA"] = $value['iii_a_AA'];
$_REQUEST["iii_a_AB"] = $value['iii_a_AB'];

$_REQUEST["iii_a_F"] = $value['iii_a_F'];
$_REQUEST["iii_a_G"] = $value['iii_a_G'];
$_REQUEST["iii_a_K"] = $value['iii_a_K'] . $value['iii_a_J'] . "様";
//$_REQUEST["iii_a_J"] =  $value['iii_a_J'];


$_REQUEST["iii_a_ID"] = $value['iii_a_ID'];
$_REQUEST["iii_c_A"] =  $value['iii_c_A'];
$_REQUEST["iii_a_V"] = $value['iii_a_V'];

$_REQUEST["iii_c_O"] = $value['iii_c_O'];
$_REQUEST["iii_c_Q"] = $value['iii_c_Q'];
$_REQUEST["iii_c_R"] = $value['iii_c_R'];




$_REQUEST["iii_c_T"] = $value['iii_c_T'];
$_REQUEST["iii_c_U"] = $value['iii_c_U'];



$_REQUEST["iii_c_V"] = $value['iii_c_V'];
$_REQUEST["iii_c_AA"] =  $value['iii_c_AA'];
$_REQUEST["iii_c_AC"] =  $value['iii_c_AC'];
$_REQUEST["iii_c_AD"] =  $value['iii_c_AD'];


$_REQUEST["iii_c_AE"] =  $value['iii_c_AE'];
$_REQUEST["iii_c_AF"] =  $value['iii_c_AF'];


$_REQUEST["iii_c_AH"] =  $value['iii_c_AH'];

$_REQUEST["iii_c_AM"] =  $value['iii_c_AM'];
$_REQUEST["iii_c_AO"] =  $value['iii_c_AO'];
$_REQUEST["iii_c_AP"] =  $value['iii_c_AP'];


$_REQUEST["iii_c_AQ"] =  $value['iii_c_AQ'];
$_REQUEST["iii_c_AR"] =  $value['iii_c_AR'];


$_REQUEST["iii_c_AT"] =  $value['iii_c_AT'];

$_REQUEST["iii_c_AY"] =  $value['iii_c_AY'];
$_REQUEST["iii_c_BA"] =  $value['iii_c_BA'];
$_REQUEST["iii_c_BB"] =  $value['iii_c_BB'];
$_REQUEST["iii_c_BC"] =  $value['iii_c_BC'];
$_REQUEST["iii_c_BD"] =  $value['iii_c_BD'];
$_REQUEST["iii_c_BF"] =  $value['iii_c_BF'];


$_REQUEST["iii_c_BK"] =  $value['iii_c_BK'];
$_REQUEST["iii_c_BM"] =  $value['iii_c_BM'];
$_REQUEST["iii_c_BN"] =  $value['iii_c_BN'];
$_REQUEST["iii_c_BP"] =  $value['iii_c_BP'];
$_REQUEST["iii_c_BQ"] =  $value['iii_c_BQ'];
$_REQUEST["iii_c_BR"] =  $value['iii_c_BR'];

$_REQUEST["iii_c_BM"] = $value['iii_c_BM'];


$_REQUEST["iii_c_S"] = $value['iii_c_S'];
$_REQUEST["iii_c_AE"] = $value['iii_c_AE'];
$_REQUEST["iii_c_AQ"] = $value['iii_c_AQ'];
$_REQUEST["iii_c_BC"] = $value['iii_c_BC'];
$_REQUEST["iii_c_BO"] = $value['iii_c_BO'];



$_REQUEST["iii_a_B"] = $value['iii_a_B'];
$_REQUEST["iii_a_C"] = $value['iii_a_C'];
$_REQUEST["iii_a_E"] = $value['iii_a_E'];
$_REQUEST["iii_a_D"] = $value['iii_a_D'];



// 接続を閉じる
$dbh = null;

// テンプレート読み込み
//$pdf->setSourceFile('template/type1_Practical_contracte_1_3_0912.pdf');

//$pdf->setSourceFile('template/（様式1）実習委託書書式（3名用）.pdf');


$_REQUEST["iii_c_T"] = date("m月d日", strtotime($value['iii_c_T']));
$_REQUEST["iii_c_U"] = date("m月d日", strtotime($value['iii_c_U']));

$_REQUEST["iii_c_AG"] = date("m月d日", strtotime($value['iii_c_AG']));
$_REQUEST["iii_c_AF"] = date("m月d日", strtotime($value['iii_c_AF']));


$_REQUEST["iii_c_AS"] = date("m月d日", strtotime($value['iii_c_AS']));
$_REQUEST["iii_c_AR"] = date("m月d日", strtotime($value['iii_c_AR']));


$_REQUEST["iii_c_BE"] = date("m月d日", strtotime($value['iii_c_BE']));
$_REQUEST["iii_c_BD"] = date("m月d日", strtotime($value['iii_c_BD']));


$_REQUEST["iii_c_BP"] = date("m月d日", strtotime($value['iii_c_BP']));
$_REQUEST["iii_c_BQ"] = date("m月d日", strtotime($value['iii_c_BQ']));


$積算日 = 0;




if ($配属人数 == 3) {


  $pdf = new TcpdfFpdi();
  $pdf->SetMargins(0, 0, 0);
  $pdf->SetCellPadding(0);
  $pdf->SetAutoPageBreak(false);
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);


  $pdf->setSourceFile('template/（様式1）実習委託書書式（3名用）.pdf');
  $pdf->AddPage('R', 'A4');


  $pdf->useTemplate($pdf->importPage(1));
  $tcpdf_fonts = new TCPDF_FONTS();
  $font = $tcpdf_fonts->addTTFfont('tcpdf/fonts/ipam.ttf');


  $yt = 15.5;
  $xl = 15.5;
  $y0 = 5.5;
  $x0 = 3.0;


  $item = array();

  $_REQUEST["iii_a_ID"] = $value['iii_a_ID'];
  $_REQUEST["iii_a_J"] =  $value['iii_a_J'];


  $_REQUEST["iii_a_V"] = $value['iii_a_V'];
  $_REQUEST["name"] = "";

  $_REQUEST["iii_c_A"] = wareki($value['iii_c_A']);





  $item["iii_c_A"]       = array("x" => 47, "y" => 2, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_a_F"]       = array("x" => 1, "y" => 3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_F"]["size"]);
  $pdf->Text($xl + $item["iii_a_F"]["x"] * $x0, $yt + $item["iii_a_F"]["y"] * $y0, $_REQUEST["iii_a_F"]);

  $item["iii_a_G"]       = array("x" => 1, "y" => 4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_G"]["size"]);
  $pdf->Text($xl + $item["iii_a_G"]["x"] * $x0, $yt + $item["iii_a_G"]["y"] * $y0, $_REQUEST["iii_a_G"]);

  $item["iii_a_K"]       = array("x" => 1, "y" => 5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_K"]["size"]);
  $pdf->Text($xl + $item["iii_a_K"]["x"] * $x0, $yt + $item["iii_a_K"]["y"] * $y0, $_REQUEST["iii_a_K"]);

  //$item["iii_a_J"]       = array("x" => 4, "y" => 5, "size" => 11);
  //$pdf->SetFont($font, '', $item["iii_a_J"]["size"]);
  //$pdf->Text($xl + $item["iii_a_J"]["x"] * $x0, $yt + $item["iii_a_J"]["y"] * $y0, $_REQUEST["iii_a_J"]);

  $item["iii_c_A"]       = array("x" => 18.5, "y" => 10.1, "size" => 14);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 - 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 + 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 - 0.1, $_REQUEST["iii_c_A"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 + 0.1, $_REQUEST["iii_c_A"]);




  //1行目
  $dat = $_REQUEST["iii_c_O"] . "　　　　　　　　　　";
  $dat1 = mb_substr($dat, 0, 5, 'utf8');
  $dat2 = mb_substr($dat, 5, 6, 'utf8');



  $item["iii_c_O"]       = array("x" => 1.5, "y" => 20.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_O"]["size"]);
  $pdf->Text($xl + $item["iii_c_O"]["x"] * $x0, $yt + $item["iii_c_O"]["y"] * $y0, $dat1);

  $item["iii_c_O"]       = array("x" => 1.5, "y" => 21.3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_O"]["size"]);
  $pdf->Text($xl + $item["iii_c_O"]["x"] * $x0, $yt + $item["iii_c_O"]["y"] * $y0,  $dat2);




  $dat = $_REQUEST["iii_c_Q"];

  if (strlen($dat) > 18) {
    $dat1 = mb_substr($dat, 0, 6, 'utf8');
    $dat2 = mb_substr($dat, 6, 6, 'utf8');

  
  $item["iii_c_Q"]       = array("x" => 10, "y" => 21-0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_Q"]["size"]);
  $pdf->Text($xl + $item["iii_c_Q"]["x"] * $x0, $yt + $item["iii_c_Q"]["y"] * $y0, $dat1);




  $item["iii_c_Q"]       = array("x" => 10, "y" => 21+0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_Q"]["size"]);
  $pdf->Text($xl + $item["iii_c_Q"]["x"] * $x0, $yt + $item["iii_c_Q"]["y"] * $y0, $dat2);





  } else {
  


  $item["iii_c_Q"]       = array("x" => 10, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_Q"]["size"]);
  $pdf->Text($xl + $item["iii_c_Q"]["x"] * $x0, $yt + $item["iii_c_Q"]["y"] * $y0, $dat1);




  }





  $item["iii_c_R"]       = array("x" => 20, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_R"]["size"]);
  $pdf->Text($xl + $item["iii_c_R"]["x"] * $x0, $yt + $item["iii_c_R"]["y"] * $y0, $_REQUEST["iii_c_R"]);

  $item["iii_c_A"]       = array("x" => 28, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_c_T"]       = array("x" => 31, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_T"]["size"]);
  $pdf->Text($xl + $item["iii_c_T"]["x"] * $x0, $yt + $item["iii_c_T"]["y"] * $y0, $_REQUEST["iii_c_T"]);

  $item["iii_c_U"]       = array("x" => 29, "y" => 21.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_U"]["size"]);
  $pdf->Text($xl + $item["iii_c_U"]["x"] * $x0, $yt + $item["iii_c_U"]["y"] * $y0, $_REQUEST["iii_c_U"]);

  $item["iii_c_V"]       = array("x" => 44, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_V"]["size"]);
  $pdf->Text($xl + $item["iii_c_V"]["x"] * $x0, $yt + $item["iii_c_V"]["y"] * $y0, $_REQUEST["iii_c_V"]);




  $積算日 = $積算日 + (int)$_REQUEST["iii_c_V"];


  $item["iii_a_V"]       = array("x" => 50, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_V"]["size"]);
  $pdf->Text($xl + $item["iii_a_V"]["x"] * $x0, $yt + $item["iii_a_V"]["y"] * $y0, $_REQUEST["iii_a_V"]);




  if ((isset($_REQUEST["iii_c_AC"])) and ($_REQUEST["iii_c_AC"] <> "")) {

    //２行目
    $yt = 15.5;
    $yt = 26.5;
    $dat = $_REQUEST["iii_c_AA"] . "　　　　　　　　　　　　";
    $dat1 = mb_substr($dat, 0, 5, 'utf8');
    $dat2 = mb_substr($dat, 5, 6, 'utf8');

    $item["iii_c_AA"]       = array("x" => 1.5, "y" => 20.6, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AA"]["size"]);
    $pdf->Text($xl + $item["iii_c_AA"]["x"] * $x0, $yt + $item["iii_c_AA"]["y"] * $y0, $dat1);

    $item["iii_c_AA"]       = array("x" => 1.5, "y" => 21.3, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AA"]["size"]);
    $pdf->Text($xl + $item["iii_c_AA"]["x"] * $x0, $yt + $item["iii_c_AA"]["y"] * $y0,  $dat2);




  $dat = $_REQUEST["iii_c_AC"];

  if (strlen($dat) > 18) {
    $dat1 = mb_substr($dat, 0, 6, 'utf8');
    $dat2 = mb_substr($dat, 6, 6, 'utf8');

  


    $item["iii_c_AC"]       = array("x" => 10, "y" => 21-0.4, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AC"]["size"]);
    $pdf->Text($xl + $item["iii_c_AC"]["x"] * $x0, $yt + $item["iii_c_AC"]["y"] * $y0, $dat1);





    $item["iii_c_AC"]       = array("x" => 10, "y" => 21+0.4, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AC"]["size"]);
    $pdf->Text($xl + $item["iii_c_AC"]["x"] * $x0, $yt + $item["iii_c_AC"]["y"] * $y0, $dat2);





  } else {
  


    $item["iii_c_AC"]       = array("x" => 10, "y" => 21, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AC"]["size"]);
    $pdf->Text($xl + $item["iii_c_AC"]["x"] * $x0, $yt + $item["iii_c_AC"]["y"] * $y0, $dat);




  }


    $item["iii_c_AD"]       = array("x" => 20, "y" => 21, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AD"]["size"]);
    $pdf->Text($xl + $item["iii_c_AD"]["x"] * $x0, $yt + $item["iii_c_AD"]["y"] * $y0, $_REQUEST["iii_c_AD"]);

    $item["iii_c_A"]       = array("x" => 28, "y" => 20.5, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
    $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

    $item["iii_c_AF"]       = array("x" => 31, "y" => 20.5, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AF"]["size"]);
    $pdf->Text($xl + $item["iii_c_AF"]["x"] * $x0, $yt + $item["iii_c_AF"]["y"] * $y0, $_REQUEST["iii_c_AF"]);

    $item["iii_c_AG"]       = array("x" => 29, "y" => 21.5, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AG"]["size"]);
    $pdf->Text($xl + $item["iii_c_AG"]["x"] * $x0, $yt + $item["iii_c_AG"]["y"] * $y0, $_REQUEST["iii_c_AG"]);



    $item["iii_c_AH"]       = array("x" => 44, "y" => 21, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AH"]["size"]);
    $pdf->Text($xl + $item["iii_c_AH"]["x"] * $x0, $yt + $item["iii_c_AH"]["y"] * $y0, $_REQUEST["iii_c_AH"]);




    $積算日 = $積算日 + (int)$_REQUEST["iii_c_AH"];


    $item["iii_a_V"]       = array("x" => 50, "y" => 21, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_a_V"]["size"]);
    $pdf->Text($xl + $item["iii_a_V"]["x"] * $x0, $yt + $item["iii_a_V"]["y"] * $y0, $_REQUEST["iii_a_V"]);
  }




  if ((isset($_REQUEST["iii_c_AO"])) and ($_REQUEST["iii_c_AO"] <> "")) {



    //３行目

    $yt = 15.5;
    $yt = 26.5;
    $yt = 38.0;

    $dat = $_REQUEST["iii_c_AM"] . "　　　　　　　　　　　　";
    $dat1 = mb_substr($dat, 0, 5, 'utf8');
    $dat2 = mb_substr($dat, 5, 6, 'utf8');

    $item["iii_c_AM"]       = array("x" => 1.5, "y" => 20.6, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AM"]["size"]);
    $pdf->Text($xl + $item["iii_c_AM"]["x"] * $x0, $yt + $item["iii_c_AM"]["y"] * $y0, $dat1);

    $item["iii_c_AM"]       = array("x" => 1.5, "y" => 21.3, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AM"]["size"]);
    $pdf->Text($xl + $item["iii_c_AM"]["x"] * $x0, $yt + $item["iii_c_AM"]["y"] * $y0,  $dat2);





  $dat = $_REQUEST["iii_c_AO"];

  if (strlen($dat) > 18) {
    $dat1 = mb_substr($dat, 0, 6, 'utf8');
    $dat2 = mb_substr($dat, 6, 6, 'utf8');

  

    $item["iii_c_AO"]       = array("x" => 10, "y" => 21-0.4, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AO"]["size"]);
    $pdf->Text($xl + $item["iii_c_AO"]["x"] * $x0, $yt + $item["iii_c_AO"]["y"] * $y0, $dat1);



    $item["iii_c_AO"]       = array("x" => 10, "y" => 21+0.4, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AO"]["size"]);
    $pdf->Text($xl + $item["iii_c_AO"]["x"] * $x0, $yt + $item["iii_c_AO"]["y"] * $y0, $dat2);


  } else {
  

    $item["iii_c_AO"]       = array("x" => 10, "y" => 21, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AO"]["size"]);
    $pdf->Text($xl + $item["iii_c_AO"]["x"] * $x0, $yt + $item["iii_c_AO"]["y"] * $y0, $dat);



  }





    $item["iii_c_AP"]       = array("x" => 20, "y" => 21, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AP"]["size"]);
    $pdf->Text($xl + $item["iii_c_AP"]["x"] * $x0, $yt + $item["iii_c_AP"]["y"] * $y0, $_REQUEST["iii_c_AP"]);

    $item["iii_c_A"]       = array("x" => 28, "y" => 20.5, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
    $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);



    $item["iii_c_AR"]       = array("x" => 31, "y" => 20.5, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AR"]["size"]);
    $pdf->Text($xl + $item["iii_c_AR"]["x"] * $x0, $yt + $item["iii_c_AR"]["y"] * $y0, $_REQUEST["iii_c_AR"]);

    $item["iii_c_AS"]       = array("x" => 29, "y" => 21.5, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AS"]["size"]);
    $pdf->Text($xl + $item["iii_c_AS"]["x"] * $x0, $yt + $item["iii_c_AS"]["y"] * $y0, $_REQUEST["iii_c_AS"]);




    $item["iii_c_AT"]       = array("x" => 44, "y" => 21, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_AT"]["size"]);
    $pdf->Text($xl + $item["iii_c_AT"]["x"] * $x0, $yt + $item["iii_c_AT"]["y"] * $y0, $_REQUEST["iii_c_AT"]);





    $積算日 = $積算日 + (int)$_REQUEST["iii_c_AT"];


    $item["iii_a_V"]       = array("x" => 50, "y" => 21, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_a_V"]["size"]);
    $pdf->Text($xl + $item["iii_a_V"]["x"] * $x0, $yt + $item["iii_a_V"]["y"] * $y0, $_REQUEST["iii_a_V"]);
  }



  $yt = 15.5;
  $xxx = 0;
  $yyy = 0;

  $item["iii_a_AB"]       = array("x" => 7, "y" => 34.9, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_AB"]["size"]);
  $xxx = $xl + $item["iii_a_AB"]["x"] * $x0;
  $yyy = $yt + $item["iii_a_AB"]["y"] * $y0;

  // 
  $総額 = $積算日 * $_REQUEST["iii_a_AA"];



  if ($_REQUEST["iii_a_AB"] <> "") {
    $pdf->Text($xxx, $yyy, number_format($総額));
  }


  $item["iii_a_AA"]       = array("x" => 18, "y" => 34.9, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_AA"]["size"]);
  $xxx = $xl + $item["iii_a_AA"]["x"] * $x0;
  $yyy = $yt + $item["iii_a_AA"]["y"] * $y0;


  if ($_REQUEST["iii_a_AA"] <> "") {
    $pdf->Text($xxx, $yyy, number_format($_REQUEST["iii_a_AA"]));
  }
}




if ($配属人数 == 4) {


  $pdf = new TcpdfFpdi();
  $pdf->SetMargins(0, 0, 0);
  $pdf->SetCellPadding(0);
  $pdf->SetAutoPageBreak(false);
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);


  $pdf->setSourceFile('template/（様式1）実習委託書書式（4名用）.pdf');
  $pdf->AddPage('R', 'A4');


  $pdf->useTemplate($pdf->importPage(1));
  $tcpdf_fonts = new TCPDF_FONTS();
  $font = $tcpdf_fonts->addTTFfont('tcpdf/fonts/ipam.ttf');


  $yt = 15.5;
  $xl = 15.5;
  $y0 = 5.5;
  $x0 = 3.0;


  $item = array();

  $_REQUEST["iii_a_ID"] = $value['iii_a_ID'];
  $_REQUEST["iii_a_J"] =  $value['iii_a_J'];


  $_REQUEST["iii_a_V"] = $value['iii_a_V'];
  $_REQUEST["name"] = "";

  $_REQUEST["iii_c_A"] = wareki($value['iii_c_A']);







  $item["iii_c_A"]       = array("x" => 47, "y" => 2, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_a_F"]       = array("x" => 1, "y" => 3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_F"]["size"]);
  $pdf->Text($xl + $item["iii_a_F"]["x"] * $x0, $yt + $item["iii_a_F"]["y"] * $y0, $_REQUEST["iii_a_F"]);

  $item["iii_a_G"]       = array("x" => 1, "y" => 4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_G"]["size"]);
  $pdf->Text($xl + $item["iii_a_G"]["x"] * $x0, $yt + $item["iii_a_G"]["y"] * $y0, $_REQUEST["iii_a_G"]);

  $item["iii_a_K"]       = array("x" => 1, "y" => 5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_K"]["size"]);
  $pdf->Text($xl + $item["iii_a_K"]["x"] * $x0, $yt + $item["iii_a_K"]["y"] * $y0, $_REQUEST["iii_a_K"]);

  //$item["iii_a_J"]       = array("x" => 4, "y" => 5, "size" => 11);
  //$pdf->SetFont($font, '', $item["iii_a_J"]["size"]);
  //$pdf->Text($xl + $item["iii_a_J"]["x"] * $x0, $yt + $item["iii_a_J"]["y"] * $y0, $_REQUEST["iii_a_J"]);

  $item["iii_c_A"]       = array("x" => 18.5, "y" => 10.0, "size" => 14);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 - 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 + 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 - 0.1, $_REQUEST["iii_c_A"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 + 0.1, $_REQUEST["iii_c_A"]);


  $yt = 15.5;
  $yt = 10.2;


  //1行目
  $dat = $_REQUEST["iii_c_O"] . "　　　　　　　　　　";
  $dat1 = mb_substr($dat, 0, 5, 'utf8');
  $dat2 = mb_substr($dat, 5, 6, 'utf8');

  $item["iii_c_O"]       = array("x" => 1.5, "y" => 20.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_O"]["size"]);
  $pdf->Text($xl + $item["iii_c_O"]["x"] * $x0, $yt + $item["iii_c_O"]["y"] * $y0, $dat1);

  $item["iii_c_O"]       = array("x" => 1.5, "y" => 21.3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_O"]["size"]);
  $pdf->Text($xl + $item["iii_c_O"]["x"] * $x0, $yt + $item["iii_c_O"]["y"] * $y0,  $dat2);








  $dat = $_REQUEST["iii_c_Q"];

  if (strlen($dat) > 18) {
    $dat1 = mb_substr($dat, 0, 6, 'utf8');
    $dat2 = mb_substr($dat, 6, 6, 'utf8');

  

  $item["iii_c_Q"]       = array("x" => 10, "y" => 21+0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_Q"]["size"]);
  $pdf->Text($xl + $item["iii_c_Q"]["x"] * $x0, $yt + $item["iii_c_Q"]["y"] * $y0, $dat1);


  $item["iii_c_Q"]       = array("x" => 10, "y" => 21-0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_Q"]["size"]);
  $pdf->Text($xl + $item["iii_c_Q"]["x"] * $x0, $yt + $item["iii_c_Q"]["y"] * $y0, $dat2);

  } else {
  

  $item["iii_c_Q"]       = array("x" => 10, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_Q"]["size"]);
  $pdf->Text($xl + $item["iii_c_Q"]["x"] * $x0, $yt + $item["iii_c_Q"]["y"] * $y0, $dat);


  }



  $item["iii_c_R"]       = array("x" => 20, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_R"]["size"]);
  $pdf->Text($xl + $item["iii_c_R"]["x"] * $x0, $yt + $item["iii_c_R"]["y"] * $y0, $_REQUEST["iii_c_R"]);

  $item["iii_c_A"]       = array("x" => 28, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_c_T"]       = array("x" => 31, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_T"]["size"]);
  $pdf->Text($xl + $item["iii_c_T"]["x"] * $x0, $yt + $item["iii_c_T"]["y"] * $y0, $_REQUEST["iii_c_T"]);

  $item["iii_c_U"]       = array("x" => 29, "y" => 21.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_U"]["size"]);
  $pdf->Text($xl + $item["iii_c_U"]["x"] * $x0, $yt + $item["iii_c_U"]["y"] * $y0, $_REQUEST["iii_c_U"]);

  $item["iii_c_V"]       = array("x" => 44, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_V"]["size"]);
  $pdf->Text($xl + $item["iii_c_V"]["x"] * $x0, $yt + $item["iii_c_V"]["y"] * $y0, $_REQUEST["iii_c_V"]);


  $積算日 = $積算日 + (int)$_REQUEST["iii_c_V"];


  $item["iii_a_V"]       = array("x" => 50, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_V"]["size"]);
  $pdf->Text($xl + $item["iii_a_V"]["x"] * $x0, $yt + $item["iii_a_V"]["y"] * $y0, $_REQUEST["iii_a_V"]);
  //２行目

  $yt = 10.2;

  $yt = 21.5;



  $dat = $_REQUEST["iii_c_AA"] . "　　　　　　　　　　　　";
  $dat1 = mb_substr($dat, 0, 5, 'utf8');
  $dat2 = mb_substr($dat, 5, 6, 'utf8');

  $item["iii_c_AA"]       = array("x" => 1.5, "y" => 20.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AA"]["size"]);
  $pdf->Text($xl + $item["iii_c_AA"]["x"] * $x0, $yt + $item["iii_c_AA"]["y"] * $y0, $dat1);

  $item["iii_c_AA"]       = array("x" => 1.5, "y" => 21.3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AA"]["size"]);
  $pdf->Text($xl + $item["iii_c_AA"]["x"] * $x0, $yt + $item["iii_c_AA"]["y"] * $y0,  $dat2);




  $dat = $_REQUEST["iii_c_AC"];

  if (strlen($dat) > 18) {
    $dat1 = mb_substr($dat, 0, 6, 'utf8');
    $dat2 = mb_substr($dat, 6, 6, 'utf8');

  

  $item["iii_c_AC"]       = array("x" => 10, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AC"]["size"]);
  $pdf->Text($xl + $item["iii_c_AC"]["x"] * $x0, $yt + $item["iii_c_AC"]["y"] * $y0, $dat1);


  $item["iii_c_AC"]       = array("x" => 10, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AC"]["size"]);
  $pdf->Text($xl + $item["iii_c_AC"]["x"] * $x0, $yt + $item["iii_c_AC"]["y"] * $y0, $dat2);

  } else {
  

  $item["iii_c_AC"]       = array("x" => 10, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AC"]["size"]);
  $pdf->Text($xl + $item["iii_c_AC"]["x"] * $x0, $yt + $item["iii_c_AC"]["y"] * $y0, $dat);


  }



  $item["iii_c_AD"]       = array("x" => 20, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AD"]["size"]);
  $pdf->Text($xl + $item["iii_c_AD"]["x"] * $x0, $yt + $item["iii_c_AD"]["y"] * $y0, $_REQUEST["iii_c_AD"]);

  $item["iii_c_A"]       = array("x" => 28, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_c_AF"]       = array("x" => 31, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AF"]["size"]);
  $pdf->Text($xl + $item["iii_c_AF"]["x"] * $x0, $yt + $item["iii_c_AF"]["y"] * $y0, $_REQUEST["iii_c_AF"]);

  $item["iii_c_AG"]       = array("x" => 29, "y" => 21.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AG"]["size"]);
  $pdf->Text($xl + $item["iii_c_AG"]["x"] * $x0, $yt + $item["iii_c_AG"]["y"] * $y0, $_REQUEST["iii_c_AG"]);

  $item["iii_c_AH"]       = array("x" => 44, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AH"]["size"]);
  $pdf->Text($xl + $item["iii_c_AH"]["x"] * $x0, $yt + $item["iii_c_AH"]["y"] * $y0, $_REQUEST["iii_c_AH"]);


  $積算日 = $積算日 + (int)$_REQUEST["iii_c_AH"];

  $item["iii_a_V"]       = array("x" => 50, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_V"]["size"]);
  $pdf->Text($xl + $item["iii_a_V"]["x"] * $x0, $yt + $item["iii_a_V"]["y"] * $y0, $_REQUEST["iii_a_V"]);


  //３行目

  $yt = 21.5;
  $yt = 32.7;


  $dat = $_REQUEST["iii_c_AM"] . "　　　　　　　　　　　　";
  $dat1 = mb_substr($dat, 0, 5, 'utf8');
  $dat2 = mb_substr($dat, 5, 6, 'utf8');

  $item["iii_c_AM"]       = array("x" => 1.5, "y" => 20.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AM"]["size"]);
  $pdf->Text($xl + $item["iii_c_AM"]["x"] * $x0, $yt + $item["iii_c_AM"]["y"] * $y0, $dat1);

  $item["iii_c_AM"]       = array("x" => 1.5, "y" => 21.3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AM"]["size"]);
  $pdf->Text($xl + $item["iii_c_AM"]["x"] * $x0, $yt + $item["iii_c_AM"]["y"] * $y0,  $dat2);



  $dat = $_REQUEST["iii_c_AQ"];

  if (strlen($dat) > 18) {
    $dat1 = mb_substr($dat, 0, 6, 'utf8');
    $dat2 = mb_substr($dat, 6, 6, 'utf8');

  $item["iii_c_AO"]       = array("x" => 10, "y" => 21-0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AO"]["size"]);
  $pdf->Text($xl + $item["iii_c_AO"]["x"] * $x0, $yt + $item["iii_c_AO"]["y"] * $y0, $dat1);
  $item["iii_c_AO"]       = array("x" => 10, "y" => 21+0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AO"]["size"]);
  $pdf->Text($xl + $item["iii_c_AO"]["x"] * $x0, $yt + $item["iii_c_AO"]["y"] * $y0, $dat2);
  } else {
  
  $item["iii_c_AO"]       = array("x" => 10, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AO"]["size"]);
  $pdf->Text($xl + $item["iii_c_AO"]["x"] * $x0, $yt + $item["iii_c_AO"]["y"] * $y0, $dat);

  }






  $item["iii_c_AP"]       = array("x" => 20, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AP"]["size"]);
  $pdf->Text($xl + $item["iii_c_AP"]["x"] * $x0, $yt + $item["iii_c_AP"]["y"] * $y0, $_REQUEST["iii_c_AP"]);

  $item["iii_c_A"]       = array("x" => 28, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_c_AR"]       = array("x" => 31, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AR"]["size"]);
  $pdf->Text($xl + $item["iii_c_AR"]["x"] * $x0, $yt + $item["iii_c_AR"]["y"] * $y0, $_REQUEST["iii_c_AR"]);

  $item["iii_c_AS"]       = array("x" => 29, "y" => 21.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AS"]["size"]);
  $pdf->Text($xl + $item["iii_c_AS"]["x"] * $x0, $yt + $item["iii_c_AS"]["y"] * $y0, $_REQUEST["iii_c_AS"]);

  $item["iii_c_AT"]       = array("x" => 44, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AT"]["size"]);
  $pdf->Text($xl + $item["iii_c_AT"]["x"] * $x0, $yt + $item["iii_c_AT"]["y"] * $y0, $_REQUEST["iii_c_AT"]);







  $積算日 = $積算日 + (int)$_REQUEST["iii_c_AT"];


  $item["iii_a_V"]       = array("x" => 50, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_V"]["size"]);
  $pdf->Text($xl + $item["iii_a_V"]["x"] * $x0, $yt + $item["iii_a_V"]["y"] * $y0, $_REQUEST["iii_a_V"]);




  //4行目

  $yt = 32.7;
  $yt = 44.4;



  $dat = $_REQUEST["iii_c_AY"] . "　　　　　　　　　　　　";
  $dat1 = mb_substr($dat, 0, 5, 'utf8');
  $dat2 = mb_substr($dat, 5, 6, 'utf8');

  $item["iii_c_AY"]       = array("x" => 1.5, "y" => 20.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AY"]["size"]);
  $pdf->Text($xl + $item["iii_c_AY"]["x"] * $x0, $yt + $item["iii_c_AY"]["y"] * $y0, $dat1);

  $item["iii_c_AY"]       = array("x" => 1.5, "y" => 21.3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AY"]["size"]);
  $pdf->Text($xl + $item["iii_c_AY"]["x"] * $x0, $yt + $item["iii_c_AY"]["y"] * $y0,  $dat2);


  $dat = $_REQUEST["iii_c_BA"];

  if (strlen($dat) > 18) {
    $dat1 = mb_substr($dat, 0, 6, 'utf8');
    $dat2 = mb_substr($dat, 6, 6, 'utf8');

  
  $item["iii_c_BA"]       = array("x" => 10, "y" => 21-0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BA"]["size"]);
  $pdf->Text($xl + $item["iii_c_BA"]["x"] * $x0, $yt + $item["iii_c_BA"]["y"] * $y0, $dat1);


  $item["iii_c_BA"]       = array("x" => 10, "y" => 21+0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BA"]["size"]);
  $pdf->Text($xl + $item["iii_c_BA"]["x"] * $x0, $yt + $item["iii_c_BA"]["y"] * $y0, $dat2);  } else {

  $item["iii_c_BA"]       = array("x" => 10, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BA"]["size"]);
  $pdf->Text($xl + $item["iii_c_BA"]["x"] * $x0, $yt + $item["iii_c_BA"]["y"] * $y0, $dat);
  }




  $item["iii_c_BB"]       = array("x" => 20, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BB"]["size"]);
  $pdf->Text($xl + $item["iii_c_BB"]["x"] * $x0, $yt + $item["iii_c_BB"]["y"] * $y0, $_REQUEST["iii_c_BB"]);

  $item["iii_c_A"]       = array("x" => 28, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_c_BD"]       = array("x" => 31, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BD"]["size"]);
  $pdf->Text($xl + $item["iii_c_BD"]["x"] * $x0, $yt + $item["iii_c_BD"]["y"] * $y0, $_REQUEST["iii_c_BD"]);

  $item["iii_c_BE"]       = array("x" => 29, "y" => 21.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BE"]["size"]);
  $pdf->Text($xl + $item["iii_c_BE"]["x"] * $x0, $yt + $item["iii_c_BE"]["y"] * $y0, $_REQUEST["iii_c_BE"]);

  $item["iii_c_BF"]       = array("x" => 44, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BF"]["size"]);
  $pdf->Text($xl + $item["iii_c_BF"]["x"] * $x0, $yt + $item["iii_c_BF"]["y"] * $y0, $_REQUEST["iii_c_BF"]);






  $積算日 = $積算日 + (int)$_REQUEST["iii_c_BF"];

  $item["iii_a_V"]       = array("x" => 50, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_V"]["size"]);
  $pdf->Text($xl + $item["iii_a_V"]["x"] * $x0, $yt + $item["iii_a_V"]["y"] * $y0, $_REQUEST["iii_a_V"]);


  $yt = 21.4;


  $item["iii_a_AB"]       = array("x" => 7, "y" => 34.9, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_AB"]["size"]);



  //  if ($_REQUEST["iii_a_AB"] <> "") {
  //    $pdf->Text($xl + $item["iii_a_AB"]["x"] * $x0, $yt + $item["iii_a_AB"]["y"] * $y0, number_format($_REQUEST["iii_a_AB"]));
  //  }

  // 
  $総額 = $積算日 * $_REQUEST["iii_a_AA"];
  //  stop($積算日."*".$_REQUEST["iii_a_AA"]."=".$総額);




  $yt = 22;
  $xxx = 0;
  $yyy = 0;

  $item["iii_a_AB"]       = array("x" => 7, "y" => 34.9, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_AB"]["size"]);
  $xxx = $xl + $item["iii_a_AB"]["x"] * $x0;
  $yyy = $yt + $item["iii_a_AB"]["y"] * $y0;





  if ($_REQUEST["iii_a_AB"] <> "") {
    $pdf->Text($xxx, $yyy, number_format($総額));
  }




  $item["iii_a_AA"]       = array("x" => 18, "y" => 34.9, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_AA"]["size"]);
  if ($_REQUEST["iii_a_AA"] <> "") {
    $pdf->Text($xl + $item["iii_a_AA"]["x"] * $x0, $yt + $item["iii_a_AA"]["y"] * $y0, number_format($_REQUEST["iii_a_AB"]));
  }
}










if ($配属人数 == 5) {


  $pdf = new TcpdfFpdi();
  $pdf->SetMargins(0, 0, 0);
  $pdf->SetCellPadding(0);
  $pdf->SetAutoPageBreak(false);
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);


  $pdf->setSourceFile('template/（様式1）実習委託書書式（5名用）.pdf');
  $pdf->AddPage('R', 'A4');


  $pdf->useTemplate($pdf->importPage(1));
  $tcpdf_fonts = new TCPDF_FONTS();
  $font = $tcpdf_fonts->addTTFfont('tcpdf/fonts/ipam.ttf');


  $yt = 13.7;
  $xl = 15.5;
  $y0 = 5.5;
  $x0 = 3.0;


  $item = array();

  $_REQUEST["iii_a_ID"] = $value['iii_a_ID'];
  $_REQUEST["iii_a_J"] =  $value['iii_a_J'];


  $_REQUEST["iii_a_V"] = $value['iii_a_V'];
  $_REQUEST["name"] = "";

  $_REQUEST["iii_c_A"] = wareki($value['iii_c_A']);



  $item["iii_c_A"]       = array("x" => 47, "y" => 2, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_a_F"]       = array("x" => 1.5, "y" => 3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_F"]["size"]);
  $pdf->Text($xl + $item["iii_a_F"]["x"] * $x0, $yt + $item["iii_a_F"]["y"] * $y0, $_REQUEST["iii_a_F"]);

  $item["iii_a_G"]       = array("x" => 1.5, "y" => 4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_G"]["size"]);
  $pdf->Text($xl + $item["iii_a_G"]["x"] * $x0, $yt + $item["iii_a_G"]["y"] * $y0, $_REQUEST["iii_a_G"]);

  $item["iii_a_K"]       = array("x" => 1, "y" => 5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_K"]["size"]);
  $pdf->Text($xl + $item["iii_a_K"]["x"] * $x0, $yt + $item["iii_a_K"]["y"] * $y0, $_REQUEST["iii_a_K"]);

  //$item["iii_a_J"]       = array("x" => 4, "y" => 5, "size" => 11);
  //$pdf->SetFont($font, '', $item["iii_a_J"]["size"]);
  //$pdf->Text($xl + $item["iii_a_J"]["x"] * $x0, $yt + $item["iii_a_J"]["y"] * $y0, $_REQUEST["iii_a_J"]);

  $item["iii_c_A"]       = array("x" => 19, "y" => 10, "size" => 14);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 - 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 + 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 - 0.1, $_REQUEST["iii_c_A"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 + 0.1, $_REQUEST["iii_c_A"]);



  $yt = 2.6;


  //1行目
  $dat = $_REQUEST["iii_c_O"] . "　　　　　　　　　　";
  $dat1 = mb_substr($dat, 0, 5, 'utf8');
  $dat2 = mb_substr($dat, 5, 6, 'utf8');

  $item["iii_c_O"]       = array("x" => 1.5, "y" => 20.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_O"]["size"]);
  $pdf->Text($xl + $item["iii_c_O"]["x"] * $x0, $yt + $item["iii_c_O"]["y"] * $y0, $dat1);

  $item["iii_c_O"]       = array("x" => 1.5, "y" => 21.3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_O"]["size"]);
  $pdf->Text($xl + $item["iii_c_O"]["x"] * $x0, $yt + $item["iii_c_O"]["y"] * $y0,  $dat2);





  $dat = $_REQUEST["iii_c_Q"];

  if (strlen($dat) > 18) {
    $dat1 = mb_substr($dat, 0, 6, 'utf8');
    $dat2 = mb_substr($dat, 6, 6, 'utf8');

  

  $item["iii_c_Q"]       = array("x" => 10, "y" => 21-0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_Q"]["size"]);
  $pdf->Text($xl + $item["iii_c_Q"]["x"] * $x0, $yt + $item["iii_c_Q"]["y"] * $y0, $dat1);



  $item["iii_c_Q"]       = array("x" => 10, "y" => 21+0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_Q"]["size"]);
  $pdf->Text($xl + $item["iii_c_Q"]["x"] * $x0, $yt + $item["iii_c_Q"]["y"] * $y0, $dat2);


  } else {
  

  $item["iii_c_Q"]       = array("x" => 10, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_Q"]["size"]);
  $pdf->Text($xl + $item["iii_c_Q"]["x"] * $x0, $yt + $item["iii_c_Q"]["y"] * $y0, $dat);


  }


  $item["iii_c_R"]       = array("x" => 20, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_R"]["size"]);
  $pdf->Text($xl + $item["iii_c_R"]["x"] * $x0, $yt + $item["iii_c_R"]["y"] * $y0, $_REQUEST["iii_c_R"]);

  $item["iii_c_A"]       = array("x" => 28, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_c_T"]       = array("x" => 31, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_T"]["size"]);
  $pdf->Text($xl + $item["iii_c_T"]["x"] * $x0, $yt + $item["iii_c_T"]["y"] * $y0, $_REQUEST["iii_c_T"]);

  $item["iii_c_U"]       = array("x" => 29, "y" => 21.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_U"]["size"]);
  $pdf->Text($xl + $item["iii_c_U"]["x"] * $x0, $yt + $item["iii_c_U"]["y"] * $y0, $_REQUEST["iii_c_U"]);

  $item["iii_c_V"]       = array("x" => 44, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_V"]["size"]);
  $pdf->Text($xl + $item["iii_c_V"]["x"] * $x0, $yt + $item["iii_c_V"]["y"] * $y0, $_REQUEST["iii_c_V"]);






  $積算日 = $積算日 + (int)$_REQUEST["iii_c_V"];


  $item["iii_a_V"]       = array("x" => 50, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_V"]["size"]);
  $pdf->Text($xl + $item["iii_a_V"]["x"] * $x0, $yt + $item["iii_a_V"]["y"] * $y0, $_REQUEST["iii_a_V"]);
  //２行目


  $yt = 14.0;


  $dat = $_REQUEST["iii_c_AA"] . "　　　　　　　　　　　　";
  $dat1 = mb_substr($dat, 0, 5, 'utf8');
  $dat2 = mb_substr($dat, 5, 6, 'utf8');

  $item["iii_c_AA"]       = array("x" => 1.5, "y" => 20.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AA"]["size"]);
  $pdf->Text($xl + $item["iii_c_AA"]["x"] * $x0, $yt + $item["iii_c_AA"]["y"] * $y0, $dat1);

  $item["iii_c_AA"]       = array("x" => 1.5, "y" => 21.3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AA"]["size"]);
  $pdf->Text($xl + $item["iii_c_AA"]["x"] * $x0, $yt + $item["iii_c_AA"]["y"] * $y0,  $dat2);







  $dat = $_REQUEST["iii_c_AC"];

  if (strlen($dat) > 18) {
    $dat1 = mb_substr($dat, 0, 6, 'utf8');
    $dat2 = mb_substr($dat, 6, 6, 'utf8');

  

  $item["iii_c_AC"]       = array("x" => 10, "y" => 21-0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AC"]["size"]);
  $pdf->Text($xl + $item["iii_c_AC"]["x"] * $x0, $yt + $item["iii_c_AC"]["y"] * $y0, $dat1);


  $item["iii_c_AC"]       = array("x" => 10, "y" => 21+0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AC"]["size"]);
  $pdf->Text($xl + $item["iii_c_AC"]["x"] * $x0, $yt + $item["iii_c_AC"]["y"] * $y0, $dat2);


  } else {
  

  $item["iii_c_AC"]       = array("x" => 10, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AC"]["size"]);
  $pdf->Text($xl + $item["iii_c_AC"]["x"] * $x0, $yt + $item["iii_c_AC"]["y"] * $y0, $dat);


  }



  $item["iii_c_AD"]       = array("x" => 20, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AD"]["size"]);
  $pdf->Text($xl + $item["iii_c_AD"]["x"] * $x0, $yt + $item["iii_c_AD"]["y"] * $y0, $_REQUEST["iii_c_AD"]);

  $item["iii_c_A"]       = array("x" => 28, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_c_AF"]       = array("x" => 31, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AF"]["size"]);
  $pdf->Text($xl + $item["iii_c_AF"]["x"] * $x0, $yt + $item["iii_c_AF"]["y"] * $y0, $_REQUEST["iii_c_AF"]);

  $item["iii_c_AG"]       = array("x" => 29, "y" => 21.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AG"]["size"]);
  $pdf->Text($xl + $item["iii_c_AG"]["x"] * $x0, $yt + $item["iii_c_AG"]["y"] * $y0, $_REQUEST["iii_c_AG"]);

  $item["iii_c_AH"]       = array("x" => 44, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AH"]["size"]);
  $pdf->Text($xl + $item["iii_c_AH"]["x"] * $x0, $yt + $item["iii_c_AH"]["y"] * $y0, $_REQUEST["iii_c_AH"]);

  $積算日 = $積算日 + (int)$_REQUEST["iii_c_AH"];


  $item["iii_a_V"]       = array("x" => 50, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_V"]["size"]);
  $pdf->Text($xl + $item["iii_a_V"]["x"] * $x0, $yt + $item["iii_a_V"]["y"] * $y0, $_REQUEST["iii_a_V"]);


  //３行目
  $yt = 25.2;


  $dat = $_REQUEST["iii_c_AM"] . "　　　　　　　　　　　　";
  $dat1 = mb_substr($dat, 0, 5, 'utf8');
  $dat2 = mb_substr($dat, 5, 6, 'utf8');

  $item["iii_c_AM"]       = array("x" => 1.5, "y" => 20.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AM"]["size"]);
  $pdf->Text($xl + $item["iii_c_AM"]["x"] * $x0, $yt + $item["iii_c_AM"]["y"] * $y0, $dat1);

  $item["iii_c_AM"]       = array("x" => 1.5, "y" => 21.3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AM"]["size"]);
  $pdf->Text($xl + $item["iii_c_AM"]["x"] * $x0, $yt + $item["iii_c_AM"]["y"] * $y0,  $dat2);






  $dat = $_REQUEST["iii_c_AO"];

  if (strlen($dat) > 18) {
    $dat1 = mb_substr($dat, 0, 6, 'utf8');
    $dat2 = mb_substr($dat, 6, 6, 'utf8');

  


  $item["iii_c_AO"]       = array("x" => 10, "y" => 21-0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AO"]["size"]);
  $pdf->Text($xl + $item["iii_c_AO"]["x"] * $x0, $yt + $item["iii_c_AO"]["y"] * $y0, $dat1);

  $item["iii_c_AO"]       = array("x" => 10, "y" => 21+0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AO"]["size"]);
  $pdf->Text($xl + $item["iii_c_AO"]["x"] * $x0, $yt + $item["iii_c_AO"]["y"] * $y0, $dat2);

  } else {
  


  $item["iii_c_AO"]       = array("x" => 10, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AO"]["size"]);
  $pdf->Text($xl + $item["iii_c_AO"]["x"] * $x0, $yt + $item["iii_c_AO"]["y"] * $y0, $dat);

  }




  $item["iii_c_AP"]       = array("x" => 20, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AP"]["size"]);
  $pdf->Text($xl + $item["iii_c_AP"]["x"] * $x0, $yt + $item["iii_c_AP"]["y"] * $y0, $_REQUEST["iii_c_AP"]);

  $item["iii_c_A"]       = array("x" => 28, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_c_AR"]       = array("x" => 31, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AR"]["size"]);
  $pdf->Text($xl + $item["iii_c_AR"]["x"] * $x0, $yt + $item["iii_c_AR"]["y"] * $y0, $_REQUEST["iii_c_AR"]);

  $item["iii_c_AS"]       = array("x" => 29, "y" => 21.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AS"]["size"]);
  $pdf->Text($xl + $item["iii_c_AS"]["x"] * $x0, $yt + $item["iii_c_AS"]["y"] * $y0, $_REQUEST["iii_c_AS"]);

  $item["iii_c_AT"]       = array("x" => 44, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AT"]["size"]);
  $pdf->Text($xl + $item["iii_c_AT"]["x"] * $x0, $yt + $item["iii_c_AT"]["y"] * $y0, $_REQUEST["iii_c_AT"]);




  $積算日 = $積算日 + (int)$_REQUEST["iii_c_AT"];

  $item["iii_a_V"]       = array("x" => 50, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_V"]["size"]);
  $pdf->Text($xl + $item["iii_a_V"]["x"] * $x0, $yt + $item["iii_a_V"]["y"] * $y0, $_REQUEST["iii_a_V"]);




  //4行目

  $yt = 37.0;


  $dat = $_REQUEST["iii_c_AY"] . "　　　　　　　　　　　　";
  $dat1 = mb_substr($dat, 0, 5, 'utf8');
  $dat2 = mb_substr($dat, 5, 6, 'utf8');

  $item["iii_c_AY"]       = array("x" => 1.5, "y" => 20.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AY"]["size"]);
  $pdf->Text($xl + $item["iii_c_AY"]["x"] * $x0, $yt + $item["iii_c_AY"]["y"] * $y0, $dat1);

  $item["iii_c_AY"]       = array("x" => 1.5, "y" => 21.3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AY"]["size"]);
  $pdf->Text($xl + $item["iii_c_AY"]["x"] * $x0, $yt + $item["iii_c_AY"]["y"] * $y0,  $dat2);




  $dat = $_REQUEST["iii_c_BA"];

  if (strlen($dat) > 18) {
    $dat1 = mb_substr($dat, 0, 6, 'utf8');
    $dat2 = mb_substr($dat, 6, 6, 'utf8');

  

  $item["iii_c_BA"]       = array("x" => 10, "y" => 21-0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BA"]["size"]);
  $pdf->Text($xl + $item["iii_c_BA"]["x"] * $x0, $yt + $item["iii_c_BA"]["y"] * $y0, $dat1);

   

  $item["iii_c_BA"]       = array("x" => 10, "y" => 21+0.4, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BA"]["size"]);
  $pdf->Text($xl + $item["iii_c_BA"]["x"] * $x0, $yt + $item["iii_c_BA"]["y"] * $y0, $dat2);
  } else {
  

  $item["iii_c_BA"]       = array("x" => 10, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BA"]["size"]);
  $pdf->Text($xl + $item["iii_c_BA"]["x"] * $x0, $yt + $item["iii_c_BA"]["y"] * $y0, $dat);
  }






  $item["iii_c_BB"]       = array("x" => 20, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BB"]["size"]);
  $pdf->Text($xl + $item["iii_c_BB"]["x"] * $x0, $yt + $item["iii_c_BB"]["y"] * $y0, $_REQUEST["iii_c_BB"]);

  $item["iii_c_A"]       = array("x" => 28, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_c_BD"]       = array("x" => 31, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BD"]["size"]);
  $pdf->Text($xl + $item["iii_c_BD"]["x"] * $x0, $yt + $item["iii_c_BD"]["y"] * $y0, $_REQUEST["iii_c_BD"]);

  $item["iii_c_BE"]       = array("x" => 29, "y" => 21.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BE"]["size"]);
  $pdf->Text($xl + $item["iii_c_BE"]["x"] * $x0, $yt + $item["iii_c_BE"]["y"] * $y0, $_REQUEST["iii_c_BE"]);

  $item["iii_c_BF"]       = array("x" => 44, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BF"]["size"]);
  $pdf->Text($xl + $item["iii_c_BF"]["x"] * $x0, $yt + $item["iii_c_BF"]["y"] * $y0, $_REQUEST["iii_c_BF"]);





  $積算日 = $積算日 + (int)$_REQUEST["iii_c_BF"];


  $item["iii_a_V"]       = array("x" => 50, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_V"]["size"]);
  $pdf->Text($xl + $item["iii_a_V"]["x"] * $x0, $yt + $item["iii_a_V"]["y"] * $y0, $_REQUEST["iii_a_V"]);







  //5行目
  $yt = 48.3;




  $dat = $_REQUEST["iii_c_BK"] . "　　　　　　　　　　　　";
  $dat1 = mb_substr($dat, 0, 5, 'utf8');
  $dat2 = mb_substr($dat, 5, 6, 'utf8');

  $item["iii_c_BK"]       = array("x" => 1.5, "y" => 20.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BK"]["size"]);
  $pdf->Text($xl + $item["iii_c_BK"]["x"] * $x0, $yt + $item["iii_c_BK"]["y"] * $y0, $dat1);

  $item["iii_c_BK"]       = array("x" => 1.5, "y" => 21.3, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BK"]["size"]);
  $pdf->Text($xl + $item["iii_c_BK"]["x"] * $x0, $yt + $item["iii_c_BK"]["y"] * $y0,  $dat2);



  $dat = $_REQUEST["iii_c_BM"];

  if (strlen($dat) > 18) {
    $dat1 = mb_substr($dat, 0, 6, 'utf8');
    $dat2 = mb_substr($dat, 6, 6, 'utf8');
    $item["iii_c_BM"]       = array("x" => 10, "y" => 21 - 0.4, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_BM"]["size"]);
    $pdf->Text($xl + $item["iii_c_BM"]["x"] * $x0, $yt + $item["iii_c_BM"]["y"] * $y0, $dat1);

    $item["iii_c_BM"]       = array("x" => 10, "y" => 21 + 0.4, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_BM"]["size"]);
    $pdf->Text($xl + $item["iii_c_BM"]["x"] * $x0, $yt + $item["iii_c_BM"]["y"] * $y0, $dat2);
  } else {
    $item["iii_c_BM"]       = array("x" => 10, "y" => 21, "size" => 11);
    $pdf->SetFont($font, '', $item["iii_c_BM"]["size"]);
    $pdf->Text($xl + $item["iii_c_BM"]["x"] * $x0, $yt + $item["iii_c_BM"]["y"] * $y0, $dat);
  }






  $item["iii_c_BN"]       = array("x" => 20, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BN"]["size"]);
  $pdf->Text($xl + $item["iii_c_BN"]["x"] * $x0, $yt + $item["iii_c_BN"]["y"] * $y0, $_REQUEST["iii_c_BN"]);

  $item["iii_c_A"]       = array("x" => 28, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
  $pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

  $item["iii_c_BP"]       = array("x" => 31, "y" => 20.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BP"]["size"]);
  $pdf->Text($xl + $item["iii_c_BP"]["x"] * $x0, $yt + $item["iii_c_BP"]["y"] * $y0, $_REQUEST["iii_c_BP"]);

  $item["iii_c_BQ"]       = array("x" => 29, "y" => 21.5, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BQ"]["size"]);
  $pdf->Text($xl + $item["iii_c_BQ"]["x"] * $x0, $yt + $item["iii_c_BQ"]["y"] * $y0, $_REQUEST["iii_c_BQ"]);

  $item["iii_c_BR"]       = array("x" => 44, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BR"]["size"]);
  $pdf->Text($xl + $item["iii_c_BR"]["x"] * $x0, $yt + $item["iii_c_BR"]["y"] * $y0, $_REQUEST["iii_c_BR"]);






  $積算日 = $積算日 + (int)$_REQUEST["iii_c_BR"];



  $item["iii_a_V"]       = array("x" => 50, "y" => 21, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_V"]["size"]);
  $pdf->Text($xl + $item["iii_a_V"]["x"] * $x0, $yt + $item["iii_a_V"]["y"] * $y0, $_REQUEST["iii_a_V"]);



  $yt = 25.8;


  $総額 = $積算日 * $_REQUEST["iii_a_AA"];


  $item["iii_a_AB"]       = array("x" => 7, "y" => 34.9, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_AB"]["size"]);




  if ($_REQUEST["iii_a_AB"] <> "") {
    $pdf->Text($xl + $item["iii_a_AB"]["x"] * $x0, $yt + $item["iii_a_AB"]["y"] * $y0, number_format($総額));
  }



  $item["iii_a_AA"]       = array("x" => 18, "y" => 34.9, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_a_AA"]["size"]);

  if ($_REQUEST["iii_a_AA"] <> "") {
    $pdf->Text($xl + $item["iii_a_AA"]["x"] * $x0, $yt + $item["iii_a_AA"]["y"] * $y0, number_format($_REQUEST["iii_a_AA"]));
  }
}




//
//
//（様式2）実習委託書かがみ文書式（修正0816版）
//
//
$pdf->setSourceFile('template/（様式2）実習委託書かがみ文書式（修正0314版）.pdf');
$pdf->AddPage('R', 'A4');


$pdf->useTemplate($pdf->importPage(1));
$tcpdf_fonts = new TCPDF_FONTS();
$font = $tcpdf_fonts->addTTFfont('tcpdf/fonts/ipam.ttf');


$yt = 15.9;
$xl = 15.5;
$y0 = 5.5;
$x0 = 3.0;


$item = array();

$_REQUEST["iii_a_ID"] = $value['iii_a_ID'];
$_REQUEST["iii_a_J"] =  $value['iii_a_J'];


$_REQUEST["iii_a_V"] = $value['iii_a_V'];
$_REQUEST["name"] = "";



$_REQUEST["iii_c_A"] = wareki($value['iii_c_A']);








$item["iii_c_A"]       = array("x" => 49, "y" => 1.9, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

$item["iii_a_F"]       = array("x" => 1, "y" => 3, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_F"]["size"]);
$pdf->Text($xl + $item["iii_a_F"]["x"] * $x0, $yt + $item["iii_a_F"]["y"] * $y0, $_REQUEST["iii_a_F"]);

$item["iii_a_G"]       = array("x" => 1, "y" => 4, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_G"]["size"]);
$pdf->Text($xl + $item["iii_a_G"]["x"] * $x0, $yt + $item["iii_a_G"]["y"] * $y0, $_REQUEST["iii_a_G"]);

$item["iii_a_K"]       = array("x" => 1, "y" => 5, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_K"]["size"]);
$pdf->Text($xl + $item["iii_a_K"]["x"] * $x0, $yt + $item["iii_a_K"]["y"] * $y0, $_REQUEST["iii_a_K"]);

$item["iii_c_A"]       = array("x" => 17, "y" => 11.0, "size" => 14);
$pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 - 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 + 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 - 0.1, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 + 0.1, $_REQUEST["iii_c_A"]);



$item["iii_c_A"]       = array("x" => 16, "y" => 15.2, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);



$item["iii_c_S"]       = array("x" => 43.5, "y" => 42.5, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_S"]["size"]);
$pdf->Text($xl + $item["iii_c_S"]["x"] * $x0, $yt + $item["iii_c_S"]["y"] * $y0, mb_substr($_REQUEST["iii_c_S"], 0, 9, 'utf8'));


$item["iii_c_AE"]       = array("x" => 43.5, "y" => 43.4, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_AE"]["size"]);
$pdf->Text($xl + $item["iii_c_AE"]["x"] * $x0, $yt + $item["iii_c_AE"]["y"] * $y0, mb_substr($_REQUEST["iii_c_AE"], 0, 9, 'utf8'));


$item["iii_c_AQ"]       = array("x" => 43.5, "y" => 44.3, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_AQ"]["size"]);
$pdf->Text($xl + $item["iii_c_AQ"]["x"] * $x0, $yt + $item["iii_c_AQ"]["y"] * $y0, mb_substr($_REQUEST["iii_c_AQ"], 0, 9, 'utf8'));


$item["iii_c_BC"]       = array("x" => 43.5, "y" => 45.2, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_BC"]["size"]);
$pdf->Text($xl + $item["iii_c_BC"]["x"] * $x0, $yt + $item["iii_c_BC"]["y"] * $y0, mb_substr($_REQUEST["iii_c_BC"], 0, 9, 'utf8'));




//$pdf->Output(sprintf("MyResume_%s.pdf", time()), 'I');
//
//
//（様式３）実習依頼文
//
//

$pdf->setSourceFile('template/（様式３）実習依頼文.pdf');
$pdf->AddPage('R', 'A4');


$pdf->useTemplate($pdf->importPage(1));
$tcpdf_fonts = new TCPDF_FONTS();
$font = $tcpdf_fonts->addTTFfont('tcpdf/fonts/ipam.ttf');


$yt = 10.7;
$xl = 22.0;
$y0 = 5.5;
$x0 = 3.0;


$item = array();

$_REQUEST["iii_a_ID"] = $value['iii_a_ID'];
$_REQUEST["iii_a_J"] =  $value['iii_a_J'];


$_REQUEST["iii_a_V"] = $value['iii_a_V'];

$_REQUEST["iii_c_A"] = wareki($value['iii_c_A']);







$item["iii_c_A"]       = array("x" => 45, "y" => 1.8, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

$item["iii_a_F"]       = array("x" => 1, "y" => 3, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_F"]["size"]);
$pdf->Text($xl + $item["iii_a_F"]["x"] * $x0, $yt + $item["iii_a_F"]["y"] * $y0, $_REQUEST["iii_a_F"]);

$item["iii_a_G"]       = array("x" => 1, "y" => 4, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_G"]["size"]);
$pdf->Text($xl + $item["iii_a_G"]["x"] * $x0, $yt + $item["iii_a_G"]["y"] * $y0, $_REQUEST["iii_a_G"]);

$item["iii_a_K"]       = array("x" => 1, "y" => 5, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_K"]["size"]);
$pdf->Text($xl + $item["iii_a_K"]["x"] * $x0, $yt + $item["iii_a_K"]["y"] * $y0, $_REQUEST["iii_a_K"]);


$item["iii_c_A"]       = array("x" => 15.0, "y" => 9.9, "size" => 14);
$pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 - 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 + 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 - 0.1, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 + 0.1, $_REQUEST["iii_c_A"]);



$item["iii_a_B"]       = array("x" => 17, "y" => 33.3, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_B"]["size"]);
$pdf->Text($xl + $item["iii_a_B"]["x"] * $x0, $yt + $item["iii_a_B"]["y"] * $y0, $_REQUEST["iii_a_B"]);



$item["iii_a_C"]       = array("x" => 33, "y" => 33.3, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_C"]["size"]);
$pdf->Text($xl + $item["iii_a_C"]["x"] * $x0, $yt + $item["iii_a_C"]["y"] * $y0, $_REQUEST["iii_a_C"]);




$item["iii_a_D"]       = array("x" => 17, "y" => 34.3, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_D"]["size"]);
$pdf->Text($xl + $item["iii_a_D"]["x"] * $x0, $yt + $item["iii_a_D"]["y"] * $y0, $_REQUEST["iii_a_D"]);


$item["iii_a_E"]       = array("x" => 33, "y" => 34.3, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_E"]["size"]);
$pdf->Text($xl + $item["iii_a_E"]["x"] * $x0, $yt + $item["iii_a_E"]["y"] * $y0, $_REQUEST["iii_a_E"]);




//$pdf->Output(sprintf("MyResume_%s.pdf", time()), 'I');
//
//
//（様式５）礼状
//
//



$pdf->setSourceFile('template/（様式５）礼状（修正）.pdf');
$pdf->AddPage('R', 'A4');


$pdf->useTemplate($pdf->importPage(1));
$tcpdf_fonts = new TCPDF_FONTS();
$font = $tcpdf_fonts->addTTFfont('tcpdf/fonts/ipam.ttf');


$yt = 43.8;
$xl = 28.0;
$y0 = 5.5;
$x0 = 3.0;


$item = array();

$_REQUEST["iii_a_ID"] = $value['iii_a_ID'];
$_REQUEST["iii_a_J"] =  $value['iii_a_J'];


$_REQUEST["iii_a_V"] = $value['iii_a_V'];
$_REQUEST["iii_c_A"] = wareki($value['iii_c_A']);




$item["iii_c_A"]       = array("x" => 43, "y" => 1.8, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

$item["iii_a_F"]       = array("x" => 1, "y" => 3, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_F"]["size"]);
$pdf->Text($xl + $item["iii_a_F"]["x"] * $x0, $yt + $item["iii_a_F"]["y"] * $y0, $_REQUEST["iii_a_F"]);

$item["iii_a_G"]       = array("x" => 1, "y" => 4.4, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_G"]["size"]);
$pdf->Text($xl + $item["iii_a_G"]["x"] * $x0, $yt + $item["iii_a_G"]["y"] * $y0, $_REQUEST["iii_a_G"]);

$item["iii_a_K"]       = array("x" => 1, "y" => 5.8, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_K"]["size"]);
$pdf->Text($xl + $item["iii_a_K"]["x"] * $x0, $yt + $item["iii_a_K"]["y"] * $y0, $_REQUEST["iii_a_K"]);






$item["iii_c_A"]       = array("x" => 12, "y" => 12.3, "size" => 14);
$pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 - 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 + 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 - 0.1, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 + 0.1, $_REQUEST["iii_c_A"]);





$item["iii_c_A"]       = array("x" => 17, "y" => 16.4, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);





$item["iii_c_S"]       = array("x" => 37.5, "y" => 35.7, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_S"]["size"]);
$pdf->Text($xl + $item["iii_c_S"]["x"] * $x0, $yt + $item["iii_c_S"]["y"] * $y0, mb_substr($_REQUEST["iii_c_S"], 0, 9, 'utf8'));


$item["iii_c_AE"]       = array("x" => 37.5, "y" => 36.6, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_AE"]["size"]);
$pdf->Text($xl + $item["iii_c_AE"]["x"] * $x0, $yt + $item["iii_c_AE"]["y"] * $y0, mb_substr($_REQUEST["iii_c_AE"], 0, 9, 'utf8'));


$item["iii_c_AQ"]       = array("x" => 37.5, "y" => 37.5, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_AQ"]["size"]);
$pdf->Text($xl + $item["iii_c_AQ"]["x"] * $x0, $yt + $item["iii_c_AQ"]["y"] * $y0, mb_substr($_REQUEST["iii_c_AQ"], 0, 9, 'utf8'));


$item["iii_c_BC"]       = array("x" => 37.5, "y" => 38.4, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_BC"]["size"]);
$pdf->Text($xl + $item["iii_c_BC"]["x"] * $x0, $yt + $item["iii_c_BC"]["y"] * $y0, mb_substr($_REQUEST["iii_c_BC"], 0, 9, 'utf8'));








//$pdf->Output(sprintf("MyResume_%s.pdf", time()), 'I');
//
//
//（様式６）支払通知書
//
//



$pdf->setSourceFile('template/（様式６）支払通知書.pdf');
$pdf->AddPage('R', 'A4');


$pdf->useTemplate($pdf->importPage(1));
$tcpdf_fonts = new TCPDF_FONTS();
$font = $tcpdf_fonts->addTTFfont('tcpdf/fonts/ipam.ttf');


$yt = 31.7;
$xl = 28.0;
$y0 = 5.5;
$x0 = 3.0;


$item = array();

$_REQUEST["iii_a_ID"] = $value['iii_a_ID'];
$_REQUEST["iii_a_J"] =  $value['iii_a_J'];


$_REQUEST["iii_a_V"] = $value['iii_a_V'];
$_REQUEST["iii_c_A"] = wareki($value['iii_c_A']);




$item["iii_c_A"]       = array("x" => 43, "y" => 1.8, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);

$item["iii_a_F"]       = array("x" => 1, "y" => 3, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_F"]["size"]);
$pdf->Text($xl + $item["iii_a_F"]["x"] * $x0, $yt + $item["iii_a_F"]["y"] * $y0, $_REQUEST["iii_a_F"]);

$item["iii_a_G"]       = array("x" => 1, "y" => 4.2, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_G"]["size"]);
$pdf->Text($xl + $item["iii_a_G"]["x"] * $x0, $yt + $item["iii_a_G"]["y"] * $y0, $_REQUEST["iii_a_G"]);

$item["iii_a_K"]       = array("x" => 1, "y" => 5.4, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_K"]["size"]);
$pdf->Text($xl + $item["iii_a_K"]["x"] * $x0, $yt + $item["iii_a_K"]["y"] * $y0, $_REQUEST["iii_a_K"]);


$item["iii_c_A"]       = array("x" => 14, "y" => 11, "size" => 14);
$pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 - 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0 + 0.1, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 - 0.1, $_REQUEST["iii_c_A"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0 + 0.1, $_REQUEST["iii_c_A"]);


$item["iii_c_A"]       = array("x" => 14, "y" => 14.6, "size" => 11);
$pdf->SetFont($font, '', $item["iii_c_A"]["size"]);
$pdf->Text($xl + $item["iii_c_A"]["x"] * $x0, $yt + $item["iii_c_A"]["y"] * $y0, $_REQUEST["iii_c_A"]);



if ($_REQUEST["iii_c_Q"] <> "") {

  $item["iii_c_Q"]       = array("x" => 7, "y" => 28.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_Q"]["size"]);
  $pdf->Text($xl + $item["iii_c_Q"]["x"] * $x0, $yt + $item["iii_c_Q"]["y"] * $y0, mb_substr($_REQUEST["iii_c_Q"], 0, 9, 'utf8') . "（" . $_REQUEST["iii_c_V"] . "）");


  $item["iii_c_V"]       = array("x" => 15, "y" => 28.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_V"]["size"]);
  //$pdf->Text($xl + $item["iii_c_V"]["x"] * $x0, $yt + $item["iii_c_V"]["y"] * $y0, "（" . $_REQUEST["iii_c_V"] . "）");

}

if ($_REQUEST["iii_c_AC"] <> "") {



  $item["iii_c_AC"]       = array("x" => 7, "y" => 29.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AC"]["size"]);
  $pdf->Text($xl + $item["iii_c_AC"]["x"] * $x0, $yt + $item["iii_c_AC"]["y"] * $y0, mb_substr($_REQUEST["iii_c_AC"], 0, 9, 'utf8') . "（" . $_REQUEST["iii_c_AH"] . "）");


  $item["iii_c_AH"]       = array("x" => 15, "y" => 29.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AH"]["size"]);
  //$pdf->Text($xl + $item["iii_c_AH"]["x"] * $x0, $yt + $item["iii_c_AH"]["y"] * $y0, "（" . $_REQUEST["iii_c_AH"] . "）");

}


if ($_REQUEST["iii_c_AO"] <> "") {



  $item["iii_c_AO"]       = array("x" => 7, "y" => 30.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AO"]["size"]);
  $pdf->Text($xl + $item["iii_c_AO"]["x"] * $x0, $yt + $item["iii_c_AO"]["y"] * $y0, mb_substr($_REQUEST["iii_c_AO"], 0, 9, 'utf8') . "（" . $_REQUEST["iii_c_AT"] . "）");


  $item["iii_c_AT"]       = array("x" => 15, "y" => 30.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_AT"]["size"]);
  //$pdf->Text($xl + $item["iii_c_AT"]["x"] * $x0, $yt + $item["iii_c_AT"]["y"] * $y0, "（" . $_REQUEST["iii_c_AT"] . "）");

}


if ($_REQUEST["iii_c_BA"] <> "") {


  $item["iii_c_BA"]       = array("x" => 7, "y" => 31.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BA"]["size"]);
  $pdf->Text($xl + $item["iii_c_BA"]["x"] * $x0, $yt + $item["iii_c_BA"]["y"] * $y0, mb_substr($_REQUEST["iii_c_BA"], 0, 9, 'utf8') . "（" . $_REQUEST["iii_c_BF"] . "）");


  $item["iii_c_BF"]       = array("x" => 15, "y" => 31.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BF"]["size"]);
  //$pdf->Text($xl + $item["iii_c_BF"]["x"] * $x0, $yt + $item["iii_c_BF"]["y"] * $y0, "（" . $_REQUEST["iii_c_BF"] . "）");

}



if ($_REQUEST["iii_c_BM"] <> "") {



  $item["iii_c_BM"]       = array("x" => 7, "y" => 32.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BM"]["size"]);
  $pdf->Text($xl + $item["iii_c_BM"]["x"] * $x0, $yt + $item["iii_c_BM"]["y"] * $y0, mb_substr($_REQUEST["iii_c_BM"], 0, 9, 'utf8') . "（" . $_REQUEST["iii_c_BR"] . "）");

  $item["iii_c_BR"]       = array("x" => 15, "y" => 32.6, "size" => 11);
  $pdf->SetFont($font, '', $item["iii_c_BR"]["size"]);
  //$pdf->Text($xl + $item["iii_c_BR"]["x"] * $x0, $yt + $item["iii_c_BR"]["y"] * $y0, "（" . $_REQUEST["iii_c_BR"] . "）");


}










$item["iii_a_AB"]       = array("x" => 9.4, "y" => 34.4, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_AB"]["size"]);



//$総額=$積算日*$_REQUEST["iii_a_AA"];

if ($_REQUEST["iii_a_AB"] <> "") {
  $pdf->Text($xl + $item["iii_a_AB"]["x"] * $x0, $yt + $item["iii_a_AB"]["y"] * $y0, number_format($総額));
}



$item["iii_a_AA"]       = array("x" => 23, "y" => 35.6, "size" => 11);
$pdf->SetFont($font, '', $item["iii_a_AA"]["size"]);
if ($_REQUEST["iii_a_AA"] <> "") {
  $pdf->Text($xl + $item["iii_a_AA"]["x"] * $x0, $yt + $item["iii_a_AA"]["y"] * $y0, number_format($_REQUEST["iii_a_AA"]));
}


$pdf->Output(sprintf("MyResume_%s.pdf", time()), 'I');
