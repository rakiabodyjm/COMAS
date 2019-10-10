@extends('layouts.app') @section('content')
@php($title = 'Summary for Employee')
<div class="content">
    <div class="container-fluid">
        <div class="row">

            <div class='col-md-3'>

                <div class="card">

                    <div class='header'>
                        <div class="row">
                            <i class="pe-7s-user" style='font-size: 70px;margin-left:10px;color:black'></i>
                            <div class="col-md-8">
                                <h4 class="title">{{$employee->full_name}}</h4>
                                @if(count($assignment)>0)
                                <h5>{{$assignment->first()->project_name}}</h5>
                                <label>
                                    <h6 style='color:red'>Salary Rate: {{$employee->skillz->salaryrate}}</h6>
                                    <h6 style='color:darkblue'>Skill: {{$employee->skillz->description}}</h6>
                                </label>

                                @else
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class='content' style="padding-top:0">
                        <div class="footer">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-refresh"> </i>
                                Last DTR Record:
                                @foreach($dtrs->sortBy('date') as $dtrz)
                                @if ($loop->last)
                                {{date('F j, Y',strtotime($dtrz->date))}}
                                @endif
                                @endforeach


                            </div>
                        </div>
                    </div>

                </div>


            </div>














        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="header">
                        <div class='row'>
                            <div class="col-xs-2 col-xs-offset-10">
                                <a href='#' id='openEmployeeSummaryModal' data-toggle='modal'
                                    data-target='#employeeSummaryModal'>
                                    <i class='fa fa-print' style='font-size:20px;margin-right:0px;color:black'></i>
                                </a>

                            </div>

                        </div>
                        <br>
                        <div class=' row text-center'>
                            <div class="col-md-7">
                                <h4 class="title">Dates of Attendances</h4>
                            </div>
                            <div class="col-md-5">
                                <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                            </div>
                        </div>

                        <hr>
                    </div>

                    <div class="content table-responsive table-full-width "
                        style="overflow-y:scroll; max-height:400px;">

                        <table id="myTable" class="table table-hover tablesorter">
                            <thead>
                                <th>Date</th>
                                <th>Project</th>
                                <th>Time</th>
                                <th>Pay</th>
                            </thead>
                            <tbody id=table>
                                @if(count($dtrs)>0)



                                @foreach($dtrs->unique('date') as $dtr)
                                @php($totalTime = $dtrs->where('date',
                                $dtr->date)->sum('time'))
                                <tr style='background-color: gray'>
                                    <td>
                                        <b>{{date('F j, Y',strtotime($dtr->date))}}</b>
                                    </td>
                                    <td>
                                        @if($totalTime>8)
                                        <b style='color:gold'>Overtime </b>
                                        @else

                                        @endif
                                    </td>
                                    <td>
                                        <b>{{$dtrs->where('date', $dtr->date)->sum('time')}}</b>
                                    </td>
                                    <td>

                                        @if($totalTime>8)

                                        <b>{{($totalTime - 8) * 1.2 * $dtr->pay/8+ 8*$dtr->pay/8}}</b>
                                        @else
                                        <b>{{$dtr->pay/8 * $dtrs->where('date', $dtr->date)->sum('time')}}</b>
                                        @endif
                                    </td>
                                </tr>

                                @foreach($dtrs->where('date', $dtr->date) as $dt)


                                <tr>

                                    @if($dt->summonid==null)
                                    <td>
                                        <p class='hidden'>{{date('F j, Y',strtotime($dt->date))}}</p>
                                    </td>
                                    <td>{{$dt->projectz['projectname']}}</td>
                                    @else
                                    <td>
                                        <p class='hidden'>{{date('F j, Y',strtotime($dt->date))}}</p>
                                    </td>
                                    <td>{{$dt->projectz['projectname']}}</td>
                                    @endif
                                    <td>
                                        {{$dt->time}}
                                    </td>
                                </tr>

                                @endforeach




                                @endforeach





                                @else
                                <tr>
                                    <td colspan=3 class='text-center'>No Submitted DTR Records Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="employeeSummaryModal">
    <div class="modal-dialog">
        <div class="card text-center">
            <div class="modal-content">

                {{-- @csrf --}}
                <div class="modal-header">
                    <h3>Select Dates to Summarize</h3>
                </div>
                <div class="modal-body">
                    <label>
                        Date From:
                    </label>
                    <input type="date" id="dateAttendanceFrom" class="form-control" placeholder="Date"
                        value="{{date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))))}}" name="date">
                    <label>
                        Date To:
                    </label>
                    <input type="date" id="dateAttendanceTo" class="form-control" placeholder="Date"
                        value="{{date('Y-m-d')}}" name="date">
                </div>

                <div>
                    <table>

                    </table>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-info btn-fill col-xs-2" id="confirmButton">Confirm</button>


                    <button type="button" class="btn btn-secondary btn-fill col-xs-2"
                        data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $('#openEmployeeSummaryModal').click(function()
    {
        $('#employeeSummaryModal').detach().appendTo('body');
        
        
    });
    $('#confirmButton').click(function()
    {
        console.log($('#dateAttendanceFrom').val());
        console.log($('#dateAttendanceTo').val());
        window.location.replace(window.location.href+'/from/'+($('#dateAttendanceFrom').val())+'/to/'+($('#dateAttendanceTo').val()))
    });
   
        $(function() {
            $("#myTable").tablesorter();
        });

</script>
@endsection