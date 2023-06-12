<?php
include "connect.php";

//QUERY CHART PERTAMA

//query untuk tahu SUM(LineTotal) semuanya
$tot = mysqli_query($conn, "SELECT sum(SubTotal) as total from tabel_fakta_penjualan2");
$tot_amount = mysqli_fetch_row($tot);

//echo $tot_amount[0];

//query untuk ambil penjualan berdasarkan kategori
//ditambahkan label variabel DATA. (teknik gak jelas :D)

$sql = "SELECT concat('Name:',st.Name) as name, concat('y:', sum(fs.SubTotal)*100/" . $tot_amount[0] . ") as y, concat('drilldown:', st.Name) as drilldown
FROM tabel_dimensi_lokasi st
JOIN tabel_fakta_penjualan2 fs ON (st.TerritoryID = fs.TerritoryID)
GROUP BY name ORDER BY y DESC";
//echo $sql;
$all_kat = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_all($all_kat)) {
    $data[] = $row;
}


$json_all_kat = json_encode($data);

//CHART KEDUA (DRILL DOWN)

//query untuk tahu SUM(LineTotal) semua wilayah
$sql = "SELECT st.Name kategori, sum(fs.SubTotal) as total_kategori
FROM tabel_fakta_penjualan2 fs
JOIN tabel_dimensi_lokasi st ON (st.TerritoryID = fs.TerritoryID)
GROUP BY kategori";

$hasil_kat = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_all($hasil_kat)) {
    $tot_all_kat[] = $row;
}

//print_r($tot_all_kat);
//function untuk nyari total_per_kat 

//echo count($tot_per_kat[0]);
//echo $tot_per_kat[0][0][1];

function cari_tot_kat($kat_dicari, $tot_all_kat)
{
    $counter = 0;
    // echo $tot_all_kat[0];
    while ($counter < count($tot_all_kat[0])) {
        if ($kat_dicari == $tot_all_kat[0][$counter][0]) {
            $tot_kat = $tot_all_kat[0][$counter][1];
            return $tot_kat;
        }
        $counter++;
    }
}

//query untuk ambil penjualan di kategori berdasarkan bulan (clean)
$sql = "SELECT st.Name kategori, t.bulan as bulan, sum(fs.SubTotal) as pendapatan_kat
FROM tabel_dimensi_lokasi st
JOIN tabel_fakta_penjualan2 fs ON (st.TerritoryID = fs.TerritoryID)
JOIN tabel_dimensi_waktu t ON (t.time_id = fs.time_id)
GROUP BY kategori, bulan;";
$det_kat = mysqli_query($conn, $sql);
$i = 0;
while ($row = mysqli_fetch_all($det_kat)) {
    //echo $row;
    $data_det[] = $row;
}

//print_r($data_det);

//PERSIAPAN DATA DRILL DOWN - TEKNIK CLEAN  
$i = 0;

//inisiasi string DATA
$string_data = "";
$string_data .= '{name:"' . $data_det[0][$i][0] . '", id:"' . $data_det[0][$i][0] . '", data: [';


// echo cari_tot_kat("Action", $tot_all_kat);
foreach ($data_det[0] as $a) {
    //echo cari_tot_kat($a[0], $tot_all_kat);

    if ($i < count($data_det[0]) - 1) {
        if ($a[0] != $data_det[0][$i + 1][0]) {
            $string_data .= '["' . $a[1] . '", ' .
                $a[2] * 100 / cari_tot_kat($a[0], $tot_all_kat) . ']]},';
            $string_data .= '{name:"' . $a[0] . '", id:"' . $a[0]    . '", data: [';
        } else {
            $string_data .= '["' . $a[1] . '", ' .
                $a[2] * 100 / cari_tot_kat($a[0], $tot_all_kat) . '], ';
        }
    } else {

        $string_data .= '["' . $a[1] . '", ' .
            $a[2] * 100 / cari_tot_kat($a[0], $tot_all_kat) . ']]}';
    }


    $i = $i + 1;
}




?>

<html>

<head>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <link rel="stylesheet" href="/drilldown.css" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js">

    </script>

</head>

<body>
    <figure class="highcharts-figure">
        <div id="container"></div>
    </figure>



    <script type="text/javascript">
        // Create the chart
        Highcharts.chart('container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },

            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    valueSuffix: '%'
                }
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },

            series: [{
                name: "Pendapatan Berdasarkan Wilayah",
                colorByPoint: true,
                data: <?php
                        //TEKNIK GAK JELAS :D

                        $datanya =  $json_all_kat;
                        $data1 = str_replace('["', '{"', $datanya);
                        $data2 = str_replace('"]', '"}', $data1);
                        $data3 = str_replace('[[', '[', $data2);
                        $data4 = str_replace(']]', ']', $data3);
                        $data5 = str_replace(':', '" : "', $data4);
                        $data6 = str_replace('"name"', 'name', $data5);
                        $data7 = str_replace('"drilldown"', 'drilldown', $data6);
                        $data8 = str_replace('"y"', 'y', $data7);
                        $data9 = str_replace('",', ',', $data8);
                        $data10 = str_replace(',y', '",y', $data9);
                        $data11 = str_replace(',y : "', ',y : ', $data10);
                        echo $data11;
                        ?>

            }],
            drilldown: {
                series: [

                    <?php
                    //TEKNIK
                    echo $string_data;

                    ?>



                ]
            }
        });
    </script>

</body>

</html>