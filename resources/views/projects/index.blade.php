@php($title = 'Projects')

@extends('layouts.app')
@section('content')
<div class="content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12" style="min-width: 180px;">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Current Projects</h4>
                    </div>
                    <div class="content">

                        <div class="row">
                            @if(count($projects)>0)
                            @foreach($projects as $project)


                            <div class='col-md-3'>
                                <a href='projects/{{$project->projectid}}'>
                                    <div class="card card-shadow">

                                        <div class='header'>
                                            <div class="row">
                                                <i class="pe-7s-culture"
                                                    style='font-size: 70px;margin-left:10px;color:black'></i>
                                                <div class="col-md-8">
                                                    <h4 class="title">{{$project->projectname}}</h4>
                                                </div>
                                            </div>

                                        </div>

                                        <div class='content' style="padding-top:0">
                                            <div class="footer">
                                                <hr>
                                                <div class="stats">
                                                    <i class="fa fa-refresh"> </i>
                                                    Last DTR Record:
                                                    @foreach($peps->where('projectid',$project->projectid)->sortBy('date'
                                                    ) as $pep)
                                                    @if($loop->last)
                                                    {{date('F j, Y', strtotime($pep->date))}}
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </a>

                            </div>

                            {{-- <div class="col-md-4" style="min-width: 150px;">
                                <a href="projects/{{$project->projectid}}">
                            <div class="card">
                                <div class="title">
                                    <div class="image" style="max-height:100px">
                                        <img src="{{asset('img/project.jpg')}}">
                                    </div>
                                    <h5 class="header text-center" style="margin-bottom:2px;">
                                        {{$project->projectname}}</h5>
                                    <h5 class="title text-center">
                                        <small>{{$project->client}}</small><br>
                                    </h5>
                                    <p class="description text-center" style="font-size: 13px;">

                                    </p>
                                </div>

                                <div class="content">

                                </div>
                            </div>
                            </a>

                        </div> --}}
                        {{-- <div class="col-md-4">
                            <div class="card bg-dark text-white">
                                <img src='' class='card-img' alt=''>
                                <div class="card-img-overlay">
                                    <h5 class="card-title">{{$project->projectname}}</h5>
                        <p class="card-text">Last payroll {{$project->projectz}}</p>
                    </div>
                </div>
            </div> --}}

            @endforeach

            @else
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">No Projects found</h4>
                    </div>
                    <div class="content">

                    </div>
                </div>
            </div>
            @endif

        </div>


    </div>
</div>
</div>
</div>





</div>
</div>
@endsection