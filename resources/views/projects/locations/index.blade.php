@php($title = 'Locations')

@extends('layouts.app')
@section('content')

<div class="content">

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <p class="category">
                            <input class="form-control" id="search" type="text" placeholder="Search..">
                        </p>
                    </div>

                    <div class="content">

                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <h4 class="title">Lists of Locations and Rates</h4>
                    </div>

                    <div class="content table-responsive table-full-width">
                        <table id="myTable" class="table table-hover table-striped tablesorter">
                            <thead>
                                <th>Location</th>
                                <th>Salary Rate</th>
                            </thead>

                            <tbody id="table">

                                @if(count($locations)>0)
                                @foreach($locations as $location)
                                <tr>
                                    <td>{{$location->location}}</td>
                                    <td>₱{{$location->locationrate}}</td>
                                    <td>
                                        <a class="edit-menu" href="locations/{{$location->locationid}}/edit">
                                            <span class="pe-7s-edit">
                                            </span>
                                        </a>
                                    </td>

                                </tr>
                                @endforeach

                                @else
                                <tr>
                                    <td colspan="4" class="text-center">No Locations Found</td>
                                </tr>

                                @endif

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="header text-center">
                        <h4 class="title">Add new Location</h4>
                    </div>
                    <div class="content">



                        <form method="post" action="{{action('LocationsController@store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Location Name</label>
                                        <input type="text" class="form-control" placeholder="Location" value=""
                                            name="location">
                                    </div>

                                    <div class="form-group">
                                        <label>Location Additional Salary</label>
                                        <input type="number" class="form-control" placeholder="Salary" value=""
                                            name="locationsalary">
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill">Create New location</button>
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