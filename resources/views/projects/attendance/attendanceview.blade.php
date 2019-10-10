@extends('layouts.app') @section('content')
@php($title = 'Attendance' )
<div class="content">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">

            <div class="col-md-4" style="display:block">
                <div class="card">
                    <div class="header">
                        <h4 class="title text-center">
                            Date of Attendance
                        </h4>
                        <h5 class="text-center" style="color:cornflowerblue;">
                            {{-- @foreach($assignments as $assignment)
                            @if($loop->last)
                            {{$assignment->projectz->projectname}}
                            @endif
                            @endforeach --}}
                            {{$projectname}}
                        </h5>
                    </div>
                    <div class="content">

                        <input type="date" id="dateAttendance" class="form-control" placeholder="Date" value="{{$date}}"
                            name="date">
                        <br>
                        <div class="text-center">
                            <span class="glyphicon pe-7s-left-arrow"
                                style="font-size:25px; margin-right:15px; cursor: pointer;"
                                onclick="dateStepFunction(0)">
                            </span>
                            {{-- <div class="col-md-4">
                                    <i class='fa fa-arrow-circle-o-left' style='font-size:30px;margin-right:0px'></i>

                            </div> --}}

                            <button type="submit" id='dateBtn' class="btn btn-info btn-fill">Enter</button>


                            {{-- <div class="col-md-4">
                                    <i class='fa fa-arrow-circle-o-right' style='font-size:30px;margin-left:0px'></i>

                            </div> --}}

                            <span class="glyphicon pe-7s-right-arrow"
                                style="font-size:25px; margin-left:15px; cursor: pointer;"
                                onclick="dateStepFunction(1)">
                            </span>

                        </div>
                    </div>
                </div>





            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="header text-center">
                        <h4 class="title">Unconfirmed Attendances</h4>



                    </div>
                    <hr>

                    <div class="content table-responsive table-full-width" style="max-height:400px; overflow-y:scroll">

                        <form action="/projects/{{$projectid}}/attendance/{{$date}}/post" method="POST" id="forms">
                            <table id="myTable" class="table table-hover table-striped tablesorter">
                                <thead>
                                    <th>Function</th>
                                    <th>Status</th>
                                    <th>Employee Name</th>
                                    <th>Attendance</th>

                                </thead>

                                <tbody id=table>

                                    @if(count($assignments)>0)
                                    @foreach($assignments as $assignment)
                                    <tr>
                                        <td>

                                        </td>
                                        <td>
                                            <button style="pointer-events: none;" type="button"
                                                class="btn btn-success btn-sm"> Assigned </button>
                                        </td>
                                        <td>
                                            {{$assignment->employeez->full_name}}
                                        </td>
                                        <td class='text-center'>
                                            @csrf
                                            <div class="radio text-center">
                                                <input type="radio" value="8" name='{{$assignment->assignmentid}}'
                                                    id='asswholeday{{$assignment->assignmentid}}'>
                                                <label for='asswholeday{{$assignment->assignmentid}}'>
                                                    Whole
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <input type="radio" value="4" name='{{$assignment->assignmentid}}'
                                                    id='asshalfday{{$assignment->assignmentid}}'>
                                                <label for='asshalfday{{$assignment->assignmentid}}'>
                                                    Half
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <input type="radio" value="0" name='{{$assignment->assignmentid}}'
                                                    id='assabsent{{$assignment->assignmentid}}'>
                                                <label for='assabsent{{$assignment->assignmentid}}'>
                                                    Absent
                                                </label>
                                            </div>

                                            <div style='padding:10px'>
                                                <input type='number' class='form-control'
                                                    name='custom{{$assignment->assignmentid}}'
                                                    id='asscustom{{$assignment->assignmentid}}' min="1" max="16">
                                            </div>

                                        </td>

                                    </tr>

                                    @endforeach

                                    @endif


                                    @if(!empty($summoned))
                                    @foreach($summoned as $summ)
                                    <tr id='{{$summ->summonid}}'>
                                        <td>
                                            {{-- <span class="mt-1 glyphicon pe-7s-close"
                                                style="font-size:25px; margin-left:15px; cursor: pointer;"
                                                onclick="deleteFunction({{$summ->summonid}})"></span> --}}
                                            <button onclick='deleteFunction({{$summ->summonid}})' type="button"
                                                rel="tooltip" title="" class="btn btn-danger btn-simple btn-md"
                                                data-original-title="Remove">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                        <td>

                                            <button style="pointer-events: none;" type="button"
                                                class="btn btn-info btn-sm">Summoned</button>
                                        </td>
                                        <td>
                                            {{$summ->assignmentz['employee_name']}}</td>
                                        <td>
                                            @csrf
                                            <div class="radio">
                                                <input type="radio" value="8" name={{'summonid:'.$summ->summonid}}
                                                    id='summwholeday{{$summ->summonid}}'>
                                                <label for='summwholeday{{$summ->summonid}}'>
                                                    Whole
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <input type="radio" value="4" name={{'summonid:'.$summ->summonid}}
                                                    id='summhalfday{{$summ->summonid}}'>
                                                <label for='summhalfday{{$summ->summonid}}'>
                                                    Half
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <input type="radio" value="0" name={{'summonid:'.$summ->summonid}}
                                                    id='summabsent{{$summ->summonid}}'>
                                                <label for='summabsent{{$summ->summonid}}'>
                                                    Absent
                                                </label>
                                            </div>

                                            <div style='padding:10px'>
                                                <input type='number' class='form-control'
                                                    name={{'customsummonid:'.$summ->summonid}}
                                                    id='summcustom{{$summ->summonid}}' min="1" max="16">
                                            </div>



                                        </td>


                                    </tr>
                                    @endforeach
                                    @endif
                                    @if(count($summoned)==0 && count($assignments)==0)
                                    <tr>
                                        <td colspan="4" class='text-center' onload="disabledSubmit()">
                                            All Attendances are Done
                                        </td>
                                    </tr>
                                    <script>
                                        $(document).ready(function()
                                        {
                                            console.log('disabled Submit worked');
                                            $('#submitForms').attr('disabled', true);
                                        })
                                      
                                    </script>
                                    @endif


                                </tbody>



                            </table>




                    </div>
                    <div class="content text-center">
                        <button type="submit" class="btn btn-primary btn-fill" id="submitForms">Submit</button>

                    </div>
                    </form>
                </div>

            </div>


            <div class="col-md-6" style="display:block">
                <div class="card">
                    <div class="header">

                        <h4 class="title text-center">Submitted DTR Records</h4>


                    </div>
                    <hr>

                    <div class="content table-responsive table-full-width" style="max-height:400px; overflow-y:scroll;">


                        <table id="myTable" class="table table-hover tablesorter">
                            <thead>
                                <th class='text-center'>Status</th>
                                <th>Employee</th>
                                <th>Time</th>
                            </thead>

                            <tbody id=table>

                                @if(count($dtrs)>0)
                                @foreach($dtrs as $dtr)
                                <tr id="{{$dtr->dtr_id}}">
                                    <td class='text-center'>
                                        @if($dtr->assignmentid==null)
                                        <i rel='tooltip' data-original-title='Summoned' data-placement='top'
                                            class="fa fa-user-plus"></i>
                                        @else
                                        <i rel='tooltip' data-original-title='Assigned' data-placement='top'
                                            class="fa fa-users"></i>
                                        @endif
                                    </td>
                                    <td>

                                        {{-- @if(count($dtr->assignmentid)>0) --}}
                                        {{$dtr->employee_name}}
                                    </td>
                                    <td>
                                        @csrf
                                        {{-- <fieldset>
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" value=wholeday
                                            name="{{$dtr->dtr_id}}">
                                        Whole
                                        </label>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" value='halfday'
                                                name="{{$dtr->dtr_id}}">
                                            Half
                                        </label>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" value='absent'
                                                name="{{$dtr->dtr_id}}">
                                            Absent
                                        </label>
                                        </fieldset> --}}

                                        @if($dtr->time == 8)
                                        <div>
                                            <button style="pointer-events: none;" type="button"
                                                class="btn btn-success btn-sm">Whole
                                                Day</button>

                                        </div>


                                        @elseif($dtr->time == 4)
                                        <div>
                                            <button style="pointer-events: none;" type="button"
                                                class="btn btn-info btn-sm">Half
                                                Day</button>
                                        </div>


                                        @elseif($dtr->time == 0)
                                        <div>
                                            <button style="pointer-events: none;" type="button"
                                                class="btn btn-danger btn-sm">Absent</button>
                                        </div>

                                        @else
                                        <div>
                                            <button style="pointer-events: none;" type="button"
                                                class="btn btn-danger btn-sm">{{$dtr->time}}</button>
                                        </div>
                                        @endif



                                    </td>
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
                    <div class="text-center content">

                        <button class='btn btn-secondary btn-fill' style="cursor:pointer" id="editAttendance"
                            data-target="#editAttendanceModal" data-toggle="modal">
                            Edit
                        </button>


                    </div>

                </div>
            </div>
        </div>


    </div>
</div>





<div class="modal fade" id="editAttendanceModal">
    <div class="modal-dialog">
        <div class="card text-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Edit Attendance</h3>
                </div>
                <div class="modal-body">
                    <div class="content table-responsive table-full-width" style="max-height:400px; overflow-y:scroll">

                        <form action="/projects/{{$projectid}}/attendance/{{$date}}/update" method="POST" id="forms">
                            <table id="myTable" class="table table-hover tablesorter">
                                <thead>
                                    <th></th>
                                    <th>Employee Name</th>
                                    <th>Attendance</th>
                                </thead>

                                <tbody id=table>
                                    @csrf
                                    @if(count($dtrs)>0)
                                    @foreach($dtrs as $dtr)
                                    <tr id="dtr{{$dtr->dtr_id}}">
                                        <td>
                                            {{-- <span class="mt-1 glyphicon pe-7s-close"
                                                style="font-size:25px; margin-left:15px; cursor: pointer;"
                                                onclick="deleteDTRFunction({{$dtr->dtr_id}})">

                                            </span> --}}
                                            <button onclick='deleteDTRFunction({{$dtr->dtr_id}})' type="button"
                                                rel="tooltip" title="" class="btn btn-danger btn-simple btn-sm"
                                                data-original-title="Remove">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                        <td>
                                            {{$dtr->employee_name}}
                                            {{-- {{$dtr}} --}}
                                        </td>
                                        <td>
                                            <div class='container'>
                                                <div class="radio">
                                                    <input type="radio" value="8" name='{{$dtr->dtr_id}}'
                                                        id='wholeday{{$dtr->dtr_id}}'>
                                                    <label for='wholeday{{$dtr->dtr_id}}'>
                                                        Whole
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <input type="radio" value="4" name='{{$dtr->dtr_id}}'
                                                        id='halfday{{$dtr->dtr_id}}'>
                                                    <label for='halfday{{$dtr->dtr_id}}'>
                                                        Half
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <input type="radio" value="0" name='{{$dtr->dtr_id}}'
                                                        id='absent{{$dtr->dtr_id}}'>
                                                    <label for='absent{{$dtr->dtr_id}}'>
                                                        Absent
                                                    </label>
                                                </div>
                                                <div style='padding:10px'>
                                                    <input type='number' class='form-control'
                                                        name='custom{{$dtr->dtr_id}}' id='custom{{$dtr->dtr_id}}'
                                                        min="1" max="16">
                                                </div>
                                            </div>

                                            {{-- <label class="form-check-label">

                                                    <input class="form-check-input" type="radio" value=wholeday
                                                        name="{{$dtr->dtr_id}}" @if($dtr->time == '1.0') checked
                                            @endif>
                                            Whole
                                            </label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" value='halfday'
                                                    name="{{$dtr->dtr_id}}" @if ($dtr->time == '0.5')checked
                                                @endif>
                                                Half
                                            </label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" value='absent'
                                                    name="{{$dtr->dtr_id}}" @if($dtr->time == '0.0') checked
                                                @endif>
                                                Absent
                                            </label> --}}
                                        </td>
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
                <div class="modal-footer d-flex justify-content-center">

                    <button type="submit" style="display:inline-block"
                        class="btn btn-primary btn-fill col-md-2">Confirm</button>

                    </form>
                    <button type="button" style="display:inline-block" class="btn btn-danger btn-fill col-md-2"
                        data-dismiss="modal" onclick='dismissFunction()'>Close</button>



                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="summonModal">
    <div class="modal-dialog">
        <div class="card text-center">
            <div class="modal-content">
                <div class="modal-header">

                    <div class="row text-center">
                        <div class="col-md-6">

                            <h3 class="title mt-2 ">Summoning</h3>

                        </div>

                        <div class="col-md-6">

                            <input class="form-control col-md-12" id="search" type="text" placeholder="Search..">

                        </div>


                    </div>

                </div>
                <div class="modal-body">
                    <div class="content table-responsive table-full-width" style="max-height:400px; overflow-y:scroll">

                        <form action="/projects/{{$projectid}}/attendance/{{$date}}/summon" method="POST" id="forms">
                            <table id="myTable" class="table table-hover tablesorter">
                                <thead>
                                    <th>Employees</th>
                                </thead>

                                <tbody id=table>

                                    @if(count($summon)>0)
                                    @foreach($summon as $sum)
                                    <tr>

                                        <td>
                                            <div class="d-flex justify-content-between bg-secondary">
                                                {{$sum->employee_name}}
                                                @csrf
                                                {{-- <label class="form-check-label">
                                                    <input id="summCheck" class="form-check-input" name='summon[]'
                                                        type="checkbox" value="{{$sum->assignmentid}}">
                                                Select
                                                </label> --}}
                                                <div class="checkbox">
                                                    <input id="checkbox{{$sum->assignmentid}}" name='summon[]'
                                                        type="checkbox" value="{{$sum->assignmentid}}" class="unassign">
                                                    <label for="checkbox{{$sum->assignmentid}}"></label>
                                                </div>
                                            </div>


                                        </td>

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
                <div class='modal-footer text-center'>
                    <button type="submit" style="display:inline-block"
                        class="btn btn-primary btn-fill col-md-2 pull-left">Confirm</button>

                    </form>
                    <button type="button" style="display:inline-block"
                        class="btn btn-secondary btn-fill col-md-2 pull-right" data-dismiss="modal">Close</button>
                </div>


                @if($date > Date('Y-m-d'))

                <script>
                    $(document).ready(function()
                    {
                        console.log('disabled Submit worked');
                        $('#submitForms').attr('disabled', true);
                    })
                  
                </script>
                @endif



            </div>
        </div>
    </div>
</div>

<script>
    $('#id').detach().appendTo('body');


</script>
<script>
    var modalhtml

    $('#toggleClicked').click(function()
    {
        modalhtml = $('#editAttendanceModal').detach();
        modalhtml.appendTo("body");

        modalhtml = $('#summonModal').detach();
        modalhtml.appendTo('body');
    });


    function inputDate(){
        $redirect = $('#dateAttendance').val();
        url=window.location.href;
        $back=(url.substring(0, url.lastIndexOf("/")+1));
        window.location.replace($back+$redirect)
    };
        
    $('#dateBtn').click(function (){
        inputDate();
    });

    function dateStepFunction(direction)
    {
        if(direction == 1)
        {
        document.getElementById("dateAttendance").stepUp(1);
        inputDate();
        }
        else if(direction == 0){
        document.getElementById("dateAttendance").stepDown(1);
        inputDate();
        }
    }

    function deleteFunction(summonid)
    {
        var responsa
        
        $('#'+summonid).fadeOut('fast');
        var realData = {
            "_token":'{{ csrf_token() }}',
            "summonid":summonid,
        };

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                $.ajax({
                    type: 'POST',
                    // headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: window.location.pathname+'/delete/'+summonid,
                    data: realData,
                    dataType: 'JSON',
                    crossDomain: true,
                    success:function(response){
                        // window.location=window.location.pathname;
                        console.log(response);

                        notification(response.success, 'danger')
                        
                    }
            })
    }

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

    var clicked = false;

    function deleteDTRFunction(dtrid)
    {
        // console.log('button clicked '+ dtrid);
        
        clicked = true;
        
        $('#'+dtrid).fadeOut('fast');
        $('#dtr'+dtrid).fadeOut('fast');
        
        var realData = {
            "_token":'{{ csrf_token() }}',
            "dtrid":dtrid,
        };

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                $.ajax({
                    type: 'POST',
                    // headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: window.location.pathname+'/deleteDTR/'+dtrid,
                    data: realData,
                    dataType: 'JSON',
                    crossDomain: true,
                    success:function(response){
                        
                    notification(response.success, 'success')
                        
                    }
            })
    }

    function dismissFunction()
    {
        console.log(clicked);
        switch(clicked){
            case true: 
            clicked = false;
            window.location=window.location.pathname;
            break;
            case false:
            clicked = false;
            break;  
        } 
    }
    
    $("#editAttendance").click(function(){
        modalhtml = $('#editAttendanceModal').detach();
        modalhtml.appendTo("body");
        $('[id^=custom]').removeAttr('name');
    });

    $('#summon').click(function()
    {
        modalhtml = $('#summonModal').detach();
        modalhtml.appendTo('body');
    });
</script>
<script>
    var container = [];
    $('.header').click(function()
    {
        $(':radio').prop('checked', false);
    });
</script>
<script>
    $('[id^=asscustom]').click(function(){
        $(this).attr('enabled', true);
        var selected = ($(this).attr('id'));
        selected = selected.substr(9);
        $(this).attr('name', 'asscustom'+selected)   
        $(':radio#assabsent'+selected).prop('checked', false);
        $(':radio#asswholeday'+selected).prop('checked', false);
        $(':radio#asshalfday'+selected).prop('checked', false);
    });
    $('[id^=summcustom]').click(function(){
        var selected2 = ($(this).attr('id'));

        selected2 = selected2.substr(10);
        $(this).attr('name', 'summcustom'+selected2)

        
        $(':radio#summwholeday'+selected2).prop('checked', false);
        $(':radio#summhalfday'+selected2).prop('checked', false);
        $(':radio#summabsent'+selected2).prop('checked', false);
        
    });
    $('[id^=custom]').click(function(){
        var selected2 = ($(this).attr('id'));
        selected2 = selected2.substr(6);
        $(this).attr('name', 'custom'+selected2)

        
        $(':radio#absent'+selected2).prop('checked', false);
        $(':radio#wholeday'+selected2).prop('checked', false);
        $(':radio#halfday'+selected2).prop('checked', false);
        
    });
    $('input[id^=asswholeday],[id^=assabsent],[id^=asshalfday]').click(function()
    {
        var selected = ($(this).attr('id'));
        selected = selected.replace(/\D/g,'');

        $('input[id=asscustom'+selected+']').val('');
        $('input[id=asscustom'+selected+']').removeAttr('name');
        //  $('input[id=asscustom'+selected+']').attr('disabled', true)
        // selected = selected.replace(/[a-z]/i, "");
    });
    $('input[id^=summwholeday],[id^=summhalfday],[id^=summabsent]').click(function()
    {
        var selected = ($(this).attr('id'));
        selected = selected.replace(/\D/g,'');

        $('input[id=summcustom'+selected+']').val('');
        $('input[id=summcustom'+selected+']').removeAttr('name');
    // console.log(selected);
    });
     $('input[id^=wholeday],[id^=halfday],[id^=absent]').click(function()
    {
        
        var selected = ($(this).attr('id'));
        selected = selected.replace(/\D/g,'');

        $('input[id=custom'+selected+']').val('');
        $('input[id=custom'+selected+']').removeAttr('name');
        // console.log('custom'+selected +'targeted');
    // console.log(selected);
    });
</script>
{{-- <script>
    $(document).ready(function()
    {
        d = new Date();
        d = d.toISOString();

        var newD=d.substr(0, 10);
        console.log(newD.valueOf())

       $('#')


    })
</script> --}}
<script>
    $(function() {
        $("#myTable").tablesorter();
    });
</script>

@endsection