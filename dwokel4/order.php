<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adventure Works - Order</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />
</head>

<body>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <?php
            include "navbar.php";
            include "logout.php";
            include "scroll-top-button.php";
            ?>


            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Order</h1>
                </div>

                <!-- Content Row -->
                <div class="row">

                    <!-- Total Penjualan -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Wilayah Penjualan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                            include "connect.php";
                                            $query = mysqli_query($conn, "SELECT COUNT(TerritoryID) as SubTotal from tabel_dimensi_lokasi");
                                            while ($row = mysqli_fetch_array($query)) {
                                                echo number_format($row['SubTotal'], 0, ".", ",");
                                            }
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Harga Satuan -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Satuan Pemesanan Penjualan Customer</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                            $query = mysqli_query($conn, "SELECT SUM(SubTotal) as total_pemesanan_penjualan from tabel_fakta_penjualan2 where SubTotal IN (SELECT SubTotal from tabel_fakta_penjualan2 group by TerritoryID);");
                                            while ($row = mysqli_fetch_array($query)) {
                                                echo '$' . number_format($row['total_pemesanan_penjualan'], 0, ".", ",");
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Produk Yang Terjual -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Banyak Pemesanan Pada Setiap Wilayah
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    <?php
                                                    $query = mysqli_query($conn, "SELECT COUNT(TerritoryID) as total_pembeli from tabel_fakta_penjualan2");
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        echo number_format($row['total_pembeli'], 0, ".", ",");
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Content Row -->

                <div class="row">

                    <!-- Area Chart -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <!-- Card Header -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Jumlah Penjualan Per Bulan</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myAreaChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pie Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header-->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Top 10 Produk Paling Banyak Terjual</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <?php
                                    $produk = mysqli_query($conn, "SELECT DISTINCT(CustomerID), Sum(SubTotal) AS total FROM tabel_fakta_penjualan2 GROUP BY CustomerID ORDER BY total DESC limit 10");
                                    while ($data = mysqli_fetch_array($produk)) {
                                        $sql = mysqli_query($conn, "SELECT s.Name, t.bulan as bulan, sum(fp.SubTotal) as pendapatan 
                                        FROM tabel_dimensi_lokasi s, tabel_fakta_penjualan2 fp, tabel_dimensi_waktu t 
                                        WHERE (s.TerritoryID = fp.TerritoryID) AND (t.time_id = fp.time_id) 
                                        GROUP BY Name, bulan'" . $data['Name'] . "'");
                                        $data = $sql->fetch_array();
                                        $name [] = $data['Name'];
                                    }
                                    ?>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #d94f00;"></i> <?php echo $name[0]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #d9c300;"></i> <?php echo $name[1]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #94d900;"></i> <?php echo $name[2]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #00d953;"></i> <?php echo $name[3]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #00d9c7;"></i> <?php echo $name[4]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #0028d9;"></i> <?php echo $name[5]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #8900d9;"></i> <?php echo $name[6]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #d90033;"></i> <?php echo $name[7]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #969696;"></i> <?php echo $name[8]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #ff26ac;"></i> <?php echo $name[9]; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Data Penjualan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Customer ID</th>
                                        <th>Territory ID</th>
                                        <th>Customer Type</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "connect.php";

                                    $query = mysqli_query($conn, 'SELECT * FROM tabel_dimensi_customer where CustomerID ORDER BY CustomerID ASC limit 500');
                                    while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $data['CustomerID'] ?></td>
                                            <td><?php echo $data['TerritoryID'] ?></td>
                                            <td><?php echo $data['CustomerType'] ?></td>
                                            <td><?php echo $data['Name'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php include "footer.php" ?>

        </div>
        <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->



        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/datatables-demo.js"></script>


    </body>

    <?php
    // Connect ke Database
    include 'connect.php';

    // Pemanggilan Data untuk Donut Chart
    $produk = mysqli_query($conn, "SELECT DISTINCT(CustomerID), Sum(SubTotal) AS total FROM tabel_fakta_penjualan2 GROUP BY CustomerID ORDER BY total DESC limit 10");
    while ($data = mysqli_fetch_array($produk)) {
        $sql = mysqli_query($conn, "SELECT p.Name AS name ,Sum(fs.SubTotal) AS total FROM tabel_dimensi_customer p JOIN tabel_fakta_penjualan2 fs ON p.CustomerID=fs.CustomerID WHERE fs.CustomerID='" . $data['CustomerID'] . "'");
        $data = $sql->fetch_array();
        $name [] = $data['Name'];
        $jumlah[] = $data['total'];
    }

    // Pemanggilan Data untuk Line Chart
    $i = 1;
    $query_bulan = mysqli_query($conn, "SELECT CONCAT(MONTHNAME(t.tanggallengkap), ' ', YEAR(t.tanggallengkap)) bulan FROM tabel_fakta_pendapata2 f JOIN time t ON f.timeid=t.time_id GROUP BY t.bulan ORDER BY t.tanggallengkap");
    $jumlah_bulan = mysqli_num_rows($query_bulan);
    $chart_bulan = "";
    while ($row = mysqli_fetch_array($query_bulan)) {
        if ($i < $jumlah_bulan) {
            $chart_bulan .= '"';
            $chart_bulan .= $row['bulan'];
            $chart_bulan .= '",';
            $i++;
        } else {
            $chart_bulan .= '"';
            $chart_bulan .= $row['bulan'];
            $chart_bulan .= '"';
        }
    }
    $a = 1;
    $query_order = mysqli_query($conn, "SELECT COUNT(f.CustomerID) as tabel_dimensi_customer FROM tabel_fakta_penjualan2 f JOIN time t ON f.timeid=t.time_id GROUP BY t.bulan ORDER BY t.tanggallengkap");
    $jumlah_order = mysqli_num_rows($query_order);
    $chart_order = "";
    while ($row1 = mysqli_fetch_array($query_order)) {
        if ($a < $jumlah_order) {
            $chart_order .= $row1['tabel_dimensi_customer'];
            $chart_order .= ',';
            $a++;
        } else {
            $chart_order .= $row1['tabel_dimensi_customer'];
        }
    }

    ?>

    <script>
        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php echo $chart_bulan; ?>],
                datasets: [{
                    label: "Jumlah Customer",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [<?php echo $chart_order; ?>],
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ':' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });

        // Pie Chart Script
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: <?php echo json_encode($name); ?>,
                datasets: [{
                    data: <?php echo json_encode($jumlah); ?>,
                    backgroundColor: ["#d94f00", "#d9c300", "#94d900", "#00d953", "#00d9c7 ", "#0028d9 ", "#8900d9", "#d90033", "#969696 ", "#ff26ac"],
                    hoverBackgroundColor: ["#fa8948", "#f7e439", "#bef743", "#4af78c", "#52faec", "#4e6efc", "#bd4dff", "#ff4773","black","#ff1c4d"],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }, ],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false,
                },
                cutoutPercentage: 80,
            },
        });
    </script>

</html>
