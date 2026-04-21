<?php
session_start();
if (!isset($_SESSION['EMAIL'])) {
  header("Location:Location: index.php");
  exit;
}

function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

require_once('./files/config_db_taisho2025.php');
require_once('./common/function.php');

/*


*/

$_SESSION['SEL_STUDENT_NUMBER']= $_GET['no'];


switch ($_GET['select']) {




  case 'outline':
    header("Location:indicate_sheet_equipment_outline_list.php");
    break;


  case 'intern':
    header("Location:indicate_sheet_intern_introduction.php");
    break;


  case 'prof':

    header("Location:indicate_account.php");

    break;


  case 'prof1':
    $_SESSION['SEL_SELECT_NEN'] = "1";

    header("Location:indicate_sheet_profile.php");

    break;

  case 'prof2':
    $_SESSION['SEL_SELECT_NEN'] = "2";
    header("Location:indicate_sheet_profile.php");
    break;
  case 'prof3':
    $_SESSION['SEL_SELECT_NEN'] = "3";
    header("Location:indicate_sheet_profile.php");
    break;
  case 'prof4':
    $_SESSION['SEL_SELECT_NEN'] = "4";
    header("Location:indicate_sheet_profile.php");
    break;
  case 'go1Q1':
    $_SESSION['SEL_SELECT_NEN'] = "1";
    header("Location:indicate_sheet_goal1Q.php");
    break;
  case 'go4Q1':
    $_SESSION['SEL_SELECT_NEN'] = "1";
    header("Location:indicate_sheet_goal4Q.php");

    break;
  case 'go1Q2':
    $_SESSION['SEL_SELECT_NEN'] = "2";
    header("Location:indicate_sheet_goal1Q.php");

    break;
  case 'go4Q2':
    $_SESSION['SEL_SELECT_NEN'] = "2";
    header("Location:indicate_sheet_goal4Q.php");

    break;
  case 'go1Q3':
    $_SESSION['SEL_SELECT_NEN'] = "3";
    header("Location:indicate_sheet_goal1Q.php");

    break;
  case 'go4Q3':
    $_SESSION['SEL_SELECT_NEN'] = "3";
    header("Location:indicate_sheet_goal4Q.php");

    break;
  case 'go1Q4':
    $_SESSION['SEL_SELECT_NEN'] = "4";
    header("Location:indicate_sheet_goal1Q.php");

    break;
  case 'go4Q4':
    $_SESSION['SEL_SELECT_NEN'] = "4";
    header("Location:indicate_sheet_goal4Q.php");
    break;
  case 'rbas1':
    $_SESSION['SEL_SELECT_NEN'] = "1";
    header("Location:indicate_sheet_ref_base.php");
    break;
  case 'rbas2':
    $_SESSION['SEL_SELECT_NEN'] = "2";
    header("Location:indicate_sheet_ref_base.php");

    break;
  case 'rbas3':
    $_SESSION['SEL_SELECT_NEN'] = "3";
    header("Location:indicate_sheet_ref_base.php");

    break;
  case 'rbas4':
    $_SESSION['SEL_SELECT_NEN'] = "4";
    header("Location:indicate_sheet_ref_base.php");


    break;
  case 'ref_sw1':

    $_SESSION['SEL_COLUMN'] = "ref_sw1";

    $_SESSION['SEL_SHEET_TITLE'] = "ソーシャルワーク実習Ⅰ";
    header("Location:indicate_sheet_ref_intern.php");
    break;
  case 'ref_sw2':
    $_SESSION['SEL_COLUMN'] = "ref_sw2";
    $_SESSION['SEL_SHEET_TITLE'] = "ソーシャルワーク実習Ⅱ";
    header("Location:indicate_sheet_ref_intern.php");
    break;
  case 'ref_intern':
    $_SESSION['SEL_COLUMN'] = "ref_intern";
    $_SESSION['SEL_SHEET_TITLE'] = "インターンシップⅠ";
    header("Location:indicate_sheet_ref_intern.php");
    break;
  case 'ref_mental1':
    $_SESSION['SEL_COLUMN'] = "`ref_mental1";
    $_SESSION['SEL_SHEET_TITLE'] = "精神実習Ⅰ/インターンシップⅡ";
    header("Location:indicate_sheet_ref_intern.php");
    break;

    case 'ref_advance':
    $_SESSION['SEL_COLUMN'] = "ref_advance";
    $_SESSION['SEL_SHEET_TITLE'] = "精神実習Ⅱ";
    header("Location:indicate_sheet_ref_intern.php");
    break;


  case 'sch_sw1':

    $_SESSION['SEL_COLUMN'] = "sch_sw1";

    $_SESSION['SEL_SHEET_TITLE'] = "ソーシャルワーク実習Ⅰ";
    header("Location:indicate_sheet_practice_plan.php");
    break;
  case 'sch_sw2':
    $_SESSION['SEL_COLUMN'] = "sch_sw2";
    $_SESSION['SEL_SHEET_TITLE'] = "ソーシャルワーク実習Ⅱ";
    header("Location:indicate_sheet_practice_plan.php");
    break;
  case 'sch_mental1':
    $_SESSION['SEL_COLUMN'] = "sch_mental1";
    $_SESSION['SEL_SHEET_TITLE'] = "精神保健福祉援助実習Ⅰ";

    header("Location:indicate_sheet_practice_plan.php");
    break;
  case 'sch_mental2':
    $_SESSION['SEL_COLUMN'] = "sch_mental2";
    $_SESSION['SEL_SHEET_TITLE'] = "精神保健福祉援助実習Ⅱ";

    header("Location:indicate_sheet_practice_plan.php");
    break;


  case 'self_sw1':

    $_SESSION['SEL_COLUMN'] = "self_sw1";

    $_SESSION['SEL_SHEET_TITLE'] = "ソーシャルワーク実習Ⅰ";

    header("Location:indicate_sheet_self_assessment.php");
    break;
  case 'self_sw2':
    $_SESSION['SEL_COLUMN'] = "self_sw2";
    $_SESSION['SEL_SHEET_TITLE'] = "ソーシャルワーク実習Ⅱ";
    header("Location:indicate_sheet_self_assessment.php");
    break;
  case 'self_mental1':
    $_SESSION['SEL_COLUMN'] = "self_mental1";
    $_SESSION['SEL_SHEET_TITLE'] = "精神保健福祉援助実習Ⅰ";

    header("Location:indicate_sheet_self_assessment.php");
    break;
  case 'self_mental2':
    $_SESSION['SEL_COLUMN'] = "self_mental2";
    $_SESSION['SEL_SHEET_TITLE'] = "精神保健福祉援助実習Ⅱ";

    header("Location:indicate_sheet_self_assessment.php");
    break;

}



  exit;
  ?>