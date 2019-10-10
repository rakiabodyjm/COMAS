@php($title = 'Logs')
@extends('layouts.app')
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-10">
                <div class="card">
                    <div class="header">
                        <div class="col-xs-7">
                            <h4 class="title">
                                Activity Logs
                            </h4>
                        </div>
                        <div class="col-xs-5">
                            <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                        </div>
                    </div>

                    <div class="content table-responsive table-full-width" style="overflow-y:scroll; max-height:580px;">
                        <table id="myTable" class="table table-hover table-striped tablesorter">
                            <thead>
                                <th>Table Name</th>
                                <th>Activity</th>
                                <th>Time</th>
                                <th>User</th>
                            </thead>
                            <tbody id="table">
                                @foreach($log as $logzz)
                                <tr>
                                    <td>{{$logzz->tblname}}</td>
                                    <td>{{$logzz->activity}}</td>
                                    <td>{{$logzz->time}}</td>
                                    <td>{{$logzz->user}}</td>
                                </tr>


                                @endforeach
                            </tbody>
                        </table>
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
