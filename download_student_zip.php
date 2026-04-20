<?php

require_once('./files/config_db_taisho2025.php');
require_once('./common/function.php'); // IMPORTANT (for tbl_goal_sheet_1q_READ)

$powerMap = [
    1 => "①他者に共感する力",
    2 => "②物事の本質を見極める力",
    3 => "③論理的に考える力",
    4 => "④自分事として問いを立てる力",
    5 => "⑤根拠にもとづいて思考する力",
    6 => "⑥自分らしい方法で表現する力",
    7 => "⑦自らの主張を吟味し、ふりかえる力",
    8 => "⑧多様性を尊重する力",
    9 => "⑨新たな価値を創造する力",
    10 => "⑩他者と対話し、協働する力"
];


function build_goal_csv_from_globals($student_number, $year, $quarter) {

    global $powerMap;

    ob_start();
    $out = fopen('php://output', 'w');

    // BOM
    fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

    // =========================
    // TITLE
    // =========================
    fputcsv($out, ["1Qゴールシート出力ファイル"]);
    fputcsv($out, [""]);

    // HEADER ROW
    fputcsv($out, [
        "1年次の「学修の到達目標」",
        "あなたの到達目標",
        "到達に必要な力"
    ]);

    // =========================
    // BLOCK RENDER FUNCTION
    // =========================
    $renderBlock = function($title, $goalText, $codes) use ($out, $powerMap) {

        $first = true;

        foreach ($codes as $code) {

            if (!$code) continue;

            $text = $powerMap[$code] ?? $code;

            if ($first) {
                fputcsv($out, [$title, $goalText, $text]);
                $first = false;
            } else {
                fputcsv($out, ["", "", $text]);
            }
        }

        // spacing after block
        fputcsv($out, [""]);
    };

    // =========================
    // BLOCKS (MATCH UI)
    // =========================

    // A
    $renderBlock(
        "大学生として必要な基礎的な知識やスキルを習得している",
        $GLOBALS['your_goal'] ?? "",
        [
            $GLOBALS['option_a1'],
            $GLOBALS['option_a2'],
            $GLOBALS['option_a3'],
            $GLOBALS['option_a4']
        ]
    );

    // B
    $renderBlock(
        "大学生として必要な基本的な態度を習得している",
        $GLOBALS['your_goal'] ?? "",
        [
            $GLOBALS['option_b1'],
            $GLOBALS['option_b2'],
            $GLOBALS['option_b3'],
            $GLOBALS['option_b4']
        ]
    );

    // C
    $renderBlock(
        "福祉マインドに関わる基本的な知識を習得している",
        $GLOBALS['your_goal'] ?? "",
        [
            $GLOBALS['option_c1'],
            $GLOBALS['option_c2'],
            $GLOBALS['option_c3'],
            $GLOBALS['option_c4']
        ]
    );

    // D
    $renderBlock(
        "福祉マインドに関わる基本的な態度を習得している",
        $GLOBALS['your_goal'] ?? "",
        [
            $GLOBALS['option_d1'],
            $GLOBALS['option_d2'],
            $GLOBALS['option_d3'],
            $GLOBALS['option_d4']
        ]
    );

    // =========================
    // FUTURE SECTION
    // =========================
    fputcsv($out, [""]);
    fputcsv($out, ["大学卒業後の自分（卒業後のイメージ）"]);

    fputcsv($out, ["対象", $GLOBALS['target_person'] ?? ""]);
    fputcsv($out, ["どこで", $GLOBALS['practical_field'] ?? ""]);
    fputcsv($out, ["どのように", $GLOBALS['activity_method'] ?? ""]);
    fputcsv($out, ["成果", $GLOBALS['aimed_results'] ?? ""]);

    fclose($out);
    return ob_get_clean();
}

function build_goal4q_csv_from_globals($student_number, $year) {

    global $powerMap;

    ob_start();
    $out = fopen('php://output', 'w');

    fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

    // =========================
    // TITLE
    // =========================
    fputcsv($out, ["4Qゴールシート出力"]);
    fputcsv($out, ["学籍番号", $student_number]);
    fputcsv($out, ["学年", $year]);
    fputcsv($out, [""]);

    // =========================
    // HEADER
    // =========================
    fputcsv($out, [
        "到達目標",
        "次のクォーターでやること",
        "必要な力",
        "具体的な達成目標"
    ]);

    // =========================
    // BLOCK LOOP
    // =========================
    $blocks = [
        ['a', '大学生として必要な基礎的な知識やスキル'],
        ['b', '大学生として必要な基本的な態度'],
        ['c', '福祉マインドに関わる基本的な知識'],
        ['d', '福祉マインドに関わる基本的な態度']
    ];

    foreach ($blocks as [$key, $label]) {

        $goal = $GLOBALS['your_goal_4Q'] ?? "";
        $action = $GLOBALS['activity_method_4Q'] ?? "";

        $options = [
            $GLOBALS["goal4q_opt_{$key}1"] ?? "",
            $GLOBALS["goal4q_opt_{$key}2"] ?? "",
            $GLOBALS["goal4q_opt_{$key}3"] ?? "",
            $GLOBALS["goal4q_opt_{$key}4"] ?? ""
        ];

        $texts = [
            $GLOBALS["goal4q_txt_{$key}1"] ?? "",
            $GLOBALS["goal4q_txt_{$key}2"] ?? "",
            $GLOBALS["goal4q_txt_{$key}3"] ?? "",
            $GLOBALS["goal4q_txt_{$key}4"] ?? ""
        ];

        $first = true;

        for ($i = 0; $i < 4; $i++) {

            if (!$options[$i]) continue;

            $powerText = $powerMap[$options[$i]] ?? $options[$i];

            if ($first) {
                fputcsv($out, [
                    $goal,
                    $action,
                    $powerText,
                    $texts[$i]
                ]);
                $first = false;
            } else {
                fputcsv($out, [
                    "",
                    "",
                    $powerText,
                    $texts[$i]
                ]);
            }
        }

        fputcsv($out, [""]); // spacing
    }

    fclose($out);
    return ob_get_clean();
}

function build_reflection_csv_from_globals($student_number, $year) {

    global $powerMap;

    ob_start();
    $out = fopen('php://output', 'w');

    // BOM
    fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

    // =========================
    // TITLE
    // =========================
    fputcsv($out, ["リフレクションシート出力"]);
    fputcsv($out, ["学籍番号", $student_number]);
    fputcsv($out, ["学年", $year]);
    fputcsv($out, [""]);

    // =========================
    // HEADER (IMPORTANT)
    // =========================
    fputcsv($out, [
        "観点",
        "到達目標",
        "達成度評価",
        "自省",
        "必要な力",
        "力の達成度"
    ]);

    // =========================
    // BLOCK LABELS (LEFT SIDE)
    // =========================
    $labels = [
        "大学生として必要な基礎的な知識やスキル",
        "大学生として必要な基本的な態度",
        "福祉マインドに関わる基本的な知識",
        "福祉マインドに関わる基本的な態度"
    ];

    // =========================
    // LOOP BLOCKS
    // =========================
    for ($i = 1; $i <= 4; $i++) {

        $label = $labels[$i-1];

        // Core values
        $goal   = $GLOBALS["共通目標{$i}"] ?? "";
        $score  = $GLOBALS["score{$i}Q1"] ?? "";
        $self   = $GLOBALS["ref{$i}_1Q1"] ?? "";

        // Power codes (multiple rows)
        $powers = [
            $GLOBALS["今後目標{$i}_1Q"] ?? "",
            $GLOBALS["今後課題{$i}_1Q"] ?? ""
        ];

        $first = true;

        foreach ($powers as $p) {

            if (!$p) continue;

            $powerText = $powerMap[$p] ?? $p;

            if ($first) {
                fputcsv($out, [
                    $label,
                    $goal,
                    $score,
                    $self,
                    $powerText,
                    "" // optional score column
                ]);
                $first = false;
            } else {
                fputcsv($out, [
                    "",
                    "",
                    "",
                    "",
                    $powerText,
                    ""
                ]);
            }
        }

        // spacing between blocks
        fputcsv($out, [""]);
    }

    fclose($out);
    return ob_get_clean();
}

session_start();

if (!isset($_SESSION['EMAIL'])) {
    header("Location: index.php");
    exit;
}

$student_number = $_POST['student_number'] ?? '2920001'; // ← use a real student number

$stmt = $pdo->prepare("
    SELECT *
    FROM tbl_profile
    WHERE student_number = ?
");
$stmt->execute([$student_number]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

$zip = new ZipArchive();

$zipFileName = "student_sheets_" . date('Ymd_His') . ".zip";
$tmpZipPath = sys_get_temp_dir() . "/" . $zipFileName;

if ($zip->open($tmpZipPath, ZipArchive::CREATE) !== TRUE) {
    die("Cannot create ZIP file");
}

// ===============================
// GOAL SHEETS (CORRECT LOGIC)
// ===============================
for ($year = 1; $year <= 4; $year++) {

    // ======================
    // 1Q
    // ======================
    if (!empty($profile["goal1Q_{$year}"])) {

        tbl_goal_sheet_1q_READ($student_number, $year);

        $csv = build_goal_csv_from_globals($student_number, $year, "1Q");

        $zip->addFromString("goal_sheet_1Q_{$year}.csv", $csv);
    }

    // ======================
    // 4Q (FIXED HERE)
    // ======================
    if (!empty($profile["goal4Q_{$year}"])) {

        tbl_goal_sheet_4q_READ($student_number, $year);

        $csv = build_goal4q_csv_from_globals($student_number, $year);

        $zip->addFromString("goal_sheet_4Q_{$year}.csv", $csv);
    }
}

// ===============================
// REFLECTION (CORRECT LOGIC)
// ===============================
for ($year = 1; $year <= 4; $year++) {

    // Reflection exists?
    if (!empty($profile["ref_base_{$year}"])) {

        tbl_reflection_base_READ($student_number, $year);

        $csv = build_reflection_csv_from_globals($student_number, $year);

        $zip->addFromString("reflection_{$year}.csv", $csv);
    }
}

$zip->close();

// ===============================
// DOWNLOAD
// ===============================
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
header('Content-Length: ' . filesize($tmpZipPath));

readfile($tmpZipPath);
unlink($tmpZipPath);
exit;


// ===============================
// CSV BUILDERS
// ===============================


file_put_contents("debug_goal.csv", $csv);
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
