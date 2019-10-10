@php($title = 'Employees')

@extends('layouts.app')
@section('content')

<div class="content">

    <div class="container-fluid">


        <div class="row">



            <div class="col-xs-6">
                <div class="card">

                    <div class="content">
                        <button type="button" class="btn btn-fill btn-info col-xs-12 container-fluid"
                            data-toggle="collapse" data-target="#collapse" style="white-space:">
                            Add Employee
                        </button>
                        <hr>
                        <br>
                        <div id="collapse" class="collapse">

                            <form method="post" action="{{action('EmployeesController@store')}}">
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
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" placeholder="Address" value=""
                                                name="address">
                                        </div>

                                        <div class="form-group">
                                            <label>Contact Number</label>
                                            <input type="text" class="form-control" placeholder="Contact Number"
                                                value="" name="phoneno">
                                        </div>

                                        <div class="form-group">
                                            <label>Skill Assignment</label>
                                            <select class="form-control" name="skill" id="skill">
                                                @foreach($skills as $skill)
                                                <option value="{{$skill->skillid}}">{{$skill->description}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <button type="submit" class="btn btn-success btn-fill col-xs-12"
                                            style="text-align: center">Add New Employee</button>



                                    </div>

                                </div>


                            </form>

                        </div>

                    </div>
                </div>

            </div>





        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="col-xs-8">
                            <h4 class="title">Lists of All Employeeasdasds</h4>

                        </div>

                        <div class="col-xs-4">
                            <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                        </div>
                        <hr>
                    </div>

                    <div class="content table-responsive table-full-width"
                        style="overflow-y:scroll; height:330px; display:block;">

                        <table id="myTable" class="table table-hover table-striped tablesorter">
                            <thead>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                                <th>Skill</th>
                                <th>Active</th>
                            </thead>

                            <tbody id=table>


                                @if(count($employees)>0)
                                @foreach($employees as $employee)
                                <tr>
                                    <td>{{$employee->lname}}</td>
                                    <td>{{$employee->fname}}</td>
                                    <td>{{$employee->address}}</td>
                                    <td>{{$employee->phoneno}}</td>
                                    <td>{{$employee->skillz->description}}</td>
                                    <td>
                                        @if ($employee->active == 1)
                                        Active
                                        @elseif($employee->active == 0)
                                        Inactive
                                        @endif
                                    </td>
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
                                    <td colspan="5" class='text-center'>
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

<script>
    $(function() {
        $("#myTable").tablesorter();
    });
</script>

@endsection