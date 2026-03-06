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

$ACTION="index.php";
require('./disp_parts/headerNon.php');


tbl_profile_READ($_SESSION['STUDENT_NUMBER']);


$btn_type1 = "btn-outline-primary";
$btn_type2 = "btn-outline-primary";
$btn_type3 = "btn-outline-primary";
$btn_type4 = "btn-outline-primary";




if (!isset($_SESSION['SELECT_NEN'])) {
  $_SESSION['SELECT_NEN']=1;
}


if (!isset($_GET['gNEN'])) {
  $_GET['gNEN'] = $_SESSION['SELECT_NEN'];
}

 


if ($_GET['gNEN'] == "1") {
  $sel_nen = "1";
  $_SESSION['SELECT_NEN']=1;  
  $btn_type1 = "btn-primary";
  //$dis = "disabled";
  $dis = "";
  
  
} elseif ($_GET['gNEN'] == "2") {
  $sel_nen = "2";
  $_SESSION['SELECT_NEN']=2;  
  $btn_type2 = "btn-primary";
  $dis = "";
  

} elseif ($_GET['gNEN'] == "3") {
  $sel_nen = "3";
  $_SESSION['SELECT_NEN']=3;  
  $btn_type3 = "btn-primary";
  $dis = "";
} elseif ($_GET['gNEN'] == "4") {
  $sel_nen = "4";
  $_SESSION['SELECT_NEN']=4;  
  $btn_type4 = "btn-primary";
  $dis = "";
}






tbl_profile_nen_set($_SESSION['STUDENT_NUMBER'],$sel_nen);
tbl_status_check($_SESSION['STUDENT_NUMBER'], $sel_nen);




dsip_midashi("学修計画・リフレクション・シート　シート選択");

?>


<div class="kakomi my-4">
<br>
  <?php
  dsip_midashi("年次選択　〈" . $_GET['gNEN'] . "年次〉");
  ?>

  <div class="btn-group">
    <a class="btn <?php echo $btn_type1; ?>" href="select_sheet.php?gNEN=1">1年次</a>
    <a class="btn <?php echo $btn_type2; ?>" href="select_sheet.php?gNEN=2">2年次</a>
    <a class="btn <?php echo $btn_type3; ?>" href="select_sheet.php?gNEN=3">3年次</a>
    <a class="btn <?php echo $btn_type4; ?>" href="select_sheet.php?gNEN=4">4年次</a>
  </div>


  <?php
  dsip_koumoku("プロフィール・シート");
  ?>


  <div class="row">
    <div class="col-5">
     
    <table class="table table-bordered border-secondary">
        <tr>
          <td class="text-center align-middle"><span class="fw600">通年</span></td>
          <td class="text-center align-middle"><span class="fw600">提出状況</span></td>
          <td class="text-center align-middle"><span class="fw600">詳細</span></td>
        </tr>
        <tr>
          <td width="20%" class="text-center align-middle"><span class="fw600"><?php echo $_GET['gNEN']."年次"; ?></span></td>
          <td width="40%" class="text-center align-middle text-Success">
            <?php
            echo $mr[$sta_prof];
            ?>
          </td>
          <td width="40%" class="text-center">
            <!--シートをしている-->
            <form action='sheet_profile.php' method='post'>
              <input type='hidden' name='select_nen' value="<?PHP echo $_GET['gNEN']; ?>">
              <button type='submit' class='btn btn-success'>詳細</button>
            </form>
          </td>
        </tr>
      </table>
    </div>
  </div>



  <?php


  dsip_koumoku("ゴール・シート");
  ?>

  <div class="row">
    <div class="col-8">
      <table class="table table-bordered border-secondary">
        <tr>
          <td class="text-center align-middle"><span class="fw600">通年</span></td>
          <td colspan="2" class="text-center align-middle"><span class="fw600">「進級時の大学卒業後の自分」1Q</span></td>
          <td colspan="2" class="text-center align-middle"><span class="fw600">「大学卒業後の自分」4Q</span></td>
        </tr>

        <tr>
          <td width="12%" class="text-center align-middle"><span class="fw600"><?php echo $_GET['gNEN']; ?></span></td>
          <td width="20%" class="text-center text-Success align-middle">
            <?php
            echo $mr[$sta_go1Q];
            ?>

          </td>
          <td width="20%" class="text-center align-middle">
            <form action='sheet_goal1Q.php' method='post'>
              <input type='hidden' name='ID' value="<?PHP echo $value['id'];; ?>">
              <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
              <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
              <button type='submit' class='btn btn-success'>詳細</button>
            </form>
          </td>

          <td width="20%" class="text-center align-middle">
            <?php
            echo $mr[$sta_go4Q];

            ?>
          </td>
          <td width="20%" class="text-center align-middle">
            <form action='sheet_goal4Q.php' method='post'>
              <input type='hidden' name='ID' value="<?PHP echo $value['id'];; ?>">
              <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
              <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
              <button type='submit' class='btn btn-success'>詳細</button>
            </form>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <?php
  dsip_koumoku("リフレクション・シート");
  ?>

  <div class="row">
    <div class="col-5">
      <table class="table table-bordered border-secondary">
        <tr>
          <td class="text-center align-middle"><span class="fw600">通年</span></td>
          <td class="text-center align-middle"><span class="fw600">提出状況</span></td>
          <td class="text-center align-middle"><span class="fw600">詳細</span></td>
        </tr>
        <tr>
          <td width="20%" class="text-center align-middle"><span class="fw600"><?php echo $_GET['gNEN']; ?></span></td>
          <td width="40%" class="text-center text-Success align-middle">
            <?php
            
            echo $mr[$sta_rbas];

            ?>
          </td>
          <td width="40%" class="text-center align-middle">
            <!--シートをしている-->

            <form action='sheet_ref_base.php' method='post'>
              <input type='hidden' name='select_nen' value="<?PHP echo $_GET['gNEN']; ?>">
              <button type='submit' class='btn btn-success'>詳細</button>
            </form>
          </td>
        </tr>
      </table>
    </div>


  </div>
</div>


<?php
dsip_koumoku("実習リフレクション・シート");


//ここからは実習計画表の作成状態
$sta = $GLOBALS['sta_ssw1'];
$sta = $GLOBALS['sta_ssw2'];
$sta = $GLOBALS['sta_smental1'];
$sta = $GLOBALS['sta_smental2'];

$sta = $GLOBALS['sta_sadv'];
//ここからは自己評価表の作成状態
$sta = $GLOBALS['sta_jsw1']; //SW1自己評価
$sta = $GLOBALS['sta_jsw2']; //SW2自己評価
$sta = $GLOBALS['sta_jmental1'];
$sta = $GLOBALS['sta_jmental2'];
$sta = $GLOBALS['sta_jadv'];

?>

<div class="row">
  <div class="col-8">

    <table class="table table-bordered border-secondary">
      <tr>
        <td width="40%" class="text-center align-middle"><span class="fw600">ソーシャルワーク実習Ⅰ</span><br>（2年次）</td>
        <td width="20%" class="text-center text-Danger align-middle">
          <?php

        $dis = "disabled";
        if ($_SESSION['SELECT_NEN']==2) {
          $dis ="";
        }

          echo $mr[$sta_rsw1];
          ?>
        </td>
        <td width="20%" class="text-center align-middle">
          <form action='sheet_ref_intern.php' method='post'>
            <input type='hidden' name='SHEET_TITLE' value="ソーシャルワーク実習Ⅰ">
            <input type='hidden' name='ID' value="<?PHP echo $value['id'];?>">
            <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
            <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">

                
                <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>

          </form>
        </td>

      <tr>
      <tr>
        <td class="text-center align-middle"><span class="fw600">ソーシャルワーク実習Ⅱ</span><br>（3年次 or 4年次）</td>


        <td class="text-center text-Danger align-middle">
          <?php
          
echo $mr[$sta_rsw2];


        $dis = "disabled";
        if (($_SESSION['SELECT_NEN']==3) or ($_SESSION['SELECT_NEN']==4)) {
          $dis ="";
        }


          ?>
        </td>

        <td class="text-center">
          <form action='sheet_ref_intern.php' method='post'>
            <input type='hidden' name='SHEET_TITLE' value="ソーシャルワーク実習Ⅱ">
            <input type='hidden' name='ID' value="<?PHP echo $value['id']; ?>">
            <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
            <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
            <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>
          </form>
        </td>

      <tr>
      <tr>
        <td class="text-center align-middle"><span class="fw600">インターンシップⅠ</span><br>（2年次）</td>
        <td class="text-center text-Danger align-middle">
          <?php
          
        $dis = "disabled";
        if ($_SESSION['SELECT_NEN']==2) {
          $dis ="";
        }

echo $mr[$sta_rintern];
          ?>
        </td>

        <td class="text-center">
          <form action='sheet_ref_intern.php' method='post'>
            <input type='hidden' name='SHEET_TITLE' value="インターンシップⅠ">
            <input type='hidden' name='ID' value="<?PHP echo $value['id']; ?>">
            <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
            <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
            <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>
          </form>
        </td>

      </tr>
      <tr>
        <td class="text-center align-middle"><span class="fw600">精神実習Ⅰ（単独）/インターンシップⅡ</span><br>（3年次）</td>
        <td class="text-center text-Danger align-middle">
          <?php
        $dis = "disabled";
        if ($_SESSION['SELECT_NEN']==3) {
          $dis ="";
        }
  
echo $mr[$sta_rmental1];
          ?>
        </td>

        <td class="text-center">
          <form action='sheet_ref_intern.php' method='post'>
            <input type='hidden' name='ID' value="<?PHP echo $value['id']; ?>">
            <input type='hidden' name='SHEET_TITLE' value="精神実習Ⅰ（単独）/インターンシップⅡ">

            <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
            <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
            <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>
          </form>
        </td>

      </tr>
      <tr>


        <td class="text-center align-middle"><span class="fw600">アドバンス・クラス/精神実習Ⅱ（単独）</span><br>（4年次）</td>

        <td class="text-center text-Danger align-middle">
          <?php

        $dis = "disabled";
        if ($_SESSION['SELECT_NEN']==4) {
          $dis ="";
        }
echo $mr[$sta_radv];
          ?>
        </td>

        <td class="text-center">
          <form action='sheet_ref_intern.php' method='post'>
            <input type='hidden' name='SHEET_TITLE' value="アドバンス・クラス/精神実習Ⅱ（単独）">
            <input type='hidden' name='ID' value="<?PHP echo $value['id']; ?>">
            <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
            <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
            <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>
          </form>
        </td>
      </tr>
    </table>
  </div>
</div>



<table class="table">
  <tr>
    <td>
      <?php btn_return("index.php", "戻る"); ?>
    </td>
  </tr>
</table>

<?PHP

require('./disp_parts/footer.php');
exit;
?>