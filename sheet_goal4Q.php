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
require_once('./common/target.php');
$ACTION = "select_sheet.php";

require('./disp_parts/header.php');
require('data_keep.php');





if (!isset($_SESSION['SELECT_NEN'])) {
    $_SESSION['SELECT_NEN'] = "1";
}


tbl_status_check($_SESSION['STUDENT_NUMBER'], $_SESSION['SELECT_NEN']);





if (($GLOBALS['sta_go4Q'] == 4) or ($GLOBALS['sta_go4Q'] == 2)) {

    $edits = "";
} else {
    $edits = "edit";
}




tbl_goal_sheet_1q_READ($_SESSION['STUDENT_NUMBER'], $_SESSION['SELECT_NEN']);





tbl_goal_sheet_4q_READ($_SESSION['STUDENT_NUMBER'], $_SESSION['SELECT_NEN']);






$study_target01_4Q = $study_conversion01;
$study_target02_4Q = $study_conversion02;
$study_target03_4Q = $study_conversion03;
$study_target04_4Q = $study_conversion04;

$study_target05_4Q = $study_conversion05;


dsip_midashi("学修行動計画(ゴール・シート)" . $_SESSION['SELECT_NEN']  . "年次（4Q）");

form_submit("registration.php");

dsip_koumoku("2-1." . $_SESSION['SELECT_NEN'] . "年次の学習を通じて展望する大学卒業後の自分（4Q）");
?>

<div class="color_fluid4">
    <table class="table table-bordered border-secondary">
        <tr>
            <td width="15%"><span class="fw600">（対象）</span><br>誰に対して…or<br>何に対して</td>
            <td width="15%"><span class="fw600">（実践フィールド）</span><br>どこで…</td>
            <td width="15%"><span class="fw600">（職業人たる自己）</span><br>どのような立場で…<br>or どのような職種で…</td>
            <td width="15%"><span class="fw600">（実践・活動の課題）</span><br>何を…</td>
            <td width="15%"><span class="fw600">（実践・活動の方法）</span><br>どのように…</td>
            <td width="15%"><span class="fw600">（実践・活動において<br>目指す成果）</span><br>…を実現する</td>
            <td><span class="fw600"></span></td>
        </tr>

        <tr>
            <td><?php _inputv("target_person_4Q", $target_person_4Q, "text", $edits, "", ""); ?><div class="text-end text-decoration-underline">に対して</div>
            </td>
            <td><?php _inputv("practical_field_4Q", $practical_field_4Q, "text", $edits, "", ""); ?><div class="text-end text-decoration-underline">で</div>
            </td>
            <td><?php _inputv("professional_position_4Q", $professional_position_4Q, "text", $edits, "", ""); ?><div class="text-end text-decoration-underline">として</div>
            </td>
            <td><?php _inputv("activity_issues_4Q", $activity_issues_4Q, "text", $edits, "", ""); ?><div class="text-end text-decoration-underline">を</div>
            </td>
            <td><?php _inputv("activity_method_4Q", $activity_method_4Q, "text", $edits, "", ""); ?><div class="text-end text-decoration-underline">によって（を用いて）</div>
            </td>
            <td><?php _inputv("aimed_results_4Q", $aimed_results_4Q, "text", $edits, "", ""); ?><div class="text-end text-decoration-underline">を実現する</div>
            </td>
            <td class="text-bottom">
                <div class="text-end text-decoration-underline">自分になる</div>
            </td>
        </tr>

    </table>
</div>



<?php
dsip_koumoku("2-2. 2-1.の「大学卒業後の自分」をさらに深めて考えてみましょう！");


?>

<div class="color_fluid4">

    <table class="table table-bordered border-secondary">
        <tr>
            <td>
                2-2① なぜあなたはそれを目指すのですか？:<span class="fs80"></span>
                <?php _inputv("your_goal_4Q", $your_goal_4Q, "textarea", $edits, "h80", "255"); ?>
            </td>
        </tr>
        <tr>
            <td>
                2-2② あなたが目指すものは、福祉の対象者や社会にとってなぜ必要ですか？:<span class="fs80"></span>
                <?php _inputv("need_your_goal_4Q", $need_your_goal_4Q, "textarea", $edits, "h80", "255"); ?>
            </td>
        </tr>
    </table>
</div>


<?php

dsip_koumoku("2-3③ " . $_SESSION['SELECT_NEN'] . "年次の学修を通じて展望する「大学卒業後の自分」になるための「あなたの達成目標」、及びやること、努力すること（行動計画）");






?>

<div row>
    <div class="col-12">

        <div class="color_fluid4">
            <table class="table table-bordered border-secondary">
                <tr>
                    <td width="30%" class="text-center text-middle">
                        <span class="fw600">「あなたの到達目標」</span>
                    </td>
                    <td width="25%" class="text-center text-middle">
                        <span class="fw600">あなたの到達目標の達成に向けて<br>次のクォーターまでに、あなたがさらにやること、努力すること</span><span class="fs80"></span>
                    </td>
                    <td width="25%" class="text-center text-middle">
                        <span class="fw600">
                            A．「4つの人になるための10の力より、<br />
                            目標への到達に必要な力を選択しよう」
                        </span>
                    </td>
                    <td width="25%" class="text-center text-middle">
                        <span class="fw600">
                            B．“A”の力について、到達目標に沿って<br />具体的に自分の言葉で書いてみよう！
                        </span>
                    </td>
                </tr>

                <tr>
                    <td
                        rowspan="4"
                        class='text-middle wbr'>
                        <?php
                        echo "<input type='hidden' name='study_target01_4Q' value='" . $study_target01_4Q . "'>";
                        echo  nl2br($study_target01_4Q);
                        ?>
                    </td>
                    <td rowspan="4"><?php _inputv("study_conversion01_4Q", $study_conversion01_4Q, "textarea", $edits, "h80", "255"); ?></td>
                    <td>
                        <select name="goal4q_opt_a1" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_a1 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_a1 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_a1 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_a1 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_a1 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_a1 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_a1 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_a1 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_a1 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_a1 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <textarea name="goal4q_txt_b1" rows="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">
                        <select name="goal4q_opt_a2" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_a2 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_a2 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_a2 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_a2 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_a2 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_a2 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_a2 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_a2 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_a2 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_a2 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <textarea name="goal4q_txt_b2" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_b2, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">
                        <select name="goal4q_opt_a3" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_a3 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_a3 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_a3 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_a3 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_a3 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_a3 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_a3 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_a3 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_a3 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_a3 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <textarea name="goal4q_txt_b3" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_b3, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">
                        <select name="goal4q_opt_a4" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_a4 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_a4 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_a4 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_a4 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_a4 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_a4 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_a4 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_a4 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_a4 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_a4 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <textarea name="goal4q_txt_b4" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_b4, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td rowspan="4" class='text-middle wbr'>
                        <?php
                        echo "<input type='hidden' name='study_target02_4Q' value='" . $study_target02_4Q . "'>";
                        echo nl2br($study_target02_4Q);

                        ?></td>
                    <td rowspan="4"><?php _inputv("study_conversion02_4Q", $study_conversion02_4Q, "textarea", $edits, "h80", "255"); ?></td>
                    <td style="vertical-align: top">
                        <select name="goal4q_opt_b1" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_b1 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_b1 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_b1 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_b1 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_b1 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_b1 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_b1 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_b1 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_b1 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_b1 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top">
                        <textarea name="goal4q_txt_c1" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_c1, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top">
                        <select name="goal4q_opt_b2" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_b2 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_b2 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_b2 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_b2 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_b2 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_b2 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_b2 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_b2 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_b2 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_b2 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top">
                        <textarea name="goal4q_txt_c2" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_c2, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top">
                        <select name="goal4q_opt_b3" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_b3 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_b3 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_b3 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_b3 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_b3 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_b3 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_b3 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_b3 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_b3 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_b3 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top">
                        <textarea name="goal4q_txt_c3" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_c3, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top">
                        <select name="goal4q_opt_b4" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_b4 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_b4 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_b4 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_b4 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_b4 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_b4 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_b4 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_b4 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_b4 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_b4 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top">
                        <textarea name="goal4q_txt_c4" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_c4, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td rowspan="4" class='text-middle wbr'>
                        <?php
                        echo "<input type='hidden' name='study_target03_4Q' value='" . $study_target03_4Q . "'>";
                        echo nl2br($study_target03_4Q);
                        ?>
                    </td>
                    <td rowspan="4"><?php _inputv("study_conversion03_4Q", $study_conversion03_4Q, "textarea", $edits, "h80", "255"); ?></td>
                    <td style="vertical-align: top">
                        <select name="goal4q_opt_c1" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_c1 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_c1 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_c1 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_c1 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_c1 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_c1 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_c1 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_c1 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_c1 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_c1 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top">
                        <textarea name="goal4q_txt_d1" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_d1, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr style="vertical-align: top;">
                    <td>
                        <select name="goal4q_opt_c2" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_c2 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_c2 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_c2 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_c2 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_c2 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_c2 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_c2 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_c2 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_c2 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_c2 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>

                    <td style="vertical-align: top;">
                        <textarea name="goal4q_txt_d2" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_d2, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr style="vertical-align: top;">
                    <td>
                        <select name="goal4q_opt_c3" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_c3 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_c3 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_c3 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_c3 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_c3 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_c3 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_c3 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_c3 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_c3 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_c3 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>

                    <td style="vertical-align: top;">
                        <textarea name="goal4q_txt_d3" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_d3, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr style="vertical-align: top;">
                    <td>
                        <select name="goal4q_opt_c4" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_c4 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_c4 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_c4 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_c4 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_c4 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_c4 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_c4 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_c4 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_c4 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_c4 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top;">
                        <textarea name="goal4q_txt_d4" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_d4, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td
                        rowspan="4"
                        class='text-middle wbr'>
                        <?php
                        echo "<input type='hidden' name='study_target04_4Q' value='" . $study_target04_4Q . "'>";
                        echo nl2br($study_target04_4Q);
                        ?>
                    </td>
                    <td rowspan="4"><?php _inputv("study_conversion04_4Q", $study_conversion04_4Q, "textarea", $edits, "h80", "255"); ?></td>
                    <td style="vertical-align: top;">
                        <select name="goal4q_opt_d1" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_d1 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_d1 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_d1 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_d1 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_d1 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_d1 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_d1 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_d1 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_d1 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_d1 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top;">
                        <textarea name="goal4q_txt_e1" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_e1, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">
                        <select name="goal4q_opt_d2" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_d2 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_d2 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_d2 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_d2 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_d2 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_d2 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_d2 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_d2 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_d2 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_d2 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top;">
                        <textarea name="goal4q_txt_e2" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_e2, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">
                        <select name="goal4q_opt_d3" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_d3 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_d3 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_d3 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_d3 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_d3 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_d3 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_d3 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_d3 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_d3 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_d3 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top;">
                        <textarea name="goal4q_txt_e3" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_e3, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">
                        <select name="goal4q_opt_d4" style="width: 100%;">
                            <option value="">-- 選択 --</option>
                            <option value="1" <?php if ($goal4q_opt_d4 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                            <option value="2" <?php if ($goal4q_opt_d4 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                            <option value="3" <?php if ($goal4q_opt_d4 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                            <option value="4" <?php if ($goal4q_opt_d4 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                            <option value="5" <?php if ($goal4q_opt_d4 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                            <option value="6" <?php if ($goal4q_opt_d4 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                            <option value="7" <?php if ($goal4q_opt_d4 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                            <option value="8" <?php if ($goal4q_opt_d4 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                            <option value="9" <?php if ($goal4q_opt_d4 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                            <option value="10" <?php if ($goal4q_opt_d4 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                        </select>
                    </td>
                    <td style="vertical-align: top;">
                        <textarea name="goal4q_txt_e4" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_e4, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>

                <?php
                if ($_SESSION['SELECT_NEN'] == 1) :
                ?>
                    <tr>
                        <td
                            rowspan="4"
                            class='text-middle wbr'>
                            <?php
                            echo "<input type='hidden' name='study_target05_4Q' value='" . $study_target05_4Q . "'>";
                            echo nl2br($study_target05_4Q);
                            ?>
                        </td>
                        <td rowspan="4">
                            <?php
                            _inputv("study_conversion05_4Q", $study_conversion05_4Q, "textarea", $edits, "h80", "255");
                            ?>
                        </td>

                        <td style="vertical-align: top;">
                            <select name="goal4q_opt_e1" style="width: 100%;">
                                <option value="">-- 選択 --</option>
                                <option value="1" <?php if ($goal4q_opt_e1 ===  "1") echo 'selected'; ?>>①他者に共感する力</option>
                                <option value="2" <?php if ($goal4q_opt_e1 ===  "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                                <option value="3" <?php if ($goal4q_opt_e1 ===  "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                                <option value="4" <?php if ($goal4q_opt_e1 ===  "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                                <option value="5" <?php if ($goal4q_opt_e1 ===  "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                                <option value="6" <?php if ($goal4q_opt_e1 ===  "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                                <option value="7" <?php if ($goal4q_opt_e1 ===  "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                                <option value="8" <?php if ($goal4q_opt_e1 ===  "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                                <option value="9" <?php if ($goal4q_opt_e1 ===  "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                                <option value="10" <?php if ($goal4q_opt_e1 ===  "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                            </select>
                        </td>

                        <td style="vertical-align: top;">
                            <textarea name="goal4q_txt_f1" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_f1, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td style="vertical-align: top;">
                            <select name="goal4q_opt_e2" style="width: 100%;">
                                <option value="">-- 選択 --</option>
                                <option value="1" <?php if ($goal4q_opt_e2 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                                <option value="2" <?php if ($goal4q_opt_e2 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                                <option value="3" <?php if ($goal4q_opt_e2 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                                <option value="4" <?php if ($goal4q_opt_e2 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                                <option value="5" <?php if ($goal4q_opt_e2 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                                <option value="6" <?php if ($goal4q_opt_e2 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                                <option value="7" <?php if ($goal4q_opt_e2 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                                <option value="8" <?php if ($goal4q_opt_e2 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                                <option value="9" <?php if ($goal4q_opt_e2 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                                <option value="10" <?php if ($goal4q_opt_e2 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                            </select>
                        </td>

                        <td style="vertical-align: top;">
                            <textarea name="goal4q_txt_f2" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_f2, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td style="vertical-align: top;">
                            <select name="goal4q_opt_e3" style="width: 100%;">
                                <option value="">-- 選択 --</option>
                                <option value="1" <?php if ($goal4q_opt_e3 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                                <option value="2" <?php if ($goal4q_opt_e3 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                                <option value="3" <?php if ($goal4q_opt_e3 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                                <option value="4" <?php if ($goal4q_opt_e3 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                                <option value="5" <?php if ($goal4q_opt_e3 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                                <option value="6" <?php if ($goal4q_opt_e3 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                                <option value="7" <?php if ($goal4q_opt_e3 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                                <option value="8" <?php if ($goal4q_opt_e3 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                                <option value="9" <?php if ($goal4q_opt_e3 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                                <option value="10" <?php if ($goal4q_opt_e3 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                            </select>
                        </td>

                        <td style="vertical-align: top;">
                            <textarea name="goal4q_txt_f3" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_f3, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td style="vertical-align: top;">
                            <select name="goal4q_opt_e4" style="width: 100%;">
                                <option value="">-- 選択 --</option>
                                <option value="1" <?php if ($goal4q_opt_e4 === "1") echo 'selected'; ?>>①他者に共感する力</option>
                                <option value="2" <?php if ($goal4q_opt_e4 === "2") echo 'selected'; ?>>②物事の本質を見極める力</option>
                                <option value="3" <?php if ($goal4q_opt_e4 === "3") echo 'selected'; ?>>③自分自身を理解する力</option>
                                <option value="4" <?php if ($goal4q_opt_e4 === "4") echo 'selected'; ?>>④自分事として問いを立てる力</option>
                                <option value="5" <?php if ($goal4q_opt_e4 === "5") echo 'selected'; ?>>⑤根拠にもとづいて思考する力</option>
                                <option value="6" <?php if ($goal4q_opt_e4 === "6") echo 'selected'; ?>>⑥自分らしい方法で表現する力</option>
                                <option value="7" <?php if ($goal4q_opt_e4 === "7") echo 'selected'; ?>>⑦自らの主張を吟味し、ふりかえる力</option>
                                <option value="8" <?php if ($goal4q_opt_e4 === "8") echo 'selected'; ?>>⑧多様性を尊重する力</option>
                                <option value="9" <?php if ($goal4q_opt_e4 === "9") echo 'selected'; ?>>⑨新たな価値を創造する力</option>
                                <option value="10" <?php if ($goal4q_opt_e4 === "10") echo 'selected'; ?>>⑩他者と対話し、協働する力</option>
                            </select>
                        </td>

                        <td style="vertical-align: top;">
                            <textarea name="goal4q_txt_f4" row="3" style="width: 100%;"><?php echo htmlspecialchars($goal4q_txt_f4, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </td>
                    </tr>

                <?php
                else:
                ?>
                    <input type="hidden" name='study_target05_4Q' value="">
                    <input type="hidden" name='study_conversion05_4Q' value="">
                    <input type="hidden" name="study_target06_4Q" value="">
                    <input type="hidden" name="study_conversion06_4Q" value="">

                <?php
                endif;
                ?>
            </table>
        </div>
        <?php
        dsip_koumoku("2-4 " . $_SESSION['SELECT_NEN'] . "年次の学修を通じて展望する「大学卒業後の自分」になるために、必要な資格・キャリア");
        ?>
        <div class='color_fluid4'>
            <table class='table table-bordered border-secondary'>
                <tr>
                    <td width='30%' class='text-middle wbr'>
                        <span class='fw600'>必要な資格<br>（福祉系の資格）<br>＊複数記述可<span class="fs80"></span>
                    </td>
                    <td width='70%'>
                        <?php
                        _inputv("qualification", $qualification, "textarea", $edits, "h80", "255");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td class='text-middle wbr'>
                        <span class='fw600'>必要な資格<br>（福祉系以外の資格）<br>＊複数記述可<span class="fs80"></span>
                    </td>
                    <td>
                        <?php
                        _inputv("qualification_other", $qualification_other, "textarea", $edits, "h80", "255");
                        ?>
                    </td>
                </tr>


                <tr>
                    <td class='text-middle wbr'>
                        <span class='fw600'>必要な教育①
                    </td>
                    <td>
                        <?php
                        _inputv("education1", $education1, "text", $edits, "h80", "255");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td class='text-middle'>
                        <span class='fw600'>必要な教育②
                    </td>

                    <td>
                        <?php
                        _inputv("education2", $education2, "text", $edits, "h80", "255");
                        ?>
                    </td>
                </tr>


                <tr>
                    <td class='text-middle'>
                        <span class='fw600'>必要な教育③
                    </td>
                    <td>
                        <?php
                        _inputv("education3", $education3, "text", $edits, "h80", "255");
                        ?>
                    </td>






                </tr>



                <tr>
                    <td class='text-middle'>
                        <span class='fw600'>必要な教育④
                    </td>


                    <td>
                        <?php
                        _inputv("education4", $education4, "text", $edits, "h80", "255");
                        ?>
                    </td>




                    </td>
                </tr>

                <tr>
                    <td class='text-middle'>
                        <span class='fw600'>必要な経験<br>（具体的に）<span class="fs80"></span>
                    </td>
                    <td>
                        <?php
                        _inputv("experience", $experience, "textarea", $edits, "h80", "255");
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php
        dsip_koumoku("2-5 上記の資格・キャリアを必要とする理由（具体的に）");
        ?>
        <span class="fs80"></span>
        <div class='color_fluid4'>
            <table class='table table-bordered border-secondary'>
                <tr>
                    <td>
                        <?php

                        _inputv("reason", $reason, "textarea", $edits, "h80", "255");
                        ?>

                    </td>
                </tr>
            </table>
        </div>

    </div>


    <h6>教員からのコメント</h6>
    <table class="table table-bordered border-secondary">
        <tr>
            <td><?php _inputv("comments_of_teacher", $comments_of_teacher, "textarea", "", "", "255"); ?></td>
        </tr>
    </table>


</div>



<br>


<input type='hidden' name='TABLE' value="tbl_goal_sheet_4q">
<input type='hidden' name='METHOD' value="UP_DATE">
<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $_SESSION['STUDENT_NUMBER']; ?>">
<input type='hidden' name='SELECT_NEN' value="<?PHP echo  $_SESSION['SELECT_NEN'] ?>">

<p class="text-center">
    <?php echo "状態：" . $mr[$GLOBALS['sta_go4Q']]; ?>
</p>

<?php
$GLOBALS['sta_go4Q'] = strval($GLOBALS['sta_go4Q']);
?>

<?PHP
$column = "goal4Q_" . $_SESSION['SELECT_NEN'];
?>

<table class="table">
    <tr>
        <td>
            <?php
            if (strpos(" 0 1 3", $GLOBALS['sta_go4Q']) == true) {
                $dis = "";
            } else {
                $dis = "disabled";
            }
           btn_submit("下書き", "draft", $column, $dis);
            ?>
        </td>
        <td>
            <?php
            if (strpos(" 0 1 3", $GLOBALS['sta_go4Q']) == true) {
                $dis = "";
            } else {
                $dis = "disabled";
            }
            btn_submit("提出", "submit", $column, $dis);
            ?>
        </td>

        <td>
            <?php btn_return("select_sheet.php", "戻る"); ?>
        </td>
    </tr>
</table>

<?PHP

echo "</form>";

require('./disp_parts/footer.php');
exit;
?>