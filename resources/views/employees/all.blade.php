@php($title = 'Employees')

@extends('layouts.app')
@section('content')

<div class="content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="title">Lists of All Employees</h4>
                                <div class="checkbox title">
                                    <input id="checker" name='check' type="checkbox" value='sanaall' checked>
                                    <label for="checker">Show All</label>
                                </div>


                            </div>

                            <div class="col-md-6">
                                <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                            </div>

                        </div>
                        <br>

                    </div>


                    <div class="content table-responsive table-full-width" style="overflow-y:scroll; height:580px;">

                        <table id="myTable" class="table table-hover table-striped tablesorter">
                            <thead>
                                <th>Full Name</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                                <th>Skill</th>
                                <th>Assignment</th>
                                <th>Active</th>
                            </thead>

                            <tbody id=table>


                                @if(count($employees)>0)
                                @foreach($employees as $employee)
                                @if($employee->active == 1)
                                <tr class='clickable-row' data-href='employees/summary/{{$employee->employeeid}}'>
                                    @else
                                <tr class='clickable-row' style='background-color: silver'
                                    data-href='employee/summary/{{$employee->employeeid}}'>
                                    @endif
                                    <td>{{$employee->full_name}}</td>
                                    <td>{{$employee->address}},
                                        @if($employee->locationz!=null){{$employee->locationz['location']}}
                                        @else @endif</td>
                                    <td>{{$employee->phoneno}}</td>
                                    <td>{{$employee->skillz->description}}</td>
                                    <td>
                                        {{$ass->where('employeeid', $employee->employeeid)->first()['project_name']}}

                                    </td>
                                    @if ($employee->active == 1)
                                    <td id='active'>
                                        Active
                                    </td>
                                    @elseif($employee->active == 0)
                                    <td id='inactive'>
                                        Inactive
                                    </td>
                                    @endif
                                    <td>
                                        <a class="edit-menu" href="/employees/{{$employee->employeeid}}/edit">
                                            <span class="pe-7s-edit">
                                            </span>
                                        </a>
                                    </td>

                                </tr>
                                @endforeach

                                @else
                                <tr>
                                    <td colspan="6" class='text-center'>
                                        No Employees Found
                                    </td>
                                </tr>

                                @endif

                            </tbody>
                        </table>

                    </div>
                    <div class="footer">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"> </i>
                            Total Employees:
                            {{count($employees)}}
                        </div>
                    </div>


                </div>
            </div>
        </div>





    </div>
</div>

<div class="modal fade" id="employee">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add Employee</h3>
            </div>
            <div class="modal-body">
                <form method="post" action="{{action('EmployeesController@store')}}" id="add-employee-form">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" placeholder="Last Name" value=""
                                    name="lastname">
                            </div>

                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" placeholder="First Name" value=""
                                    name="firstname">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Address</label>
                                    <input type="text" class="form-control" placeholder="Address" value=""
                                        name="address">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Town/City</label>
                                    <select name="location" id="" class="form-control">
                                        @foreach ($locations as $loc)
                                        <option value="{{$loc->locationid}}">{{$loc->location}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" class="form-control" placeholder="Contact Number" value=""
                                    name="phoneno">
                            </div>

                            <div class="form-group">
                                <label>Skill Assignment</label>
                                <select class="form-control" name="skill" id="skill">
                                    @foreach($skills as $skill)
                                    <option value="{{$skill->skillid}}">{{$skill->description}}</option>
                                    @endforeach
                                </select>
                            </div>




                        </div>

                    </div>


            </div>
            <div class="modal-footer text-center">

                <div onclick="editForm('add-employee-form')"
                    class="disabled btn btn-primary btn-fill col-md-2 pull-left">Add
                </div>
                <button type="button" class="btn btn-secondary btn-fill col-md-2 pull-right"
                    data-dismiss="modal">Close</button>


                </form>

            </div>
        </div>
    </div>
</div>


<script>
    $('#toggleClicked').click(function()
    {
        $('#employee').detach().appendTo('body');
    })
    $("#modalTrigger").click(function(){
        $('#employee').detach().appendTo('body');
})
</script>
<script>
    $('#checker').click(function()
   {
       if($(this).is(':checked'))
       {
         $('[id^=inactive]').closest('tr').show().fadeIn('fast');
       }
       else{
        $('[id^=inactive]').closest('tr').hide().fadeOut('fast');
       }
   })
    
   


    $(function() {
        $("#myTable").tablesorter();
    });

</script>

@endsection