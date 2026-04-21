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

require('./disp_parts/headerNon.php');


/*require('header_w.php');*/

$student_number=$_SESSION['SEL_STUDENT_NUMBER'];

tbl_profile_READ($student_number);""

?><div class="pagebreak"></div><?php
dsip_midashi("個人情報");

?>

 <table class="table table-bordered border-secondary">

    <tr>
      <td width="200px" class="text-left align-middle"><span class="fw600">氏名</span></td>
      <td class="text-left align-top"><?php echo $name;?></td>
    </tr>
    <tr>
      <td  class="text-left align-middle"><span class="fw600">ふりがな</span></td>
      <td class="text-left align-top"><?php echo $kana;?></td>
    </tr>
    <tr>
      <td  class="text-left align-middle"><span class="fw600">現住所</span></td>
      <td class="text-left align-top"><?php echo $adresse;?></td>
    </tr>
    <tr>
      <td  class="text-left align-middle"><span class="fw600">現住所の最寄駅</span></td>
      <td class="text-left align-top"><?php echo $nearest_station;?></td>
    </tr>
    <tr>
      <td  class="text-left align-middle"><span class="fw600">最寄駅までの移動手段</span></td>
      <td class="text-left align-top"><?php echo $transportation;?></td>
    </tr>
    <tr>
      <td  class="text-left align-middle"><span class="fw600">最寄駅までの移動時間</span></td>
      <td class="text-left align-top"><?php echo $travel_time;?></td>
    </tr>
    <tr>
      <td  class="text-left align-middle"><span class="fw600">帰省先住所</span></td>
      <td class="text-left align-top"><?php echo $hometown;?></td>
    </tr>

    <tr>
      <td  class="text-left align-middle"><span class="fw600">電話番号</span></td>
      <td class="text-left align-top"><?php echo  $tel;?></td>
    </tr>

    <tr>
      <td  class="text-left align-middle"><span class="fw600">メールアドレス</span></td>
      <td class="text-left align-top"><?php echo $email;?></td>
    </tr>

</table>


<div class="pagebreak"></div>


  <table class="table">
    <tr>
      <td>
        <?php btn_return("student_list.php", "戻る"); ?>
      </td>
    </tr>
  </table>

  <?PHP







require('./disp_parts/footer.php');
exit;
?>