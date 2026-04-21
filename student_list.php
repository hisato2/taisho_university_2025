<?php





session_start();
if (!isset($_SESSION['EMAIL'])) {
  header("Location: index.php");
  exit;
}

$ACTION = "index.php";
function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

require_once('./files/config_db_taisho2025.php');



if (isset($_POST['download_csv'])) {
  try {
    // DBへ接続
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    $dbh->exec("SET NAMES utf8");

    // SQL作成
    $sql = "SELECT " .
      "p.student_number, p.name, r.school_year, " .
  "r.score1Q1, " .
  "r.score1Q4, " .
  "r.score2Q1, " .
  "r.score2Q4, " .
  "r.score3Q1, " .
  "r.score3Q4, " .
  "r.score4Q1, " .
  "r.score4Q4, " .
  "r.score5Q1, " .
  "r.score5Q4 " .
      "FROM tbl_profile AS p " .
      "INNER JOIN tbl_reflection_base AS r " .
      "ON p.student_number = r.student_number;";

    $stmt = $dbh->query($sql);
    if (!$stmt) {
      throw new Exception("データの取得に失敗しました。");
    }


    // CSV出力用ヘッダー
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="score_export.csv"');

$output = fopen('php://output', 'w');

// ▼ UTF-8 BOM を出力（Excel対策）
fwrite($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

// ヘッダー行
$headers = array_keys($stmt->fetch(PDO::FETCH_ASSOC));
fputcsv($output, $headers);
$stmt->execute(); // 再実行

// データ行
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  fputcsv($output, $row);
}


    fclose($output);
    exit;

  } catch (PDOException $e) {
    echo 'DBエラー: ' . htmlspecialchars($e->getMessage());
    exit;
  } catch (Exception $e) {
    echo 'エラー: ' . htmlspecialchars($e->getMessage());
    exit;
  }
}






require_once('./common/function.php');
require('./disp_parts/headerNonlist.php');

//////////何年度の表の提出状況を表示するか

$tname = "";

if (isset($_POST['tname'])) {
  $tname = $_POST['tname'];
  $_SESSION['TNAME']=$tname;
}elseif(isset($_SESSION['TNAME'])){
  $tname = $_SESSION['TNAME'];
}

$Wstudent = "";
$NEN = "";


 // DB接続とSQL → CSV出力 → exit;
  // DB接続とSQL → CSV出力 → exit;
   // DB接続とSQL → CSV出力 → exit;


if (!isset($_GET['admission'])){
  $_SESSION['ADMISSION'] = "all";
}else if ($_GET['admission']=="全て表示"){
  $_SESSION['ADMISSION'] = "all";
}else{
  $_SESSION['ADMISSION'] = $_GET['admission'];
  $NEN = substr($_SESSION['ADMISSION'], 0, 2);
  $Wstudent = "and student_number LIKE '" . $NEN . "%'";
}





$Wtcher = "";

if ($tname <> "") {
  $Wstudent = $Wstudent . " and ((professor1 LIKE '%" . $tname . "%') or (professor2 LIKE '%" . $tname . "%') or (professor3 LIKE '%" . $tname . "%') or (professor4 LIKE '%" . $tname . "%'))";
}



dsip_midashi("学生リスト　" . "<span class='small'>(入学年度：" . $_SESSION['ADMISSION'] . ")</span>");

$student_number = "";

?>

<table class="table">
  <tr>
    <td>
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          対象学生の選択
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <?php
          for ($i = 1; $i > -7; $i--) { //繰り返す回数はfruitsに入ってる要素数
            $h = $i . "  year";
            $n = date('y', strtotime($h));
            $fruits[$i + 1] = $n . "年度";
          }
          $fruits[$i + 1] = "全て表示";
          foreach ($fruits as $fruit) { //fruitsの先頭から１つずつ$fruitに代入する
            echo "<a class='dropdown-item' href='student_list.php?admission=" . $fruit . "'>" . $fruit . "</a>\n";
          }
          ?>
        </div>
      </div>
    </td>
    <td>

    <form method="post" action="">
  <label for="inputText">教員名</label>
  <input type="text" id="inputText" name="tname" placeholder="教員名を入力" value="<?php echo htmlspecialchars($tname);?>" >
  <button type="submit">検索</button>
</form>

    </td>
  </tr>
</table>




<?php
/////////////////////////////////////////////////////////////////////////////////////////////

try {
  // DBへ接続

  $dbh = new PDO(DSN, DB_USER, DB_PASS);


  // SQL作成

  $where = " where kubun='学生'" . $Wstudent . $Wstudent . " LIMIT 200";


  if ((isset($_SESSION['SQL_BACKUP'])) AND $_SESSION['SQL_BACKUP']<>""){
    $sql = $_SESSION['SQL_BACKUP'];


  } else {
    $sql = "select * from tbl_profile" . $where;
  }


  $cnt = 0;





?>
  <!--
    <table class="table table-hover">
-->




  <table class="table table-bordered border-secondary">

    <tr>
      <td class="text-center align-middle"><span class="fw600">No.</span></td>
      <td class="text-center align-middle"><span class="fw600">学生</span></td>
      <td class="text-center align-middle"><span class="fw600">プロフィール</span></td>
      <td class="text-center align-middle"><span class="fw600">ゴールシート</span></td>
      <td class="text-center align-middle"><span class="fw600">リフレクション（学修）</span></td>
      <td class="text-center align-middle"><span class="fw600">リフレクション（実習）</span></td>
      <td class="text-center align-middle"><span class="fw600">実習計画書</span></td>
      <td class="text-center align-middle"><span class="fw600">自己評価表</span></td>
      <td class="text-center align-middle"><span class="fw600">実習配属先・紹介書</span></td>

    </tr>


    <?php

    $res = $dbh->query($sql);
    foreach ($res as $value) {
      $cnt = $cnt + 1;
      $no = $value['student_number'];

      // ✅ Check if student has downloadable data
      $stmt = $dbh->prepare("
          SELECT COUNT(*)
          FROM tbl_goal_sheet_1q
          WHERE student_number = ?
      ");
      $stmt->execute([$no]);
      $goal_count = $stmt->fetchColumn();

      $stmt = $dbh->prepare("
          SELECT COUNT(*)
          FROM tbl_reflection_base
          WHERE student_number = ?
      ");
      $stmt->execute([$no]);
      $reflection_count = $stmt->fetchColumn();

      // Final decision
      $has_downloadable = ($goal_count > 0 || $reflection_count > 0);

      if (isset($value['profile_1']) and $value['profile_1'] < 5) {
        $sta_prof1 =  intval($value['profile_1']);
      } else {
        $sta_prof1 =  "0";
      }
      if (isset($value['goal1Q_1']) and $value['goal1Q_1'] < 5) {
        $sta_go1Q1 =  intval($value['goal1Q_1']);
      } else {
        $sta_go1Q1 =  "0";
      }
      if (isset($value['goal4Q_1']) and $value['goal4Q_1'] < 5) {
        $sta_go4Q1 =  intval($value['goal4Q_1']);
      } else {
        $sta_go4Q1 =  "0";
      }
      if (isset($value['ref_base_1']) and $value['ref_base_1'] < 5) {
        $sta_rbas1 =  intval($value['ref_base_1']);
      } else {
        $sta_rbas1 =  "0";
      }
      if (isset($value['profile_2']) and $value['profile_2'] < 5) {
        $sta_prof2 =  intval($value['profile_2']);
      } else {
        $sta_prof2 =  "0";
      }
      if (isset($value['goal1Q_2']) and $value['goal1Q_2'] < 5) {
        $sta_go1Q2 =  intval($value['goal1Q_2']);
      } else {
        $sta_go1Q2 =  "0";
      }
      if (isset($value['goal4Q_2']) and $value['goal4Q_2'] < 5) {
        $sta_go4Q2 =  intval($value['goal4Q_2']);
      } else {
        $sta_go4Q2 =  "0";
      }
      if (isset($value['ref_base_2']) and $value['ref_base_2'] < 5) {
        $sta_rbas2 =  intval($value['ref_base_2']);
      } else {
        $sta_rbas2 =  "0";
      }
      if (isset($value['profile_3']) and $value['profile_3'] < 5) {
        $sta_prof3 =  intval($value['profile_3']);
      } else {
        $sta_prof3 =  "0";
      }
      if (isset($value['goal1Q_3']) and $value['goal1Q_3'] < 5) {
        $sta_go1Q3 =  intval($value['goal1Q_3']);
      } else {
        $sta_go1Q3 =  "0";
      }
      if (isset($value['goal4Q_3']) and $value['goal4Q_3'] < 5) {
        $sta_go4Q3 =  intval($value['goal4Q_3']);
      } else {
        $sta_go4Q3 =  "0";
      }
      if (isset($value['ref_base_3']) and $value['ref_base_3'] < 5) {
        $sta_rbas3 =  intval($value['ref_base_3']);
      } else {
        $sta_rbas3 =  "0";
      }
      if (isset($value['profile_4']) and $value['profile_4'] < 5) {
        $sta_prof4 =  intval($value['profile_4']);
      } else {
        $sta_prof4  =  "0";
      }
      if (isset($value['goal1Q_4']) and $value['goal1Q_4'] < 5) {
        $sta_go1Q4 =  intval($value['goal1Q_4']);
      } else {
        $sta_go1Q4 =  "0";
      }
      if (isset($value['goal4Q_4']) and $value['goal4Q_4'] < 5) {
        $sta_go4Q4 =  intval($value['goal4Q_4']);
      } else {
        $sta_go4Q4 =  "0";
      }
      if (isset($value['ref_base_4']) and $value['ref_base_4'] < 5) {
        $sta_rbas4 =  intval($value['ref_base_4']);
      } else {
        $sta_rbas4 =  "0";
      }
      if (isset($value['ref_sw1']) and $value['ref_sw1'] < 5) {
        $sta_ref_sw1 = intval($value['ref_sw1']);
      } else {
        $sta_ref_sw1  =  "0";
      }
      if (isset($value['ref_sw2']) and $value['ref_sw2'] < 5) {
        $sta_ref_sw2 = intval($value['ref_sw2']);
      } else {
        $sta_ref_sw2 =  "0";
      }
      if (isset($value['ref_intern']) and $value['ref_intern'] < 5) {
        $sta_ref_intern = intval($value['ref_intern']);
      } else {
        $sta_ref_intern  =  "0";
      }
      if (isset($value['ref_mental1']) and $value['ref_mental1'] < 5) {
        $sta_ref_mental1 = intval($value['ref_mental1']);
      } else {
        $sta_ref_mental1 =  "0";
      }
      if (isset($value['ref_advance']) and $value['ref_advance'] < 5) {
        $sta_ref_advance = intval($value['ref_advance']);
      } else {
        $sta_ref_advance =  "0";
      }



      if (isset($value['sch_sw1']) and $value['sch_sw1'] < 5) {
        $sta_sch_sw1 = intval($value['sch_sw1']);
      } else {
        $sta_sch_sw1  =  "0";
      }
      if (isset($value['sch_sw2']) and $value['sch_sw2'] < 5) {
        $sta_sch_sw2 = intval($value['sch_sw2']);
      } else {
        $sta_sch_sw2 =  "0";
      }
      if (isset($value['sch_mental1']) and $value['sch_mental1'] < 5) {
        $sta_sch_mental1 = intval($value['sch_mental1']);
      } else {
        $sta_sch_mental1 =  "0";
      }
      if (isset($value['sch_mental2']) and $value['sch_mental2'] < 5) {
        $sta_sch_mental2 = intval($value['sch_mental2']);
      } else {
        $sta_sch_mental2 =  "0";
      }
      if (isset($value['sch_advance']) and $value['sch_advance'] < 5) {
        $sta_sch_advance = intval($value['sch_advance']);
      } else {
        $sta_sch_advance =  "0";
      }


      if (isset($value['self_sw1']) and $value['self_sw1'] < 5) {
        $sta_self_sw1 = intval($value['self_sw1']);
      } else {
        $sta_self_sw1 =  "0";
      }
      if (isset($value['self_sw2']) and $value['self_sw2'] < 5) {
        $sta_self_sw2 = intval($value['self_sw2']);
      } else {
        $sta_self_sw2 =  "0";
      }
      if (isset($value['self_mental1']) and $value['self_mental1'] < 5) {
        $sta_self_mental1 = intval($value['self_mental1']);
      } else {
        $sta_self_mental1 =  "0";
      }
      if (isset($value['self_mental2']) and $value['self_mental2'] < 5) {
        $sta_self_mental2 = intval($value['self_mental2']);
      } else {
        $sta_self_mental2 =  "0";
      }
      if (isset($value['self_advance']) and $value['self_advance'] < 5) {
        $sta_self_advance = intval($value['self_advance']);
      } else {
        $sta_self_advance =  "0";
      }



    ?>
      <tr>
        <td class="text-center align-middle"><?php echo $cnt; ?></td>
        <td class="text-center align-middle"><?php echo $value['name'] . "<br>" . $no; ?>
        <td>
          <?php

          if ($sta_prof1 > 0) {
            echo "1：";
          }
          if ($sta_prof1 > 0) {
            echo "<a href='student_sorting.php?select=prof1&no=" . $no . "'>" . $mr[$sta_prof1] . "</a>";
          }
          ?><br>


          <?php
          if ($sta_prof2 > 0) {
            echo "2：";
          }
          if ($sta_prof2 > 0) {
            echo "<a href='student_sorting.php?select=prof2&no=" . $no . "'>" . $mr[$sta_prof2] . "</a>";
          }
          ?><br>
          <?php
          if ($sta_prof3 > 0) {
            echo "3：";
          }
          if ($sta_prof3 > 0) {
            echo "<a href='student_sorting.php?select=prof3&no=" . $no . "'>" . $mr[$sta_prof3] . "</a>";
          }
          ?><br>
          <?php
          if ($sta_prof4 > 0) {
            echo "4：";
          }
          if ($sta_prof4 > 0) {
            echo "<a href='student_sorting.php?select=prof4&no=" . $no . "'>" . $mr[$sta_prof4] . "</a>";
          }
          ?>



        </td>
        <td>


          <?php
          if ($sta_go1Q1 > 0) {
            echo "1：";
          }
          if ($sta_go1Q1 > 0) {
            echo "1Q <a href='student_sorting.php?select=go1Q1&no=" . $no . "'>"   . $mr[$sta_go1Q1] . "</a>　";
          }
          if ($sta_go4Q1  > 0) {
            echo "4Q <a href='student_sorting.php?select=go4Q1&no=" . $no . "'>" .   $mr[$sta_go4Q1] . "</a>";
          }
          ?><br>

          <?php
          if ($sta_go1Q2 > 0) {
            echo "2：";
          }
          if ($sta_go1Q2 > 0) {
            echo "1Q <a href='student_sorting.php?select=go1Q2&no=" . $no . "'>" .  $mr[$sta_go1Q2] . "</a>　";
          }
          if ($sta_go4Q2  > 0) {
            echo "4Q <a href='student_sorting.php?select=go4Q2&no=" . $no . "'>" .  $mr[$sta_go4Q2] . "</a>";
          }
          ?><br>

          <?php
          if ($sta_go1Q3 > 0) {
            echo "3：";
          }

          if ($sta_go1Q3 > 0) {
            echo "1Q <a href='student_sorting.php?select=go1Q3&no=" . $no . "'>" .  $mr[$sta_go1Q3] . "</a>　";
          }
          if ($sta_go4Q3  > 0) {
            echo "4Q <a href='student_sorting.php?select=go4Q3&no=" . $no . "'>" . $mr[$sta_go4Q3] . "</a>";
          }
          ?><br>

          <?php
          if ($sta_go1Q4 > 0) {
            echo "4：";
          }

          if ($sta_go1Q4 > 0) {
            echo "1Q <a href='student_sorting.php?select=go1Q4&no=" . $no . "'>" .  $mr[$sta_go1Q4] . "</a>　";
          }


          if ($sta_go4Q4  > 0) {
            echo "4Q <a href='student_sorting.php?select=go4Q4&no=" . $no . "'>" .  $mr[$sta_go4Q4] . "</a>";
          }
          ?><br>



        </td>
        <td>

          <?php
          if ($sta_rbas1 > 0) {
            echo "1：";
          }

          if ($sta_rbas1 > 0) {
            echo "<a href='student_sorting.php?select=rbas1&no=" . $no . "'>" . $mr[$sta_rbas1] . "</a>";
          }
          ?><br>


          <?php
          if ($sta_rbas2 > 0) {
            echo "2：";
          }

          if ($sta_rbas2 > 0) {
            echo "<a href='student_sorting.php?select=rbas2&no=" . $no . "'>" . $mr[$sta_rbas2] . "</a>";
          }
          ?><br>

          <?php
          if ($sta_rbas3 > 0) {
            echo "3：";
          }


          if ($sta_rbas3 > 0) {
            echo "<a href='student_sorting.php?select=rbas3&no=" . $no . "'>" . $mr[$sta_rbas3] . "</a>";
          }
          ?><br>
          <?php
          if ($sta_rbas4 > 0) {
            echo "4：";
          }

          if ($sta_rbas4 > 0) {
            echo "<a href='student_sorting.php?select=rbas4&no=" . $no . "'>" . $mr[$sta_rbas4] . "</a>";
          }
          ?>

        </td>


        <td>

          <?php

          if ($sta_ref_sw1 > 0) {
            echo "SWⅠ:<a href='student_sorting.php?select=ref_sw1&no=" . $no . "'>"  . $mr[$sta_ref_sw1] . "</a><br>";
          }


          if ($sta_ref_sw2 > 0) {
            echo "SWⅡ:<a href='student_sorting.php?select=ref_sw2&no=" . $no . "'>"  . $mr[$sta_ref_sw2] . "</a><br>";
          }



          if ($sta_ref_intern > 0) {
            echo "ｲﾝﾀｰﾝｼｯﾌﾟⅠ:<a href='student_sorting.php?select=ref_intern&no=" . $no . "'>"  . $mr[$sta_ref_intern] . "</a><br>";
          }


          if ($sta_ref_mental1 > 0) {
            echo "精神実習Ⅰ/ｲﾝﾀｰﾝｼｯﾌﾟⅡ:<a href='student_sorting.php?select=ref_mental1&no=" . $no . "'>"  . $mr[$sta_ref_mental1] . "</a><br>";
          }

          if ($sta_ref_advance > 0) {
            echo "精神実習Ⅱ:<a href='student_sorting.php?select=ref_advance&no=" . $no . "'>"  . $mr[$sta_ref_advance] . "</a><br>";
          }




          ?>

        </td>


        <td>


          <?php
          if ($sta_sch_sw1 > 0) {
            echo "SWⅠ:<a href='student_sorting.php?select=sch_sw1&no=" . $no . "'>"  . $mr[$sta_sch_sw1] . "</a><br>";
          }


          if ($sta_sch_sw2 > 0) {
            echo "SWⅡ:<a href='student_sorting.php?select=sch_sw2&no=" . $no . "'>"  . $mr[$sta_sch_sw2] . "</a><br>";
          }


          if ($sta_sch_mental1 > 0) {
            echo "精神実習Ⅰ:<a href='student_sorting.php?select=sch_mental1&no=" . $no . "'>"  . $mr[$sta_sch_mental1] . "</a><br>";
          }


          if ($sta_sch_mental2 > 0) {
            echo "精神実習Ⅱ:<a href='student_sorting.php?select=sch_mental2&no=" . $no . "'>"  . $mr[$sta_sch_mental2] . "</a><br>";
          }



          ?>

        </td>
        <td>


          <?php
          if ($sta_self_sw1 > 0) {
            echo "SWⅠ:<a href='student_sorting.php?select=self_sw1&no=" . $no . "'>"  . $mr[$sta_self_sw1] . "</a><br>";
          }


          if ($sta_self_sw2 > 0) {
            echo "SWⅡ:<a href='student_sorting.php?select=self_sw2&no=" . $no . "'>"  . $mr[$sta_self_sw2] . "</a><br>";
          }


          if ($sta_self_mental1 > 0) {
            echo "精神実習Ⅰ:<a href='student_sorting.php?select=self_mental1&no=" . $no . "'>"  . $mr[$sta_self_mental1] . "</a><br>";
          }


          if ($sta_self_mental2 > 0) {
            echo "精神実習Ⅱ:<a href='student_sorting.php?select=self_mental2&no=" . $no . "'>"  . $mr[$sta_self_mental2] . "</a><br>";
          }


          ?>


        </td>

        <td>

          <?php
          echo "<a href='student_sorting.php?select=prof&no=" . $no . "'>学生情報</a><br>";
          echo "<a href='student_sorting.php?select=outline&no=" . $no . "'>実習配属先</a><br>";
          echo "<a href='student_sorting.php?select=intern&no=" . $no . "'>実習生紹介書</a>";
          ?>

          <br><br>

          <!-- NEW BUTTON -->
          <?php if ($has_downloadable): ?>
            <form method="POST" action="download_student_zip.php" style="margin-top:5px;">
              <input type="hidden" name="student_number" value="<?= $no ?>">
              <button type="submit" class="btn btn-success btn-sm">
                CSV一括DL
              </button>
            </form>
          <?php else: ?>
            <span style="color: gray; font-size: 12px;">データなし</span>
          <?php endif; ?>

        </td>



      </tr>
  <?php
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
    die();
  }
  ?>
  </table>
  <?php

  // 接続を閉じる
  $dbh = null;



  //STOP($student_number,$name, $adresse,$logement,$tel);



  ?>



  <table class="table">
    <tr>
      <td>
        <?php btn_return("index.php", "戻る");?>
      </td>

      <td>
        <br><br>
      <form method="post">
        <button type='submit'  class='btn btn-secondary w-200px' name="download_csv">自己採点ダウンロード</button>
      </form>

    </tr>
  </table>

  <?PHP





  require('./disp_parts/footer.php');
  exit;
  ?>
