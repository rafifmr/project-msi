<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Alumnni STSN</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/style.css">

    <!-- Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">

</head>

<body>
    <!-- jQuery online menggunakan CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- jQuery lokal -->
    <script src="assets/jquery/jquery.min.js"></script>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <!-- <script src="assets/custom.js"></script> -->

    <!-- Chart JS -->
    <script type="text/javascript" src="assets/chartjs/Chart.js"></script>

    <div class="container">

        <!-- Bagian Header -->
        <div class="row">
            <div class="col-md-12 header" id="site-header">
                <!-- isi header -->
                <header>
                    <h1 class="title-site">Sistem Informasi Alumni Sekolah Tinggi Sandi Negara</h1>
                    <p style="text-align:center">--- Provide Information ---</p>
                </header>

                <nav class="menus">
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#kinerja">Kepuasan Kinerja</a></li>
                        <li><a href="#kompetensi">Kepuasan Kompetensi</a></li>
                        <li><a href="#attitude">Kepuasan Attitude</a></li>
                        <li><form method="post" action="logout.php"><button>Log Out</button></form></li>
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

        // Get Data
        $data = json_decode(base64_decode($lsJSONRPCClient->export_responses($sessionKey, $survey_id, 'json')), true);
        $nilai = $data['responses'];
        // Konek Data
        $user_name = "root";
        $password  = "";
        $database  = "alumni";
        $host_name = "localhost";

        $link = mysqli_connect($host_name, $user_name, $password, $database) or die(mysqli_error());
        //Akhir koneksi
        ?>

        <!-- Bagian Home -->
        <div class="row" id="home">
            <div class="col-md-12 articles" id="site-content">
                <!-- isi content -->
                <article class="posts">
                    <h2 class="title-post">Home</h2>
                    <br>
                
                    <p align="center"><iframe width="900" height="400"
                            src="https://www.youtube.com/embed/MweEv2hq5us" 
                            frameborder="0" allow="accelerometer; 
                            autoplay; encrypted-media; gyroscope; 
                            picture-in-picture" allowfullscreen>
                    </iframe></p>
                    
                    <br>

                    <div class="content">
                        <?php

                        // $response=$lsJSONRPCClient->list_surveys($sessionKey,null);

                        //~ release the session key
                        $lsJSONRPCClient->release_session_key($sessionKey);
                        ?>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Unit Kerja</th>
                                </tr>
                            </thead>

                            <?php
                            $j = 1;
                            for ($i = 0; $i < sizeof($nilai) - 1; $i++) { ?>
                                <tbody>
                                    <tr>
                                        <?php
                                        if ($nilai[$i][(string) $i + 5]["II5"] != null &&
                                            $nilai[$i][(string) $i + 5]["II5"] != "-") { ?>
                                            <th>
                                                <?php
                                                    echo $j;
                                                    $j++;
                                                ?>
                                            </th>
                                            <th>
                                                <?php echo $nilai[$i][(string) $i + 5]["II5"]; ?>
                                            </th>
                                        <?php
                                        } else {
                                        }
                                        ?>
                                    </tr>
                                </tbody>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </article>
            </div>

        </div>
        <!-- End Bagian Home -->

        <!-- Bagian Kinerja -->
        <div class="row" id="kinerja">
            <div class="col-md-12 articles" id="site-content">
                <!-- isi content -->
                <article class="posts">
                    <h2 class="title-post">Kepuasan Kinerja</h2>
                    <br>
                    <div class="meta-post">
                        <p style="text-align: center"><span><em class="glyphicon glyphicon-user">Tingkat Kepuasan Kinerja</em></span></p>
                    </div>

                    <?php

                    // Deklarasi Nilai
                    $kinerja_5 = 0;
                    $kinerja_4 = 0;
                    $kinerja_3 = 0;
                    $kinerja_2 = 0;
                    $kinerja_1 = 0;
                    $id_kinerja = 1;

                    for ($i = 0; $i < sizeof($nilai) - 1; $i++) {
                        if ($nilai[$i][(string) $i + 5]["E1"] == "A5") {
                            $kinerja_5++;
                        }
                        if ($nilai[$i][(string) $i + 5]["E1"] == "A4") {
                            $kinerja_4++;
                        }
                        if ($nilai[$i][(string) $i + 5]["E1"] == "A3") {
                            $kinerja_3++;
                        }
                        if ($nilai[$i][(string) $i + 5]["E1"] == "A2") {
                            $kinerja_2++;
                        }
                        if ($nilai[$i][(string) $i + 5]["E1"] == "A1") {
                            $kinerja_1++;
                        }
                    }

                    $cek_kinerja = mysqli_query($link, "SELECT * FROM `nilai_kepuasan` WHERE `id` = 1");

                    $arrKinerja = mysqli_fetch_array($cek_kinerja);

                    if ($arrKinerja['id'] != $id_kinerja) {
                        mysqli_query($link, "INSERT into `nilai_kepuasan`(`id`,`a1`,`a2`,`a3`,`a4`,`a5`) VALUES (1, $kinerja_1, $kinerja_2, $kinerja_3, $kinerja_4, $kinerja_5)");
                        // echo "Tambah Data";
                    } else {
                        mysqli_query($link, "UPDATE `nilai_kepuasan` SET `id`=1,`a1`=$kinerja_1,`a2`=$kinerja_2,`a3`=$kinerja_3,`a4`=$kinerja_4,`a5`=$kinerja_5 WHERE `id`=1");
                        // echo "Data Update";
                    }

                    ?>

            </div>
            <div style="width :800px; margin: 0px auto;">
            <canvas id="myChartA"></canvas>
            <script>
                var ctx = document.getElementById('myChartA');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Sangat Tidak Puas', 'Tidak Puas', 'Cukup Puas', 'Puas', 'Sangat Puas'],
                        datasets: [{
                            label: "Tingkat Kepuasan",
                            data: [
                                <?php echo $kinerja_1?>,
                                <?php echo $kinerja_2?>,
                                <?php echo $kinerja_3?>,
                                <?php echo $kinerja_4?>,
                                <?php echo $kinerja_5?>
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        legend : {
                            display : false
                        }
                    }
                });
            </script>
            </div>
        </div>

        <!-- End Bagian Kinerja -->


        <!-- Bagian Kompetensi -->
        <div class="row" id="kompetensi">
            <div class="col-md-12 articles" id="site-content">
                <!-- isi content -->
                <article class="posts">
                    <h2 class="title-post">Kepuasan Kompetensi</h2>
                    <br>
                    <div class="meta-post">
                        <p style="text-align: center"><span><em class="glyphicon glyphicon-user">Tingkat Kepuasan Kompetensi</em></span></p>
                    </div>

                    <?php

                    // Deklarasi Nilai
                    $kompetensi_5 = 0;
                    $kompetensi_4 = 0;
                    $kompetensi_3 = 0;
                    $kompetensi_2 = 0;
                    $kompetensi_1 = 0;
                    $id_kompetensi = 2;

                    for ($i = 0; $i < sizeof($nilai) - 1; $i++) {
                        if ($nilai[$i][(string) $i + 5]["E2"] == "A5") {
                            $kompetensi_5++;
                        }
                        if ($nilai[$i][(string) $i + 5]["E2"] == "A4") {
                            $kompetensi_4++;
                        }
                        if ($nilai[$i][(string) $i + 5]["E2"] == "A3") {
                            $kompetensi_3++;
                        }
                        if ($nilai[$i][(string) $i + 5]["E2"] == "A2") {
                            $kompetensi_2++;
                        }
                        if ($nilai[$i][(string) $i + 5]["E2"] == "A1") {
                            $kompetensi_1++;
                        }
                    }

                    $cek_kompetensi = mysqli_query($link, "SELECT * FROM `nilai_kepuasan` WHERE `id` = 2");

                    $arrKompetensi = mysqli_fetch_array($cek_kompetensi);

                    if ($arrKompetensi['id'] != $id_kompetensi) {
                        mysqli_query($link, "INSERT into `nilai_kepuasan`(`id`,`a1`,`a2`,`a3`,`a4`,`a5`) VALUES (2, $kompetensi_1, $kompetensi_2, $kompetensi_3, $kompetensi_4, $kompetensi_5)");
                        // echo "Tambah Data";
                    } else {
                        mysqli_query($link, "UPDATE `nilai_kepuasan` SET `id`=2,`a1`=$kompetensi_1,`a2`=$kompetensi_2,`a3`=$kompetensi_3,`a4`=$kompetensi_4,`a5`=$kompetensi_5 WHERE `id`=2");
                        // echo "Data Update";
                    }

                    ?>
            </div>
            <div style="width :800px; margin: 0px auto;">
            <canvas id="myChartB"></canvas>
            <script>
                var ctx = document.getElementById('myChartB');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Sangat Tidak Puas', 'Tidak Puas', 'Cukup Puas', 'Puas', 'Sangat Puas'],
                        datasets: [{
                            label: "Tingkat Kepuasan",
                            data: [
                                <?php echo $kompetensi_1?>,
                                <?php echo $kompetensi_2?>,
                                <?php echo $kompetensi_3?>,
                                <?php echo $kompetensi_4?>,
                                <?php echo $kompetensi_5?>
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        legend : {
                            display : false
                        }
                    }
                });
            </script>
            </div>
        </div>
        <!-- End Bagian Kompetensi -->


        <!-- Bagian Attitude -->
        <div class="row" id="attitude">
            <div class="col-md-12 articles" id="site-content">
                <!-- isi content -->
                <article class="posts">
                    <h2 class="title-post">Kepuasan Attitude</h2>
                    <br>
                    <div class="meta-post">
                        <p style="text-align: center"><span><em class="glyphicon glyphicon-user">Tingkat Kepuasan Attitude</em></span></p>
                    </div>

                    <?php

                    // Deklarasi Nilai
                    $attitude_5 = 0;
                    $attitude_4 = 0;
                    $attitude_3 = 0;
                    $attitude_2 = 0;
                    $attitude_1 = 0;
                    $id_attitude = 3;

                    for ($i = 0; $i < sizeof($nilai) - 1; $i++) {
                        if ($nilai[$i][(string) $i + 5]["E3"] == "A5") {
                            $attitude_5++;
                        }
                        if ($nilai[$i][(string) $i + 5]["E3"] == "A4") {
                            $attitude_4++;
                        }
                        if ($nilai[$i][(string) $i + 5]["E3"] == "A3") {
                            $attitude_3++;
                        }
                        if ($nilai[$i][(string) $i + 5]["E3"] == "A2") {
                            $attitude_2++;
                        }
                        if ($nilai[$i][(string) $i + 5]["E3"] == "A1") {
                            $attitude_1++;
                        }
                    }

                    $cek_attitude = mysqli_query($link, "SELECT * FROM `nilai_kepuasan` WHERE `id` = 3");

                    $arrAttitude = mysqli_fetch_array($cek_attitude);

                    if ($arrAttitude['id'] != $id_attitude) {
                        mysqli_query($link, "INSERT into `nilai_kepuasan`(`id`,`a1`,`a2`,`a3`,`a4`,`a5`) VALUES (3, $attitude_1, $attitude_2, $attitude_3, $attitude_4, $attitude_5)");
                        // echo "Tambah Data";
                    } else {
                        mysqli_query($link, "UPDATE `nilai_kepuasan` SET `id`=3,`a1`=$attitude_1,`a2`=$attitude_2,`a3`=$attitude_3,`a4`=$attitude_4,`a5`=$attitude_5 WHERE `id`=3");
                        // echo "Data Update";
                    }

                    ?>
            </div>
            <div style="width :800px; margin: 0px auto;">
            <canvas id="myChartC"></canvas>
            <script>
                var ctx = document.getElementById('myChartC');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Sangat Tidak Puas', 'Tidak Puas', 'Cukup Puas', 'Puas', 'Sangat Puas'],
                        datasets: [{
                            label: "Tingkat Kepuasan",
                            data: [
                                <?php echo $attitude_1?>,
                                <?php echo $attitude_2?>,
                                <?php echo $attitude_3?>,
                                <?php echo $attitude_4?>,
                                <?php echo $attitude_5?>
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        legend : {
                            display : false
                        }
                    }
                });
            </script>
            </div>
        </div>
        <!-- End Bagian Attitude -->


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