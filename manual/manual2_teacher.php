<?php


$共通項目 = "<p>教員・事務局メニューでは、学生が学生が記入したシートを閲覧することができます。</p>";
$共通項目 = $共通項目 . "<p>画面下には教員からコメント欄があります。</p>";
$共通項目 = $共通項目 . "<p>学生が「下書き」中は、まだコメントを記入できません</p>";
$共通項目 = $共通項目 . "<p>学生が「提出」したものはコメントを記入することができます。</p>";

$共通項目 = $共通項目 . "<p>内容を確認して修正が必要なものは、コメントを記入した後、「要修正」ボタンをクリックしてください。</p>";
$共通項目 = $共通項目 . "<p>「要修正」としたした場合は、学生が加筆修正して再提出しますので、あらためて内容を確認してください。</p>";
$共通項目 = $共通項目 . "<p>内容を確認して承認する場合は、「承認」ボタンをクリックします。「承認」した場合はそのシートは完成となります。</p>";

$共通項目 = $共通項目 . "<p class='my-4'>　</p>";
$共通項目 = $共通項目 . "<p>メニューに戻る場合は戻るボタンをクリックしてください。</p><p>ブラウザの「戻る」ボタンでは正しく動作しない場合がありますので「戻る」ボタンを使用してください。</p>";


$共通項目2 = "<p>教員・事務局メニューでは、学生が学生が記入したシートを閲覧することができます。</p>";
$共通項目2 = $共通項目2 . "<p class='my-4'>　</p>";
$共通項目2 = $共通項目2 . "<p>メニューに戻る場合は戻るボタンをクリックしてください。</p><p>ブラウザの「戻る」ボタンでは正しく動作しない場合がありますので「戻る」ボタンを使用してください。</p>";







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
         background-color: rgb(35, 165, 5);
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
   </style>


   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

</head>

<body>





   <div class="container-fluid">
      <h1>学修支援作成システム（教員・事務局用マニュアル）</h1>

      <div class="clear w-100">
         <h2 class="my-5">ログイン画面</h2>
      </div>
      <img src="img2/image2001.png" alt="" class="float_l image-width">


      <p>最初にメールアドレス、パスワードでログインしていただきます。</p>
      <p>学生と教員は同じログイン画面ですが、マスターにある教員／学生区分により、メニューが分れます。</p>
      <p>パスワードを忘れた場合は巻末をご参照ください。</p>

      <p class='my-4'>　</p>
      <p>システム管理用アカウントとして　メールアドレス　info@sysad.jp パスワード　Password123が登録されています。</p>


      <div class="clear w-100">
         <h2 class="my-5">教員・事務局用MENU画面</h2>
      </div>
      <img src="img2/image2002.png" alt="" class="float_l image-width">
      <p>教員・事務局用のメニュー画面です</p>
      <p>各ボタンをクリックすると入力画面が表示されます</p>
      <p>終了する場合は、ログアウトボタンをクリックしてください。</p>




      <div class="clear w-100">
         <h2 class="my-5">個人情報画面</h2>
      </div>
      <img src="img2/image2003.png" alt="" class="float_l image-width">
      <p>個人情報を登録・更新します。</p>
      <p>更新する場合は、個人情報登録ボタンをクリックしてください。</p>
      <p>メニューに戻る場合は戻るボタンをクリックしてください。</p>


      <div class="clear w-100">
         <h2 class="my-5">学生情報一括登録</h2>
      </div>
      <img src="img2/image2004.png" alt="" class="float_l image-width">
      <p>新学期に備え、予め学生情報を登録しておきます。</p>
      <p>学籍番号、氏名、メールアドレス、パスワード（仮）、区分をカンマ区切りのCSVで作成し、貼り付けてから、読み込むボタンをクリックします。</p>





      <div class="clear w-100">
         <h2 class="my-5">学生情報一括登録（続き）</h2>
      </div>
      <img src="img2/image2004-2.png" alt="" class="float_l image-width">
      <p>学生の場合は区分を「学生」、教員、事務局の場合は区分を「教員」としてください。</p>
      <p>一度に２０名まで登録できます。</p>




      <div class="clear w-100">
         <h2 class="my-5">学生情報一括登録（続き）</h2>
      </div>
      <img src="img2/image2004-3.png" alt="" class="float_l image-width">
      <p>読み込んだら、一括登録ボタンをクリックします。</p>


      <div class="clear w-100">
         <h2 class="my-5">学生情報一括登録（続き）</h2>
      </div>
      <img src="img2/image2004-4.png" alt="" class="float_l image-width">
      <p></p>




      <div class="clear w-100">
         <h2 class="my-5">実習機関リスト</h2>
      </div>
      <img src="img2/image2005.png" alt="" class="float_l image-width">
      <p>実習機関の登録、変更を行います。既に登録されている実習機関のリストが表示されます。</p>
      <p>リスト表の右側には、「詳細」ボタンと「指導者」ボタンがあります。</p>
      <p>既に登録されている機関の詳細を確認・内容の更新をする場合は、「詳細」ボタンをクリックします。</p>
      <p>施設ごとの実習指導者を登録する場合は、「指導者」ボタンをクリックします。</p>
      <p>新規に実習機関を追加する場合は、「実習施設の新規追加」をクリックします。</p>


      <div class="clear w-100">
         <h2 class="my-5">実習機関情報（詳細）</h2>
      </div>
      <img src="img2/image2006.png" alt="" class="float_l image-width">
      <p>実習機関情報を入力します。</p>
      <p>各項目を入力して「登録」ボタンをクリックしてください。</p>
      <p>※新規登録の場合、配属情報テーブルを初期化し、実習機関を追加します。</p>


      <p>既に登録している法人を削除すると、法人に紐づいた指導者情報と、配属情報をすべて削除します。</p>
      <p>tbl_institution   tbl_assignment tbl_instructor</p>

      <p>メニューに戻る場合は「戻る」ボタンをクリックしてください。</p>





      <div class="clear w-100">
         <h2 class="my-5">実習指導者情報（詳細）</h2>
      </div>
      <img src="img2/image2007.png" alt="" class="float_l image-width">
      <p>実習機関の指導者を最大３名まで登録できます。</p>
      <p>指導者の各項目を入力して「登録」ボタンをクリックしてください。</p>
      <p>メニューに戻る場合は「戻る」ボタンをクリックしてください。</p>


      <div class="clear w-100">
         <h2 class="my-5">学生リスト　</h2>
      </div>
      <img src="img2/image2008.png" alt="" class="float_l image-width">
      
      <p>学生とシートの提出状況を確認する画面です。</p>
      <p>入学年度をコンボボックスで指定することで、学生を絞り込むことができます。</p>
      <p>学生の作成した各シートの提出状態が表示されます。リンクをクリックすることで、各シートを閲覧することができます。</p>
      <p>提出状態は、未作成（非表示）→下書き（学生の下書き状態）→提出済→要修正→承認済</p>
      <p>全て閲覧はできます。提出済についてコメントを書き、要修正か、承認済を決定できます。</p>
      <p>要修正の場合は学生は先生の書いたコメントにそって内容を修正して、提出済にして再び先生の審査を受けます。</p>
      <p>最終的には承認済に進みシートの作成は終了します。</p>



      <div class="clear w-100">
         <h2 class="my-5">プロフィール・シート</h2>
      </div>
      <img src="img2/image2009.png" alt="" class="float_l image-width">
      <p>プロフィールリストです。</p>
      <p>１年次の例です。</p>


      <?php echo $共通項目;?>




      <div class="clear w-100">
         <h2 class="my-5">学修行動計画（ゴール・シート）(１Q)</h2>
      </div>
      <img src="img2/image2010.png" alt="" class="float_l image-width">
      <p>学修行動計画（ゴール・シート）（1Q）の内容を閲覧できます。</p>


     <?php echo $共通項目;?>



      <div class="clear w-100">
         <h2 class="my-5">学修行動計画（ゴール・シート）(４Q)</h2>
      </div>
      <img src="img2/image2011.png" alt="" class="float_l image-width">
      <p>学修行動計画（ゴール・シート）（4Q）の内容を閲覧できます。</p>
  
     <?php echo $共通項目;?>


      <div class="clear w-100">
         <h2 class="my-5">学修行動計画（リフレクション・シート）(４Q)</h2>
      </div>
      <img src="img2/image2012.png" alt="" class="float_l image-width">
      <p>学修行動計画（リフレクション・シート）(４Q)の内容を閲覧できます。</p>

     <?php echo $共通項目;?>


      <div class="clear w-100">
         <h2 class="my-5">学修行動計画・リフレクション・シート</h2>
      </div>
      <img src="img2/image2012-2.png" alt="" class="float_l image-width">
      <p>学修行動計画(リフレクション・シート)の内容を閲覧できます。</p>
      <p>学修行動計画(リフレクション・シート)には次の種類があります。</p>
      <p>学生は、次の学修行動計画の一部か、あるいは全てを作成します。</p>
         <p>　１．ソーシャルワーク実習Ⅰ・リフレクション・シート</p>
         <p>　２．ソーシャルワーク実習Ⅱ・リフレクション・シート</p>
         <p>　３．インターンシップⅠ・リフレクション・シート)</p>
         <p>　４．精神実習Ⅰ（単独）/インターンシップⅡ・リフレクション・シート</p>
         <p>　５．アドバンス・クラス/精神実習Ⅱ（単独）・リフレクション・シート</p>



     <?php echo $共通項目;?>




      <div class="clear w-100">
         <h2 class="my-5">実習計画表</h2>
      </div>
      <img src="img2/image2013.png" alt="" class="float_l image-width">
      <p>実習計画表の内容を閲覧できます。</p>

      <p>実習計画表には次の種類があります。</p>
      <p>学生は、次の実習計画表の一部か、あるいは全てを作成します。</p>
         <p>　１．ソーシャルワーク実習Ⅰ</p>
         <p>　２．ソーシャルワーク実習Ⅱ</p>
         <p>　３．精神保健福祉援助実習Ⅰ</p>
         <p>　４．精神保健福祉援助実習Ⅱ</p>
         <p>　５．アドバンス・クラス実習</p>


     <?php echo $共通項目;?>

      <div class="clear w-100">
         <h2 class="my-5">自己評価表 （ソーシャルワーク実習Ⅱの例）</h2>
      </div>
      <img src="img2/image2013-2.png" alt="" class="float_l image-width">
      <p>自己評価表の内容を閲覧できます。</p>
      <p>自己評価表には次の種類があります。</p>
      <p>学生は、次の自己評価表の一部か、あるいは全てを作成します。</p>
         <p>　１．ソーシャルワーク実習Ⅰ</p>
         <p>　２．ソーシャルワーク実習Ⅱ</p>
         <p>　３．精神保健福祉援助実習Ⅰ</p>
         <p>　４．精神保健福祉援助実習Ⅱ</p>
         <p>　５．アドバンス・クラス実習</p>

     <?php echo $共通項目;?>

      <div class="clear w-100">
         <h2 class="my-5">個人情報</h2>
      </div>
      <img src="img2/image2015.png" alt="" class="float_l image-width">
      <p>学生の個人情報を閲覧できます</p>




      <div class="clear w-100">
         <h2 class="my-5">施設概要書（リスト）</h2>
      </div>
      <img src="img2/image2016.png" alt="" class="float_l image-width">
      <p>該当する学生の実習先のリストを表示します。</p>
      <p>複数の実習先に登録されている場合もあります。</p>

      <p>詳細ボタンをクリックすると概要書を表示します。</p>

      <div class="clear w-100">
         <h2 class="my-5">施設概要書（詳細）</h2>
      </div>
      <img src="img2/image2017.png" alt="" class="float_l image-width">
      <p>該当する学生の実習先の施設概要書を表示します。</p>





      <div class="clear w-100">
         <h2 class="my-5">実習生紹介書</h2>
      </div>
      <img src="img2/image2018.png" alt="" class="float_l image-width">
      <p>学生が作成した実習生紹介書を表示します。</p>
      <p>教員はコメント欄にコメントを記入することができます。</p>







      <div class="clear w-100">
         <h2 class="my-5">実習配属情報（配属情報リスト）</h2>
      </div>
      <img src="img2/image2019.png" alt="" class="float_l image-width">
      <p>配属情報先リストが表示されます</p>
      <p>画面右上で実習種別を選択して再表示ボタンで絞込表示します。</p>
      <p>実習種別は、以下のものがあります。</p>
      <p>１．ソーシャルワーク実習Ⅰ</p>
      <p>２．ソーシャルワーク実習Ⅱ</p>
      <p>３．精神保健福祉援助実習Ⅰ</p>
      <p>４．精神保健福祉援助実習Ⅱ</p>
      <p>５．アドバンス・クラス実習</p>








      <div class="clear w-100">
         <h2 class="my-5">実習配属情報（実習機関リスト）</h2>
      </div>
      <img src="img2/image2020.png" alt="" class="float_l image-width">
      <p>配属情報の入力画面です。</p>




     <?php echo $共通項目;?>






      <div class="clear w-100">
         <h2 class="my-5">書類出力PDF</h2>
      </div>
      <img src="img2/image2021.png" alt="" class="float_l image-width">
      <p>出力先施設リスト</p>
      <p>配属情報が登録された施設の書類をPDFで出力します</p>




      <div class="clear w-100">
         <h2 class="my-5">PDF出力例</h2>
      </div>
      <img src="img2/image2022.png" alt="" class="float_l image-width">


      <div class="clear w-100">
         <h2 class="my-5">マスター管理</h2>
      </div>
      <img src="img2/image2023.png" alt="" class="float_l image-width">
      <p>システムで使用しているデーターベースを直接保守する機能です</p>
      <p>対象となるテーブル一覧を表示します。</p>
      <p>詳細ボタンでテーブルを選択してください。次にすすみます</p>

      <div class="clear w-100">
         <h2 class="my-5">マスター管理（テーブル表示画面）</h2>
      </div>
      <img src="img2/image2024.png" alt="" class="float_l image-width">
      <p>プロティール・テーブルの例です</p>
      <p>画面上にはキーワード欄があります。キーワードを入力して絞込ボタンでフィルタをかけて絞込表示します。</p>
      <p>二行目はデータベースでつかわれているカラム名です。</p>

      <div class="clear w-100">
         <h2 class="my-5">マスター管理（テーブル内容修正画面）</h2>
      </div>
      <img src="img2/image2025.png" alt="" class="float_l image-width">
      <p>プロティール・テーブルの例です</p>
      <p>画面左はカラム名、右側がデータとなっています。</p>
      <p>データを修正して変更ボタンをクリックすると変更されます。</p>

      <div class="clear w-100">
         <h2 class="my-5">年度更新</h2>
      </div>
      <img src="img2/image2026.png" alt="" class="float_l image-width">
      <p>年度更新画面です</p>
      <p>事業年度は今稼働している、あるいは今後稼働させる事業年度を指定します。</p>
      <p>事業年度は、画面の上のヘッダー部分に表示されている年度となります。</p>
      <p>管理用年度は、年度を指定しての配属情報テーブルを参照する場合に指定します。</p>      
      <p>管理用年度は、該当する管理用年度の配属情報が存在しない場合は新規に作成します。</p>

      <div class="clear w-100">
         <h2 class="my-5">管理年度を指定して実習配属情報を選択した場合</h2>
      </div>
      <img src="img2/image2027.png" alt="" class="float_l image-width">
      <p>管理年度に該当する実習配属情報を参照できます。</p>




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