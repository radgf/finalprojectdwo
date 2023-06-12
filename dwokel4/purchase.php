<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adventure Works - Purchase</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Pembelian</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Yearly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Pembelian</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                include "connect.php";
                                                $query = mysqli_query($conn, 'SELECT count(distinct PurchaseOrderId) as count FROM fact_purchase');
                                                    $row = mysqli_fetch_array($query);

                                                    echo $row['count']?></div>

                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Penjualan Tahun ini </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                                    $query = mysqli_query($conn,"SELECT COUNT(DISTINCT(f.PurchaseOrderId)) PurchaseOrder FROM fact_purchase f JOIN time t ON f.timeID=t.time_id WHERE t.tahun=2004");
                                                        while($row=mysqli_fetch_array($query)){
                                                            echo number_format($row['PurchaseOrder'],0,".",",");
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

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Jenis Produk Terjual</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                include "connect.php";
                                                $query = mysqli_query($conn, 'SELECT count(distinct ProductID) as product FROM fact_purchase');
                                                    $row = mysqli_fetch_array($query);

                                                    echo $row['product']?></div>

                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Penjualan Bulan Ini</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                                    $query = mysqli_query($conn,"SELECT COUNT(DISTINCT(f.PurchaseOrderId)) PurchaseOrder FROM fact_purchase f JOIN time t ON f.timeID=t.time_id WHERE t.tahun=2004 AND bulan=9");
                                                        while($row=mysqli_fetch_array($query)){
                                                            echo number_format($row['PurchaseOrder'],0,".",",");
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
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
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Pembelian Per Bulan</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- doughnut Chart -->
<div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header-->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Top 10 Employee Dengan Pelayanan Order Terbanyak</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <?php
                                    $produk = mysqli_query($conn, "SELECT DISTINCT(employeeid), Sum(orderqty) AS jumlah FROM fact_purchase GROUP BY employeeid ORDER BY jumlah DESC limit 10");
                                    while ($data = mysqli_fetch_array($produk)) {
                                        $sql = mysqli_query($conn, "SELECT c.employeeid AS employeeid ,Sum(fs.orderqty) AS jumlah FROM employee c JOIN fact_purchase fs ON c.employeeid=fs.employeeid WHERE fs.employeeid='" . $data['employeeid'] . "'");
                                        $data = $sql->fetch_array();
                                        $employeeid [] = $data['employeeid'];
                                    }
                                    ?>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #d94f00;"></i> <?php echo $employeeid[0]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #d9c300;"></i> <?php echo $employeeid[1]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #94d900;"></i> <?php echo $employeeid[2]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #00d953;"></i> <?php echo $employeeid[3]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #00d9c7;"></i> <?php echo $employeeid[4]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #0028d9;"></i> <?php echo $employeeid[5]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #8900d9;"></i> <?php echo $employeeid[6]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #d90033;"></i> <?php echo $employeeid[7]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #969696;"></i> <?php echo $employeeid[8]; ?>
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: #ff26ac;"></i> <?php echo $employeeid[9]; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- Content Table -->
                    <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                Data Pembelian
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>    
                                    <tr>
                                        <th>Purchase Order ID</th>
                                            <th>Ship Method ID</th>
                                            <th>Product ID</th>
                                            <th>Vendor ID </th>
                                            <th>Time ID</th>
                                            <th>Employee ID</th>
                                            <th>Order Qty</th>
                                            <th>Received Qty</th>
                                            <th>Rejected Qty</th>
                                            <th>Stocked Qty</th>
                                            <th>Line Total</th>
                                            <th>Status</th>
                                            <th>Sub Total</th>
                                            <th>Tax Amt</th>
                                            <th>Freight</th>
                                        </tr>
                                    </thead>  
                                    <tfoot>    
                                    <tr>
                                        <th>Purchase Order ID</th>
                                            <th>Ship Method ID</th>
                                            <th>Product ID</th>
                                            <th>Vendor ID </th>
                                            <th>Time ID</th>
                                            <th>Employee ID</th>
                                            <th>Order Qty</th>
                                            <th>Received Qty</th>
                                            <th>Rejected Qty</th>
                                            <th>Stocked Qty</th>
                                            <th>Line Total</th>
                                            <th>Status</th>
                                            <th>Sub Total</th>
                                            <th>Tax Amt</th>
                                            <th>Freight</th>
                                        </tr> 
                                        </tfoot>
                                        <tbody>
                                        <?php
                                            include "connect.php";

                                            $query = mysqli_query($conn, 'SELECT * FROM fact_purchase where PurchaseOrderID < 500');
                                            while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $data['PurchaseOrderID'] ?></td>
                                            <td><?php echo $data['ShipMethodID'] ?></td>
                                            <td><?php echo $data['ProductID'] ?></td>
                                            <td><?php echo $data['VendorID'] ?></td>
                                            <td><?php echo $data['TimeID'] ?></td>
                                            <td><?php echo $data['EmployeeID'] ?></td>
                                            <td><?php echo $data['OrderQty'] ?></td>
                                            <td><?php echo $data['ReceivedQty'] ?></td>
                                            <td><?php echo $data['RejectedQty'] ?></td>
                                            <td><?php echo $data['StockedQty'] ?></td>
                                            <td><?php echo $data['LineTotal'] ?></td>
                                            <td><?php echo $data['Status'] ?></td>
                                            <td><?php echo $data['SubTotal'] ?></td>
                                            <td><?php echo $data['TaxAmt'] ?></td>
                                            <td><?php echo $data['Freight'] ?></td>
                                            
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
    $produk = mysqli_query($conn, "SELECT DISTINCT(employeeid), Sum(orderqty) AS jumlah FROM fact_purchase GROUP BY employeeid ORDER BY jumlah DESC limit 10");
    while ($data = mysqli_fetch_array($produk)) {
        $sql = mysqli_query($conn, "SELECT c.employeeid AS employeeid ,Sum(fs.orderqty) AS jumlah FROM employee c JOIN fact_purchase fs ON c.employeeid=fs.employeeid WHERE fs.employeeid='" . $data['employeeid'] . "'");
        $data = $sql->fetch_array();
        $employeeid [] = $data['employeeid'];
        $jumlah[] = $data['jumlah'];
    }

    // Pemanggilan Data untuk Line Chart
    $i = 1;
    $query_bulan = mysqli_query($conn, "SELECT CONCAT(MONTHNAME(t.tanggallengkap), ' ', YEAR(t.tanggallengkap)) bulan FROM fact_purchase f JOIN time t ON f.TimeID=t.time_id GROUP BY t.bulan ORDER BY t.tanggallengkap");
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
    $query_purchase = mysqli_query($conn, "SELECT COUNT(f.purchaseorderid) as purchase FROM fact_purchase f JOIN time t ON f.TimeID=t.time_id GROUP BY t.bulan ORDER BY t.tanggallengkap");
    $jumlah_purchase = mysqli_num_rows($query_purchase);
    $chart_purchase = "";
    while ($row1 = mysqli_fetch_array($query_purchase)) {
        if ($a < $jumlah_purchase) {
            $chart_purchase .= $row1['purchase'];
            $chart_purchase .= ',';
            $a++;
        } else {
            $chart_purchase .= $row1['purchase'];
        }
    }

    ?>

    <!-- Codingan ferdy mboh dibawah-->
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

    // line Chart Script
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php echo $chart_bulan; ?>],
                datasets: [{
                    label: "Jumlah Pembelian",
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
                    data: [<?php echo $chart_purchase; ?>],
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

                // doughnut Chart Script
                var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: <?php echo json_encode($employeeid); ?>,
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
    </script>   
</html>