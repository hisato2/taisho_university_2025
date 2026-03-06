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


$ACTION="student_list.php";


require('./disp_parts/header.php');

require('data_keep.php');



$sta = "0";
$student_number = $_SESSION['SEL_STUDENT_NUMBER'];


tbl_student_introduction_read($student_number);




if (!isset($氏名)) {
      dsip_midashi("実習生紹介書");
      dsip_msg("実習生紹介書が作成されていません");
      btn_return("student_list.php", "戻る");
      exit;
}

?>

<div style="height:50px;">
</div>

<div class="pagebreak"></div>



<?php






form_submit("registration.php");

dsip_midashi("実習生紹介書");




$school_year = $学年;
$name = $氏名;
$kana = $かな;




?>
<table class="table tunagi table-bordered border-secondary">

  <tr>
    <td width="200px" class="text-center text-middle">
      <p class="fw700l">学年</p>
    </td>
    <td width="300px" class="text-middle">
      <p class="text-center text-middle">
        <?php _inputv2("", "学年", $school_year . "学年", "text", "", ""); ?>
      </p>
    </td>
    <td width="200px" class="text-center text-middle">
      <p class="fw700l">氏<br>名</p>
    </td>
    <td colspan="2" class="text-middle">
      <table>
        <tr>
          <td><?php _inputv2("", "氏名", $name, "text", "", ""); ?></td>
          <td>（</td>
          <td><?php _inputv2("", "かな", $kana, "text", "", ""); ?></td>
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
            <p class="fw700l">生年月日</p>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "生年月日", $生年月日, "text", "", ""); ?>
          </td>
        </tr>
      </table>
    </td>
    <td width="40%" class="text-middle">
      <p class="fw700l">履修中の資格課程</p>
      <table width="100%">
        <tr>
          <td width="70%">
            <?php _inputv2("", "資格課程", $資格課程, "text", "", ""); ?>
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
      <p class="fw700l">現<br>住<br>所</p>
    </td>
    <td width="95%" class="">
      <table width="100%">
        <tr>
          <td colspan="2">
            <table>
              <tr>
                <td width="200px">
                  <?php _inputv2("〒", "郵便現住所", $郵便現住所, "text", "", ""); ?>
                </td>
                <td></td>
              </tr>
            </table>

          </td>
        </tr>
        <tr>
          <td width="60%">
            <?php _inputv2("", "現住所", $現住所, "text", "", ""); ?>

          </td>
          <td width="40%">
            <?php _inputv2("TEL", "電話",  $電話, "text", "", ""); ?>
          </td>
        </tr>
      </table>

    </td>
  </tr>
  <tr>
    <td width="5%" class="text-center text-middle">
      <p class="fw700l">帰<br>省<br>先</p>
    </td>

    <td width="95%" class="">
      <table width="100%">
        <tr>
          <td colspan="2">
            <?php _inputv2("〒", "郵便帰省先", $郵便帰省先, "text", "", ""); ?>
          </td>
        </tr>
        <tr>
          <td width="60%">
            <?php _inputv2("", "帰省先", $帰省先, "text", "", ""); ?>

          </td>
          <td width="40%">
            <?php _inputv2("TEL", "帰省先電話", $帰省先電話, "text", "", ""); ?>
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
            <p  class="fw700l">職歴</p>
          </td>
    </td>
  </tr>
  <tr>
    <td>
      <?php _inputv2("", "職歴",  $職歴, "textarea", "", ""); ?>
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
            <P class="fw700l">所属団体</P>
          </td>
        </tr>

        <tr>
          <td>
            <P class="fw700l">（大学内の文化団体、研修会、クラブ活動等）</P>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "学内所属団体",  $学内所属団体, "textarea", "", ""); ?>
          </td>
        </tr>

        <tr>
          <td>
            <P class="fw700l">（大学外の文化団体、研修会、クラブ活動等）</P>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "学外所属団体",  $学外所属団体, "textarea", "", ""); ?>

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
            <P class="fw700l">健康状態</P>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "健康状態",  $健康状態, "textarea", "", ""); ?>

          </td>
        </tr>
      </table>

    </td>
  </tr>
  <td>
    <table width="100%">
      <tr>
        <td>
          <P class="fw700l">実習を行うにあたり配慮していただきたいこと</P>
        </td>
      </tr>
      <tr>
        <td>
          <?php _inputv2("", "考慮事項",  $考慮事項, "textarea", "", ""); ?>

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
            <P class="fw700l">資格・特技</P>
          </td>
        </tr>

        <tr>
          <td>
            <?php _inputv2("", "資格特技",  $資格特技, "textarea", "", ""); ?>
          </td>
        </tr>
      </table>
    </td>

    <td width="50%">
      <table width="100%">
        <tr>
          <td>
            <P class="fw700l">趣味</P>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "趣味",  $趣味, "textarea", "", ""); ?>

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
            <P class="fw700l">自己アピール</P>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "自己アピール",  $自己アピール, "textarea", "", ""); ?>
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
          <td><p  class="fw700l">2年次の現場体験学習の内容と学んだこと</p></td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "現場体験",  $現場体験, "textarea", "", "h200"); ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr height="240px">
    <td>
      <table style="width:100%;">
        <tr>
          <td><p class="fw700l">実習の準備状況（ボランティア経験等記入）</p>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "準備状況",  $準備状況, "textarea", "", "h200"); ?>

          </td>
        </tr>
      </table>
    </td>
  </tr>


  <?php form_submit("registration.php"); ?>


  <tr height="260px">
    <td>
      <table style="width:100%;">
        <tr>
          <td><p class="fw700l">教員コメント欄</p>
          </td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "教員コメント",  $教員コメント, "textarea", "edit", "h200"); ?>

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
            <?php _inputv2("", "指導教員",  $指導教員, "text", "", ""); ?>
          </td>
        </tr>

        <tr>
          <td>事務担当</td>
        </tr>
        <tr>
          <td>
            <?php _inputv2("", "事務担当",  $事務担当, "text", "", ""); ?>
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



<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $_SESSION['SEL_STUDENT_NUMBER']; ?>">
<input type='hidden' name='TABLE' value="tbl_student_introduction">
<input type='hidden' name='METHOD' value="COMMENT_UP">


<table class="table">
  <tr>
  <tr>
    <td>
      <?php btn_submit("コメント登録", "", ""); ?>
    </td>
    <td>
      <?php btn_return("student_list.php", "戻る"); ?>
    </td>
  </tr>

</table>





<?php

require('./disp_parts/footer.php');
exit;
?>