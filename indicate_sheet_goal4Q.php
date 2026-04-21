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

$ACTION = "student_list.php";

require('./disp_parts/header.php');
require('data_keep.php');

tbl_profile_READ($_SESSION['SEL_STUDENT_NUMBER']);

if (!isset($_SESSION['SEL_SELECT_NEN'])) {
    $_SESSION['SEL_SELECT_NEN'] = "1";
}

// 選択肢の値と表示テキストの対応表
$options = [
    '1' => '①他者に共感する力',
    '2' => '②物事の本質を見極める力',
    '3' => '③自分自身を理解する力',
    '4' => '④自分事として問いを立てる力',
    '5' => '⑤根拠にもとづいて思考する力',
    '6' => '⑥自分らしい方法で表現する力',
    '7' => '⑦自らの主張を吟味し、ふりかえる力',
    '8' => '⑧多様性を尊重する力',
    '9' => '⑨新たな価値を創造する力',
    '10' => '⑩他者と対話し、協働する力',
];



tbl_status_check($_SESSION['SEL_STUDENT_NUMBER'], $_SESSION['SEL_SELECT_NEN']);

tbl_goal_sheet_1q_READ($_SESSION['SEL_STUDENT_NUMBER'], $_SESSION['SEL_SELECT_NEN']);
tbl_goal_sheet_4q_READ($_SESSION['SEL_STUDENT_NUMBER'], $_SESSION['SEL_SELECT_NEN']);

$study_target01_4Q = $study_conversion01;
$study_target02_4Q = $study_conversion02;
$study_target03_4Q = $study_conversion03;
$study_target04_4Q = $study_conversion04;

$study_target05_4Q = $study_conversion05;


dsip_midashi("学修行動計画(ゴール・シート)" . $_SESSION['SEL_SELECT_NEN']  . "年次（4Q）（" . $name . "）");
form_submit("registration.php");
dsip_koumoku("2-1." . $_SESSION['SEL_SELECT_NEN'] . "年次の学習を通じて展望する大学卒業後の自分（4Q）");
?>

<style>
    select:disabled {
        background-color: #fff !important;
        color: #000;
        opacity: 1;
        /* override any reduced opacity */
    }
</style>

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
            <td><?php _inputv("target_person_4Q", $target_person_4Q, "text", "", "", ""); ?><div class="text-end text-decoration-underline">に対して</div>
            </td>
            <td><?php _inputv("practical_field_4Q", $practical_field_4Q, "text", "", "", ""); ?><div class="text-end text-decoration-underline">で</div>
            </td>
            <td><?php _inputv("professional_position_4Q", $professional_position_4Q, "text", "", "", ""); ?><div class="text-end text-decoration-underline">として</div>
            </td>
            <td><?php _inputv("activity_issues_4Q", $activity_issues_4Q, "text", "", "", ""); ?><div class="text-end text-decoration-underline">を</div>
            </td>
            <td><?php _inputv("activity_method_4Q", $activity_method_4Q, "text", "", "", ""); ?><div class="text-end text-decoration-underline">によって（を用いて）</div>
            </td>
            <td><?php _inputv("aimed_results_4Q", $aimed_results_4Q, "text", "", "", ""); ?><div class="text-end text-decoration-underline">を実現する</div>
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
                2-2① なぜあなたはそれを目指すのですか？:
                <?php _inputv("your_goal_4Q", $your_goal_4Q, "textarea", "", "", "255"); ?>
            </td>
        </tr>
        <tr>
            <td>
                2-2② あなたが目指すものは、福祉の対象者や社会にとってなぜ必要ですか？:
                <?php _inputv("need_your_goal_4Q", $need_your_goal_4Q, "textarea", "", "", "255"); ?>
            </td>
        </tr>
    </table>
</div>


<?php

dsip_koumoku("2-3③ " . $_SESSION['SEL_SELECT_NEN'] . "年次の学修を通じて展望する「大学卒業後の自分」になるための「あなたの達成目標」、及びやること、努力すること（行動計画）");




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
                        <span class="fw600">あなたの到達目標の達成に向けて<br>次のクォーターまでに、あなたがさらにやること、努力すること</span>
                    </td>
                    <td width="25" class="text-center text-middle">
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
                        <?php echo "<input type='hidden' name='study_target01_4Q' value='" . $study_target01_4Q . "'>";
                        echo nl2br($study_target01_4Q); ?>
                    </td>
                    <td rowspan="4">
                        <?php _inputv("study_conversion01_4Q", $study_conversion01_4Q, "textarea", "", "", "255"); ?>
                    </td>
                    <?php
                    $selected_value = $goal4q_opt_a1 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>




                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_a1" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>





                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_b1" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">

                    </td>
                </tr>

                <tr>
                    <?php
                    $selected_value = $goal4q_opt_a2 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_a2" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>
                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_b2, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_b2" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>
                </tr>

                <tr>




                    <?php
                    $selected_value = $goal4q_opt_a3 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_a3" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>


                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_b3, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_b3" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                </tr>

                <tr>



                    <?php
                    $selected_value = $goal4q_opt_a4 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_a4" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>


                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_b4, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_b4" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                </tr>

                <tr>
                    <td rowspan="4" class='text-middle wbr'>
                        <?php echo "<input type='hidden' name='study_target02_4Q' value='" . $study_target02_4Q . "'>";
                        echo nl2br($study_target02_4Q); ?>
                    </td>
                    <td rowspan="4">
                        <?php _inputv("study_conversion02_4Q", $study_conversion02_4Q, "textarea", "", "", "255"); ?>
                    </td>



                    <?php
                    $selected_value = $goal4q_opt_b1 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_b1" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>


                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_c1, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_c1" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                </tr>

                <tr>


                    <?php
                    $selected_value = $goal4q_opt_b2 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_b2" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>


                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_c2, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_c2" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>
                </tr>

                <tr>


                    <?php
                    $selected_value = $goal4q_opt_b3 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_b3" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>


                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_c3, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_c3" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>
                </tr>

                <tr>

                    <?php
                    $selected_value = $goal4q_opt_b4 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_b4" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>
                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_c4, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_c4" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                </tr>

                <tr>
                    <td rowspan="4" class='text-middle wbr'>
                        <?php echo "<input type='hidden' name='study_target03_4Q' value='" . $study_target03_4Q . "'>";
                        echo nl2br($study_target03_4Q); ?>
                    </td>
                    <td rowspan="4">
                        <?php _inputv("study_conversion03_4Q", $study_conversion03_4Q, "textarea", "", "", "255"); ?>
                    </td>


                    <?php
                    $selected_value = $goal4q_opt_c1 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_c1" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_d1, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_d1" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                </tr>

                <tr style="vertical-align: top;">


                    <?php
                    $selected_value = $goal4q_opt_c2 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_c2" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_d2, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_d2" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>


                <tr style="vertical-align: top;">


                    <?php
                    $selected_value = $goal4q_opt_c3 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_c3" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_d3, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_d3" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                </tr>

                <tr style="vertical-align: top;">

                    <?php
                    $selected_value = $goal4q_opt_c4 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_c4" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>
                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_d4, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_d4" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                </tr>

                <tr>
                    <td
                        rowspan="4"
                        class='text-middle wbr'>
                        <?php echo "<input type='hidden' name='study_target04_4Q' value='" . $study_target04_4Q . "'>";
                        echo nl2br($study_target04_4Q); ?>
                    </td>
                    <td rowspan="4">
                        <?php _inputv("study_conversion04_4Q", $study_conversion04_4Q, "textarea", "", "", "255"); ?>
                    </td>


                    <?php
                    $selected_value = $goal4q_opt_d1 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_d1" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_e1, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_e1" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>


                <tr>

                    <?php
                    $selected_value = $goal4q_opt_d2 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_d2" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_e2, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_e2" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>
                </tr>

                <tr>

                    <?php
                    $selected_value = $goal4q_opt_d3 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_d3" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>
                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_e3, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_e3" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>
                </tr>

                <tr>

                    <?php
                    $selected_value = $goal4q_opt_d4 ?? '';
                    $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                    ?>
                    <td style="vertical-align: top;">
                        <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                        <input type="hidden" name="goal4q_opt_d4" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                    </td>

                    <td style="vertical-align: top; flex-wrap: nowrap;">
                        <?php echo htmlspecialchars($goal4q_txt_e4, ENT_QUOTES, 'UTF-8'); ?>
                        <input type="hidden" name="goal4q_txt_e4" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                    </td>
                </tr>

                <?php
                if ($_SESSION['SEL_SELECT_NEN'] == 1):
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
                            _inputv("study_conversion05_4Q", $study_conversion05_4Q, "textarea", "", "", "255");
                            ?>
                        </td>


                        <?php
                        $selected_value = $goal4q_opt_e1 ?? '';
                        $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                        ?>
                        <td style="vertical-align: top;">
                            <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                            <input type="hidden" name="goal4q_opt_e1" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                        </td>

                        <td style="vertical-align: top; flex-wrap: nowrap;">
                            <?php echo htmlspecialchars($goal4q_txt_f1, ENT_QUOTES, 'UTF-8'); ?>
                            <input type="hidden" name="goal4q_txt_f1" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                        </td>
                    </tr>

                    <tr>

                        <?php
                        $selected_value = $goal4q_opt_e2 ?? '';
                        $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                        ?>
                        <td style="vertical-align: top;">
                            <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                            <input type="hidden" name="goal4q_opt_e2" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                        </td>
                        <td style="vertical-align: top; flex-wrap: nowrap;">
                            <?php echo htmlspecialchars($goal4q_txt_f2, ENT_QUOTES, 'UTF-8'); ?>
                            <input type="hidden" name="goal4q_txt_f2" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                        </td>

                    </tr>

                    <tr>
                        <?php
                        $selected_value = $goal4q_opt_e3 ?? '';
                        $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                        ?>
                        <td style="vertical-align: top;">
                            <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                            <input type="hidden" name="goal4q_opt_e3" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                        </td>

                        <td style="vertical-align: top; flex-wrap: nowrap;">
                            <?php echo htmlspecialchars($goal4q_txt_f3, ENT_QUOTES, 'UTF-8'); ?>
                            <input type="hidden" name="goal4q_txt_f3" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                        </td>

                    </tr>

                    <tr>

                        <?php
                        $selected_value = $goal4q_opt_e4 ?? '';
                        $display_text = $options[$selected_value] ?? '-- 選択されていません --';
                        ?>
                        <td style="vertical-align: top;">
                            <?= htmlspecialchars($display_text, ENT_QUOTES, 'UTF-8') ?>
                            <input type="hidden" name="goal4q_opt_e4" value="<?= htmlspecialchars($selected_value, ENT_QUOTES, 'UTF-8') ?>">
                        </td>
                        <td style="vertical-align: top; flex-wrap: nowrap;">
                            <?php echo htmlspecialchars($goal4q_txt_f4, ENT_QUOTES, 'UTF-8'); ?>
                            <input type="hidden" name="goal4q_txt_f4" value="<?= htmlspecialchars($goal4q_txt_b1, ENT_QUOTES, 'UTF-8') ?>">
                        </td>

                    </tr>

                <?php
                else:
                ?>
                    <input type="hidden" name='study_target05_4Q' value="">
                    <input type="hidden" name='study_conversion05_4Q' value="">
                <?php
                endif;
                ?>
            </table>
        </div>
        <?php
        dsip_koumoku("2-4 " . $_SESSION['SEL_SELECT_NEN'] . "年次の学修を通じて展望する「大学卒業後の自分」になるために、必要な資格・キャリア");
        ?>
        <div class='color_fluid4'>
            <table class='table table-bordered border-secondary'>
                <tr>
                    <td width='30%' class='text-middle'>
                        <span class='fw600'>必要な資格<br>（福祉系の資格）<br>＊複数記述可
                    </td>
                    <td width='70%'>
                        <?php
                        _inputv("qualification", $qualification, "textarea", "", "", "255");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td class='text-middle'>
                        <span class='fw600'>必要な資格<br>（福祉系以外の資格）<br>＊複数記述可
                    </td>
                    <td>
                        <?php
                        _inputv("qualification_other", $qualification_other, "textarea", "", "", "255");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td class='text-middle'>
                        <span class='fw600'>必要な教育①
                    </td>
                    <td style='background-color:#ffffff'>
                        <?php
                        if ($education1 == '1') {
                            echo MATERIALS1;
                        } elseif ($education1 == '2') {
                            echo MATERIALS2;
                        } elseif ($education1 == '3') {
                            echo MATERIALS3;
                        } elseif ($education1 == '4') {
                            echo MATERIALS4;
                        } elseif ($education1 == '5') {
                            echo MATERIALS5;
                        } elseif ($education1 == '6') {
                            echo MATERIALS6;
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td class='text-middle'>
                        <span class='fw600'>必要な教育②
                    </td>
                    <td style='background-color:#ffffff'>
                        <?php
                        if ($education2 == '1') {
                            echo MATERIALS1;
                        } elseif ($education2 == '2') {
                            echo MATERIALS2;
                        } elseif ($education2 == '3') {
                            echo MATERIALS3;
                        } elseif ($education2 == '4') {
                            echo MATERIALS4;
                        } elseif ($education2 == '5') {
                            echo MATERIALS5;
                        } elseif ($education2 == '6') {
                            echo MATERIALS6;
                        }
                        ?>



                    </td>
                </tr>


                <tr>
                    <td class='text-middle'>
                        <span class='fw600'>必要な教育③
                    </td>
                    <td style='background-color:#ffffff'>
                        <?php
                        if ($education3 == '1') {
                            echo MATERIALS1;
                        } elseif ($education3 == '2') {
                            echo MATERIALS2;
                        } elseif ($education3 == '3') {
                            echo MATERIALS3;
                        } elseif ($education3 == '4') {
                            echo MATERIALS4;
                        } elseif ($education3 == '5') {
                            echo MATERIALS5;
                        } elseif ($education3 == '6') {
                            echo MATERIALS6;
                        }
                        ?>



                    </td>
                </tr>



                <tr>
                    <td class='text-middle'>
                        <span class='fw600'>必要な教育④
                    </td>
                    <td style='background-color:#ffffff'>

                        <?php
                        if ($education4 == '1') {
                            echo MATERIALS1;
                        } elseif ($education4 == '2') {
                            echo MATERIALS2;
                        } elseif ($education4 == '3') {
                            echo MATERIALS3;
                        } elseif ($education4 == '4') {
                            echo MATERIALS4;
                        } elseif ($education4 == '5') {
                            echo MATERIALS5;
                        } elseif ($education4 == '6') {
                            echo MATERIALS6;
                        }
                        ?>



                    </td>
                </tr>

                <tr>
                    <td class='text-middle'>
                        <span class='fw600'>必要な経験<br>（具体的に）
                    </td>
                    <td>
                        <?php
                        _inputv("experience", $experience, "textarea", "", "", "255");
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php
        dsip_koumoku("2-5 上記の資格・キャリアを必要とする理由（具体的に）");
        ?>

        <div class='color_fluid4'>
            <table class='table table-bordered border-secondary'>
                <tr>
                    <td>
                        <?php

                        _inputv("reason", $reason, "textarea", "", "", "255");
                        ?>

                    </td>
                </tr>
            </table>
        </div>



        <h6>教員からのコメント <span class="fs80"></span></h6>
        <table class="table table-bordered border-secondary">
            <tr>
                <td><?php _inputv("comments_of_teacher", $comments_of_teacher, "textarea", "edit", "", "255"); ?></td>
            </tr>
        </table>




    </div>


</div>



<br>


<input type='hidden' name='TABLE' value="tbl_goal_sheet_4q">
<input type='hidden' name='METHOD' value="COMMENT_UP">
<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $_SESSION['SEL_STUDENT_NUMBER']; ?>">
<input type='hidden' name='SELECT_NEN' value="<?PHP echo  $_SESSION['SEL_SELECT_NEN'] ?>">




<p class="text-center">
    <?php echo "状態：" . $mr[$GLOBALS['sta_go4Q']]; ?>
</p>

<?php
$GLOBALS['sta_go4Q'] = strval($GLOBALS['sta_go4Q']);
?>

<?php
    $column = "goal4Q_" . $_SESSION['SEL_SELECT_NEN'];
?>


<table class="table">
    <tr>

        <td>
            <?php
            if (strpos(" 2 3 4 ", $GLOBALS['sta_go4Q']) == true) {
                $dis = "";
            } else {
                $dis = "disabled";
            }
            btn_submit("要修正", "fix", $column, $dis);
            ?>
        </td>

        <td>
            <?php
            if (strpos(" 2 3 4 ", $GLOBALS['sta_go4Q']) == true) {
                $dis = "";
            } else {
                $dis = "disabled";
            }
            btn_submit("承認", "approve", $column, $dis);

            ?>
        </td>
        <td>
            <?php btn_return("student_list.php", "戻る"); ?>
        </td>

    </tr>
</table>


<?php


echo "</form>";


require('./disp_parts/footer.php');
exit;
?>