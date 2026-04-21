<?php
session_start();

require_once('./files/config_db_taisho2025.php');


require_once('./common/function.php');



if (!isset($_SESSION['KUBUN'])) {
    $_SESSION['KUBUN']="";
    $_SESSION['NAME']="";
    $_SESSION['STUDENT_NUMBER']="";
}


require('./disp_parts/headerNon.php');





if (!isset($_SESSION['EMAIL'])) {
    login();
} else {

    if ($_SESSION['KUBUN'] == "教員") {
        kanri_menu();
    } else {
        mein_menu();
    }
}
?>
<?php
require('./disp_parts/footer.php');
?>

