@extends('layouts.app') @section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-5">
                <div class="card">
                    <div class="header">

                        <div class="col-xs-7">
                            <h4 class="title">Employees</h4>
                        </div>
                        <div class="col-xs-5">
                            <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                        </div>




                    </div>

                    <div class="content table-responsive table-full-width" style="max-height:400px;">

                        <table id="myTable" class="table table-hover tablesorter">
                            <thead>
                                <th>Employee</th>
                                <th>Skill</th>
                                <th>Date Assigned</th>
                            </thead>

                            <tbody id=table>

                                @csrf @if(count($assignments)>0) @foreach($assignments as $assignment)
                                <tr class="clickable-row"
                                    data-href="/projects/{{$projectid}}/{{$assignment->employeez->employeeid}}">
                                    <td>{{$assignment->employeez->lname}}, {{$assignment->employeez->fname}}</td>
                                    <td>{{$assignment->employeez->skillz->description}}</td>
                                    <td>{{$assignment->date}}</td>
                                    {{-- <td>{{$assignment->projectz->projectname}}</td> --}}
                                </tr>
                                @endforeach @else
                                <tr>
                                    <td colspan="3" class='text-center'>
                                        No Employees Found
                                    </td>
                                </tr>

                                @endif

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

            <div class="col-xs-8">
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