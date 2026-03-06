<?php
?>
<!DOCTYPE html>
<html dir="ltr" lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes, maximum-scale=1.0, minimum-scale=1.0">
    <title>大正大学社会福祉学科|学修支援システム</title>
    <meta name="description" content="大正大学社会福祉学科|学修行動計画作成システム" />
    <meta content="大正大学社会福祉学科,学修行動計画作成システム" name="author" />
    <meta content="大正大学社会福祉学科,学修行動計画作成システム" name="keywords" />
    <link rel='stylesheet' href='./css/style.css' type='text/css' media='all' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    <script type="text/javascript">
        function check() {

            if (window.confirm('処理を続行してよろしいですか？')) { // 確認ダイアログを表示
                return true; // 「OK」時は送信を実行

            } else { // 「キャンセル」時の処理
                return false; // サブミットを中止
            }
        }



        window.addEventListener('DOMContentLoaded', function() {

            // (1)パスワード入力欄とボタンのHTMLを取得
            let btn_passview = document.getElementById("btn_passview");
            let input_pass = document.getElementById("input_pass");

            // (2)ボタンのイベントリスナーを設定
            btn_passview.addEventListener("click", (e) => {

                // (3)ボタンの通常の動作をキャンセル（フォーム送信をキャンセル）
                e.preventDefault();

                // (4)パスワード入力欄のtype属性を確認
                if (input_pass.type === 'password') {

                    // (5)パスワードを表示する
                    input_pass.type = 'text';
                    btn_passview.textContent = '非表示';

                } else {

                    // (6)パスワードを非表示にする
                    input_pass.type = 'password';
                    btn_passview.textContent = '表示';
                }
            });

            window.addEventListener("DOMContentLoaded", () => {
                // textareaタグを全て取得
                const textareaEls = document.querySelectorAll("textarea");

                textareaEls.forEach((textareaEl) => {
                    // デフォルト値としてスタイル属性を付与
                    textareaEl.setAttribute("style", `height: ${textareaEl.scrollHeight}px;`);
                    // inputイベントが発生するたびに関数呼び出し
                    textareaEl.addEventListener("input", setTextareaHeight);
                });

                // textareaの高さを計算して指定する関数
                function setTextareaHeight() {
                    this.style.height = "auto";
                    this.style.height = `${this.scrollHeight}px`;
                }
            });

        });
    </script>


</head>




<body>
    <div class="container-fluid">
        <form action='<?php echo $ACTION; ?>' method='post' onSubmit='return check()'>
            <header>

                <?php
                GET_NENDO();
                ?>

                <img src="./images/header_image2.png" class="w-100" alt=" ... " />
                <h1></h1>
                <h2></h2>

                <table width="100%">
                    <tr>
                        <td width="33%">
                        </td>

                        <?php if (isset($ACTION)) {
                            echo "<td class='text-center pt-1'><button type='submit' class='btn2 btn-secondary'>戻る</button></td>";
                        }
                        ?>

                        <td class=' text-end' width="33%">
                            <?php
                            if (isset($_SESSION['STUDENT_NUMBER'])) {
                                echo "<span class='fw600'>" . $_SESSION['KUBUN'] . " " . $_SESSION['STUDENT_NUMBER'] . " " . $_SESSION['NAME'] . "</span>&emsp;";
                            }
                            ?>
                        </td>
                    </tr>
                </table>

            </header>

        </FORM>



        <main>
            <!-- 16:9 aspect ratio -->
            <div class="row">
                <!--メインエリアー-->
                <div class="col-sm-12">
                    <div class="tight_w">
                        <?php
                        ?>