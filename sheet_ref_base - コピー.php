<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

form_submit("registration.php");

$ACTION = "select_sheet.php";

require('./disp_parts/headerNonlist.php');
require('data_keep.php');

if (!isset($pdo)) {
  echo "PDO is not set. Please check config_db_tashio.php";
  exit;
}

if (!isset($_POST['SELECT_NEN'])) {
  $_SESSION['SELECT_NEN'] = "1";
} else {
  $_SESSION['SELECT_NEN'] = intval($_POST['select_nen']);
}

$_SESSION['school_year'] = $_SESSION['SELECT_NEN'];
$student_number = $_SESSION['STUDENT_NUMBER'];
$school_year = intval($_SESSION['school_year']);

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
  $stmt->execute([$student_number, $school_year]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    foreach ($result as $key => $value) {
      if (strpos($key, 'textarea_') === 0) {
        $GLOBALS[$key] = $value;
      }
    }
  }

  tbl_reflection_base_READ($student_number, $_SESSION['SELECT_NEN']);

  $ref_base_fields = [
    'ref_base_a1',
    'ref_base_a2',
    'ref_base_a3',
    'ref_base_a4',
    'ref_base_b1',
    'ref_base_b2',
    'ref_base_b3',
    'ref_base_b4',
    'ref_base_c1',
    'ref_base_c2',
    'ref_base_c3',
    'ref_base_c4',
    'ref_base_d1',
    'ref_base_d2',
    'ref_base_d3',
    'ref_base_d4',
    'ref_base_e1',
    'ref_base_e2',
    'ref_base_e3',
    'ref_base_e4',
    'ref_base_f1',
    'ref_base_f2',
    'ref_base_f3',
    'ref_base_f4'
  ];

  foreach ($ref_base_fields as $field) {
    $$field = $GLOBALS[$field];
    error_log("Assigned \$$field = '{$$field}'");
  }
} catch (PDOException $e) {
  echo "Error fetcing data: " . $e->getMessage();
  exit;
}

$edits = "";
$dis1 = $dis2 = $dis3 = $dis4 = "";

switch ($_SESSION['SELECT_NEN']) {
  case "1":
    $dis1 = $edits;
    break;
  case "2":
    $dis2 = $edits;
    break;
  case "3":
    $dis3 = $edits;
    break;
  case "4":
    $dis4 = $edits;
    break;
}

tbl_status_check($student_number, $_SESSION['SELECT_NEN']);
$school_year = intval($_SESSION['school_year']);

$column = "ref_base_" . $_SESSION['SELECT_NEN'];

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


tbl_profile_READ($_SESSION['STUDENT_NUMBER']);

dsip_midashi("学修行動計画（リフレクション・シート）＜" . $_SESSION['SELECT_NEN'] . "年次＞(４Q)");


tbl_goal_sheet_1q_READ($student_number, $_SESSION['SELECT_NEN']);
tbl_reflection_base_READ($student_number, $_SESSION['SELECT_NEN']);

if (($GLOBALS['sta_rbas'] == 4) or ($GLOBALS['sta_rbas'] == 2)) {
  $edits = "";
} else {
  $edits = "edit";
}


switch ($_SESSION['SELECT_NEN']) {
  case 1:
    $study_target01 = "大学生として必要な学ぶための基礎的な知識やスキルを習得しいる。(Ⅰ類科目・基礎ゼミナール・ソーシャルワーク論)";
    $study_target02 = "大学生として必要な学ぶための基礎的な態度を獲得しいる。(全科目)";
    $study_target03 = "福祉マインドに関わる基本的な知識を習得している。(社会福祉入門・社会福祉原論・社会保障論等)";
    $study_target04 = "福祉マインドに関わる基本的な態度を獲得している。(基礎ゼミナール・ソーシャルワーク演習)※⑧他者と協働し、共生社会構築の役割を担う意欲を持っている。";
    $study_target05 = "グループの特性に応じて、適切なリーダーシップやメンバーシップを発揮する姿勢を有している。";
    $study_target06 = "";
    break;
  case 2:
    $study_target01 = "福祉マインドを持つ人材としての思想や指針となる理論、支援に役立つ知識・技術を理解するために必要な読解力、記述力及び学びの方法を身につけている";
    $study_target02 = "学んだことを生かして、自らの生き方及び果たすべき役割や責任について考察を深めることができる。";
    $study_target03 = "他者と協働し、共生社会構築の役割を担う意欲を持っている。";
    $study_target04 = "自分自身の言動を振り返り、意識的な変容の意図のもと、自身の成長につなげることができる。";
    $study_target05 = "";
    $study_target06 = "";
  case 3:
    $study_target01 = "福祉マインドを持つ人材としての思想や指針となる理論、支援に役立つ知識・技術を理解するために必要な読解力、記述力及び学びの方法を身につけている。";
    $study_target02 = "学んだ知識について、自らの考えを他者に対して的確に表現することができる。";
    $study_target03 = "社会福祉学の学びから学習や研究課題を設定し、主体的に取り組む姿勢を有している。";
    $study_target04 = "社会福祉学の価値・知識・技術を理解し活用できるよう、日々成果を蓄積しようとする意欲を持っている。";
    $study_target05 = "";
    $study_target06 = "";
    break;
  case 4:
    $study_target01 = "地域共生社会の実現に向け、社会福祉学の価値・知識・技術を人と社会に対する支援に活用する方法を身につけている。";
    $study_target02 = "社会福祉学領域の研究や方法を通じて、地域社会や身近な人々の間で生じている問題を発見し、その解決方法を判断し、改善を図ることができる。";
    $study_target03 = "知識集約型社会を見据えて、自らの専門分野の学問領域と他の学問領域を統合的に学び、多面的・重層的な思考をすることで、複雑で多様な現代社会の課題に応えることができる。";
    $study_target04 = "多様な人々の価値観を受け止め、円滑な人間関係を築き、チームアプローチにより目標達成に向けて努力することができる。";
    $study_target05 = "";
    $study_target06 = "";
    break;
  default:
    $study_target01 = $study_target02 = $study_target03 = $study_target04 = $study_target05 = "";
}


$自己目標1 = $study_target01;
$自己目標2 = $study_target02;
$自己目標3 = $study_target03;
$自己目標4 = $study_target04;

$自己目標5 = $study_target05;
?>

<table class="table changing-line">
  <tr style="border: 1px solid #fff">
    <td width="5%" rowspan="2" class="changing-line text-center text-middle color_td1">
      <span class="fw600">年次</span>
    </td>
    <td width="12.5%" rowspan="2" class='changing-line text-middle color_td1'>
      <span class="fw600">1.共通の到達目標</span>
    </td>
    <td width="12.5%" rowspan="2" class='changing-line text-middle color_td1'>
      <span class="fw600">2.「共通の到達目標」を踏まえた、あなたの到達目標</span>
    </td>
    <td colspan="4" class="changing-line text-center text-middle color_td1">
      <span class="fw600">3.学修行動の振り返り</span>
    </td>

    <td width="12.5%" rowspan="2" class='changing-line text-middle color_td4'>
      <span class="fw600">4.3.の振り返りを踏まえた「あなたの到達目標」</span>
      <br><span class="fs80"></span>
    </td>
    <td width="12.5%" rowspan="2" class='changing-line text-middle color_td4'>
      <span class="fw600">5.「あなたの到達目標」達成に向けて、次のクォーターまでに、あなたがさらにやること、努力すること</span><br>
      <span class="fs80"></span>
    </td>


  </tr>



  <tr style="border: 1px solid #fff">
    <td width="12.5%" class='changing-line text-middle color_td1'>
      <span class="fw600">①.共通の目標達成度評価(評価基準表に基づき自己評価)</span>
      <br><span class="fs80"></span>
    </td>
    <td width="12.5%" class='changing-line text-middle color_td1'>
      <span class="fw600">②.①に関して、あなたが獲得できたこと、達成できたこと、できるようになったこと（2.「あなたの達成目標」に関連付けて記述）</span>
      <br><span class="fs80"></span>
    </td>
    <td width="12.5%" class='changing-line text-middle color_td1'>
      <span class="fw600">③ あなたの到達目標の達成に必要な力（1Qゴールシートであなたが獲得目標として設定した力）</span>
    </td>
    <td width="12.5%" class='changing-line text-middle color_td1'>
      <span class="fw600">④ ③で掲げた獲得目標の達成度評価
        <!-- （③の力を用いて、できるようになったこと/できなかったこと、向上した技能/獲得に至らなかった技能、新たに始めた活動、学修が進んだこと/学修が進まなかったこと、などを振り返りながら、「その力がどの程度発揮されたか/発揮されなかったか」という観点で自己評価してください。） -->
        <span class="fs80">（50字以上、225字以内）</span>
    </td>
  </tr>




  <tr style="border: 1px solid #fff">
    <td class='changing-line text-middle color_td1' rowspan="2">
      <span class='fw600 text-center'><?php echo h($_SESSION['SELECT_NEN']); ?>年次<br>(1Q/2Q)</span>
    </td>

    <td rowspan="4" class='changing-line color_td1  wbr'>
      <?php _inputv("共通目標1", $study_target01, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("自己目標1", $自己目標1, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("自己評価1", $自己評価1, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("出来た1", $出来た1, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_b1", $textarea_b1, "textarea", "", "h200", "255"); ?>
    </td>

    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_a1", $ref_base_a1, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr'>
      <?php _inputv("今後目標1", $今後目標1, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("今後課題1", $今後課題1, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>





  <tr style="border: 1px solid #fff">


    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_b2", $textarea_b2, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_a2", $ref_base_a2, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>

  <tr style="border: 1px solid #fff">
    <td rowspan='2' class='changing-line text-middle color_td4'>
      <span class='fw600 text-center'><?php echo h($_SESSION['SELECT_NEN']); ?>年次<br>(3Q/4Q)</span>
    </td>

    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_b3", $textarea_b3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_a3", $ref_base_a3, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>



  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_b4", $textarea_b4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_a4", $ref_base_a4, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>





  <tr style="border: 1px solid #fff">
    <td class='changing-line text-middle color_td1' rowspan="2">
      <span class='fw600 text-center'><?php echo h($_SESSION['SELECT_NEN']); ?>年次<br>(1Q/2Q)</span>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("共通目標2", $study_target02, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("自己目標2", $自己目標2, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("自己評価2", $自己評価2, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("出来た2", $出来た2, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_c1", $textarea_c1, "textarea", "", "h200", "255"); ?>
    </td>

    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_b1", $ref_base_b1, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr'>
      <?php _inputv("今後目標2", $今後目標2, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("今後課題2", $今後課題2, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>



  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_c2", $textarea_c2, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_b2", $ref_base_b2, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>

  <tr style="border: 1px solid #fff">
    <td rowspan='2' class='changing-line text-middle color_td4'>
      <span class='fw600 text-center'><?php echo h($_SESSION['SELECT_NEN']); ?>年次<br>(3Q/4Q)</span>
    </td>

    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_c3", $textarea_c3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_b3", $ref_base_b3, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>


  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_c4", $textarea_c4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_b4", $ref_base_b4, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>


  <tr style="border: 1px solid #fff">
    <td class='changing-line text-middle color_td1' rowspan="2">
      <span class='fw600 text-center'><?php echo h($_SESSION['SELECT_NEN']); ?>年次<br>(1Q/2Q)</span>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("共通目標3", $study_target03, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("自己目標3", $自己目標3, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("自己評価3", $自己評価3, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("出来た3", $出来た3, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_d1", $textarea_d1, "textarea", "", "h200", "255"); ?>
    </td>

    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_c1", $ref_base_c1, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr'>
      <?php _inputv("今後目標3", $今後目標3, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("今後課題3", $今後課題3, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>

  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_d2", $textarea_d2, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_c2", $ref_base_c2, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>

  <tr style="border: 1px solid #fff">

    <td rowspan='2' class='changing-line text-middle color_td4'>
      <span class='fw600 text-center'><?php echo h($_SESSION['SELECT_NEN']); ?>年次<br>(3Q/4Q)</span>
    </td>


    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_d3", $textarea_d3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_c3", $ref_base_c3, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>

  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_d4", $textarea_d4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_c4", $ref_base_c4, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>



  <tr style="border: 1px solid #fff">
    <td class='changing-line text-middle color_td1' rowspan="2">
      <span class='fw600 text-center'><?php echo h($_SESSION['SELECT_NEN']); ?>年次<br>(1Q/2Q)</span>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("共通目標4", $study_target04, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("自己目標4", $自己目標4, "textarea", "", "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("自己評価4", $自己評価4, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td1 wbr'>
      <?php _inputv("出来た4", $出来た4, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_e1", $textarea_e1, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_d1", $ref_base_d1, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr'>
      <?php _inputv("今後目標4", $今後目標4, "textarea", $edits, "h200", "255"); ?>
    </td>

    <td rowspan="4" class='changing-line color_td4 wbr'>
      <?php _inputv("今後課題4", $今後課題4, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>

  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_e2", $textarea_e2, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_d2", $ref_base_d2, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>



  <tr style="border: 1px solid #fff">
    <td rowspan='2' class='changing-line text-middle color_td4'>
      <span class='fw600 text-center'><?php echo h($_SESSION['SELECT_NEN']); ?>年次<br>(3Q/4Q)</span>
    </td>

    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_e3", $textarea_e3, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_d3", $ref_base_d3, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>




  <tr style="border: 1px solid #fff">
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("textarea_e4", $textarea_e4, "textarea", "", "h200", "255"); ?>
    </td>
    <td class='changing-line color_td1 wbr'>
      <?php _inputv("ref_base_d4", $ref_base_d4, "textarea", $edits, "h200", "255"); ?>
    </td>
  </tr>




  <?php if ($_SESSION['SELECT_NEN'] == 1) { ?>
    <tr style="border: 1px solid #fff">
      <td class='changing-line text-middle color_td1' rowspan="2">
        <span class='fw600 text-center'><?php echo h($_SESSION['SELECT_NEN']); ?>年次<br>(1Q/2Q)</span>
      </td>

      <td rowspan="4" class='changing-line color_td1 wbr'>
        <?php _inputv("共通目標5", $study_target05, "textarea", "", "h200", "255"); ?>
      </td>

      <td rowspan="4" class='changing-line color_td1 wbr'>
        <?php _inputv("自己目標5", $自己目標5, "textarea", "", "h200", "255"); ?>
      </td>

      <td rowspan="4" class='changing-line color_td1 wbr'>
        <?php _inputv("自己評価5", $自己評価5, "textarea", $edits, "h200", "255"); ?>
      </td>

      <td rowspan="4" class='changing-line color_td1 wbr'>
        <?php _inputv("出来た5", $出来た5, "textarea", $edits, "h200", "255"); ?>
      </td>

      <td class='changing-line color_td1 wbr'>
        <?php _inputv("textarea_f1", $textarea_f1, "textarea", "", "h200", "255"); ?>
      </td>

      <td class='changing-line color_td1 wbr'>
        <?php _inputv("ref_base_e1", $ref_base_e1, "textarea", $edits, "h200", "255"); ?>
      </td>

      <td rowspan="4" class='changing-line color_td4 wbr'>
        <?php _inputv("今後目標5", $今後目標5, "textarea", $edits, "h200", "255"); ?>
      </td>

      <td rowspan="4" class='changing-line color_td4 wbr'>
        <?php _inputv("今後課題5", $今後課題5, "textarea", $edits, "h200", "255"); ?>
      </td>
    </tr>



    <tr style="border: 1px solid #fff">
      <td class='changing-line color_td1 wbr'>
        <?php _inputv("textarea_f2", $textarea_f2, "textarea", "", "h200", "255"); ?>
      </td>
      <td class='changing-line color_td1 wbr'>
        <?php _inputv("ref_base_e2", $ref_base_e2, "textarea", $edits, "h200", "255"); ?>
      </td>
    </tr>

    <tr style="border: 1px solid #fff">
      <td rowspan='2' class='changing-line text-middle color_td4'>
        <span class='fw600 text-center'><?php echo h($_SESSION['SELECT_NEN']); ?>年次<br>(3Q/4Q)</span>
      </td>

      <td class='changing-line color_td1 wbr'>
        <?php _inputv("textarea_f3", $textarea_f3, "textarea", "", "h200", "255"); ?>
      </td>
      <td class='changing-line color_td1 wbr'>
        <?php _inputv("ref_base_e3", $ref_base_e3, "textarea", $edits, "h200", "255"); ?>
      </td>
    </tr>

    <tr style="border: 1px solid #fff">
      <td class='changing-line color_td1 wbr'>
        <?php _inputv("textarea_f4", $textarea_f4, "textarea", "", "h200", "255"); ?>
      </td>
      <td class='changing-line color_td1 wbr'>
        <?php _inputv("ref_base_e4", $ref_base_e4, "textarea", $edits, "h200", "255"); ?>
      </td>
    </tr>




  <?php } else { ?>

    <!-- Hidden Inputs for Groups E and F -->
    <input type="hidden" name='共通目標5' value="">
    <input type="hidden" name='自己目標5' value="">
    <input type="hidden" name='自己評価5' value="">
    <input type="hidden" name='出来た5' value="">
    <input type="hidden" name='出来ず5' value="">
    <input type="hidden" name='今後目標5' value="">
    <input type="hidden" name='今後課題5' value="">

  <?php } ?>

</table>




<h6>教員からのコメント</h6>
<table class="table table-bordered changing-line">
  <tr>
    <td><?php _inputv("comments_of_teacher", $comments_of_teacher, "textarea", "", "", "255"); ?></td>
  </tr>
</table>






<input type='hidden' name='TABLE' value="tbl_reflection_base">
<input type='hidden' name='METHOD' value="UP_DATE">
<input type='hidden' name='STUDENT_NUMBER' value="<?PHP echo $_SESSION['STUDENT_NUMBER']; ?>">
<input type='hidden' name='SELECT_NEN' value="<?PHP echo  $_SESSION['SELECT_NEN'] ?>">

<br>
<br>
</table>
<p class="text-center">
  <?php echo "状態：" . $mr[$GLOBALS['sta_rbas']]; ?>
</p>
<?php
$GLOBALS['sta_rbas'] = strval($GLOBALS['sta_rbas']);
?>

<table class="table">
  <tr>
    <td>
      <?php
      if (strpos(" 0 1 3", $GLOBALS['sta_rbas']) == true) {
        $dis = "";
      } else {
        $dis = "disabled";
      }
       btn_submit("下書き", "draft", $column, $dis);
      ?>
    </td>
    <td>
      <?php
      if (strpos(" 0 1 3", $GLOBALS['sta_rbas']) == true) {
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

<?php

echo "</form>";

require('./disp_parts/footer.php');
exit;
?>