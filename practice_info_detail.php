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

$ACTION="practice_info.php";

require('./disp_parts/headerjs.php');

//////////何年度の表の提出状況を表示するか



tbl_institution_READ($_POST['法人ID']);


dsip_midashi("実習機関情報（詳細）");

form_submit("registration.php");


?>

<table class="table table-bordered border-secondary">
  <tr>
    <td width="80px" class="text-left align-middle"><span class="fw600">施設区分</span></td>
    <td  ><?php _inputv("施設区分", $施設区分, "text", "required", "", ""); ?></td>
    <td width="80px" class="text-left align-middle"><span class="fw600">法人名</span></td>
    <td  ><?php _inputv("法人名", $法人名, "text", "required", "", ""); ?></td>
    <td width="80px" class="text-left align-middle"><span class="fw600">施設名</span></td>
    <td ><?php _inputv("施設名", $施設名, "text", "required", "", ""); ?></td>
  </tr>
</table>


<table class="table table-bordered border-secondary">


  <tr>
    <td width="20%" class="text-left align-middle"><span class="fw600">実習種別1</span></td>
    <td width="30%">
                        <?php
                        $sel0 = "";
                        $sel1 = "";
                        $sel2 = "";
                        $sel3 = "";
                        $sel4 = "";
                        $sel5 = "";

                        if ($実習種別1 == 'ソーシャルワーク実習Ⅰ') {
                            $sel1 = "selected";
                        } elseif ($実習種別1== 'ソーシャルワーク実習Ⅱ') {
                            $sel2 = "selected";
                        } elseif ($実習種別1 == '精神保健福祉援助実習Ⅰ') {
                            $sel3 = "selected";
                        } elseif ($実習種別1 == '精神保健福祉援助実習Ⅱ') {
                            $sel4 = "selected";
                        } else {
                            $sel0 = "selected";
                        }
                        ?>
                        <select class="form-select" aria-label="Default select example" name="実習種別1">
                            <option <?php echo $sel0; ?>>選択してください</option>
                            <option <?php echo $sel1; ?> value="ソーシャルワーク実習Ⅰ"><?PHP echo "ソーシャルワークⅠ"; ?></option>
                            <option <?php echo $sel2; ?> value="ソーシャルワーク実習Ⅱ"><?PHP echo "ソーシャルワークⅡ"; ?></option>
                            <option <?php echo $sel3; ?> value="精神保健福祉援助実習Ⅰ"><?PHP echo "精神保健福祉援助Ⅰ"; ?></option>
                            <option <?php echo $sel4; ?> value="精神保健福祉援助実習Ⅱ"><?PHP echo "精神保健福祉援助Ⅱ"; ?></option>
                        </select>



</td>

    <td width="20%" class="text-left align-middle"><span class="fw600">実習種別1実日数（日）</span></td>
    <td width="30%"><?php _inputv("実習種別1実日数", $実習種別1実日数, "text",  "edit", "", ""); ?></td>
  </tr>


  <tr>
    <td class="text-left align-middle"><span class="fw600">実習種別2</span></td>
    <td>
                        <?php
                        $sel0 = "";
                        $sel1 = "";
                        $sel2 = "";
                        $sel3 = "";
                        $sel4 = "";
                        $sel5 = "";

                        if ($実習種別2 == 'ソーシャルワーク実習Ⅰ') {
                            $sel1 = "selected";
                        } elseif ($実習種別2 == 'ソーシャルワーク実習Ⅱ') {
                            $sel2 = "selected";
                        } elseif ($実習種別2 == '精神保健福祉援助実習Ⅰ') {
                            $sel3 = "selected";
                        } elseif ($実習種別2 == '精神保健福祉援助実習Ⅱ') {
                            $sel4 = "selected";
                        } else {
                            $sel0 = "selected";
                        }
                        ?>
                        <select class="form-select" aria-label="Default select example" name="実習種別2">
                            <option <?php echo $sel0; ?>>選択してください</option>
                            <option <?php echo $sel1; ?> value="ソーシャルワーク実習Ⅰ"><?PHP echo "ソーシャルワークⅠ"; ?></option>
                            <option <?php echo $sel2; ?> value="ソーシャルワーク実習Ⅱ"><?PHP echo "ソーシャルワークⅡ"; ?></option>
                            <option <?php echo $sel3; ?> value="精神保健福祉援助実習Ⅰ"><?PHP echo "精神保健福祉援助Ⅰ"; ?></option>
                            <option <?php echo $sel4; ?> value="精神保健福祉援助実習Ⅱ"><?PHP echo "精神保健福祉援助Ⅱ"; ?></option>
                        </select>
    </td>
    <td class="text-left align-middle"><span class="fw600">実習種別2実日数（日）</span></td>
    <td><?php _inputv("実習種別2実日数", $実習種別2実日数, "text", "edit", "", ""); ?></td>
  </tr>


</table>


<table class="table table-bordered border-secondary">
  <tr>
    <td width="20%" class="text-left align-middle"><span class="fw600">施設種別</span></td>
    <td width="30%"><?php _inputv("施設種別", $施設種別, "text", "required", "", ""); ?></td>
    <td width="20%" class="text-left align-middle"><span class="fw600">設置者又は経営者</span></td>
    <td width="30%"><?php _inputv("設置者又は経営者", $設置者又は経営者, "text", "required", "", ""); ?></td>
  </tr>

  <tr>
    <td class="text-left align-middle"><span class="fw600">管理者</span></td>
    <td><?php _inputv("管理者", $管理者, "text", "required", "", ""); ?></td>
    <td class="text-left align-middle"><span class="fw600">管理者役職名</span></td>
    <td><?php _inputv("管理者役職名", $管理者役職名, "text",  "edit", "", ""); ?></td>
  </tr>




  <tr>
    <td class="text-left align-middle"><span class="fw600">設置又は開始の年月日</span></td>
    <td><input name="設置又は開始の年月日" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $設置又は開始の年月日;?>  style="width:150px"></td>
      <td class="text-left align-middle"><span class="fw600">実習施設提出年月日</span></td>
    <td><input name="実習施設提出年月日" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習施設提出年月日;?>  style="width:150px"></td>

  </tr>

</table>

<table class="table table-bordered border-secondary">

  <tr>
    <td class="text-left align-middle"><span class="fw600">承諾書記載受入人数</span></td>
    <td><?php _inputv("承諾書記載受入人数", $承諾書記載受入人数, "text",  "edit", "", ""); ?></td>
    <td class="text-left align-middle"><span class="fw600">当該年度の受入人数</span></td>
    <td><?php _inputv("当該年度の受入人数", $当該年度の受入人数, "text",  "edit", "", ""); ?></td>
    <td class="text-left align-middle"><span class="fw600">同時受入可能人数</span></td>
    <td><?php _inputv("同時受入可能人数", $同時受入可能人数, "text",  "edit", "", ""); ?></td>

  </tr>


</table>

<table class="table table-bordered border-secondary">


  <tr>

    <td width="80px" class="text-left align-middle"><span class="fw600">郵便番号</span></td>
    <td width="120px" ><?php _inputv("郵便番号", $郵便番号, "text", "edit", "", ""); ?></td>

    <td  width="80px" class="text-left align-middle"><span class="fw600">所在地</span></td>
    <td><?php _inputv("所在地", $所在地, "text",  "edit", "", ""); ?></td>
    <td width="80px" class="text-left align-middle"><span class="fw600">最寄駅</span></td>
    <td width="120px" ><?php _inputv("最寄駅", $最寄駅, "text", "edit", "", ""); ?></td>


  </tr>


</table>

<table class="table table-bordered border-secondary">


  <tr>
    <td class="text-left align-middle"><span class="fw600">電話番号</span></td>
    <td><?php _inputv("電話番号", $電話番号, "text", "edit", "",""); ?></td>
    <td class="text-left align-middle"><span class="fw600">FAX番号</span></td>
    <td><?php _inputv("FAX番号", $FAX番号, "text", "edit", "",""); ?></td>
  </tr>

  <tr>
    <td class="text-left align-middle"><span class="fw600">メールアドレス</span></td>
    <td><?php _inputv("MAIL", $MAIL, "text", "edit", "",""); ?></td>

    <td class="text-left align-middle"><span class="fw600">URL</span></td>
    <td><?php _inputv("URL", $URL, "text", "edit", "",""); ?></td>

  </tr>


</table>

<table class="tunagi table table-bordered border-secondary">



  <tr>
    <td class="text-left align-middle"><span class="fw600">実習窓口担当者名</span></td>
    <td><?php _inputv("実習窓口担当者名", $実習窓口担当者名, "text", "edit", "",""); ?></td>

    <td class="text-left align-middle"><span class="fw600">形態</span></td>
    <td><?php _inputv("形態", $形態, "text", "edit", "",""); ?></td>
    <td class="text-left align-middle"><span class="fw600">土日祝実習の有無</span></td>
    <td><?php _inputv("土日祝実習の有無", $土日祝実習の有無, "text", "edit", "",""); ?></td>
  </tr>



  <tr>
    <td class="text-left align-middle"><span class="fw600">日委託費</span></td>
    <td><?php _inputv("日委託費", $日委託費, "text", "edit", "",""); ?></td>
    <td class="text-left align-middle"><span class="fw600">総委託費</span></td>
    <td><?php _inputv("総委託費", $総委託費, "text", "edit", "",""); ?></td>
    <td class="text-left align-middle"><span class="fw600">実習委託費以外の費用</span></td>
    <td><?php _inputv("実習委託費以外の費用", $実習委託費以外の費用, "text", "edit", "",""); ?></td>

  </tr>




  <tr>


    <td class="text-left align-middle"><span class="fw600">今年度受入数</span></td>
    <td><?php _inputv("今年度受入数", $今年度受入数, "text", "edit", "",""); ?></td>

    <td class="text-left align-middle"><span class="fw600">昨年度受入数</span></td>
    <td><?php _inputv("昨年度受入数", $昨年度受入数, "text", "edit", "",""); ?></td>


    <td class="text-left align-middle"><span class="fw600">一昨年度受入数</span></td>
    <td><?php _inputv("一昨年度受入数", $一昨年度受入数, "text", "edit", "",""); ?></td>

  </tr>
</table>

<table class="tunagi table table-bordered border-secondary">
    <td width="20%" class="text-left align-middle"><span class="fw600">備考(512文字)</span></td>
    <td width="80%"><?php _inputv("備考", $備考,  "textarea", "edit",  "h200","512"); ?></td>
</table>



<table class="table table-bordered border-secondary">
  <tr>
    <td width="20%" class="text-left align-middle"><span class="fw600">特記事項(512文字)</span></td>
    <td width="80%"><?php _inputv("特記事項", $特記事項, "textarea", "edit", "h200","512"); ?></td>
  </tr>
</table>


<input type='hidden' name='TABLE' value="tbl_institution">
<input type='hidden' name='METHOD' value="UP_DATE">
<input type='hidden' name='法人ID' value="<?php echo $_POST['法人ID'];?>">

<table class="table">
  <tr>
    <td>
      <?php btn_submit2("登録","","");?>
   </td>
      <td>
      <?php

        IF ($_POST['法人ID']!="9999999999"){


              btn_submit2("法人削除","delete","");

        }



      ?>
   </td>
    <td>
      <?php btn_return("practice_info.php", "戻る"); ?>
    </td>




  </tr>
</table>

<?PHP


echo "</form>";


require('./disp_parts/footer.php');
exit;
?>