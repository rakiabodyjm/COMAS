@php($title = 'Locations') 
@extends('layouts.app') 
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">

                    <div class="content">
                        <div class="header">
                            <h4 class="title text-center">
                                    Edit {{$title}}
                                </h4>
                        </div>
                        <hr>
                        <br>

                        <form method="post" action="{{action('LocationsController@update', $location)}}">
                            @csrf {{ method_field('PATCH') }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" class="form-control" placeholder="Location" value="{{$location->location}}" name="location">
                                    </div>

                                    <div class="form-group">
                                        <label>Location Rate</label>
                                        <input type="text" class="form-control" placeholder="Salary" value="{{$location->province}}" name="locationsalary">
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill">Edit Location</button>

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