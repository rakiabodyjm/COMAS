@php($title = 'Dashboard')
@extends('layouts.app')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4" style='min-width:400px'>
                <div class="card">
                    <div class="header ">
                        <h4 class="title">Distribution of Payroll</h4>

                    </div>
                    <div class="content">
                        <div id="chartPayroll" class="ct-chart ct-perfect-fourth"></div>

                        <div class="footer">
                            <div class="legend">
                                <p class="category">From:
                                    {{date('F j, Y', strtotime(date('Y-m-d', strtotime('-5 days'))))}}</p>
                                <p class="category">From: {{date('F j, Y', strtotime(date('Y-m-d')))}}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="header ">
                        <h4 class="title">Payroll Daily</h4>
                        <p class="category">From: </p>
                        <p class="category">To: </p>
                    </div>
                    <div class="content">
                        <div id="barGraph" class="ct-chart ct-perfect-fourth"></div>

                        <div class="footer">
                            <div class="legend">
                                {{-- <i class="fa fa-circle text-info"></i> Open
                                            <i class="fa fa-circle text-danger"></i> Bounce
                                            <i class="fa fa-circle text-warning"></i> Unsubscribe --}}
                            </div>
                            {{-- <hr>
                                        <div class="stats">
                                            <i class="fa fa-clock-o"></i> Campaign sent 2 days ago
                                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<script>
</script>
<script type="text/javascript">
    $(document).ready(function(){

        	demo.initChartist();

        	$.notify({
            	icon: 'pe-7s-gift',
            	message: "Welcome to <b>COMAS</b> - a Payroll and Inventory System for MANRIC."

            },{
                template: '<div data-notify="container" class="col-xs-11 col-sm-9 alert alert-{0}" role="alert">'+
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>'+
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">x</button>'
                    ,
                timer: 4000,
                placement: {
                from: "top",
                align: "center"
                }
            });

                    var data = {
                    labels: [
                        @foreach($payrolldata as $a)
                        "{{$a['projectname']}}, {{$a['total']}}",
                        @endforeach
                    ],
                    series: [
                        @foreach($payrolldata as $a)
                        "{{$a['total']}}",
                        @endforeach
                    ]
                    };

                    var options = {
                    labelInterpolationFnc: function(value) {
                        return value[0]
                    }
                    };

                    var responsiveOptions = [
                    ['screen and (min-width: 1000px)', {
                        chartPadding: 30,
                        labelOffset: 100,
                        labelDirection: 'explode',
                        labelInterpolationFnc: function(value) {
                            return value;
                        }
                    }],
                    ['screen and (min-width: 1024px)', {
                        labelOffset: 40,
                        chartPadding: 20
                    }]
                    ];

                    new Chartist.Pie('#chartPayroll', data, options, responsiveOptions);

                    new Chartist.Bar('#barGraph', {
                    labels: ['Quarter 1', 'Quarter 2', 'Quarter 3', 'Quarter 4'],
                    series: [
                        [5, 4, 3, 7],
                        [3, 2, 9, 5],
                        [1, 5, 8, 4],
                        [2, 3, 4, 6],
                        [4, 1, 2, 1]
                    ]
                    }, {
                    // Default mobile configuration
                    stackBars: true,
                    axisX: {
                        labelInterpolationFnc: function(value) {
                        return value.split(/\s+/).map(function(word) {
                            return word[0];
                        }).join('');
                        }
                    },
                    axisY: {
                        offset: 20
                    }
                    }, [
                    // Options override for media > 400px
                    ['screen and (min-width: 400px)', {
                        reverseData: true,
                        horizontalBars: true,
                        axisX: {
                        labelInterpolationFnc: Chartist.noop
                        },
                        axisY: {
                        offset: 60
                        }
                    }],
                    // Options override for media > 800px
                    ['screen and (min-width: 770px)', {
                        stackBars: false,
                        seriesBarDistance: 10
                    }],
                    // Options override for media > 1000px
                    ['screen and (min-width: 1000px)', {
                        reverseData: false,
                        horizontalBars: false,
                        seriesBarDistance: 15
                    }]
                    ]);


    	});
</script>
@endsection