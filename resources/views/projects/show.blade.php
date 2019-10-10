@extends('layouts.app') @section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="header">

                        <div class='row'>
                            <div class="col-xs-2 col-xs-offset-10">
                                <a href='#' id='openProjectSummaryModal' data-toggle='modal' rel='tooltip' title=''
                                    data-original-title='Print' data-target='#projectSummaryModal'>
                                    <i class='fa fa-print' style='font-size:20px;margin-right:0px;color:black'></i>
                                </a>

                            </div>

                        </div>
                        <br>
                        <div class='row text-center'>
                            <div class="col-md-7">
                                <h4 class="title">Attendances Available</h4>
                            </div>
                            <div class="col-md-5">
                                <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                            </div>
                        </div>

                        <hr>
                    </div>

                    <div class="content table-responsive table-full-width" style="overflow-y:scroll; max-height:400px;">

                        <table id="myTable" class="table table-hover tablesorter">
                            <thead>
                                <th>Dates of Attendances</th>
                            </thead>
                            <tbody id=table>
                                @if(count($dtr)>0)
                                @foreach($dtr as $dt)
                                @php($x=0)
                                <tr class="clickable-row" data-href="{{$projectid}}/attendance/{{$dt}}">
                                    <td class='text-center'>
                                        {{date('F j, Y', strtotime($dt))}}
                                    </td>
                                </tr>

                                @endforeach
                                @else
                                <tr>
                                    <td class='text-center'>No Dates Available</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <div class="row text-center">
                            <div class="col-xs-7 ">
                                <h4 class="title">Employees Assigned</h4>
                            </div>
                            <div class="col-xs-5">
                                <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                            </div>
                        </div>



                        <hr>
                    </div>

                    <div class="content table-responsive table-full-width" style="overflow-y:scroll; max-height:400px;">

                        <table id="myTable" class="table table-hover tablesorter">
                            <thead>
                                <th>Employee</th>
                                <th>Skill</th>
                                <th>Date Assigned</th>
                            </thead>

                            <tbody id=search>

                                @csrf @if(count($assignments)>0) @foreach($assignments as $assignment)
                                <tr>

                                    <td>{{$assignment->employeez->lname}}, {{$assignment->employeez->fname}}</td>
                                    <td>{{$assignment->employeez->skillz->description}}</td>
                                    <td>{{date('F j, Y', strtotime($assignment->date))}}</td>
                                    {{-- <td>{{$assignment->projectz->projectname}}</td> --}}
                                </tr>
                                @endforeach @else
                                <tr>
                                    <td colspan="3" class='text-center'>
                                        No Employees Found
                                    </td>
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
<div class="modal fade" id="projectSummaryModal">
    <div class="modal-dialog">
        <div class="card text-center">
            <div class="modal-content">

                {{-- @csrf --}}
                <div class="modal-header">
                    <h3>Select Dates to Summarize for Printing</h3>
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
    $('#openProjectSummaryModal').click(function()
    {
        $('#projectSummaryModal').detach().appendTo('body');
        
        
    });
    $('#confirmButton').click(function()
    {
        console.log($('#dateAttendanceFrom').val());
        console.log($('#dateAttendanceTo').val());
        window.location.replace(window.location.href+'/summary/from/'+($('#dateAttendanceFrom').val())+'/to/'+($('#dateAttendanceTo').val()))
    });
    
</script>
<script>
    $(function() {
        $("#myTable").tablesorter();
    });
</script>
@endsection