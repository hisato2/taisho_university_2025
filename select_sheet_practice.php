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
tbl_status_check($_SESSION['STUDENT_NUMBER'], "3"); //年は必要ない




?>


<?php
dsip_midashi("実習記録・自己評価シート選択");
$student_number = "";
?>


<?php



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


$dis = "";

?>

<div class="row">
  <div class="col-10">

    <table class="table table-bordered border-secondary">
      <tr>
        <td class="text-center fw600">実習種別</td>
        <td class="text-center fw600">法人名</td>
        <td class="text-center fw600">施設名</td>
        <td colspan="2" class="text-center fw600">
              実習計画書
        </td>
        <td colspan="2" class="text-center fw600">
              自己評価表
        </td>
      <tr>

        <?php $cnt = tbl_assignment_check($_SESSION['STUDENT_NUMBER'], "ソーシャルワーク実習Ⅰ"); ?>

      <tr>
        <td class="text-center"><span class="fw600">ソーシャルワーク実習Ⅰ</span></td>
        <td class="text-center"><span class="fw600"><?php echo $法人名; ?></span></td>
        <td class="text-center"><span class="fw600"><?php echo $施設名; ?></span></td>

        <?php
        if ($cnt > 0) {



        ?>


        <td class="text-center text-Danger" width="100px">
          <?php
          echo $mr[$sta_ssw1];
          ?>
        </td>

        <td class="text-center">
          <form action='sheet_practice_plan.php' method='post'>
            <input type='hidden' name='title' value="ソーシャルワーク実習Ⅰ">
            <input type='hidden' name='column' value="sch_sw1">
            <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
            <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
            <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>
          </form>
        </td>
        <td class="text-center text-Danger" width="100px">
          <?php
          echo $mr[$sta_jsw1];
          ?>
        </td>

        <td class="text-center">
          <form action='sheet_self_assessment.php' method='post'>
            <input type='hidden' name='title' value="ソーシャルワーク実習Ⅰ">
            <input type='hidden' name='column' value="self_sw1">
            <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
            <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
            <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>

          </form>
        </td>

<?php



        } else {
                   echo "<td></td><td></td><td></td><td><br><br></td>";

        }
        ?>
      </tr>








        <?php $cnt = tbl_assignment_check($_SESSION['STUDENT_NUMBER'], "ソーシャルワーク実習Ⅱ"); ?>
      <tr>
        <td width="40%" class="text-center"><span class="fw600">ソーシャルワーク実習Ⅱ</span></td>
        <td class="text-center"><span class="fw600"><?php echo $法人名; ?></span></td>
        <td class="text-center"><span class="fw600"><?php echo $施設名; ?></span></td>

        <?php
        if ($cnt > 0) {
        ?>
        <td class="text-center text-Danger">
          <?php

          echo $mr[$sta_ssw2];
          ?>
        </td>

        <td class="text-center">
          <form action='sheet_practice_plan.php' method='post'>
            <input type='hidden' name='title' value="ソーシャルワーク実習Ⅱ">
            <input type='hidden' name='column' value="sch_sw2">
            <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
            <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
            <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>
          </form>
        </td>
        <td class="text-center text-Danger">
          <?php
          echo $mr[$sta_jsw2];
          ?>
        </td>

        <td class="text-center">
          <form action='sheet_self_assessment.php' method='post'>
            <input type='hidden' name='title' value="ソーシャルワーク実習Ⅱ">
            <input type='hidden' name='column' value="self_sw2">
            <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
            <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
            <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>

          </form>
        </td>
      <?php
        } else {
                  echo "<td></td><td></td><td></td><td><br><br></td>";

        }
      ?>
      </tr>






      <?php $cnt = tbl_assignment_check($_SESSION['STUDENT_NUMBER'], "精神保健福祉援助実習Ⅰ"); ?>
    
      <tr>
        <td class="text-center"><span class="fw600">精神保健福祉援助実習Ⅰ</span></td>
        <td class="text-center"><span class="fw600"><?php echo $法人名; ?></span></td>
        <td class="text-center"><span class="fw600"><?php echo $施設名; ?></span></td>

        <?php
        if ($cnt > 0) {
        ?>
          <td class="text-center text-Danger">
            <?php
            echo $mr[$sta_smental1];
            ?>
          </td>
          <td class="text-center">
            <form action='sheet_practice_plan.php' method='post'>
              <input type='hidden' name='title' value="精神保健福祉援助実習Ⅰ">
              <input type='hidden' name='column' value="sch_mental1">
              <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
              <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">

              <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>
            </form>
          </td>
          <td class="text-center text-Danger">
            <?php
            echo $mr[$sta_jmental1];
            ?>
          </td>

          <td class="text-center">
            <form action='sheet_self_assessment.php' method='post'>
              <input type='hidden' name='title' value="精神保健福祉援助実習Ⅰ">
              <input type='hidden' name='column' value="self_mental1">
              <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
              <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
              <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>
            </form>
          </td>

        <?php

        } else {
                  echo "<td></td><td></td><td></td><td><br><br></td>";

        }
        ?>

      </tr>
      <?php $cnt = tbl_assignment_check($_SESSION['STUDENT_NUMBER'], "精神保健福祉援助実習Ⅱ"); ?>

      <tr>
        <td class="text-center"><span class="fw600">精神保健福祉援助実習Ⅱ</span></td>
        <td class="text-center"><span class="fw600"><?php echo $法人名; ?></span></td>
        <td class="text-center"><span class="fw600"><?php echo $施設名; ?></span></td>

        <?php
        if ($cnt > 0) {
        ?>

          <td class="text-center text-Danger">
            <?php
            echo $mr[$sta_smental2];
            ?>
          </td>

          <td class="text-center">
            <form action='sheet_practice_plan.php' method='post'>
              <input type='hidden' name='title' value="精神保健福祉援助実習Ⅱ">
              <input type='hidden' name='column' value="sch_mental2">
              <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
              <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
              <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>
            </form>
          </td>

          <td class="text-center text-Danger">
            <?php
            echo $mr[$sta_jmental2];
            ?>
          </td>

          <td class="text-center">
            <form action='sheet_self_assessment.php' method='post'>
              <input type='hidden' name='title' value="精神保健福祉援助実習Ⅱ">
              <input type='hidden' name='column' value="self_mental2">
              <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
              <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
              <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>
            </form>
          </td>

        <?php

        } else {
          echo "<td></td><td></td><td></td><td><br><br></td>";
        }
        ?>
      </tr>



      <?php $cnt = tbl_assignment_check($_SESSION['STUDENT_NUMBER'], "アドバンス・クラス実習"); ?>
      <tr>
        <td class="text-center"><span class="fw600">アドバンス・クラス実習</span></td>
        <td class="text-center"><span class="fw600"><?php echo $法人名; ?></span></td>
        <td class="text-center"><span class="fw600"><?php echo $施設名; ?></span></td>
        <?php
        if ($cnt > 0) {
        ?>


          <td class="text-center text-Danger">
            <?php
            echo $mr[$sta_sadv];
            ?>
          </td>

          <td class="text-center">
            <form action='sheet_practice_plan.php' method='post'>
              <input type='hidden' name='title' value="アドバンス・クラス実習">
              <input type='hidden' name='column' value="sch_advance">
              <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
              <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
              <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>
            </form>
          </td>


          <td class="text-center text-Danger"><?php echo $mr[$sta_jadv]; ?></td>
          <td class="text-center">
            <form action='sheet_self_assessment.php' method='post'>
              <input type='hidden' name='title' value="アドバンス・クラス実習">
              <input type='hidden' name='column' value="self_advance">
              <input type='hidden' name='student_number' value="<?PHP echo $value['student_number']; ?>">
              <input type='hidden' name='name' value="<?PHP echo $value['name']; ?>">
              <button type='submit' class='btn btn-success' <?PHP echo $dis; ?>>詳細</button>
            </form>
          </td>


        <?php
        } else {
                  echo "<td></td><td></td><td></td><td><br><br></td>";

        }
        ?>

      </tr>

    </table>







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