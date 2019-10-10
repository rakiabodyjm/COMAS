@extends('layouts.app') @section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-3">

            </div>
            <div class="col-xs-6">
                <div class="card">
                    <div class="header">


                        <h4 class="title">Assignment Histories</h4>


                    </div>

                    <div class="content table-responsive table-full-width" style="max-height:400px; overflow-y:scroll">

                        <table id="myTable" class="table table-hover tablesorter">
                            <thead>
                                <th>Project</th>
                                <th>Date Assigned</th>
                            </thead>

                            <tbody id=table>

                                @csrf @if(count($assignments)>0) @foreach($assignments as $assignment)
                                <tr>
                                    <td>{{$assignment->projectz->projectname}}</td>
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

            <div class="col-xs-3">
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