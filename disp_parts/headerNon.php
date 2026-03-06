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

    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">


   

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
                            echo "<td class='text-center pt-1' width='33%'><button type='submit' class='btn2 btn-secondary'>戻る</button></td>";
                        }
                        ?>



                        <td class='text-end' width="33%">
                            <?php
                            if (isset($_SESSION['STUDENT_NUMBER'])) {
                                                        echo "<span class='fw600'>" . $_SESSION['KUBUN'] . " " . $_SESSION['STUDENT_NUMBER'] . " " . $_SESSION['NAME'] . "</span>&emsp;&emsp;";

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