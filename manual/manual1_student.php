<?php


$共通項目 = "<p>各入力欄に入力してください。</p>";

$共通項目 = $共通項目 . "<p class='my-4'>　</p>";


$共通項目 = $共通項目 . "<p>入力が済んだら「下書き」ボタンあるいは「提出」ボタンをクリックして登録てください。</p>";
$共通項目 = $共通項目 . "<p>メニューに戻る場合は戻るボタンをクリックしてください。</p><p>ブラウザの「戻る」ボタンでは正しく動作しない場合がありますので「戻る」ボタンを使用してください。</p>";
$共通項目 = $共通項目 . "<p>「下書き」ボタンで登録した場合は、後で加筆修正できます。</p>";
$共通項目 = $共通項目 . "<p>「提出」ボタンで登録した場合は、先生が確認しますので、その間「下書き」ボタン「提出」ボタンはロックされます</p>";
$共通項目 = $共通項目 . "<p>提出状況は下書中、提出済、要修正、承認済があります。</p>";



$コメント = "<p>画面下には先生からのコメント欄があります。</p>";
$コメント = $コメント . "<p>提出すると先生が確認して必要に応じてコメントを書いてくれます。</p>";
$コメント = $コメント . "<p>要修正と表示された場合は、先生が修正を求めています。先生からのコメントを参照して必要な修正を行い、再提出してください。</p>";
$コメント = $コメント . "承認済となった場合はシートの作成終了です。先生からのコメントを参照して学修にはげんでください。</p>";




?>

<html lang="ja">

<head>
    <meta charset="utf-8">
    <style>
        .float_l {
            margin-bottom: 10px;
            margin-right: 10px;
            float: left;
        }

        .float_r {
            margin-bottom: 10px;
            margin-left: 10px;
            float: right;
        }

        .container-fluid {
            margin-right: auto;
            margin-left: auto;
            max-width: 960px;
            background-repeat: no-repeat;
            background-position: top;
            background-size: contain;
            background-color: white
        }

        .image-width {
            width: 60%;
            margin-bottom: 50px;
        }

        .image-width50 {
            width: 30%;
            margin-bottom: 50px;
        }

        .clear {
            clear: both;
        }

        h2 {
            background-color: cornflowerblue;
            color: rgb(255, 255, 255);
            font-size: 24px !important;
            display: inline-block;
            padding-left: 20px;
            padding-right: 20px;
            border-radius: 10px;
        }

        p {
            line-height: 1.2rem;
        }

        .fw {
            font-weight: 900;
           color: rgb(214, 122, 127);
        }

        

    </style>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

</head>

<body>


    <div class="container-fluid">
        <h1>学修支援作成システム（学生用マニュアル）</h1>



        <div class="clear w-100">
            <h2 class="my-5">ログイン画面</h2>
        </div>


        <img src="img1/image1001.png" alt="" class="float_l image-width">
        <p>学生の場合は、予め事務局からメールアドレスと仮パスワードが配布されます。</p>
        <p>仮パスワードでログインしてから個人情報画面より、パスワードの設定をおこなってください。</p>
        <p>パスワードを忘れた場合は巻末をご参照ください。</p>


        <div class="clear w-100">
            <h2 class="my-5">メニュー画面</h2>
        </div>


        <img src="img1/image1002.png" alt="" class="float_l image-width">
        <p>学生用のメニュー画面です。</p>
        <p>各ボタンをクリックすると入力画面が表示されます</p>
        <p>終了する場合は、ログアウトボタンをクリックしてください。</p>



        <div class="clear w-100">
            <h2 class="my-5">個人情報画面</h2>
        </div>


        <img src="img1/image1003.png" alt="" class="float_l image-width">
        <p>個人情報登録画面です。</p>
        <p>最初に初期設定されたパスワードでログインされた方は、ここで、パスワードの再登録をおこなってください。</p>
        <p>パスワードを変更しない場合はパスワード欄は空欄のままにしてください。</p>



        <div class="clear w-100">
            <h2 class="my-5">学修計画・リフレクション・シート　シート選択画面</h2>
        </div>
        <img src="img1/image1004.png" alt="" class="float_l image-width">
        <p>プロフィールシート、ゴールシート、リフレクションシートは年次ごとに作成します。</p>
        <p>実習リフレクションシートは実習種別毎に作成します。</p>




        <img src="img1/image1004-2.png" alt="" class="image-width50">
        <p class="mb-5">学年は選択ボタンをクリックして指定します。</p>




        <?php echo $共通項目; ?>
        <?php echo $コメント; ?>



        <div class="clear w-100">
            <h2 class="my-5">プロフィールシート画面</h2>
        </div>
        <img src="img1/image1005.png" alt="" class="float_l image-width">



        <p>プロフィールシート画面です。年次を通して表示されます。</p>
        <p>この画面は４年次の例です</p>
        <p>全画面で選択した年次にあたる列に入力が可能となります。</p>



        <?php echo $共通項目; ?>
        <?php echo $コメント; ?>

        <div class="clear w-100">
            <h2 class="my-5">学修行動計画(ゴール・シート)(1Q)</h2>
        </div>

        <img src="img1/image1006.png" alt="" class="float_l image-width">
        <p>学修行動計画(ゴール・シート)(1Q)の入力画面です。</p>
        <p>画面は４年次の例です</p>

        <?php echo $共通項目; ?>
        <?php echo $コメント; ?>



        <div class="clear w-100">
            <h2 class="my-5">学修行動計画(ゴール・シート)(1Q)の内容が他のシートに転記される</h2>
        </div>

        <img src="img2/imageP001.png" alt="" class="float_l image-width">



        <p>学修行動計画(ゴール・シート)(1Q)には、各年次に応じて次の内容があります。</p>
        <h6>１年次</h6>
            <P>&#9312;1.1の「自分」になるためのあなたの到達目標</P>


        <h6>２年次</h6>
        
            <P>&#9312;1.1の「自分」になるためのあなたの到達目標</P>
            <P>&#9313;ソーシャルワーク実習Ⅰ</P>
            <P>&#9314;インターンシップⅠ</P>



   <h6>３年次</h6>
        
            <P>&#9312;1.1の「自分」になるためのあなたの到達目標</P>
            <P>&#9313;ソーシャルワーク実習Ⅱ</P>
            <P>&#9314;精神実習Ⅰ（単独）/インターンシップⅡ</P>

     


   <h6>４年次</h6>
     
            <P>&#9312;1.1の「自分」になるためのあなたの到達目標</P>
            <P>&#9313;ソーシャルワーク実習Ⅱ</P>
            <P>&#9314;アドバンス・クラス/精神実習Ⅱ（単独）</P>
     
            <hr>
   <h6>各年次共通</h6>
        <p>ゴール・シート)(1Q)の&#9312;<span class="fw">「自分」になるためのあなたの到達目標</span>は、同じ年次のゴールシート４Qの「あなたの到達目標」に転記されます。</p>
        <p>また、同じ年次のリフレクションシートの2.「共通の到達目標」を踏まえた、あなたの到達目標 に転記されます。</p>

   <h6>２年時のゴール・シート)(1Q)の</h6>
           <P>&#9313;<span class="fw">ソーシャルワーク実習Ⅰ</span>は、実習リフレクションシートのソーシャルワーク実習Ⅰの2.「共通の到達目標」を踏まえた、あなたの到達目標に転記されます。</P>
            <P>&#9314;<span class="fw">インターンシップⅠ</span>は、実習リフレクションシートのインターンシップⅠの2.「共通の到達目標」を踏まえた、あなたの到達目標に転記されます。</P>

   <h6>３年時のゴール・シート)(1Q)の</h6>
           <P>&#9313;<span class="fw">ソーシャルワーク実習Ⅱ</span>は、実習リフレクションシートのソーシャルワーク実習Ⅱの2.「共通の到達目標」を踏まえた、あなたの到達目標に転記されます。</P>
            <P>&#9314;<span class="fw">精神実習Ⅰ（単独）/インターンシップⅡ</span>は、実習リフレクションシートの精神実習Ⅰ（単独）/インターンシップⅡの2.「共通の到達目標」を踏まえた、あなたの到達目標に転記されます。</P>



   <h6>４年時のゴール・シート)(1Q)の</h6>
           <P>&#9313;<span class="fw">ソーシャルワーク実習Ⅱ</span>は、実習リフレクションシートのソーシャルワーク実習Ⅱの2.「共通の到達目標」を踏まえた、あなたの到達目標に転記されます。</P>
           <P>ソーシャルワーク実習Ⅱを希望する人で３年時に実習を行わなかった人は４年次で実習することになります。</P>

            <P>&#9314;<span class="fw">アドバンス・クラス/精神実習Ⅱ（単独）</span>は、実習リフレクションシートのアドバンス・クラス/精神実習Ⅱ（単独）の2.「共通の到達目標」を踏まえた、あなたの到達目標に転記されます。</P>



        <div class="clear w-100">
            <h2 class="my-5">学修行動計画(ゴール・シート)(4Q)</h2>
        </div>

        <img src="img1/image1007.png" alt="" class="float_l image-width">




        <p>学修行動計画(ゴール・シート)(4Q)の入力画面です。</p>
        <p>画面は４年次の例です</p>



        <?php echo $共通項目; ?>
        <?php echo $コメント; ?>





        <div class="clear w-100">
            <h2 class="my-5">学修行動計画(リフレクション・シート)(4Q)</h2>
        </div>
        <img src="img1/image1008.png" alt="" class="float_l image-width">
        <p>学修行動計画(リフレクション・シート)(4Q)の入力画面です。</p>

        <?php echo $共通項目; ?>
        <?php echo $コメント; ?>



        <div class="clear w-100">
            <h2 class="my-5">実習リフレクションシート</h2>
        </div>
        <img src="img1/image1009.png" alt="" class="float_l image-width">
        <p>画面の例は学修行動計画(ソーシャルワーク実習Ⅰ・リフレクション・シート)の入力画面です。</p>
        <p>実習リフレクションシートには次の５種類がありますが入力形式は共通しています</p>
        <p>　１．ソーシャルワーク実習Ⅰ</p>
        <p>　２．ソーシャルワーク実習Ⅱ</p>
        <p>　３．インターンシップⅠ</p>
        <p>　４．精神実習Ⅰ（単独）/インターンシップⅡ</p>
        <p>　５．アドバンスクラス/精神実習Ⅱ（単独）</p>
        <p>自分の必要なシートを作成してください。</p>


        <?php echo $共通項目; ?>
        <?php echo $コメント; ?>



        <div class="clear w-100">
            <h2 class="my-5">実習施設・機関の概要（配属登録された施設リスト）</h2>
        </div>
        <img src="img1/image1010.png" alt="" class="float_l image-width">
        <p>先生が実習配属先を選び割り当てをおこなってくれます。</p>
        <p>すると、配属先のリストが表示されます。一か所の場合も複数の場合もあるかもしれません。</p>

        <p>配属登録された施設リストから実習施設・機関を選択し、「詳細」をクリックして詳細画面を表示してください。</p>


        <div class="clear w-100">
            <h2 class="my-5">実習施設・機関の概要（詳細）</h2>
        </div>

        <img src="img1/image1011.png" alt="" class="float_l image-width">
        <p>実習施設・機関の概要を入力します</p>
        <p>基本内容は、施設情報から読みだされ表示されます。もし変更・修正が必要な場合があれば、ここで修正登録することができます。</p>


        <p>入力したら「実習施設・機関の概要登録」ボタンをクリックして登録してください。</p>
        <p>このシートには、「下書き」や「提出」はなく、「実習施設・機関の概要登録」ボタンだけです。</p>





        <div class="clear w-100">
            <h2 class="my-5">実習計画・自己評価シートリスト</h2>
        </div>
        <img src="img1/image1012.png" alt="" class="float_l image-width">

        <p>実習計画計画書、及び、自己評価シートを作成するメニューです。</p>

        <p>実習計画・自己評価シートリストから実習施設先を選択します。実習計画書か、自己評価表のいずれかを選択して詳細入力画面を開きます</p>

        <div class="clear w-100">
            <h2 class="my-5">実習計画表</h2>
        </div>
        <img src="img1/image1013.png" alt="" class="float_l image-width">
        <p>実習計画表を入力します。</p>
        <p>基本内容は、施設情報から読みだされ表示されます。もし変更・修正が必要な場合があれば、ここで修正登録することができます。</p>


        <?php echo $共通項目; ?>
        <?php echo $コメント; ?>



        <div class="clear w-100">
            <h2 class="my-5">自己評価表</h2>
        </div>
        <img src="img1/image1014.png" alt="" class="float_l image-width">
        <p>実習した結果の自己評価表を作成します。</p>
        <p>基本内容は、施設情報から読みだされ表示されます。もし変更・修正が必要な場合があれば、ここで修正登録することができます。</p>


        <?php echo $共通項目; ?>
        <?php echo $コメント; ?>



        <div class="clear w-100">
            <h2 class="my-5">実習生紹介書</h2>
        </div>
        <img src="img1/image1015.png" alt="" class="float_l image-width">
        <p>実習生紹介書を入力します。</p>


        <p>入力したら「実習生紹介書登録」ボタンをクリックして登録してください。</p>
        <p>このシートには、「下書き」や「提出」はなく、「実習生紹介書登録」ボタンだけです。</p>
        <p>画面下に先生からのコメントが記入されますので、参照してください。</p>






        <div class="clear w-100">
            <h2 class="my-5">パスワードを忘れた場合</h2>
        </div>
        <img src="img2/image2001.png" alt="" class="float_l image-width">

        <p>パスワードを忘れた場合は再設定をおこなってください。</p>

        <p>パスワードを忘れたボタンをクリックしてください。</p>



        <div class="clear w-100">
            <h2 class="my-5">パスワードを忘れた場合（続き）</h2>
        </div>

        <img src="img2/image2001-P1.png" alt="" class="float_l image-width">
        <img src="img2/image2001-P2.png" alt="" class="float_l image-width">

        <p>メールアドレスを入力して送信します。</p>



        <div class="clear w-100">
            <h2 class="my-5">パスワードを忘れた場合（続き）</h2>
        </div>

        <img src="img2/image2001-P3.png" alt="" class="float_l image-width">

        <img src="img2/image2001-P4.png" alt="" class="float_l image-width">


        <p>再設定のためのリンクがメールで送られてきますので確認してください。</p>
        <p>リンクをクリックすると設定画面が表示されます。</p>



        <div class="clear w-100">
            <h2 class="my-5">パスワードを忘れた場合（続き）</h2>
        </div>

        <img src="img2/image2001-P5.png" alt="" class="float_l image-width">




        <p>パスワードを再入力し、再設定ボタンをクリックします。</p>



    </div>

</body>

</html>