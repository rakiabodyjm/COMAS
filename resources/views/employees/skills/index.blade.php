@php($title = 'Skills') @extends('layouts.app') @section('content')
<div class="content">

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8">

                <div class="card">
                    <div class="header">
                        <div class="col-xs-7">
                            <h4 class="title">
                                All Skills and their Respective Salaries
                            </h4>
                        </div>
                        <div class="col-xs-5">
                            <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                        </div>
                    </div>

                    <div class="content table-responsive table-full-width">
                        <table id="myTable" class="table table-hover table-striped tablesorter">
                            <thead>
                                <th>Description</th>
                                <th>Salary</th>
                                <th>Active</th>
                                <th></th>
                            </thead>

                            <tbody id="table">

                                @if(count($skills)>0) @foreach($skills as $skill)
                                <tr>
                                    <td>{{$skill->description}}</td>
                                    <td>₱{{$skill->salaryrate}}</td>

                                    <td>
                                        @if ($skill->active == 1) Active @elseif($skill->active == 0) Inactive @endif
                                    </td>
                                    <td>
                                        <a class="edit-menu" href="skills/{{$skill->skillid}}/edit">
                                            <span class="pe-7s-edit">
                                            </span>
                                        </a>
                                    </td>

                                </tr>
                                @endforeach @else
                                <tr>
                                    <td colspan="4" class="text-center">No Skills Found</td>
                                </tr>

                                @endif

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="header text-center">
                        <h4>
                            Add Skill
                        </h4>
                    </div>
                    <div class="content">
                        {{-- <button type="button" class="btn btn-info btn-fill col-xs-12 container-fluid"
                            data-toggle="collapse" data-target="#collapse" style="white-space:">Create Skill
                        </button> --}}



                        <form method="post" action="{{action('SkillsController@store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Skill Name</label>
                                        <input type="text" class="form-control" placeholder="Description" value=""
                                            name="skilldescription">
                                    </div>

                                    <div class="form-group">
                                        <label>Skill Salary</label>
                                        <input type="text" class="form-control" placeholder="Salary" value=""
                                            name="skillsalary">
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill">Create New
                                            Skill</button>

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
</div>
<script>
    $(function() {
        $("#myTable").tablesorter();
    });
</script>

@endsection