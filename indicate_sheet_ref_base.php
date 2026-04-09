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

$ACTION = "student_list.php";

require('./disp_parts/headerNonlistS.php');
?>
<style>
  input[type="radio"] {
    pointer-events: none;
    /* クリック不可にする */
  }
</style>
<?PHP
require('data_keep.php');

// スコア値（これはどこかで渡ってくる前提）




if (!isset($_SESSION['NAME'])) {
  $_SESSION['NAME'] = "Unknown student";
}
$name = $_SESSION['NAME'];

$dis1 = "";
$dis2 = "";
$dis3 = "";
$dis4 = "";

switch ($_SESSION['SEL_SELECT_NEN']) {
  case "1":
    $dis1 = "";
    break;
  case "2":
    $dis2 = "";
    break;
  case "3":
    $dis3 = "";
    break;
  case "4":
    $dis4 = "";
    break;
}

$student_number = $_SESSION['SEL_STUDENT_NUMBER'];
tbl_status_check($_SESSION['SEL_STUDENT_NUMBER'], $_SESSION['SEL_SELECT_NEN']);


$column = "ref_base_" . $_SESSION['SEL_SELECT_NEN'];


//年度ごと
$sta = $GLOBALS['sta_prof'];
$sta = $GLOBALS['sta_go1Q'];
$sta = $GLOBALS['sta_go4Q'];
$sta = $GLOBALS['sta_rbas'];
//ここからは実習リフレクション
$sta = $GLOBALS['sta_rsw1'];
$sta = $GLOBALS['sta_rsw2'];
$sta = $GLOBALS['sta_rintern'];
$sta = $GLOBALS['sta_rmental1'];
$sta = $GLOBALS['sta_radv'];
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




tbl_profile_READ($_SESSION['SEL_STUDENT_NUMBER']);
dsip_midashi("学修行動計画（リフレクション・シート）＜" . $_SESSION['SEL_SELECT_NEN'] . "年次＞（" . $name . "）");





//////////////////////////////////////////////////
// リフレクションシート読込
//////////////////////////////////////////////////



$力獲得目標1_1Q1 = "";
$力獲得目標1_1Q2 = "";
$力獲得目標1_1Q3 = "";
$力獲得目標1_1Q4 = "";


$力獲得目標2_1Q1 = "";
$力獲得目標2_1Q2 = "";
$力獲得目標2_1Q3 = "";
$力獲得目標2_1Q4 = "";

$力獲得目標3_1Q1 = "";
$力獲得目標3_1Q2 = "";
$力獲得目標3_1Q3 = "";
$力獲得目標3_1Q4 = "";


$力獲得目標4_1Q1 = "";
$力獲得目標4_1Q2 = "";
$力獲得目標4_1Q3 = "";
$力獲得目標4_1Q4 = "";


$力獲得目標5_1Q1 = "";
$力獲得目標5_1Q2 = "";
$力獲得目標5_1Q3 = "";
$力獲得目標5_1Q4 = "";


$力獲得目標1_4Q1 = "";
$力獲得目標1_4Q2 = "";
$力獲得目標1_4Q3 = "";
$力獲得目標1_4Q4 = "";


$力獲得目標2_4Q1 = "";
$力獲得目標2_4Q2 = "";
$力獲得目標2_4Q3 = "";
$力獲得目標2_4Q4 = "";

$力獲得目標3_4Q1 = "";
$力獲得目標3_4Q2 = "";
$力獲得目標3_4Q3 = "";
$力獲得目標3_4Q4 = "";


$力獲得目標4_4Q1 = "";
$力獲得目標4_4Q2 = "";
$力獲得目標4_4Q3 = "";
$力獲得目標4_4Q4 = "";


$力獲得目標5_4Q1 = "";
$力獲得目標5_4Q2 = "";
$力獲得目標5_4Q3 = "";
$力獲得目標5_4Q4 = "";





try {
  $stmt = $pdo->prepare("
  SELECT textarea_b1, textarea_b2, textarea_b3, textarea_b4,
                textarea_c1, textarea_c2, textarea_c3, textarea_c4,
                textarea_d1, textarea_d2, textarea_d3, textarea_d4,
                textarea_e1, textarea_e2, textarea_e3, textarea_e4,
                textarea_f1, textarea_f2, textarea_f3, textarea_f4,
                textarea_h1, textarea_h2, textarea_h3, textarea_h4
       FROM tbl_goal_sheet_1q 
       WHERE student_number = ? 
       AND school_year = ?
       ");



  $stmt->execute([$_SESSION['SEL_STUDENT_NUMBER'], $_SESSION['SEL_SELECT_NEN']]);


  if ($value = $stmt->fetch(PDO::FETCH_ASSOC)) {



    $力獲得目標1_1Q1 = $value['textarea_b1'];
    $力獲得目標1_1Q2 = $value['textarea_b2'];
    $力獲得目標1_1Q3 = $value['textarea_b3'];
    $力獲得目標1_1Q4 = $value['textarea_b4'];


    $力獲得目標2_1Q1 = $value['textarea_c1'];
    $力獲得目標2_1Q2 = $value['textarea_c2'];
    $力獲得目標2_1Q3 = $value['textarea_c3'];
    $力獲得目標2_1Q4 = $value['textarea_c4'];

    $力獲得目標3_1Q1 = $value['textarea_d1'];
    $力獲得目標3_1Q2 = $value['textarea_d2'];
    $力獲得目標3_1Q3 = $value['textarea_d3'];
    $力獲得目標3_1Q4 = $value['textarea_d4'];


    $力獲得目標4_1Q1 = $value['textarea_e1'];
    $力獲得目標4_1Q2 = $value['textarea_e2'];
    $力獲得目標4_1Q3 = $value['textarea_e3'];
    $力獲得目標4_1Q4 = $value['textarea_e4'];


    $力獲得目標5_1Q1 = $value['textarea_f1'];
    $力獲得目標5_1Q2 = $value['textarea_f2'];
    $力獲得目標5_1Q3 = $value['textarea_f3'];
    $力獲得目標5_1Q4 = $value['textarea_f4'];


    $力獲得目標1_4Q1 = $力獲得目標1_1Q1;
    $力獲得目標1_4Q2 = $力獲得目標1_1Q2;
    $力獲得目標1_4Q3 = $力獲得目標1_1Q3;
    $力獲得目標1_4Q4 = $力獲得目標1_1Q4;


    $力獲得目標2_4Q1 = $力獲得目標2_1Q1;
    $力獲得目標2_4Q2 = $力獲得目標2_1Q2;
    $力獲得目標2_4Q3 = $力獲得目標2_1Q3;
    $力獲得目標2_4Q4 = $力獲得目標2_1Q4;

    $力獲得目標3_4Q1 = $力獲得目標3_1Q1;
    $力獲得目標3_4Q2 = $力獲得目標3_1Q2;
    $力獲得目標3_4Q3 = $力獲得目標3_1Q3;
    $力獲得目標3_4Q4 = $力獲得目標3_1Q4;


    $力獲得目標4_4Q1 = $力獲得目標4_1Q1;
    $力獲得目標4_4Q2 = $力獲得目標4_1Q2;
    $力獲得目標4_4Q3 = $力獲得目標4_1Q3;
    $力獲得目標4_4Q4 = $力獲得目標4_1Q4;


    $力獲得目標5_4Q1 = $力獲得目標5_1Q1;
    $力獲得目標5_4Q2 = $力獲得目標5_1Q2;
    $力獲得目標5_4Q3 = $力獲得目標5_1Q3;
    $力獲得目標5_4Q4 = $力獲得目標5_1Q4;
  }
} catch (PDOException $e) {
  error_log("tbl_goal_sheet_1q (tbl_reflection_base) Error: " . $e->getMessage());

  echo "An error occurred while fetching reflection data.";
  die();
}

// 接続を閉じる


tbl_reflection_base_READ($_SESSION['SEL_STUDENT_NUMBER'], $_SESSION['SEL_SELECT_NEN']);



$ref_base_fields = [
  '共通目標1',
  '自己目標1',
  '出来た1',
  '出来ず1',
  'ref1_1Q1',
  'ref1_1Q2',
  'ref1_1Q3',
  'ref1_1Q4',
  'ref1_4Q1',
  'ref1_4Q2',
  'ref1_4Q3',
  'ref1_4Q4',
  '今後目標1_1Q',
  '今後目標1_4Q',
  '今後課題1_1Q',
  '今後課題1_4Q',
  '共通目標2',
  '自己目標2',
  '出来た2',
  '出来ず2',
  'ref2_1Q1',
  'ref2_1Q2',
  'ref2_1Q3',
  'ref2_1Q4',
  'ref2_4Q1',
  'ref2_4Q2',
  'ref2_4Q3',
  'ref2_4Q4',
  '今後目標2_1Q',
  '今後目標2_4Q',
  '今後課題2_1Q',
  '今後課題2_4Q',
  '共通目標3',
  '自己目標3',
  '出来た3',
  '出来ず3',
  'ref3_1Q1',
  'ref3_1Q2',
  'ref3_1Q3',
  'ref3_1Q4',
  'ref3_4Q1',
  'ref3_4Q2',
  'ref3_4Q3',
  'ref3_4Q4',
  '今後目標3_1Q',
  '今後目標3_4Q',
  '今後課題3_1Q',
  '今後課題3_4Q',
  '共通目標4',
  '自己目標4',
  '出来た4',
  '出来ず4',
  'ref4_1Q1',
  'ref4_1Q2',
  'ref4_1Q3',
  'ref4_1Q4',
  'ref4_4Q1',
  'ref4_4Q2',
  'ref4_4Q3',
  'ref4_4Q4',
  '今後目標4_1Q',
  '今後目標4_4Q',
  '今後課題4_1Q',
  '今後課題4_4Q',
  '共通目標5',
  '自己目標5',
  '出来た5',
  '出来ず5',
  'ref5_1Q1',
  'ref5_1Q2',
  'ref5_1Q3',
  'ref5_1Q4',
  'ref5_4Q1',
  'ref5_4Q2',
  'ref5_4Q3',
  'ref5_4Q4',
  '今後目標5_1Q',
  '今後目標5_4Q',
  '今後課題5_1Q',
  '今後課題5_4Q',
  'score1Q1',
  'score1Q4',
  'score2Q1',
  'score2Q4',
  'score3Q1',
  'score3Q4',
  'score4Q1',
  'score4Q4',
  'score5Q1',
  'score5Q4'    
];

foreach ($ref_base_fields as $field) {
  $$field = $GLOBALS[$field];
  error_log("Assigned \$$field = '{$$field}'");
}







$labels = [
  4 => "４. 十分達成できた",
  3 => "３. やや達成できた",
  2 => "２.あまり達成できなかった",
  1 => "１.全く達成できなかった"
];




if ($_SESSION['SEL_SELECT_NEN'] == 1) {
  $study_target01 = "大学生として必要な、学ぶための基礎的な知識やスキルを習得している（Ⅰ類科目・基礎ゼミナール）";
  $study_target02 = "大学生として必要な、学ぶための基本的な態度を獲得している（全科目）";
  $study_target03 = "福祉マインドに関わる基本敵な知識を習得している（福祉入門・社会福祉言論・社会保障論等）";
  $study_target04 = "福祉マインドに関わる基本的な態度を獲得している（基礎ゼミナール・ソーシャルワーク演習）";

  $study_target05 = "グループの特性に応じて、適切なリーダーシップやメンバーシップを発揮する姿勢を有している。";
  $study_target06 = "";
}


if ($_SESSION['SEL_SELECT_NEN'] == 2) {
  $study_target01 = "福祉マインドを持つ人材としての思想や指針となる理論、支援に役立つ知識・技術を理解するために必要な読解力、記述力及び学びの方法を身につけている";
  $study_target02 = "学んだことを生かして、自らの生き方及び果たすべき役割や責任について考察を深めることができる。";
  $study_target03 = "他者と協働し、共生社会構築の役割を担う意欲を持っている。";
  $study_target04 = "自分自身の言動を振り返り、意識的な変容の意図のもと、自身の成長につなげることができる。";
  $study_target05 = "";
  $study_target06 = "";
}


if ($_SESSION['SEL_SELECT_NEN'] == 3) {
  $study_target01 = "福祉マインドを持つ人材としての思想や指針となる理論、支援に役立つ知識・技術を理解するために必要な読解力、記述力及び学びの方法を身につけている。";
  $study_target02 = "学んだ知識について、自らの考えを他者に対して的確に表現することができる。";
  $study_target03 = "社会福祉学の学びから学習や研究課題を設定し、主体的に取り組む姿勢を有している。";
  $study_target04 = "社会福祉学の価値・知識・技術を理解し活用できるよう、日々成果を蓄積しようとする意欲を持っている。";
  $study_target05 = "";
  $study_target06 = "";
}


if ($_SESSION['SEL_SELECT_NEN'] == 4) {
  $study_target01 = "地域共生社会の実現に向け、社会福祉学の価値・知識・技術を人と社会に対する支援に活用する方法を身につけている。";
  $study_target02 = "社会福祉学領域の研究や方法を通じて、地域社会や身近な人々の間で生じている問題を発見し、その解決方法を判断し、改善を図ることができる。";
  $study_target03 = "知識集約型社会を見据えて、自らの専門分野の学問領域と他の学問領域を統合的に学び、多面的・重層的な思考をすることで、複雑で多様な現代社会の課題に応えることができる。";
  $study_target04 = "多様な人々の価値観を受け止め、円滑な人間関係を築き、チームアプローチにより目標達成に向けて努力することができる。";
  $study_target05 = "";
  $study_target06 = "";
}



$自己目標1 = $study_target01;
$自己目標2 = $study_target02;
$自己目標3 = $study_target03;
$自己目標4 = $study_target04;
$自己目標5 = $study_target05;

form_submit("registration.php");
?>
<table class="table changing-line">
  <tr style="border: 1px solid #fff">
    <td width="5%" rowspan="2" class="changing-line text-center text-middle color_td1">
      <span class="fw600">年次</span>
    </td>


    <td width="11%" rowspan="2" class='changing-line text-middle color_td1'>
      <span class="fw600">1.共通の到達目標</span>
    </td>


    <td width="11%" rowspan="2" class='changing-line text-middle color_td1'>
      <span class="fw600">2.「共通の到達目標」を踏まえた、あなたの到達目標</span>
    </td>
    <td colspan="5" class="changing-line text-center text-middle color_td1">
      <span class="fw600">3.学修行動の振り返り</span>
    </td>

    <td width="11%" rowspan="2" class='changing-line text-middle color_td4'>
      <span class="fw600">4.3.の振り返りを踏まえた「あなたの到達目標」</span>
      <br><span class="fs80"></span>
    </td>
    <td width="11%" rowspan="2" class='changing-line text-middle color_td4'>
      <span class="fw600">5.「あなたの到達目標」達成に向けて、次のクォーターまでに、あなたがさらにやること、努力すること</span><br>
      <span class="fs80"></span>
    </td>
  </tr>


  <tr style="border: 1px solid #fff">


    <td width="11%" class='changing-line text-middle color_td1'>
      <span class="fw600">①.共通の目標達成度評価(評価基準表に基づき自己評価)</span>
      <br><span class="fs80"></span>
    </td>



    <td class='changing-line text-middle color_td1'>
      <span class="fw600">①の自己評価点</span>
      <br><span class="fs80"></span>
    </td>


    <td width="11%" class='changing-line text-middle color_td1'>
      <span class="fw600">②.①に関して、あなたが獲得できたこと、達成できたこと、できるようになったこと（2.「あなたの達成目標」に関連付けて記述）</span>
      <br><span class="fs80"></span>
    </td>
    <td width="11%" class='changing-line text-middle color_td1'>
      <span class="fw600">③ あなたの到達目標の達成に必要な力（1Qゴールシートであなたが獲得目標として設定した力）</span>
    </td>
    <td width="11%" class='changing-line text-middle color_td1'>
      <span class="fw600">④ ③で掲げた獲得目標の達成度評価
        <span class="fs80">（50字以上）</span>
    </td>
  </tr>




  <!-------------------------------------------------------------->

  <tr style="border: 1px solid #fff">
    <td rowspan="4" class='changing-line text-middle color_td1'>
      <span class='fw600 text-center'><?php echo h($_SESSION['SEL_SELECT_NEN']); ?>年次<br>(1Q/2Q)</span>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("共通目標1", $study_target01, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr ' style="vertical-align: top;">
      <?php _inputv("自己目標1", $自己目標1, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("出来た1", $出来た1, "textarea", "", "h200", "255"); ?>
    </td>


    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">

      <div>
        <?php foreach ($labels as $val => $text): ?>
          <?php if ($score1Q1 == $val): ?>
            <i class="fa-regular fa-circle-check" style="color: blue;"></i> <?= htmlspecialchars($text) ?>
          <?php else: ?>
            <i class="fa-regular fa-circle" style="color: gray;"></i> <?= htmlspecialchars($text) ?>
          <?php endif; ?>
          <br><br>
        <?php endforeach; ?>
      </div>

    </td>


    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("出来ず1", $出来ず1, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標1_1Q1", $力獲得目標1_1Q1, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref1_1Q1", $ref1_1Q1, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後目標1_1Q", $今後目標1_1Q, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後課題1_1Q", $今後課題1_1Q, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標1_1Q2", $力獲得目標1_1Q2, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref1_1Q2", $ref1_1Q2, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標1_1Q3", $力獲得目標1_1Q3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref1_1Q3", $ref1_1Q4, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標1_1Q4", $力獲得目標1_1Q4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref1_1Q4", $ref1_1Q4, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr style="border: 1px solid #fff">
    <td rowspan='4' class='changing-line text-middle color_td4'>
      <span class='fw600 text-center'><?php echo h($_SESSION['SEL_SELECT_NEN']); ?>年次<br>(3Q/4Q)</span>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo $study_target01; ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr ' style="vertical-align: top;">
      <?php echo $自己目標1; ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo  $出来た1; ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">

<div>
  <?php foreach ($labels as $val => $text): ?>
    <?php if ($score1Q4 == $val): ?>
      <i class="fa-regular fa-circle-check" style="color: blue;"></i> <?= htmlspecialchars($text) ?>
    <?php else: ?>
      <i class="fa-regular fa-circle" style="color: gray;"></i> <?= htmlspecialchars($text) ?>
    <?php endif; ?>
    <br><br>
  <?php endforeach; ?>
</div>

    </td>

    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo $出来ず1; ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標1_4Q1", $力獲得目標1_4Q1, "textarea", "", "h200", "255"); ?>
    </td>

    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref1_4Q1", $ref1_4Q1, "textarea", "", "h200", "255"); ?>
    </td>




    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後目標1_4Q", $今後目標1_4Q, "textarea", "", "h200", "255"); ?>
    </td>


    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後課題1_4Q", $今後課題1_4Q, "textarea", "", "h200", "255"); ?>
    </td>



  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標1_4Q3", $力獲得目標1_4Q3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref1_4Q2", $ref1_4Q2, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>




  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標1_4Q3", $力獲得目標1_4Q3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref1_4Q3", $ref1_4Q3, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>




  <tr style="border: 1px solid #555">
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標1_4Q4", $力獲得目標1_4Q4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref1_4Q4", $ref1_4Q4, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>





  <tr style="border: 1px solid #fff">
    <td rowspan="4" class='changing-line text-middle color_td1'>
      <span class='fw600 text-center'><?php echo h($_SESSION['SEL_SELECT_NEN']); ?>年次<br>(1Q/2Q)</span>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("共通目標2", $study_target02, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("自己目標2", $自己目標2, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("出来た2", $出来た2, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">

     
<div>
  <?php foreach ($labels as $val => $text): ?>
    <?php if ($score2Q1 == $val): ?>
      <i class="fa-regular fa-circle-check" style="color: blue;"></i> <?= htmlspecialchars($text) ?>
    <?php else: ?>
      <i class="fa-regular fa-circle" style="color: gray;"></i> <?= htmlspecialchars($text) ?>
    <?php endif; ?>
    <br><br>
  <?php endforeach; ?>
</div>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("出来ず2", $出来ず2, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標2_1Q1", $力獲得目標2_1Q1, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref2_1Q1", $ref2_1Q1, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後目標2_1Q", $今後目標2_1Q, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後課題2_1Q", $今後課題2_1Q, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標2_1Q2", $力獲得目標2_1Q2, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref2_1Q2", $ref2_1Q2, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標2_1Q3", $力獲得目標2_1Q3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref2_1Q3", $ref2_1Q3, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標2_1Q4", $力獲得目標2_1Q4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref2_1Q4", $ref2_1Q4, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr style="border: 1px solid #fff">
    <td rowspan='4' class='changing-line text-middle color_td4'>
      <span class='fw600 text-center'><?php echo h($_SESSION['SEL_SELECT_NEN']); ?>年次<br>(3Q/4Q)</span>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo $study_target02; ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo $自己目標2; ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo $出来た2; ?>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">

    
<div>
  <?php foreach ($labels as $val => $text): ?>
    <?php if ($score2Q4 == $val): ?>
      <i class="fa-regular fa-circle-check" style="color: blue;"></i> <?= htmlspecialchars($text) ?>
    <?php else: ?>
      <i class="fa-regular fa-circle" style="color: gray;"></i> <?= htmlspecialchars($text) ?>
    <?php endif; ?>
    <br><br>
  <?php endforeach; ?>
</div>

    </td>

    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo  $出来ず2; ?>
    </td>



    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標2_4Q1", $力獲得目標2_4Q1, "textarea", "", "h200", "255"); ?>
    </td>

    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref2_4Q1", $ref2_4Q1, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後目標2_4Q", $今後目標2_4Q, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後課題2_4Q", $今後課題2_4Q, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標2_4Q2", $力獲得目標2_4Q2, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref2_4Q2", $ref2_4Q2, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標2_4Q3", $力獲得目標2_4Q3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref2_4Q3", $ref2_4Q3, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #555">
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標2_4Q4", $力獲得目標2_4Q4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref2_4Q4", $ref2_4Q4, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>



  <tr style="border: 1px solid #fff">
    <td rowspan="4" class='changing-line text-middle color_td1'>
      <span class='fw600 text-center'><?php echo h($_SESSION['SEL_SELECT_NEN']); ?>年次<br>(1Q/2Q)</span>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("共通目標3", $study_target03, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("自己目標3", $自己目標3, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("出来た3", $出来た3, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">

     
<div>
  <?php foreach ($labels as $val => $text): ?>
    <?php if ($score3Q1 == $val): ?>
      <i class="fa-regular fa-circle-check" style="color: blue;"></i> <?= htmlspecialchars($text) ?>
    <?php else: ?>
      <i class="fa-regular fa-circle" style="color: gray;"></i> <?= htmlspecialchars($text) ?>
    <?php endif; ?>
    <br><br>
  <?php endforeach; ?>
</div>

    </td>

    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("出来ず3", $出来ず3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標3_1Q1", $力獲得目標3_1Q1, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref3_1Q1", $ref3_1Q1, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後目標3_1Q", $今後目標3_1Q, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後課題3_1Q", $今後課題3_1Q, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標3_1Q2", $力獲得目標3_1Q2, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref3_1Q2", $ref3_1Q2, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標3_1Q3", $力獲得目標3_1Q3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref3_1Q3", $ref3_1Q3, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標3_1Q4", $力獲得目標3_1Q4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref3_1Q4", $ref3_1Q4, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr style="border: 1px solid #fff">
    <td rowspan='4' class='changing-line text-middle color_td4'>
      <span class='fw600 text-center'><?php echo h($_SESSION['SEL_SELECT_NEN']); ?>年次<br>(3Q/4Q)</span>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo $study_target03; ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo  $自己目標3; ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo  $出来た3; ?>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">

   
<div>
  <?php foreach ($labels as $val => $text): ?>
    <?php if ($score3Q4 == $val): ?>
      <i class="fa-regular fa-circle-check" style="color: blue;"></i> <?= htmlspecialchars($text) ?>
    <?php else: ?>
      <i class="fa-regular fa-circle" style="color: gray;"></i> <?= htmlspecialchars($text) ?>
    <?php endif; ?>
    <br><br>
  <?php endforeach; ?>
</div>

    </td>

    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo  $出来ず3; ?>
    </td>


    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標3_4Q1", $力獲得目標3_4Q1, "textarea", "", "h200", "255"); ?>
    </td>

    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref3_4Q1", $ref3_4Q1, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後目標3_4Q", $今後目標3_4Q, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後課題3_4Q", $今後課題3_4Q, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標3_4Q2", $力獲得目標3_4Q2, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref3_4Q2", $ref3_4Q2, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標3_4Q3", $力獲得目標3_4Q3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref3_4Q3", $ref3_4Q3, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #555">
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標3_4Q4", $力獲得目標3_4Q4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref3_4Q4", $ref3_4Q4, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>




  <tr style="border: 1px solid #fff">
    <td rowspan="4" class='changing-line text-middle color_td1'>
      <span class='fw600 text-center'><?php echo h($_SESSION['SEL_SELECT_NEN']); ?>年次<br>(1Q/2Q)</span>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("共通目標4", $study_target04, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("自己目標4", $自己目標4, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("出来た4", $出来た4, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">

<div>
  <?php foreach ($labels as $val => $text): ?>
    <?php if ($score4Q1 == $val): ?>
      <i class="fa-regular fa-circle-check" style="color: blue;"></i> <?= htmlspecialchars($text) ?>
    <?php else: ?>
      <i class="fa-regular fa-circle" style="color: gray;"></i> <?= htmlspecialchars($text) ?>
    <?php endif; ?>
    <br><br>
  <?php endforeach; ?>
</div>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("出来ず4", $出来ず4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標4_1Q1", $力獲得目標4_1Q1, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref4_1Q1", $ref4_1Q1, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後目標4_1Q", $今後目標4_1Q, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後課題4_1Q", $今後課題4_1Q, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標4_1Q2", $力獲得目標4_1Q2, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref4_1Q2", $ref4_1Q2, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標4_1Q3", $力獲得目標4_1Q3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref4_1Q3", $ref4_1Q3, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標4_1Q4", $力獲得目標4_1Q4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr' style="vertical-align: top;">
      <?php _inputv("ref4_1Q4", $ref4_1Q4, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr style="border: 1px solid #fff">
    <td rowspan='4' class='changing-line text-middle color_td4'>
      <span class='fw600 text-center'><?php echo h($_SESSION['SEL_SELECT_NEN']); ?>年次<br>(3Q/4Q)</span>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo $study_target04; ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo $自己目標4; ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo  $出来た4; ?>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">

 <div>
  <?php foreach ($labels as $val => $text): ?>
    <?php if ($score4Q4 == $val): ?>
      <i class="fa-regular fa-circle-check" style="color: blue;"></i> <?= htmlspecialchars($text) ?>
    <?php else: ?>
      <i class="fa-regular fa-circle" style="color: gray;"></i> <?= htmlspecialchars($text) ?>
    <?php endif; ?>
    <br><br>
  <?php endforeach; ?>
</div>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php echo  $出来ず4; ?>
    </td>



    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標4_4Q1", $力獲得目標4_4Q1, "textarea", "", "h200", "255"); ?>
    </td>

    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref4_4Q1", $ref4_4Q1, "textarea", "", "h200", "255"); ?>
    </td>
    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後目標4_4Q", $今後目標4_4Q, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("今後課題4_4Q", $今後課題4_4Q, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標4_4Q2", $力獲得目標4_4Q2, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref4_4Q2", $ref4_4Q2, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標4_4Q3", $力獲得目標4_4Q3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref4_4Q3", $ref4_4Q3, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>
  <tr style="border: 1px solid #555">
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("力獲得目標4_4Q4", $力獲得目標4_4Q4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td4 wbr' style="vertical-align: top;">
      <?php _inputv("ref4_4Q4", $ref4_4Q4, "textarea", "", "h200", "255"); ?>
    </td>
  </tr>






  <?php if ($_SESSION['SEL_SELECT_NEN'] == 1) { ?>


    <tr style="border: 1px solid #fff">
      <td rowspan="4" class='changing-line text-middle color_td1'>
        <span class='fw600 text-center'><?php echo h($_SESSION['SEL_SELECT_NEN']); ?>年次<br>(1Q/2Q)</span>
      </td>
      <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
        <?php _inputv("共通目標5", $study_target05, "textarea", "", "h200", "255"); ?>
      </td>
      <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
        <?php _inputv("自己目標5", $自己目標5, "textarea", "", "h200", "255"); ?>
      </td>
      <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
        <?php _inputv("出来た5", $出来た5, "textarea", "", "h200", "255"); ?>
      </td>
      <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">

    <div>
  <?php foreach ($labels as $val => $text): ?>
    <?php if ($score5Q1 == $val): ?>
      <i class="fa-regular fa-circle-check" style="color: blue;"></i> <?= htmlspecialchars($text) ?>
    <?php else: ?>
      <i class="fa-regular fa-circle" style="color: gray;"></i> <?= htmlspecialchars($text) ?>
    <?php endif; ?>
    <br><br>
  <?php endforeach; ?>
</div>
      </td>

      <td rowspan="4" class='changing-line color_td1 wbr' style="vertical-align: top;">
        <?php _inputv("出来ず5", $出来ず5, "textarea", "", "h200", "255"); ?>
      </td>
      <td class='changing-line color_td1 wbr' style="vertical-align: top;">
        <?php _inputv("力獲得目標5_1Q1", $力獲得目標5_1Q1, "textarea", "", "h200", "255"); ?>
      </td>
      <td class='changing-line color_td1 wbr' style="vertical-align: top;">
        <?php _inputv("ref5_1Q1", $ref5_1Q1, "textarea", "", "h200", "255"); ?>
      </td>
      <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php _inputv("今後目標5_1Q", $今後目標5_1Q, "textarea", "", "h200", "255"); ?>
      </td>
      <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php _inputv("今後課題5_1Q", $今後課題5_1Q, "textarea", "", "h200", "255"); ?>
      </td>
    </tr>
    <tr style="border: 1px solid #fff">
      <td class='changing-line color_td1 wbr' style="vertical-align: top;">
        <?php _inputv("力獲得目標5_1Q2", $力獲得目標5_1Q2, "textarea", "", "h200", "255"); ?>
      </td>
      <td class='changing-line color_td1 wbr' style="vertical-align: top;">
        <?php _inputv("ref5_1Q2", $ref5_1Q2, "textarea", "", "h200", "255"); ?>
      </td>
    </tr>
    <tr style="border: 1px solid #fff">
      <td class='changing-line color_td1 wbr' style="vertical-align: top;">
        <?php _inputv("力獲得目標5_1Q3", $力獲得目標5_1Q3, "textarea", "", "h200", "255"); ?>
      </td>
      <td class='changing-line color_td1 wbr' style="vertical-align: top;">
        <?php _inputv("ref5_1Q3", $ref5_1Q3, "textarea", "", "h200", "255"); ?>
      </td>
    </tr>
    <tr style="border: 1px solid #fff">
      <td class='changing-line color_td1 wbr' style="vertical-align: top;">
        <?php _inputv("力獲得目標5_1Q4", $力獲得目標5_1Q4, "textarea", "", "h200", "255"); ?>
      </td>
      <td class='changing-line color_td1 wbr' style="vertical-align: top;">
        <?php _inputv("ref5_1Q4", $ref5_1Q4, "textarea", "", "h200", "255"); ?>
      </td>
    </tr>
    <!-------------------------------------------------------------->
    <tr style="border: 1px solid #fff">
      <td rowspan='4' class='changing-line text-middle color_td4'>
        <span class='fw600 text-center'><?php echo h($_SESSION['SEL_SELECT_NEN']); ?>年次<br>(3Q/4Q)</span>
      </td>


      <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php echo $study_target05; ?>
      </td>
      <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php echo  $自己目標5; ?>
      </td>
      <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php echo $出来た5; ?>
      </td>
      <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">

     <div>
  <?php foreach ($labels as $val => $text): ?>
    <?php if ($score5Q4 == $val): ?>
      <i class="fa-regular fa-circle-check" style="color: blue;"></i> <?= htmlspecialchars($text) ?>
    <?php else: ?>
      <i class="fa-regular fa-circle" style="color: gray;"></i> <?= htmlspecialchars($text) ?>
    <?php endif; ?>
    <br><br>
  <?php endforeach; ?>
</div>
      </td>

      <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php echo $出来ず5; ?>
      </td>



      <td class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php _inputv("力獲得目標5_4Q1", $力獲得目標5_4Q1, "textarea", "", "h200", "255"); ?>
      </td>

      <td class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php _inputv("ref5_4Q1", $ref5_4Q1, "textarea", "", "h200", "255"); ?>
      </td>
      <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php _inputv("今後目標5_4Q", $今後目標5_4Q, "textarea", "", "h200", "255"); ?>
      </td>

      <td rowspan="4" class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php _inputv("今後課題5_4Q", $今後課題5_4Q, "textarea", "", "h200", "255"); ?>
      </td>
    </tr>
    <tr style="border: 1px solid #fff">
      <td class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php _inputv("力獲得目標5_4Q2", $力獲得目標5_4Q2, "textarea", "", "h200", "255"); ?>
      </td>
      <td class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php _inputv("ref5_4Q2", $ref5_4Q2, "textarea", "", "h200", "255"); ?>
      </td>
    </tr>
    <tr style="border: 1px solid #fff">
      <td class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php _inputv("力獲得目標5_4Q3", $力獲得目標5_4Q3, "textarea", "", "h200", "255"); ?>
      </td>
      <td class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php _inputv("ref5_4Q3", $ref5_4Q3, "textarea", "", "h200", "255"); ?>
      </td>
    </tr>
    <tr style="border: 1px solid #555">
      <td class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php _inputv("力獲得目標5_4Q4", $力獲得目標5_4Q4, "textarea", "", "h200", "255"); ?>
      </td>
      <td class='changing-line color_td4 wbr' style="vertical-align: top;">
        <?php _inputv("ref5_4Q4", $ref5_4Q4, "textarea", "", "h200", "255"); ?>
      </td>
    </tr>








  <?php } else { ?>

    <!-- Hidden Inputs for Groups E and F -->
    <input type="hidden" name='共通目標5' value="">
    <input type="hidden" name='自己目標5' value="">
    <input type="hidden" name='出来た5' value="">
    <input type="hidden" name='出来ず5' value="">
    <input type="hidden" name='ref5_1Q1' value="">
    <input type="hidden" name='ref5_1Q2' value="">
    <input type="hidden" name='ref5_1Q3' value="">
    <input type="hidden" name='ref5_1Q4' value="">
    <input type="hidden" name='ref5_4Q1' value="">
    <input type="hidden" name='ref5_4Q2' value="">
    <input type="hidden" name='ref5_4Q3' value="">
    <input type="hidden" name='ref5_4Q4' value="">
    <input type="hidden" name='今後目標5_1Q' value="">
    <input type="hidden" name='今後目標5_4Q' value="">
    <input type="hidden" name='今後課題5_1Q' value="">
    <input type="hidden" name='今後課題5_4Q' value="">

    <input type="hidden" name="score1Q1" value="">
    <input type="hidden" name="score1Q4" value="">
    <input type="hidden" name="score2Q1" value="">
    <input type="hidden" name="score2Q4" value="">
    <input type="hidden" name="score3Q1" value="">
    <input type="hidden" name="score3Q4" value="">
    <input type="hidden" name="score4Q1" value="">
    <input type="hidden" name="score4Q4" value="">
    <input type="hidden" name="score5Q1" value="">
    <input type="hidden" name="score5Q4" value="">

  <?php } ?>

</table>

<h6>教員からのコメント <span class="fs80"></span></h6>
<table class="table table-bordered border-secondary">
  <tr>
    <td><?php _inputv("comments_of_teacher", $comments_of_teacher, "textarea", "edit", "h200", "255"); ?></td>
  </tr>
</table>



<input type='hidden' name='TABLE' value="tbl_reflection_base">
<input type='hidden' name='METHOD' value="COMMENT_UP">
<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $_SESSION['SEL_STUDENT_NUMBER']; ?>">
<input type='hidden' name='SELECT_NEN' value="<?PHP echo  $_SESSION['SEL_SELECT_NEN'] ?>">

<br>
<br>

<p class="text-center">
  <?php echo "状態：" . $mr[$GLOBALS['sta_rbas']]; ?>
</p>
<?php
$GLOBALS['sta_rbas'] = strval($GLOBALS['sta_rbas']);
$column="rbas"
?>

<table class="table">
  <tr>


    <td>
      <?php
      if (strpos(" 2 3 4 ", $GLOBALS['sta_rbas']) == true) {
        $dis = "";
      } else {
        $dis = "disabled";
      }

      btn_submit("要修正", "fix", $column, $dis);

      ?>
    </td>

    <td>
      <?php

      if (strpos(" 2 3 4 ", $GLOBALS['sta_rbas']) == true) {
        $dis = ""; //承認できる
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