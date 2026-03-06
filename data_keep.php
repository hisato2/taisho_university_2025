<?php
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(function() {
            // フォームの入力欄が更新されたかどうかを表すフラグです。
            var isChanged = true;

            $(window).bind("beforeunload", function() {
                /*    console.log(isChanged);*/
                if (isChanged) {
                    return "このページを離れようとしています。データを保存しないと失われます。";
                }
            });

            $("button[type=submit]").click(function() {
                isChanged = false;
            });
        });
    </script>
