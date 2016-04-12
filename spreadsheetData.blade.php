@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Water Aid Device Report.
            </header>
            @if( count($process_result)>0 )

                <div class="panel-body">
                    <div class="adv-table editable-table ">

                        <div class="space15"></div>
                        <table class="table table-bordered table-striped table-condensed table-hover">
                            <thead class="center-align">
                            <tr>
                                <th>Date</th>
                                <th>Phone number</th>
                                <th>Amount used</th>
                                <th>Daily amount used</th>
                                <th>Daily amount adjusted for reset</th>
                                <th>Daily litres</th>
                                <th>Total Amount in litres day</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($process_result as $info )
                                
                                    <?php
                                        if ( isset($info['date']) ) {

                                            $dateformat = explode('at', $info['date']);
                                            
                                            $date = $dateformat[0] .' '.$dateformat[1];

                                        } else {
                                            $date = '';
                                        }
                                        
                                    if( !empty($date) ) {

                                    ?>
                                <tr>
                                    <td>{{ $date }}</td>
                                    <td>{{ isset( $info['phonenumber'] ) ? $info['phonenumber'] : ''  }}</td>
                                    <td>{{ isset( $info['amountused'] ) ? $info['amountused'] : ''  }}</td>
                                    <td>{{ isset( $info['dailyamountused'] ) ?  $info['dailyamountused']: '' }}</td>
                                    <td>{{ isset( $info['dailyamountadjustedforreset'] ) ? $info['dailyamountadjustedforreset'] : ''  }}</td>
                                    <td>{{ isset( $info['dailylitres'] ) ? $info['dailylitres'] : 0  }}</td>
                                    <td>{{ isset( $info['gsxgxcolotalamountinlitresday'] ) ? $info['gsxgxcolotalamountinlitresday'] : 0 }}</td>

                                </tr>
                                <?php
                                    }
                                ?>
                            @endforeach

                            </tbody>
                        </table>
                        
                    </div>
                </div>
            @else
                <tr> <td colspan="7"> <center> No Result found </center> </td> </tr>
            @endif

            <!-- Chart Area -->

            <div id="ChartDataResult" style="width: 900px; height: 300px;"></div>
        </section>
    </div>
</div>

<script type="text/javascript">


    /*  Bar chart for Water Aid Result */

    google.load('visualization', '1', {packages: ['corechart', 'bar']});

    google.setOnLoadCallback( drawWaterAidChart );

    function drawWaterAidChart() {

        var data = google.visualization.arrayToDataTable([
            ['BarChart', 'Weight', { role: 'style' }, { role: 'annotation' } ],

        <?php 

        foreach($process_result as $info ) {
            
            if ( isset($info['date']) ) {

                $dateformat = explode('at', $info['date']);
                
                $date = $dateformat[0] .' '.$dateformat[1];

            } else {
                $date = '';
            }
                
            if( !empty($date) ) {

            $amount = isset( $info['amountused'] ) ? $info['amountused'] : 0;
            $total  = explode(',', $amount);
            $totalAmount = implode('', $total);

            $colorValue = rand(000001, 999999);
        ?>
            
            [<?php echo "'" .$date."'"; ?> , <?php echo $totalAmount; ?> , <?php echo "'#" .$colorValue."'"; ?>, <?php echo "'" . $amount ."'"; ?>],

        <?php    
            }
        }    
        ?>

        ]);
        
        var options = {
            'title':'Water Aid Result',
            chartArea: { width: '100%', 'height': '100%' },
            isStacked: true,
            bar: { groupWidth: "95%" },
            legend: { position: "none" },
            hAxis: {
                minValue: 0,
            }
        };

        var chart = new google.visualization.ColumnChart( document.getElementById('ChartDataResult') );
        chart.draw( data, options );
        
    }

</script>

@stop