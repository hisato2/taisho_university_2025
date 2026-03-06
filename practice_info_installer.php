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
$ACTION = "practice_info.php";
require('./disp_parts/headerjs.php');

//////////何年度の表の提出状況を表示するか

tbl_instructor_READ($_POST['法人ID']);


$施設区分 = $_POST['施設区分'];
$法人名 = $_POST['法人名'];
$施設名 = $_POST['施設名'];

dsip_midashi("実習指導者情報");

form_submit("registration.php");


?>


<table class="table table-bordered border-secondary">



  <tr>
    <td width="20%" class="text-left align-middle"><span class="fw600">施設区分</span></td>
    <td width="80%"><?php _inputv("施設区分", $施設区分, "text", "", "", ""); ?></td>
  </tr>
  <tr>
    <td width="20%" class="text-left align-middle"><span class="fw600">法人名</span></td>
    <td width="80%"><?php _inputv("法人名", $法人名, "text", "", "", ""); ?></td>
  </tr>

  <tr>
    <td class="text-left align-middle"><span class="fw600">施設名</span></td>
    <td><?php _inputv("施設名", $施設名, "text", "", "", ""); ?></td>
  </tr>
</table>


<h5>実習指導者1</h5>

<table class="table table-bordered border-secondary">

  <tr>
    <td width="20%" class="text-center align-middle"><span class="fw600">項目</span></td>
    <td width="26.6%" class="text-center align-middle"><span class="fw600">指導者①</span></td>
    <td width="26.6%" class="text-center align-middle"><span class="fw600">指導者②</span></td>
    <td width="26.6%" class="text-center align-middle"><span class="fw600">指導者③</span></td>
  </tr>


  <tr>
    <td class="text-left align-middle"><span class="fw600">氏名</span></td>
    <td><?php _inputv("氏名1", $氏名1, "text", "edit", "", ""); ?></td>
    <td><?php _inputv("氏名2", $氏名2, "text", "edit", "", ""); ?></td>
    <td><?php _inputv("氏名3", $氏名3, "text", "edit", "", ""); ?></td>
  </tr>


  <tr>
    <td class="text-left align-middle"><span class="fw600">講習会修了日</span></td>
    <td><input name="講習会修了日1" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $講習会修了日1; ?> style="width:150px"></td>
    <td><input name="講習会修了日2" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $講習会修了日2; ?> style="width:150px"></td>
    <td><input name="講習会修了日3" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $講習会修了日3; ?> style="width:150px"></td>


  </tr>

  <tr>
    <td class="text-left align-middle"><span class="fw600">実習指導者提出年月日</span></td>


    <td><input name="提出年月日1" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $提出年月日1; ?> style="width:150px"></td>
    <td><input name="提出年月日2" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $提出年月日2; ?> style="width:150px"></td>
    <td><input name="提出年月日3" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $提出年月日3; ?> style="width:150px"></td>

  </tr>

  <tr>
    <td class="text-left align-middle"><span class="fw600">調書の有無・資格区分</span></td>
    <td><?php _inputv("調書資格1", $調書資格1, "text", "edit", "", ""); ?></td>
    <td><?php _inputv("調書資格2", $調書資格2, "text", "edit", "", ""); ?></td>
    <td><?php _inputv("調書資格3", $調書資格3, "text", "edit", "", ""); ?></td>
  </tr>


  <tr>
    <td class="text-left align-middle"><span class="fw600">在籍確認：在籍：○　非在籍：×</span></td>
    <td><?php _inputv("在籍確認1", $在籍確認1, "text", "edit", "", ""); ?></td>
    <td><?php _inputv("在籍確認2", $在籍確認2, "text", "edit", "", ""); ?></td>
    <td><?php _inputv("在籍確認3", $在籍確認3, "text", "edit", "", ""); ?></td>
  </tr>

  <tr>
    <td class="text-left align-middle"><span class="fw600">異動日</span></td>

    <td><input name="異動日1" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $異動日1; ?> style="width:150px"></td>
    <td><input name="異動日2" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $異動日2; ?> style="width:150px"></td>
    <td><input name="異動日3" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $異動日3; ?> style="width:150px"></td>



  </tr>

  <tr>
    <td class="text-left align-middle"><span class="fw600">異動理由</span></td>
    <td><?php _inputv("理由1", $理由1, "textarea", "edit", "h200", "255"); ?></td>
    <td><?php _inputv("理由2", $理由2, "textarea", "edit", "h200", "255"); ?></td>
    <td><?php _inputv("理由3", $理由3, "textarea", "edit", "h200", "255"); ?></td>
  </tr>


  <tr>
    <td class="text-left align-middle"><span class="fw600">確認日</span></td>
    <td><input name="確認日1" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $確認日1; ?> style="width:150px"></td>
    <td><input name="確認日2" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $確認日2; ?> style="width:150px"></td>
    <td><input name="確認日3" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $確認日3; ?> style="width:150px"></td>
  </tr>

  <input type="hidden" value="off" name="delete1">
  <input type="hidden" value="off" name="delete2">
  <input type="hidden" value="off" name="delete3">
  <tr>
    <td class="text-left align-middle"><span class="fw600">備考</span></td>
    <td><?php _inputv("備考1", $備考1, "textarea", "edit", "h200", "255"); ?></td>
    <td><?php _inputv("備考2", $備考2, "textarea", "edit", "h200", "255"); ?></td>
    <td><?php _inputv("備考3", $備考3, "textarea", "edit", "h200", "255"); ?></td>
  </tr>

  <tr>
    <td class="text-left align-middle"><span class="fw600">削除の場合はチェック</span></td>
    <td>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="on" name="delete1">
        <label class="form-check-label" for="flexCheckDefault">
          削除する
        </label>
      </div>
    </td>
    <td>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="on" name="delete2">
        <label class="form-check-label" for="flexCheckDefault">
          削除する
        </label>
      </div>
    </td>
    <td>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="on" name="delete3">
        <label class="form-check-label" for="flexCheckDefault">
          削除する
        </label>
      </div>
    </td>
  </tr>


</table>
<input type='hidden' name='TABLE' value="tbl_instructor">
<input type='hidden' name='METHOD' value="UP_DATE">
<input type='hidden' name='法人ID' value="<?php echo $_POST['法人ID']; ?>">


<table class="table">
  <tr>
    <td>
      <?php btn_submit("登録", "", ""); ?>
    </td>
    <td>
      <?php btn_return("practice_info.php", "戻る"); ?>
    </td>
  </tr>
</table>

<?PHP

require('./disp_parts/footer.php');
exit;
?>