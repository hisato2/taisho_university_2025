<?php

//しスステムで使用する関数群です。

use setasign\Fpdi\PdfParser\Filter\Lzw;

$mr = ["", "<span style ='font-weight:900;font-size: 14px;color:darkgoldenrod'>下書中</span>", "<span style ='font-weight:900;font-size: 14px;color:green'>提出済</span>", "<span style ='font-weight:900;font-size: 14px;color:red'>要修正</span>", "<span style ='font-weight:900;font-size: 14px;color:navy'>承認済</span>"];

if (!isset($study_conversion06)) {
  $study_conversion06 = "";
}

//////////////////////////////////////////////////
// 学生プロフィールにたいする教員のコメント書込み
//////////////////////////////////////////////////
function tbl_profile_detail_COMMENT_UP($student_number, $school_year)
{

  $comments_of_teacher = "";

  if ($school_year == 1) {
    $comments_of_teacher = $_POST['comments_of_teacher1'];
  }
  if ($school_year == 2) {
    $comments_of_teacher = $_POST['comments_of_teacher2'];
  }
  if ($school_year == 3) {
    $comments_of_teacher = $_POST['comments_of_teacher3'];
  }
  if ($school_year == 4) {
    $comments_of_teacher = $_POST['comments_of_teacher4'];
  }

  try {

    $sql = "UPDATE tbl_profile_detail SET comments_of_teacher=? WHERE student_number =? AND school_year=?";
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$comments_of_teacher, $student_number, $school_year]);
  } catch (\Exception $e) {
    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }



  $stmt = null;
  $pdo = null;

  dsip_msg("更新しました");
  btn_return("student_list.php", "戻る");
  exit;
}



/////////////////////////////////////////////////////////////////
// 学生が作成した施設概要書に対する教員のコメント書込み
/////////////////////////////////////////////////////////////////

function tbl_student_introduction_COMMENTUP($student_number)
{

  // テーブルにレコードが存在するかチェック
  $WHERE = "(学籍番号='" . $student_number . "')";
  $cnt = RECODE_CHECK("tbl_student_introduction", $WHERE);

  try {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE tbl_student_introduction SET 教員コメント=? WHERE 学籍番号=?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([$_POST['教員コメント'], $student_number]);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }
  $mysqli = null;
  dsip_msg("更新しました");
  btn_return("student_list.php", "戻る");

  exit;
}



/////////////////////////////////////////////////////////////////
// 学生が作成した施設概要書の削除
/////////////////////////////////////////////////////////////////
function tbl_institution_overview_DELETE($student_number, $学年, $種別)
{
  try {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE from tbl_institution_overview WHERE (学籍番号=? AND 学年=?)";
    $stmt = $pdo->prepare($sql);

    $stmt->execute($student_number, $学年);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }
  $mysqli = null;
  dsip_msg("削除しました");
  btn_return("index.php", "戻る");

  exit;
}


/////////////////////////////////////////////////////////////////
// マスター管理で仕様する汎用的なテープル読込関数
/////////////////////////////////////////////////////////////////

function tbl_TABLE_READ($TABLE_NAME, $ID, $aryColumn, &$colcount, &$coldat)
{

  $colcount = 0;

  try {
    // DBへ接続

    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成

    if ($TABLE_NAME == "tbl_assignment") {
      $sql = "select * from " . $TABLE_NAME . " where 配属情報ID=" . $ID;
    } elseif ($TABLE_NAME == "tbl_institution") {
      $sql = "select * from " . $TABLE_NAME . " where 法人ID=" . $ID;
    } elseif ($TABLE_NAME == "tbl_instructor") {
      $sql = "select * from " . $TABLE_NAME . " where 指導者ID=" . $ID;
    } elseif ($TABLE_NAME == "tbl_practice_plan") {
      $sql = "select * from " . $TABLE_NAME . " where 計画ID=" . $ID;
    } elseif ($TABLE_NAME == "tbl_self_assessment") {
      $sql = "select * from " . $TABLE_NAME . " where 自己評価ID=" . $ID;
    } else {
      $sql = "select * from " . $TABLE_NAME . " where ID=" . $ID;
    }

    $res = $dbh->query($sql);
    $colcount = $res->columnCount();





    foreach ($res as $value) {
      for ($i = 1; $i <= $colcount; $i++) {
        $coldat[($i - 1)] = $value[$aryColumn[($i - 1)]];
      }
    }
  } catch (PDOException $e) {

    echo $e->getMessage();

    die();
  }





  $dbh = null;
  $res = null;

  return $coldat;
}



/////////////////////////////////////////////////////////////////
// 施設概要書読込関数
/////////////////////////////////////////////////////////////////

function tbl_institution_overview_READ($student_number, $学年, $種別)
{

  if ($学年 == "１") {
    $学年 = "1";
  }
  if ($学年 == "２") {
    $学年 = "2";
  }
  if ($学年 == "３") {
    $学年 = "3";
  }
  if ($学年 == "４") {
    $学年 = "4";
  }
  if ($学年 == "５") {
    $学年 = "5";
  }

  $GLOBALS['法人事業概要'] = "";
  $GLOBALS['施設事業概要'] = "";
  $GLOBALS['周辺地域'] = "";
  $GLOBALS['施設情報1'] = "";
  $GLOBALS['施設情報2'] = "";
  $GLOBALS['実習開始日'] = "";
  $GLOBALS['実習終了日'] = "";

  try {
    // DBへ接続

    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成

    $sql = "select * from tbl_institution_overview";
    $sql = $sql . " where ((学籍番号='" . $student_number . "') AND (学年='" . $学年 . "' ) AND (実習種別='" . $種別 . "'))";

    $cnt = 0;
    $res = $dbh->query($sql);
    foreach ($res as $value) {
      $cnt = $cnt + 1;

      $GLOBALS['法人事業概要'] = $value['法人事業概要'];
      $GLOBALS['施設事業概要'] = $value['施設事業概要'];
      $GLOBALS['周辺地域']  = $value['周辺地域'];
      $GLOBALS['施設情報1'] = $value['施設情報1'];
      $GLOBALS['施設情報2'] = $value['施設情報2'];
      $GLOBALS['実習開始日'] = $value['実習開始日'];
      $GLOBALS['実習終了日'] = $value['実習終了日'];
    }
  } catch (PDOException $e) {

    echo $e->getMessage();

    die();
  }

  if ($cnt > 0) {
  }
  $dbh = null;
  $res = null;



  return $cnt;
}


/////////////////////////////////////////////////////////////////
// 施設概要書の更新・新規書込み関数
/////////////////////////////////////////////////////////////////

function tbl_institution_overview_UPDATE($student_number, $学年, $種別)
{

  //予備カラム
  $_POST['施設情報1'] = "";
  $_POST['施設情報2'] = "";

if (
  (isset($_POST['action']) && $_POST['action'] === "delete") ||
  (isset($_POST['status']) && $_POST['status'] === "削除") // 互換
) {

  if (!isset($_POST['DELETE'])) {
    dsip_msg("削除するをチェックしてください");
    btn_return("index.php", "戻る");
    exit;
  }

  if ($_POST['DELETE'] === "on") {
    tbl_institution_overview_DELETE($student_number, $学年, $種別);
    exit;
  }
}

  // テーブルにレコードが存在するかチェック
  $WHERE = "((学籍番号='" . $student_number . "') AND (学年=" . $学年 . " ) AND (実習種別='" . $種別 . "'))";
  $cnt = RECODE_CHECK("tbl_institution_overview", $WHERE);

  $開始日 = $_POST['実習開始日'] ?? "";
  $終了日 = $_POST['実習終了日'] ?? "";



  $開始日 = mb_ereg_replace('年', '/', $開始日);
  $開始日 = mb_ereg_replace('月', '/', $開始日);
  $開始日 = mb_ereg_replace('日', '', $開始日);

  $終了日 = mb_ereg_replace('年', '/', $終了日);
  $終了日 = mb_ereg_replace('月', '/', $終了日);
  $終了日 = mb_ereg_replace('日', '', $終了日);

  if ($cnt == 0) {   /*新規書込み*/


    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
      $sql = "insert tbl_institution_overview(`学籍番号`, `学年`,`実習種別`,`氏名`, `法人名`, `施設名`,`郵便番号`, `所在地`, `電話`, `FAX`, `URL`, `MAIL`, `施設長`, `指導者1`, `指導者2`, `指導者3`, `実習開始日`, `実習終了日`, `法人事業概要`, `施設事業概要`, `周辺地域`, `施設情報1`, `施設情報2`) value (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

      $stmt = $pdo->prepare($sql);



      $stmt->execute([$student_number, $学年, $種別, $_POST['氏名'], $_POST['法人名'], $_POST['施設名'], $_POST['郵便番号'], $_POST['所在地'], $_POST['電話'], $_POST['FAX'], $_POST['URL'], $_POST['MAIL'], $_POST['施設長'], $_POST['指導者1'], $_POST['指導者2'], $_POST['指導者3'], $開始日, $終了日, $_POST['法人事業概要'], $_POST['施設事業概要'], $_POST['周辺地域'], $_POST['施設情報1'], $_POST['施設情報2']]);
    } catch (\Exception $e) {

      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");


      exit;
    }



    dsip_msg("追加しました");
    btn_return("index.php", "戻る");


    exit;
  } else   /*更新書込み*/


    try {

      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "UPDATE tbl_institution_overview SET 氏名=?,法人名=?,施設名=?,郵便番号=?,所在地=?,電話=?,FAX=?,URL=?,MAIL=?,施設長=?,指導者1=?,指導者2=?,指導者3=?,実習開始日=?,実習終了日=?,法人事業概要=?,施設事業概要=?,周辺地域=?,施設情報1=?,施設情報2=?
 WHERE ((学籍番号=?) AND (学年=?) AND (実習種別=?))";
      $stmt = $pdo->prepare($sql);

      $stmt->execute([$_POST['氏名'], $_POST['法人名'], $_POST['施設名'], $_POST['郵便番号'], $_POST['所在地'], $_POST['電話'], $_POST['FAX'], $_POST['URL'], $_POST['MAIL'], $_POST['施設長'], $_POST['指導者1'], $_POST['指導者2'], $_POST['指導者3'], $開始日, $終了日, $_POST['法人事業概要'], $_POST['施設事業概要'], $_POST['周辺地域'], $_POST['施設情報1'], $_POST['施設情報2'], $student_number, $学年, $種別]);
    } catch (\Exception $e) {

      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
    }







  $mysqli = null;
  dsip_msg("更新しました");
  btn_return("sheet_equipment_outline_list.php", "戻る");

  exit;
}



//////////////////////////////////////////////////
// 学生プロフィールにたいする教員のコメント書込み
//////////////////////////////////////////////////

function tbl_student_introduction_DELETE($student_number)
{

  try {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE from tbl_student_introduction WHERE (学籍番号=?)";
    $stmt = $pdo->prepare($sql);

    $stmt->execute($student_number);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }
  $mysqli = null;
  dsip_msg("削除しました");
  btn_return("index.php", "戻る");

  exit;
}

//////////////////////////////////////////////////
// 学生紹介書の更新・新規書込み・削除
//////////////////////////////////////////////////

function tbl_student_introduction_UPDATE($student_number)
{

  // 削除処理（action対応＋旧status互換）
  if (
    (isset($_POST['action']) && $_POST['action'] === "delete") ||
    (isset($_POST['status']) && $_POST['status'] === "削除")
  ) {

    if (!isset($_POST['DELETE'])) {
      dsip_msg("削除するをチェックしてください");
      btn_return("index.php", "戻る");
      exit;
    }

    if ($_POST['DELETE'] === "on") {
      $cnt = tbl_student_introduction_DELETE($student_number);
      exit;
    }
  }

  // テーブルにレコードが存在するかチェック
  $WHERE = "学籍番号='" . $student_number . "'";
  $cnt = RECODE_CHECK("tbl_student_introduction", $WHERE);


  // 新規登録
  if ($cnt == 0) {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
      $sql = "insert tbl_student_introduction(`学籍番号`, `学年`, `氏名`, `かな`, `生年月日`, `資格課程`, `郵便現住所`, `現住所`, `電話`, `郵便帰省先`, `帰省先`, `帰省先電話`, `職歴`, `学内所属団体`, `学外所属団体`, `健康状態`, `考慮事項`, `資格特技`, `趣味`, `自己アピール`, `現場体験`, `準備状況`, `教員コメント`, `指導教員`, `事務担当`)
              values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

      $stmt = $pdo->prepare($sql);

      $stmt->execute([
        $student_number,
        $_POST['学年'] ?? "",
        $_POST['氏名'] ?? "",
        $_POST['かな'] ?? "",
        $_POST['生年月日'] ?? "",
        $_POST['資格課程'] ?? "",
        $_POST['郵便現住所'] ?? "",
        $_POST['現住所'] ?? "",
        $_POST['電話'] ?? "",
        $_POST['郵便帰省先'] ?? "",
        $_POST['帰省先'] ?? "",
        $_POST['帰省先電話'] ?? "",
        $_POST['職歴'] ?? "",
        $_POST['学内所属団体'] ?? "",
        $_POST['学外所属団体'] ?? "",
        $_POST['健康状態'] ?? "",
        $_POST['考慮事項'] ?? "",
        $_POST['資格特技'] ?? "",
        $_POST['趣味'] ?? "",
        $_POST['自己アピール'] ?? "",
        $_POST['現場体験'] ?? "",
        $_POST['準備状況'] ?? "",
        "", // 教員コメント（新規時は空）
        $_POST['指導教員'] ?? "",
        $_POST['事務担当'] ?? ""
      ]);

    } catch (\Exception $e) {
      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }

    dsip_msg("追加しました");
    btn_return("index.php", "戻る");
    exit;

  } else {

    // 更新処理
    try {

      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "UPDATE tbl_student_introduction SET
                学年=?, 氏名=?, かな=?, 生年月日=?, 資格課程=?, 郵便現住所=?, 現住所=?, 電話=?,
                郵便帰省先=?, 帰省先=?, 帰省先電話=?, 職歴=?, 学内所属団体=?, 学外所属団体=?,
                健康状態=?, 考慮事項=?, 資格特技=?, 趣味=?, 自己アピール=?, 現場体験=?, 準備状況=?,
                教員コメント=?, 指導教員=?, 事務担当=?
              WHERE (学籍番号=?)";

      $stmt = $pdo->prepare($sql);

      $stmt->execute([
        $_POST['学年'] ?? "",
        $_POST['氏名'] ?? "",
        $_POST['かな'] ?? "",
        $_POST['生年月日'] ?? "",
        $_POST['資格課程'] ?? "",
        $_POST['郵便現住所'] ?? "",
        $_POST['現住所'] ?? "",
        $_POST['電話'] ?? "",
        $_POST['郵便帰省先'] ?? "",
        $_POST['帰省先'] ?? "",
        $_POST['帰省先電話'] ?? "",
        $_POST['職歴'] ?? "",
        $_POST['学内所属団体'] ?? "",
        $_POST['学外所属団体'] ?? "",
        $_POST['健康状態'] ?? "",
        $_POST['考慮事項'] ?? "",
        $_POST['資格特技'] ?? "",
        $_POST['趣味'] ?? "",
        $_POST['自己アピール'] ?? "",
        $_POST['現場体験'] ?? "",
        $_POST['準備状況'] ?? "",
        $_POST['教員コメント'] ?? "",
        $_POST['指導教員'] ?? "",
        $_POST['事務担当'] ?? "",
        $student_number
      ]);

    } catch (\Exception $e) {
      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }

    $mysqli = null;
    dsip_msg("更新しました");
    btn_return("index.php", "戻る");
    exit;
  }
}




//////////////////////////////////////////////////
// 学生紹介書の読込
//////////////////////////////////////////////////

function tbl_student_introduction_read($student_number)
{



  $GLOBALS['学年'] = "";
  $GLOBALS['生年月日'] = "";
  $GLOBALS['資格課程'] = "";
  $GLOBALS['郵便現住所'] = "";
  $GLOBALS['郵便帰省先'] = "";
  $GLOBALS['帰省先電話'] = "";
  $GLOBALS['職歴'] = "";
  $GLOBALS['学内所属団体'] = "";
  $GLOBALS['学外所属団体'] = "";
  $GLOBALS['健康状態'] = "";
  $GLOBALS['趣味'] = "";
  $GLOBALS['自己アピール'] = "";
  $GLOBALS['現場体験'] = "";
  $GLOBALS['準備状況'] = "";
  $GLOBALS['教員コメント'] = "";
  $GLOBALS['指導教員'] = "";
  $GLOBALS['事務担当'] = "";
  $GLOBALS['電話'] = "";


  try {
    // DBへ接続

    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成

    $sql = "select * from tbl_student_introduction where 学籍番号='" . $student_number . "'";

    $cnt = 0;
    $res = $dbh->query($sql);
    foreach ($res as $value) {
      $cnt = $cnt + 1;


      $GLOBALS['学年'] =  $value['学年'];
      $GLOBALS['氏名'] = $value['氏名'];
      $GLOBALS['かな'] = $value['かな'];
      $GLOBALS['生年月日'] = $value['生年月日'];
      $GLOBALS['資格課程'] = $value['資格課程'];
      $GLOBALS['郵便現住所'] = $value['郵便現住所'];
      $GLOBALS['現住所']  = $value['現住所'];
      $GLOBALS['郵便帰省先'] = $value['郵便帰省先'];
      $GLOBALS['帰省先'] = $value['帰省先'];
      $GLOBALS['職歴'] = $value['職歴'];
      $GLOBALS['学内所属団体'] = $value['学内所属団体'];
      $GLOBALS['学外所属団体'] = $value['学外所属団体'];
      $GLOBALS['健康状態'] = $value['健康状態'];
      $GLOBALS['考慮事項'] = $value['考慮事項'];
      $GLOBALS['資格特技'] = $value['資格特技'];
      $GLOBALS['趣味'] = $value['趣味'];
      $GLOBALS['自己アピール'] = $value['自己アピール'];
      $GLOBALS['現場体験'] = $value['現場体験'];
      $GLOBALS['準備状況'] = $value['準備状況'];
      $GLOBALS['教員コメント'] = $value['教員コメント'];
      $GLOBALS['指導教員'] = $value['指導教員'];
      $GLOBALS['事務担当'] = $value['事務担当'];
      $GLOBALS['電話'] = $value['電話'];
    }
  } catch (PDOException $e) {

    echo $e->getMessage();

    die();
  }

  $dbh = null;
  $res = null;

  return $cnt;
}



//////////////////////////////////////////////////
// 年度情報を読み込む
//////////////////////////////////////////////////

function GET_NENDO()
{

  try {
    // DBへ接続



    $dbh = new PDO(DSN, DB_USER, DB_PASS);


    // SQL作成

    $sql = "select * from tbl_nendo";
    $cnt = 0;
    $res = $dbh->query($sql);
    foreach ($res as $value) {
      $cnt = $cnt + 1;

      $_SESSION['NENDO'] = $value['nen'];
      $_SESSION['KANRI_NENDO'] = $value['kanri_nen'];
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
    die();
  }
}


//////////////////////////////////////////////////
// 年度情報の更新
//////////////////////////////////////////////////


function tbl_nend_UPDATE()
{



  $事業年度 = $_POST['事業年度'];
  $_SESSION['NENDO'] = $_POST['事業年度'];

  $管理年度 = $_POST['管理用年度'];
  $_SESSION['KANRI_NENDO'] = $_POST['管理用年度'];



  try {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE tbl_nendo SET nen=?,kanri_nen=? WHERE ID=1";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([$事業年度, $管理年度]);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }
  $mysqli = null;


  //////////////////////////////////////////////////////////////////////////////////////////////
  // 年度情報の更新をおこなったタイミングで該当年度の配属情報テーブルの枠レコードを作成する
  // ここでは、一括更新するし、指導者テーブルも存在しているはずだから、ジョイントしておく。
  // 施設の新規作成時も似たような処理をおこなうが、その時は指導者テーブルは無しなのでジョイントしない
  //////////////////////////////////////////////////////////////////////////////////////////////

  $sql = "select tbl_institution.法人ID,tbl_institution.施設区分,tbl_institution.法人名,tbl_institution.施設名,tbl_institution.施設種別,tbl_institution.管理者,tbl_institution.管理者役職名,郵便番号,所在地,実習窓口担当者名,氏名1,氏名2,氏名3 from tbl_institution JOIN tbl_instructor ON tbl_institution.法人ID=tbl_instructor.法人ID";

  // DBへ接続
  $dbh = new PDO(DSN, DB_USER, DB_PASS);
  // SQL作成

  $cnt1 = 0;
  $cnt = 0;
  $res = $dbh->query($sql);
  foreach ($res as $value) {
    $cnt1 = $cnt1 + 1;
    $cnt = $cnt + 1;
    $法人ID = $value['法人ID'];
    $施設区分 = $value['施設区分'];
    $法人名 = $value['法人名'];
    $施設名 = $value['施設名'];
    $施設種別 = $value['施設種別'];
    $管理者 = $value['管理者'];
    $管理者役職名 = $value['管理者役職名'];
    $郵便番号 = $value['郵便番号'];
    $所在地 = $value['所在地'];
    $実習窓口担当者 = $value['実習窓口担当者名'];
    $実習指導者1 = $value['氏名1'];
    $実習指導者2 = $value['氏名2'];
    $実習指導者3 = $value['氏名3'];

    $事業年度文字 = (string) $管理年度;

    // テーブルにレコードが存在するかチェック
    $WHERE = "(法人ID=" . $法人ID . ") AND (事業年度='" . $管理年度 . "')";
    $cnt = RECODE_CHECK("tbl_assignment", $WHERE);

    if ($cnt == 0) {   /*新規書込み*/
      $pdo2 = new PDO(DSN, DB_USER, DB_PASS);
      $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      try {
        $sql = "insert into tbl_assignment(法人ID, 事業年度, NO, 施設区分, 法人名, 施設名, 施設種別, 管理者, 管理者役職名, 郵便番号, 所在地, 実習窓口担当者名, 実習指導者1, 実習指導者2, 実習指導者3) value (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt2 = $pdo2->prepare($sql);



        $stmt2->execute([$法人ID, $事業年度文字, $cnt, $施設区分, $法人名, $施設名, $施設種別, $管理者, $管理者役職名, $郵便番号, $所在地, $実習窓口担当者, $実習指導者1, $実習指導者2, $実習指導者3]);
      } catch (\Exception $e) {
        dsip_msg($e->getMessage() . PHP_EOL);
        btn_return("index.php", "戻る");
        exit;
      }
      $mysqli = null;
    }
  }

  dsip_msg("更新しました");
  btn_return("index.php", "戻る");
  exit;
}





//////////////////////////////////////////////////////////////////////////////////////////////
// 配属情報テーブルの更新・新規追加
//////////////////////////////////////////////////////////////////////////////////////////////

function tbl_assignment_UPDATE($法人ID,  $施設区分, $事業年度)
{


  //////////////////////////////////////
  // 削除フラグをチェックして初期化する
  //////////////////////////////////////

  if ($_POST['delete1'] == "on") {
    $_POST['実習種別1'] = "";
    $_POST['学籍番号1'] = "";
    $_POST['学生1'] = "";
    $_POST['学年1'] = "";
    $_POST['担当教員1'] = "";
    $_POST['実習開始日1'] = "";
    $_POST['実習終了日1'] = "";
    $_POST['総実習時間1'] = "";
    $_POST['巡回指導日1'] = "";
    $_POST['帰校日1'] = "";
    $_POST['オリエンテーション1'] = "";
    $_POST['特記事項1'] = "";
  }

  if ($_POST['delete2'] == "on") {
    $_POST['実習種別2'] = "";
    $_POST['学籍番号2'] = "";
    $_POST['学生2'] = "";
    $_POST['学年2'] = "";
    $_POST['担当教員2'] = "";
    $_POST['実習開始日2'] = "";
    $_POST['実習終了日2'] = "";
    $_POST['総実習時間2'] = "";
    $_POST['巡回指導日2'] = "";
    $_POST['帰校日2'] = "";
    $_POST['オリエンテーション2'] = "";
    $_POST['特記事項2'] = "";
  }

  if ($_POST['delete3'] == "on") {
    $_POST['実習種別3'] = "";
    $_POST['学籍番号3'] = "";
    $_POST['学生3'] = "";
    $_POST['学年3'] = "";
    $_POST['担当教員3'] = "";
    $_POST['実習開始日3'] = "";
    $_POST['実習終了日3'] = "";
    $_POST['総実習時間3'] = "";
    $_POST['巡回指導日3'] = "";
    $_POST['帰校日3'] = "";
    $_POST['オリエンテーション3'] = "";
    $_POST['特記事項3'] = "";
  }


  if ($_POST['delete4'] == "on") {
    $_POST['実習種別4'] = "";
    $_POST['学籍番号4'] = "";
    $_POST['学生4'] = "";
    $_POST['学年4'] = "";
    $_POST['担当教員4'] = "";
    $_POST['実習開始日4'] = "";
    $_POST['実習終了日4'] = "";
    $_POST['総実習時間4'] = "";
    $_POST['巡回指導日4'] = "";
    $_POST['帰校日4'] = "";
    $_POST['オリエンテーション4'] = "";
    $_POST['特記事項4'] = "";
  }

  if ($_POST['delete5'] == "on") {
    $_POST['実習種別5'] = "";
    $_POST['学籍番号5'] = "";
    $_POST['学生5'] = "";
    $_POST['学年5'] = "";
    $_POST['担当教員5'] = "";
    $_POST['実習開始日5'] = "";
    $_POST['実習終了日5'] = "";
    $_POST['総実習時間5'] = "";
    $_POST['巡回指導日5'] = "";
    $_POST['帰校日5'] = "";
    $_POST['オリエンテーション5'] = "";
    $_POST['特記事項5'] = "";
  }


  if ($_POST['実習種別1'] == "選択してください") {
    $_POST['実習種別1'] = "";
  }

  if ($_POST['実習種別2'] == "選択してください") {
    $_POST['実習種別2'] = "";
  }


  if ($_POST['実習種別3'] == "選択してください") {
    $_POST['実習種別3'] = "";
  }

  if ($_POST['実習種別4'] == "選択してください") {
    $_POST['実習種別4'] = "";
  }

  if ($_POST['実習種別5'] == "選択してください") {
    $_POST['実習種別5'] = "";
  }

  //////////////////////////////////////
  // 実習種別がないものは前詰めする
  //////////////////////////////////////

  if (($_POST['実習種別1'] == "")  and ($_POST['実習種別2'] <> "")) {
    $_POST['実習種別1'] = $_POST['実習種別2'];
    $_POST['学籍番号1'] = $_POST['学籍番号2'];
    $_POST['学生1'] = $_POST['学生2'];
    $_POST['学年1'] = $_POST['学年2'];
    $_POST['担当教員1'] = $_POST['担当教員2'];
    $_POST['実習開始日1'] = $_POST['実習開始日2'];
    $_POST['実習終了日1'] = $_POST['実習終了日2'];
    $_POST['総実習時間1'] = $_POST['総実習時間2'];
    $_POST['巡回指導日1'] = $_POST['巡回指導日2'];
    $_POST['帰校日1'] = $_POST['帰校日2'];
    $_POST['オリエンテーション1'] = $_POST['オリエンテーション2'];
    $_POST['特記事項1'] = $_POST['特記事項2'];

    $_POST['実習種別2'] = "";
    $_POST['学籍番号2'] = "";
    $_POST['学生2'] = "";
    $_POST['学年2'] = "";
    $_POST['担当教員2'] = "";
    $_POST['実習開始日2'] = "";
    $_POST['実習終了日2'] = "";
    $_POST['総実習時間2'] = "";
    $_POST['巡回指導日2'] = "";
    $_POST['帰校日2'] = "";
    $_POST['オリエンテーション2'] = "";
    $_POST['特記事項2'] = "";
  };

  if (($_POST['実習種別1'] == "")  and ($_POST['実習種別3'] <> "")) {
    $_POST['実習種別1'] = $_POST['実習種別3'];
    $_POST['学籍番号1'] = $_POST['学籍番号3'];
    $_POST['学生1'] = $_POST['学生3'];
    $_POST['学年1'] = $_POST['学年3'];
    $_POST['担当教員1'] = $_POST['担当教員3'];
    $_POST['実習開始日1'] = $_POST['実習開始日3'];
    $_POST['実習終了日1'] = $_POST['実習終了日3'];
    $_POST['総実習時間1'] = $_POST['総実習時間3'];
    $_POST['巡回指導日1'] = $_POST['巡回指導日3'];
    $_POST['帰校日1'] = $_POST['帰校日3'];
    $_POST['オリエンテーション1'] = $_POST['オリエンテーション3'];
    $_POST['特記事項1'] = $_POST['特記事項3'];

    $_POST['実習種別3'] = "";
    $_POST['学籍番号3'] = "";
    $_POST['学生3'] = "";
    $_POST['学年3'] = "";
    $_POST['担当教員3'] = "";
    $_POST['実習開始日3'] = "";
    $_POST['実習終了日3'] = "";
    $_POST['総実習時間3'] = "";
    $_POST['巡回指導日3'] = "";
    $_POST['帰校日3'] = "";
    $_POST['オリエンテーション3'] = "";
    $_POST['特記事項3'] = "";
  };

  if (($_POST['実習種別1'] == "")  and ($_POST['実習種別4'] <> "")) {
    $_POST['実習種別1'] = $_POST['実習種別4'];
    $_POST['学籍番号1'] = $_POST['学籍番号4'];
    $_POST['学生1'] = $_POST['学生4'];
    $_POST['学年1'] = $_POST['学年4'];
    $_POST['担当教員1'] = $_POST['担当教員4'];
    $_POST['実習開始日1'] = $_POST['実習開始日4'];
    $_POST['実習終了日1'] = $_POST['実習終了日4'];
    $_POST['総実習時間1'] = $_POST['総実習時間4'];
    $_POST['巡回指導日1'] = $_POST['巡回指導日4'];
    $_POST['帰校日1'] = $_POST['帰校日3'];
    $_POST['オリエンテーション1'] = $_POST['オリエンテーション4'];
    $_POST['特記事項1'] = $_POST['特記事項4'];

    $_POST['実習種別4'] = "";
    $_POST['学籍番号4'] = "";
    $_POST['学生4'] = "";
    $_POST['学年4'] = "";
    $_POST['担当教員4'] = "";
    $_POST['実習開始日4'] = "";
    $_POST['実習終了日4'] = "";
    $_POST['総実習時間4'] = "";
    $_POST['巡回指導日4'] = "";
    $_POST['帰校日4'] = "";
    $_POST['オリエンテーション4'] = "";
    $_POST['特記事項4'] = "";
  };

  if (($_POST['実習種別1'] == "")  and ($_POST['実習種別5'] <> "")) {
    $_POST['実習種別1'] = $_POST['実習種別5'];
    $_POST['学籍番号1'] = $_POST['学籍番号5'];
    $_POST['学生1'] = $_POST['学生5'];
    $_POST['学年1'] = $_POST['学年5'];
    $_POST['担当教員1'] = $_POST['担当教員5'];
    $_POST['実習開始日1'] = $_POST['実習開始日5'];
    $_POST['実習終了日1'] = $_POST['実習終了日5'];
    $_POST['総実習時間1'] = $_POST['総実習時間5'];
    $_POST['巡回指導日1'] = $_POST['巡回指導日5'];
    $_POST['帰校日1'] = $_POST['帰校日5'];
    $_POST['オリエンテーション1'] = $_POST['オリエンテーション5'];
    $_POST['特記事項1'] = $_POST['特記事項5'];

    $_POST['実習種別5'] = "";
    $_POST['学籍番号5'] = "";
    $_POST['学生5'] = "";
    $_POST['学年5'] = "";
    $_POST['担当教員5'] = "";
    $_POST['実習開始日5'] = "";
    $_POST['実習終了日5'] = "";
    $_POST['総実習時間5'] = "";
    $_POST['巡回指導日5'] = "";
    $_POST['帰校日5'] = "";
    $_POST['オリエンテーション5'] = "";
    $_POST['特記事項5'] = "";
  };



  if (($_POST['実習種別2'] == "")  and ($_POST['実習種別3'] <> "")) {
    $_POST['実習種別2'] = $_POST['実習種別3'];
    $_POST['学籍番号2'] = $_POST['学籍番号3'];
    $_POST['学生2'] = $_POST['学生3'];
    $_POST['学年2'] = $_POST['学年3'];
    $_POST['担当教員2'] = $_POST['担当教員3'];
    $_POST['実習開始日2'] = $_POST['実習開始日3'];
    $_POST['実習終了日2'] = $_POST['実習終了日3'];
    $_POST['総実習時間2'] = $_POST['総実習時間3'];
    $_POST['巡回指導日2'] = $_POST['巡回指導日3'];
    $_POST['帰校日2'] = $_POST['帰校日3'];
    $_POST['オリエンテーション2'] = $_POST['オリエンテーション3'];
    $_POST['特記事項2'] = $_POST['特記事項3'];

    $_POST['実習種別3'] = "";
    $_POST['学籍番号3'] = "";
    $_POST['学生3'] = "";
    $_POST['学年3'] = "";
    $_POST['担当教員3'] = "";
    $_POST['実習開始日3'] = "";
    $_POST['実習終了日3'] = "";
    $_POST['総実習時間3'] = "";
    $_POST['巡回指導日3'] = "";
    $_POST['帰校日3'] = "";
    $_POST['オリエンテーション3'] = "";
    $_POST['特記事項3'] = "";
  };

  if (($_POST['実習種別2'] == "")  and ($_POST['実習種別4'] <> "")) {
    $_POST['実習種別2'] = $_POST['実習種別4'];
    $_POST['学籍番号2'] = $_POST['学籍番号4'];
    $_POST['学生2'] = $_POST['学生4'];
    $_POST['学年2'] = $_POST['学年4'];
    $_POST['担当教員2'] = $_POST['担当教員4'];
    $_POST['実習開始日2'] = $_POST['実習開始日4'];
    $_POST['実習終了日2'] = $_POST['実習終了日4'];
    $_POST['総実習時間2'] = $_POST['総実習時間4'];
    $_POST['巡回指導日2'] = $_POST['巡回指導日4'];
    $_POST['帰校日2'] = $_POST['帰校日4'];
    $_POST['オリエンテーション2'] = $_POST['オリエンテーション4'];
    $_POST['特記事項2'] = $_POST['特記事項4'];

    $_POST['実習種別4'] = "";
    $_POST['学籍番号4'] = "";
    $_POST['学生4'] = "";
    $_POST['学年4'] = "";
    $_POST['担当教員4'] = "";
    $_POST['実習開始日4'] = "";
    $_POST['実習終了日4'] = "";
    $_POST['総実習時間4'] = "";
    $_POST['巡回指導日4'] = "";
    $_POST['帰校日4'] = "";
    $_POST['オリエンテーション4'] = "";
    $_POST['特記事項4'] = "";
  };


  if (($_POST['実習種別2'] == "")  and ($_POST['実習種別5'] <> "")) {
    $_POST['実習種別2'] = $_POST['実習種別5'];
    $_POST['学籍番号2'] = $_POST['学籍番号5'];
    $_POST['学生2'] = $_POST['学生5'];
    $_POST['学年2'] = $_POST['学年5'];
    $_POST['担当教員2'] = $_POST['担当教員5'];
    $_POST['実習開始日2'] = $_POST['実習開始日5'];
    $_POST['実習終了日2'] = $_POST['実習終了日5'];
    $_POST['総実習時間2'] = $_POST['総実習時間5'];
    $_POST['巡回指導日2'] = $_POST['巡回指導日5'];
    $_POST['帰校日2'] = $_POST['帰校日5'];
    $_POST['オリエンテーション2'] = $_POST['オリエンテーション5'];
    $_POST['特記事項2'] = $_POST['特記事項5'];

    $_POST['実習種別5'] = "";
    $_POST['学籍番号5'] = "";
    $_POST['学生5'] = "";
    $_POST['学年5'] = "";
    $_POST['担当教員5'] = "";
    $_POST['実習開始日5'] = "";
    $_POST['実習終了日5'] = "";
    $_POST['総実習時間5'] = "";
    $_POST['巡回指導日5'] = "";
    $_POST['帰校日5'] = "";
    $_POST['オリエンテーション5'] = "";
    $_POST['特記事項5'] = "";
  };



  if (($_POST['実習種別3'] == "")  and ($_POST['実習種別4'] <> "")) {
    $_POST['実習種別3'] = $_POST['実習種別4'];
    $_POST['学籍番号3'] = $_POST['学籍番号4'];
    $_POST['学生3'] = $_POST['学生4'];
    $_POST['学年3'] = $_POST['学年4'];
    $_POST['担当教員3'] = $_POST['担当教員4'];
    $_POST['実習開始日3'] = $_POST['実習開始日4'];
    $_POST['実習終了日3'] = $_POST['実習終了日4'];
    $_POST['総実習時間3'] = $_POST['総実習時間4'];
    $_POST['巡回指導日3'] = $_POST['巡回指導日4'];
    $_POST['帰校日3'] = $_POST['帰校日4'];
    $_POST['オリエンテーション3'] = $_POST['オリエンテーション4'];
    $_POST['特記事項3'] = $_POST['特記事項4'];

    $_POST['実習種別4'] = "";
    $_POST['学籍番号4'] = "";
    $_POST['学生4'] = "";
    $_POST['学年4'] = "";
    $_POST['担当教員4'] = "";
    $_POST['実習開始日4'] = "";
    $_POST['実習終了日4'] = "";
    $_POST['総実習時間4'] = "";
    $_POST['巡回指導日4'] = "";
    $_POST['帰校日4'] = "";
    $_POST['オリエンテーション4'] = "";
    $_POST['特記事項4'] = "";
  };



  if (($_POST['実習種別3'] == "")  and ($_POST['実習種別5'] <> "")) {
    $_POST['実習種別3'] = $_POST['実習種別5'];
    $_POST['学籍番号3'] = $_POST['学籍番号5'];
    $_POST['学生3'] = $_POST['学生5'];
    $_POST['学年3'] = $_POST['学年5'];
    $_POST['担当教員3'] = $_POST['担当教員5'];
    $_POST['実習開始日3'] = $_POST['実習開始日5'];
    $_POST['実習終了日3'] = $_POST['実習終了日5'];
    $_POST['総実習時間3'] = $_POST['総実習時間5'];
    $_POST['巡回指導日3'] = $_POST['巡回指導日5'];
    $_POST['帰校日3'] = $_POST['帰校日5'];
    $_POST['オリエンテーション3'] = $_POST['オリエンテーション5'];
    $_POST['特記事項3'] = $_POST['特記事項5'];

    $_POST['実習種別5'] = "";
    $_POST['学籍番号5'] = "";
    $_POST['学生5'] = "";
    $_POST['学年5'] = "";
    $_POST['担当教員5'] = "";
    $_POST['実習開始日5'] = "";
    $_POST['実習終了日5'] = "";
    $_POST['総実習時間5'] = "";
    $_POST['巡回指導日5'] = "";
    $_POST['帰校日5'] = "";
    $_POST['オリエンテーション5'] = "";
    $_POST['特記事項5'] = "";
  };




  if (($_POST['実習種別4'] == "")  and ($_POST['実習種別5'] <> "")) {
    $_POST['実習種別4'] = $_POST['実習種別5'];
    $_POST['学籍番号4'] = $_POST['学籍番号5'];
    $_POST['学生4'] = $_POST['学生5'];
    $_POST['学年4'] = $_POST['学年5'];
    $_POST['担当教員4'] = $_POST['担当教員5'];
    $_POST['実習開始日4'] = $_POST['実習開始日5'];
    $_POST['実習終了日4'] = $_POST['実習終了日5'];
    $_POST['総実習時間4'] = $_POST['総実習時間5'];
    $_POST['巡回指導日4'] = $_POST['巡回指導日5'];
    $_POST['帰校日4'] = $_POST['帰校日5'];
    $_POST['オリエンテーション4'] = $_POST['オリエンテーション5'];
    $_POST['特記事項4'] = $_POST['特記事項5'];

    $_POST['実習種別5'] = "";
    $_POST['学籍番号5'] = "";
    $_POST['学生5'] = "";
    $_POST['学年5'] = "";
    $_POST['担当教員5'] = "";
    $_POST['実習開始日5'] = "";
    $_POST['実習終了日5'] = "";
    $_POST['総実習時間5'] = "";
    $_POST['巡回指導日5'] = "";
    $_POST['帰校日5'] = "";
    $_POST['オリエンテーション5'] = "";
    $_POST['特記事項5'] = "";
  };







  // 有効な人数をカウント
  $NINZU = 0;
  if ($_POST['学籍番号1'] <> "") {
    $NINZU = $NINZU + 1;
  }
  if ($_POST['学籍番号2'] <> "") {
    $NINZU = $NINZU + 1;
  }
  if ($_POST['学籍番号3'] <> "") {
    $NINZU = $NINZU + 1;
  }
  if ($_POST['学籍番号4'] <> "") {
    $NINZU = $NINZU + 1;
  }
  if ($_POST['学籍番号5'] <> "") {
    $NINZU = $NINZU + 1;
  }

  $配属数 = (string)$NINZU;


  //学生が存在するかをチェックする
  $msg = "";
  if ($_POST['学籍番号1'] <> "") {
    $WHERE = "student_number='" . $_POST['学籍番号1'] . "'";
    $cnt = RECODE_CHECK("tbl_profile", $WHERE);
    if ($cnt == 0) {
      $msg = $msg . $_POST['学籍番号1'] . "  " . $_POST['学生1'] . "<br>";
    }
  }
  if ($_POST['学籍番号2'] <> "") {
    $WHERE = "student_number='" . $_POST['学籍番号2'] . "'";
    $cnt = RECODE_CHECK("tbl_profile", $WHERE);
    if ($cnt == 0) {
      $msg = $msg . $_POST['学籍番号2'] . "  " . $_POST['学生2'] . "<br>";
    }
  }
  if ($_POST['学籍番号3'] <> "") {
    $WHERE = "student_number='" . $_POST['学籍番号3'] . "'";
    $cnt = RECODE_CHECK("tbl_profile", $WHERE);
    if ($cnt == 0) {
      $msg = $msg . $_POST['学籍番号3'] . "  " . $_POST['学生3'] . "<br>";
    }
  }


  if ($_POST['学籍番号4'] <> "") {
    $WHERE = "student_number='" . $_POST['学籍番号4'] . "'";
    $cnt = RECODE_CHECK("tbl_profile", $WHERE);
    if ($cnt == 0) {
      $msg = $msg . $_POST['学籍番号4'] . "  " . $_POST['学生4'] . "<br>";
    }
  }


  if ($_POST['学籍番号5'] <> "") {
    $WHERE = "student_number='" . $_POST['学籍番号5'] . "'";
    $cnt = RECODE_CHECK("tbl_profile", $WHERE);
    if ($cnt == 0) {
      $msg = $msg . $_POST['学籍番号5'] . "  " . $_POST['学生5'] . "<br>";
    }
  }

  // テーブルにレコードが存在するかチェック

  $WHERE = "(法人ID=" . $法人ID . ") AND (事業年度=" . $事業年度 . ")";
  $cnt2 = RECODE_CHECK("tbl_assignment", $WHERE);

  if ($cnt2 == 0) {   /*新規書込み*/
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
      $sql = "insert into tbl_assignment(`法人ID`, `事業年度`, `NO`, `施設区分`, `法人名`, `施設名`, `施設種別`, `管理者`, `管理者役職名`, `郵便番号`, `所在地`, `実習窓口担当者名`, `実習指導者1`, `実習指導者2`, `実習指導者3`, `実習種別1`, `学籍番号1`, `氏名1`, `学年1`, `担当教員1`, `実習開始日1`, `実習終了日1`, `総実習時間1`, `巡回指導日1`, `帰校日1`, `オリエンテーション1`, `特記事項1`, `実習種別2`, `学籍番号2`, `氏名2`, `学年2`, `担当教員2`, `実習開始日2`, `実習終了日2`, `総実習時間2`, `巡回指導日2`, `帰校日2`, `オリエンテーション2`, `特記事項2`, `実習種別3`, `学籍番号3`, `氏名3`, `学年3`, `担当教員3`, `実習開始日3`, `実習終了日3`, `総実習時間3`, `巡回指導日3`, `帰校日3`, `オリエンテーション3`, `特記事項3`, `実習種別4`, `学籍番号4`, `氏名4`, `学年4`, `担当教員4`, `実習開始日4`, `実習終了日4`, `総実習時間4`, `巡回指導日4`, `帰校日4`, `オリエンテーション4`, `特記事項4`, `実習種別5`, `学籍番号5`, `氏名5`, `学年5`, `担当教員5`, `実習開始日5`, `実習終了日5`, `総実習時間5`, `巡回指導日5`, `帰校日5`, `オリエンテーション5`, `特記事項5`,`配属数`) value (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";



      $stmt = $pdo->prepare($sql);

      $stmt->execute([$_POST['法人ID'], $_POST['事業年度'], $_POST['NO'], $_POST['施設区分'], $_POST['法人名'], $_POST['施設名'], $_POST['施設種別'], $_POST['管理者'], $_POST['管理者役職名'], $_POST['郵便番号'], $_POST['所在地'], $_POST['実習窓口担当者名'], $_POST['実習指導者1'], $_POST['実習指導者2'], $_POST['実習指導者3'], $_POST['実習種別1'], $_POST['学籍番号1'], $_POST['学生1'], $_POST['学年1'], $_POST['担当教員1'], $_POST['実習開始日1'], $_POST['実習終了日1'], $_POST['総実習時間1'], $_POST['巡回指導日1'], $_POST['帰校日1'], $_POST['オリエンテーション1'], $_POST['特記事項1'], $_POST['実習種別2'], $_POST['学籍番号2'], $_POST['学生2'], $_POST['学年2'], $_POST['担当教員2'], $_POST['実習開始日2'], $_POST['実習終了日2'], $_POST['総実習時間2'], $_POST['巡回指導日2'], $_POST['帰校日2'], $_POST['オリエンテーション2'], $_POST['特記事項2'], $_POST['実習種別3'], $_POST['学籍番号3'], $_POST['学生3'], $_POST['学年3'], $_POST['担当教員3'], $_POST['実習開始日3'], $_POST['実習終了日3'], $_POST['総実習時間3'], $_POST['巡回指導日3'], $_POST['帰校日3'], $_POST['オリエンテーション3'], $_POST['特記事項3'], $_POST['実習種別4'], $_POST['学籍番号4'], $_POST['学生4'], $_POST['学年4'], $_POST['担当教員4'], $_POST['実習開始日4'], $_POST['実習終了日4'], $_POST['総実習時間4'], $_POST['巡回指導日4'], $_POST['帰校日4'], $_POST['オリエンテーション4'], $_POST['特記事項4'], $_POST['実習種別5'], $_POST['学籍番号5'], $_POST['学生5'], $_POST['学年5'], $_POST['担当教員5'], $_POST['実習開始日5'], $_POST['実習終了日5'], $_POST['総実習時間5'], $_POST['巡回指導日5'], $_POST['帰校日5'], $_POST['オリエンテーション5'], $_POST['特記事項5'], $配属数]);
    } catch (\Exception $e) {

      dsip_msg($e->getMessage() . PHP_EOL);



      btn_return("index.php", "戻る");

      exit;
    }


    if ($msg <> "") {
      dsip_msg("以下の学生番号が存在しません。確認してください。<br>" . $msg);
      btn_return("assignment_info_detail.php", "戻る");
      exit;
    }
  } else   /*更新書込み*/

    try {

      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "UPDATE tbl_assignment SET 施設区分=?,NO=?,法人名=?,施設名=?,施設種別=?,管理者=?,管理者役職名=?,郵便番号=?,所在地=?,実習窓口担当者名=?,実習指導者1=?,実習指導者2=?,実習指導者3=?,実習種別1=?,学籍番号1=?,氏名1=?,学年1=?,担当教員1=?,実習開始日1=?,実習終了日1=?,総実習時間1=?,巡回指導日1=?,帰校日1=?,オリエンテーション1=?,特記事項1=?,実習種別2=?,学籍番号2=?,氏名2=?,学年2=?,担当教員2=?,実習開始日2=?,実習終了日2=?,総実習時間2=?,巡回指導日2=?,帰校日2=?,オリエンテーション2=?,特記事項2=?,実習種別3=?,学籍番号3=?,氏名3=?,学年3=?,担当教員3=?,実習開始日3=?,実習終了日3=?,総実習時間3=?,巡回指導日3=?,帰校日3=?,オリエンテーション3=?,特記事項3=?,実習種別4=?,学籍番号4=?,氏名4=?,学年4=?,担当教員4=?,実習開始日4=?,実習終了日4=?,総実習時間4=?,巡回指導日4=?,帰校日4=?,オリエンテーション4=?,特記事項4=?,実習種別5=?,学籍番号5=?,氏名5=?,学年5=?,担当教員5=?,実習開始日5=?,実習終了日5=?,総実習時間5=?,巡回指導日5=?,帰校日5=?,オリエンテーション5=?,特記事項5=?,配属数=?
 WHERE (法人ID=? AND 事業年度=?)";
      $stmt = $pdo->prepare($sql);

      $stmt->execute([$_POST['施設区分'], $_POST['NO'], $_POST['法人名'], $_POST['施設名'], $_POST['施設種別'], $_POST['管理者'], $_POST['管理者役職名'], $_POST['郵便番号'], $_POST['所在地'], $_POST['実習窓口担当者名'], $_POST['実習指導者1'], $_POST['実習指導者2'], $_POST['実習指導者3'], $_POST['実習種別1'], $_POST['学籍番号1'], $_POST['学生1'], $_POST['学年1'], $_POST['担当教員1'], $_POST['実習開始日1'], $_POST['実習終了日1'], $_POST['総実習時間1'], $_POST['巡回指導日1'], $_POST['帰校日1'], $_POST['オリエンテーション1'], $_POST['特記事項1'], $_POST['実習種別2'], $_POST['学籍番号2'], $_POST['学生2'], $_POST['学年2'], $_POST['担当教員2'], $_POST['実習開始日2'], $_POST['実習終了日2'], $_POST['総実習時間2'], $_POST['巡回指導日2'], $_POST['帰校日2'], $_POST['オリエンテーション2'], $_POST['特記事項2'], $_POST['実習種別3'], $_POST['学籍番号3'], $_POST['学生3'], $_POST['学年3'], $_POST['担当教員3'], $_POST['実習開始日3'], $_POST['実習終了日3'], $_POST['総実習時間3'], $_POST['巡回指導日3'], $_POST['帰校日3'], $_POST['オリエンテーション3'], $_POST['特記事項3'], $_POST['実習種別4'], $_POST['学籍番号4'], $_POST['学生4'], $_POST['学年4'], $_POST['担当教員4'], $_POST['実習開始日4'], $_POST['実習終了日4'], $_POST['総実習時間4'], $_POST['巡回指導日4'], $_POST['帰校日4'], $_POST['オリエンテーション4'], $_POST['特記事項4'], $_POST['実習種別5'], $_POST['学籍番号5'], $_POST['学生5'], $_POST['学年5'], $_POST['担当教員5'], $_POST['実習開始日5'], $_POST['実習終了日5'], $_POST['総実習時間5'], $_POST['巡回指導日5'], $_POST['帰校日5'], $_POST['オリエンテーション5'], $_POST['特記事項5'], $配属数, $_POST['法人ID'], $_POST['事業年度']]);
    } catch (\Exception $e) {

      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }
  if ($msg <> "") {
    dsip_msg("以下の学生番号が存在しません。確認してください。<br>" . $msg);

?>

    <div class="text-center">
      <form action='<?php echo 'assignment_info_detail.php'; ?>' method='post' onSubmit='return check()'>
        <input type='hidden' name='事業年度' value="<?PHP echo $_POST['事業年度']; ?>">
        <input type='hidden' name='選択実習種別' value="<?PHP echo $_POST['選択実習種別']; ?>">
        <input type='hidden' name='法人ID' value="<?PHP echo $_POST['法人ID']; ?>">
        <button type='submit' class='btn btn-secondary w-200px'>戻る</button>
      </form>
    </div>


  <?php
    exit;
  } else {
    if ($cnt2 == 0) {
      dsip_msg("追加しました");
    } else {
      dsip_msg("更新しました");
    }
  }

  ?>

  <table class="table">
    <tr>
      <td class="text-center">
        <!--選択した学習種別を保持して戻る-->
        <form action='<?php echo 'assignment_info.php'; ?>' method='post' onSubmit='return check()'>
          <input type='hidden' name='選択実習種別' value="<?php echo $_POST['選択実習種別']; ?>">
          <button type='submit' class='btn btn-secondary w-200px'>戻る</button>
        </form>

      </td>
    </tr>

  </table>
<?php
  exit;
}


/////////////////////////////////////////////////////
// 配属情報テーブルを削除する←つかわなくなったと思う
// 削除は施設情報の削除でこのレコードも削除される
/////////////////////////////////////////////////////
function tbl_assignment_DELETE($法人ID, $事業年度)
{

  try {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE from tbl_assignment WHERE (法人ID=?  AND 事業年度=? )";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([$_POST['法人ID'], $_POST['実習種別'], $_POST['事業年度']]);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }
  $mysqli = null;
  dsip_msg("削除しました");
  btn_return("assignmente_info.php", "戻る");

  exit;
}

/////////////////////////////////////////////////////
// 配属情報テーブルを読み込む
/////////////////////////////////////////////////////

function tbl_assignment_READ($法人ID, $事業年度)
{


  $GLOBALS['法人ID'] = "";
  //$GLOBALS['事業年度'] = "";
  $GLOBALS['NO'] = "";
  $GLOBALS['施設区分'] = "";
  $GLOBALS['法人名'] = "";
  $GLOBALS['施設名'] = "";
  $GLOBALS['施設種別'] = "";
  $GLOBALS['管理者'] = "";
  $GLOBALS['管理者役職名'] = "";
  $GLOBALS['郵便番号'] = "";
  $GLOBALS['所在地'] = "";
  $GLOBALS['実習窓口担当者名'] = "";
  $GLOBALS['指導者1'] = "";
  $GLOBALS['指導者2'] = "";
  $GLOBALS['指導者3'] = "";


  $GLOBALS['実習種別1'] = "";
  $GLOBALS['学籍番号1'] = "";
  $GLOBALS['学生1'] = "";
  $GLOBALS['学年1'] = "";
  $GLOBALS['担当教員1'] = "";
  $GLOBALS['実習開始日1'] = "";
  $GLOBALS['実習終了日1'] = "";
  $GLOBALS['総実習時間1'] = "";
  $GLOBALS['巡回指導日1'] = "";
  $GLOBALS['帰校日1'] = "";
  $GLOBALS['オリエンテーション1'] = "";
  $GLOBALS['特記事項1'] = "";
  $GLOBALS['実習種別2'] = "";
  $GLOBALS['学籍番号2'] = "";
  $GLOBALS['学生2'] = "";
  $GLOBALS['学年2'] = "";
  $GLOBALS['担当教員2'] = "";
  $GLOBALS['実習開始日2'] = "";
  $GLOBALS['実習終了日2'] = "";
  $GLOBALS['総実習時間2'] = "";
  $GLOBALS['巡回指導日2'] = "";
  $GLOBALS['帰校日2'] = "";
  $GLOBALS['オリエンテーション2'] = "";
  $GLOBALS['特記事項2'] = "";
  $GLOBALS['実習種別3'] = "";
  $GLOBALS['学籍番号3'] = "";
  $GLOBALS['学生3'] = "";
  $GLOBALS['学年3'] = "";
  $GLOBALS['担当教員3'] = "";
  $GLOBALS['実習開始日3'] = "";
  $GLOBALS['実習終了日3'] = "";
  $GLOBALS['総実習時間3'] = "";
  $GLOBALS['巡回指導日3'] = "";
  $GLOBALS['帰校日3'] = "";
  $GLOBALS['オリエンテーション3'] = "";
  $GLOBALS['特記事項3'] = "";
  $GLOBALS['実習種別4'] = "";
  $GLOBALS['学籍番号4'] = "";
  $GLOBALS['学生4'] = "";
  $GLOBALS['学年4'] = "";
  $GLOBALS['担当教員4'] = "";
  $GLOBALS['実習開始日4'] = "";
  $GLOBALS['実習終了日4'] = "";
  $GLOBALS['総実習時間4'] = "";
  $GLOBALS['巡回指導日4'] = "";
  $GLOBALS['帰校日4'] = "";
  $GLOBALS['オリエンテーション4'] = "";
  $GLOBALS['特記事項4'] = "";
  $GLOBALS['実習種別5'] = "";
  $GLOBALS['学籍番号5'] = "";
  $GLOBALS['学生5'] = "";
  $GLOBALS['学年5'] = "";
  $GLOBALS['担当教員5'] = "";
  $GLOBALS['実習開始日5'] = "";
  $GLOBALS['実習終了日5'] = "";
  $GLOBALS['総実習時間5'] = "";
  $GLOBALS['巡回指導日5'] = "";
  $GLOBALS['帰校日5'] = "";
  $GLOBALS['オリエンテーション5'] = "";
  $GLOBALS['特記事項5'] = "";


  try {
    // DBへ接続

    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成

    $sql = "select * from tbl_assignment where 法人ID=" . $法人ID . " AND 事業年度='" . $事業年度 . "'";
    $cnt = 0;
    $res = $dbh->query($sql);
    foreach ($res as $value) {
      $cnt = $cnt + 1;

      $GLOBALS['法人ID'] = $value['法人ID'];
      $GLOBALS['事業年度'] = $value['事業年度'];
      $GLOBALS['NO'] = $value['NO'];
      $GLOBALS['施設区分'] = $value['施設区分'];
      $GLOBALS['法人名'] = $value['法人名'];
      $GLOBALS['施設名'] = $value['施設名'];
      $GLOBALS['施設種別'] = $value['施設種別'];
      $GLOBALS['管理者'] = $value['管理者'];
      $GLOBALS['管理者役職名'] = $value['管理者役職名'];
      $GLOBALS['郵便番号'] = $value['郵便番号'];
      $GLOBALS['所在地'] = $value['所在地'];
      $GLOBALS['実習窓口担当者名'] = $value['実習窓口担当者名'];
      $GLOBALS['指導者1'] = $value['実習指導者1'];
      $GLOBALS['指導者2'] = $value['実習指導者2'];
      $GLOBALS['指導者3'] = $value['実習指導者3'];



      $GLOBALS['実習種別1'] = $value['実習種別1'];
      $GLOBALS['学籍番号1'] = $value['学籍番号1'];
      $GLOBALS['学生1'] = $value['氏名1'];
      $GLOBALS['学年1'] = $value['学年1'];


      $GLOBALS['担当教員1'] = $value['担当教員1'];
      $GLOBALS['実習開始日1'] = $value['実習開始日1'];
      $GLOBALS['実習終了日1'] = $value['実習終了日1'];
      $GLOBALS['総実習時間1'] = $value['総実習時間1'];
      $GLOBALS['巡回指導日1'] = $value['巡回指導日1'];
      $GLOBALS['帰校日1'] = $value['帰校日1'];
      $GLOBALS['オリエンテーション1'] = $value['オリエンテーション1'];
      $GLOBALS['特記事項1'] = $value['特記事項1'];


      $GLOBALS['実習種別2'] = $value['実習種別2'];
      $GLOBALS['学籍番号2'] = $value['学籍番号2'];
      $GLOBALS['学生2'] = $value['氏名2'];
      $GLOBALS['学年2'] = $value['学年2'];

      $GLOBALS['担当教員2'] = $value['担当教員2'];
      $GLOBALS['実習開始日2'] = $value['実習開始日2'];
      $GLOBALS['実習終了日2'] = $value['実習終了日2'];
      $GLOBALS['総実習時間2'] = $value['総実習時間2'];
      $GLOBALS['巡回指導日2'] = $value['巡回指導日2'];
      $GLOBALS['帰校日2'] = $value['帰校日2'];
      $GLOBALS['オリエンテーション2'] = $value['オリエンテーション2'];
      $GLOBALS['特記事項2'] = $value['特記事項2'];


      $GLOBALS['実習種別3'] = $value['実習種別3'];
      $GLOBALS['学籍番号3'] = $value['学籍番号3'];
      $GLOBALS['学生3'] = $value['氏名3'];
      $GLOBALS['学年3'] = $value['学年3'];
      $GLOBALS['担当教員3'] = $value['担当教員3'];
      $GLOBALS['実習開始日3'] = $value['実習開始日3'];
      $GLOBALS['実習終了日3'] = $value['実習終了日3'];
      $GLOBALS['総実習時間3'] = $value['総実習時間3'];
      $GLOBALS['巡回指導日3'] = $value['巡回指導日3'];
      $GLOBALS['帰校日3'] = $value['帰校日3'];
      $GLOBALS['オリエンテーション3'] = $value['オリエンテーション3'];
      $GLOBALS['特記事項3'] = $value['特記事項3'];

      $GLOBALS['実習種別4'] = $value['実習種別4'];
      $GLOBALS['学籍番号4'] = $value['学籍番号4'];
      $GLOBALS['学生4'] = $value['氏名4'];
      $GLOBALS['学年4'] = $value['学年4'];

      $GLOBALS['担当教員4'] = $value['担当教員4'];
      $GLOBALS['実習開始日4'] = $value['実習開始日4'];
      $GLOBALS['実習終了日4'] = $value['実習終了日4'];
      $GLOBALS['総実習時間4'] = $value['総実習時間4'];
      $GLOBALS['巡回指導日4'] = $value['巡回指導日4'];
      $GLOBALS['帰校日4'] = $value['帰校日4'];
      $GLOBALS['オリエンテーション4'] = $value['オリエンテーション4'];
      $GLOBALS['特記事項4'] = $value['特記事項4'];

      $GLOBALS['実習種別5'] = $value['実習種別5'];
      $GLOBALS['学籍番号5'] = $value['学籍番号5'];
      $GLOBALS['学生5'] = $value['氏名5'];
      $GLOBALS['学年5'] = $value['学年5'];

      $GLOBALS['担当教員5'] = $value['担当教員5'];
      $GLOBALS['実習開始日5'] = $value['実習開始日5'];
      $GLOBALS['実習終了日5'] = $value['実習終了日5'];
      $GLOBALS['総実習時間5'] = $value['総実習時間5'];
      $GLOBALS['巡回指導日5'] = $value['巡回指導日5'];
      $GLOBALS['帰校日5'] = $value['帰校日5'];
      $GLOBALS['オリエンテーション5'] = $value['オリエンテーション5'];
      $GLOBALS['特記事項5'] = $value['特記事項5'];
    }
  } catch (PDOException $e) {

    echo $e->getMessage();
    die();
    exit;
  }

  if ($cnt > 0) {
    $res = null;
    $dbh = null;

    return $cnt;
  } else {

    /////////////////////////////////////////////////////////////////////
    // 配属情報テーブルを読み込むタイミングで、施設情報と指導者情報も読む
    /////////////////////////////////////////////////////////////////////
    tbl_institution_READ($法人ID);
    tbl_instructor_READ($法人ID);
  }
}


/////////////////////////////////////////////////////////////////////
// 指導者テーブルの該当レコードを削除する←個別削除でつかわなくなった。
// 削除は施設情報の削除でこのレコードも削除される
/////////////////////////////////////////////////////////////////////

function tbl_instructor_DELETE($法人ID)
{

  try {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE from tbl_instructor WHERE 指導者ID=?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([$_POST['指導者ID']]);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }
  $mysqli = null;
  dsip_msg("削除しました");
  btn_return("practice_info.php", "戻る");

  exit;
}


/////////////////////////////////////////////////////////////////////
// 削除フラグをチェックして初期化する
/////////////////////////////////////////////////////////////////////
function tbl_instructor_UPDATE($法人ID)
{
  if ($_POST['delete1'] == "on") {
    $_POST['氏名1'] = "";
    $_POST['講習会修了日1'] = "";
    $_POST['提出年月日1'] = "";
    $_POST['調書資格1'] = "";
    $_POST['在籍確認1'] = "";
    $_POST['異動日1'] = "";
    $_POST['理由1'] = "";
    $_POST['確認日1'] = "";
    $_POST['備考1'] = "";
  }

  if ($_POST['delete2'] == "on") {
    $_POST['氏名2'] = "";
    $_POST['講習会修了日2'] = "";
    $_POST['提出年月日2'] = "";
    $_POST['調書資格2'] = "";
    $_POST['在籍確認2'] = "";
    $_POST['異動日2'] = "";
    $_POST['理由2'] = "";
    $_POST['確認日2'] = "";
    $_POST['備考2'] = "";
  }


  if ($_POST['delete3'] == "on") {
    $_POST['氏名3'] = "";
    $_POST['講習会修了日3'] = "";
    $_POST['提出年月日3'] = "";
    $_POST['調書資格3'] = "";
    $_POST['在籍確認3'] = "";
    $_POST['異動日3'] = "";
    $_POST['理由3'] = "";
    $_POST['確認日3'] = "";
    $_POST['備考3'] = "";
  }


  /////////////////////////////////////////////////////////////////////
  // 氏名が空の場合は前詰めする
  /////////////////////////////////////////////////////////////////////

  if (($_POST['氏名1'] == "")  and ($_POST['氏名2'] <> "")) {
    $_POST['氏名1'] = $_POST['氏名2'];
    $_POST['講習会修了日1'] = $_POST['講習会修了日2'];
    $_POST['提出年月日1'] = $_POST['提出年月日2'];
    $_POST['調書資格1'] = $_POST['調書資格2'];
    $_POST['在籍確認1'] = $_POST['在籍確認2'];
    $_POST['異動日1'] = $_POST['異動日2'];
    $_POST['理由1'] = $_POST['理由2'];
    $_POST['確認日1'] = $_POST['確認日2'];
    $_POST['備考1'] = $_POST['備考2'];

    $_POST['氏名2'] = "";
    $_POST['講習会修了日2'] = "";
    $_POST['提出年月日2'] = "";
    $_POST['調書資格2'] = "";
    $_POST['在籍確認2'] = "";
    $_POST['異動日2'] = "";
    $_POST['理由2'] = "";
    $_POST['確認日2'] = "";
    $_POST['備考2'] = "";
  };


  if (($_POST['氏名1'] == "")  and ($_POST['氏名3'] <> "")) {
    $_POST['氏名1'] = $_POST['氏名3'];
    $_POST['講習会修了日1'] = $_POST['講習会修了日3'];
    $_POST['提出年月日1'] = $_POST['提出年月日3'];
    $_POST['調書資格1'] = $_POST['調書資格3'];
    $_POST['在籍確認1'] = $_POST['在籍確認3'];
    $_POST['異動日1'] = $_POST['異動日3'];
    $_POST['理由1'] = $_POST['理由3'];
    $_POST['確認日1'] = $_POST['確認日3'];
    $_POST['備考1'] = $_POST['備考3'];

    $_POST['氏名3'] = "";
    $_POST['講習会修了日3'] = "";
    $_POST['提出年月日3'] = "";
    $_POST['調書資格3'] = "";
    $_POST['在籍確認3'] = "";
    $_POST['異動日3'] = "";
    $_POST['理由3'] = "";
    $_POST['確認日3'] = "";
    $_POST['備考3'] = "";
  };



  if (($_POST['氏名2'] == "")  and ($_POST['氏名3'] <> "")) {
    $_POST['氏名2'] = $_POST['氏名3'];
    $_POST['講習会修了日2'] = $_POST['講習会修了日3'];
    $_POST['提出年月日2'] = $_POST['提出年月日3'];
    $_POST['調書資格2'] = $_POST['調書資格3'];
    $_POST['在籍確認2'] = $_POST['在籍確認3'];
    $_POST['異動日2'] = $_POST['異動日3'];
    $_POST['理由2'] = $_POST['理由3'];
    $_POST['確認日2'] = $_POST['確認日3'];
    $_POST['備考2'] = $_POST['備考3'];

    $_POST['氏名3'] = "";
    $_POST['講習会修了日3'] = "";
    $_POST['提出年月日3'] = "";
    $_POST['調書資格3'] = "";
    $_POST['在籍確認3'] = "";
    $_POST['異動日3'] = "";
    $_POST['理由3'] = "";
    $_POST['確認日3'] = "";
    $_POST['備考3'] = "";
  };



  // テーブルにレコードが存在するかチェック
  $WHERE = "法人ID=" . $法人ID;
  $cnt = RECODE_CHECK("tbl_instructor", $WHERE);



  if ($cnt == 0) {   /*新規書込み*/
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
      $sql = "insert into tbl_instructor(`法人ID`, `施設区分`, `法人名`, `施設名`, `氏名1`, `講習会修了日1`, `提出年月日1`, `調書資格1`, `在籍確認1`, `異動日1`, `理由1`, `確認日1`, `備考1`, `氏名2`, `講習会修了日2`, `提出年月日2`, `調書資格2`, `在籍確認2`, `異動日2`, `理由2`, `確認日2`, `備考2`, `氏名3`, `講習会修了日3`, `提出年月日3`, `調書資格3`, `在籍確認3`, `異動日3`, `理由3`, `確認日3`, `備考3`) value (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";


      $stmt = $pdo->prepare($sql);




      $stmt->execute([$_POST['法人ID'], $_POST['施設区分'], $_POST['法人名'], $_POST['施設名'], $_POST['氏名1'], $_POST['講習会修了日1'], $_POST['提出年月日1'], $_POST['調書資格1'], $_POST['在籍確認1'], $_POST['異動日1'], $_POST['理由1'], $_POST['確認日1'], $_POST['備考1'], $_POST['氏名2'], $_POST['講習会修了日2'], $_POST['提出年月日2'], $_POST['調書資格2'], $_POST['在籍確認2'], $_POST['異動日2'], $_POST['理由2'], $_POST['確認日2'], $_POST['備考2'], $_POST['氏名3'], $_POST['講習会修了日3'], $_POST['提出年月日3'], $_POST['調書資格3'], $_POST['在籍確認3'], $_POST['異動日3'], $_POST['理由3'], $_POST['確認日3'], $_POST['備考3']]);
    } catch (\Exception $e) {

      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }

    dsip_msg("追加しました");
    btn_return("practice_info.php", "戻る");
    exit;
  } else   /*更新書込み*/


    try {

      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "UPDATE tbl_instructor SET 施設区分= ?, 法人名= ?, 施設名= ?, 氏名1= ?, 講習会修了日1= ?, 提出年月日1= ?, 調書資格1= ?, 在籍確認1= ?, 異動日1= ?, 理由1= ?, 確認日1= ?, 備考1= ?, 氏名2= ?, 講習会修了日2= ?, 提出年月日2= ?, 調書資格2= ?, 在籍確認2= ?, 異動日2= ?, 理由2= ?, 確認日2= ?, 備考2= ?, 氏名3= ?, 講習会修了日3= ?, 提出年月日3= ?, 調書資格3= ?, 在籍確認3= ?, 異動日3= ?, 理由3= ?, 確認日3= ?, 備考3= ?
 WHERE 法人ID=?";


      $stmt = $pdo->prepare($sql);


      $stmt->execute([$_POST['施設区分'], $_POST['法人名'], $_POST['施設名'], $_POST['氏名1'], $_POST['講習会修了日1'], $_POST['提出年月日1'], $_POST['調書資格1'], $_POST['在籍確認1'], $_POST['異動日1'], $_POST['理由1'], $_POST['確認日1'], $_POST['備考1'], $_POST['氏名2'], $_POST['講習会修了日2'], $_POST['提出年月日2'], $_POST['調書資格2'], $_POST['在籍確認2'], $_POST['異動日2'], $_POST['理由2'], $_POST['確認日2'], $_POST['備考2'], $_POST['氏名3'], $_POST['講習会修了日3'], $_POST['提出年月日3'], $_POST['調書資格3'], $_POST['在籍確認3'], $_POST['異動日3'], $_POST['理由3'], $_POST['確認日3'], $_POST['備考3'], $_POST['法人ID']]);
    } catch (\Exception $e) {

      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }
  $mysqli = null;

  dsip_msg("更新しました");
  btn_return("practice_info.php", "戻る");
  exit;
}



/////////////////////////////////////////////////////////////////////
// 指導者情報テーブルの読込（タイプ２）
/////////////////////////////////////////////////////////////////////
function tbl_instructor_READ2($法人ID)
{

  $GLOBALS['指導者1'] = "";
  $GLOBALS['指導者2'] = "";
  $GLOBALS['指導者3'] = "";
  $GLOBALS['施設実習種別1'] = "";
  $GLOBALS['施設実習種別2'] = "";
  try {
    // DBへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成
    $sql = "select 実習種別1,実習種別2,氏名1,氏名2,氏名3 from tbl_institution JOIN tbl_instructor ON tbl_institution.法人ID=tbl_instructor.法人ID  where tbl_institution.法人ID=" . $法人ID;
    $cnt = 0;
    $res = $dbh->query($sql);
    foreach ($res as $value) {
      $cnt = $cnt + 1;
      $GLOBALS['施設実習種別1'] = $value['実習種別1'];
      $GLOBALS['施設実習種別2'] = $value['実習種別2'];
      $GLOBALS['指導者1'] = $value['氏名1'];
      $GLOBALS['指導者2'] = $value['氏名2'];
      $GLOBALS['指導者3'] = $value['氏名3'];
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
    ERR("ここまできたか、エラーか");
    die();
  }
  $res = null;
  $dbh = null;

  return $cnt;
}


/////////////////////////////////////////////////////////////////////
// 指導者情報テーブルの読込
/////////////////////////////////////////////////////////////////////
function tbl_instructor_READ($法人ID)
{
  $GLOBALS['施設区分'] = "";
  $GLOBALS['法人名'] = "";
  $GLOBALS['施設名'] = "";


  $GLOBALS['氏名1'] = "";
  $GLOBALS['講習会修了日1'] = "";
  $GLOBALS['提出年月日1'] = "";
  $GLOBALS['調書資格1'] = "";
  $GLOBALS['在籍確認1'] = "";
  $GLOBALS['異動日1'] = "";
  $GLOBALS['理由1'] = "";
  $GLOBALS['確認日1'] = "";
  $GLOBALS['備考1'] = "";
  $GLOBALS['氏名2'] = "";
  $GLOBALS['講習会修了日2'] = "";
  $GLOBALS['提出年月日2'] = "";
  $GLOBALS['調書資格2'] = "";
  $GLOBALS['在籍確認2'] = "";
  $GLOBALS['異動日2'] = "";
  $GLOBALS['理由2'] = "";
  $GLOBALS['確認日2'] = "";
  $GLOBALS['備考2'] = "";
  $GLOBALS['氏名3'] = "";
  $GLOBALS['講習会修了日3'] = "";
  $GLOBALS['提出年月日3'] = "";
  $GLOBALS['調書資格3'] = "";
  $GLOBALS['在籍確認3'] = "";
  $GLOBALS['異動日3'] = "";
  $GLOBALS['理由3'] = "";
  $GLOBALS['確認日3'] = "";
  $GLOBALS['備考3'] = "";

  try {
    // DBへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成
    $sql = "select * from tbl_instructor where 法人ID=" . $法人ID;
    $cnt = 0;

    $res = $dbh->query($sql);
    foreach ($res as $value) {
      $cnt = $cnt + 1;
      $GLOBALS['法人ID'] = $value['法人ID'];
      $GLOBALS['施設区分'] = $value['施設区分'];
      $GLOBALS['法人名'] = $value['法人名'];
      $GLOBALS['施設名'] = $value['施設名'];
      $GLOBALS['氏名1'] = $value['氏名1'];
      $GLOBALS['講習会修了日1'] = $value['講習会修了日1'];
      $GLOBALS['提出年月日1'] = $value['提出年月日1'];
      $GLOBALS['調書資格1'] = $value['調書資格1'];
      $GLOBALS['在籍確認1'] = $value['在籍確認1'];
      $GLOBALS['異動日1'] = $value['異動日1'];
      $GLOBALS['理由1'] = $value['理由1'];
      $GLOBALS['確認日1'] = $value['確認日1'];
      $GLOBALS['備考1'] = $value['備考1'];
      $GLOBALS['氏名2'] = $value['氏名2'];
      $GLOBALS['講習会修了日2'] = $value['講習会修了日2'];
      $GLOBALS['提出年月日2'] = $value['提出年月日2'];
      $GLOBALS['調書資格2'] = $value['調書資格2'];
      $GLOBALS['在籍確認2'] = $value['在籍確認2'];
      $GLOBALS['異動日2'] = $value['異動日2'];
      $GLOBALS['理由2'] = $value['理由2'];
      $GLOBALS['確認日2'] = $value['確認日2'];
      $GLOBALS['備考2'] = $value['備考2'];
      $GLOBALS['氏名3'] = $value['氏名3'];
      $GLOBALS['講習会修了日3'] = $value['講習会修了日3'];
      $GLOBALS['提出年月日3'] = $value['提出年月日3'];
      $GLOBALS['調書資格3'] = $value['調書資格3'];
      $GLOBALS['在籍確認3'] = $value['在籍確認3'];
      $GLOBALS['異動日3'] = $value['異動日3'];
      $GLOBALS['理由3'] = $value['理由3'];
      $GLOBALS['確認日3'] = $value['確認日3'];
      $GLOBALS['備考3'] = $value['備考3'];
    }
  } catch (PDOException $e) {

    echo $e->getMessage();
    ERR("ここまできたか、エラーか");
    die();
  }
  $res = null;
  $dbh = null;

  return $cnt;
}


/////////////////////////////////////////////////////////////////////
// 施設情報テーブルの削除
// 該当する配属情報テーブルと指導者テーブルも削除する
/////////////////////////////////////////////////////////////////////

function tbl_institution_DELETE($法人ID)
{


  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  try {


    $sql = "DELETE from tbl_institution WHERE 法人ID=" . $_POST['法人ID'] . ";";
    $sql = $sql . "DELETE from tbl_assignment WHERE 法人ID=" . $_POST['法人ID'] . ";";
    $sql = $sql . "DELETE from tbl_instructor WHERE 法人ID=" . $_POST['法人ID'] . ";";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }
  $mysqli = null;


  dsip_msg("削除しました");
  btn_return("practice_info.php", "戻る");
  exit;
}


/////////////////////////////////////////////////////////////////////
// 施設情報テーブルの更新・新規書込み
/////////////////////////////////////////////////////////////////////

function tbl_institution_UPDATE($法人ID)
{

  if ($_POST['実習種別2'] == "選択してください") {
    $_POST['実習種別2'] = "";
  }

  if ($_POST['実習種別1'] == "選択してください") {
    $_POST['実習種別1'] = "";
  }


    $status = $_POST['status'] ?? "";



  if ($status === "法人削除") {
      $cnt = tbl_institution_DELETE($法人ID);
    btn_return("practice_info.php", "戻る");
    exit;
  }


  // テーブルにレコードが存在するかチェック
  $WHERE = "法人ID=" . $法人ID;
  $cnt = RECODE_CHECK("tbl_institution", $WHERE);

  if ($cnt == 0) {   /*新規書込み*/
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
      $sql = "insert into tbl_institution(`施設区分`,`実習種別1`, `実習種別1実日数`, `実習種別2`, `実習種別2実日数`, `法人名`, `施設名`, `施設種別`, `設置者又は経営者`, `管理者`, `管理者役職名`, `設置又は開始の年月日`, `実習施設提出年月日`, `承諾書記載受入人数`, `当該年度の受入人数`, `同時受入可能人数`, `郵便番号`, `所在地`, `最寄駅`, `電話番号`, `FAX番号`,`MAIL`,`URL`,`実習窓口担当者名`, `形態`, `土日祝実習の有無`, `実習委託費以外の費用`, `備考`, `特記事項`, `日委託費`, `総委託費`, `今年度受入数`, `昨年度受入数`, `一昨年度受入数`) value (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

      $stmt = $pdo->prepare($sql);

      $stmt->execute([$_POST['施設区分'], $_POST['実習種別1'], $_POST['実習種別1実日数'], $_POST['実習種別2'], $_POST['実習種別2実日数'], $_POST['法人名'], $_POST['施設名'], $_POST['施設種別'], $_POST['設置者又は経営者'], $_POST['管理者'], $_POST['管理者役職名'], $_POST['設置又は開始の年月日'], $_POST['実習施設提出年月日'], $_POST['承諾書記載受入人数'], $_POST['当該年度の受入人数'], $_POST['同時受入可能人数'], $_POST['郵便番号'], $_POST['所在地'], $_POST['最寄駅'], $_POST['電話番号'], $_POST['FAX番号'], $_POST['MAIL'], $_POST['URL'], $_POST['実習窓口担当者名'], $_POST['形態'], $_POST['土日祝実習の有無'], $_POST['実習委託費以外の費用'], $_POST['備考'], $_POST['特記事項'], $_POST['日委託費'], $_POST['総委託費'], $_POST['今年度受入数'], $_POST['昨年度受入数'], $_POST['一昨年度受入数']]);
    } catch (\Exception $e) {

      dsip_msg($e->getMessage() . PHP_EOL);

      btn_return("index.php", "戻る");
      exit;
    }


    //続いて今書き込んだ法人ID（オートインクリメント）を取得しなくてはならない。
    try {
      // DBへ接続

      $dbh = new PDO(DSN, DB_USER, DB_PASS);
      // SQL作成
      $WHERE = "(実習種別2='" . $_POST['実習種別2'] . "') AND (実習種別1='" . $_POST['実習種別1'] . "') AND (施設名='" . $_POST['施設名'] . "') AND (法人名='" . $_POST['法人名'] . "')";
      $sql = "select * from tbl_institution where " . $WHERE;

      $res = $dbh->query($sql);
      foreach ($res as $value) {
        $GLOBALS['法人ID'] = $value['法人ID'];
      }
    } catch (PDOException $e) {

      echo $e->getMessage();
      ERR("ここまできたか、エラーか");
      die();
    }

    $res = null;
    $dbh = null;



    // テーブルにレコードが存在するかチェック
    $WHERE = "(法人ID=" . $GLOBALS['法人ID'] . ") AND (事業年度='" . $_SESSION['NENDO'] . "')";
    $cnt = RECODE_CHECK("tbl_assignment", $WHERE);

    if ($cnt == 0) {
      $pdo2 = new PDO(DSN, DB_USER, DB_PASS);
      $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      try {
        $sql = "insert into tbl_assignment(法人ID, 事業年度, NO, 施設区分, 法人名, 施設名, 施設種別, 管理者, 管理者役職名, 郵便番号, 所在地, 実習窓口担当者名) value (" . $GLOBALS['法人ID'] . "," . $_SESSION['NENDO'] . "," . $cnt . ",'" . $_POST['施設区分'] . "','" . $_POST['法人名'] . "','" . $_POST['施設名'] . "','" . $_POST['施設種別'] . "','" . $_POST['管理者'] . "','" . $_POST['管理者役職名'] . "','" . $_POST['郵便番号'] . "','" . $_POST['所在地'] . "','" . $_POST['実習窓口担当者名'] . "')";

        $stmt2 = $pdo2->prepare($sql);
        $stmt2->execute();
      } catch (\Exception $e) {
        dsip_msg($e->getMessage() . PHP_EOL);
        btn_return("index.php", "戻る");
        exit;
      }
      $stmt2 = null;
      $pdo2 = null;
    }


    dsip_msg("追加しました");
    btn_return("practice_info.php", "戻る");
    exit;
    //↑↑↑↑↑↑ここまでは新規登録↑↑↑↑↑↑↑



  } else   /*更新書込み*/
    try {

      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "UPDATE tbl_institution SET 施設区分=?,実習種別1=?, 実習種別1実日数=?, 実習種別2=?, 実習種別2実日数=?, 法人名=?, 施設名=?, 施設種別=?, 設置者又は経営者=?, 管理者=?, 管理者役職名=?, 設置又は開始の年月日=?, 実習施設提出年月日=?, 承諾書記載受入人数=?, 当該年度の受入人数=?, 同時受入可能人数=?, 郵便番号=?, 所在地=?, 最寄駅=?, 電話番号=?,FAX番号=?,MAIL=?,URL=?,実習窓口担当者名=?, 形態=?, 土日祝実習の有無=?, 実習委託費以外の費用=?, 備考=?, 特記事項=?, 日委託費=?, 総委託費=?, 今年度受入数=?, 昨年度受入数=?, 一昨年度受入数=? WHERE 法人ID=?";

      $stmt = $pdo->prepare($sql);

      $stmt->execute([$_POST['施設区分'], $_POST['実習種別1'], $_POST['実習種別1実日数'], $_POST['実習種別2'], $_POST['実習種別2実日数'], $_POST['法人名'], $_POST['施設名'], $_POST['施設種別'], $_POST['設置者又は経営者'], $_POST['管理者'], $_POST['管理者役職名'], $_POST['設置又は開始の年月日'], $_POST['実習施設提出年月日'], $_POST['承諾書記載受入人数'], $_POST['当該年度の受入人数'], $_POST['同時受入可能人数'], $_POST['郵便番号'], $_POST['所在地'], $_POST['最寄駅'], $_POST['電話番号'], $_POST['FAX番号'], $_POST['MAIL'], $_POST['URL'], $_POST['実習窓口担当者名'], $_POST['形態'], $_POST['土日祝実習の有無'], $_POST['実習委託費以外の費用'], $_POST['備考'], $_POST['特記事項'], $_POST['日委託費'], $_POST['総委託費'], $_POST['今年度受入数'], $_POST['昨年度受入数'], $_POST['一昨年度受入数'], $_POST['法人ID']]);
    } catch (\Exception $e) {

      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }
  $mysqli = null;
  dsip_msg("更新しました");
  btn_return("practice_info.php", "戻る");
  exit;
}



/////////////////////////////////////////////////////////////////////
// 施設情報テーブルの読込
/////////////////////////////////////////////////////////////////////

function tbl_institution_READ($法人ID)
{
  $GLOBALS['法人ID'] = "";
  $GLOBALS['施設区分'] = "";
  $GLOBALS['実習種別1'] = "";
  $GLOBALS['実習種別1実日数'] = "";
  $GLOBALS['実習種別2'] = "";
  $GLOBALS['実習種別2実日数'] = "";
  $GLOBALS['法人名'] = "";
  $GLOBALS['施設名'] = "";
  $GLOBALS['施設種別'] = "";
  $GLOBALS['設置者又は経営者'] = "";
  $GLOBALS['管理者'] = "";
  $GLOBALS['管理者役職名'] = "";
  $GLOBALS['設置又は開始の年月日'] = "";
  $GLOBALS['実習施設提出年月日'] = "";
  $GLOBALS['承諾書記載受入人数'] = "";
  $GLOBALS['当該年度の受入人数'] = "";
  $GLOBALS['同時受入可能人数'] = "";
  $GLOBALS['郵便番号'] = "";
  $GLOBALS['所在地'] = "";
  $GLOBALS['最寄駅'] = "";
  $GLOBALS['電話番号'] = "";

  $GLOBALS['FAX番号'] = "";
  $GLOBALS['MAIL'] = "";
  $GLOBALS['URL'] = "";



  $GLOBALS['実習窓口担当者名'] = "";
  $GLOBALS['形態'] = "";
  $GLOBALS['土日祝実習の有無'] = "";
  $GLOBALS['実習委託費以外の費用'] = "";
  $GLOBALS['備考'] = "";
  $GLOBALS['特記事項'] = "";
  $GLOBALS['日委託費'] = "";
  $GLOBALS['総委託費'] = "";
  $GLOBALS['今年度受入数'] = "";
  $GLOBALS['昨年度受入数'] = "";
  $GLOBALS['一昨年度受入数'] = "";
  $GLOBALS['昨年度受入数'] = "";
  if ($法人ID == "新規追加") {
    return 0;
  }


  try {
    // DBへ接続

    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成

    $sql = "select * from tbl_institution where 法人ID=" . $法人ID;

    $cnt = 0;




    $res = $dbh->query($sql);

    foreach ($res as $value) {
      $cnt = $cnt + 1;

      $GLOBALS['法人ID'] = $value['法人ID'];
      $GLOBALS['施設区分'] = $value['施設区分'];
      $GLOBALS['実習種別1'] = $value['実習種別1'];
      $GLOBALS['実習種別1実日数'] = $value['実習種別1実日数'];
      $GLOBALS['実習種別2'] = $value['実習種別2'];
      $GLOBALS['実習種別2実日数'] = $value['実習種別2実日数'];
      $GLOBALS['法人名'] = $value['法人名'];
      $GLOBALS['施設名'] = $value['施設名'];
      $GLOBALS['施設種別'] = $value['施設種別'];
      $GLOBALS['設置者又は経営者'] = $value['設置者又は経営者'];
      $GLOBALS['管理者'] = $value['管理者'];
      $GLOBALS['管理者役職名'] = $value['管理者役職名'];
      $GLOBALS['設置又は開始の年月日'] = $value['設置又は開始の年月日'];
      $GLOBALS['実習施設提出年月日'] = $value['実習施設提出年月日'];
      $GLOBALS['承諾書記載受入人数'] = $value['承諾書記載受入人数'];
      $GLOBALS['当該年度の受入人数'] = $value['当該年度の受入人数'];
      $GLOBALS['同時受入可能人数'] = $value['同時受入可能人数'];
      $GLOBALS['郵便番号'] = $value['郵便番号'];
      $GLOBALS['所在地'] = $value['所在地'];
      $GLOBALS['最寄駅'] = $value['最寄駅'];
      $GLOBALS['電話番号'] = $value['電話番号'];
      $GLOBALS['FAX番号'] = $value['FAX番号'];
      $GLOBALS['MAIL'] = $value['MAIL'];
      $GLOBALS['URL'] = $value['URL'];

      $GLOBALS['実習窓口担当者名'] = $value['実習窓口担当者名'];
      $GLOBALS['形態'] = $value['形態'];
      $GLOBALS['土日祝実習の有無'] = $value['土日祝実習の有無'];
      $GLOBALS['実習委託費以外の費用'] = $value['実習委託費以外の費用'];
      $GLOBALS['備考'] = $value['備考'];
      $GLOBALS['特記事項'] = $value['特記事項'];
      $GLOBALS['日委託費'] = $value['日委託費'];
      $GLOBALS['総委託費'] = $value['総委託費'];
      $GLOBALS['今年度受入数'] = $value['今年度受入数'];
      $GLOBALS['昨年度受入数'] = $value['昨年度受入数'];
      $GLOBALS['一昨年度受入数'] = $value['一昨年度受入数'];
      $GLOBALS['昨年度受入数'] = $value['昨年度受入数'];
    }
  } catch (PDOException $e) {

    echo $e->getMessage();
    ERR("ここまできたか、エラーか");
    die();
  }

  $res = null;
  $dbh = null;

  return $cnt;
}


/////////////////////////////////////////////////////////////////////
// 自己評価表テープの読込
/////////////////////////////////////////////////////////////////////

function tbl_self_assessment_READ($student_number, $self_assessment_title, $mode)
{


  $GLOBALS['配属情報テーブルID'] = "";

  if ($mode == "教員") {

    $GLOBALS['法人名'] = "";
    $GLOBALS['施設名'] = "";
    $GLOBALS['実習種別'] = "";
    $GLOBALS['施設種別'] = "";
    $GLOBALS['学籍番号'] = "";
    $GLOBALS['氏名'] = "";
    $GLOBALS['かな'] = "";
  }




  $GLOBALS['実習先責任者'] = "";
  $GLOBALS['実習先指導者名'] = "";
  $GLOBALS['実習開始日'] = "";
  $GLOBALS['実習終了日'] = "";
  $GLOBALS['出勤日数'] = "";
  $GLOBALS['病気日'] = "";
  $GLOBALS['事故日'] = "";
  $GLOBALS['遅刻日'] = "";
  $GLOBALS['早退日'] = "";


  $GLOBALS['出勤日数'] = "";
  $GLOBALS['実習方法'] = "";
  $GLOBALS['病気日'] = "";
  $GLOBALS['事故日'] = "";
  $GLOBALS['遅刻日'] = "";
  $GLOBALS['早退日'] = "";
  $GLOBALS['評価区分'] = "";
  /*
  $GLOBALS['評価項目1'] = "";
  $GLOBALS['評価項目2'] = "";
  $GLOBALS['評価項目3'] = "";
  $GLOBALS['評価項目4'] = "";
  $GLOBALS['評価項目5'] = "";
  $GLOBALS['評価項目6'] = "";
  $GLOBALS['評価項目7'] = "";
  $GLOBALS['評価項目8'] = "";
  $GLOBALS['評価項目9'] = "";
  $GLOBALS['評価項目10'] = "";
  $GLOBALS['評価項目11'] = "";
  $GLOBALS['評価項目12'] = "";

*/
  $GLOBALS['評価点1'] = "";
  $GLOBALS['評価点2'] = "";
  $GLOBALS['評価点3'] = "";
  $GLOBALS['評価点4'] = "";
  $GLOBALS['評価点5'] = "";
  $GLOBALS['評価点6'] = "";
  $GLOBALS['評価点7'] = "";
  $GLOBALS['評価点8'] = "";
  $GLOBALS['評価点9'] = "";
  $GLOBALS['評価点10'] = "";
  $GLOBALS['評価点11'] = "";
  $GLOBALS['評価点12'] = "";
  $GLOBALS['総合評価項目'] = "";
  $GLOBALS['総合評価点'] = "";
  $GLOBALS['自己評価'] = "";
  $GLOBALS['comments_of_teacher'] = "";

  try {
    // DBへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成

    $sql = "select * from tbl_self_assessment where 学籍番号='" . $student_number . "' and 実習種別='" . $self_assessment_title . "'";

    $cnt = 0;

    $res = $dbh->query($sql);

    foreach ($res as $value) {
      $cnt = $cnt + 1;
      $GLOBALS['配属情報テーブルID'] = $value['配属情報テーブルID'];


      if ($mode == "教員") {

        $GLOBALS['法人名'] = $value['法人名'];
        $GLOBALS['施設名'] = $value['施設名'];
        $GLOBALS['実習種別'] = $value['実習種別'];
        $GLOBALS['施設種別'] = $value['施設種別'];
        $GLOBALS['学籍番号'] = $value['学籍番号'];
        $GLOBALS['氏名'] = $value['氏名'];
        $GLOBALS['かな'] = $value['かな'];
      }


      $GLOBALS['実習先責任者'] = $value['実習先責任者'];
      $GLOBALS['実習先指導者名'] = $value['実習先指導者名'];
      $GLOBALS['実習開始日'] = $value['実習開始日'];
      $GLOBALS['実習終了日'] = $value['実習終了日'];
      $GLOBALS['出勤日数'] = $value['出勤日数'];
      $GLOBALS['病気日'] = $value['病気日'];
      $GLOBALS['事故日'] = $value['事故日'];
      $GLOBALS['遅刻日'] = $value['遅刻日'];
      $GLOBALS['早退日'] = $value['早退日'];


      /*
      $GLOBALS['評価項目1'] = $value['評価項目1'];
      $GLOBALS['評価項目2'] = $value['評価項目2'];
      $GLOBALS['評価項目3'] = $value['評価項目3'];
      $GLOBALS['評価項目4'] = $value['評価項目4'];
      $GLOBALS['評価項目5'] = $value['評価項目5'];
      $GLOBALS['評価項目6'] = $value['評価項目6'];
      $GLOBALS['評価項目7'] = $value['評価項目7'];
      $GLOBALS['評価項目8'] = $value['評価項目8'];
      $GLOBALS['評価項目9'] = $value['評価項目9'];
      $GLOBALS['評価項目10'] = $value['評価項目10'];
      $GLOBALS['評価項目11'] = $value['評価項目11'];
      $GLOBALS['評価項目12'] = $value['評価項目12'];


*/
      $GLOBALS['評価点1'] = $value['評価点1'];
      $GLOBALS['評価点2'] = $value['評価点2'];
      $GLOBALS['評価点3'] = $value['評価点3'];
      $GLOBALS['評価点4'] = $value['評価点4'];
      $GLOBALS['評価点5'] = $value['評価点5'];
      $GLOBALS['評価点6'] = $value['評価点6'];
      $GLOBALS['評価点7'] = $value['評価点7'];
      $GLOBALS['評価点8'] = $value['評価点8'];
      $GLOBALS['評価点9'] = $value['評価点9'];
      $GLOBALS['評価点10'] = $value['評価点10'];
      $GLOBALS['評価点11'] = $value['評価点11'];
      $GLOBALS['評価点12'] = $value['評価点12'];

      $GLOBALS['総合評価点'] = $value['総合評価点'];
      $GLOBALS['自己評価'] = $value['自己評価'];

      $GLOBALS['comments_of_teacher'] = $value['comments_of_teacher'];
    }
  } catch (PDOException $e) {

    echo $e->getMessage();
    ERR("ここまできたか、エラーか");
    die();
  }
  $res = null;
  $dbh = null;
  return $cnt;
}



//////////////////////////////////////////////////////////////////////////////
//　学生の作成した実習リフレクション・シートへの教員のコメント書込み
//////////////////////////////////////////////////////////////////////////////

function tbl_self_assessment_COMMENT_UP($student_number, $self_assessment_title)
{
  try {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE tbl_self_assessment SET comments_of_teacher= ? WHERE (学籍番号=?) AND (実習種別=?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$_POST['comments_of_teacher'], $student_number, $self_assessment_title]);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }
  $mysqli = null;

  dsip_msg("更新しました");
  btn_return("student_list.php", "戻る");
  exit;
}




//////////////////////////////////////////////////
//実習リフレクション・シート書込み
//////////////////////////////////////////////////

function tbl_self_assessment_UPDATE($student_number, $self_assessment_title)
{

  // テーブルにレコードが存在するかチェック
  $WHERE = " (学籍番号='" . $student_number . "') AND (実習種別='" . $self_assessment_title . "')";
  $cnt = RECODE_CHECK("tbl_self_assessment", $WHERE);

  if ($cnt == 0) {   /*新規書込み*/
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
      $sql = "insert into tbl_self_assessment(`配属情報テーブルID`, `法人名`, `施設名`, `実習種別`, `施設種別`, `実習先責任者`, `実習先指導者名`, `学籍番号`, `氏名`, `かな`, `実習開始日`, `実習終了日`, `出勤日数`, `病気日`, `事故日`, `遅刻日`, `早退日`, `評価項目1`, `評価項目2`, `評価項目3`, `評価項目4`, `評価項目5`, `評価項目6`, `評価項目7`, `評価項目8`, `評価項目9`, `評価項目10`, `評価項目11`, `評価項目12`, `評価点1`, `評価点2`, `評価点3`, `評価点4`, `評価点5`, `評価点6`, `評価点7`, `評価点8`, `評価点9`, `評価点10`, `評価点11`, `評価点12`, `総合評価点`,`自己評価`) value (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

      $stmt = $pdo->prepare($sql);

      $stmt->execute([$_POST['配属情報テーブルID'], $_POST['法人名'], $_POST['施設名'], $self_assessment_title, $_POST['施設種別'], $_POST['実習先責任者'], $_POST['実習先指導者名'], $_POST['学籍番号'], $_POST['氏名'], $_POST['かな'], $_POST['実習開始日'], $_POST['実習終了日'], $_POST['出勤日数'], $_POST['病気日'], $_POST['事故日'], $_POST['遅刻日'], $_POST['早退日'], $_POST['評価項目1'], $_POST['評価項目2'], $_POST['評価項目3'], $_POST['評価項目4'], $_POST['評価項目5'], $_POST['評価項目6'], $_POST['評価項目7'], $_POST['評価項目8'], $_POST['評価項目9'], $_POST['評価項目10'], $_POST['評価項目11'], $_POST['評価項目12'], $_POST['評価点1'], $_POST['評価点2'], $_POST['評価点3'], $_POST['評価点4'], $_POST['評価点5'], $_POST['評価点6'], $_POST['評価点7'], $_POST['評価点8'], $_POST['評価点9'], $_POST['評価点10'], $_POST['評価点11'], $_POST['評価点12'], $_POST['総合評価点'], $_POST['自己評価']]);
    } catch (\Exception $e) {


      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }

    dsip_msg("追加しました");
    btn_return("select_sheet_practice.php", "戻る");
    exit;
  } else   /*更新書込み*/

    try {

      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "UPDATE tbl_self_assessment SET 配属情報テーブルID= ?,法人名= ?,施設名= ?,施設種別= ?,実習先責任者= ?,実習先指導者名= ?,氏名= ?,かな= ?,実習開始日= ?,実習終了日= ?,出勤日数= ?,病気日= ?,事故日= ?,遅刻日= ?,早退日= ?,評価項目1= ?,評価項目2= ?,評価項目3= ?,評価項目4= ?,評価項目5= ?,評価項目6= ?,評価項目7= ?,評価項目8= ?,評価項目9= ?,評価項目10= ?,評価項目11= ?,評価項目12= ?,評価点1= ?,評価点2= ?,評価点3= ?,評価点4= ?,評価点5= ?,評価点6= ?,評価点7= ?,評価点8= ?,評価点9= ?,評価点10= ?,評価点11= ?,評価点12= ?,総合評価点= ?,自己評価= ?
 WHERE (学籍番号=?) AND (実習種別=?)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$_POST['配属情報テーブルID'], $_POST['法人名'], $_POST['施設名'], $_POST['施設種別'], $_POST['実習先責任者'], $_POST['実習先指導者名'], $_POST['氏名'], $_POST['かな'], $_POST['実習開始日'], $_POST['実習終了日'], $_POST['出勤日数'], $_POST['病気日'], $_POST['事故日'], $_POST['遅刻日'], $_POST['早退日'], $_POST['評価項目1'], $_POST['評価項目2'], $_POST['評価項目3'], $_POST['評価項目4'], $_POST['評価項目5'], $_POST['評価項目6'], $_POST['評価項目7'], $_POST['評価項目8'], $_POST['評価項目9'], $_POST['評価項目10'], $_POST['評価項目11'], $_POST['評価項目12'], $_POST['評価点1'], $_POST['評価点2'], $_POST['評価点3'], $_POST['評価点4'], $_POST['評価点5'], $_POST['評価点6'], $_POST['評価点7'], $_POST['評価点8'], $_POST['評価点9'], $_POST['評価点10'], $_POST['評価点11'], $_POST['評価点12'], $_POST['総合評価点'], $_POST['自己評価'], $student_number, $self_assessment_title]);
    } catch (\Exception $e) {

      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }
  $mysqli = null;

  dsip_msg("更新しました");
  btn_return("select_sheet_practice.php", "戻る");
  exit;
}

/////////////////////////////////////////////////////////////
//学生が書いた実習計画書にたいする教員のコメント書込み
/////////////////////////////////////////////////////////////

function tbl_practice_plan_COMMENT_UP($student_number, $practice_plan_title)
{

  try {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE tbl_practice_plan SET comments_of_teacher= ? WHERE (学籍番号=?) AND (実習種別=?)";

    $stmt = $pdo->prepare($sql);


    $stmt->execute([$_POST['comments_of_teacher'], $student_number, $practice_plan_title]);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }
  $mysqli = null;

  dsip_msg("更新しました");
  btn_return("student_list.php", "戻る");
  exit;
}



//////////////////////////////////////////////////
//実習計画書更新・新規作成
//////////////////////////////////////////////////

function tbl_practice_plan_UPDATE($student_number, $practice_plan_title)
{

  // テーブルにレコードが存在するかチェック
  $WHERE = " (学籍番号='" . $student_number . "') AND (実習種別='" . $practice_plan_title . "')";
  $cnt = RECODE_CHECK("tbl_practice_plan", $WHERE);


  if ($cnt == 0) {   /*新規書込み*/
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
      $sql = "insert into tbl_practice_plan(`配属情報テーブルID`,`法人名`,`施設名`, `実習種別`, `施設種別`, `学籍番号`,`氏名`,`かな`, `実習開始日`, `実習終了日`, `準備状況`, `動機目的`, `課題概要`, `実習時期`, `実習課題`, `実習方法`, `備考`) value (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";


      $stmt = $pdo->prepare($sql);

      $stmt->execute([$_POST['配属情報テーブルID'], $_POST['法人名'], $_POST['施設名'], $practice_plan_title, $_POST['施設種別'], $student_number, $_POST['氏名'], $_POST['かな'], $_POST['実習開始日'], $_POST['実習終了日'], $_POST['準備状況'], $_POST['動機目的'], $_POST['課題概要'], $_POST['実習時期'], $_POST['実習課題'], $_POST['実習方法'], $_POST['備考']]);
    } catch (\Exception $e) {


      dsip_msg($e->getMessage() . PHP_EOL);

      btn_return("index.php", "戻る");
      exit;
    }
    dsip_msg("追加しました");
    btn_return("select_sheet_practice.php", "戻る");

    exit;
  } else   /*更新書込み*/
    try {

      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "UPDATE tbl_practice_plan SET 配属情報テーブルID= ?,法人名= ?,施設名= ?,  施設種別= ?, 氏名= ?,かな= ?, 実習開始日= ?, 実習終了日= ?, 準備状況= ?, 動機目的= ?, 課題概要= ?, 実習時期= ?, 実習課題= ?, 実習方法= ?, 備考= ? WHERE (学籍番号=?) AND (実習種別=?)";

      $stmt = $pdo->prepare($sql);


      $stmt->execute([$_POST['配属情報テーブルID'], $_POST['法人名'], $_POST['施設名'],  $_POST['施設種別'], $_POST['氏名'], $_POST['かな'], $_POST['実習開始日'], $_POST['実習終了日'], $_POST['準備状況'], $_POST['動機目的'], $_POST['課題概要'], $_POST['実習時期'], $_POST['実習課題'], $_POST['実習方法'], $_POST['備考'], $student_number, $practice_plan_title]);
    } catch (\Exception $e) {

      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }


  $mysqli = null;
  dsip_msg("更新しました");
  btn_return("select_sheet_practice.php", "戻る");
  exit;
}




/////////////////////////////////////////////
// テーブルにレコードが存在するかチェック
/////////////////////////////////////////////
function RECODE_CHECK($table, $WHERE)
{
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = "SELECT COUNT(*) FROM `$table` WHERE $WHERE";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    return $count;
  } catch (PDOException $e) {
    error_log("RECODE_CHECK PDO Error: " . $e->getMessage());
    return 0;
  } finally {
    $stmt = null;
    $pdo = null;
  }
}


//////////////////////////////////////////////////
//配属情報テーブルの学生が存在するか読込
//////////////////////////////////////////////////

function tbl_assignment_read2($student_number, $syubetu)
{

  try {
    // DBへ接続

    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成
    $sql = "select *  FROM `tbl_assignment` where (((実習種別1='" . $syubetu . "') AND (学籍番号1='" . $student_number . "')) OR
((実習種別2='" . $syubetu . "') AND (学籍番号2='" . $student_number . "')) OR ((実習種別3='" . $syubetu . "') AND (学籍番号3='" . $student_number . "')) OR
((実習種別4='" . $syubetu . "') AND (学籍番号4='" . $student_number . "')) OR ((実習種別5='" . $syubetu . "') AND (学籍番号5='" . $student_number . "')))";


    $cnt = 0;


    $res = $dbh->query($sql);

    foreach ($res as $value) {
      $cnt = $cnt + 1;


      $GLOBALS['配属情報テーブルID'] = $value['配属情報ID'];

      $GLOBALS['法人名'] = $value['法人名'];
      $GLOBALS['施設名'] = $value['施設名'];
      $GLOBALS['施設種別'] = $value['施設種別'];
      $GLOBALS['管理者'] = $value['管理者'];





      if ($value['学籍番号1'] == $student_number) {
        $GLOBALS['担当教員'] = $value['担当教員1'];
        $GLOBALS['実習開始日'] = $value['実習開始日1'];
        $GLOBALS['実習終了日'] = $value['実習終了日1'];
        $GLOBALS['総実習時間'] = $value['総実習時間1'];
      }
      if ($value['学籍番号2'] == $student_number) {
        $GLOBALS['担当教員'] = $value['担当教員2'];
        $GLOBALS['実習開始日'] = $value['実習開始日2'];
        $GLOBALS['実習終了日'] = $value['実習終了日2'];
        $GLOBALS['総実習時間'] = $value['総実習時間2'];
      }
      if ($value['学籍番号3'] == $student_number) {
        $GLOBALS['担当教員'] = $value['担当教員3'];
        $GLOBALS['実習開始日'] = $value['実習開始日3'];
        $GLOBALS['実習終了日'] = $value['実習終了日3'];
        $GLOBALS['総実習時間'] = $value['総実習時間3'];
      }

      if ($value['学籍番号4'] == $student_number) {
        $GLOBALS['担当教員'] = $value['担当教員4'];
        $GLOBALS['実習開始日'] = $value['実習開始日4'];
        $GLOBALS['実習終了日'] = $value['実習終了日4'];
        $GLOBALS['総実習時間'] = $value['総実習時間4'];
      }


      if ($value['学籍番号5'] == $student_number) {
        $GLOBALS['担当教員'] = $value['担当教員5'];
        $GLOBALS['実習開始日'] = $value['実習開始日5'];
        $GLOBALS['実習終了日'] = $value['実習終了日5'];
        $GLOBALS['総実習時間'] = $value['総実習時間5'];
      }
    }
  } catch (PDOException $e) {

    echo $e->getMessage();

    die();
    exit;
  }

  $res = null;
  $dbh = null;

  return $cnt;
}



////////////////////////////////////////////////////////////////////
//配属情報テーブルに学生が存在したら法人名、施設名だけを取り出す
////////////////////////////////////////////////////////////////////

function tbl_assignment_check($student_number, $syubetu)
//ソーシャルワーク実習Ⅰ
//ソーシャルワーク実習Ⅱ
//精神保健福祉援助実習Ⅰ
//精神保健福祉援助実習Ⅱ
{

  $GLOBALS['法人名'] = "";
  $GLOBALS['施設名'] = "";

  try {
    // DBへ接続


    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成
    $sql = "select `法人名`, `施設名`  FROM `tbl_assignment` where (((実習種別1='" . $syubetu . "') AND (学籍番号1='" . $student_number . "')) OR
((実習種別2='" . $syubetu . "') AND (学籍番号2='" . $student_number . "')) OR ((実習種別3='" . $syubetu . "') AND (学籍番号3='" . $student_number . "')) OR
((実習種別4='" . $syubetu . "') AND (学籍番号4='" . $student_number . "')) OR ((実習種別5='" . $syubetu . "') AND (学籍番号5='" . $student_number . "')))";


    $cnt = 0;


    $res = $dbh->query($sql);

    foreach ($res as $value) {
      $cnt = $cnt + 1;

      $GLOBALS['法人名'] = $value['法人名'];
      $GLOBALS['施設名'] = $value['施設名'];
    }
  } catch (PDOException $e) {

    echo $e->getMessage();

    die();
    exit;
  }

  $res = null;
  $dbh = null;


  return $cnt;
}


//////////////////////////////////////////////////
//実習計画書読込
//////////////////////////////////////////////////

function tbl_practice_plan_READ($student_number, $practice_plan_title, $MODE)
{


  /*$GLOBALS['法人名'] =  "";
  $GLOBALS['施設名'] =   "";
  $GLOBALS['実習種別'] =  "";
  $GLOBALS['施設種別'] =  "";
*/

  //  $GLOBALS['学籍番号'] =  $value['学籍番号'];

  if ($MODE == "教員") {


    $GLOBALS['法人名'] =  "";
    $GLOBALS['施設名'] =   "";
    $GLOBALS['実習種別'] =  "";
    $GLOBALS['施設種別'] =  "";
    $GLOBALS['氏名'] =  "";
    $GLOBALS['かな'] =  "";
  }



  $GLOBALS['実習開始日'] =  "";
  $GLOBALS['実習終了日'] =  "";


  $GLOBALS['準備状況'] =  "";
  $GLOBALS['動機目的'] =   "";
  $GLOBALS['課題概要'] =  "";


  $GLOBALS['実習時期'] = "";
  $GLOBALS['実習課題'] =  "";
  $GLOBALS['実習方法'] =   "";
  $GLOBALS['備考'] =  "";
  $GLOBALS['comments_of_teacher'] = "";


  try {
    // DBへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成
    $sql = "select * from tbl_practice_plan where 学籍番号='" . $student_number . "' and 実習種別='" . $practice_plan_title . "'";
    $cnt = 0;
    $res = $dbh->query($sql);
    foreach ($res as $value) {
      $cnt = $cnt + 1;

      /*
*/

      //  $GLOBALS['学籍番号'] =  $value['学籍番号'];

      if ($MODE == "教員") {


        $GLOBALS['法人名'] = $value['法人名'];
        $GLOBALS['施設名'] =  $value['施設名'];
        $GLOBALS['実習種別'] =  $value['実習種別'];
        $GLOBALS['施設種別'] =  $value['施設種別'];

        $GLOBALS['氏名'] =  $value['氏名'];
        $GLOBALS['かな'] = $value['かな'];
      }



      $GLOBALS['実習開始日'] =  $value['実習開始日'];
      $GLOBALS['実習終了日'] =  $value['実習終了日'];


      $GLOBALS['準備状況'] =  $value['準備状況'];
      $GLOBALS['動機目的'] =  $value['動機目的'];
      $GLOBALS['課題概要'] =  $value['課題概要'];


      $GLOBALS['実習時期'] =  $value['実習時期'];
      $GLOBALS['実習課題'] =  $value['実習課題'];
      $GLOBALS['実習方法'] =  $value['実習方法'];
      $GLOBALS['備考'] =  $value['備考'];
      $GLOBALS['comments_of_teacher'] = $value['comments_of_teacher'];
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
    die();
    exit;
  }

  $res = null;
  $dbh = null;
  return $cnt;
}



//////////////////////////////////////////////////
//実習リフレクション・シート読込
//////////////////////////////////////////////////

function tbl_reflection_intern_READ($student_number, $reflection_title)
{




  $GLOBALS['実習共通目標1'] = "";
  $GLOBALS['実習共通目標2'] = "";
  $GLOBALS['実習共通目標3'] = "";
  $GLOBALS['実習共通目標4'] = "";
  $GLOBALS['実習共通目標5'] = "";
  $GLOBALS['実習共通目標6'] = "";

  $GLOBALS['実習共通目標7'] = "";
  $GLOBALS['実習共通目標8'] = "";
  $GLOBALS['実習共通目標9'] = "";
  $GLOBALS['実習共通目標10'] = "";
  $GLOBALS['実習共通目標11'] = "";
  $GLOBALS['実習共通目標12'] = "";


  $GLOBALS['実習自己目標1'] = "";
  $GLOBALS['実習自己目標2'] = "";
  $GLOBALS['実習自己目標3'] = "";
  $GLOBALS['実習自己目標4'] = "";
  $GLOBALS['実習自己目標5'] = "";
  $GLOBALS['実習自己目標6'] = "";

  $GLOBALS['実習自己目標7'] = "";
  $GLOBALS['実習自己目標8'] = "";
  $GLOBALS['実習自己目標9'] = "";
  $GLOBALS['実習自己目標10'] = "";
  $GLOBALS['実習自己目標11'] = "";
  $GLOBALS['実習自己目標12'] = "";


  $GLOBALS['実習自己評価1'] = "";
  $GLOBALS['実習自己評価2'] = "";
  $GLOBALS['実習自己評価3'] = "";
  $GLOBALS['実習自己評価4'] = "";
  $GLOBALS['実習自己評価5'] = "";
  $GLOBALS['実習自己評価6'] = "";

  $GLOBALS['実習自己評価7'] = "";
  $GLOBALS['実習自己評価8'] = "";
  $GLOBALS['実習自己評価9'] = "";
  $GLOBALS['実習自己評価10'] = "";
  $GLOBALS['実習自己評価11'] = "";
  $GLOBALS['実習自己評価12'] = "";



  $GLOBALS['実習出来た1'] = "";
  $GLOBALS['実習出来た2'] = "";
  $GLOBALS['実習出来た3'] = "";
  $GLOBALS['実習出来た4'] = "";
  $GLOBALS['実習出来た5'] = "";
  $GLOBALS['実習出来た6'] = "";


  $GLOBALS['実習出来た7'] = "";
  $GLOBALS['実習出来た8'] = "";
  $GLOBALS['実習出来た9'] = "";
  $GLOBALS['実習出来た10'] = "";
  $GLOBALS['実習出来た11'] = "";
  $GLOBALS['実習出来た12'] = "";


  $GLOBALS['実習出来ず1'] = "";
  $GLOBALS['実習出来ず2'] = "";
  $GLOBALS['実習出来ず3'] = "";
  $GLOBALS['実習出来ず4'] = "";
  $GLOBALS['実習出来ず5'] = "";
  $GLOBALS['実習出来ず6'] = "";


  $GLOBALS['実習出来ず7'] = "";
  $GLOBALS['実習出来ず8'] = "";
  $GLOBALS['実習出来ず9'] = "";
  $GLOBALS['実習出来ず10'] = "";
  $GLOBALS['実習出来ず11'] = "";
  $GLOBALS['実習出来ず12'] = "";


  $GLOBALS['実習今後課題1'] = "";
  $GLOBALS['実習今後課題2'] = "";
  $GLOBALS['実習今後課題3'] = "";
  $GLOBALS['実習今後課題4'] = "";
  $GLOBALS['実習今後課題5'] = "";
  $GLOBALS['実習今後課題6'] = "";

  $GLOBALS['実習今後課題7'] = "";
  $GLOBALS['実習今後課題8'] = "";
  $GLOBALS['実習今後課題9'] = "";
  $GLOBALS['実習今後課題10'] = "";
  $GLOBALS['実習今後課題11'] = "";
  $GLOBALS['実習今後課題12'] = "";

  $GLOBALS['comments_of_teacher'] = "";


  //////////////////////////////////////////////////////////////////
  //ソーシャルワーク実習Ⅰの場合はゴールシートで入力した値を読みだす
  //////////////////////////////////////////////////////////////////

  if ($reflection_title == "ソーシャルワーク実習Ⅰ") {
    tbl_goal_sheet_1q_READ($student_number, "2");
  }


  if ($reflection_title == "ソーシャルワーク実習Ⅱ") {
    tbl_goal_sheet_1q_READ($student_number, "2");
  }




  try {
    // DBへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成
    $sql = "select * from tbl_reflection_intern where student_number='" . $student_number . "' and reflection_title='" . $reflection_title . "'";
    $cnt = 0;
    $res = $dbh->query($sql);
    foreach ($res as $value) {
      $cnt = $cnt + 1;
      $GLOBALS['実習共通目標1'] =  $value['共通目標1'];
      $GLOBALS['実習共通目標2'] =  $value['共通目標2'];
      $GLOBALS['実習共通目標3'] =  $value['共通目標3'];
      $GLOBALS['実習共通目標4'] =  $value['共通目標4'];
      $GLOBALS['実習共通目標5'] =  $value['共通目標5'];
      $GLOBALS['実習共通目標6'] = $value['共通目標6'];
      $GLOBALS['実習共通目標7'] =  $value['共通目標7'];
      $GLOBALS['実習共通目標8'] =  $value['共通目標8'];
      $GLOBALS['実習共通目標9'] =  $value['共通目標9'];
      $GLOBALS['実習共通目標10'] =  $value['共通目標10'];
      $GLOBALS['実習共通目標11'] =  $value['共通目標11'];
      $GLOBALS['実習共通目標12'] = $value['共通目標12'];

      $GLOBALS['実習自己目標1'] =  $value['自己目標1'];
      $GLOBALS['実習自己目標2'] =  $value['自己目標2'];
      $GLOBALS['実習自己目標3'] =  $value['自己目標3'];
      $GLOBALS['実習自己目標4'] =  $value['自己目標4'];
      $GLOBALS['実習自己目標5'] =  $value['自己目標5'];
      $GLOBALS['実習自己目標6'] =  $value['自己目標6'];
      $GLOBALS['実習自己目標7'] =  $value['自己目標7'];
      $GLOBALS['実習自己目標8'] =  $value['自己目標8'];
      $GLOBALS['実習自己目標9'] =  $value['自己目標9'];
      $GLOBALS['実習自己目標10'] =  $value['自己目標10'];
      $GLOBALS['実習自己目標11'] =  $value['自己目標11'];
      $GLOBALS['実習自己目標12'] =  $value['自己目標12'];

      $GLOBALS['実習自己評価1'] =  $value['自己評価1'];
      $GLOBALS['実習自己評価2'] =  $value['自己評価2'];
      $GLOBALS['実習自己評価3'] =  $value['自己評価3'];
      $GLOBALS['実習自己評価4'] =  $value['自己評価4'];
      $GLOBALS['実習自己評価5'] =  $value['自己評価5'];
      $GLOBALS['実習自己評価6'] =  $value['自己評価6'];
      $GLOBALS['実習自己評価7'] =  $value['自己評価7'];
      $GLOBALS['実習自己評価8'] =  $value['自己評価8'];
      $GLOBALS['実習自己評価9'] =  $value['自己評価9'];
      $GLOBALS['実習自己評価10'] =  $value['自己評価10'];
      $GLOBALS['実習自己評価11'] =  $value['自己評価11'];
      $GLOBALS['実習自己評価12'] =  $value['自己評価12'];


      $GLOBALS['comments_of_teacher'] = $value['comments_of_teacher'];
    }
  } catch (PDOException $e) {


    echo $e->getMessage();
    ERR("エラーか");

    die();
  }



  // 接続を閉じる
  $res = null;
  $dbh = null;

  try {
    // DBへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成


    $sql = "select * from tbl_reflection_intern2 where student_number='" . $student_number . "' and reflection_title='" . $reflection_title . "'";

    $cnt = 0;


    $res = $dbh->query($sql);

    foreach ($res as $value) {
      $cnt = $cnt + 1;

      $GLOBALS['実習出来た1'] =  $value['出来た1'];
      $GLOBALS['実習出来た2'] =  $value['出来た2'];
      $GLOBALS['実習出来た3'] =  $value['出来た3'];
      $GLOBALS['実習出来た4'] =  $value['出来た4'];
      $GLOBALS['実習出来た5'] =  $value['出来た5'];
      $GLOBALS['実習出来た6'] =  $value['出来た6'];
      $GLOBALS['実習出来た7'] =  $value['出来た7'];
      $GLOBALS['実習出来た8'] =  $value['出来た8'];
      $GLOBALS['実習出来た9'] =  $value['出来た9'];
      $GLOBALS['実習出来た10'] =  $value['出来た10'];
      $GLOBALS['実習出来た11'] =  $value['出来た11'];
      $GLOBALS['実習出来た12'] =  $value['出来た12'];

      $GLOBALS['実習出来ず1'] =  $value['出来ず1'];
      $GLOBALS['実習出来ず2'] =  $value['出来ず2'];
      $GLOBALS['実習出来ず3'] =  $value['出来ず3'];
      $GLOBALS['実習出来ず4'] =  $value['出来ず4'];
      $GLOBALS['実習出来ず5'] =  $value['出来ず5'];
      $GLOBALS['実習出来ず6'] =  $value['出来ず6'];
      $GLOBALS['実習出来ず7'] =  $value['出来ず7'];
      $GLOBALS['実習出来ず8'] =  $value['出来ず8'];
      $GLOBALS['実習出来ず9'] =  $value['出来ず9'];
      $GLOBALS['実習出来ず10'] =  $value['出来ず10'];
      $GLOBALS['実習出来ず11'] =  $value['出来ず11'];
      $GLOBALS['実習出来ず12'] =  $value['出来ず12'];

      $GLOBALS['実習今後課題1'] =  $value['今後課題1'];
      $GLOBALS['実習今後課題2'] =  $value['今後課題2'];
      $GLOBALS['実習今後課題3'] =  $value['今後課題3'];
      $GLOBALS['実習今後課題4'] =  $value['今後課題4'];
      $GLOBALS['実習今後課題5'] =  $value['今後課題5'];
      $GLOBALS['実習今後課題6'] =  $value['今後課題6'];
      $GLOBALS['実習今後課題7'] =  $value['今後課題7'];
      $GLOBALS['実習今後課題8'] =  $value['今後課題8'];
      $GLOBALS['実習今後課題9'] =  $value['今後課題9'];
      $GLOBALS['実習今後課題10'] =  $value['今後課題10'];
      $GLOBALS['実習今後課題11'] =  $value['今後課題11'];
      $GLOBALS['実習今後課題12'] =  $value['今後課題12'];
    }
  } catch (PDOException $e) {


    echo $e->getMessage();
    ERR("エラーか");

    die();
  }




  // 接続を閉じる
  $res = null;
  $dbh = null;
  return $cnt;
}






////////////////////////////////////////////////////////////////////////
//学生が書いた実習リフレクション・シートへの教員のコメント書込み
////////////////////////////////////////////////////////////////////////

function tbl_reflection_intern_COMMENT_UP($student_number, $SHEET_TITLE)
{

  try {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE tbl_reflection_intern SET  comments_of_teacher=?  WHERE (student_number=?) AND (reflection_title=?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['comments_of_teacher'], $student_number, $SHEET_TITLE]);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }

  $stmt = null;
  $pdo = null;


  dsip_msg("更新しました");
  btn_return("student_list.php", "戻る");


  exit;
}


//////////////////////////////////////////////////
// 実習リフレクション・インターンシート書込み
// データ量が多いので二つのテーブルに分けている。
//////////////////////////////////////////////////

function tbl_reflection_intern_update($student_number, $SHEET_TITLE)
{

  //レコードが存在するかチェック
  $WHERE = " (student_number='" . $student_number . "') AND (reflection_title='" . $SHEET_TITLE . "')";
  $cnt = RECODE_CHECK("tbl_reflection_intern", $WHERE);


  if ($cnt == 0) {   /*新規書込み*/
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
      $sql = "insert into tbl_reflection_intern(`student_number`, `reflection_title`, `共通目標1`, `共通目標2`, `共通目標3`, `共通目標4`, `共通目標5`, `共通目標6`, `共通目標7`, `共通目標8`, `共通目標9`, `共通目標10`, `共通目標11`, `共通目標12`, `自己目標1`, `自己目標2`, `自己目標3`, `自己目標4`, `自己目標5`, `自己目標6`, `自己目標7`, `自己目標8`, `自己目標9`, `自己目標10`, `自己目標11`, `自己目標12`, `自己評価1`, `自己評価2`, `自己評価3`, `自己評価4`, `自己評価5`, `自己評価6`, `自己評価7`, `自己評価8`, `自己評価9`, `自己評価10`, `自己評価11`, `自己評価12`) value (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$student_number, $SHEET_TITLE, $_POST['共通目標1'], $_POST['共通目標2'], $_POST['共通目標3'], $_POST['共通目標4'], $_POST['共通目標5'], $_POST['共通目標6'], $_POST['共通目標7'], $_POST['共通目標8'], $_POST['共通目標9'], $_POST['共通目標10'], $_POST['共通目標11'], $_POST['共通目標12'], $_POST['自己目標1'], $_POST['自己目標2'], $_POST['自己目標3'], $_POST['自己目標4'], $_POST['自己目標5'], $_POST['自己目標6'], $_POST['自己目標7'], $_POST['自己目標8'], $_POST['自己目標9'], $_POST['自己目標10'], $_POST['自己目標11'], $_POST['自己目標12'], $_POST['自己評価1'], $_POST['自己評価2'], $_POST['自己評価3'], $_POST['自己評価4'], $_POST['自己評価5'], $_POST['自己評価6'], $_POST['自己評価7'], $_POST['自己評価8'], $_POST['自己評価9'], $_POST['自己評価10'], $_POST['自己評価11'], $_POST['自己評価12']]);
    } catch (\Exception $e) {
      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }
    dsip_msg("追加しました");
    btn_return("select_sheet.php", "戻る");
    exit;
  } else   /*更新書込み*/
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "UPDATE tbl_reflection_intern SET  共通目標1=? ,共通目標2=? ,共通目標3=? ,共通目標4=? ,共通目標5=? ,共通目標6=? ,共通目標7=? ,共通目標8=? ,共通目標9=? ,共通目標10=? ,共通目標11=? ,共通目標12=? ,自己目標1=? ,自己目標2=? ,自己目標3=? ,自己目標4=? ,自己目標5=? ,自己目標6=? ,自己目標7=? ,自己目標8=? ,自己目標9=? ,自己目標10=? ,自己目標11=? ,自己目標12=? ,自己評価1=? ,自己評価2=? ,自己評価3=? ,自己評価4=? ,自己評価5=? ,自己評価6=? ,自己評価7=? ,自己評価8=? ,自己評価9=? ,自己評価10=? ,自己評価11=? ,自己評価12=? WHERE (student_number=?) AND (reflection_title=?)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$_POST['共通目標1'], $_POST['共通目標2'], $_POST['共通目標3'], $_POST['共通目標4'], $_POST['共通目標5'], $_POST['共通目標6'], $_POST['共通目標7'], $_POST['共通目標8'], $_POST['共通目標9'], $_POST['共通目標10'], $_POST['共通目標11'], $_POST['共通目標12'], $_POST['自己目標1'], $_POST['自己目標2'], $_POST['自己目標3'], $_POST['自己目標4'], $_POST['自己目標5'], $_POST['自己目標6'], $_POST['自己目標7'], $_POST['自己目標8'], $_POST['自己目標9'], $_POST['自己目標10'], $_POST['自己目標11'], $_POST['自己目標12'], $_POST['自己評価1'], $_POST['自己評価2'], $_POST['自己評価3'], $_POST['自己評価4'], $_POST['自己評価5'], $_POST['自己評価6'], $_POST['自己評価7'], $_POST['自己評価8'], $_POST['自己評価9'], $_POST['自己評価10'], $_POST['自己評価11'], $_POST['自己評価12'], $student_number, $SHEET_TITLE]);
    } catch (\Exception $e) {
      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }
  $mysqli = null;


  //レコードが存在するかチェック
  $WHERE = " (student_number='" . $student_number . "') AND (reflection_title='" . $SHEET_TITLE . "')";
  $cnt = RECODE_CHECK("tbl_reflection_intern2", $WHERE);

  if ($cnt == 0) {   /*新規書込み*/
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
      $sql = "insert into tbl_reflection_intern2(`student_number`, `reflection_title`,`出来た1`, `出来た2`, `出来た3`, `出来た4`, `出来た5`, `出来た6`, `出来た7`, `出来た8`, `出来た9`, `出来た10`, `出来た11`, `出来た12`, `出来ず1`, `出来ず2`, `出来ず3`, `出来ず4`, `出来ず5`, `出来ず6`, `出来ず7`, `出来ず8`, `出来ず9`, `出来ず10`, `出来ず11`, `出来ず12`, `今後課題1`, `今後課題2`, `今後課題3`, `今後課題4`, `今後課題5`, `今後課題6`, `今後課題7`, `今後課題8`, `今後課題9`, `今後課題10`, `今後課題11`, `今後課題12`) value (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$student_number, $SHEET_TITLE, $_POST['出来た1'], $_POST['出来た2'], $_POST['出来た3'], $_POST['出来た4'], $_POST['出来た5'], $_POST['出来た6'], $_POST['出来た7'], $_POST['出来た8'], $_POST['出来た9'], $_POST['出来た10'], $_POST['出来た11'], $_POST['出来た12'], $_POST['出来ず1'], $_POST['出来ず2'], $_POST['出来ず3'], $_POST['出来ず4'], $_POST['出来ず5'], $_POST['出来ず6'], $_POST['出来ず7'], $_POST['出来ず8'], $_POST['出来ず9'], $_POST['出来ず10'], $_POST['出来ず11'], $_POST['出来ず12'], $_POST['今後課題1'], $_POST['今後課題2'], $_POST['今後課題3'], $_POST['今後課題4'], $_POST['今後課題5'], $_POST['今後課題6'], $_POST['今後課題7'], $_POST['今後課題8'], $_POST['今後課題9'], $_POST['今後課題10'], $_POST['今後課題11'], $_POST['今後課題12']]);
    } catch (\Exception $e) {
      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }
    dsip_msg("追加しました");
    btn_return("select_sheet.php", "戻る");
    exit;
  } else   /*更新書込み*/
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "UPDATE tbl_reflection_intern2 SET  出来た1=? ,出来た2=? ,出来た3=? ,出来た4=? ,出来た5=? ,出来た6=? ,出来た7=? ,出来た8=? ,出来た9=? ,出来た10=? ,出来た11=? ,出来た12=? ,出来ず1=? ,出来ず2=? ,出来ず3=? ,出来ず4=? ,出来ず5=? ,出来ず6=? ,出来ず7=? ,出来ず8=? ,出来ず9=? ,出来ず10=? ,出来ず11=? ,出来ず12=? ,今後課題1=? ,今後課題2=? ,今後課題3=? ,今後課題4=? ,今後課題5=? ,今後課題6=? ,今後課題7=? ,今後課題8=? ,今後課題9=? ,今後課題10=? ,今後課題11=? ,今後課題12=? WHERE (student_number=?) AND (reflection_title=?)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$_POST['出来た1'], $_POST['出来た2'], $_POST['出来た3'], $_POST['出来た4'], $_POST['出来た5'], $_POST['出来た6'], $_POST['出来た7'], $_POST['出来た8'], $_POST['出来た9'], $_POST['出来た10'], $_POST['出来た11'], $_POST['出来た12'], $_POST['出来ず1'], $_POST['出来ず2'], $_POST['出来ず3'], $_POST['出来ず4'], $_POST['出来ず5'], $_POST['出来ず6'], $_POST['出来ず7'], $_POST['出来ず8'], $_POST['出来ず9'], $_POST['出来ず10'], $_POST['出来ず11'], $_POST['出来ず12'], $_POST['今後課題1'], $_POST['今後課題2'], $_POST['今後課題3'], $_POST['今後課題4'], $_POST['今後課題5'], $_POST['今後課題6'], $_POST['今後課題7'], $_POST['今後課題8'], $_POST['今後課題9'], $_POST['今後課題10'], $_POST['今後課題11'], $_POST['今後課題12'], $student_number, $SHEET_TITLE]);
    } catch (\Exception $e) {
      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }
  $mysqli = null;
  dsip_msg("更新しました");
  btn_return("select_sheet.php", "戻る");

  exit;
}




//////////////////////////////////////////////////////////////////
//学生が書いた学修リフレクションシートへの教員のコメント書き込み
//////////////////////////////////////////////////////////////////

function tbl_reflection_base_COMMENT_UP($student_number, $school_year)
{
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE tbl_reflection_base SET  comments_of_teacher=? WHERE (student_number=?) AND (school_year=?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['comments_of_teacher'], $student_number, $school_year]);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }
  $mysqli = null;

  dsip_msg("更新しました");
  btn_return("student_list.php", "戻る");

  exit;
}


//////////////////////////////////////////////////
// 学修リフレクションシートの書込み
//////////////////////////////////////////////////

function tbl_reflection_base_update($student_number, $school_year)
{
  /*レコード存在するか確認*/
  $WHERE = " (student_number='" . $student_number . "') AND (school_year=" . $school_year . ")";
  $cnt = RECODE_CHECK("tbl_reflection_base", $WHERE);

  $fields = [
    '共通目標1',
    '自己目標1',
    '出来た1',
    '出来ず1',
    'ref1_1Q1',
    'ref1_1Q2',
    'ref1_1Q3',
    'ref1_1Q4',
    'ref1_4Q1',
    'ref1_4Q2',
    'ref1_4Q3',
    'ref1_4Q4',
    '今後目標1_1Q',
    '今後目標1_4Q',
    '今後課題1_1Q',
    '今後課題1_4Q',
    '共通目標2',
    '自己目標2',
    '出来た2',
    '出来ず2',
    'ref2_1Q1',
    'ref2_1Q2',
    'ref2_1Q3',
    'ref2_1Q4',
    'ref2_4Q1',
    'ref2_4Q2',
    'ref2_4Q3',
    'ref2_4Q4',
    '今後目標2_1Q',
    '今後目標2_4Q',
    '今後課題2_1Q',
    '今後課題2_4Q',
    '共通目標3',
    '自己目標3',
    '出来た3',
    '出来ず3',
    'ref3_1Q1',
    'ref3_1Q2',
    'ref3_1Q3',
    'ref3_1Q4',
    'ref3_4Q1',
    'ref3_4Q2',
    'ref3_4Q3',
    'ref3_4Q4',
    '今後目標3_1Q',
    '今後目標3_4Q',
    '今後課題3_1Q',
    '今後課題3_4Q',
    '共通目標4',
    '自己目標4',
    '出来た4',
    '出来ず4',
    'ref4_1Q1',
    'ref4_1Q2',
    'ref4_1Q3',
    'ref4_1Q4',
    'ref4_4Q1',
    'ref4_4Q2',
    'ref4_4Q3',
    'ref4_4Q4',
    '今後目標4_1Q',
    '今後目標4_4Q',
    '今後課題4_1Q',
    '今後課題4_4Q',
    '共通目標5',
    '自己目標5',
    '出来た5',
    '出来ず5',
    'ref5_1Q1',
    'ref5_1Q2',
    'ref5_1Q3',
    'ref5_1Q4',
    'ref5_4Q1',
    'ref5_4Q2',
    'ref5_4Q3',
    'ref5_4Q4',
    '今後目標5_1Q',
    '今後目標5_4Q',
    '今後課題5_1Q',
    '今後課題5_4Q',
    'score1Q1',
    'score1Q4',
    'score2Q1',
    'score2Q4',
    'score3Q1',
    'score3Q4',
    'score4Q1',
    'score4Q4',
    'score5Q1',
    'score5Q4',
    'comments_of_teacher'
  ];






  $field_values = [];

  foreach ($fields as $field) {
    $field_values[$field] = isset($_POST[$field]) ? trim($_POST[$field]) : '';
  }

  if ($cnt == 0) {
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $placeholders = rtrim(str_repeat('?, ', count($fields)), ', ');

      $sql = "INSERT INTO tbl_reflection_base (
                  student_number,
                  school_year,
                  " . implode(', ', array_map(function ($f) {
        return "`$f`";
      }, $fields)) . "
                  ) VALUES (
                   ?, ?, " . $placeholders . "
                   )";
      $stmt = $pdo->prepare($sql);

      $execute_array = array_merge([$student_number, $school_year], array_values($field_values));
      $stmt->execute($execute_array);

      dsip_msg("追加しました");
      btn_return("select_sheet.php", "戻る");
      exit;
    } catch (\Exception $e) {
      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    } finally {
      $pdo = null;
    }
  } else {
    try {

      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      error_log("Fields Array: " . implode(", ", $fields));

      foreach ($fields as $field) {
        $trimmed_field = trim($field);
        if (empty($field)) {
          error_log("Empty field name detected: $field");
          dsip_msg("An unexpected error occurred. please contact support.");
          btn_return("index.php", "戻る");
          exit();
        }
      }
      $assignments = implode(", ", array_map(function ($f) {
        return "`$f` = ?";
      }, $fields));

      $sql = "UPDATE tbl_reflection_base SET
                $assignments
                WHERE
                  student_number = ? AND school_year = ?";

      error_log("UPDATE SQL: " . $sql);
      $execute_array = array_merge(array_values($field_values), [$student_number, $school_year]);
      error_log("Parameters: " . print_r($execute_array, true));

      $num_placeholders = count($fields) + 2;
      $num_params = count($execute_array);
      if ($num_placeholders !== $num_params) {
        error_log("Mismatch in placeholders and parameters: placeholders=$num_placeholders, params=$num_params");
        dsip_msg("An unexpected error occurred. Please contact support.");
        btn_return("index.php", "戻る");
        exit();
      }

      $stmt = $pdo->prepare($sql);
      $stmt->execute($execute_array);




      dsip_msg("更新しました");
      btn_return("select_sheet.php", "戻る");
      exit;
    } catch (\Exception $e) {
      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    } finally {
      $pdo = null;
    }
  }
}



//////////////////////////////////////////////////
// 学修リフレクションシートの読込
//////////////////////////////////////////////////
function tbl_reflection_base_READ($student_number, $school_year)
{

  $fields = [
    '共通目標1',
    '自己目標1',
    '出来た1',
    '出来ず1',
    'ref1_1Q1',
    'ref1_1Q2',
    'ref1_1Q3',
    'ref1_1Q4',
    'ref1_4Q1',
    'ref1_4Q2',
    'ref1_4Q3',
    'ref1_4Q4',
    '今後目標1_1Q',
    '今後目標1_4Q',
    '今後課題1_1Q',
    '今後課題1_4Q',
    '共通目標2',
    '自己目標2',
    '出来た2',
    '出来ず2',
    'ref2_1Q1',
    'ref2_1Q2',
    'ref2_1Q3',
    'ref2_1Q4',
    'ref2_4Q1',
    'ref2_4Q2',
    'ref2_4Q3',
    'ref2_4Q4',
    '今後目標2_1Q',
    '今後目標2_4Q',
    '今後課題2_1Q',
    '今後課題2_4Q',
    '共通目標3',
    '自己目標3',
    '出来た3',
    '出来ず3',
    'ref3_1Q1',
    'ref3_1Q2',
    'ref3_1Q3',
    'ref3_1Q4',
    'ref3_4Q1',
    'ref3_4Q2',
    'ref3_4Q3',
    'ref3_4Q4',
    '今後目標3_1Q',
    '今後目標3_4Q',
    '今後課題3_1Q',
    '今後課題3_4Q',
    '共通目標4',
    '自己目標4',
    '出来た4',
    '出来ず4',
    'ref4_1Q1',
    'ref4_1Q2',
    'ref4_1Q3',
    'ref4_1Q4',
    'ref4_4Q1',
    'ref4_4Q2',
    'ref4_4Q3',
    'ref4_4Q4',
    '今後目標4_1Q',
    '今後目標4_4Q',
    '今後課題4_1Q',
    '今後課題4_4Q',
    '共通目標5',
    '自己目標5',
    '出来た5',
    '出来ず5',
    'ref5_1Q1',
    'ref5_1Q2',
    'ref5_1Q3',
    'ref5_1Q4',
    'ref5_4Q1',
    'ref5_4Q2',
    'ref5_4Q3',
    'ref5_4Q4',
    '今後目標5_1Q',
    '今後目標5_4Q',
    '今後課題5_1Q',
    '今後課題5_4Q',
    'score1Q1',
    'score1Q4',
    'score2Q1',
    'score2Q4',
    'score3Q1',
    'score3Q4',
    'score4Q1',
    'score4Q4',
    'score5Q1',
    'score5Q4',
    'comments_of_teacher'
  ];

  foreach ($fields as $field) {
    $GLOBALS[$field] = "";
  }

  $GLOBALS['school_year'] = $school_year;







  try {
    // DBへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = "SELECT " . implode(", ", array_map(function ($field) {
      return "`$field`";
    }, $fields)) . " FROM `tbl_reflection_base` WHERE `student_number` = ? AND `school_year` = ?";

    $stmt = $dbh->prepare($sql);
    $stmt->execute([$student_number, $school_year]);



    $result = $stmt->fetch(PDO::FETCH_ASSOC);



    if ($result) {
      foreach ($fields as $field) {
        if (isset($result[$field])) {
          $GLOBALS[$field] = $result[$field];
        }
      }
      return 1;
    } else {
      return 0;
    }
  } catch (PDOException $e) {
    error_log("Error fetching reflection base data: " . $e->getMessage());
    dsip_msg("An unexpected error occurred while fetching data. please try again later.");
    btn_return("index.php", "戻る");
    exit();
  } finally {
    // 接続を閉じる
    $stmt = null;
    $dbh = null;
  }




}




//////////////////////////////////////////////////
//　プロフィール詳細の更新・新規作成
//////////////////////////////////////////////////
function tbl_profile_detail_UPDATE($student_number, $school_year)
{





  $advanced_course = "";
  $roommate_club_activities = "";
  $other_activities = "";
  $affiliation_circle_campus = "";
  $affiliation_circle_off_campus = "";
  $training_overview = "";
  $training_destination_1 = "";
  $training_destination_2 = "";
  $advanced_training_destination = "";
  $internship_content = "";
  $qualification = "";
  $sw_hope = "";
  $psw_hope = "";
  $adv_hope = "";
  $things_to_consider = "";
  $comments_of_teacher = "";



  //////////////////////////////////////////////////
  //　１年次とそれ以外は、読み込む内容が異なる
  //////////////////////////////////////////////////
  if ($school_year == 1) {
    $roommate_club_activities = $_POST['roommate_club_activities1'];
    $other_activities = $_POST['other_activities1'];
    $affiliation_circle_campus = $_POST['affiliation_circle_campus1'];
    $affiliation_circle_off_campus = $_POST['affiliation_circle_off_campus1'];
    $training_overview = $_POST['training_overview1'];
    $qualification = $_POST['qualification1'];
    $sw_hope = $_POST['sw_hope1'];
    $psw_hope = $_POST['psw_hope1'];
    $adv_hope = $_POST['adv_hope1'];
    $things_to_consider = $_POST['things_to_consider1'];
  }
  if ($school_year == 2) {
    $advanced_course = $_POST['advanced_course2'];
    $roommate_club_activities = $_POST['roommate_club_activities2'];
    $other_activities = $_POST['other_activities2'];
    $affiliation_circle_campus = $_POST['affiliation_circle_campus2'];
    $affiliation_circle_off_campus = $_POST['affiliation_circle_off_campus2'];
    $training_overview = $_POST['training_overview2'];
    $training_destination_1 = $_POST['training_destination_12'];
    $training_destination_2 = $_POST['training_destination_22'];
    $advanced_training_destination = $_POST['advanced_training_destination2'];
    $internship_content = $_POST['internship_content2'];
    $qualification = $_POST['qualification2'];
    $sw_hope = $_POST['sw_hope2'];
    $psw_hope = $_POST['psw_hope2'];
    $adv_hope = $_POST['adv_hope2'];
    $things_to_consider = $_POST['things_to_consider2'];
  }
  if ($school_year == 3) {
    $advanced_course = $_POST['advanced_course3'];
    $roommate_club_activities = $_POST['roommate_club_activities3'];
    $other_activities = $_POST['other_activities3'];
    $affiliation_circle_campus = $_POST['affiliation_circle_campus3'];
    $affiliation_circle_off_campus = $_POST['affiliation_circle_off_campus3'];
    $training_overview = $_POST['training_overview3'];
    $training_destination_1 = $_POST['training_destination_13'];
    $training_destination_2 = $_POST['training_destination_23'];
    $advanced_training_destination = $_POST['advanced_training_destination3'];
    $internship_content = $_POST['internship_content3'];
    $qualification = $_POST['qualification3'];
    $sw_hope = $_POST['sw_hope3'];
    $psw_hope = $_POST['psw_hope3'];
    $adv_hope = $_POST['adv_hope3'];
    $things_to_consider = $_POST['things_to_consider3'];
  }
  if ($school_year == 4) {
    $advanced_course = $_POST['advanced_course4'];
    $roommate_club_activities = $_POST['roommate_club_activities4'];
    $other_activities = $_POST['other_activities4'];
    $affiliation_circle_campus = $_POST['affiliation_circle_campus4'];
    $affiliation_circle_off_campus = $_POST['affiliation_circle_off_campus4'];
    $training_overview = $_POST['training_overview4'];
    $training_destination_1 = $_POST['training_destination_14'];
    $training_destination_2 = $_POST['training_destination_24'];
    $advanced_training_destination = $_POST['advanced_training_destination4'];
    $internship_content = $_POST['internship_content4'];
    $qualification = $_POST['qualification4'];
    $sw_hope = $_POST['sw_hope4'];
    $psw_hope = $_POST['psw_hope4'];
    $adv_hope = $_POST['adv_hope4'];
    $things_to_consider = $_POST['things_to_consider4'];
  }


  ///////////////////////////////////
  //パスワードの正規表現
  ///////////////////////////////////

  //レコードがあるかチェック
  $WHERE = "student_number='" . $student_number . "' and school_year=" . $school_year;
  $cnt = RECODE_CHECK("tbl_profile_detail", $WHERE);

  if ($cnt == 0) {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {


      if ($school_year == 1) {
        $SQL = "insert into tbl_profile_detail(`student_number`,`school_year`,`roommate_club_activities`,`other_activities`,`affiliation_circle_campus`,`affiliation_circle_off_campus`,`training_overview`,`qualification`,`sw_hope`,`psw_hope`,`adv_hope`,`things_to_consider`) value(?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $pdo->prepare($SQL);

        $stmt->execute([$student_number, $school_year,  $roommate_club_activities, $other_activities, $affiliation_circle_campus, $affiliation_circle_off_campus, $training_overview, $qualification, $sw_hope, $psw_hope, $adv_hope, $things_to_consider]);
      } else {

        $SQL = "insert into tbl_profile_detail(`student_number`,`school_year`,`advanced_course`,`roommate_club_activities`,`other_activities`,`affiliation_circle_campus`,`affiliation_circle_off_campus`,`training_overview`,`training_destination_1`,`training_destination_2`,`advanced_training_destination`,`internship_content`,`qualification`,`things_to_consider`,`comments_of_teacher`,`sw_hope`,`psw_hope`,`adv_hope`) value(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $pdo->prepare($SQL);


        $stmt->execute([$student_number, $school_year, $advanced_course, $roommate_club_activities, $other_activities, $affiliation_circle_campus, $affiliation_circle_off_campus, $training_overview, $training_destination_1, $training_destination_2, $advanced_training_destination, $internship_content, $qualification, $things_to_consider, $comments_of_teacher, $sw_hope, $psw_hope, $adv_hope]);
      }
    } catch (\Exception $e) {
      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }


    dsip_msg("追加しました");
    btn_return("select_sheet.php", "戻る");
    exit;
  } else
    try {





      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




      //stop($school_year);

      if ($school_year == 1) {

        $sql = "UPDATE tbl_profile_detail SET school_year=?, roommate_club_activities=?, other_activities=?, affiliation_circle_campus=?, affiliation_circle_off_campus=?, training_overview=?,qualification=?,sw_hope=?,psw_hope=?,adv_hope=?, things_to_consider=? WHERE student_number =? AND school_year=?";





        $stmt = $pdo->prepare($sql);
        $stmt->execute([$school_year, $roommate_club_activities, $other_activities, $affiliation_circle_campus, $affiliation_circle_off_campus, $training_overview, $qualification, $sw_hope, $psw_hope, $adv_hope, $things_to_consider, $student_number, $school_year]);
      } else {

        $SQL = "UPDATE tbl_profile_detail SET school_year=?, advanced_course=?, roommate_club_activities=?, other_activities=?, affiliation_circle_campus=?, affiliation_circle_off_campus=?, training_overview=?,training_destination_1=?, training_destination_2=?, advanced_training_destination=?, internship_content=?, qualification=?,sw_hope=?,psw_hope=?,adv_hope=?, things_to_consider=? WHERE student_number =? AND school_year =?";


        $stmt = $pdo->prepare($SQL);
        $stmt->execute([$school_year, $advanced_course, $roommate_club_activities, $other_activities, $affiliation_circle_campus, $affiliation_circle_off_campus, $training_overview, $training_destination_1, $training_destination_2, $advanced_training_destination, $internship_content, $qualification, $sw_hope, $psw_hope, $adv_hope, $things_to_consider, $student_number, $school_year]);
      }
    } catch (\Exception $e) {
      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }


  $mysqli = null;
  dsip_msg("更新しました");
  btn_return("select_sheet.php", "戻る");
  exit;
}





//////////////////////////////////////////////////
//　コールシート・４Qの書込み
//////////////////////////////////////////////////
function tbl_goal_sheet_4q_UPDATE($student_number, $school_year)
{
  // Assign POST variables with default values
  $student_number = $_POST['STUDENT_NUMBER'] ?? '';
  $school_year = $_POST['SELECT_NEN'] ?? '';

  /* レコードの有無を確認 */
  $WHERE = "student_number='" . $student_number . "' and school_year=" . $school_year;
  $cnt = RECODE_CHECK("tbl_goal_sheet_4q", $WHERE);

  // Function to sanitize inputs
  function sanitize_input($input)
  {
    if (is_array($input)) {
      return implode(',', array_map('trim', $input));
    }
    return trim($input);
  }

  // List all fields that might be arrays and sanitize them
  $fields_to_sanitize = [
    'target_person_4Q',
    'practical_field_4Q',
    'professional_position_4Q',
    'activity_issues_4Q',
    'activity_method_4Q',
    'aimed_results_4Q',
    'your_goal_4Q',
    'need_your_goal_4Q',
    'study_target01_4Q',
    'study_target02_4Q',
    'study_target03_4Q',
    'study_target04_4Q',
    'study_target05_4Q',
    'study_target06_4Q',
    'study_conversion01_4Q',
    'study_conversion02_4Q',
    'study_conversion03_4Q',
    'study_conversion04_4Q',
    'study_conversion05_4Q',
    'study_conversion06_4Q',
    'qualification',
    'qualification_other',
    'education1',
    'education2',
    'education3',
    'education4',
    'experience',
    'reason',
    'goal4q_opt_a1',
    'goal4q_opt_a2',
    'goal4q_opt_a3',
    'goal4q_opt_a4',
    'goal4q_opt_b1',
    'goal4q_opt_b2',
    'goal4q_opt_b3',
    'goal4q_opt_b4',
    'goal4q_opt_c1',
    'goal4q_opt_c2',
    'goal4q_opt_c3',
    'goal4q_opt_c4',
    'goal4q_opt_d1',
    'goal4q_opt_d2',
    'goal4q_opt_d3',
    'goal4q_opt_d4',
    'goal4q_opt_e1',
    'goal4q_opt_e2',
    'goal4q_opt_e3',
    'goal4q_opt_e4',
    'goal4q_opt_g1',
    'goal4q_opt_g2',
    'goal4q_opt_g3',
    'goal4q_opt_g4',
    'goal4q_txt_b1',
    'goal4q_txt_b2',
    'goal4q_txt_b3',
    'goal4q_txt_b4',
    'goal4q_txt_c1',
    'goal4q_txt_c2',
    'goal4q_txt_c3',
    'goal4q_txt_c4',
    'goal4q_txt_d1',
    'goal4q_txt_d2',
    'goal4q_txt_d3',
    'goal4q_txt_d4',
    'goal4q_txt_e1',
    'goal4q_txt_e2',
    'goal4q_txt_e3',
    'goal4q_txt_e4',
    'goal4q_txt_f1',
    'goal4q_txt_f2',
    'goal4q_txt_f3',
    'goal4q_txt_f4',
    'goal4q_txt_h1',
    'goal4q_txt_h2',
    'goal4q_txt_h3',
    'goal4q_txt_h4',
  ];

  foreach ($fields_to_sanitize as $field) {
    $$field = sanitize_input($_POST[$field] ?? '');
  }

  // Initialize PDO inside try-catch
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (\Exception $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    dsip_msg("An error occurred while connecting to the database.");
    btn_return("index.php", "戻る");
    exit;
  }

  if ($cnt == 0) {   /* 新規書込み (INSERT) */
    try {
      $sql = "INSERT INTO tbl_goal_sheet_4q (
            `student_number`, `school_year`,
            `target_person`, `practical_field`, `professional_position`, `activity_issues`,
            `activity_method`, `aimed_results`, `your_goal`, `need_your_goal`,
            `study_target01`, `study_target02`, `study_target03`, `study_target04`,
            `study_target05`, `study_target06`, `study_conversion01`, `study_conversion02`,
            `study_conversion03`, `study_conversion04`, `study_conversion05`, `study_conversion06`,
            `qualification`, `qualification_other`, `education1`, `education2`, `education3`,
            `education4`, `experience`, `reason`,
            `goal4q_opt_a1`, `goal4q_opt_a2`, `goal4q_opt_a3`, `goal4q_opt_a4`,
            `goal4q_opt_b1`, `goal4q_opt_b2`, `goal4q_opt_b3`, `goal4q_opt_b4`,
            `goal4q_opt_c1`, `goal4q_opt_c2`, `goal4q_opt_c3`, `goal4q_opt_c4`,
            `goal4q_opt_d1`, `goal4q_opt_d2`, `goal4q_opt_d3`, `goal4q_opt_d4`,
            `goal4q_opt_e1`, `goal4q_opt_e2`, `goal4q_opt_e3`, `goal4q_opt_e4`,
            `goal4q_opt_g1`, `goal4q_opt_g2`, `goal4q_opt_g3`, `goal4q_opt_g4`,
            `goal4q_txt_b1`, `goal4q_txt_b2`, `goal4q_txt_b3`, `goal4q_txt_b4`,
            `goal4q_txt_c1`, `goal4q_txt_c2`, `goal4q_txt_c3`, `goal4q_txt_c4`,
            `goal4q_txt_d1`, `goal4q_txt_d2`, `goal4q_txt_d3`, `goal4q_txt_d4`,
            `goal4q_txt_e1`, `goal4q_txt_e2`, `goal4q_txt_e3`, `goal4q_txt_e4`,
            `goal4q_txt_f1`, `goal4q_txt_f2`, `goal4q_txt_f3`, `goal4q_txt_f4`,
            `goal4q_txt_h1`, `goal4q_txt_h2`, `goal4q_txt_h3`, `goal4q_txt_h4`
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?
        )";


      $stmt = $pdo->prepare($sql);

      // Assemble parameters
      $insert_params = [
        $student_number,
        $school_year,
        $target_person_4Q,
        $practical_field_4Q,
        $professional_position_4Q,
        $activity_issues_4Q,
        $activity_method_4Q,
        $aimed_results_4Q,
        $your_goal_4Q,
        $need_your_goal_4Q,
        $study_target01_4Q,
        $study_target02_4Q,
        $study_target03_4Q,
        $study_target04_4Q,
        $study_target05_4Q,
        $study_target06_4Q,
        $study_conversion01_4Q,
        $study_conversion02_4Q,
        $study_conversion03_4Q,
        $study_conversion04_4Q,
        $study_conversion05_4Q,
        $study_conversion06_4Q,
        $qualification,
        $qualification_other,
        $education1,
        $education2,
        $education3,
        $education4,
        $experience,
        $reason,
        $goal4q_opt_a1,
        $goal4q_opt_a2,
        $goal4q_opt_a3,
        $goal4q_opt_a4,
        $goal4q_opt_b1,
        $goal4q_opt_b2,
        $goal4q_opt_b3,
        $goal4q_opt_b4,
        $goal4q_opt_c1,
        $goal4q_opt_c2,
        $goal4q_opt_c3,
        $goal4q_opt_c4,
        $goal4q_opt_d1,
        $goal4q_opt_d2,
        $goal4q_opt_d3,
        $goal4q_opt_d4,
        $goal4q_opt_e1,
        $goal4q_opt_e2,
        $goal4q_opt_e3,
        $goal4q_opt_e4,
        $goal4q_opt_g1,
        $goal4q_opt_g2,
        $goal4q_opt_g3,
        $goal4q_opt_g4,
        $goal4q_txt_b1,
        $goal4q_txt_b2,
        $goal4q_txt_b3,
        $goal4q_txt_b4,
        $goal4q_txt_c1,
        $goal4q_txt_c2,
        $goal4q_txt_c3,
        $goal4q_txt_c4,
        $goal4q_txt_d1,
        $goal4q_txt_d2,
        $goal4q_txt_d3,
        $goal4q_txt_d4,
        $goal4q_txt_e1,
        $goal4q_txt_e2,
        $goal4q_txt_e3,
        $goal4q_txt_e4,
        $goal4q_txt_f1,
        $goal4q_txt_f2,
        $goal4q_txt_f3,
        $goal4q_txt_f4,
        $goal4q_txt_h1,
        $goal4q_txt_h2,
        $goal4q_txt_h3,
        $goal4q_txt_h4
      ];

      // Verify counts
      $placeholder_count = substr_count($sql, '?');
      $parameter_count = count($insert_params);

      // Debugging output (optional)
      //echo "Placeholders in INSERT: $placeholder_count<br>";
      //echo "Parameters in INSERT: $parameter_count<br>";

      if ($placeholder_count !== $parameter_count) {
        error_log("INSERT Error: Placeholders ($placeholder_count) do not match parameters ($parameter_count).");
        dsip_msg("An error occurred while processing your request.");
        btn_return("index.php", "戻る");
        exit;
      }

      // Ensure no parameters are arrays
      foreach ($insert_params as $index => $param) {
        if (is_array($param)) {
          error_log("INSERT Error: Parameter at index $index is an array.");
          dsip_msg("An error occurred while processing your request.");
          btn_return("index.php", "戻る");
          exit;
        }
      }

      // Execute the statement
      $stmt->execute($insert_params);
    } catch (\Exception $e) {
      error_log("INSERT Exception: " . $e->getMessage());
      dsip_msg("An error occurred while adding the record.");
      btn_return("index.php", "戻る");
      exit;
    }
    dsip_msg("追加しました");
    btn_return("select_sheet.php", "戻る");
    exit;
  } else {  /* 更新書込み (UPDATE) */
    try {
      $sql = "UPDATE tbl_goal_sheet_4q SET
                target_person=?, practical_field=?, professional_position=?, activity_issues=?,
                activity_method=?, aimed_results=?, your_goal=?, need_your_goal=?,
                study_target01=?, study_target02=?, study_target03=?, study_target04=?,
                study_target05=?, study_target06=?, study_conversion01=?,
                study_conversion02=?, study_conversion03=?, study_conversion04=?,
                study_conversion05=?, study_conversion06=?, qualification=?,
                qualification_other=?, education1=?, education2=?, education3=?,
                education4=?, experience=?, reason=?,

                goal4q_opt_a1=?, goal4q_opt_a2=?, goal4q_opt_a3=?, goal4q_opt_a4=?,
                goal4q_opt_b1=?, goal4q_opt_b2=?, goal4q_opt_b3=?, goal4q_opt_b4=?,
                goal4q_opt_c1=?, goal4q_opt_c2=?, goal4q_opt_c3=?, goal4q_opt_c4=?,
                goal4q_opt_d1=?, goal4q_opt_d2=?, goal4q_opt_d3=?, goal4q_opt_d4=?,
                goal4q_opt_e1=?, goal4q_opt_e2=?, goal4q_opt_e3=?, goal4q_opt_e4=?,
                goal4q_opt_g1=?, goal4q_opt_g2=?, goal4q_opt_g3=?, goal4q_opt_g4=?,

                goal4q_txt_b1=?, goal4q_txt_b2=?, goal4q_txt_b3=?, goal4q_txt_b4=?,
                goal4q_txt_c1=?, goal4q_txt_c2=?, goal4q_txt_c3=?, goal4q_txt_c4=?,
                goal4q_txt_d1=?, goal4q_txt_d2=?, goal4q_txt_d3=?, goal4q_txt_d4=?,
                goal4q_txt_e1=?, goal4q_txt_e2=?, goal4q_txt_e3=?, goal4q_txt_e4=?,
                goal4q_txt_f1=?, goal4q_txt_f2=?, goal4q_txt_f3=?, goal4q_txt_f4=?,
                goal4q_txt_h1=?, goal4q_txt_h2=?, goal4q_txt_h3=?, goal4q_txt_h4=?

                WHERE (student_number=?) AND (school_year=?)";

      $stmt = $pdo->prepare($sql);

      // Assemble parameters for UPDATE
      $update_params = [
        $target_person_4Q,
        $practical_field_4Q,
        $professional_position_4Q,
        $activity_issues_4Q,
        $activity_method_4Q,
        $aimed_results_4Q,
        $your_goal_4Q,
        $need_your_goal_4Q,
        $study_target01_4Q,
        $study_target02_4Q,
        $study_target03_4Q,
        $study_target04_4Q,
        $study_target05_4Q,
        $study_target06_4Q,
        $study_conversion01_4Q,
        $study_conversion02_4Q,
        $study_conversion03_4Q,
        $study_conversion04_4Q,
        $study_conversion05_4Q,
        $study_conversion06_4Q,
        $qualification,
        $qualification_other,
        $education1,
        $education2,
        $education3,
        $education4,
        $experience,
        $reason,
        $goal4q_opt_a1,
        $goal4q_opt_a2,
        $goal4q_opt_a3,
        $goal4q_opt_a4,
        $goal4q_opt_b1,
        $goal4q_opt_b2,
        $goal4q_opt_b3,
        $goal4q_opt_b4,
        $goal4q_opt_c1,
        $goal4q_opt_c2,
        $goal4q_opt_c3,
        $goal4q_opt_c4,
        $goal4q_opt_d1,
        $goal4q_opt_d2,
        $goal4q_opt_d3,
        $goal4q_opt_d4,
        $goal4q_opt_e1,
        $goal4q_opt_e2,
        $goal4q_opt_e3,
        $goal4q_opt_e4,
        $goal4q_opt_g1,
        $goal4q_opt_g2,
        $goal4q_opt_g3,
        $goal4q_opt_g4,
        $goal4q_txt_b1,
        $goal4q_txt_b2,
        $goal4q_txt_b3,
        $goal4q_txt_b4,
        $goal4q_txt_c1,
        $goal4q_txt_c2,
        $goal4q_txt_c3,
        $goal4q_txt_c4,
        $goal4q_txt_d1,
        $goal4q_txt_d2,
        $goal4q_txt_d3,
        $goal4q_txt_d4,
        $goal4q_txt_e1,
        $goal4q_txt_e2,
        $goal4q_txt_e3,
        $goal4q_txt_e4,
        $goal4q_txt_f1,
        $goal4q_txt_f2,
        $goal4q_txt_f3,
        $goal4q_txt_f4,
        $goal4q_txt_h1,
        $goal4q_txt_h2,
        $goal4q_txt_h3,
        $goal4q_txt_h4,
        $student_number,
        $school_year
      ];

      // Verify counts
      $placeholder_count = substr_count($sql, '?');
      $parameter_count = count($update_params);

      // Debugging output (optional)
      // echo "Placeholders in UPDATE: $placeholder_count<br>";
      // echo "Parameters in UPDATE: $parameter_count<br>";

      if ($placeholder_count !== $parameter_count) {
        error_log("UPDATE Error: Placeholders ($placeholder_count) do not match parameters ($parameter_count).");
        dsip_msg("An error occurred while processing your request.");
        btn_return("index.php", "戻る");
        exit;
      }

      // Ensure no parameters are arrays
      foreach ($update_params as $index => $param) {
        if (is_array($param)) {
          error_log("UPDATE Error: Parameter at index $index is an array.");
          dsip_msg("An error occurred while processing your request.");
          btn_return("index.php", "戻る");
          exit;
        }
      }

      // Execute the statement
      $stmt->execute($update_params);
    } catch (\Exception $e) {
      error_log("UPDATE Exception: " . $e->getMessage());
      dsip_msg("An error occurred while updating the record.");
      btn_return("index.php", "戻る");
      exit;
    }

    // Clean up
    $stmt = null;
    $pdo = null;

    dsip_msg("更新しました");
    btn_return("select_sheet.php", "戻る");
    exit;
  }

  // Clean up outside of if-else (optional redundancy)
  $stmt = null;
  $pdo = null;

  dsip_msg("更新しました");
  btn_return("select_sheet.php", "戻る");
  exit;
}








//////////////////////////////////////////////////
// これは不要
//////////////////////////////////////////////////
function tbl_goal_sheet_4q_READ($student_number, $school_year)
{





  $GLOBALS['今後目標1_1Q'] = "";
  $GLOBALS['今後目標2_1Q'] = "";
  $GLOBALS['今後目標3_1Q'] = "";
  $GLOBALS['今後目標4_1Q'] = "";
  $GLOBALS['今後目標5_1Q'] = "";

  try {
    // DBへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // SQL作成


    $sql_reflection = "SELECT 今後目標1_1Q,今後目標2_1Q,今後目標3_1Q,今後目標4_1Q,今後目標5_1Q
        FROM tbl_reflection_base
        WHERE student_number = :student_number AND school_year = :school_year";
    $stmt_reflection = $dbh->prepare($sql_reflection);
    $stmt_reflection->execute([
      ':student_number' => $student_number,
      ':school_year' => $school_year
    ]);


    if ($value = $stmt_reflection->fetch(PDO::FETCH_ASSOC)) {


      $GLOBALS['今後目標1_1Q'] =  $value['今後目標1_1Q'];
      $GLOBALS['今後目標2_1Q'] =  $value['今後目標2_1Q'];
      $GLOBALS['今後目標3_1Q'] =  $value['今後目標3_1Q'];
      $GLOBALS['今後目標4_1Q'] =  $value['今後目標4_1Q'];
      $GLOBALS['今後目標5_1Q'] =  $value['今後目標5_1Q'];

    }
  } catch (PDOException $e) {
    error_log("tbl_goal_sheet_4q_READ (tbl_reflection_base) Error: " . $e->getMessage());

    echo "An error occurred while fetching reflection data.";
    die();
  }
  // 接続を閉じる


  $GLOBALS['school_year'] = $school_year;
  $GLOBALS['target_person_4Q'] = "";
  $GLOBALS['practical_field_4Q'] = "";
  $GLOBALS['professional_position_4Q'] = "";
  $GLOBALS['activity_issues_4Q'] = "";
  $GLOBALS['activity_method_4Q'] = "";
  $GLOBALS['aimed_results_4Q'] = "";
  $GLOBALS['your_goal_4Q'] = "";
  $GLOBALS['need_your_goal_4Q'] = "";
  $GLOBALS['study_target01_4Q'] = "";
  $GLOBALS['study_target02_4Q'] = "";
  $GLOBALS['study_target03_4Q'] = "";
  $GLOBALS['study_target04_4Q'] = "";
  $GLOBALS['study_target05_4Q'] = "";
  $GLOBALS['study_target06_4Q'] = "";
  $GLOBALS['study_conversion01_4Q'] = "";
  $GLOBALS['study_conversion02_4Q'] = "";
  $GLOBALS['study_conversion03_4Q'] = "";
  $GLOBALS['study_conversion04_4Q'] = "";
  $GLOBALS['study_conversion05_4Q'] = "";
  $GLOBALS['study_conversion06_4Q'] = "";
  $GLOBALS['qualification'] = "";
  $GLOBALS['qualification_other'] = "";
  $GLOBALS['education1'] = "";
  $GLOBALS['education2'] = "";
  $GLOBALS['education3'] = "";
  $GLOBALS['education4'] = "";
  $GLOBALS['experience'] = "";
  $GLOBALS['reason'] = "";

  $GLOBALS['study_conversion01_4Q'] = $GLOBALS['今後目標1_1Q'];
  $GLOBALS['study_conversion02_4Q'] = $GLOBALS['今後目標2_1Q'];
  $GLOBALS['study_conversion03_4Q'] = $GLOBALS['今後目標3_1Q'];
  $GLOBALS['study_conversion04_4Q'] = $GLOBALS['今後目標4_1Q'];
  $GLOBALS['study_conversion05_4Q'] = $GLOBALS['今後目標5_1Q'];
  $GLOBALS['study_conversion06_4Q'] = "";

  $GLOBALS['comments_of_teacher'] = "";

  $goal4q_fields = [
    'goal4q_opt_a1',
    'goal4q_opt_a2',
    'goal4q_opt_a3',
    'goal4q_opt_a4',


    'goal4q_opt_b1',
    'goal4q_opt_b2',
    'goal4q_opt_b3',
    'goal4q_opt_b4',

    'goal4q_opt_c1',
    'goal4q_opt_c2',
    'goal4q_opt_c3',
    'goal4q_opt_c4',

    'goal4q_opt_d1',
    'goal4q_opt_d2',
    'goal4q_opt_d3',
    'goal4q_opt_d4',

    'goal4q_opt_e1',
    'goal4q_opt_e2',
    'goal4q_opt_e3',
    'goal4q_opt_e4',

    'goal4q_opt_g1',
    'goal4q_opt_g2',
    'goal4q_opt_g3',
    'goal4q_opt_g4',

    'goal4q_txt_b1',
    'goal4q_txt_b2',
    'goal4q_txt_b3',
    'goal4q_txt_b4',

    'goal4q_txt_c1',
    'goal4q_txt_c2',
    'goal4q_txt_c3',
    'goal4q_txt_c4',

    'goal4q_txt_d1',
    'goal4q_txt_d2',
    'goal4q_txt_d3',
    'goal4q_txt_d4',

    'goal4q_txt_e1',
    'goal4q_txt_e2',
    'goal4q_txt_e3',
    'goal4q_txt_e4',


    'goal4q_txt_f1',
    'goal4q_txt_f2',
    'goal4q_txt_f3',
    'goal4q_txt_f4',


    'goal4q_txt_h1',
    'goal4q_txt_h2',
    'goal4q_txt_h3',
    'goal4q_txt_h4'
  ];

  foreach ($goal4q_fields as $field) {
    $GLOBALS[$field] = "";
  }

  try {
    $sql_goal = "SELECT * FROM tbl_goal_sheet_4q
               WHERE student_number = :student_number AND school_year = :school_year";
    $stmt_goal = $dbh->prepare($sql_goal);
    $stmt_goal->execute([
      ':student_number' => $student_number,
      ':school_year' => $school_year
    ]);

    if ($value = $stmt_goal->fetch(PDO::FETCH_ASSOC)) {
      $GLOBALS['target_person_4Q'] = $value['target_person'];
      $GLOBALS['practical_field_4Q'] = $value['practical_field'];
      $GLOBALS['professional_position_4Q'] = $value['professional_position'];
      $GLOBALS['activity_issues_4Q'] = $value['activity_issues'];
      $GLOBALS['activity_method_4Q'] = $value['activity_method'];
      $GLOBALS['aimed_results_4Q'] = $value['aimed_results'];;
      $GLOBALS['your_goal_4Q'] = $value['your_goal'];
      $GLOBALS['need_your_goal_4Q'] = $value['need_your_goal'];
      $GLOBALS['study_target01_4Q'] = $value['study_target01'];
      $GLOBALS['study_target02_4Q'] = $value['study_target02'];
      $GLOBALS['study_target03_4Q'] = $value['study_target03'];
      $GLOBALS['study_target04_4Q'] = $value['study_target04'];
      $GLOBALS['study_target05_4Q'] = $value['study_target05'];
      $GLOBALS['study_target06_4Q'] = $value['study_target06'];


      $GLOBALS['study_conversion01_4Q'] = $value['study_conversion01'];
      $GLOBALS['study_conversion02_4Q'] = $value['study_conversion02'];
      $GLOBALS['study_conversion03_4Q'] = $value['study_conversion03'];
      $GLOBALS['study_conversion04_4Q'] = $value['study_conversion04'];
      $GLOBALS['study_conversion05_4Q'] = $value['study_conversion05'];
      $GLOBALS['study_conversion06_4Q'] = $value['study_conversion06'];


      $GLOBALS['qualification'] = $value['qualification'];
      $GLOBALS['qualification_other'] = $value['qualification_other'];
      $GLOBALS['education1'] = $value['education1'];
      $GLOBALS['education2'] = $value['education2'];
      $GLOBALS['education3'] = $value['education3'];
      $GLOBALS['education4'] = $value['education4'];
      $GLOBALS['experience'] = $value['experience'];
      $GLOBALS['reason'] = $value['reason'];
      $GLOBALS['comments_of_teacher'] = $value['comments_of_teacher'];

      foreach (['a1', 'a2', 'a3', 'a4', 'b1', 'b2', 'b3', 'b4', 'c1', 'c2', 'c3', 'c4', 'd1', 'd2', 'd3', 'd4', 'e1', 'e2', 'e3', 'e4', 'g1', 'g2', 'g3', 'g4'] as $opt) {
        $field = "goal4q_opt_" . $opt;
        if (isset($value[$field])) {
          $GLOBALS[$field] = $value[$field];
        }
      }

      foreach (['b1', 'b2', 'b3', 'b4', 'c1', 'c2', 'c3', 'c4', 'd1', 'd2', 'd3', 'd4', 'e1', 'e2', 'e3', 'e4', 'f1', 'f2', 'f3', 'f4', 'h1', 'h2', 'h3', 'h4'] as $txt) {
        $field = "goal4q_txt_" . $txt;
        if (isset($value[$field])) {
          $GLOBALS[$field] = $value[$field];
        }
      }
    }
  } catch (PDOException $e) {

    error_log("tbl_goal_sheet_4q_READ (tbl_goal_sheet_4q) Error: " . $e->getMessage());

    echo "An error occurred while fetching goal sheet data.";
    die();
  }
  // 接続を閉じる

  $res = null;

  $dbh = null;
}













//////////////////////////////////////////////////
//
//////////////////////////////////////////////////
function tbl_goal_sheet_4q_COMMENT_UP($student_number, $school_year)
{

  $GLOBALS['comments_of_teacher']  = $_POST['comments_of_teacher'];


  try {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE tbl_goal_sheet_4q SET comments_of_teacher=? WHERE (student_number=?) AND (school_year=?)";

    $stmt = $pdo->prepare($sql);


    $stmt->execute([$_POST['comments_of_teacher'], $student_number, $school_year]);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }

  $stmt = null;
  $pdo = null;


  dsip_msg("更新しました");
  btn_return("student_list.php", "戻る");

  exit;
}





function tbl_goal_sheet_1q_COMMENT_UP($student_number, $school_year)
{


  $GLOBALS['comments_of_teacher']  = $_POST['comments_of_teacher'];


  try {

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE tbl_goal_sheet_1q SET comments_of_teacher=? WHERE (student_number=?) AND (school_year=?)";

    $stmt = $pdo->prepare($sql);


    $stmt->execute([$_POST['comments_of_teacher'], $student_number, $school_year]);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }

  $stmt = null;
  $pdo = null;

  dsip_msg("更新しました");
  btn_return("student_list.php", "戻る");
  exit;
}



function tbl_goal_sheet_1q_update($student_number, $school_year)
{

  $WHERE = "student_number='" . $student_number . "' and school_year=" . $school_year;
  $cnt = RECODE_CHECK("tbl_goal_sheet_1q", $WHERE);


  $GLOBALS['target_person'] = $_POST['target_person'];
  $GLOBALS['practical_field'] = $_POST['practical_field'];
  $GLOBALS['professional_position'] = $_POST['professional_position'];
  $GLOBALS['activity_issues'] = $_POST['activity_issues'];
  $GLOBALS['activity_method'] = $_POST['activity_method'];
  $GLOBALS['aimed_results'] = $_POST['aimed_results'];
  $GLOBALS['your_goal'] = $_POST['your_goal'];

  $GLOBALS['need_your_goal'] = $_POST['need_your_goal'];


  $GLOBALS['study_target01'] = $_POST['study_target01'];
  $GLOBALS['study_target02'] = $_POST['study_target02'];
  $GLOBALS['study_target03'] = $_POST['study_target03'];
  $GLOBALS['study_target04'] = $_POST['study_target04'];
  $GLOBALS['study_target05'] = $_POST['study_target05'];
  $GLOBALS['study_target06'] = isset($_POST['study_target06']) ? $_POST['study_target06'] : "";


  $GLOBALS['study_conversion01'] = $_POST['study_conversion01'];
  $GLOBALS['study_conversion02'] = $_POST['study_conversion02'];
  $GLOBALS['study_conversion03'] = $_POST['study_conversion03'];
  $GLOBALS['study_conversion04'] = $_POST['study_conversion04'];
  $GLOBALS['study_conversion05'] = $_POST['study_conversion05'];
  $GLOBALS['study_conversion06'] = isset($_POST['study_conversion06']) ? $_POST['study_conversion06'] : "";


  $GLOBALS['sw_target01'] = $_POST['sw_target01'];
  $GLOBALS['sw_target02'] = $_POST['sw_target02'];
  $GLOBALS['sw_target03'] = $_POST['sw_target03'];
  $GLOBALS['sw_target04'] = $_POST['sw_target04'];
  $GLOBALS['sw_target05'] = $_POST['sw_target05'];
  $GLOBALS['sw_target06'] = $_POST['sw_target06'];
  $GLOBALS['sw_target07'] = $_POST['sw_target07'];
  $GLOBALS['sw_target08'] = $_POST['sw_target08'];
  $GLOBALS['sw_target09'] = $_POST['sw_target09'];
  $GLOBALS['sw_target10'] = $_POST['sw_target10'];
  $GLOBALS['sw_target11'] = $_POST['sw_target11'];
  $GLOBALS['sw_target12'] = $_POST['sw_target12'];

  $GLOBALS['sw_conversion01'] = $_POST['sw_conversion01'];
  $GLOBALS['sw_conversion02'] = $_POST['sw_conversion02'];
  $GLOBALS['sw_conversion03'] = $_POST['sw_conversion03'];
  $GLOBALS['sw_conversion04'] = $_POST['sw_conversion04'];
  $GLOBALS['sw_conversion05'] = $_POST['sw_conversion05'];
  $GLOBALS['sw_conversion06'] = $_POST['sw_conversion06'];
  $GLOBALS['sw_conversion07'] = $_POST['sw_conversion07'];
  $GLOBALS['sw_conversion08'] = $_POST['sw_conversion08'];
  $GLOBALS['sw_conversion09'] = $_POST['sw_conversion09'];
  $GLOBALS['sw_conversion10'] = $_POST['sw_conversion10'];
  $GLOBALS['sw_conversion11'] = $_POST['sw_conversion11'];
  $GLOBALS['sw_conversion12'] = $_POST['sw_conversion12'];

  $GLOBALS['intern_target01']  = $_POST['intern_target01'];
  $GLOBALS['intern_target02']  = $_POST['intern_target02'];
  $GLOBALS['intern_target03']  = $_POST['intern_target03'];
  $GLOBALS['intern_target04']  = $_POST['intern_target04'];
  $GLOBALS['intern_target05']  = $_POST['intern_target05'];
  $GLOBALS['intern_target06']  = $_POST['intern_target06'];
  $GLOBALS['intern_target07']  = $_POST['intern_target07'];
  $GLOBALS['intern_target08']  = $_POST['intern_target08'];
  $GLOBALS['intern_target09']  = $_POST['intern_target09'];
  $GLOBALS['intern_target10']  = $_POST['intern_target10'];
  $GLOBALS['intern_target11']  = $_POST['intern_target11'];
  $GLOBALS['intern_target12']  = $_POST['intern_target12'];

  $GLOBALS['intern_conversion01']  = $_POST['intern_conversion01'];
  $GLOBALS['intern_conversion02']  = $_POST['intern_conversion02'];
  $GLOBALS['intern_conversion03']  = $_POST['intern_conversion03'];
  $GLOBALS['intern_conversion04']  = $_POST['intern_conversion04'];
  $GLOBALS['intern_conversion05']  = $_POST['intern_conversion05'];
  $GLOBALS['intern_conversion06']  = $_POST['intern_conversion06'];
  $GLOBALS['intern_conversion07']  = $_POST['intern_conversion07'];
  $GLOBALS['intern_conversion08']  = $_POST['intern_conversion08'];
  $GLOBALS['intern_conversion09']  = $_POST['intern_conversion09'];
  $GLOBALS['intern_conversion10']  = $_POST['intern_conversion10'];
  $GLOBALS['intern_conversion11']  = $_POST['intern_conversion11'];
  $GLOBALS['intern_conversion12']  = $_POST['intern_conversion12'];

  $option_a1 = $_POST['option_a1'] ?? ' ';
  $option_a2 = $_POST['option_a2'] ?? ' ';
  $option_a3 = $_POST['option_a3'] ?? ' ';
  $option_a4 = $_POST['option_a4'] ?? ' ';
  $option_b1 = $_POST['option_b1'] ?? ' ';
  $option_b2 = $_POST['option_b2'] ?? ' ';
  $option_b3 = $_POST['option_b3'] ?? ' ';
  $option_b4 = $_POST['option_b4'] ?? ' ';
  $option_c1 = $_POST['option_c1'] ?? ' ';
  $option_c2 = $_POST['option_c2'] ?? ' ';
  $option_c3 = $_POST['option_c3'] ?? ' ';
  $option_c4 = $_POST['option_c4'] ?? ' ';
  $option_d1 = $_POST['option_d1'] ?? ' ';
  $option_d2 = $_POST['option_d2'] ?? ' ';
  $option_d3 = $_POST['option_d3'] ?? ' ';
  $option_d4 = $_POST['option_d4'] ?? ' ';
  $option_e1 = $_POST['option_e1'] ?? ' ';
  $option_e2 = $_POST['option_e2'] ?? ' ';
  $option_e3 = $_POST['option_e3'] ?? ' ';
  $option_e4 = $_POST['option_e4'] ?? ' ';
  $option_g1 = $_POST['option_g1'] ?? ' ';
  $option_g2 = $_POST['option_g2'] ?? ' ';
  $option_g3 = $_POST['option_g3'] ?? ' ';
  $option_g4 = $_POST['option_g4'] ?? ' ';

  $textarea_b1 = $_POST['textarea_b1'] ?? ' ';
  $textarea_b2 = $_POST['textarea_b2'] ?? ' ';
  $textarea_b3 = $_POST['textarea_b3'] ?? ' ';
  $textarea_b4 = $_POST['textarea_b4'] ?? ' ';
  $textarea_c1 = $_POST['textarea_c1'] ?? ' ';
  $textarea_c2 = $_POST['textarea_c2'] ?? ' ';
  $textarea_c3 = $_POST['textarea_c3'] ?? ' ';
  $textarea_c4 = $_POST['textarea_c4'] ?? ' ';
  $textarea_d1 = $_POST['textarea_d1'] ?? ' ';
  $textarea_d2 = $_POST['textarea_d2'] ?? ' ';
  $textarea_d3 = $_POST['textarea_d3'] ?? ' ';
  $textarea_d4 = $_POST['textarea_d4'] ?? ' ';
  $textarea_e1 = $_POST['textarea_e1'] ?? ' ';
  $textarea_e2 = $_POST['textarea_e2'] ?? ' ';
  $textarea_e3 = $_POST['textarea_e3'] ?? ' ';
  $textarea_e4 = $_POST['textarea_e4'] ?? ' ';
  $textarea_f1 = $_POST['textarea_f1'] ?? ' ';
  $textarea_f2 = $_POST['textarea_f2'] ?? ' ';
  $textarea_f3 = $_POST['textarea_f3'] ?? ' ';
  $textarea_f4 = $_POST['textarea_f4'] ?? ' ';
  $textarea_h1 = $_POST['textarea_h1'] ?? ' ';
  $textarea_h2 = $_POST['textarea_h2'] ?? ' ';
  $textarea_h3 = $_POST['textarea_h3'] ?? ' ';
  $textarea_h4 = $_POST['textarea_h4'] ?? ' ';



  if ($cnt == 0) {   /*新規書込み*/
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
      $sql = "insert into tbl_goal_sheet_1q(`student_number`, `school_year`, `target_person`, `practical_field`, `professional_position`, `activity_issues`, `activity_method`, `aimed_results`, `your_goal`, `need_your_goal`, `study_target01`, `study_target02`, `study_target03`, `study_target04`, `study_target05`, `study_target06`, `study_conversion01`, `study_conversion02`, `study_conversion03`, `study_conversion04`, `study_conversion05`, `study_conversion06`, `sw_conversion01`, `sw_conversion02`, `sw_conversion03`, `sw_conversion04`, `sw_conversion05`, `sw_conversion06`, `sw_conversion07`, `sw_conversion08`, `sw_conversion09`, `sw_conversion10`, `sw_conversion11`,`sw_conversion12`,`intern_target01`, `intern_target02`, `intern_target03`, `intern_target04`, `intern_target05`, `intern_target06`, `intern_target07`, `intern_target08`, `intern_target09`, `intern_target10`, `intern_target11`, `intern_target12`, `intern_conversion01`, `intern_conversion02`, `intern_conversion03`, `intern_conversion04`, `intern_conversion05`, `intern_conversion06`, `intern_conversion07`, `intern_conversion08`, `intern_conversion09`, `intern_conversion10`, `intern_conversion11`, `intern_conversion12`, `option_a1`, `option_a2`, `option_a3`, `option_a4`, `option_b1`, `option_b2`, `option_b3`, `option_b4`, `option_c1`, `option_c2`, `option_c3`, `option_c4`, `option_d1`, `option_d2`, `option_d3`, `option_d4`, `option_e1`, `option_e2`, `option_e3`, `option_e4`, `option_g1`, `option_g2`, `option_g3`, `option_g4`, `textarea_b1`, `textarea_b2`, `textarea_b3`, `textarea_b4`, `textarea_c1`, `textarea_c2`, `textarea_c3`, `textarea_c4`, `textarea_d1`, `textarea_d2`, `textarea_d3`, `textarea_d4`, `textarea_e1`, `textarea_e2`, `textarea_e3`, `textarea_e4`, `textarea_f1`, `textarea_f2`, `textarea_f3`, `textarea_f4`, `textarea_h1`, `textarea_h2`, `textarea_h3`, `textarea_h4`) value (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";



      $stmt = $pdo->prepare($sql);

      $stmt->execute([$student_number, $school_year, $_POST['target_person'], $_POST['practical_field'], $_POST['professional_position'], $_POST['activity_issues'], $_POST['activity_method'], $_POST['aimed_results'], $_POST['your_goal'], $_POST['need_your_goal'], $_POST['study_target01'], $_POST['study_target02'], $_POST['study_target03'], $_POST['study_target04'], $_POST['study_target05'], $_POST['study_target06'] = isset($_POST['study_target06']) ? $_POST['study_target06'] : "", $_POST['study_conversion01'], $_POST['study_conversion02'], $_POST['study_conversion03'], $_POST['study_conversion04'], $_POST['study_conversion05'], $_POST['study_conversion06'] ?? "", $_POST['sw_conversion01'], $_POST['sw_conversion02'], $_POST['sw_conversion03'], $_POST['sw_conversion04'], $_POST['sw_conversion05'], $_POST['sw_conversion06'], $_POST['sw_conversion07'], $_POST['sw_conversion08'], $_POST['sw_conversion09'], $_POST['sw_conversion10'], $_POST['sw_conversion11'], $_POST['sw_conversion12'], $_POST['intern_target01'], $_POST['intern_target02'], $_POST['intern_target03'], $_POST['intern_target04'], $_POST['intern_target05'], $_POST['intern_target06'], $_POST['intern_target07'], $_POST['intern_target08'], $_POST['intern_target09'], $_POST['intern_target10'], $_POST['intern_target11'], $_POST['intern_target12'], $_POST['intern_conversion01'], $_POST['intern_conversion02'], $_POST['intern_conversion03'], $_POST['intern_conversion04'], $_POST['intern_conversion05'], $_POST['intern_conversion06'], $_POST['intern_conversion07'], $_POST['intern_conversion08'], $_POST['intern_conversion09'], $_POST['intern_conversion10'], $_POST['intern_conversion11'], $_POST['intern_conversion12'], $option_a1, $option_a2, $option_a3, $option_a4, $option_b1, $option_b2, $option_b3, $option_b4, $option_c1, $option_c2, $option_c3, $option_c4, $option_d1, $option_d2, $option_d3, $option_d4, $option_e1, $option_e2, $option_e3, $option_e4, $option_g1, $option_g2, $option_g3, $option_g4, $textarea_b1, $textarea_b2, $textarea_b3, $textarea_b4, $textarea_c1, $textarea_c2, $textarea_c3, $textarea_c4, $textarea_d1, $textarea_d2, $textarea_d3, $textarea_d4, $textarea_e1, $textarea_e2, $textarea_e3, $textarea_e4, $textarea_f1, $textarea_f2, $textarea_f3, $textarea_f4, $textarea_h1, $textarea_h2, $textarea_h3, $textarea_h4]);
    } catch (\Exception $e) {



      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }

    $stmt = null;
    $pdo = null;

    dsip_msg("追加しました");
    btn_return("select_sheet.php", "戻る");

    exit;
  } else   /*更新書込み*/


    try {

      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "UPDATE tbl_goal_sheet_1q SET
       target_person=?,
       practical_field=?,
       professional_position=?,
       activity_issues=?,
       activity_method=?,
       aimed_results=?,
       your_goal=?,
       need_your_goal=?,

       study_target01=?,
       study_target02=?,
       study_target03=?,
       study_target04=?,
       study_target05=?,
       study_target06=?,

       study_conversion01=?,
       study_conversion02=?,
       study_conversion03=?,
       study_conversion04=?,
       study_conversion05=?,
       study_conversion06=?,

       sw_conversion01=?,
       sw_conversion02=?,
       sw_conversion03=?,
       sw_conversion04=?,
       sw_conversion05=?,
       sw_conversion06=?,
       sw_conversion07=?,
       sw_conversion08=?,
       sw_conversion09=?,
       sw_conversion10=?,
       sw_conversion11=?,
       sw_conversion12=?,

       intern_target01=?,
       intern_target02=?,
       intern_target03=?,
       intern_target04=?,
       intern_target05=?,
       intern_target06=?,
       intern_target07=?,
       intern_target08=?,
       intern_target09=?,
       intern_target10=?,
       intern_target11=?,
       intern_target12=?,

       intern_conversion01=?,
       intern_conversion02=?,
       intern_conversion03=?,
       intern_conversion04=?,
       intern_conversion05=?,
       intern_conversion06=?,
       intern_conversion07=?,
       intern_conversion08=?,
       intern_conversion09=?,
       intern_conversion10=?,
       intern_conversion11=?,
       intern_conversion12=?,

       option_a1 = ?,
       option_a2 = ?,
       option_a3 = ?,
       option_a4 = ?,

      option_b1=?,
      option_b2=?,
      option_b3=?,
      option_b4=?,

      option_c1=?,
      option_c2=?,
      option_c3=?,
      option_c4=?,

      option_d1=?,
      option_d2=?,
      option_d3=?,
      option_d4=?,

      option_e1=?,
      option_e2=?,
      option_e3=?,
      option_e4=?,

      option_g1=?,
      option_g2=?,
      option_g3=?,
      option_g4=?,
      textarea_b1=?,
      textarea_b2=?,
      textarea_b3=?,
      textarea_b4=?,

      textarea_c1=?,
      textarea_c2=?,
      textarea_c3=?,
      textarea_c4=?,

      textarea_d1=?,
      textarea_d2=?,
      textarea_d3=?,
      textarea_d4=?,

      textarea_e1=?,
      textarea_e2=?,
      textarea_e3=?,
      textarea_e4=?,

      textarea_f1=?,
      textarea_f2=?,
      textarea_f3=?,
      textarea_f4=?,

      textarea_h1=?,
      textarea_h2=?,
      textarea_h3=?,
      textarea_h4=?   WHERE (student_number=?) AND (school_year=?)";

      $stmt = $pdo->prepare($sql);



      $stmt->execute([$_POST['target_person'], $_POST['practical_field'], $_POST['professional_position'], $_POST['activity_issues'], $_POST['activity_method'], $_POST['aimed_results'], $_POST['your_goal'], $_POST['need_your_goal'], $_POST['study_target01'], $_POST['study_target02'], $_POST['study_target03'], $_POST['study_target04'], $_POST['study_target05'], $_POST['study_target06'] ?? "", $_POST['study_conversion01'], $_POST['study_conversion02'], $_POST['study_conversion03'], $_POST['study_conversion04'], $_POST['study_conversion05'], $_POST['study_conversion06'] = isset($_POST['study_conversion06']) ? $_POST['study_conversion06'] : "", $_POST['sw_conversion01'], $_POST['sw_conversion02'], $_POST['sw_conversion03'], $_POST['sw_conversion04'], $_POST['sw_conversion05'], $_POST['sw_conversion06'], $_POST['sw_conversion07'], $_POST['sw_conversion08'], $_POST['sw_conversion09'], $_POST['sw_conversion10'], $_POST['sw_conversion11'], $_POST['sw_conversion12'], $_POST['intern_target01'], $_POST['intern_target02'], $_POST['intern_target03'], $_POST['intern_target04'], $_POST['intern_target05'], $_POST['intern_target06'], $_POST['intern_target07'], $_POST['intern_target08'], $_POST['intern_target09'], $_POST['intern_target10'], $_POST['intern_target11'], $_POST['intern_target12'], $_POST['intern_conversion01'], $_POST['intern_conversion02'], $_POST['intern_conversion03'], $_POST['intern_conversion04'], $_POST['intern_conversion05'], $_POST['intern_conversion06'], $_POST['intern_conversion07'], $_POST['intern_conversion08'], $_POST['intern_conversion09'], $_POST['intern_conversion10'], $_POST['intern_conversion11'], $_POST['intern_conversion12'], $option_a1, $option_a2, $option_a3, $option_a4, $option_b1, $option_b2, $option_b3, $option_b4, $option_c1, $option_c2, $option_c3, $option_c4, $option_d1, $option_d2, $option_d3, $option_d4, $option_e1, $option_e2, $option_e3, $option_e4, $option_g1, $option_g2, $option_g3, $option_g4, $textarea_b1, $textarea_b2, $textarea_b3, $textarea_b4, $textarea_c1, $textarea_c2, $textarea_c3, $textarea_c4, $textarea_d1, $textarea_d2, $textarea_d3, $textarea_d4, $textarea_e1, $textarea_e2, $textarea_e3, $textarea_e4, $textarea_f1, $textarea_f2, $textarea_f3, $textarea_f4, $textarea_h1, $textarea_h2, $textarea_h3, $textarea_h4, $student_number, $school_year]);
    } catch (\Exception $e) {

      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }


  $stmt = null;
  $pdo = null;


  dsip_msg("更新しました");
  btn_return("select_sheet.php", "戻る");

  exit;
}


//////////////////////////////////////////////////
// ゴールシート１Qの値を読込む
//////////////////////////////////////////////////
function tbl_goal_sheet_1q_READ($student_number, $school_year)
{

  $GLOBALS['target_person'] = "";
  $GLOBALS['practical_field'] = "";
  $GLOBALS['professional_position'] = "";
  $GLOBALS['activity_issues'] = "";
  $GLOBALS['activity_method'] = "";
  $GLOBALS['aimed_results'] = "";
  $GLOBALS['your_goal'] = "";

  $GLOBALS['need_your_goal'] = "";
  $GLOBALS['study_target01'] = "";
  $GLOBALS['study_target02'] = "";
  $GLOBALS['study_target03'] = "";
  $GLOBALS['study_target04'] = "";
  $GLOBALS['study_target05'] = "";
  $GLOBALS['study_target06'] = "";


  $GLOBALS['study_conversion01'] = "";
  $GLOBALS['study_conversion02'] = "";
  $GLOBALS['study_conversion03'] = "";
  $GLOBALS['study_conversion04'] = "";
  $GLOBALS['study_conversion05'] = "";
  $GLOBALS['study_conversion06'] = "";
  $GLOBALS['sw_target01'] = "";
  $GLOBALS['sw_target02'] = "";
  $GLOBALS['sw_target03'] = "";
  $GLOBALS['sw_target04'] = "";
  $GLOBALS['sw_target05'] = "";
  $GLOBALS['sw_target06'] = "";
  $GLOBALS['sw_target07'] = "";
  $GLOBALS['sw_target08'] = "";
  $GLOBALS['sw_target09'] = "";
  $GLOBALS['sw_target10'] = "";
  $GLOBALS['sw_target11'] = "";
  $GLOBALS['sw_target12'] = "";
  $GLOBALS['sw_conversion01'] = "";
  $GLOBALS['sw_conversion02'] = "";
  $GLOBALS['sw_conversion03'] = "";
  $GLOBALS['sw_conversion04'] = "";
  $GLOBALS['sw_conversion05'] = "";
  $GLOBALS['sw_conversion06'] = "";
  $GLOBALS['sw_conversion07'] = "";
  $GLOBALS['sw_conversion08'] = "";
  $GLOBALS['sw_conversion09'] = "";
  $GLOBALS['sw_conversion10'] = "";
  $GLOBALS['sw_conversion11'] = "";
  $GLOBALS['sw_conversion12'] = "";
  $GLOBALS['intern_target01'] = "";
  $GLOBALS['intern_target02'] = "";
  $GLOBALS['intern_target03'] = "";
  $GLOBALS['intern_target04'] = "";
  $GLOBALS['intern_target05'] = "";
  $GLOBALS['intern_target06'] = "";
  $GLOBALS['intern_target07'] = "";
  $GLOBALS['intern_target08'] = "";
  $GLOBALS['intern_target09'] = "";
  $GLOBALS['intern_target10'] = "";
  $GLOBALS['intern_target11'] = "";
  $GLOBALS['intern_target12'] = "";
  $GLOBALS['intern_conversion01'] = "";
  $GLOBALS['intern_conversion02'] = "";
  $GLOBALS['intern_conversion03'] = "";
  $GLOBALS['intern_conversion04'] = "";
  $GLOBALS['intern_conversion05'] = "";
  $GLOBALS['intern_conversion06'] = "";
  $GLOBALS['intern_conversion07'] = "";
  $GLOBALS['intern_conversion08'] = "";
  $GLOBALS['intern_conversion09'] = "";
  $GLOBALS['intern_conversion10'] = "";
  $GLOBALS['intern_conversion11'] = "";
  $GLOBALS['intern_conversion12'] = "";
  $GLOBALS['comments_of_teacher'] = "";

  $GLOBALS['option_a1'] = "";
  $GLOBALS['option_a2'] = "";
  $GLOBALS['option_a3'] = "";
  $GLOBALS['option_a4'] = "";
  $GLOBALS['option_b1'] = "";
  $GLOBALS['option_b2'] = "";
  $GLOBALS['option_b3'] = "";
  $GLOBALS['option_b4'] = "";
  $GLOBALS['option_c1'] = "";
  $GLOBALS['option_c2'] = "";
  $GLOBALS['option_c3'] = "";
  $GLOBALS['option_c4'] = "";
  $GLOBALS['option_d1'] = "";
  $GLOBALS['option_d2'] = "";
  $GLOBALS['option_d3'] = "";
  $GLOBALS['option_d4'] = "";
  $GLOBALS['option_e1'] = "";
  $GLOBALS['option_e2'] = "";
  $GLOBALS['option_e3'] = "";
  $GLOBALS['option_e4'] = "";
  $GLOBALS['option_g1'] = "";
  $GLOBALS['option_g2'] = "";
  $GLOBALS['option_g3'] = "";
  $GLOBALS['option_g4'] = "";

  $GLOBALS['textarea_b1'] = "";
  $GLOBALS['textarea_b2'] = "";
  $GLOBALS['textarea_b3'] = "";
  $GLOBALS['textarea_b4'] = "";
  $GLOBALS['textarea_c1'] = "";
  $GLOBALS['textarea_c2'] = "";
  $GLOBALS['textarea_c3'] = "";
  $GLOBALS['textarea_c4'] = "";
  $GLOBALS['textarea_d1'] = "";
  $GLOBALS['textarea_d2'] = "";
  $GLOBALS['textarea_d3'] = "";
  $GLOBALS['textarea_d4'] = "";
  $GLOBALS['textarea_e1'] = "";
  $GLOBALS['textarea_e2'] = "";
  $GLOBALS['textarea_e3'] = "";
  $GLOBALS['textarea_e4'] = "";
  $GLOBALS['textarea_f1'] = "";
  $GLOBALS['textarea_f2'] = "";
  $GLOBALS['textarea_f3'] = "";
  $GLOBALS['textarea_f4'] = "";
  $GLOBALS['textarea_h1'] = "";
  $GLOBALS['textarea_h2'] = "";
  $GLOBALS['textarea_h3'] = "";
  $GLOBALS['textarea_h4'] = "";


  try {
    // DBへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "select * from tbl_goal_sheet_1q where student_number='" . $student_number . "' and school_year=" . $school_year;


    $cnt = 0;

    $res = $dbh->query($sql);

    foreach ($res as $value) {
      $cnt = $cnt + 1;
      $GLOBALS['target_person'] = $value['target_person'];
      $GLOBALS['practical_field'] = $value['practical_field'];
      $GLOBALS['professional_position'] = $value['professional_position'];
      $GLOBALS['activity_issues'] = $value['activity_issues'];
      $GLOBALS['activity_method'] = $value['activity_method'];
      $GLOBALS['aimed_results'] = $value['aimed_results'];
      $GLOBALS['your_goal'] = $value['your_goal'];
      $GLOBALS['need_your_goal'] = $value['need_your_goal'];
      $GLOBALS['comments_of_teacher'] = $value['comments_of_teacher'];



      $GLOBALS['study_conversion01'] = $value['study_conversion01'];
      $GLOBALS['study_conversion02'] = $value['study_conversion02'];
      $GLOBALS['study_conversion03'] = $value['study_conversion03'];
      $GLOBALS['study_conversion04'] = $value['study_conversion04'];
      $GLOBALS['study_conversion05'] = $value['study_conversion05'];
      $GLOBALS['study_conversion06'] = $value['study_conversion06'];


      $GLOBALS['sw_conversion01'] = $value['sw_conversion01'];
      $GLOBALS['sw_conversion02'] = $value['sw_conversion02'];
      $GLOBALS['sw_conversion03'] = $value['sw_conversion03'];
      $GLOBALS['sw_conversion04'] = $value['sw_conversion04'];
      $GLOBALS['sw_conversion05'] = $value['sw_conversion05'];
      $GLOBALS['sw_conversion06'] = $value['sw_conversion06'];
      $GLOBALS['sw_conversion07'] = $value['sw_conversion07'];
      $GLOBALS['sw_conversion08'] = $value['sw_conversion08'];
      $GLOBALS['sw_conversion09'] = $value['sw_conversion09'];
      $GLOBALS['sw_conversion10'] = $value['sw_conversion10'];
      $GLOBALS['sw_conversion11'] = $value['sw_conversion11'];
      $GLOBALS['sw_conversion12'] = $value['sw_conversion12'];





      $GLOBALS['intern_target01'] = $value['intern_target01'];
      $GLOBALS['intern_target02'] = $value['intern_target02'];
      $GLOBALS['intern_target03'] = $value['intern_target03'];
      $GLOBALS['intern_target04'] = $value['intern_target04'];
      $GLOBALS['intern_target05'] = $value['intern_target05'];
      $GLOBALS['intern_target06'] = $value['intern_target06'];
      $GLOBALS['intern_target07'] = $value['intern_target07'];
      $GLOBALS['intern_target08'] = $value['intern_target08'];
      $GLOBALS['intern_target09'] = $value['intern_target09'];
      $GLOBALS['intern_target10'] = $value['intern_target10'];
      $GLOBALS['intern_target11'] = $value['intern_target11'];
      $GLOBALS['intern_target12'] = $value['intern_target12'];


      $GLOBALS['intern_conversion01'] = $value['intern_conversion01'];
      $GLOBALS['intern_conversion02'] = $value['intern_conversion02'];
      $GLOBALS['intern_conversion03'] = $value['intern_conversion03'];
      $GLOBALS['intern_conversion04'] = $value['intern_conversion04'];
      $GLOBALS['intern_conversion05'] = $value['intern_conversion05'];
      $GLOBALS['intern_conversion06'] = $value['intern_conversion06'];
      $GLOBALS['intern_conversion07'] = $value['intern_conversion07'];
      $GLOBALS['intern_conversion08'] = $value['intern_conversion08'];
      $GLOBALS['intern_conversion09'] = $value['intern_conversion09'];
      $GLOBALS['intern_conversion10'] = $value['intern_conversion10'];
      $GLOBALS['intern_conversion11'] = $value['intern_conversion11'];
      $GLOBALS['intern_conversion12'] = $value['intern_conversion12'];

      $GLOBALS['option_a1'] = $value['option_a1'];
      $GLOBALS['option_a2'] = $value['option_a2'];
      $GLOBALS['option_a3'] = $value['option_a3'];
      $GLOBALS['option_a4'] = $value['option_a4'];
      $GLOBALS['option_b1'] = $value['option_b1'];
      $GLOBALS['option_b2'] = $value['option_b2'];
      $GLOBALS['option_b3'] = $value['option_b3'];
      $GLOBALS['option_b4'] = $value['option_b4'];
      $GLOBALS['option_c1'] = $value['option_c1'];
      $GLOBALS['option_c2'] = $value['option_c2'];
      $GLOBALS['option_c3'] = $value['option_c3'];
      $GLOBALS['option_c4'] = $value['option_c4'];
      $GLOBALS['option_d1'] = $value['option_d1'];
      $GLOBALS['option_d2'] = $value['option_d2'];
      $GLOBALS['option_d3'] = $value['option_d3'];
      $GLOBALS['option_d4'] = $value['option_d4'];
      $GLOBALS['option_e1'] = $value['option_e1'];
      $GLOBALS['option_e2'] = $value['option_e2'];
      $GLOBALS['option_e3'] = $value['option_e3'];
      $GLOBALS['option_e4'] = $value['option_e4'];
      $GLOBALS['option_g1'] = $value['option_g1'];
      $GLOBALS['option_g2'] = $value['option_g2'];
      $GLOBALS['option_g3'] = $value['option_g3'];
      $GLOBALS['option_g4'] = $value['option_g4'];

      $GLOBALS['textarea_b1'] = $value['textarea_b1'];
      $GLOBALS['textarea_b2'] = $value['textarea_b2'];
      $GLOBALS['textarea_b3'] = $value['textarea_b3'];
      $GLOBALS['textarea_b4'] = $value['textarea_b4'];
      $GLOBALS['textarea_c1'] = $value['textarea_c1'];
      $GLOBALS['textarea_c2'] = $value['textarea_c2'];
      $GLOBALS['textarea_c3'] = $value['textarea_c3'];
      $GLOBALS['textarea_c4'] = $value['textarea_c4'];
      $GLOBALS['textarea_d1'] = $value['textarea_d1'];
      $GLOBALS['textarea_d2'] = $value['textarea_d2'];
      $GLOBALS['textarea_d3'] = $value['textarea_d3'];
      $GLOBALS['textarea_d4'] = $value['textarea_d4'];
      $GLOBALS['textarea_e1'] = $value['textarea_e1'];
      $GLOBALS['textarea_e2'] = $value['textarea_e2'];
      $GLOBALS['textarea_e3'] = $value['textarea_e3'];
      $GLOBALS['textarea_e4'] = $value['textarea_e4'];
      $GLOBALS['textarea_f1'] = $value['textarea_f1'];
      $GLOBALS['textarea_f2'] = $value['textarea_f2'];
      $GLOBALS['textarea_f3'] = $value['textarea_f3'];
      $GLOBALS['textarea_f4'] = $value['textarea_f4'];
      $GLOBALS['textarea_h1'] = $value['textarea_h1'];
      $GLOBALS['textarea_h2'] = $value['textarea_h2'];
      $GLOBALS['textarea_h3'] = $value['textarea_h3'];
      $GLOBALS['textarea_h4'] = $value['textarea_h4'];
    }

    $stmt = null;
    $dbh = null;
    return $cnt;
  } catch (PDOException $e) {

    echo $e->getMessage();
    die();
  }
  // 接続を閉じる



  $res = null;
  $dbh = null;
  return $cnt;
}


//////////////////////////////////////////////////
//
//////////////////////////////////////////////////
function tbl_profile_detail_READ($student_number, $school_year)
{

  $GLOBALS['school_year'] = $school_year;
  $GLOBALS['advanced_course'] = "";
  $GLOBALS['roommate_club_activities']  = "";
  $GLOBALS['other_activities'] = "";
  $GLOBALS['affiliation_circle_campus']  = "";
  $GLOBALS['affiliation_circle_off_campus']  = "";


  $GLOBALS['training_overview']  = "";


  $GLOBALS['training_destination_1']  = "";
  $GLOBALS['training_destination_2']  = "";
  $GLOBALS['advanced_training_destination']  = "";
  $GLOBALS['internship_content']  = "";
  $GLOBALS['qualification']  = "";

  $GLOBALS['sw_hope']  = "";
  $GLOBALS['psw_hope']  = "";
  $GLOBALS['adv_hope']  = "";

  $GLOBALS['things_to_consider']  = "";
  $GLOBALS['comments_of_teacher']  = "";
  $GLOBALS['future_use1']  = "";
  $GLOBALS['future_use2'] = "";
  $GLOBALS['future_use3'] = "";
  $GLOBALS['future_use4'] = "";
  try {
    // DBへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    // SQL作成


    $sql = "select `school_year`,`advanced_course`,`roommate_club_activities`,`other_activities`,`affiliation_circle_campus`,`affiliation_circle_off_campus`,`training_overview`,`training_destination_1`,`training_destination_2`,`advanced_training_destination`,`internship_content`,`qualification`,`sw_hope`,`psw_hope`,`adv_hope`,`things_to_consider`,`comments_of_teacher`,`future_use1`,`future_use2`,`future_use3`,`future_use4` from tbl_profile_detail where student_number='" . $student_number . "' and school_year=" . $school_year;
    $cnt = 0;

    $res = $dbh->query($sql);

    foreach ($res as $value) {
      $cnt = $cnt + 1;

      $GLOBALS['school_year'] = $value['school_year'];
      $GLOBALS['advanced_course'] = $value['advanced_course'];
      $GLOBALS['roommate_club_activities'] = $value['roommate_club_activities'];
      $GLOBALS['other_activities'] = $value['other_activities'];
      $GLOBALS['affiliation_circle_campus'] = $value['affiliation_circle_campus'];
      $GLOBALS['affiliation_circle_off_campus'] = $value['affiliation_circle_off_campus'];



      $GLOBALS['training_overview'] = $value['training_overview'];
      $GLOBALS['training_destination_1'] = $value['training_destination_1'];
      $GLOBALS['training_destination_2'] = $value['training_destination_2'];
      $GLOBALS['advanced_training_destination'] = $value['advanced_training_destination'];
      $GLOBALS['internship_content'] = $value['internship_content'];


      $GLOBALS['qualification'] = $value['qualification'];
      $GLOBALS['sw_hope'] = $value['sw_hope'];
      $GLOBALS['psw_hope'] = $value['psw_hope'];
      $GLOBALS['adv_hope'] = $value['adv_hope'];
      $GLOBALS['things_to_consider'] = $value['things_to_consider'];
      $GLOBALS['comments_of_teacher'] = $value['comments_of_teacher'];
      $GLOBALS['future_use1'] = $value['future_use1'];
      $GLOBALS['future_use2'] = $value['future_use2'];
      $GLOBALS['future_use3'] = $value['future_use3'];
      $GLOBALS['future_use4'] = $value['future_use4'];
      $GLOBALS['qualification'] = trim($GLOBALS['qualification']);
      $GLOBALS['things_to_consider'] = trim($GLOBALS['things_to_consider']);
    }
  } catch (PDOException $e) {

    echo $e->getMessage();
    die();
  }
  // 接続を閉じる

  $res = null;
  $dbh = null;
  return $cnt;
}






function tbl_status_check($STUDENT_NUMBER, $select_nen)
{

  $cnt = 0;
  // DBへ接続
  $dbh = new PDO(DSN, DB_USER, DB_PASS);

  ////////////////////////////////
  // プロフィールシート
  ////////////////////////////////


  $GLOBALS['sta_prof'] = "0";
  $GLOBALS['sta_go1Q'] = "0";
  $GLOBALS['sta_go4Q'] = "0";
  $GLOBALS['sta_rbas'] = "0";

  $GLOBALS['sta_rsw1'] = "0";
  $GLOBALS['sta_rsw2'] = "0";
  $GLOBALS['sta_rintern'] = "0";
  $GLOBALS['sta_rmental1'] = "0";
  $GLOBALS['sta_rmental2'] = "0";
  $GLOBALS['sta_radv'] = "0";


  $GLOBALS['sta_ssw1'] = "0";
  $GLOBALS['sta_ssw2'] = "0";
  $GLOBALS['sta_smental1'] = "0";
  $GLOBALS['sta_smental2'] = "0";
  $GLOBALS['sta_sadv'] = "0";


  $GLOBALS['sta_jsw1'] = "0";
  $GLOBALS['sta_jsw2'] = "0";
  $GLOBALS['sta_jmental1'] = "0";
  $GLOBALS['sta_jmental2'] = "0";
  $GLOBALS['sta_jadv'] = "0";

  $kana = 'たにひさと';
  try {
    // SQL修正：安全なプレースホルダ使用
    $sql = "SELECT * FROM tbl_profile WHERE student_number = :student_number";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':student_number', $STUDENT_NUMBER, PDO::PARAM_STR);
    $stmt->execute();



    foreach ($stmt as $value) {



      switch ($select_nen) {
        case "1":




          if (isset($value['profile_1']) and ($value['profile_1'] < 5)) {
            $GLOBALS['sta_prof'] =  intval($value['profile_1']);
          }
          if (isset($value['goal1Q_1']) and ($value['goal1Q_1'] < 5)) {
            $GLOBALS['sta_go1Q'] =  intval($value['goal1Q_1']);
          }
          if (isset($value['goal4Q_1']) and ($value['goal4Q_1'] < 5)) {
            $GLOBALS['sta_go4Q'] =  intval($value['goal4Q_1']);
          }
          if (isset($value['ref_base_1']) and ($value['ref_base_1'] < 5)) {
            $GLOBALS['sta_rbas'] =  intval($value['ref_base_1']);
          }



          break;
        case "2":
          if (isset($value['profile_2']) and ($value['profile_2'] < 5)) {
            $GLOBALS['sta_prof'] =  intval($value['profile_2']);
          }
          if (isset($value['goal1Q_2']) and ($value['goal1Q_2'] < 5)) {
            $GLOBALS['sta_go1Q'] =  intval($value['goal1Q_2']);
          }
          if (isset($value['goal4Q_2']) and ($value['goal4Q_2'] < 5)) {
            $GLOBALS['sta_go4Q'] =  intval($value['goal4Q_2']);
          }
          if (isset($value['ref_base_2']) and ($value['ref_base_2'] < 5)) {
            $GLOBALS['sta_rbas'] =  intval($value['ref_base_2']);
          }



          break;
        case "3":
          if (isset($value['profile_3']) and ($value['profile_3'] < 5)) {
            $GLOBALS['sta_prof'] =  intval($value['profile_3']);
          }
          if (isset($value['goal1Q_3']) and ($value['goal1Q_3'] < 5)) {
            $GLOBALS['sta_go1Q'] =  intval($value['goal1Q_3']);
          }
          if (isset($value['goal4Q_3']) and ($value['goal4Q_3'] < 5)) {
            $GLOBALS['sta_go4Q'] =  intval($value['goal4Q_3']);
          }
          if (isset($value['ref_base_3']) and ($value['ref_base_3'] < 5)) {
            $GLOBALS['sta_rbas'] =  intval($value['ref_base_3']);
          }

          break;
        case "4":
          if (isset($value['profile_4']) and ($value['profile_4'] < 5)) {
            $GLOBALS['sta_prof'] =  intval($value['profile_4']);
          }
          if (isset($value['goal1Q_4']) and ($value['goal1Q_4'] < 5)) {
            $GLOBALS['sta_go1Q'] =  intval($value['goal1Q_4']);
          }
          if (isset($value['goal4Q_4']) and ($value['goal4Q_4'] < 5)) {
            $GLOBALS['sta_go4Q'] =  intval($value['goal4Q_4']);
          }
          if (isset($value['ref_base_4']) and ($value['ref_base_4'] < 5)) {
            $GLOBALS['sta_rbas'] =  intval($value['ref_base_4']);
          }

          break;
      }






      if (isset($value['ref_sw1']) and ($value['ref_sw1'] < 5)) {
        $GLOBALS['sta_rsw1'] =  intval($value['ref_sw1']);
      }
      if (isset($value['ref_sw2']) and ($value['ref_sw2'] < 5)) {
        $GLOBALS['sta_rsw2'] =  intval($value['ref_sw2']);
      }
      if (isset($value['ref_intern']) and ($value['ref_intern'] < 5)) {
        $GLOBALS['sta_rintern'] =  intval($value['ref_intern']);
      }
      if (isset($value['ref_mental1']) and ($value['ref_mental1'] < 5)) {
        $GLOBALS['sta_rmental1'] =  intval($value['ref_mental1']);
      }
      if (isset($value['ref_advance']) and ($value['ref_advance'] < 5)) {
        $GLOBALS['sta_radv'] =  intval($value['ref_advance']);
      }


      //ここからは実習計画表の作成状態
      if (isset($value['sch_sw1']) and ($value['sch_sw1'] < 5)) {
        $GLOBALS['sta_ssw1'] =  intval($value['sch_sw1']);
      }
      if (isset($value['sch_sw2']) and ($value['sch_sw2'] < 5)) {
        $GLOBALS['sta_ssw2'] =  intval($value['sch_sw2']);
      }
      if (isset($value['sch_mental1']) and ($value['sch_mental1'] < 5)) {
        $GLOBALS['sta_smental1'] =  intval($value['sch_mental1']);
      }
      if (isset($value['sch_mental2']) and ($value['sch_mental2'] < 5)) {
        $GLOBALS['sta_smental2'] =  intval($value['sch_mental2']);
      }
      if (isset($value['sch_advance']) and ($value['sch_advance'] < 5)) {
        $GLOBALS['sta_sadv'] =  intval($value['sch_advance']);
      }
      //ここからは自己評価表の作成状態
      if (isset($value['self_sw1']) and ($value['self_sw1'] < 5)) {
        $GLOBALS['sta_jsw1'] =  intval($value['self_sw1']);
      }
      if (isset($value['self_sw2']) and ($value['self_sw2'] < 5)) {
        $GLOBALS['sta_jsw2'] =  intval($value['self_sw2']);
      }

      if (isset($value['self_mental1']) and ($value['self_mental1'] < 5)) {
        $GLOBALS['sta_jmental1'] =  intval($value['self_mental1']);
      }
      if (isset($value['self_mental2']) and ($value['self_mental2'] < 5)) {
        $GLOBALS['sta_jmental2'] =  intval($value['self_mental2']);
      }

      if (isset($value['self_advance']) and ($value['self_advance'] < 5)) {
        $GLOBALS['sta_jadv'] =  intval($value['self_advance']);
      }
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
    die();
  }




  // 接続を閉じる
  $res = null;
  $dbh = null;



  return $cnt;
}


////////////////////////////////////////////
//　プロフィール・個人情報書込み
////////////////////////////////////////////
function  tbl_profile_UPDATE($student_number)
{


  $password = "";


  //パスワードが入力されていたら、暗号化する
  if (isset($_POST['set_pass']) and $_POST['set_pass'] <> "") {

    if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['set_pass'])) {
      $password = password_hash($_POST['set_pass'], PASSWORD_DEFAULT);
    } else {


      dsip_msg("パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。記号は使えません");

      btn_return("account.php", "戻る");
      exit;
    }
  } else {
    //  dsip_msg("パスワードを入力してください。パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。記号は使えません");
    //  btn_return("index.php", "戻る");
    //  exit;
  }



  //レコードの有無を確認;
  $WHERE = "student_number='" . $student_number . "'";
  $cnt = RECODE_CHECK("tbl_profile", $WHERE);


  if ($cnt == 0) {

    if ($password == "") {
      dsip_msg("パスワードを入力してください。パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。記号は使えません");
      btn_return("index.php", "戻る");
      exit;
    }

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    //////////////////////////////////////////////////////
    //一括で仮登録を行うのでこの処理はつかわない
    //////////////////////////////////////////////////////

    try {


      $name = $GLOBALS['name'];
      $kana = $GLOBALS['kana'];
      $adresse = $GLOBALS['adresse'];
      $tel = $GLOBALS['tel'];
      $email = $GLOBALS['email'];

      $nearest_station = $_POST['nearest_station'];
      $transportation = $_POST['transportation'];
      $travel_time = $_POST['travel_time'];
      $hometown = $_POST['hometown'];
      $professor1 = $_POST['professor1'];
      $professor2 = $_POST['professor2'];
      $professor3 = $_POST['professor3'];
      $professor4 = $_POST['professor4'];





      $stmt = $pdo->prepare("insert into tbl_profile(`student_number`,`name`,`kana`,`adresse`,`hometown` ,`tel`,`email`,`password` ,`nearest_station`,`transportation`,`travel_time`,`professor1`,`professor2`,`professor3`,`professor4`) value(?, ?, ?, ?, ?, ?, ?,?, ?, ? )");

      $stmt->execute($_POST['student_number'], $_POST['name'], $_POST['kana'], $_POST['adresse'], $_POST['hometown'], $_POST['tel'], $_POST['email'], $password, $_POST['$nearest_station'], $_POST['transportation'], $_POST['travel_time'], $_POST['professor1'], $_POST['professor2'], $_POST['professor3'], $_POST['professor4']);
    } catch (\Exception $e) {
      dsip_msg($e->getMessage());

      btn_return("index.php", "戻る");
      exit;
    }

    $pdo = null;
    $stmt = null;

    dsip_msg("追加しました");
    btn_return("index.php", "戻る");
  } else


    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


      $name = $_POST['name'];
      $kana = $_POST['kana'];
      $adresse = $_POST['adresse'];
      $nearest_station = $_POST["nearest_station"];
      $transportation = $_POST["transportation"];
      $travel_time = $_POST["travel_time"];
      $hometown = $_POST["hometown"];
      $tel = $_POST['tel'];
      $email = $_POST['email'];

      $professor1 = $_POST['professor1'];
      $professor2 = $_POST['professor2'];
      $professor3 = $_POST['professor3'];
      $professor4 = $_POST['professor4'];


      ///////////////////////////////////////////////////////////
      //パスワードが入力されてなければ、パスワードの更新はしない
      ///////////////////////////////////////////////////////////
      if ($password == "") {
        $sql = "UPDATE tbl_profile SET name=?,kana=?,adresse=?,hometown=?,tel=?,email=?,nearest_station=?,transportation=?,travel_time=?,professor1=?,professor2=?,professor3=?,professor4=? WHERE student_number =?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $kana, $adresse, $hometown, $tel, $email, $nearest_station, $transportation, $travel_time, $professor1, $professor2, $professor3, $professor4, $student_number]);
      } else {
        $sql = "UPDATE tbl_profile SET name=?,kana=?,adresse=?,hometown=?,tel=?,email=?,password=?,nearest_station=?,transportation=?,travel_time=?,professor1=?,professor2=?,professor3=?,professor4=? WHERE student_number =?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $kana, $adresse, $hometown, $tel, $email, $password, $nearest_station, $transportation, $travel_time, $professor1, $professor2, $professor3, $professor4, $student_number]);
      }
    } catch (\Exception $e) {



      dsip_msg($e->getMessage() . PHP_EOL);
      btn_return("index.php", "戻る");
      exit;
    }


  $_SESSION['EMAIL'] = $email;
  $_SESSION['NAME'] = $name;
  $_SESSION['KANA'] = $kana;

  $pdo = null;
  $stmt = null;






  dsip_msg("更新しました");


  btn_return("index.php", "戻る");


  exit;
}





////////////////////////////////////////////
//　現在の年次を保存しておく
////////////////////////////////////////////
function  tbl_profile_nen_set($student_number, $sel_nen)
{

  //レコードの有無を確認;

  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE tbl_profile SET now_nen=? WHERE student_number =?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$sel_nen, $student_number]);
  } catch (\Exception $e) {

    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }
  $pdo = null;
  $stmt = null;
  $_SESSION['SELECT_NEN'] = $sel_nen;
}


//////////////////////////////////////////////////
// プロトコール個人情報読込
//////////////////////////////////////////////////
function tbl_profile_READ($student_number)
{
  try {
    // DBへ接続

    $dbh = new PDO(DSN, DB_USER, DB_PASS);


    // SQL作成

    $sql = "select * from tbl_profile where student_number='" . $student_number . "'";


    $cnt = 0;


    $res = $dbh->query($sql);
    foreach ($res as $value) {
      $cnt = $cnt + 1;
      $GLOBALS['ID'] = $value['ID'];
      $GLOBALS['name'] =  $value['name'];
      $GLOBALS['kana'] =  $value['kana'];

      $GLOBALS['adresse'] = $value['adresse'];
      $GLOBALS['hometown'] = $value['hometown'];
      $GLOBALS['nearest_station'] = $value['nearest_station'];
      $GLOBALS['transportation'] = $value['transportation'];
      $GLOBALS['travel_time'] = $value['travel_time'];
      $GLOBALS['tel'] = $value['tel'];
      $GLOBALS['email'] = $value['email'];
      $GLOBALS['password'] = $value['password'];
      $GLOBALS['now_nen'] = $value['now_nen'];

      $GLOBALS['professor1'] = $value['professor1'];
      $GLOBALS['professor2'] = $value['professor2'];
      $GLOBALS['professor3'] = $value['professor3'];
      $GLOBALS['professor4'] = $value['professor4'];


      //   $_SESSION['SELECT_NEN'] = $value['now_nen'];
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
    die();
  }

  // 接続を閉じる
  $res = null;
  $dbh = null;

  return $cnt;
}




//////////////////////////////////////////////////
//　年度の選択
//////////////////////////////////////////////////
function select_nen()
{

  if (!isset($_SESSION['SELECT_NEN'])) {
    $_SESSION['SELECT_NEN'] = 1;
  }

  $n = $_SESSION['SELECT_NEN'];
  $cd1 = "";
  $cd2 = "";
  $cd3 = "";
  $cd4 = "";

  if ($n == "1") {
    $cd1 = "checked";
  } elseif (($n == "2")) {
    $cd2 = "checked";
  } elseif (($n == "3")) {
    $cd3 = "checked";
  } elseif (($n == "4")) {
    $cd4 = "checked";
  }

?>


  <div class="row">
    <div class="col-12">
      <div class="btn-group mb-4" role="group" aria-label="Basic radio toggle button group">
        <label class="input-group-text" for="btnradio1">入力する学年を選択</label>
        <input type="radio" class="btn-check" name="select_nen" id="btnradio1" value="1" autocomplete="off" <?php echo $cd1; ?>>
        <label class="btn btn-outline-primary" for="btnradio1">1学年</label>
        <input type="radio" class="btn-check" name="select_nen" id="btnradio2" value="2" autocomplete="off" <?php echo $cd2; ?>>
        <label class="btn btn-outline-primary" for="btnradio2">2学年</label>
        <input type="radio" class="btn-check" name="select_nen" id="btnradio3" value="3" autocomplete="off" <?php echo $cd3; ?>>
        <label class="btn btn-outline-primary" for="btnradio3">3学年</label>
        <input type="radio" class="btn-check" name="select_nen" id="btnradio4" value="4" autocomplete="off" <?php echo $cd4; ?>>
        <label class="btn btn-outline-primary" for="btnradio4">4学年</label>
      </div>


    </div>
  </div>


<?php
}



//////////////////////////////////////////////////
//　デバッグツール
//////////////////////////////////////////////////
function edit_br($text_dat)
{

  /*  $str = str_replace("<br>", "改行コード", $text_dat,10);*/
  return $text_dat . "******";
}



//////////////////////////////////////////////////
//　汎用ボタン
//////////////////////////////////////////////////

function btn_return($ACTION, $title)
{
?>
  <div class="text-center mt-5" style="height:100px">
    <button type='button'
      onclick="location.href='<?php echo $ACTION; ?>'"
      class='btn btn-secondary w-200px'>
      <?php echo $title; ?>
    </button>
  </div>
<?php
}

//////////////////////////////////////////////////
//　汎用ボタン
//////////////////////////////////////////////////
function btn_history_back()
{
?>
  <div class="text-center mt-5" style="height:100px">
    <button type="button" class='btn btn-secondary w-200px' onclick="history.back()">戻る</button>
  </div>
<?php
}


function btn_return2($ACTION, $title, $paraname, $paradata, $table_title)
{

?>
  <div class="text-center mt-5" style="height:100px">
    <form action='<?php echo $ACTION; ?>' method='post' onSubmit='return check()'>
      <input type='hidden' name=table_title value='<?php echo $table_title; ?>'>
      <input type='hidden' name='<?php echo $paraname; ?>' value='<?php echo $paradata; ?>'>
      <button type='submit' class='btn btn-secondary w-200px'><?php echo $title; ?></button>
    </form>
  </div>
<?php
}


//////////////////////////////////////////////////
//シート提出情報を書き込む
//////////////////////////////////////////////////
function submission_status_put($column, $status, $student_number, $nen)


{

  //ステータス書込み


  if ($column == "prof") {
    if ($nen == "") {
      ERR("年を指定しろ！");
    }
    $column = "profile_" . $nen;
  }

  if ($column == "go1Q") {
    if ($nen == "") {
      ERR("年を指定しろ！");
    }
    $column = "goal1Q_" . $nen;
  }


  if ($column == "go4Q") {
    if ($nen == "") {
      ERR("年を指定しろ！");
    }
    $column = "goal4Q_" . $nen;
  }


  if ($column == "rbas") {
    if ($nen == "") {
      ERR("年を指定しろ！");
    }
    $column = "ref_base_" . $nen;
  }




  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try {

    $sql = "UPDATE tbl_profile SET " . $column . "='" . $status . "' WHERE student_number='" . $student_number . "'";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
  } catch (\Exception $e) {
    dsip_msg($e->getMessage() . PHP_EOL);
    btn_return("index.php", "戻る");
    exit;
  }

  $stmt = null;
  $pdo = null;
  return;
}



//////////////////////////////////////////////////
//
//////////////////////////////////////////////////
function form_submit($ACTION)
{
  echo "<form action='" . $ACTION . "' method='post' onSubmit='return check()'>";
}

////////////////////////////////////////////////////////
// ボタンのタイトルによって、色、プロパティをセット
////////////////////////////////////////////////////////


function btn_submit($title, $action, $column, $mode)
{
  // ボタン色だけ決める（UI専用）
  $btntype = "btn-secondary";

  if ($title == "下書き") $btntype = "btn-warning";
  if ($title == "提出") $btntype = "btn-primary";
  if ($title == "要修正") $btntype = "btn-danger";
  if ($title == "承認") $btntype = "btn-success";

  if ($title == "登録") $btntype = "btn-success";
  if ($title == "変更/削除実行") $btntype = "btn-danger";
  if ($title == "法人削除") $btntype = "btn-danger";

  if ($title == "実習生紹介書登録") $btntype = "btn-success";
  if ($title == "実習施設・機関の概要登録") $btntype = "btn-success";
  if ($title == "年度更新") $btntype = "btn-warning";
  if ($title == "コメント登録") $btntype = "btn-success";
  if ($title == "一括登録") $btntype = "btn-success";
  if ($title == "初期化") $btntype = "btn-warning";

  // columnはそのまま送る（重要）
  echo "<input type='hidden' name='column' value='{$column}'>";

  // actionだけ送る（ここが本質）
  echo "<button type='submit' name='action' value='{$action}' class='mt-5 btn {$btntype} w-200px' {$mode}>{$title}</button>";
}


function btn_submit2($title, $action, $mode = "")
{
  $btntype = "btn-secondary";

  if (str_contains($title, "登録")) $btntype = "btn-success";
  if (str_contains($title, "削除")) $btntype = "btn-danger";
  if (str_contains($title, "更新")) $btntype = "btn-warning";

  echo "<button type='submit' name='action' value='{$action}' class='mt-5 btn {$btntype} w-200px' {$mode}>{$title}</button>";
}


//////////////////////////////////////////////////
//ボタンタイプ２
//////////////////////////////////////////////////

function btn_submit_s($title)
{
  echo "<button type='submit' class='btn btn-success'>" . $title . "</button>";
  echo "</form>";
}

//////////////////////////////////////////////////
//タイトル表示
//////////////////////////////////////////////////
function dsip_taitle($title)
{
?>
  <h2 class="my-4 mx-4"><?php echo $title; ?> </h2>
<?php
}

//////////////////////////////////////////////////
//サブタイトル表示
//////////////////////////////////////////////////
function dsip_sub_title($title)
{
?>
  <h3 class="mb-4 mx-4"><?php echo $title; ?> </h3>
<?php
}


//////////////////////////////////////////////////
//見出し表示
//////////////////////////////////////////////////
function dsip_midashi($title)
{





?>
  <h4 class="my-4 mx-4"><?php echo $title; ?> </h4>
<?php
}


//////////////////////////////////////////////////
//項目表示
//////////////////////////////////////////////////
function dsip_koumoku($title)
{
?>
  <h5 class="mt-4 mb-1 mx-4"><?php echo $title; ?> </h5>
<?php
}


//////////////////////////////////////////////////
//項目表示
//////////////////////////////////////////////////
function dsip_koumoku6($title)
{
?>
  <h6 class="mt-1 mb-1 mx-4"><?php echo $title; ?> </h6>
<?php
}



//////////////////////////////////////////////////
//　メッセージ表示
//////////////////////////////////////////////////
function dsip_msg($title)
{
?>
  <div style="height:200px;">　</div>
  <h5 class="text-center my-4 mx-4"><?php echo $title; ?> </h5>
<?php
}


//////////////////////////////////////////////////
//　メッセージ表示
//////////////////////////////////////////////////
function dsip_p($title)
{
?>
  <h6 class="mt-1 mb-1 mx-4"><?php echo $title; ?> </h6>
  <?php
}




////////////////////////////////////////////////////////////////////////////
//　汎用インプットテキスト　タイブ１　評価点入力中心揃え　幅狭い
////////////////////////////////////////////////////////////////////////////
function  _inputvt($name, $dat_value, $type, $mode, $hight1)
{

  if ($mode == "") {

    echo "<div class='mb-0 text-center' style='background-color:#ffffff'>";
    echo $dat_value;
    echo "</div>";
  } else {

    echo "<div class='input-group mb-0'>";
    echo "<input type='text' name=" . $name . " value='" . $dat_value . "' width='100px' class='text-center form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default'>";
    echo "</div>";
  }
}


//////////////////////////////////////////////////
//　汎用インプットテキスト　タイブ２　タイトル付
//////////////////////////////////////////////////

function _input($sub_title, $name, $dat_value, $type, $haba, $hight1)

{

  if ($haba == "") {
    $w = "250px";
  } else {
    $w = $haba;
  }


  if ($type == "text") {
  ?>
    <div class="input-group mb-0">

      <?php
      if ($sub_title <> "") {
      ?>
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroup-sizing-default" style="width:<?php echo $w; ?>"><?php echo $sub_title; ?></span>
        </div>

      <?php
      }
      ?>
      <input type="text" name="<?php echo $name; ?>" value="<?php echo $dat_value; ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
    </div>

  <?php
  } else if ($type == "textarea") {

  ?>
    <div class="input-group mb-0">
      <?php
      if ($sub_title <> "") {

        if ($sub_title == "教員からのコメント") {
          $coloer = "bg-primary2";
        } else {
          $coloer = "";
        }
      ?>
        <div class="input-group-prepend">
          <span class="input-group-text" style="width:<?php echo $w; ?>"><?php echo $sub_title; ?></span>
        </div>
      <?php
      }

      ?>
      <textarea class="<?php echo $coloer; ?> form-control <?php echo $hight1; ?>" aria-label="With textarea" name="<?php echo $name; ?>"><?php echo $dat_value; ?></textarea>
    </div>

  <?php

  } else if ($type == "password") {
  ?>

    <div style="width:550px">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroup-sizing-default" style="width:<?php echo $w; ?>"><?php echo $sub_title; ?></span>
        </div>

        <!--
        <input type="password" id="input_pass" name="<?php echo $name; ?>" value="<?php echo $dat_value; ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        &emsp;<button id="btn_passview" class="btn btn-secondary">表示</button>

-->
        <table>
          <tr>
            <td>
              <input type="password" id="textPassword" name="set_pass" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </td>

            <td>
              <span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span>
            </td>
          </tr>
        </table>


      </div>

    </div>


  <?php

  } else if ($type == "email") {

  ?>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-default" style="width:<?php echo $w; ?>"><?php echo $sub_title; ?></span>
      </div>
      <input type="email" name="<?php echo $name; ?>" value="<?php echo $dat_value; ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
    </div>

  <?php


  } else  if ($type == "Nonedit") {

  ?>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-default" style="width:<?php echo $w; ?>"><?php echo $sub_title; ?></span>
      </div>
      <?php echo $dat_value; ?>
    </div>

  <?php

  } else  if ($type == "") {

  ?>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-default" style="width:<?php echo $w; ?>"><?php echo $sub_title; ?></span>
      </div>
      <?php echo $dat_value; ?>
    </div>

    <?php


  }
}

//////////////////////////////////////////////////
//　汎用インプットテキスト　タイブ３
//////////////////////////////////////////////////

function _inputv2($subtitle, $name, $dat_value, $type, $mode, $hight1)

{
  $dat_value = trim($dat_value);
  $w = "250px";


  if ($hight1 == "右寄せ") {
    $r = " style='text-align:right' ";
  } else {
    $r = "";
  }



  if ($mode == "") {
    $w = "250px";
    if ($type == "text") {
    ?>
      <div class="input-group mb-0 waku-none">
        <?php
        if ($subtitle <> "") {
          echo "<div class='input-group-prepend'>";
          echo "<span class='input-group-text input-none'>" . $subtitle . "</span>";
          echo "</div>";
        }
        echo "<p class='mt-1 fs120'>" . $dat_value . "<p>";
        echo "<input type='hidden' name='" . $name . "' value='" . $dat_value . "'>";
        ?>
      </div>
    <?php




    } else if ($type == "textarea") {

      if ($subtitle <> "") {
        echo "<div class='input-group-prepend'>";
        echo "<span class='input-group-text input-none'>" . $subtitle . "</span>";
        echo "</div>";
      }


      echo "<p class='fs120'>" . nl2br($dat_value) . "</p>";
    ?>




    <?php
    }
  } else {

    if ($type == "text") {
    ?>


      <div class="input-group mb-0 waku-none">

        <?php
        if ($subtitle <> "") {
          echo "<div class='input-group-prepend'>";
          echo "<span class='input-group-text input-none'>" . $subtitle . "</span>";
          echo "</div>";
        }
        ?>

        <input type="text" name="<?php echo $name; ?>" value="<?php echo $dat_value; ?>" class="form-control  waku-none" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" <?php echo $r; ?>>
      </div>
    <?php
    } else if ($type == "textarea") {



    ?>

      <?php
      if ($subtitle <> "") {
        echo "<div class='input-group-prepend'>";
        echo "<span class='input-group-text input-none'>" . $subtitle . "</span>";
        echo "</div>";
      }
      ?>

      <textarea class="form-control <?php echo $hight1; ?>  waku-none" aria-label="With textarea" name="<?php echo $name; ?>"><?php echo $dat_value; ?></textarea>
      </div>
    <?php
    }
  }
}
//////////////////////////////////////////////////
//　汎用インプットテキスト　タイブ４
//////////////////////////////////////////////////
function _inputv($name, $dat_value, $type, $mode, $hight1, $length)
{



  $dat_value = trim($dat_value);

  $w = "250px";

  //入力できる文字数を設定する
  if ($length == "") {
    $length = "maxlength='24'";
  }

  if ($length == "255") {
    $length = "";
  }


  if ($length == "48") {
    $length = "maxlength='48'";
  }

  if ($length == "128") {
    $length = "maxlength='128'";
  }


  if ($mode == "") {
    //編集しない場合
    $w = "250px";
    if ($type == "text") {
    ?>
    <div class="input-group mb-0" style='background-color:#ffffff'>
        <div class="input-group mb-0">
          <?php

          echo "<p>" . $dat_value . "</p>";
          echo "<input type='hidden' name='" . $name . "' value='" . $dat_value . "'>";
          ?>
        </div>
      <?php
    } else if ($type == "textarea") {

      echo "<input type='hidden' name='" . $name . "' value='" . $dat_value . "'>";
      //      echo "<div class='wbr' style='background-color:#ffffff; min-height: 200px'>";
      echo "<div class='wbr' style='min-height: 20px'>"; //谷修正

      echo nl2br($dat_value);



      echo "</div>";
    }
  } else {

    //編集する場合

    if ($mode == "required") {
      $required = " required";
    } else {
      $required = "";
    }

    //テキストの場合
    if ($type == "text") {
      ?>
        <div class="input-group mb-0">
          <input type="text" <?php echo $length; ?> name="<?php echo $name; ?>" value="<?php echo $dat_value; ?>" class="form-control input-highlight" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" <?php echo $required; ?>>
        </div>
      <?php


    } else if ($type == "textarea") {
      //テキストエリアの場合
      ?>

        <div class="input-container">
          <textarea class="form-control input-white <?php echo $hight1; ?>"
              name="<?php echo $name; ?>" <?php echo $required; ?>>
              <?php echo $dat_value; ?>
          </textarea>
        </div>
    </div>
    <?php
    } elseif ($type == "password") {



    ?>


      <!--
      <div class="input-group mb-0">
        <input type="password" id="input_pass" name="<?php echo $name; ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        &emsp;<button id="btn_passview" class="btn btn-secondary">表示</button>

      </div>

-->




      <table>
        <tr>
          <td>
            <input type="password" id="textPassword" name="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
          </td>

          <td>
            <span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span>
          </td>
        </tr>
      </table>


  <?php



    }
  }
  return null;
}



//////////////////////////////////////////////////
//　デバッグ関数
//////////////////////////////////////////////////
function  DP($D1)
{
  echo "******" . $D1 . "*****<br>";
}

function  STOP($D1)
{
  echo ">>>" . $D1 . "<<<";
  exit;
}





function  ERR($D1)
{
  echo "******" . $D1 . "*****<br>";

  exit;
}



//////////////////////////////////////////////////
// ログイン画面
//////////////////////////////////////////////////
function login()
{
  ?>
  <div class="row">

    <div class="col-sm-4 pb-2 mx-60"></div>
    <div class="col-sm-4 pb-2 mx-60">

      <h3 CLASS="mt-5">ログインしてください</h3>

      <div class="text-center">
        <?php
        form_submit("./authentication/login_chek.php");
        _input("メールアドレス", "email", "", "email", "100px", "");

        // _input("パスワード", "password", "", "password", "100px", "");



        ?>


        <div style="width:410px">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default" style="width:100px">パスワード</span>
            </div>




            <!--            <input type="password" id="input_pass" name="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            &emsp;<button id="btn_passview" class="btn btn-secondary" tabindex="">表示</button>
-->
            <table>
              <tr>
                <td>
                  <input type="password" id="textPassword" name="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </td>

                <td>
                  <span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span>
                </td>
              </tr>
            </table>


          </div>



        </div>

        <?php


        btn_submit2("ログイン", "", "");

        btn_return("forgetpass.php", "パスワード忘れた場合");


        echo "</form>";
        ?>
      </div>


      <br><br><br><br><br>





      <br><br><br><br><br>




    </div>























    <div class="col-sm-4 pb-2 mx-60"></div>


  </div>


  <div style="height:400px;"></div>

<?php
  return null;
}



//////////////////////////////////////////////////
// 学生ログイン画面
//////////////////////////////////////////////////
function mein_menu()
{
?>
  <h2 class="mt-4 mx-4">MENU</h2>
  <table class="table my-5">
    <tr>
      <td class="text-center"> <a type="button" class="btn btn-info w-200px" href="account.php">個人情報</a></td>
      <td class="text-center"> <a type="button" class="btn btn-primary w-200px" href="select_sheet.php">学修計画・リフレクション・シート</a></td>
      <td class="text-center"> <a type="button" class="btn btn-secondary w-200px" href="authentication/logout.php">ログアウト</a></td>
    </tr>
    <tr>
      <td class="text-center"> <a type="button" class="btn btn-info w-200px" href="sheet_intern_introduction.php">実習生紹介書</a></td>
      <td class="text-center"> <a type="button" class="btn btn-primary w-200px" href="sheet_equipment_outline_list.php">実習施設概要</a></td>
      <td></td>
    </tr>

    <tr>
      <td></td>
      <td class="text-center"> <a type="button" class="btn btn-primary w-200px" href="select_sheet_practice.php">実習計画・自己評価・シート</a></td>
      <td></td>
    </tr>


    <td class="text-center"><a href="manual/manual1_student.php" target="_blank">学生用マニュアル</a></td>

    <td></td>
    <td></td>
    </tr>


    <!--ここはデバックです。-->
    <!--ここはデバックです。-->
    <!--ここはデバックです。-->
    <!--ここはデバックです。-->
    <!--ここはデバックです。

    <tr>

      <td class="text-center"> <a type="button" class="btn btn-secondary w-200px" href="common/status_clear.php?mode=0">未作成にする</a></td>
      <td class="text-center"> <a type="button" class="btn btn-secondary w-200px" href="common/status_clear.php?mode=1">下書きにする</a></td>
      <td class="text-center"> <a type="button" class="btn btn-secondary w-200px" href="common/status_clear.php?mode=2">提出済にする</a></td>
    </tr>

    <tr>

      <td class="text-center"> <a type="button" class="btn btn-secondary w-200px" href="common/status_clear.php?mode=3">要修正にする</a></td>
      <td class="text-center"> <a type="button" class="btn btn-secondary w-200px" href="common/status_clear.php?mode=4">承認済にする</a></td>
      <td class="text-center"></td>
    </tr>
    -->

    <!--ここはデバックです。-->
    <!--ここはデバックです。-->
    <!--ここはデバックです。-->
    <!--ここはデバックです。-->


    <!-- Comment out after the implemntation -->

  </table>

  <div style="height:100px;"></div>
<?php
  return null;
}


//////////////////////////////////////////////////
// ログイン画面
//////////////////////////////////////////////////
function kanri_menu()
{
?>

  <p class="mt-4 text-end"><?php echo "事業年度:" . $_SESSION['NENDO'] . "年　　管理年度:" . $_SESSION['KANRI_NENDO'] . "年　"; ?></p>

  <h2 class="mt-4 mx-4">教員・事務局MENU</h2>
  <table class="table mt-4">
    <tr>
      <td class="text-center"> <a type="button" class="btn btn-info w-200px" href="account.php">個人情報</a></td>
      <td class="text-center"> <a type="button" class="btn btn-primary w-200px" href="student_list.php">学生一覧</a></td>
      <td class="text-center"> <a type="button" class="btn btn-success w-200px" href="master_list.php">マスター管理</a></td>
    </tr>



    <tr>
      <td class="text-center"> <a type="button" class="btn btn-info w-200px" href="bulk_registration.php">一括仮登録</a>
      </td>
      <td class="text-center"> <a type="button" class="btn btn-primary w-200px" href="assignment_info.php">実習配属情報</a>
      </td>
      <td class="text-center"> <a type="button" class="btn btn-success w-200px" href="nendo_koshin.php">年度更新</a></td>
    </tr>

    <tr>
      <td class="text-center"> <a type="button" class="btn btn-info w-200px" href="practice_info.php">実習先情報</a></td>
      <td class="text-center"> <a type="button" class="btn btn-primary w-200px" href="pdf_list.php">書類出力PDF</a></td>
      <td class="text-center"> <a type="button" class="btn btn-secondary w-200px" href="authentication/logout.php">ログアウト</a></td>

    </tr>

    <tr>
      <td class="text-center"><a href="manual/manual2_teacher.php" target="_blank">教員・事務局用マニュアル</a></td>
      <td></td>
      <td></td>
    </tr>


  </table>
  <div style="height:400px;"></div>
<?php
  return null;
}

////////////////////////////////////////
// 西暦 => 和暦
////////////////////////////////////////
function wareki($year)
{

  $eras = array(
    array('year' => 2018, 'name' => '令和'),
    array('year' => 1988, 'name' => '平成'),
    array('year' => 1925, 'name' => '昭和'),
    array('year' => 1911, 'name' => '大正'),
    array('year' => 1867, 'name' => '明治')
  );

  foreach ($eras as $era) {

    $base_year = $era['year'];
    $era_name = $era['name'];

    if ($year > $base_year) {

      $era_year = $year - $base_year;

      if ($era_year === 1) {
        return '元';
        //                return $era_name .'元';
      }

      return  $era_year;
      //            return $era_name . $era_year .'年';
    }
  }
  return null;
}
