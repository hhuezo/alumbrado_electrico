
<div id="container_conteo_luminaria_pie_sugerido" class="xl:col-span-6 col-span-6 lg:col-span-6 ">

</div>
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script>

    chartSugerido = Highcharts.chart('container_conteo_luminaria_pie_sugerido', {
        chart: {
            type: 'pie'
        },
        title: {
            align: 'left',
            text: 'Distribución de luminarias despues de la sustitución'
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

    async function handleChartToBase642(chart) {
        try {
            const base64Data = await chartToBase64(chart);
            console.log("grafico64", base64Data);
            $('#jsonGraficoSustituir').val(base64Data);
        } catch (error) {
            console.error("Error:", error);
        }
    }

    setTimeout(function() {
       handleChartToBase642(chartSugerido);
    }, 500); // Ajusta el tiempo según sea necesario

   /* setTimeout(function() {
        $('#jsonGraficoSustituir').val(chartToBase64(chartSugerido));
    }, 500); // Ajusta el tiempo según sea necesario*/
</script>
