@extends('layouts.app') @section('content')
@php($title = 'Assignment')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">

                    <div class="header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="title">Employees</h4>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                            </div>
                        </div>

                        <hr>
                    </div>

                    <div class="content table-responsive table-full-width" style="overflow-y:scroll;max-height:330px;">

                        <table id="myTable" class="table table-hover tablesorter">
                            <thead>
                                <th>Employees</th>
                            </thead>

                            <tbody id=table class="assignmenttable">
                                @if(count($employees)>0)
                                @foreach($employees as $employee)


                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-between bg-secondary">
                                            <div>
                                                {{$employee->full_name}}
                                            </div>

                                            <div class="checkbox">
                                                <input id="checkbox{{$employee->employeeid}}" name='assign[]'
                                                    type="checkbox" value="{{$employee->employeeid}}">
                                                <label for="checkbox{{$employee->employeeid}}"></label>
                                            </div>

                                        </div>

                                    </td>

                                </tr>

                                @endforeach
                                @endif


                                @if(count($employees)==0)
                                <tr>
                                    <td colspan="1" class='text-center'>
                                        No Employees Found
                                    </td>
                                </tr>
                                @endif

                                </td>
                        </table>

                    </div>
                    <hr>
                    <div class="text-center">
                        <div class="d-flex mx-3">
                            <button type="submit" id="sumite" class="col-md-12 btn btn-primary btn-fill">Assign</button>
                        </div>

                    </div>
                    <hr>

                </div>
            </div>
            <div class='col-md-6'>
                @foreach($projects as $project)
                <div class="col-md-12">
                    <div class="card">

                        <div class="content">
                            <button type="button" class="btn btn-info btn-fill col-xs-12 container-fluid"
                                data-toggle="collapse" data-target="#collapse{{$project->projectid}}"
                                style="white-space:">{{$project->projectname}}
                            </button>
                            <hr>
                            <br>
                            <div id="collapse{{$project->projectid}}" class="collapse">

                                <form method="post" id='{{$project->projectid}}'
                                    action="{{action('AssignmentsController@disassignthatbitch')}}">
                                    @csrf
                                    <div class="content table-responsive table-full-width"
                                        style="overflow-y:scroll;max-height:330px;">

                                        <table id="myTable" class="table table-hover tablesorter">
                                            <thead>
                                                <th>Employees</th>
                                                <th>Date of Assignment</th>
                                            </thead>
                                            <form>
                                                <tbody id=table class="assignmenttable">

                                                    @if(count($project->assignmentz)>0)
                                                    @foreach($project['assignmentz'] as $proass)
                                                    <tr>
                                                        <td>
                                                            <div class="bg-secondary">
                                                                <div>
                                                                    {{$proass->employee_name}}
                                                                </div>


                                                            </div>

                                                        </td>
                                                        <td>
                                                            <div>
                                                                {{date('F j, Y', strtotime($proass->date))}}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input id="checkbox{{$proass->assignmentid}}"
                                                                    name='disassign[]' type="checkbox"
                                                                    value="{{$proass->assignmentid}}" class="unassign">
                                                                <label for="checkbox{{$proass->assignmentid}}"></label>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                    @endif
                                                    @if(count($project->assignmentz)==0)
                                                    <tr>
                                                        <td colspan="1" class='text-center'>
                                                            No Employees Found
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </tbody>



                                        </table>

                                    </div>
                                    <button type="submit" id="unassign{{$project->projectid}}"
                                        class="col-md-12 btn btn-secondary btn-fill">Unassign</button>
                                    <div class='clearfix'></div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
                @endforeach


            </div>


            <div class="modal fade" id="assignModal">
                <div class="modal-dialog">
                    <div class="card text-center">
                        <div class="modal-content">

                            {{-- @csrf --}}
                            <div class="modal-header">
                                <h3>Select Project to Assign</h3>
                            </div>
                            <div class="modal-body">
                                <select class="form-control" name="project" id="project" value="">
                                    @foreach($projects as $project)
                                    <option value="{{$project->projectid}}">{{$project->projectname}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <table>

                                </table>
                            </div>

                            <div class="modal-footer d-flex justify-content-center">
                                <button type="submit" class="btn btn-info btn-fill col-xs-2"
                                    id="submitAss">Confirm</button>


                                <button type="button" class="btn btn-secondary btn-fill col-xs-2"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<script>
    var modalhtml
    var val=[];
    $(document).ready(function()
    {
        modalhtml = $('#assignModal').detach();
        modalhtml.appendTo("body");

        $("#submitAss").click(function(e)
        {
            e.preventDefault();

            var project = $("select[name='project']").val();
            var employee = val;

            var realData = {
                "_token":'{{ csrf_token() }}',
                "project":project,
                "employees":employee
            };
            // var jsonData = JSON.stringify(realData);
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                $.ajax({
                    type: 'POST',
                 
                    url: '/projects/assign',
                    data: realData,
                    dataType: 'JSON',
                    crossDomain: true,
                    success:function(response){

                   
                        notification(response.join(' | ')+' Assigned', 'success');
                        $('#assignModal').modal('toggle');
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }
            });


        });
        
    });

    $("#sumite").click(function()
    {
        
        $('[id^=checkbox][type=checkbox]:checked').each(function(i)
        {
            val[i] = $(this).val();
        });
            $('#assignModal').modal('show');
    });

    // $('[id^=unassign]').click(function(e)
    // {
    //     var emp=[];
    //     // $('#disAssCheck:checked').each(function(i)
    //     // {
    //     //     emp[i] = $(this).val();
    //     // });
    //     $('[id^=checkbox][type=checkbox].unassign:checked').each(function(i)
    //     {
    //         emp[i]=$(this).val();
    //     });

    //     e.preventDefault();
        

    //       $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //           var theData = {
    //             "_token":'{{ csrf_token() }}',
    //             "employees":emp
    //         };
    //             $.ajax({
    //                 type: 'POST',
    //                 // headers: {
    //                 // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                 // },
    //                 url: '/projects/disassign',
    //                 data: theData,
    //                 dataType: 'JSON',
    //                 crossDomain: true,
    //                 success:function(response){
    //                     notification(response.join(' | ')+' Unassigned', 'success');

    //                     setTimeout(function(){
    //                         location.reload();
    //                     }, 2000);
    //                 }
                   
                    
    //         });
        
    // });

    function notification(string, type)
    {
        $.notify({
        message: string,
        icon: "pe-7s-attention",
        
        },{
        type: type,
        delay: 7000,
        template: '<div data-notify="container" class="col-xs-11 col-sm-9 alert alert-{0}" role="alert">'+
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>'+
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">x</button>'
            ,
            placement: {
            from: "top",
            align: "center"
            }
        
            })
    }


    $(function() {
        $("#myTable").tablesorter();
    });

</script>
@endsection