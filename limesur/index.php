<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/style.css">
    
    <!-- Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">


</head>

<body>
    <!--happy code-->
    <!-- jQuery online menggunakan CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- jQuery lokal -->
    <script src="assets/jquery/jquery.min.js"></script>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/custom.js"></script>

    <div class="container">

        <!-- Bagian Header -->
        <div class="row">
            <div class="col-md-12 header" id="site-header">
                <!-- isi header -->
                <header>
                    <h1 class="title-site">Sistem Informasi</h1>
                    <p class="description">Sistem Informasi Apa Ya ?</p>
                </header>

                <nav class="menus">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Portfolio</a></li>
                    </ul>
                </nav>

            </div>
        </div>
        <!-- End Bagian Header -->

        <?php
        require_once './jsonrpcphp/jsonRPCClient.php';
        $rpcUrl = "https://survey.stsn-nci.ac.id/index.php/admin/remotecontrol";
        $rpcUser = "kelompok3";
        $rpcPassword = "123456";
        $survey_id = 798923;

        $lsJSONRPCClient = new \org\jsonrpcphp\jsonRPCClient($rpcUrl);
        $sessionKey = $lsJSONRPCClient->get_session_key($rpcUser, $rpcPassword);
        ?>


        <!-- Bagian Wrapper 2 kolom -->
        <div class="row">
            <div class="col-md-8 articles" id="site-content">
                <!-- isi content -->
                <article class="posts">
                    <h2 class="title-post">Lorem ipsum dolor sit amet</h2>
                    <div class="meta-post">
                        <span><em class="glyphicon glyphicon-user"></em> Onphpid</span>
                        <span><em class="glyphicon glyphicon-time"></em> 13 Juni 2015</span>
                    </div>
                    <!-- <div class="content"> -->
                    //////////////////////////////////////////////
                    <?php
                    //   ~ If an error happen
                    if (is_array($sessionKey)) {
                        header("Content-type: application/json");
                        echo json_encode($sessionKey);
                        die();
                    }
                    $response = $lsJSONRPCClient->list_surveys($sessionKey);

                    //~ For big array : base64 encoded
                    if (is_array($response)) {
                        echo json_encode($response);
                        echo "\n\n";
                        // echo json_encode($export);
                        // echo "\n\n";
                        // echo json_encode($answer);
                    } else {
                        header("Content-type: application/json");
                        print_r(base64_decode($response), null);
                    }
                    //~ release the session key
                    $lsJSONRPCClient->release_session_key($sessionKey);
                    ?>
                    <!-- </div> -->
                </article>
            </div>

            <div class="col-md-4 sidebar" id="site-sidebar">
                <!-- isi sidebar -->
                <aside class="widgets">
                    <h3 class="widget-title">Latest Posts</h3>
                    <ul>
                        <li><a href="#">Lorem Ipsum</a></li>
                        <li><a href="#">Lorem Ipsum</a></li>
                        <li><a href="#">Lorem Ipsum</a></li>
                        <li><a href="#">Lorem Ipsum</a></li>
                        <li><a href="#">Lorem Ipsum</a></li>
                    </ul>
                </aside>
            </div>
        </div>
        <!-- End Bagian wrapper -->

        <!-- Bagian footer -->
        <div class="row">
            <div class="col-md-12 footer" id="site-footer">
                <!-- isi footer -->
            </div>
        </div>
        <!-- End Bagian footer -->

    </div>
</body>

</html>