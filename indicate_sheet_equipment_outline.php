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
$ACTION="indicate_sheet_equipment_outline_list.php";


require('./disp_parts/headerNon.php');
require('data_keep.php');




$曜日 = ['日', '月', '火', '水', '木', '金', '土'];



$sta = "0";
$student_number = $_SESSION['SEL_STUDENT_NUMBER'];
$法人ID = $_POST['法人ID'];
$事業年度 = $_SESSION['NENDO'];
tbl_profile_READ($_SESSION['SEL_STUDENT_NUMBER']);

try {
  // DBへ接続

  $dbh = new PDO(DSN, DB_USER, DB_PASS);
  // SQL作成


  $sql = "select 事業年度,tbl_institution.法人ID,tbl_institution.法人名,tbl_institution.施設名,tbl_institution.施設種別,tbl_institution.実習種別1,tbl_institution.実習種別2,tbl_institution.管理者,tbl_institution.管理者役職名,tbl_institution.実習窓口担当者名,tbl_institution.郵便番号,tbl_institution.所在地,tbl_institution.電話番号,tbl_institution.FAX番号,tbl_institution.MAIL,tbl_institution.URL,tbl_assignment.学籍番号1,tbl_assignment.学籍番号2,tbl_assignment.学籍番号3,tbl_assignment.学籍番号4,tbl_assignment.学籍番号5,tbl_assignment.実習種別1,tbl_assignment.実習種別2,tbl_assignment.実習種別3,tbl_assignment.実習種別4,tbl_assignment.実習種別5,tbl_assignment.実習開始日1,tbl_assignment.実習開始日2,tbl_assignment.実習開始日3,tbl_assignment.実習開始日4,tbl_assignment.実習開始日5,tbl_assignment.実習終了日1,tbl_assignment.実習終了日2,tbl_assignment.実習終了日3,tbl_assignment.実習終了日4,tbl_assignment.実習終了日5,tbl_assignment.学年1,tbl_assignment.学年2,tbl_assignment.学年3,tbl_assignment.学年4,tbl_assignment.学年5,tbl_assignment.実習指導者1,tbl_assignment.実習指導者2,tbl_assignment.実習指導者3 FROM tbl_assignment JOIN tbl_institution ON tbl_assignment.法人ID=tbl_institution.法人ID where ((学籍番号1='" . $student_number . "') OR (学籍番号2='" . $student_number . "') OR (学籍番号3='" . $student_number . "') OR (学籍番号4='" . $student_number . "') OR (学籍番号5='" . $student_number . "')) AND (事業年度='" . $事業年度 . "') AND (tbl_institution.法人ID=" . $法人ID . ")";



  $cnt = 0;


  $res = $dbh->query($sql);
  foreach ($res as $value) {

    $cnt = $cnt + 1;

    $GLOBALS['実習種別1'] = $value['実習種別1'];
    $GLOBALS['実習種別2'] = $value['実習種別2'];
    $GLOBALS['法人名'] = $value['法人名'];
    $GLOBALS['施設名'] = $value['施設名'];
    $GLOBALS['施設種別'] = $value['施設種別'];
    $GLOBALS['管理者'] = $value['管理者'];
    $GLOBALS['管理者役職名'] = $value['管理者役職名'];
    $GLOBALS['実習窓口担当者名'] = $value['実習窓口担当者名'];
    if ($value['学籍番号1'] == $student_number) {
      $GLOBALS['実習種別'] = $value['実習種別1'];
      $GLOBALS['実習開始日'] = $value['実習開始日1'];
      $GLOBALS['実習終了日'] = $value['実習終了日1'];
      $GLOBALS['学年'] = $value['学年1'];
    }
    if ($value['学籍番号2'] == $student_number) {
      $GLOBALS['実習種別'] = $value['実習種別2'];
      $GLOBALS['実習開始日'] = $value['実習開始日2'];
      $GLOBALS['実習終了日'] = $value['実習終了日2'];
      $GLOBALS['学年'] = $value['学年2'];
    }
    if ($value['学籍番号3'] == $student_number) {
      $GLOBALS['実習種別'] = $value['実習種別3'];
      $GLOBALS['実習開始日'] = $value['実習開始日3'];
      $GLOBALS['実習終了日'] = $value['実習終了日3'];
      $GLOBALS['学年'] = $value['学年3'];
    }
    if ($value['学籍番号4'] == $student_number) {
      $GLOBALS['実習種別'] = $value['実習種別4'];
      $GLOBALS['実習開始日'] = $value['実習開始日4'];
      $GLOBALS['実習終了日'] = $value['実習終了日4'];
      $GLOBALS['学年'] = $value['学年4'];
    }
    if ($value['学籍番号5'] == $student_number) {
      $GLOBALS['実習種別'] = $value['実習種別5'];
      $GLOBALS['実習開始日'] = $value['実習開始日5'];
      $GLOBALS['実習終了日'] = $value['実習終了日5'];
      $GLOBALS['学年'] = $value['学年5'];
    }

    $GLOBALS['郵便番号'] = $value['郵便番号'];
    $GLOBALS['所在地'] = $value['所在地'];
    $GLOBALS['電話番号'] = $value['電話番号'];
    $GLOBALS['FAX番号'] = $value['FAX番号'];
    $GLOBALS['MAIL'] = $value['MAIL'];
    $GLOBALS['URL'] = $value['URL'];

    $GLOBALS['実習指導者1'] = $value['実習指導者1'];
    $GLOBALS['実習指導者2'] = $value['実習指導者2'];
    $GLOBALS['実習指導者3'] = $value['実習指導者3'];
  if ($GLOBALS['学年'] ="１") {$GLOBALS['学年'] ="1";}
  if ($GLOBALS['学年'] ="２") {$GLOBALS['学年'] ="2";}
  if ($GLOBALS['学年'] ="３") {$GLOBALS['学年'] ="3";}
  if ($GLOBALS['学年'] ="４") {$GLOBALS['学年'] ="4";}


  }
} catch (PDOException $e) {
  echo $e->getMessage();
  die();
}
?>



<div class="pagebreak"></div>

<?php

dsip_midashi("実習施設・機関の概要（".$name."）");



tbl_institution_overview_READ($student_number, $学年, $実習種別);

?>



<table class="table tunagi table-bordered border-secondary">

  <tr>
    <td width="35%">
      <p>法人名</p>
      <?php _inputv2("", "法人名",  $法人名, "text", "", ""); ?>
    </td>
    <td width="40%">
      <p>施設名</p>
      <?php _inputv2("", "施設名",  $施設名, "text", "", ""); ?>
    </td>
    <td width="25%">
      <p>施設種別</p>
      <?php _inputv2("", "施設種別",  $施設種別, "text", "", ""); ?>
    </td>
  </tr>
</table>
<table class="table tunagi table-bordered border-secondary table_tunagi">

  <tr>
    <td>
      <table width="100%">
        <tr>
          <td width="10%">
            所在地
          </td>
          <td width="15%">
            <?php _inputv2("〒", "郵便番号",  $郵便番号, "text", "", ""); ?>
          </td>
          <td width="75%">
          </td>
        </tr>

        <tr>
          <td>
          </td>
          <td colspan="2">
            <?php _inputv2("", "所在地",  $所在地, "text", "", ""); ?>
          </td>
        </tr>

      </table>


      <table width="100%">
        <tr>
          <td width="15%">
            <?php _inputv2("TEL", "電話",  $電話番号, "text", "", ""); ?>
          </td>
          <td width="15%">
            <?php _inputv2("FAX", "FAX",  $FAX番号, "text", "", ""); ?>
          </td>
          <td width="35%">
            <?php _inputv2("MAIL", "MAIL",  $MAIL, "text", "", ""); ?>
          </td>
          <td width="35%">
            <?php _inputv2("URL", "URL",  $URL, "text", "", ""); ?>
          </td>
        </tr>
      </table>

    </td>
  </tr>

</table>
<table class="table tunagi table-bordered border-secondary table_tunagi">
  <tr>
    <td width="30%">
      <p>施設長氏名</p>
      <?php _inputv2("", "施設長",  $管理者, "text", "", ""); ?>
    </td>
    <td>
      <p>実習指導者氏名</p>

      <table width="100%">
        <tr>
          <td width="33%">
            <?php _inputv2("", "指導者1",  $実習指導者1, "text", "", ""); ?>
          </td>
          <td width="33%">
            <?php _inputv2("", "指導者2",  $実習指導者2, "text", "", ""); ?>
          </td>
          <td width="33%">
            <?php _inputv2("", "指導者3",  $実習指導者3, "text", "", ""); ?>
          </td>
        </tr>
      </table>
    </td>

  </tr>
</table>

</td>


</tr>

</table>


<table class="table tunagi table-bordered border-secondary table_tunagi">
  <tr>

    <td width="30%">
      <p>実習種別</p>
      <?php _inputv2("", "実習種別",  $実習種別, "text", "", ""); ?>
    </td>


    <td>
      <p>実習期間</p>




      <table width="100%">
        <tr>
          <td class="text-end">
               <p><?php echo date('Y年m月d日', strtotime($実習開始日));?> </p>

          </td>
          <td  class="text-center">
            ～
          </td>
          <td>
               <p><?php echo date('Y年m月d日', strtotime($実習終了日));?> </p>
          
          </td>
        </tr>
      </table>


    </td>



  </tr>
</table>
 

<table class="table tunagi table-bordered border-secondary">


  <tr height="290px">
    <td>
      <table style="width:100%;">
        <tr>
          <td>法人の特徴と沿革・事業概要
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "法人事業概要",  $法人事業概要, "textarea", "", "h200"); ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr height="240px">
    <td>
      <table style="width:100%;">
        <tr>
          <td>実習先施設・機関の事業概要と職員構成
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "施設事業概要",  $施設事業概要, "textarea", "", "h200"); ?>

          </td>
        </tr>
      </table>
    </td>
  </tr>

</table>

<p class="text-end">
  大正大学　社会福祉学科
</p>


<div class="pagebreak"></div>

<?php
dsip_midashi("実習施設・機関の概要");

?>
<table class="table tunagi table-bordered border-secondary">
  <tr>
    <td>
      <table style="width:100%;">
        <tr>
          <td>実地周辺地域の概要
          </td>
        </tr>
        <tr>
          <td style="height:800px">
            <?php _inputv2("", "周辺地域",  $周辺地域, "textarea", "", "h100p"); ?>
        </tr>

        <tr>
          <td>その他印刷物は添付のこと
          </td>
        </tr>
      </table>
    </td>

  </tr>
</table>


<table class="table tunagi table-bordered border-secondary table_tunagi">
  <tr>
    <td>
      <table>
        <tr>
          <td>（実習生氏名・学年）
          </td>
          <td>
            <?php _inputv2("", "氏名",   $name, "text", "", ""); ?>
          </td>
          <td>
            <?php _inputv2("", "学年",  $学年."学年", "text", "", ""); ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<p class="text-end">
  大正大学　社会福祉学科
</p>
<div class="pagebreak"></div>




<table class="table">
  <tr>
    <td>
      <?php btn_return("indicate_sheet_equipment_outline_list.php", "戻る"); ?>
    </td>
  </tr>

</table>







<?php

require('./disp_parts/footer.php');
exit;
?>