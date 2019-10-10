@php($title = 'Projects')

@extends('layouts.app')
@section('content')
<div class="content">

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-7">

                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="title">
                                    All Projects
                                </h4>
                            </div>
                            <div class="col-md-5">
                                <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="content table-responsive table-full-width">
                        <table id="myTable" class="table table-hover table-striped tablesorter">
                            <thead>
                                <th>Project Name</th>
                                <th>Location</th>
                                <th>Client</th>
                                <th>Status</th>
                            </thead>

                            <tbody id=table>


                                @if(count($projects)>0)
                                @foreach($projects as $project)
                                <tr>
                                    <td>{{$project->projectname}}</td>
                                    <td>{{$project->locationz->location}}</td>
                                    <td>{{$project->client}}</td>

                                    <td>
                                        @if ($project->status == 1)
                                        On going
                                        @elseif($project->status == 0)
                                        Finished
                                        @endif
                                    </td>
                                    <td>
                                        <a class="edit-menu" href="/projects/{{$project->projectid}}/edit">
                                            <span class="pe-7s-edit">
                                            </span>
                                        </a>
                                    </td>

                                </tr>
                                @endforeach

                                @else
                                <tr>
                                    <td colspan="5" class='text-center'>
                                        No projects Found
                                    </td>
                                </tr>

                                @endif

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

            <div class="col-md-5">
                <div class="card">
                    <div class="content">
                        <button type="button" class="btn btn-fill btn-info col-xs-12 container-fluid"
                            data-toggle="collapse" data-target="#collapse" style="white-space:">
                            Add Project
                        </button>
                        <hr>
                        <br>

                        <div id="collapse" class="collapse">
                            <form method="post" action="{{action('ProjectsController@store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label>Project Name</label>
                                            <input type="text" class="form-control" placeholder="Project Name" value=""
                                                name="projectname">
                                        </div>


                                        <div class="form-group">
                                            <label>Location</label>
                                            <select class="form-control" name="location" id="location">
                                                @foreach($locations as $location)
                                                <option value="{{$location->locationid}}">{{$location->location}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Client</label>
                                            <input type="text" class="form-control" placeholder="Client" value=""
                                                name="client">
                                        </div>



                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info btn-fill">Add New Project</button>

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
</div>
<script>
    $(function() {
        $("#myTable").tablesorter();
    });
</script>
@endsection