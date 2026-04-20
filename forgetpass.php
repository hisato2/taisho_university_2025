<?php
session_start();


function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

require_once('./files/config_db_taisho2025.php');
require_once('./common/function.php');

require('./disp_parts/header.php');


/*require('header_w.php');*/
require('data_keep.php');




?>
            <h5 class="text-center my-5">メールアドレスを入力してください。</h5>
              <form action="mail_pass.php" method="post">

                <div class="text-center">
                  <label for="email">メールアドレス</label>
                  <input type="email" name="email" size="40" required>
                  <button type="submit" class="btn btn-outline-info btn-sm ml">メール送信</button>

                </div>
              </form>




              <div class="mt-4" style="width:100%;text-align:center">
              <?php
                  btn_return("index.php", "戻る");
              ?>
              </div>

                <div style="height:400px;"></div>



<?PHP




require('./disp_parts/footer.php');
exit;
?>



