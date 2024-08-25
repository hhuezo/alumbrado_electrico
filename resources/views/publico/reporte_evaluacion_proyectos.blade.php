<!DOCTYPE html>
<html lang="zxx" dir="ltr" class="light semiDark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <title>Evaluación de proyectos</title>

</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
    <div>
        <table style="width: 700px;">
            <tr>
                <th colspan="3">
                    <h2><b>Evaluación de proyectos</b></h2>
                </th>
            </tr>
        </table>
        <table border="1" cellspacing="0" style="width: 700px;">
            <tr>
                <th style="text-align: left; background-color: #f2f2f2;">
                    <label for="largeInput" style="font-weight: bold;">Departamento:</label>
                </th>
                <th style="text-align: left; background-color: #f2f2f2;">
                    <label for="largeInput" style="font-weight: bold;">Municipio:</label>
                </th>

                <th style="text-align: left; background-color: #f2f2f2;">
                    <label for="largeInput" style="font-weight: bold;">Distrito:</label>
                </th>
            </tr>
            <tr>
                <td style="text-align: left; background-color: #ffffff;">{{ $jsonUbicacion[0]['departamento'] }}</td>
                <td style="text-align: left; background-color: #ffffff;">{{ $jsonUbicacion[0]['municipio'] }}</td>
                <td style="text-align: left; background-color: #ffffff;">{{ $jsonUbicacion[0]['distrito'] }}</td>
            </tr>
        </table>
        <br>
        <table style="width: 700px;" border="0">
            <tr >
                <td colspan="3" align="center">
                    <img src="{{ base_path('public/img/grafico1.png') }}" alt="Gráfico"
                        style="margin:auto; width: 75%; " />
                </td>
            </tr>
        </table>
        
        <table style="width: 720px;">
            <tr>
                <th>
                    <h3><b>Luminarias que se desean sustituir</b></h3>
                </th>
            </tr>
        </table>
        <table style="padding: 1% !important; width: 700px;" border="1" cellspacing="0">

            <tr>
                <th style="text-align: center; background-color: #f2f2f2; padding: 3.5px;">Tecnología</th>
                <th style="text-align: center; background-color: #f2f2f2; padding: 3.5px;">Potencia</th>
                <th style="text-align: center; background-color: #f2f2f2; padding: 3.5px;">kWh</th>
                <th style="text-align: center; background-color: #f2f2f2; padding: 3.5px;">N° Luminarias</th>
                <th style="text-align: center; background-color: #f2f2f2; padding: 3.5px;">Cantidad</th>
            </tr>

            @foreach ($jsonTablaSustituir as $resultado)
            <tr>
                <td style="text-align: center; background-color: #ffffff; padding: 3.5px;">
                    {{ $resultado['tecnologia'] }}
                </td>
                <td style="text-align: center; background-color: #ffffff; padding: 3.5px;">
                    {{ $resultado['potenciaNominal'] }} Vatios
                </td>
                <td style="text-align: center; background-color: #ffffff; padding: 3.5px;">
                    {{ $resultado['consumoMensual'] }}
                </td>
                <td style="text-align: center; background-color: #ffffff; padding: 3.5px;">
                    {{ $resultado['totalLuminarias'] }}
                </td>
                <td style="text-align: center; background-color: #ffffff; padding: 3.5px;">
                    {{ $resultado['luminariasSustituir'] }}
                </td>
            </tr>
            @endforeach

        </table>
        <br>

        <table style="width: 720px;" >
            <tr>
                <td style="width: 40%; vertical-align: top;">
                    <table border="0" cellspacing="0" style="width: 100%;">
                        <tr>
                            <th style="text-align: left; background-color: #f2f2f2; padding-left: 4px;">
                                <h3><b>Tecnología Sugerida a Sustituir</b></h3>
                            </th>
                        </tr>
                        <tr>
                            <td  style="padding: 8px;">
                                <label for="largeInput" style="font-weight: bold;">Tecnología a sustituir:</label>
                                {{ $jsonTecnologiaSustituir[0]['tecnologia_sustituir'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px;">
                                <label for="tecno_susti_kwh_uso" style="font-weight: bold;">kWh de uso:</label>
                                {{ $jsonTecnologiaSustituir[0]['tecno_susti_kwh_uso'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px;">
                                <label for="tecno_susti_valor_mercado" style="font-weight: bold;">Precio Mercado por unidad
                                    ($):</label>
                                ${{ $jsonTecnologiaSustituir[0]['tecno_susti_valor_mercado'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px;">
                                <label for="tecno_susti_total_iluminarias" style="font-weight: bold;">Total a
                                    sustituir:</label>
                                {{ $jsonTecnologiaSustituir[0]['tecno_susti_total_iluminarias'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px;">
                                <label for="tecno_susti_total_inversion" style="font-weight: bold;">Total inversión
                                    ($):</label>
                                {{ $jsonTecnologiaSustituir[0]['tecno_susti_total_inversion'] }}
                            </td>
                        </tr>
                    </table>
                </td>

                <td style="width: 60%; vertical-align: top;">
                    <table  border="0" cellspacing="0">
                        <tr>
                            <th style="text-align: left; background-color: #f2f2f2; padding-left: 5px;">
                                <h3><b>Analisis Financiero
                                    <br><br>
                                    Valor
                                        kWh:
                                        ${{ rtrim($configuracion->valor_kwh, '0') }}
                                </b></h3>
                            </th>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td>
                                <table border="1" cellspacing="0" style="border:1px solid black; ">
                                    <tr>
                                        <th style="text-align: left; background-color: #f2f2f2; border:1px solid black; padding: 3.5px;"></th>
                                        <th style="text-align: left; background-color: #f2f2f2; border:1px solid black; padding: 3.5px;">Costo Mensual Total</th>
                                        <th style="text-align: left; background-color: #f2f2f2; border:1px solid black; padding: 3.5px;">Costo Anual</th>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left; background-color: #f2f2f2; border:1px solid black; padding: 3.5px;"><b>Precio energia facturado</b></td>
                                        <td style="border:1px solid black; padding: 3.5px;">{{ $jsonAnalisisFinanciero[0]['precio_facturado_mensual'] }}</td>
                                        <td style="border:1px solid black; padding: 3.5px;">{{ $jsonAnalisisFinanciero[0]['precio_facturado_anual'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left; background-color: #f2f2f2; border:1px solid black; padding: 3.5px;"><b>Precio sustituido</b></td>
                                        <td style="border:1px solid black; padding: 3.5px;">{{ $jsonAnalisisFinanciero[0]['precio_sustituido_costo_mensual'] }}</td>
                                        <td style="border:1px solid black; padding: 3.5px;">{{ $jsonAnalisisFinanciero[0]['precio_sustituido_costo_anual'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left; background-color: #f2f2f2; border:1px solid black; padding: 3.5px;"><b>Ahorro</b></td>
                                        <td style="border:1px solid black; padding: 3.5px;">{{ $jsonAnalisisFinanciero[0]['ahorro_mensual'] }}</td>
                                        <td style="border:1px solid black; padding: 3.5px;">{{ $jsonAnalisisFinanciero[0]['ahorro_anual'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid black; padding: 3.5px;"></td>
                                        <td style="border:1px solid black; padding: 3.5px;"><b>PR</b></td>
                                        <td style="border:1px solid black; padding: 3.5px;">{{ $jsonAnalisisFinanciero[0]['pr'] }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>
                                PR: Periodo de recuperacion simple es la
                                    inversion entre el
                                    ahorro anual.
                                </h4>
                                @if ($jsonAnalisisFinanciero[0]['pr'] <= 3 && $jsonAnalisisFinanciero[0]['pr']>= 0)
                                <div style="background-color: green; border-radius: 0.375rem; color: #ffffff; padding: 15px;">
                                            El Proyecto Es viable.
                                     
                                </div>
                                @else
                                <div style="background-color: #f1595c; border-radius: 0.375rem; color: #ffffff; padding: 15px;">
                                            Revisar condiciones para su ejecución
                                </div>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <br>
        <table>
            <tr>
                <td>
                <img src="{{ base_path('public/img/grafico2.png') }}" alt="Gráfico"
                                style="margin: 0 auto;" />
                </td>
            </tr>
        </table>
    </div>
</body>

</html>