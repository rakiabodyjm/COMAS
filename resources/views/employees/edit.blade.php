@php($title = $employee->full_name) @extends('layouts.app') @section('content')

<div class="content">
    <div class="container-fluid">
        <form method="post" action="{{action('EmployeesController@update', $employee)}}">
            @csrf {{ method_field('PATCH') }}

            <div class="row">
                <div class="col-md-5">
                    <div class="card">

                        <div class="content">
                            <div class="row">
                                <div class="header pull-left">
                                    <h4 class="title">
                                        Edit {{$title}} Information
                                    </h4>

                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" placeholder="Last Name"
                                        value="{{$employee->lname}}" name="lastname">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" placeholder="First Name"
                                        value="{{$employee->fname}}" name="firstname">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label>Address</label>
                                    <input type="text" class="form-control" placeholder="Address"
                                        value="{{$employee->address}}" name="address">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Location</label>
                                    @if($employee->locationz != null)
                                    <select class="form-control" name="location"
                                        value="{{$employee->locationz->location}}">
                                        @foreach($locations as $loc)
                                        @if($loc->location == $employee->locationz->location)
                                        <option selected="selected" value="{{$loc->locationid}}">{{$loc->location}}
                                        </option>
                                        @else
                                        <option value="{{$loc->locationid}}">{{$loc->location}}</option>
                                        @endif
                                        @endforeach
                                    </select>

                                    @else

                                    <select class="form-control" name="location">
                                        @foreach($locations as $loc)
                                        @if($loc->location == $employee->locationz['location'])
                                        <option selected="selected" value="{{$loc->locationid}}">{{$loc->location}}
                                        </option>
                                        @else
                                        <option value="{{$loc->locationid}}">{{$loc->location}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @endif

                                </div>


                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Skill Assignment</label>
                                    <select class="form-control" name="skill" id="skill"
                                        value="{{$employee->skillz->description}}">
                                        @foreach($skills as $skill)
                                        @if($skill->description == $employee->skillz->description)
                                        <option selected="selected" value="{{$skill->skillid}}">{{$skill->description}}
                                        </option>
                                        @else
                                        <option value="{{$skill->skillid}}">{{$skill->description}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control" placeholder="Contact Number"
                                        value="{{$employee->phoneno}}" name="phoneno">
                                </div>

                            </div>

                            <div class='text-center'>

                                @if($employee->active == 0)
                                <div class="radio">
                                    <input type="radio" value='1' name='active' id='radioactive'>
                                    <label for="radioactive">Active</label>
                                </div>
                                <div class="radio">
                                    <input type="radio" value='0' name='active' id='radio0' checked>
                                    <label for="radio0">Inactive</label>
                                </div>
                                @else
                                <div class="radio">
                                    <input type="radio" value='1' name='active' id='radioactive' checked>
                                    <label for="radioactive">Active</label>
                                </div>
                                <div class="radio">
                                    <input type="radio" value='0' name='active' id='radio0'>
                                    <label for="radio0">Inactive</label>
                                </div>
                                @endif




                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-info btn-fill">Edit Employee</button>

                            </div>

                        </div>
                    </div>
                    <hr>
                    <br>

                    <div class="clearfix"></div>

                </div>

            </div>
    </div>
    <div class="clearfix"></div>
    </form>


</div>
</div>
@endsection