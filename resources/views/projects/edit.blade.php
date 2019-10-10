@php($title = 'Project') @extends('layouts.app') @section('content')

<div class="content">

    <form method="post" action="{{route('projects.update', $projectsid)}}">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="card">

                    <div class="content">
                        <div class="row">
                            <div class="header pull-left">
                                <h4 class="title">
                                    Edit {{$title}}
                                </h4>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Project Name</label>
                                <input type="text" class="form-control" placeholder="Project Name"
                                    value="{{$project->projectname}}" name="projectname">
                            </div>


                            <div class="form-group col-md-6">
                                <label>Location</label>
                                <select class="form-control" name="location" id="location"
                                    value="{{$project->locationz->location}}">
                                    @foreach($locations as $location)
                                    <option value="{{$location->locationid}}">{{$location->location}}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="form-group col-md-6">
                                <label>Client</label>
                                <input type="text" class="form-control" placeholder="Client"
                                    value="{{$project->client}}" name="client">
                            </div>
                        </div>


                        <div class="row">

                            <div class="form-group col-md-6">
                                <label>Project Status</label>
                                <br>
                                @if ($project->status == 1)
                                {{Form::radio('status', '1', true, ['checked' => 'checked'])}} On Going
                                <br>
                                {{Form::radio('status', '0', [])}} Finished

                                @elseif($project->status == 0)

                                {{Form::radio('status', '1', [])}} On Going
                                <br>
                                {{Form::radio('status', '0', true, ['checked' => 'checked'])}} Finished
                                @endif

                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-info btn-fill">Edit Project</button>

                        </div>

                    </div>
                </div>
                <hr>
                <br>

                <div class="clearfix"></div>

            </div>

        </div>

        <div class="clearfix"></div>
    </form>

</div>
</div>
@endsection