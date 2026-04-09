<?php
session_start();

$年度 = "";
$dummy = "";
$実習種別 = "";

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

$ACTION = "index.php";
require('./disp_parts/headerjs.php');


/*require('header_w.php');*/
require('data_keep.php');



//////////何年度の表の提出状況を表示するか


$SEl1_1 = "";
$SEl1_2 = "";
$SEl1_3 = "";
$SEl1_4 = "";
$SEl1_5 = "";
$SEl1_6 = "";
$SEl1_7 = "";


$SEl2_1 = "";
$SEl2_2 = "";
$SEl2_3 = "";
$SEl2_4 = "";
$SEl2_5 = "";
$SEl2_6 = "";
$SEl2_7 = "";



$nenP1 = "1";
$nenP2 = "2";
$nenP3 = "3";
$nenP4 = "4";



if (!isset($_POST['選択学年'])) {
  $nen = $nenP3;
  $_POST['選択学年'] = $nenP3;
} else {
  if ($_POST['選択学年'] == $nenP1) {
    $SEl1_1 = "selected";
  }
  if ($_POST['選択学年'] == $nenP2) {
    $SEl1_2 = "selected";
  }
  if ($_POST['選択学年'] == $nenP3) {
    $SEl1_3 = "selected";
  }
  if ($_POST['選択学年'] == $nenP4) {
    $SEl1_4 = "selected";
  }
}
$school_year = $_POST['選択学年'];


$sta = "0";
$student_number = $_SESSION['STUDENT_NUMBER'];


tbl_profile_READ($student_number);

tbl_profile_detail_READ($student_number, $school_year);


$GLOBALS['氏名'] = $name;
$GLOBALS['かな'] = $kana;
$GLOBALS['現住所'] = $adresse;
$GLOBALS['電話'] = $tel;
$GLOBALS['帰省先'] = $hometown;

$GLOBALS['学内所属団体'] = $affiliation_circle_campus;
$GLOBALS['学外所属団体'] = $affiliation_circle_off_campus;
$GLOBALS['考慮事項'] = $things_to_consider;
$GLOBALS['資格特技'] = $qualification;
$GLOBALS['指導教員'] = $comments_of_teacher;

tbl_student_introduction_read($student_number);



?>

<div style="height:50px;">
</div>



<div class="pagebreak"></div>

<?php

form_submit("registration.php");

dsip_midashi("実習生紹介書");

?>
<table class="table tunagi table-bordered border-secondary">

  <tr>
    <td width="5%" class="text-center text-middle">
      <p>学<br>年</p>
    </td>
    <td colspan="2" class="text-middle">


      <select name="学年" id="nend-select">
        <option value=<?php echo $学年 . " " . $SEl1_1; ?>><?php echo $学年 . "学年"; ?></option>
        <option value=<?php echo $nenP1 . " " . $SEl1_1; ?>><?php echo $nenP1 . "学年"; ?></option>
        <option value=<?php echo $nenP2 . " " . $SEl1_2; ?>><?php echo $nenP2 . "学年"; ?></option>
        <option value=<?php echo $nenP3 . " " . $SEl1_3; ?>><?php echo $nenP3 . "学年"; ?></option>
        <option value=<?php echo $nenP4 . " " . $SEl1_4; ?>><?php echo $nenP4 . "学年"; ?></option>
      </select>
    </td>




    <td width="5%" class="text-center text-middle">
      <p>氏<br>名</p>
    </td>
    <td colspan="2" width="60%" class="text-middle">
      <table>
        <tr>
          <td><?php _inputv2("", "氏名", $name, "text", "edit", ""); ?></td>
          <td>（</td>
          <td><?php _inputv2("", "かな", $kana, "text", "edit", ""); ?></td>
          <td>）</td>
        </tr>
      </table>

    </td>
    <td rowspan="2" height="150px" width="20%">
      <p class="text-center"><?php echo "<br>写   真<br>(4cm×3cm)"; ?>
    </td>
  </tr>

  <tr>
    <td colspan="4" width="40%" class="text-middle">
      <table width="100%">
        <tr>
          <td>
            <p>生年月日</p>
          </td>
        </tr>
        <tr>
          <td>

            <input name="生年月日" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $生年月日; ?> style="width:150px">



          </td>
        </tr>
      </table>
    </td>
    <td width="40%" class="text-middle">
      <p>履修中の資格課程</p>
      <table width="100%">
        <tr>
          <td width="70%">
            <?php _inputv2("", "資格課程", $資格課程, "text", "edit", ""); ?>
          </td>
          <td width="30%">
            <p class="text-middle">受験資格</p>
          </td>
        </tr>
      </table>



    </td>
  </tr>


</table>


<table class="table tunagi table-bordered border-secondary ">

  <tr>
    <td width="5%" class="text-center text-middle">
      <p>現<br>住<br>所</p>
    </td>
    <td width="95%" class="">
      <table width="100%">
        <tr>
          <td colspan="2">
            <table>
              <tr>
                <td width="200px">
                  <?php _inputv2("〒", "郵便現住所", $郵便現住所, "text", "edit", ""); ?>
                </td>
                <td></td>
              </tr>
            </table>

          </td>
        </tr>
        <tr>
          <td width="60%">
            <?php _inputv2("", "現住所", $現住所, "text", "edit", ""); ?>

          </td>
          <td width="40%">
            <?php _inputv2("TEL", "電話",  $電話, "text", "edit", ""); ?>
          </td>
        </tr>
      </table>

    </td>
  </tr>
  <tr>
    <td width="5%" class="text-center text-middle">
      <p>帰<br>省<br>先</p>
    </td>

    <td width="95%" class="">
      <table width="100%">
        <tr>
          <td colspan="2">
            <?php _inputv2("〒", "郵便帰省先", $郵便帰省先, "text", "edit", ""); ?>
          </td>
        </tr>
        <tr>
          <td width="60%">
            <?php _inputv2("", "帰省先", $帰省先, "text", "edit", ""); ?>

          </td>
          <td width="40%">
            <?php _inputv2("TEL", "帰省先電話", $帰省先電話, "text", "edit", ""); ?>
          </td>
        </tr>
      </table>


    </td>
  </tr>

</table>
<table class="table tunagi table-bordered border-secondary ">
  <tr>
    <td>
      <table width="100%">
        <tr>
          <td>
            職歴
          </td>
    </td>
  </tr>
  <tr>
    <td>
      <?php _inputv2("", "職歴",  $職歴, "textarea", "edit", "h80"); ?>
    </td>
  </tr>
</table>
</td>
</tr>

</table>

<table class="table tunagi table-bordered border-secondary ">

  <tr>
    <td>

      <table width="100%">
        <tr>
          <td>
            <P>所属団体</P>
          </td>
        </tr>

        <tr>
          <td>
            <P>（大学内の文化団体、研修会、クラブ活動等）</P>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "学内所属団体",  $学内所属団体, "textarea", "edit", ""); ?>
          </td>
        </tr>

        <tr>
          <td>
            <P>（大学外の文化団体、研修会、クラブ活動等）</P>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "学外所属団体",  $学外所属団体, "textarea", "edit", ""); ?>

          </td>
        </tr>

      </table>


    </td>
  </tr>

  <tr>
    <td>
      <table width="100%">
        <tr>
          <td>
            <P>健康状態</P>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "健康状態",  $健康状態, "textarea", "edit", "h80"); ?>

          </td>
        </tr>
      </table>

    </td>
  </tr>
  <td>
    <table width="100%">
      <tr>
        <td>
          <P>実習を行うにあたり配慮していただきたいこと</P>
        </td>
      </tr>
      <tr>
        <td>
          <?php _inputv2("", "考慮事項",  $考慮事項, "textarea", "edit", "h80"); ?>

        </td>
      </tr>
    </table>

  </td>
  </tr>

</table>



<table class="table tunagi table-bordered border-secondary ">
  <tr>
    <td width="50%">
      <table width="100%">
        <tr>
          <td>
            <P>資格・特技</P>
          </td>
        </tr>

        <tr>
          <td>
            <?php _inputv2("", "資格特技",  $資格特技, "textarea", "edit", "h80"); ?>
          </td>
        </tr>
      </table>
    </td>

    <td width="50%">
      <table width="100%">
        <tr>
          <td>
            <P>趣味</P>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "趣味",  $趣味, "textarea", "edit", "h80"); ?>

          </td>

        </tr>
      </table>
    </td>

  </tr>
</table>


<table class="table tunagi table-bordered border-secondary ">
  <tr>
    <td>
      <table width="100%">
        <tr>
          <td>
            <P>自己アピール</P>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "自己アピール",  $自己アピール, "textarea", "edit", "h80"); ?>
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
dsip_midashi("実習生紹介書");
?>

<table class="table table-bordered border-secondary">


  <tr height="290px">
    <td>
      <table style="width:100%;">
        <tr>
          <td>2年次の現場体験学習の内容と学んだこと
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "現場体験",  $現場体験, "textarea", "edit", "h80"); ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr height="240px">
    <td>
      <table style="width:100%;">
        <tr>
          <td>実習の準備状況（ボランティア経験等記入）（）
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "準備状況",  $準備状況, "textarea", "edit", "h80"); ?>

          </td>
        </tr>
      </table>
    </td>
  </tr>


  <tr height="260px">
    <td>
      <table style="width:100%;">
        <tr>
          <td>教員コメント欄（学生は記入しない）
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "教員コメント",  $教員コメント, "textarea", "", "h200"); ?>

          </td>
        </tr>
      </table>
    </td>
  </tr>

</table>




<table class="table table-bordered border-secondary ">


  <tr>
    <td width="10%" class="text-center text-middle">
      <p class="fw600">連絡先</p>
    </td>
    <td width="60%" class="text-center text-middle">
      <p class="fw600">〒170-8740　東京都豊島区西巣鴨3-20-1<br>
        大正大学社会福祉実習指導室<br>
        TEL/FAX 03-5394-3085（直通）</p>
    </td>
    <td width="30%">
      <table style="width:100%;">
        <tr>
          <td>指導教員</td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "指導教員",  $指導教員, "text", "edit", ""); ?>
          </td>
        </tr>

        <tr>
          <td>事務担当</td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "事務担当",  $事務担当, "text", "edit", ""); ?>
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



<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $_SESSION['STUDENT_NUMBER']; ?>">
<input type='hidden' name='TABLE' value="tbl_student_introduction">
<input type='hidden' name='METHOD' value="UP_DATE">



<table class="table">
  <tr>
  <tr>
    <td>
      <?php btn_submit2("実習生紹介書登録", "student_intro_update"); ?>
    </td>
    <td>
      <?php btn_return("index.php", "戻る"); ?>
    </td>
  </tr>

</table>





<?php

echo "</form>";

require('./disp_parts/footer.php');
exit;
?>