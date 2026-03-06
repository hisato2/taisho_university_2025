<?php

$key = '長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵長い鍵';
$addres = $_GET['add'];

$email = str_replace("|", "+", $addres);

$addres = openssl_decrypt($email, 'AES-128-ECB', $key);

function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

require_once('../../files/config_db_taisho2025.php');
require_once('./common/function.php');


require('./disp_parts/header.php');



dsip_midashi("パスワード再設定");

?>




<h5 class="text-center mb-4">パスワードを入力してください</h5>



<div class="row">
  <div class="col-4">

  </div>
  <div class="col-4">




    <form action="resetpass.php" method="post">
      <div class="input-group mb-3">


        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroup-sizing-default" style="width:100px">パスワード</span>
        </div>
<!--
        <input type="password" id="input_pass" name="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        &emsp;<button id="btn_passview" class="btn btn-secondary">表示</button>
-->

           <table>
              <tr>
                <td>
                 <input type="password" id="textPassword" name="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </td>

                <td>
                  <span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span>
                </td>
              </tr>
            </table>





      </div>



      <input type="hidden" name="email" value="<?php echo $addres; ?>">
      <p class="fs80">※パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上で設定してください。記号は使えません。</p>
      <br><br>
      <div class="text-center">
        <button type="submit" class="btn btn-info btn-sm ml">再設定</button>
      </div>
    </form>

  </div>
  <div class="col-4">

  </div>

</div>









<div style="height:400px;"></div>
<?php

require('./disp_parts/footer.php');
exit;
?>