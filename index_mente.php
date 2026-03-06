<?php
session_start();
$_SESSION = array();

require_once('../../files/config_db_taisho2025.php');



require_once('./common/function.php');


if (!isset($_SESSION['KUBUN'])) {
    $_SESSION['KUBUN']="";
    $_SESSION['NAME']="";
    $_SESSION['STUDENT_NUMBER']="";
}

require('./disp_parts/headerNon.php');


    dsip_msg("ただいま、メンテナンス中です");

?>
<?php
require('./disp_parts/footer.php');
?>