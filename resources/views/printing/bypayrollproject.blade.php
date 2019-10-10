@extends('layouts.app')@section('content')
@php($title = 'Payroll ')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header text-center">
                        <h4 class="title">{{$projectname}}</h4>
                    </div>
                    <div class="content">

                    </div>
                </div>
            </div>

        </div>
        <div class="row">


            @foreach($dtrs->pluck('date')->unique() as $date)

            <div class="col-md-6">
                <div class="card" style='border: black'>
                    <div class="header">
                        <div class="row text-center">
                            <div class="col-xs-7 ">
                                @if($holidates->contains($date))
                                <h4 style='color:red' class="title">(Holiday) {{date('F j, Y', strtotime($date))}}</h4>
                                @else
                                <h4 class="title">{{date('F j, Y', strtotime($date))}}</h4>

                                @endif
                            </div>
                            <div class="col-xs-5">
                                <input class="form-control pull-right" id="search{{str_replace(' ', '', $date)}}"
                                    type="text" placeholder="Search..">
                            </div>
                        </div>



                        <hr>
                    </div>

                    <div class="content table-responsive table-full-width" style='overflow-x:hidden;'>

                        <table id="myTable" class="table table-hover tablesorter">
                            <thead>
                                <th>Employee Name </th>
                                <th>Skill</th>
                                <th>Base Pay</th>
                                <th>Total Time</th>
                                <th>Over Time</th>
                                <th>Over Time Pay</th>
                                <th>Location Rate</th>
                                <th>Final Pay</th>

                            </thead>

                            <tbody id='search{{str_replace(' ', '', $date)}}'>
                                @foreach($dtrs->where('date', $date) as $dt)
                                <tr>
                                    <td>
                                        {{$dt['employeeName']}}
                                    </td>
                                    <td>
                                        {{$dt['skill']}}
                                    </td>
                                    <td>
                                        {{$dt['basePay']}}
                                    </td>
                                    <td>
                                        {{$dt['totalTime']}}
                                    </td>
                                    <td>
                                        {{$dt['overTime']}}
                                    </td>
                                    <td>
                                        {{$dt['overTimePay']}}
                                    </td>
                                    <td>
                                        {{$dt['locationRate']}}
                                    </td>
                                    <td>
                                        {{$dt['finalPay']}}
                                    </td>

                                </tr>

                                @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
            @endforeach



        </div>
    </div>
</div>
<script>
    $(function() {
        $("#myTable").tablesorter();
    });
</script>
@endsection