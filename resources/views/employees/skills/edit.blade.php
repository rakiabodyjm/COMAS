@php($title = 'Skills') @extends('layouts.app') @section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <!--<div class="header">
                                <p class="category">Create Skill</p>
                        </div>-->
                    <div class="content">
                        <div class="header">
                            <h4 class="title text-center">
                                Edit {{$title}}
                            </h4>
                        </div>
                        <hr>
                        <br>

                        <form method="post" action="{{action('SkillsController@update', $skill)}}">
                            @csrf {{ method_field('PATCH') }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Skill Name</label>
                                        <input type="text" class="form-control" placeholder="Description"
                                            value="{{$skill->description}}" name="skilldescription">
                                    </div>

                                    <div class="form-group">
                                        <label>Skill Salary</label>
                                        <input type="text" class="form-control" placeholder="Salary"
                                            value="{{$skill->salaryrate}}" name="skillsalary">
                                    </div>

                                    <div class="form-group">
                                        <label>Skill Active </label>
                                        <br>

                                        <div class="form-check form-check-radio">

                                            @if ($skill->active == 1)
                                            <div class="radio">
                                                <input type="radio" value='1' name='active' id='radioactive' checked>
                                                <label for="radioactive">Active</label>
                                            </div>
                                            {{-- <input class="form-check-input" type="radio" name="active" value="1" checked>Active --}}
                                            <div class="radio">
                                                <input type="radio" value='0' name='active' id='radio0'>
                                                <label for="radio0">Inactive</label>
                                            </div>

                                            @elseif($skill->active == 0)
                                            <div class="radio">
                                                <input type="radio" value='1' name='active' id='radioactive'>
                                                <label for="radioactive">Active</label>
                                            </div>
                                            {{-- <input class="form-check-input" type="radio" name="active" value="1" checked>Active --}}
                                            <div class="radio">
                                                <input type="radio" value='0' name='active' id='radio0' checked>
                                                <label for="radio0">Inactive</label>
                                            </div>
                                            @endif


                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-info btn-fill">Edit Skill</button>

                            </div>

                    </div>

                </div>

                <div class="clearfix"></div>
                </form>

            </div>
        </div>
    </div>
</div>
</div>
@endsection