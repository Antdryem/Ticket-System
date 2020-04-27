<!DOCTYPE HTML>
<?php if (!isset($ejecutado)) { ?>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <title>Gráfica</title>

            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
            <style type="text/css">
                demo.css
            </style><?php }else echo "<head>"; ?>
        <script type="text/javascript">
            $(function () {
                $('#container').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: '<?php echo $datos[1]; ?>'
                    },
                    subtitle: {
                        text: '   '
                    },
                    xAxis: {
                        type: 'category',
                        labels: {
                            rotation: -45,
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '<?php echo $datos[0]; ?>'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    tooltip: {
                        pointFormat: ' <b>{point.y:.1f}<?php echo $datos[2]; ?> </b>'
                    },
                    series: [{
                            name: 'Population',
                            data: [
<?php for ($pene = 0; $pene < count($datos[3]) / 2; $pene++) { ?>
                                    [
                                            '<?php echo $datos[3][$pene * 2]; ?>',
    <?php
    echo $datos[3][$pene * 2 + 1];
    ?>],
<?php } ?>
                            ],
                            dataLabels: {
                                enabled: true,
                                rotation: -90,
                                color: '#FFFFFF',
                                align: 'right',
                                format: '{point.y:.1f}', // one decimal
                                y: 10, // 10 pixels down from the top
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        }]
                });
            });
        </script>
        <?php if (!isset($ejecutado)) { ?>
        </head>
        <body>
            <script src="../../externos/graficos/js/highcharts.js"></script>
            <script src="../../externos/graficos/js/modules/exporting.js"></script>

            <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>

        </body>
    </html>


    <?php
}else echo "</head>";
$ejecutado = 0;
