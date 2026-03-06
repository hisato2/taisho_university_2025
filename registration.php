<?php
session_start();


function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

require_once('../../files/config_db_taisho2025.php');
require_once('./disp_parts/msg.php');
require_once('./common/function.php');



//■stop($_POST['TABLE'] ."<br>".$_POST['METHOD']);









if (($_POST['TABLE'] == "tbl_nendo") & ($_POST['METHOD'] == "UP_DATE")) {

  tbl_nend_UPDATE();
}


if (($_POST['TABLE'] == "tbl_student_introduction") & ($_POST['METHOD'] == "COMMENT_UP")) {
  tbl_student_introduction_COMMENTUP($_POST['STUDENT_NUMBER']);
}


if (($_POST['TABLE'] == "tbl_institution_overview") & ($_POST['METHOD'] == "UP_DATE")) {




if (($_POST['学年']=="1学年") or ($_POST['学年']=="１学年")){
  $学年="1";
}

if (($_POST['学年']=="2学年") or ($_POST['学年']=="２学年")){
  $学年="2";
}
if (($_POST['学年']=="3学年") or ($_POST['学年']=="３学年")) {
  $学年="3";
}
if (($_POST['学年']=="4学年") or ($_POST['学年']=="４学年")){
  $学年="4";
}



  tbl_institution_overview_UPDATE($_POST['STUDENT_NUMBER'],$学年,$_POST['実習種別']);
}


if (($_POST['TABLE'] == "tbl_student_introduction") & ($_POST['METHOD'] == "UP_DATE")) {
  tbl_student_introduction_UPDATE($_POST['STUDENT_NUMBER']);
}




if (($_POST['TABLE'] == "tbl_assignment") & ($_POST['METHOD'] == "UP_DATE")) {




  tbl_assignment_UPDATE($_POST['法人ID'],$_POST['施設区分'],$_POST['事業年度']);


}




if (($_POST['TABLE'] == "tbl_instructor") & ($_POST['METHOD'] == "UP_DATE")) {
  tbl_instructor_UPDATE($_POST['法人ID'],$_POST['title']);
}



if (($_POST['TABLE'] == "tbl_institution") & ($_POST['METHOD'] == "UP_DATE")) {
  tbl_institution_UPDATE($_POST['法人ID'],$_POST['title']);
}





///////////////////////////////////////
// tbl_self_assessment
///////////////////////////////////////
if (($_POST['TABLE'] == "tbl_self_assessment") & ($_POST['METHOD'] == "COMMENT_UP")) {
    $student_number = $_POST['STUDENT_NUMBER'];
    $cheet_title = $_POST['SHEET_TITLE'] ;


    submission_status_put($_POST['column'], $_POST['status'],$student_number,"");
    tbl_self_assessment_COMMENT_UP($student_number,  $_POST['SHEET_TITLE'] );


}




///////////////////////////////////////
// tbl_self_assessment
///////////////////////////////////////
if (($_POST['TABLE'] == "tbl_self_assessment") & ($_POST['METHOD'] == "UP_DATE")) {
    $student_number = $_POST['STUDENT_NUMBER'];
    $cheet_title = $_POST['SHEET_TITLE'] ;


    submission_status_put($_POST['column'], $_POST['status'],$student_number,"");
    tbl_self_assessment_update($student_number,  $_POST['SHEET_TITLE'] );


}



///////////////////////////////////////
// tbl_practice_plan
///////////////////////////////////////
if (($_POST['TABLE'] == "tbl_practice_plan") & ($_POST['METHOD'] == "COMMENT_UP")) {
    $student_number = $_POST['STUDENT_NUMBER'];
    $cheet_title = $_POST['SHEET_TITLE'] ;
    submission_status_put($_POST['column'], $_POST['status'],$student_number,"");
    tbl_practice_plan_COMMENT_UP($student_number,  $_POST['SHEET_TITLE'] );


}



///////////////////////////////////////
// tbl_practice_plan
///////////////////////////////////////
if (($_POST['TABLE'] == "tbl_practice_plan") & ($_POST['METHOD'] == "UP_DATE")) {
    $student_number = $_POST['STUDENT_NUMBER'];
    $cheet_title = $_POST['SHEET_TITLE'] ;
    submission_status_put($_POST['column'], $_POST['status'],$student_number,"");
    tbl_practice_plan_update($student_number,  $_POST['SHEET_TITLE'] );


}





///////////////////////////////////////
// tbl_goal_sheet_4Q
///////////////////////////////////////
if (($_POST['TABLE'] == "tbl_reflection_intern") & ($_POST['METHOD'] == "COMMENT_UP")) {
    $student_number = $_POST['STUDENT_NUMBER'];


    submission_status_put($_POST['column'], $_POST['status'],$student_number,"");
    tbl_reflection_intern_COMMENT_UP($student_number,  $_POST['SHEET_TITLE'] );


}



///////////////////////////////////////
// tbl_goal_sheet_4Q
///////////////////////////////////////
if (($_POST['TABLE'] == "tbl_reflection_intern") & ($_POST['METHOD'] == "UP_DATE")) {
    $student_number = $_POST['STUDENT_NUMBER'];
    $school_year = $_POST['SELECT_NEN'];

    submission_status_put($_POST['column'], $_POST['status'],$student_number,"");
    tbl_reflection_intern_update($student_number,  $_POST['SHEET_TITLE'] );


}



///////////////////////////////////////
// tbl_goal_sheet_4Q
///////////////////////////////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['TABLE']) && isset($_POST['METHOD'])) {
    
    if (($_POST['TABLE'] == "tbl_reflection_base") &&
      ($_POST['METHOD'] == "UP_DATE")) {
        $student_number = $_POST['STUDENT_NUMBER'];
        $school_year = $_POST['SELECT_NEN'];

    if (!isset($_POST['status'])) {
      $_POST['status'] = "0";
    }
    submission_status_put($_POST['column'], $_POST['status'],$student_number,"");
    tbl_reflection_base_update($student_number, $school_year);
  }
}
}


///////////////////////////////////////
// tbl_goal_sheet_4Q
///////////////////////////////////////
if (($_POST['TABLE'] == "tbl_reflection_base") && ($_POST['METHOD'] == "COMMENT_UP")) {
    $student_number = $_POST['STUDENT_NUMBER'];
    $school_year = $_POST['SELECT_NEN'];

    if (!isset($_POST['status'])) {
      $_POST['status'] - "0";
    }

    submission_status_put($_POST['column'], $_POST['status'],$student_number,   $school_year);
    tbl_reflection_base_COMMENT_UP($student_number, $school_year);
}





///////////////////////////////////////
// tbl_goal_sheet_4Q
///////////////////////////////////////
if (($_POST['TABLE'] == "tbl_goal_sheet_4q") & ($_POST['METHOD'] == "UP_DATE")) {
    $student_number = $_POST['STUDENT_NUMBER'];
    $school_year = $_POST['SELECT_NEN'];



    submission_status_put($_POST['column'], $_POST['status'],$student_number,    $school_year );
    tbl_goal_sheet_4q_update($student_number, $school_year);
}


///////////////////////////////////////
// tbl_goal_sheet_4Q
///////////////////////////////////////
if (($_POST['TABLE'] == "tbl_goal_sheet_4q") & ($_POST['METHOD'] == "COMMENT_UP")) {
    $student_number = $_POST['STUDENT_NUMBER'];
    $school_year = $_POST['SELECT_NEN'];



    submission_status_put($_POST['column'], $_POST['status'],$student_number,    $school_year );
    tbl_goal_sheet_4q_COMMENT_UP($student_number, $school_year);
}

///////////////////////////////////////
//  tbl_goal_sheet_1Q
//  読込はfunction.php）
///////////////////////////////////////



if (($_POST['TABLE'] == "tbl_goal_sheet_1q") & ($_POST['METHOD'] == "UP_DATE")) {

  $student_number = $_POST['STUDENT_NUMBER'];
  $school_year = $_POST['SELECT_NEN'];

  submission_status_put($_POST['column'], $_POST['status'],$student_number,$school_year);


  tbl_goal_sheet_1q_update($student_number, $school_year);

}
                                                                     
if (($_POST['TABLE'] == "tbl_goal_sheet_1q") & ($_POST['METHOD'] == "COMMENT_UP")) {


  $student_number = $_POST['STUDENT_NUMBER'];
  $school_year = $_POST['SELECT_NEN'];

  submission_status_put($_POST['column'], $_POST['status'],$student_number,$school_year);


  tbl_goal_sheet_1q_COMMENT_UP($student_number, $school_year);

}






///////////////////////////////////////
// tbl_profile_detail
///////////////////////////////////////
if (($_POST['TABLE'] == "tbl_profile_detail") & ($_POST['METHOD'] == "UP_DATE")) {




  $student_number = $_POST['STUDENT_NUMBER'];
  $school_year = $_POST['SELECT_NEN'];

  submission_status_put($_POST['column'], $_POST['status'],$student_number,$school_year);


  tbl_profile_detail_UPDATE($student_number, $school_year);
}



///////////////////////////////////////
// tbl_profile_detail
///////////////////////////////////////
if (($_POST['TABLE'] == "tbl_profile_detail") & ($_POST['METHOD'] == "COMMENT_UP")) {

  
  $student_number = $_POST['STUDENT_NUMBER'];
  $school_year = $_POST['SELECT_NEN'];
   

  submission_status_put($_POST['column'], $_POST['status'],$student_number,$school_year);
  tbl_profile_detail_COMMENT_UP($student_number, $school_year);
}





///////////////////////////////////////
// tbl_profile
///////////////////////////////////////

 

if (($_POST['TABLE'] == "tbl_profile") & ($_POST['METHOD'] == "UP_DATE")) {


  $student_number  =$_POST['STUDENT_NUMBER'];
  tbl_profile_UPDATE($student_number);
 
}


///////////////////////////////////////
// tbl_profile
///////////////////////////////////////
if (($_POST['TABLE'] == "tbl_profile") & ($_POST['METHOD'] == "Bulk insert")) {

    dsip_msg("更新しました");
    btn_return("index.php", "戻る");
    exit;


}
