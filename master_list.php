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

require_once('./files/config_db_taisho2025.php');
require_once('./common/function.php');

$ACTION="index.php";

require('./disp_parts/headerNon.php');


//////////何年度の表の提出状況を表示するか
?>
<div class="row">


  <div class="col-3">
  </div>

  <div class="col-6">
    <?php
    dsip_midashi("マスターリスト");

    $student_number = "";

    ?>

<table class="table table-striped">


      <tr>
        <td>プロフィール・テーブル </td>
        <td>
          <form action='master_disp.php' method='post'>
        <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_profile">
          <input type='hidden' name='table_title' value="プロフィール・テーブル">
          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>


      <tr>
        <td>プロフィール詳細テーブル </td>
        <td>
          <form action='master_disp.php' method='post'>
        <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_profile_detail">
          <input type='hidden' name='table_title' value="プロフィール詳細テーブル">
          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>


      <tr>
        <td>配属情報テーブル</td>
        <td>
          <form action='master_disp.php' method='post'>
        <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_assignment">
          <input type='hidden' name='table_title' value="配属情報テーブル">
          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>




      <tr>
        <td>ゴール・シート(1q) </td>
        <td>
          <form action='master_disp.php' method='post'>
          <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_goal_sheet_1q">
          <input type='hidden' name='table_title' value="ゴール・シート(1q) ">
          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>



      <tr>
        <td>ゴール・シート(4q)</td>
        <td>
          <form action='master_disp.php' method='post'>
        <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_goal_sheet_4q">
          <input type='hidden' name='table_title' value="ゴール・シート(4q)">

          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>



      <tr>
        <td>施設情報テーブル</td>
        <td>
          <form action='master_disp.php' method='post'>
        <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_institution">
          <input type='hidden' name='table_title' value="施設情報テーブル">

          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>



      <tr>
        <td>施設概要テーブル</td>
        <td>
          <form action='master_disp.php' method='post'>
        <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_institution_overview">
          <input type='hidden' name='table_title' value="施設概要テーブル">

          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>


      <tr>
        <td>指導者テーブル</td>
        <td>
          <form action='master_disp.php' method='post'>
        <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_instructor">
          <input type='hidden' name='table_title' value="指導者テーブル">

          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>


      <tr>
        <td>実習計画テーブル</td>
        <td>
          <form action='master_disp.php' method='post'>
        <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_practice_plan">
          <input type='hidden' name='table_title' value="実習計画テーブル">

          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>



      <tr>
        <td>学修リフレクション・テーブル</td>
        <td>
          <form action='master_disp.php' method='post'>
        <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_reflection_base">
          <input type='hidden' name='table_title' value="学修リフレクション・テーブル">

          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>



      <tr>
        <td>実習リフレクション・テーブル</td>
        <td>
          <form action='master_disp.php' method='post'>
        <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_reflection_intern">
          <input type='hidden' name='table_title' value="実習リフレクション・テーブル">

          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>



      <tr>
        <td>実習自己評価表</td>
        <td>
          <form action='master_disp.php' method='post'>
        <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_self_assessment">
          <input type='hidden' name='table_title' value="実習自己評価表">

          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>



      <tr>
        <td>学生紹介テーブル</td>
        <td>
          <form action='master_disp.php' method='post'>
        <td class="text-center align-middle">
          <input type='hidden' name='table_name' value="tbl_student_introduction">
          <input type='hidden' name='table_title' value="学生紹介テーブル">

          <button type='submit' class='btn btn-outline-primary btn-sm'>詳細</button>
        </td>
        </form>
        </td>
      </tr>


    </table>



  </div>

  <div class="col-3">
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