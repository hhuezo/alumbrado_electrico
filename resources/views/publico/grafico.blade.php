<div id="container_conteo_luminaria_pie" class="xl:col-span-6 col-span-6 lg:col-span-6 ">

</div>
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script>
    chart = Highcharts.chart('container_conteo_luminaria_pie', {
        chart: {
            type: 'pie'
        },
        title: {
            align: 'left',
            text: 'Cantidad por tipo de luminaria'
        },
        subtitle: {
            align: 'left',
            text: ''
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Número de luminarias'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y:.0f}'
                },
                showInLegend: true
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b>   <br/>'
        },

        series: [{
            name: 'Browsers',
            colorByPoint: true,
            data: @json($data_numero_luminaria)

        }]
    });

    // Convertir el gráfico a una imagen en Base64
    function chartToBase64(chart) {
        var svg = chart.getSVG(); // Obtener el SVG generado por Highcharts
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var img = new Image();

        img.onload = function() {
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);

            // Convertir el canvas a Base64
            var dataURL = canvas.toDataURL('image/png');
            console.log(dataURL); // Aquí tienes la imagen en formato Base64

            // Si necesitas almacenar el Base64 en un input hidden
            $('#inputHiddenImagen').val(dataURL);
        };

        return btoa(unescape(encodeURIComponent(svg)));
    }
    setTimeout(function() {
        $('#jsonGrafico').val(chartToBase64(chart));
    }, 500); // Ajusta el tiempo según sea necesario
</script>
