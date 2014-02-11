<?php
//---Revenue Per Wilayah--//
for ($zz = 0; $zz < (count($kategor)); $zz++) {
    if ($zz < (count($kategor)) - 1) {
        $dt_kategor[$zz] = "'" . $kategor[$zz] . "',";
    } else {
        $dt_kategor[$zz] = "'" . $kategor[$zz] . "'";
    }
}

for ($zz = 0; $zz < (count($nilai)); $zz++) {
    if ($nilai[$zz] == '') {
        $nilai[$zz] = '0';
    }
    if ($zz < (count($nilai)) - 1) {
        $dt_nilai[$zz] = $nilai[$zz] . ",";
    } else {
        $dt_nilai[$zz] = $nilai[$zz];
    }
}
//^^^^^^^^^^^^^^^^^//
//--Profit Layanan Pengiriman------//
$kd_ly = mysql_query("SELECT kode_layanan FROM layanan");
$tot = mysql_num_rows($kd_ly);
$i = 0;
while ($kod = mysql_fetch_array($kd_ly)) {
    $kode[$i] = $kod['kode_layanan'];

    if ($i < ($tot - 1)) {
        $tanda[$i] = " },";
    } else {
        $tanda[$i] = "}\n";
    }
    for ($bln = 1; $bln < 13; $bln++) {
        if ($kondisi == 'awal') {
            $query_1 = "
                    SELECT sum(biaya) as profit, MONTH(tanggal) as tanggal, kode_layanan 
                    FROM transaksi 
                    WHERE YEAR(tanggal) = $tahun 
                    AND kode_layanan = '$kode[$i]' 
                    AND MONTH(tanggal) = '$bln'
                    GROUP BY MONTH(tanggal)
                   ";
        } elseif ($kondisi == 'prov') {
            $query_1 = "
                    SELECT sum(transaksi.biaya) as profit, MONTH(transaksi.tanggal) as tanggal, transaksi.kode_layanan
                    FROM transaksi, pengirim, customer, kota
                    LEFT JOIN provinsi ON kota.provinsi_id_provinsi = provinsi.id_provinsi
                    WHERE transaksi.id_pengirim = pengirim.id_pengirim
                    AND pengirim.customer_id_customer = customer.id_customer
                    AND customer.id_kota = kota.id_kota
                    AND YEAR(tanggal) = $tahun
                    AND kode_layanan = '$kode[$i]' 
                    AND provinsi.id_provinsi BETWEEN $between
                    AND MONTH(tanggal) = '$bln'
                    GROUP BY MONTH(tanggal)            
                   ";
        } elseif ($kondisi == 'kota') {
            $query_1 = "
                    SELECT sum(transaksi.biaya) as profit, MONTH(transaksi.tanggal) as tanggal, transaksi.kode_layanan
                    FROM transaksi, pengirim, customer, kota
                    LEFT JOIN provinsi ON kota.provinsi_id_provinsi = provinsi.id_provinsi
                    WHERE transaksi.id_pengirim = pengirim.id_pengirim
                    AND pengirim.customer_id_customer = customer.id_customer
                    AND customer.id_kota = kota.id_kota
                    AND YEAR(tanggal) = $tahun
                    AND kode_layanan = '$kode[$i]' 
                    AND MONTH(tanggal) = '$bln'
                    AND provinsi.id_provinsi = (SELECT id_provinsi FROM provinsi WHERE provinsi = '$wilayah')
                    GROUP BY MONTH(tanggal)            
                   ";
        }
        $dt[$i] = mysql_query($query_1);
        $brs[$i] = mysql_fetch_array($dt[$i]);
        $pt[$i][$bln] = $brs[$i]['profit'];
        $tg[$i][$bln] = $brs[$i]['tanggal'];

        if ((empty($pt[$i][$bln])) AND (empty($tg[$i][$bln]))) {
            $pt[$i][$bln] = 0;
            // $tg[$i][$bln] = 0;
        }
        if ($bln < 12) {
            $profit[$i][$bln] = $pt[$i][$bln] . ",";
            // echo "tanggal[$i]= ".$dat[$i][$x]['tanggal'];
        } else {
            $profit[$i][$bln] = $pt[$i][$bln];
        }
        // echo $profit[$i][$bln];
    }
    // echo "<br>";
    $i++;
}
//---------------------------//
//---PIE DIAGRAM----//
$i = 0;
foreach ($pie as $p) {
    if ($i < (count($pie))) {
        $dt_pie[$i] = "['" . $p->kode_layanan . "', " . $p->persen . "],";
    } else {
        $dt_pie[$i] = "['" . $p->kode_layanan . "', " . $p->persen . "]";
    }
    $i++;
}
//^^^^^^^^^^^^^^^^^//
//-------------------//
?>
<script type="text/javascript" src="<?php echo base_url() ?>media/js/1.8.2-jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        var chart;
        $(document).ready(function() {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'kolom',
                    type: 'column'
                },
                title: {
                    text: 'Revenue Per Wilayah'
                },
                xAxis: {
                    categories: [<?php
for ($zz = 0; $zz < (count($kategor)); $zz++) {
    echo $dt_kategor[$zz];
}
?>]
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Total Revenue'
                        },
                        stackLabels: {
                            enabled: true,
                            style: {
                                fontWeight: 'bold',
                                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                            }
                        }
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>'+ this.x +'</b><br/>'+
                                'Total: '+ this.point.stackTotal;
                        }
                    },
                    plotOptions: {
                        column: {
                            stacking: 'normal',
                            dataLabels: {
                                enabled: false,
                                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                            }
                        },
                        series: {
                            cursor: 'pointer',
                            point: {
                                events: {
                                    click: function() {
<?php if ($kondisi == 'kota') { ?>
                                            window.location = "<?php echo base_url() . $url; ?>";                                        
<?php } else { ?>
                                            window.location = "<?php echo base_url() . $url; ?>"+this.category;
<?php } ?>
                                    }
                                }
                            }
                        }
                    
                    },
                    series: [{
                            name: '<?php echo $wilayah; ?>',
                            data: [<?php
for ($zz = 0; $zz < (count($nilai)); $zz++) {
    echo $dt_nilai[$zz];
}
?>]
                            }]
                    });

                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'trendrevenue',
                            type: 'line',
                            marginRight: 130,
                            marginBottom: 25
                        },
                        title: {
                            text: 'Profit Layanan Pengiriman \n Tahun <?php echo $tahun; ?>',
                            x: -20 //center
                        },
                        xAxis: {
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                        },
                        yAxis: {
                            title: {
                                text: 'Revenue'
                            },
                            plotLines: [{
                                    value: 0,
                                    width: 1,
                                    color: '#808080'
                                }]
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                    this.x +': '+ this.y;
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -10,
                            y: 100,
                            borderWidth: 0
                        },
                        series: [
<?php
for ($c = 0; $c < (count($kode)); $c++) {
    echo "
                {\n 
                    name: '" . $kode[$c] . "',\n";
    echo "       data: [";
    for ($ii = 1; $ii < 13; $ii++) {
        if (isset($profit[$c][$ii])) {
            echo $profit[$c][$ii];
        }
    }
    echo "]\n";
    echo $tanda[$c];
}
?>
                        ]
                    });  

                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'presentase',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false
                        },
                        title: {
                            text: 'Presentase Layanan Pengiriman <br> Tahun <?php echo $this->session->userdata("tahun"); ?>'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                            percentageDecimals: 1
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: true
                            }
                        },
                        series: [{
                                type: 'pie',
                                name: 'Presentase pengiriman',
                                data: [<?php
for ($yy = 0; $yy < (count($pie)); $yy++) {
    echo $dt_pie[$yy];
}
?>]
                                }]
                        });
                    });
                });
             
</script>
<script src="<?php echo base_url() ?>media/js/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="/twitter-bootstrap/twitter-bootstrap-v2/js/bootstrap-tooltip.js"></script>  
<script src="/twitter-bootstrap/twitter-bootstrap-v2/js/bootstrap-popover.js"></script>  
<script>  
                $(function() {
                    $(".acehss").popover({
                        offset: 50,
                        placement: 'left',
                        trigger: 'hover'
                    });
                });   
</script> 

<div class="panel" id="panel-101">
    <header>
    </header>
    <div class="content tiles-container">
        <div id="kolom" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
    </div>
</div>




<div class="row-fluid">

    <div class="span8">

        <div class="panel" id="panel-13">
            <header>
            </header>
            <div class="content">
                <div id="trendrevenue" style="min-width: 400px; height: 300px; margin: 0 auto"></div>
            </div>
        </div>

    </div>

    <div class="span4">

        <div class="panel" id="panel-102">
            <header>
            </header>
            <div class="content tiles-container">
                <div id="presentase" style="min-width: 300px; height: 300px; margin: 0 auto"></div>
            </div>
        </div>
    </div>
</div>


