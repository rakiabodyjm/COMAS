@extends('layouts.app')@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">

            @foreach($dtrs->pluck('date')->unique() as $pepe)
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <div class="row text-center">
                            <div class="col-xs-7 ">
                                <h4 class="title">{{date('F j, Y', strtotime($pepe))}}</h4>
                            </div>
                            <div class="col-xs-5">
                                <input class="form-control pull-right" id="search{{$pepe}}" type="text"
                                    placeholder="Search..">
                            </div>
                        </div>



                        <hr>
                    </div>

                    <div class="content table-responsive table-full-width" style='overflow-x:hidden;'>

                        <table id="myTable" class="table table-hover tablesorter">
                            <thead>
                                <th>Employee</th>
                                <th>Time</th>
                                <th>Pay</th>
                            </thead>

                            <tbody id='search{{$pepe}}'>
                                @foreach($dtrs->where('date', $pepe) as $poke)
                                <tr>
                                    <td>
                                        {{$poke->employee_name}}
                                    </td>
                                    <td>
                                        {{$poke->time}}
                                    </td>
                                    <td>{{$poke->pay/8 * $poke->time}}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
            @endforeach



        </div>
    </div>
</div>
<script>
    $(function() {
        $("#myTable").tablesorter();
    });
</script>
@endsection