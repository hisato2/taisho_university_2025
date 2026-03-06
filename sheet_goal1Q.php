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
require_once('./common/target.php');


$ACTION = "select_sheet.php";

require('./disp_parts/header.php');
require('data_keep.php');




tbl_status_check($_SESSION['STUDENT_NUMBER'], $_SESSION['SELECT_NEN']);
tbl_goal_sheet_1q_READ($_SESSION['STUDENT_NUMBER'], $_SESSION['SELECT_NEN']);


if (($GLOBALS['sta_go1Q'] == 4) or ($GLOBALS['sta_go1Q'] == 2)) {
    $edits = "";
} else {
    $edits = "edit";
}



if (!isset($_SESSION['SELECT_NEN'])) {
    $_SESSION['SELECT_NEN'] = "1";
}


if ($_SESSION['SELECT_NEN'] == 1) {
    $study_target01 = STUDY_1_01;
    $study_target02 = STUDY_1_02;
    $study_target03 = STUDY_1_03;
    $study_target04 = STUDY_1_04;

    $study_target05 = STUDY_1_05;
    $study_target06 = "";
}


if ($_SESSION['SELECT_NEN'] == 2) {




    $study_target01 = STUDY_2_01;
    $study_target02 = STUDY_2_02;
    $study_target03 = STUDY_2_03;
    $study_target04 = STUDY_2_04;
    $study_target05 = STUDY_2_05;

    $study_target06 = "";
}


if ($_SESSION['SELECT_NEN'] == 3) {
    $study_target01 = STUDY_3_01;
    $study_target02 = STUDY_3_02;
    $study_target03 = STUDY_3_03;
    $study_target04 = STUDY_3_04;

    $study_target05 = STUDY_3_05;
    $study_target06 = "";
}


if ($_SESSION['SELECT_NEN'] == 4) {
    $study_target01 = STUDY_4_01;
    $study_target02 = STUDY_4_02;
    $study_target03 = STUDY_4_03;
    $study_target04 = STUDY_4_04;

    $study_target05 = STUDY_4_05;
    $study_target06 = "";
}




if ($_SESSION['SELECT_NEN'] == 2) {
    $sw_target01 = SW1_TARGET_01;
    $sw_target02 = SW1_TARGET_02;
    $sw_target03 = SW1_TARGET_03;
    $sw_target04 = SW1_TARGET_04;
    $sw_target05 = SW1_TARGET_05;
    $sw_target06 = SW1_TARGET_06;
    $sw_target07 = SW1_TARGET_07;
    $sw_target08 = SW1_TARGET_08;
    $sw_target09 = SW1_TARGET_09;
    $sw_target10 = SW1_TARGET_10;
    $sw_target11 = SW1_TARGET_11;
    $sw_target12 = SW1_TARGET_12;
}

if (($_SESSION['SELECT_NEN'] == 3) or ($_SESSION['SELECT_NEN'] == 4)) {
    $sw_target01 = SW2_TARGET_01;
    $sw_target02 = SW2_TARGET_02;
    $sw_target03 = SW2_TARGET_03;
    $sw_target04 = SW2_TARGET_04;
    $sw_target05 = SW2_TARGET_05;
    $sw_target06 = SW2_TARGET_06;
    $sw_target07 = SW2_TARGET_07;
    $sw_target08 = SW2_TARGET_08;
    $sw_target09 = SW2_TARGET_09;
    $sw_target10 = SW2_TARGET_10;
    $sw_target11 = SW2_TARGET_11;
    $sw_target12 = SW2_TARGET_12;
}


if (($_SESSION['SELECT_NEN'] == 2)) {
    $intern_target01 = IT2_TARGET_01;
    $intern_target02 = IT2_TARGET_02;
    $intern_target03 = IT2_TARGET_03;
    $intern_target04 = IT2_TARGET_04;
    $intern_target05 = IT2_TARGET_05;
    $intern_target06 = IT2_TARGET_06;
    $intern_target07 = IT2_TARGET_07;
    $intern_target08 = IT2_TARGET_08;
    $intern_target09 = IT2_TARGET_09;
    $intern_target10 = IT2_TARGET_10;
    $intern_target11 = IT2_TARGET_11;
    $intern_target12 = IT2_TARGET_12;
}

if (($_SESSION['SELECT_NEN'] == 3)) {
    $intern_target01 = IT3_TARGET_01;
    $intern_target02 = IT3_TARGET_02;
    $intern_target03 = IT3_TARGET_03;
    $intern_target04 = IT3_TARGET_04;
    $intern_target05 = IT3_TARGET_05;
    $intern_target06 = IT3_TARGET_06;
    $intern_target07 = IT3_TARGET_07;
    $intern_target08 = IT3_TARGET_08;
    $intern_target09 = IT3_TARGET_09;
    $intern_target10 = IT3_TARGET_10;
    $intern_target11 = IT3_TARGET_11;
    $intern_target12 = IT3_TARGET_12;
}

if (($_SESSION['SELECT_NEN'] == 4)) {
    $intern_target01 = IT4_TARGET_01;
    $intern_target02 = IT4_TARGET_02;
    $intern_target03 = IT4_TARGET_03;
    $intern_target04 = IT4_TARGET_04;
    $intern_target05 = IT4_TARGET_05;
    $intern_target06 = IT4_TARGET_06;
    $intern_target07 = IT4_TARGET_07;
    $intern_target08 = IT4_TARGET_08;
    $intern_target09 = IT4_TARGET_09;
    $intern_target10 = IT4_TARGET_10;
    $intern_target11 = IT4_TARGET_11;
    $intern_target12 = IT4_TARGET_12;
}





if ($_SESSION['SELECT_NEN'] == 1) {
    $midashino_atama = "入学時に";
    $sw_target = "";
    $intern_target = "";
    $study_area = "";
}

if ($_SESSION['SELECT_NEN'] == 2) {
    $midashino_atama = "１年次に";
    $sw_target = "（ソーシャルワーク実習Ⅰ）";
    $intern_target = "（インターンシップⅠ）";
    //$study_area = "edit";
    $study_area = "";
}


if ($_SESSION['SELECT_NEN'] == 3) {
    $midashino_atama = "２年次に";
    $sw_target = "（ソーシャルワーク実習Ⅱ）";
    $intern_target = "（精神保健福祉援助Ⅰ（単独）/インターンシップⅡ）";
    //$study_area = "edit";
    $study_area = "";
}
if ($_SESSION['SELECT_NEN'] == 4) {
    $midashino_atama = "３年次に";
    $sw_target = "（ソーシャルワーク実習Ⅱ）";
    $intern_target = "（アドバンス・コース/精神実習Ⅱ（単独））";
    //$study_area = "edit";
    $study_area = "";
}


dsip_midashi("学修行動計画(ゴール・シート)" . $_SESSION['SELECT_NEN']  . "年次（1Q）");


form_submit("registration.php");




dsip_koumoku("1-1." . $midashino_atama . "設定した大学卒業後の自分");
?>

<div class="color_fluid1">
    <table class="table table-bordered border-secondary">
        <tr>
            <td width="15%"><span class="fw600">（対象）</span><br>誰に対して…or<br>何に対して</td>
            <td width="15%"><span class="fw600">（実践フィールド）</span><br>どこで…</td>
            <td width="15%"><span class="fw600">（職業人たる自己）</span><br>どのような立場で…<br>or どのよなう職種で…</td>
            <td width="15%"><span class="fw600">（実践・活動の課題）</span><br>何を…</td>
            <td width="15%"><span class="fw600">（実践・活動の方法）</span><br>どのように…</td>
            <td width="15%"><span class="fw600">（実践・活動において<br>目指す成果）</span><br>…を実現する</td>
            <td><span class="fw600"></span></td>
        </tr>

        <tr>
            <td><?php
                _inputv("target_person", $target_person, "text", $edits, "", "");

                ?>
                <div class="text-end text-decoration-underline">に対して</div>
            </td>
            <td><?php _inputv("practical_field", $practical_field, "text", $edits, "", ""); ?>
                <div class="text-end text-decoration-underline">で</div>
            </td>
            <td><?php _inputv("professional_position", $professional_position, "text", $edits, "", ""); ?>
                <div class="text-end text-decoration-underline">として</div>
            </td>
            <td><?php _inputv("activity_issues", $activity_issues, "text", $edits, "", ""); ?>
                <div class="text-end text-decoration-underline">を</div>
            </td>
            <td><?php _inputv("activity_method", $activity_method, "text", $edits, "", ""); ?>
                <div class="text-end text-decoration-underline">によって（を用いて）</div>
            </td>
            <td><?php _inputv("aimed_results", $aimed_results, "text", $edits, "", ""); ?>
                <div class="text-end text-decoration-underline">を実現する</div>
            </td>
            <td class="text-bottom">
                <div class="text-end text-decoration-underline">自分になる</div>
            </td>
        </tr>

    </table>
</div>



<?php
dsip_koumoku("1-2.1-1.の「大学卒業後の自分」をさらに深めて考えてみましょう！");

?>

<div class="color_fluid1">

    <table class="table table-bordered border-secondary">
        <tr>
            <td>
                1-2①なぜあなたはそれを目指すのですか？:<span class="fs80"></span>


                <?php _inputv("your_goal", $your_goal, "textarea", $edits, "h80", "255"); ?>
            </td>
        </tr>
        <tr>
            <td>
                1-2②あなたが目指すものは、福祉の対象者や社会にとってなぜ必要ですか？:<span class="fs80"></span>
                <?php _inputv("need_your_goal", $need_your_goal, "textarea", $edits, "h80", "255"); ?>
            </td>
        </tr>
    </table>
</div>


<?php

dsip_koumoku("1-3.「" . $midashino_atama . "設定した大学卒業後の自分」になるための「あなたの達成目標」（" . $_SESSION['SELECT_NEN'] . "年次「学修の到達目標」を踏まえて、観点ごとに設定）");

?>
<style>
    .myGoalTable {
        border-collapse: collapse;
        width: 100%;
    }

    .myGoalTable th,
    .myGoalTable td {
        border: 1px solid #ccc;
        padding: 6px;
        vertical-align: middle;
    }

    .center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }
</style>
<div row>
    <div class="col-12">
        <div class="color_fluid1">
            <table class="myGoalTable">
                <tr>
                    <!-- left cell -->
                    <td
                        rowspan="2"
                        style="width: 20%"
                        class="light-green center bold">
                        <?php echo $_SESSION['SELECT_NEN']; ?> 1年次の「学修の到達目標」（共通）
                    </td>

                    <!-- Middle cell -->
                    <td
                        class="text-center"
                        style="width: 30%">
                        1-1．の「自分」になるためのあなたの到達目標
                    </td>

                    <!-- Right cell -->
                    <td
                        colspan="2"
                        class="center"
                        style="width: 50%;">
                        1-1の自分になるための目標に
                        到達するために必要な（身につける）力
                    </td>
                </tr>

                <tr>
                    <td class="text-center" style="width: 30%;">
                        <span class="bold"> （各観点を「あなたの到達目標」に変換しよう！）<br></span>
                        <span style="font-size: 90%">(20字以上)</span>
                    </td>
                    <td
                        class="center bold"
                        style="width: 25%">
                        A．「4つの人になるための10の力」より、<br>
                        目標への到達に必要な力を選択しよう
                    </td>
                    <td
                        class="center bold"
                        style="width: 25%;">
                        B．“A”の力について、<br>
                        到達目標に沿って具体的に自分の言葉で書いてみよう！
                    </td>
                </tr>

                <tr>
                    <td
                        rowspan="4"
                        style="vertical-align: top;">
                        <?php
                        echo "<input type='hidden' name='study_target01' value='" . $study_target01 . "'>";
                        echo nl2br($study_target01);
                        ?>
                    </td>

                    <td
                        rowspan="4"
                        style="vertical-align: top;">
                        <?php _inputv("study_conversion01", $study_conversion01, "textarea", $edits, "h80", "255"); ?>
                    </td>

                    <td style="vertical-align: top;">
                        <select name="option_a1" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_a1'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_a1'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_a1'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_a1'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_a1'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_a1'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_a1'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_a1'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_a1'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_a1'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php _inputv("textarea_b1", $GLOBALS['textarea_b1'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">
                        <select name="option_a2" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_a2'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_a2'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_a2'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_a2'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_a2'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_a2'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_a2'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_a2'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_a2'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_a2'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php _inputv("textarea_b2", $GLOBALS['textarea_b2'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">
                        <select name="option_a3" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_a3'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_a3'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_a3'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_a3'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_a3'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_a3'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_a3'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_a3'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_a3'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_a3'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php _inputv("textarea_b3", $GLOBALS['textarea_b3'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">
                        <select name="option_a4" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_a4'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_a4'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_a4'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_a4'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_a4'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_a4'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_a4'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_a4'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_a4'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_a4'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php _inputv("textarea_b4", $GLOBALS['textarea_b4'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr>
                    <td
                        rowspan="4"
                        class="light-green"
                        style="vertical-align: top;">
                        <?php
                        echo "<input type='hidden' name='study_target02' value='" . $study_target02 . "'>";
                        echo nl2br($study_target02);
                        ?>
                    </td>
                    <td
                        rowspan="4"
                        style="vertical-align: top;">
                        <?php _inputv("study_conversion02", $study_conversion02, "textarea", $edits, "h80", "255"); ?>
                    </td>

                    <td style="vertical-align: top">
                        <select name="option_b1" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_b1'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_b1'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_b1'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_b1'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_b1'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_b1'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_b1'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_b1'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_b1'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_b1'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top">
                        <?php _inputv("textarea_c1", $GLOBALS['textarea_c1'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top">
                        <select name="option_b2" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_b2'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_b2'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_b2'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_b2'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_b2'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_b2'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_b2'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_b2'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_b2'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_b2'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top">
                        <?php _inputv("textarea_c2", $GLOBALS['textarea_c2'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top">
                        <select name="option_b3" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_b3'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_b3'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_b3'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_b3'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_b3'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_b3'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_b3'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_b3'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_b3'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_b3'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top">
                        <?php _inputv("textarea_c3", $GLOBALS['textarea_c3'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top">
                        <select name="option_b4" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_b4'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_b4'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_b4'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_b4'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_b4'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_b4'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_b4'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_b4'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_b4'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_b4'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top">
                        <?php _inputv("textarea_c4", $GLOBALS['textarea_c4'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr>
                    <td
                        rowspan="4"
                        class="light-green"
                        style="vertical-align: top">
                        <?php
                        echo "<input type='hidden' name='study_target03' value='" . $study_target03 . "'>";
                        echo nl2br($study_target03);
                        ?>
                    </td>
                    <td
                        style="vertical-align: top"
                        rowspan="4">
                        <?php _inputv("study_conversion03", $study_conversion03, "textarea", $edits, "h80", "255"); ?>
                    </td>
                    <td style="vertical-align: top">
                        <select name="option_c1" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_c1'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_c1'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_c1'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_c1'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_c1'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_c1'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_c1'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_c1'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_c1'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_c1'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top">
                        <?php _inputv("textarea_d1", $GLOBALS['textarea_d1'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr style="vertical-align: top;">
                    <td>
                        <select name="option_c2" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_c2'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_c2'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_c2'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_c2'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_c2'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_c2'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_c2'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_c2'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_c2'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_c2'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>

                    <td style="vertical-align: top;">
                        <?php _inputv("textarea_d2", $GLOBALS['textarea_d2'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr style="vertical-align: top;">
                    <td>
                        <select name="option_c3" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_c3'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_c3'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_c3'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_c3'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_c3'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_c3'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_c3'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_c3'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_c3'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_c3'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>

                    <td style="vertical-align: top;">
                        <?php _inputv("textarea_d3", $GLOBALS['textarea_d3'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr style="vertical-align: top;">
                    <td>
                        <select name="option_c4" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_c4'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_c4'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_c4'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_c4'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_c4'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_c4'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_c4'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_c4'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_c4'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_c4'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>

                    <td style="vertical-align: top;">
                        <?php _inputv("textarea_d4", $GLOBALS['textarea_d4'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>


                <tr>
                    <td
                        rowspan="4"
                        class="light-green"
                        style="vertical-align: top">
                        <?php
                        echo "<input type='hidden' name='study_target04' value='" . $study_target04 . "'>";
                        echo nl2br($study_target04);
                        ?>
                    </td>
                    <td
                        rowspan="4"
                        style="vertical-align: top">
                        <?php _inputv("study_conversion04", $study_conversion04, "textarea", $edits, "h80", "255"); ?>
                    </td>
                    <td style="vertical-align: top;">
                        <select name="option_d1" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_d1'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_d1'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_d1'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_d1'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_d1'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_d1'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_d1'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_d1'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_d1'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_d1'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top;">
                        <?php _inputv("textarea_e1", $GLOBALS['textarea_e1'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">
                        <select name="option_d2" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_d2'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_d2'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_d2'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_d2'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_d2'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_d2'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_d2'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_d2'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_d2'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_d2'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top;">
                        <?php _inputv("textarea_e2", $GLOBALS['textarea_e2'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">
                        <select name="option_d3" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_d3'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_d3'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_d3'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_d3'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_d3'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_d3'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_d3'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_d3'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_d3'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_d3'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top;">
                        <?php _inputv("textarea_e3", $GLOBALS['textarea_e3'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">
                        <select name="option_d4" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?= ($GLOBALS['option_d4'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                            <option value="2" <?= ($GLOBALS['option_d4'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                            <option value="3" <?= ($GLOBALS['option_d4'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                            <option value="4" <?= ($GLOBALS['option_d4'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?= ($GLOBALS['option_d4'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?= ($GLOBALS['option_d4'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?= ($GLOBALS['option_d4'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?= ($GLOBALS['option_d4'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?= ($GLOBALS['option_d4'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?= ($GLOBALS['option_d4'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top;">
                        <?php _inputv("textarea_e4", $GLOBALS['textarea_e4'], "textarea", $edits, "h100", "255"); ?>
                    </td>
                </tr>

                <?php

                if ($_SESSION['SELECT_NEN'] == 1) :
                ?>
                    <tr>
                        <td
                            rowspan="4"
                            class="light-green"
                            style="vertical-align: top;">
                            <?php
                            echo "<input type='hidden' name='study_target05' value='" . $study_target05 . "'>";
                            echo nl2br($study_target05);
                            ?>
                        </td>

                        <td
                            rowspan="4"
                            style="vertical-align: top;">
                            <?php _inputv("study_conversion05", $study_conversion05, "textarea", $edits, "h80", "255"); ?>
                        </td>

                        <td style="vertical-align: top;">
                            <select name="option_e1" style="width: 100%;">
                                <option value="">-- 選択 --</option>
                                <option value="1" <?= ($GLOBALS['option_e1'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                                <option value="2" <?= ($GLOBALS['option_e1'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                                <option value="3" <?= ($GLOBALS['option_e1'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                                <option value="4" <?= ($GLOBALS['option_e1'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                                <option value="5" <?= ($GLOBALS['option_e1'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                                <option value="6" <?= ($GLOBALS['option_e1'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                                <option value="7" <?= ($GLOBALS['option_e1'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                                <option value="8" <?= ($GLOBALS['option_e1'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                                <option value="9" <?= ($GLOBALS['option_e1'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                                <option value="10" <?= ($GLOBALS['option_e1'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                            </select>
                        </td>

                        <td style="vertical-align: top;">
                            <?php _inputv("textarea_f1", $GLOBALS['textarea_f1'], "textarea", $edits, "h100", "255"); ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="vertical-align: top;">
                            <select name="option_e2" style="width: 100%;">
                                <option value="">-- 選択 --</option>
                                <option value="1" <?= ($GLOBALS['option_e2'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                                <option value="2" <?= ($GLOBALS['option_e2'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                                <option value="3" <?= ($GLOBALS['option_e2'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                                <option value="4" <?= ($GLOBALS['option_e2'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                                <option value="5" <?= ($GLOBALS['option_e2'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                                <option value="6" <?= ($GLOBALS['option_e2'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                                <option value="7" <?= ($GLOBALS['option_e2'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                                <option value="8" <?= ($GLOBALS['option_e2'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                                <option value="9" <?= ($GLOBALS['option_e2'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                                <option value="10" <?= ($GLOBALS['option_e2'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                            </select>
                        </td>

                        <td style="vertical-align: top;">
                            <?php _inputv("textarea_f2", $GLOBALS['textarea_f2'], "textarea", $edits, "h100", "255"); ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="vertical-align: top;">
                            <select name="option_e3" style="width: 100%;">
                                <option value="">-- 選択 --</option>
                                <option value="1" <?= ($GLOBALS['option_e3'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                                <option value="2" <?= ($GLOBALS['option_e3'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                                <option value="3" <?= ($GLOBALS['option_e3'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                                <option value="4" <?= ($GLOBALS['option_e3'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                                <option value="5" <?= ($GLOBALS['option_e3'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                                <option value="6" <?= ($GLOBALS['option_e3'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                                <option value="7" <?= ($GLOBALS['option_e3'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                                <option value="8" <?= ($GLOBALS['option_e3'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                                <option value="9" <?= ($GLOBALS['option_e3'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                                <option value="10" <?= ($GLOBALS['option_e3'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                            </select>
                        </td>

                        <td style="vertical-align: top;">
                            <?php _inputv("textarea_f3", $GLOBALS['textarea_f3'], "textarea", $edits, "h100", "255"); ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="vertical-align: top;">
                            <select name="option_e4" style="width: 100%;">
                                <option value="">-- 選択 --</option>
                                <option value="1" <?= ($GLOBALS['option_e4'] === '1') ? 'selected' : '' ?>>①他者に共感する力</option>
                                <option value="2" <?= ($GLOBALS['option_e4'] === '2') ? 'selected' : '' ?>>②物事の本質を見極める力</option>
                                <option value="3" <?= ($GLOBALS['option_e4'] === '3') ? 'selected' : '' ?>>③自分自身を理解する力</option>
                                <option value="4" <?= ($GLOBALS['option_e4'] === '4') ? 'selected' : '' ?>>④自分事として問いを立てる力</option>
                                <option value="5" <?= ($GLOBALS['option_e4'] === '5') ? 'selected' : '' ?>>⑤根拠にもとづいて思考する力</option>
                                <option value="6" <?= ($GLOBALS['option_e4'] === '6') ? 'selected' : '' ?>>⑥自分らしい方法で表現する力</option>
                                <option value="7" <?= ($GLOBALS['option_e4'] === '7') ? 'selected' : '' ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                                <option value="8" <?= ($GLOBALS['option_e4'] === '8') ? 'selected' : '' ?>>⑧多様性を尊重する力</option>
                                <option value="9" <?= ($GLOBALS['option_e4'] === '9') ? 'selected' : '' ?>>⑨新たな価値を創造する力</option>
                                <option value="10" <?= ($GLOBALS['option_e4'] === '10') ? 'selected' : '' ?>>⑩他者と対話し、協働する力</option>
                            </select>
                        </td>

                        <td style="vertical-align: top;">
                            <?php _inputv("textarea_f4", $GLOBALS['textarea_f4'], "textarea", $edits, "h100", "255"); ?>
                        </td>
                    </tr>

                <?php
                else:
                ?>
                    <input type="hidden" name='study_target05' value="">
                    <input type="hidden" name='study_conversion05' value="">
                    <input type="hidden" name="study_target06" value="">
                    <input type="hidden" name="study_conversion06" value="">


                <?php
                endif;
                ?>
            </table>

        </div>

        <?php


        if ($_SESSION['SELECT_NEN'] > 1) {

            echo "<div class='color_fluid2'>";
            echo "<table class='table table-bordered border-secondary'>";
            echo "<tr>";
            echo "<td width='50%' class='text-center text-middle'>";
            echo "<span class='fw600'>" . $_SESSION['SELECT_NEN']  . "年次の「学修の到達目標」<br>" . $sw_target . "</span>";
            echo "</td>";
            echo "<td width='50%' class='text-center text-middle'>";
            echo "<span class='fw600'>1-1．の「自分」になるためのあなたの到達目標<br>（各観点を「あなたの到達目標」に変換しよう！）<br>" . $sw_target . "</span>";
            echo "</td>";
            echo "</tr>";
            echo "<tr><td>";

            echo "<input type='hidden' name='sw_target01' value='" . $sw_target01 . "'>";
            echo nl2br($sw_target01);

            echo "</td><td>";
            _inputv("sw_conversion01", $sw_conversion01, "textarea", $edits, "h80", "255");
            echo "</td></tr>";

            echo "<tr><td>";
            echo "<input type='hidden' name='sw_target02' value='" . $sw_target02 . "'>";
            echo nl2br($sw_target02);

            echo "</td><td>";
            _inputv("sw_conversion02", $sw_conversion02, "textarea", $edits, "h80", "255");
            echo "</td></tr>";

            echo "<tr><td>";
            echo "<input type='hidden' name='sw_target03' value='" . $sw_target03 . "'>";
            echo nl2br($sw_target03);
            echo "</td><td>";
            _inputv("sw_conversion03", $sw_conversion03, "textarea", $edits, "h80", "255");
            echo "</td></tr>";

            echo "<tr><td>";
            echo "<input type='hidden' name='sw_target04' value='" . $sw_target04 . "'>";
            echo nl2br($sw_target04);
            echo "</td><td>";
            _inputv("sw_conversion04", $sw_conversion04, "textarea", $edits, "h80", "255");
            echo "</td></tr>";

            echo "<tr><td>";
            echo "<input type='hidden' name='sw_target05' value='" . $sw_target05 . "'>";
            echo nl2br($sw_target05);
            echo "</td><td>";
            _inputv("sw_conversion05", $sw_conversion05, "textarea", $edits, "h80", "255");
            echo "</td></tr>";

            echo "<tr><td>";
            echo "<input type='hidden' name='sw_target06' value='" . $sw_target06 . "'>";
            echo nl2br($sw_target06);
            echo "</td><td>";
            _inputv("sw_conversion06", $sw_conversion06, "textarea", $edits, "h80", "255");
            echo "</td></tr>";

            echo "<tr><td>";
            echo "<input type='hidden' name='sw_target07' value='" . $sw_target07 . "'>";
            echo nl2br($sw_target07);
            echo "</td><td>";
            _inputv("sw_conversion07", $sw_conversion07, "textarea", $edits, "h80", "255");
            echo "</td></tr>";

            echo "<tr><td>";
            echo "<input type='hidden' name='sw_target08' value='" . $sw_target08 . "'>";
            echo nl2br($sw_target08);

            echo "</td><td>";
            _inputv("sw_conversion08", $sw_conversion08, "textarea", $edits, "h80", "255");
            echo "</td></tr>";

            echo "<tr><td>";
            echo "<input type='hidden' name='sw_target09' value='" . $sw_target09 . "'>";
            echo nl2br($sw_target09);

            echo "</td><td>";
            _inputv("sw_conversion09", $sw_conversion09, "textarea", $edits, "h80", "255");
            echo "</td></tr>";



            if ($_SESSION['SELECT_NEN'] > 2) {


                echo "<tr><td>";
                echo "<input type='hidden' name='sw_target10' value='" . $sw_target10 . "'>";
                echo nl2br($sw_target10);
                echo "</td><td>";
                _inputv("sw_conversion10", $sw_conversion10, "textarea", $edits, "h80", "255");
                echo "</td></tr>";

                echo "<tr><td>";
                echo "<input type='hidden' name='sw_target11' value='" . $sw_target11 . "'>";
                echo nl2br($sw_target11);
                echo "</td><td>";
                _inputv("sw_conversion11", $sw_conversion11, "textarea", $edits, "h80", "255");
                echo "</td></tr>";

                echo "<tr><td>";
                echo "<input type='hidden' name='sw_target12' value='" . $sw_target12 . "'>";
                echo nl2br($sw_target12);
                echo "</td><td>";
                _inputv("sw_conversion12", $sw_conversion12, "textarea", $edits, "h80", "255");
                echo "</td></tr>";
            } else {
        ?>
                <input type="hidden" name='sw_target10' value="">
                <input type="hidden" name='sw_target11' value="">
                <input type="hidden" name='sw_target12' value="">
                <input type="hidden" name='sw_conversion10' value="">
                <input type="hidden" name='sw_conversion11' value="">
                <input type="hidden" name='sw_conversion12' value="">


            <?php

            }




            echo "</table>";
            echo "</div>";
        } else {

            ?>
            <input type="hidden" name='study_target01' value="">
            <input type="hidden" name='study_target02' value="">
            <input type="hidden" name='study_target03' value="">
            <input type="hidden" name='study_target04' value="">
            <input type="hidden" name='study_target05' value="">
            <input type="hidden" name='study_target06' value="">




            <input type="hidden" name='study_conversion07' value="">
            <input type="hidden" name='study_conversion08' value="">
            <input type="hidden" name='study_conversion09' value="">
            <input type="hidden" name='study_conversion10' value="">
            <input type="hidden" name='study_conversion11' value="">
            <input type="hidden" name='study_conversion12' value="">




            <input type="hidden" name='sw_target01' value="">
            <input type="hidden" name='sw_target02' value="">
            <input type="hidden" name='sw_target03' value="">
            <input type="hidden" name='sw_target04' value="">
            <input type="hidden" name='sw_target05' value="">
            <input type="hidden" name='sw_target06' value="">
            <input type="hidden" name='sw_target07' value="">
            <input type="hidden" name='sw_target08' value="">
            <input type="hidden" name='sw_target09' value="">
            <input type="hidden" name='sw_target10' value="">
            <input type="hidden" name='sw_target11' value="">
            <input type="hidden" name='sw_target12' value="">



            <input type="hidden" name='sw_conversion01' value="">
            <input type="hidden" name='sw_conversion02' value="">
            <input type="hidden" name='sw_conversion03' value="">
            <input type="hidden" name='sw_conversion04' value="">
            <input type="hidden" name='sw_conversion05' value="">
            <input type="hidden" name='sw_conversion06' value="">
            <input type="hidden" name='sw_conversion07' value="">
            <input type="hidden" name='sw_conversion08' value="">
            <input type="hidden" name='sw_conversion09' value="">
            <input type="hidden" name='sw_conversion10' value="">
            <input type="hidden" name='sw_conversion11' value="">
            <input type="hidden" name='sw_conversion12' value="">


            <input type="hidden" name='intern_target01' value="">
            <input type="hidden" name='intern_target02' value="">
            <input type="hidden" name='intern_target03' value="">
            <input type="hidden" name='intern_target04' value="">
            <input type="hidden" name='intern_target05' value="">
            <input type="hidden" name='intern_target06' value="">
            <input type="hidden" name='intern_target07' value="">
            <input type="hidden" name='intern_target08' value="">
            <input type="hidden" name='intern_target09' value="">
            <input type="hidden" name='intern_target10' value="">
            <input type="hidden" name='intern_target11' value="">
            <input type="hidden" name='intern_target12' value="">

            <input type="hidden" name='intern_conversion01' value="">
            <input type="hidden" name='intern_conversion02' value="">
            <input type="hidden" name='intern_conversion03' value="">
            <input type="hidden" name='intern_conversion04' value="">
            <input type="hidden" name='intern_conversion05' value="">
            <input type="hidden" name='intern_conversion06' value="">
            <input type="hidden" name='intern_conversion07' value="">
            <input type="hidden" name='intern_conversion08' value="">
            <input type="hidden" name='intern_conversion09' value="">
            <input type="hidden" name='intern_conversion10' value="">
            <input type="hidden" name='intern_conversion11' value="">
            <input type="hidden" name='intern_conversion12' value="">
            <?php
        }


        if ($_SESSION['SELECT_NEN'] > 1) {


            echo "<div class='color_fluid3'>";


            echo "<table class='table table-bordered border-secondary'>";
            echo "<tr>";
            echo "<td width='50%' class='text-center text-middle'>";
            echo "<span class='fw600'>" . $_SESSION['SELECT_NEN']  . "年次の「学修の到達目標」<br>" . $intern_target . "</span>";
            echo "</td>";
            echo "<td width='50%' class='text-center text-middle'>";
            echo "<span class='fw600'>1-1．の「自分」になるためのあなたの到達目標<br>（各観点を「あなたの到達目標」に変換しよう！）<br>" . $intern_target . "</span>";
            echo "</td>";
            echo "</tr>";

            echo "<tr><td>";

            echo "<input type='hidden' name='intern_target01' value='" . $intern_target01 . "'>";
            echo nl2br($intern_target01);



            echo "</td><td>";
            _inputv("intern_conversion01", $intern_conversion01, "textarea", $edits, "h80", "255");
            echo "</td></tr>";

            echo "<tr><td>";
            echo "<input type='hidden' name='intern_target02' value='" . $intern_target02 . "'>";
            echo nl2br($intern_target02);


            echo "</td><td>";
            _inputv("intern_conversion02", $intern_conversion02, "textarea", $edits, "h80", "255");
            echo "</td></tr>";


            echo "<tr><td>";
            echo "<input type='hidden' name='intern_target03' value='" . $intern_target03 . "'>";
            echo nl2br($intern_target03);

            echo "</td><td>";
            _inputv("intern_conversion03", $intern_conversion03, "textarea", $edits, "h80", "255");
            echo "</td></tr>";


            echo "<tr><td>";
            echo "<input type='hidden' name='intern_target04' value='" . $intern_target04 . "'>";
            echo nl2br($intern_target04);
            echo "</td><td>";
            _inputv("intern_conversion04", $intern_conversion04, "textarea", $edits, "h80", "255");
            echo "</td></tr>";


            echo "<tr><td>";
            echo "<input type='hidden' name='intern_target05' value='" . $intern_target05 . "'>";
            echo nl2br($intern_target05);

            echo "</td><td>";
            _inputv("intern_conversion05", $intern_conversion05, "textarea", $edits, "h80", "255");
            echo "</td></tr>";


            echo "<tr><td>";
            echo "<input type='hidden' name='intern_target06' value='" . $intern_target06 . "'>";
            echo nl2br($intern_target06);

            echo "</td><td>";
            _inputv("intern_conversion06", $intern_conversion06, "textarea", $edits, "h80", "255");
            echo "</td></tr>";


            echo "<tr><td>";
            echo "<input type='hidden' name='intern_target07' value='" . $intern_target07 . "'>";
            echo nl2br($intern_target07);

            echo "</td><td>";
            _inputv("intern_conversion07", $intern_conversion07, "textarea", $edits, "h80", "255");
            echo "</td></tr>";


            echo "<tr><td>";
            echo "<input type='hidden' name='intern_target08' value='" . $intern_target08 . "'>";
            echo nl2br($intern_target08);

            echo "</td><td>";
            _inputv("intern_conversion08", $intern_conversion08, "textarea", $edits, "h80", "255");
            echo "</td></tr>";


            if ($_SESSION['SELECT_NEN'] > 2) {

                echo "<tr><td>";
                echo "<input type='hidden' name='intern_target09' value='" . $intern_target09 . "'>";
                echo nl2br($intern_target09);

                echo "</td><td>";
                _inputv("intern_conversion09", $intern_conversion09, "textarea", $edits, "h80", "255");
                echo "</td></tr>";


                echo "<tr><td>";
                echo "<input type='hidden' name='intern_target10' value='" . $intern_target10 . "'>";
                echo nl2br($intern_target10);

                echo "</td><td>";
                _inputv("intern_conversion10", $intern_conversion10, "textarea", $edits, "h80", "255");
                echo "</td></tr>";


                echo "<tr><td>";
                echo "<input type='hidden' name='intern_target11' value='" . $intern_target11 . "'>";
                echo nl2br($intern_target11);

                echo "</td><td>";
                _inputv("intern_conversion11", $intern_conversion11, "textarea", $edits, "h80", "255");
                echo "</td></tr>";


                echo "<tr><td>";
                echo "<input type='hidden' name='intern_target12' value='" . $intern_target12 . "'>";
                echo nl2br($intern_target12);

                echo "</td><td>";
                _inputv("intern_conversion12", $intern_conversion12, "textarea", $edits, "h80", "255");
                echo "</td></tr>";
            } else {
            ?>
                <input type="hidden" name='intern_target09' value="">
                <input type="hidden" name='intern_target10' value="">
                <input type="hidden" name='intern_target11' value="">
                <input type="hidden" name='intern_target12' value="">


                <input type="hidden" name='intern_conversion09' value="">
                <input type="hidden" name='intern_conversion10' value="">
                <input type="hidden" name='intern_conversion11' value="">
                <input type="hidden" name='intern_conversion12' value="">


        <?php
            }
            echo "</table>";
            echo "</div>";
        }
        ?>



        <h6>教員からのコメント</h6>
        <table class="table table-bordered border-secondary">
            <tr>
                <td><?php _inputv("comments_of_teacher", $comments_of_teacher, "textarea", "", "", "255"); ?></td>
            </tr>
        </table>

    </div>

</div>

<br>


<input type='hidden' name='TABLE' value="tbl_goal_sheet_1q">
<input type='hidden' name='METHOD' value="UP_DATE">
<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $_SESSION['STUDENT_NUMBER']; ?>">
<input type='hidden' name='SELECT_NEN' value="<?PHP echo $_SESSION['SELECT_NEN'] ?>">


<p class="text-center">
    <?php echo "状態：" . $mr[$GLOBALS['sta_go1Q']]; ?>

</p>
<?php
$GLOBALS['sta_go1Q'] = strval($GLOBALS['sta_go1Q']);
?>


<?php
$column = "goal1Q_" . $_SESSION['SELECT_NEN'];
?>


<table class="table">
    <tr>
        <td>
            <?php

            if (strpos(" 0 1 3 ", $GLOBALS['sta_go1Q']) == true) {
                $dis = "";
            } else {
                $dis = "disabled";
            }

            btn_submit("下書き", $column, $dis);
            ?>
        </td>
        <td>
            <?php
            if (strpos(" 0 1 3", $GLOBALS['sta_go1Q']) == true) {
                $dis = "";
            } else {
                $dis = "disabled";
            }
            btn_submit("提出", $column, $dis);
            ?>
        </td>

        <td>
            <?php btn_return("select_sheet.php", "戻る"); ?>
        </td>
    </tr>
</table>
<?php


require('./disp_parts/footer.php');
exit;
?>