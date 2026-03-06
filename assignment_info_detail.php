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
$ACTION = "assignment_info.php";

require('./disp_parts/headerjs.php');

//////////何年度の表の提出状況を表示するか
$法人ID = $_POST['法人ID'];
$事業年度 = $_POST['事業年度'];


tbl_assignment_READ($法人ID, $事業年度);


tbl_instructor_READ2($法人ID);



dsip_midashi("配属情報詳細");

form_submit("registration.php");


?>

<table class="table table-bordered border-secondary">
    <tr>
        <td width="80px" class="text-left align-middle"><span class="fw600">事業年度</span></td>
        <td><?php echo  $事業年度; ?></td>
    </tr>
</table>
<table class="table table-bordered border-secondary">
    <tr>
        <td width="80px" class="text-left align-middle"><span class="fw600">法人名</span></td>
        <td width="300px"><?php _inputv("法人名", $法人名, "text", "edit", "", "48"); ?></td>
        <td width="80px" class="text-left align-middle"><span class="fw600">施設名</span></td>
        <td><?php _inputv("施設名", $施設名, "text", "edit", "", "48"); ?></td>
    </tr>
    <tr>
        <td class="text-left align-middle"><span class="fw600">施設区分</span></td>
        <td><?php _inputv("施設区分", $施設区分, "text", "edit", "", ""); ?></td>
        <td class="text-left align-middle"><span class="fw600">施設種別</span></td>
        <td><?php _inputv("施設種別", $施設種別, "text", "edit", "", ""); ?></td>
    </tr>

    <tr>
        <td class="text-left align-middle"><span class="fw600">実習種別1</span></td>
        <td><?php _inputv("施設実習種別1", $施設実習種別1, "text", "edit", "", ""); ?></td>
        <td class="text-left align-middle"><span class="fw600">実習種別2</span></td>
        <td><?php _inputv("$施設実習種別2", $施設実習種別2, "text", "edit", "", ""); ?></td>
    </tr>



    <tr>
        <td class="text-left align-middle"><span class="fw600">管理者</span></td>
        <td><?php _inputv("管理者", $管理者, "text", "edit", "", ""); ?></td>
        <td class="text-left align-middle"><span class="fw600">役職</span></td>
        <td><?php _inputv("管理者役職名", $管理者役職名, "text", "edit", "", ""); ?></td>


    </tr>

    <tr>
        <td class="text-left align-middle"><span class="fw600">郵便番号</span></td>
        <td><?php _inputv("郵便番号", $郵便番号, "text", "edit", "", ""); ?></td>

        <td class="text-left align-middle"><span class="fw600">所在地</span></td>
        <td><?php _inputv("所在地", $所在地, "text", "edit", "", ""); ?></td>

    </tr>
</table>

<table class="table table-bordered border-secondary">

    <tr>
        <td class="text-left align-middle"><span class="fw600">実習窓口担当者名</span></td>
        <td><?php _inputv("実習窓口担当者名", $実習窓口担当者名, "text", "edit", "", ""); ?></td>
        <td class="text-left align-middle"><span class="fw600">実習指導者</span></td>
        <td><?php _inputv("実習指導者1", $指導者1, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("実習指導者2", $指導者2, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("実習指導者3", $指導者3, "text", "edit", "", ""); ?></td>
    </tr>
</table>


<h5>配属学生</h5>
<table class="table table-bordered border-secondary">

    <tr>
        <td width="12%" class="text-lrdt align-middle"><span class="fw600">実習種別</span></td>
        <td width="17.6%">

            <?php
            $sel0 = "";
            $sel1 = "";
            $sel2 = "";
            $sel3 = "";
            $sel4 = "";
            $sel5 = "";

            if ($実習種別1 == 'ソーシャルワーク実習Ⅰ') {
                $sel1 = "selected";
            } elseif ($実習種別1 == 'ソーシャルワーク実習Ⅱ') {
                $sel2 = "selected";
            } elseif ($実習種別1 == '精神保健福祉援助実習Ⅰ') {
                $sel3 = "selected";
            } elseif ($実習種別1 == '精神保健福祉援助実習Ⅱ') {
                $sel4 = "selected";
            } elseif ($実習種別1 == 'アドバンス・クラス実習') {
                $sel5 = "selected";
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
                <option <?php echo $sel5; ?> value="アドバンス・クラス実習"><?PHP echo "アドバンス・クラス"; ?></option>
            </select>

        </td>
        <td width="17.6%">


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
            } elseif ($実習種別2 == 'アドバンス・クラス実習') {
                $sel5 = "selected";
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
                <option <?php echo $sel5; ?> value="アドバンス・クラス実習"><?PHP echo "アドバンス・クラス"; ?></option>
            </select>



        </td>
        <td width="17.6%">
            <?php
            $sel0 = "";
            $sel1 = "";
            $sel2 = "";
            $sel3 = "";
            $sel4 = "";
            $sel5 = "";

            if ($実習種別3 == 'ソーシャルワーク実習Ⅰ') {
                $sel1 = "selected";
            } elseif ($実習種別3 == 'ソーシャルワーク実習Ⅱ') {
                $sel2 = "selected";
            } elseif ($実習種別3 == '精神保健福祉援助実習Ⅰ') {
                $sel3 = "selected";
            } elseif ($実習種別3 == '精神保健福祉援助実習Ⅱ') {
                $sel4 = "selected";
            } elseif ($実習種別3 == 'アドバンス・クラス実習') {
                $sel5 = "selected";
            } else {
                $sel0 = "selected";
            }
            ?>
            <select class="form-select" aria-label="Default select example" name="実習種別3">
                <option <?php echo $sel0; ?>>選択してください</option>
                <option <?php echo $sel1; ?> value="ソーシャルワーク実習Ⅰ"><?PHP echo "ソーシャルワークⅠ"; ?></option>
                <option <?php echo $sel2; ?> value="ソーシャルワーク実習Ⅱ"><?PHP echo "ソーシャルワークⅡ"; ?></option>
                <option <?php echo $sel3; ?> value="精神保健福祉援助実習Ⅰ"><?PHP echo "精神保健福祉援助Ⅰ"; ?></option>
                <option <?php echo $sel4; ?> value="精神保健福祉援助実習Ⅱ"><?PHP echo "精神保健福祉援助Ⅱ"; ?></option>
                <option <?php echo $sel5; ?> value="アドバンス・クラス実習"><?PHP echo "アドバンス・クラス"; ?></option>
            </select>

        </td>
        <td width="17.6%">

            <?php
            $sel0 = "";
            $sel1 = "";
            $sel2 = "";
            $sel3 = "";
            $sel4 = "";
            $sel5 = "";

            if ($実習種別4 == 'ソーシャルワーク実習Ⅰ') {
                $sel1 = "selected";
            } elseif ($実習種別4 == 'ソーシャルワーク実習Ⅱ') {
                $sel2 = "selected";
            } elseif ($実習種別4 == '精神保健福祉援助実習Ⅰ') {
                $sel3 = "selected";
            } elseif ($実習種別4 == '精神保健福祉援助実習Ⅱ') {
                $sel4 = "selected";
            } elseif ($実習種別4 == 'アドバンス・クラス実習') {
                $sel5 = "selected";
            } else {
                $sel0 = "selected";
            }
            ?>
            <select class="form-select" aria-label="Default select example" name="実習種別4">
                <option <?php echo $sel0; ?>>選択してください</option>
                <option <?php echo $sel1; ?> value="ソーシャルワーク実習Ⅰ"><?PHP echo "ソーシャルワークⅠ"; ?></option>
                <option <?php echo $sel2; ?> value="ソーシャルワーク実習Ⅱ"><?PHP echo "ソーシャルワークⅡ"; ?></option>
                <option <?php echo $sel3; ?> value="精神保健福祉援助実習Ⅰ"><?PHP echo "精神保健福祉援助Ⅰ"; ?></option>
                <option <?php echo $sel4; ?> value="精神保健福祉援助実習Ⅱ"><?PHP echo "精神保健福祉援助Ⅱ"; ?></option>
                <option <?php echo $sel5; ?> value="アドバンス・クラス実習"><?PHP echo "アドバンス・クラス"; ?></option>
            </select>

        </td>
        <td width="17.6%">



            <?php
            $sel0 = "";
            $sel1 = "";
            $sel2 = "";
            $sel3 = "";
            $sel4 = "";
            $sel5 = "";

            if ($実習種別5 == 'ソーシャルワーク実習Ⅰ') {
                $sel1 = "selected";
            } elseif ($実習種別5 == 'ソーシャルワーク実習Ⅱ') {
                $sel2 = "selected";
            } elseif ($実習種別5 == '精神保健福祉援助実習Ⅰ') {
                $sel3 = "selected";
            } elseif ($実習種別5 == '精神保健福祉援助実習Ⅱ') {
                $sel4 = "selected";
            } elseif ($実習種別5 == 'アドバンス・クラス実習') {
                $sel5 = "selected";
            } else {
                $sel0 = "selected";
            }
            ?>
            <select class="form-select" aria-label="Default select example" name="実習種別5">
                <option <?php echo $sel0; ?>>選択してください</option>
                <option <?php echo $sel1; ?> value="ソーシャルワーク実習Ⅰ"><?PHP echo "ソーシャルワークⅠ"; ?></option>
                <option <?php echo $sel2; ?> value="ソーシャルワーク実習Ⅱ"><?PHP echo "ソーシャルワークⅡ"; ?></option>
                <option <?php echo $sel3; ?> value="精神保健福祉援助実習Ⅰ"><?PHP echo "精神保健福祉援助Ⅰ"; ?></option>
                <option <?php echo $sel4; ?> value="精神保健福祉援助実習Ⅱ"><?PHP echo "精神保健福祉援助Ⅱ"; ?></option>
                <option <?php echo $sel5; ?> value="アドバンス・クラス実習"><?PHP echo "アドバンス・クラス"; ?></option>
            </select>


        </td>
    </tr>


    <tr>
        <td class="text-lrdt align-middle"><span class="fw600">学籍番号</span></td>
        <td><?php _inputv("学籍番号1", $学籍番号1, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("学籍番号2", $学籍番号2, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("学籍番号3", $学籍番号3, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("学籍番号4", $学籍番号4, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("学籍番号5", $学籍番号5, "text", "edit", "", ""); ?></td>
    </tr>

    <tr>
        <td class="text-lrdt align-middle"><span class="fw600">氏名</span></td>
        <td><?php _inputv("学生1", $学生1, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("学生2", $学生2, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("学生3", $学生3, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("学生4", $学生4, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("学生5", $学生5, "text", "edit", "", ""); ?></td>
    </tr>

    <tr>
        <td class="text-lrdt align-middle"><span class="fw600">学年</span></td>


            <?php
            $sel0 = "";
            $sel1 = "";
            $sel2 = "";
            $sel3 = "";
            $sel4 = "";

            if ($学年1 == '1') {
                $sel1 = "selected";
            } elseif ($学年1 == '2') {
                $sel2 = "selected";
            } elseif ($学年1 == '3') {
                $sel3 = "selected";
            } elseif ($学年1 == '4') {
                $sel4 = "selected";
            } else {
                $sel0 = "selected";
            }
            ?>


        <td><select class="form-select" aria-label="Default select example" name="学年1">
            <option value="" <?php echo $sel0;?>>選択してください</option>
            <option value="1" <?php echo $sel1;?>>1学年</option>
            <option value="2" <?php echo $sel2;?>>2学年</option>
            <option value="3" <?php echo $sel3;?>>3学年</option>
            <option value="4" <?php echo $sel4;?>>4学年</option>
        </select></td>

            <?php
            $sel0 = "";
            $sel1 = "";
            $sel2 = "";
            $sel3 = "";
            $sel4 = "";

            if ($学年2 == '1') {
                $sel1 = "selected";
            } elseif ($学年2 == '2') {
                $sel2 = "selected";
            } elseif ($学年2 == '3') {
                $sel3 = "selected";
            } elseif ($学年2 == '4') {
                $sel4 = "selected";
            } else {
                $sel0 = "selected";
            }
            ?>


        <td><select class="form-select" aria-label="Default select example" name="学年2">
            <option value="" <?php echo $sel0;?>>選択してください</option>
            <option value="1" <?php echo $sel1;?>>1学年</option>
            <option value="2" <?php echo $sel2;?>>2学年</option>
            <option value="3" <?php echo $sel3;?>>3学年</option>
            <option value="4" <?php echo $sel4;?>>4学年</option>
        </select></td>


            <?php
            $sel0 = "";
            $sel1 = "";
            $sel2 = "";
            $sel3 = "";
            $sel4 = "";

            if ($学年3 == '1') {
                $sel1 = "selected";
            } elseif ($学年3 == '2') {
                $sel2 = "selected";
            } elseif ($学年3 == '3') {
                $sel3 = "selected";
            } elseif ($学年3 == '4') {
                $sel4 = "selected";
            } else {
                $sel0 = "selected";
            }
            ?>
        <td><select class="form-select" aria-label="Default select example" name="学年3">
            <option value="" <?php echo $sel0;?>>選択してください</option>
            <option value="1" <?php echo $sel1;?>>1学年</option>
            <option value="2" <?php echo $sel2;?>>2学年</option>
            <option value="3" <?php echo $sel3;?>>3学年</option>
            <option value="4" <?php echo $sel4;?>>4学年</option>
        </select></td>

            <?php
            $sel0 = "";
            $sel1 = "";
            $sel2 = "";
            $sel3 = "";
            $sel4 = "";

            if ($学年4 == '1') {
                $sel1 = "selected";
            } elseif ($学年4 == '2') {
                $sel2 = "selected";
            } elseif ($学年4 == '3') {
                $sel3 = "selected";
            } elseif ($学年4 == '4') {
                $sel4 = "selected";
            } else {
                $sel0 = "selected";
            }
            ?>

        <td><select class="form-select" aria-label="Default select example" name="学年4">
            <option value="" <?php echo $sel0;?>>選択してください</option>
            <option value="1" <?php echo $sel1;?>>1学年</option>
            <option value="2" <?php echo $sel2;?>>2学年</option>
            <option value="3" <?php echo $sel3;?>>3学年</option>
            <option value="4" <?php echo $sel4;?>>4学年</option>
        </select></td>

        <?php
            $sel0 = "";
            $sel1 = "";
            $sel2 = "";
            $sel3 = "";
            $sel4 = "";

            if ($学年5 == '1') {
                $sel1 = "selected";
            } elseif ($学年5 == '2') {
                $sel2 = "selected";
            } elseif ($学年5 == '3') {
                $sel3 = "selected";
            } elseif ($学年5 == '4') {
                $sel4 = "selected";
            } else {
                $sel0 = "selected";
            }
            ?>


        <td><select class="form-select" aria-label="Default select example" name="学年5">
            <option value="" <?php echo $sel0;?>>選択してください</option>
            <option value="1" <?php echo $sel1;?>>1学年</option>
            <option value="2" <?php echo $sel2;?>>2学年</option>
            <option value="3" <?php echo $sel3;?>>3学年</option>
            <option value="4" <?php echo $sel4;?>>4学年</option>
        </select></td>

    </tr>

    <tr>
        <td class="text-lrdt align-middle"><span class="fw600">担当教員</span></td>
        <td><?php _inputv("担当教員1", $担当教員1, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("担当教員2", $担当教員2, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("担当教員3", $担当教員3, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("担当教員4", $担当教員4, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("担当教員5", $担当教員5, "text", "edit", "", ""); ?></td>
    </tr>

    <tr>
        <td class="text-lrdt align-middle"><span class="fw600">実習開始日</span></td>

        <td><input name="実習開始日1" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習開始日1; ?> style="width:150px"></td>
        <td><input name="実習開始日2" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習開始日2; ?> style="width:150px"></td>
        <td><input name="実習開始日3" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習開始日3; ?> style="width:150px"></td>
        <td><input name="実習開始日4" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習開始日4; ?> style="width:150px"></td>
        <td><input name="実習開始日5" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習開始日5; ?> style="width:150px"></td>


    </tr>

    <tr>
        <td class="text-lrdt align-middle"><span class="fw600">実習終了日</span></td>

        <td><input name="実習終了日1" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習終了日1; ?> style="width:150px"></td>
        <td><input name="実習終了日2" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習終了日2; ?> style="width:150px"></td>
        <td><input name="実習終了日3" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習終了日3; ?> style="width:150px"></td>
        <td><input name="実習終了日4" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習終了日4; ?> style="width:150px"></td>
        <td><input name="実習終了日5" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $実習終了日5; ?> style="width:150px"></td>

    </tr>


    <tr>
        <td class="text-lrdt align-middle"><span class="fw600">総実習時間（日）</span></td>
        <td><?php _inputv("総実習時間1", $総実習時間1, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("総実習時間2", $総実習時間2, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("総実習時間3", $総実習時間3, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("総実習時間4", $総実習時間4, "text", "edit", "", ""); ?></td>
        <td><?php _inputv("総実習時間5", $総実習時間5, "text", "edit", "", ""); ?></td>
    </tr>


    <tr>
        <td class="text-lrdt align-middle"><span class="fw600">巡回指導日</span></td>

        <td><input name="巡回指導日1" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $巡回指導日1; ?> style="width:150px"></td>
        <td><input name="巡回指導日2" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $巡回指導日2; ?> style="width:150px"></td>
        <td><input name="巡回指導日3" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $巡回指導日3; ?> style="width:150px"></td>
        <td><input name="巡回指導日4" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $巡回指導日4; ?> style="width:150px"></td>
        <td><input name="巡回指導日5" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $巡回指導日5; ?> style="width:150px"></td>



    </tr>

    <tr>
        <td class="text-lrdt align-middle"><span class="fw600">帰校日</span></td>


        <td><input name="帰校日1" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $帰校日1; ?> style="width:150px"></td>
        <td><input name="帰校日2" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $帰校日2; ?> style="width:150px"></td>
        <td><input name="帰校日3" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $帰校日3; ?> style="width:150px"></td>
        <td><input name="帰校日4" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $帰校日4; ?> style="width:150px"></td>
        <td><input name="帰校日5" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $帰校日5; ?> style="width:150px"></td>

    </tr>


    <tr>
        <td class="text-lrdt align-middle"><span class="fw600">オリエンテーション</span></td>

        <td><input name="オリエンテーション1" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $オリエンテーション1; ?> style="width:150px"></td>
        <td><input name="オリエンテーション2" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $オリエンテーション2; ?> style="width:150px"></td>
        <td><input name="オリエンテーション3" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $オリエンテーション3; ?> style="width:150px"></td>
        <td><input name="オリエンテーション4" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $オリエンテーション4; ?> style="width:150px"></td>
        <td><input name="オリエンテーション5" type="date" cmanCLDat="USE:ON,LANG:EN,FORM:3" value=<?php echo $オリエンテーション5; ?> style="width:150px"></td>

    </tr>

    <tr>
        <td class="text-lrdt align-middle"><span class="fw600">特記事項</span></td>
        <td><?php _inputv("特記事項1", $特記事項1, "textarea", "edit", "h200", "255"); ?></td>
        <td><?php _inputv("特記事項2", $特記事項2, "textarea", "edit", "h200", "255"); ?></td>
        <td><?php _inputv("特記事項3", $特記事項3, "textarea", "edit", "h200", "255"); ?></td>
        <td><?php _inputv("特記事項4", $特記事項4, "textarea", "edit", "h200", "255"); ?></td>
        <td><?php _inputv("特記事項5", $特記事項5, "textarea", "edit", "h200", "255"); ?></td>
    </tr>


        <input  type="hidden" value="off" name="delete1">
        <input  type="hidden" value="off" name="delete2">
        <input  type="hidden" value="off" name="delete3">
        <input  type="hidden" value="off" name="delete4">
        <input  type="hidden" value="off" name="delete5">


    <tr>
        <td class="text-lrdt align-middle"><span class="fw600">学生の個別削除</span></td>
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
                <input class="form-check-input" type="checkbox" value="on"  name="delete2">
                <label class="form-check-label" for="flexCheckDefault">
                    削除する
                </label>
            </div>
        </td>
        <td>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="on"  name="delete3">
                <label class="form-check-label" for="flexCheckDefault">
                    削除する
                </label>
            </div>
        </td>
        <td>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="on"  name="delete4">
                <label class="form-check-label" for="flexCheckDefault">
                    削除する
                </label>
            </div>
        </td>
        <td>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="on"  name="delete5">
                <label class="form-check-label" for="flexCheckDefault">
                    削除する
                </label>
            </div>
        </td>
    </tr>

</table>

</table>
<input type='hidden' name='NO' value="<?php echo intval($NO); ?>">
<input type='hidden' name='TABLE' value="tbl_assignment">
<input type='hidden' name='METHOD' value="UP_DATE">


<input type='hidden' name='事業年度' value="<?php echo $事業年度; ?>">
<input type='hidden' name='法人ID' value="<?php echo $_POST['法人ID']; ?>">
<input type='hidden' name='選択実習種別' value="<?php echo $_POST['選択実習種別']; ?>">








<table class="table">
    <tr>
        <td>
            <?php btn_submit("登録", "", ""); ?>
        </td>

        <form action='assignment_info.php' method='post'>
            <td class="text-center align-middle">
                <input type='hidden' name='選択実習種別' value="<?PHP echo $_POST['選択実習種別']; ?>">
                <?php btn_submit("戻る", "", ""); ?>
            </td>
        </form>

    </tr>
</table>

<?PHP





require('./disp_parts/footer.php');
exit;
?>