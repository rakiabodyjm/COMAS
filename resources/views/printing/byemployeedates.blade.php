@extends('layouts.app')@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">

            @foreach($dtrs->pluck('project_name')->unique() as $pepe)
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <div class="row text-center">
                            <div class="col-xs-7 ">
                                <h4 class="title">{{$pepe}}</h4>
                            </div>
                            <div class="col-xs-5">
                                <input class="form-control pull-right" id="search{{str_replace(' ', '', $pepe)}}"
                                    type="text" placeholder="Search..">
                            </div>
                        </div>



                        <hr>
                    </div>

                    <div class="content table-responsive table-full-width">

                        <table id="myTable" class="table table-hover tablesorter">
                            <thead>
                                <th>Employee</th>
                                <th>Time</th>
                                <th>Pay</th>
                            </thead>

                            <tbody id='search{{str_replace(' ', '', $pepe)}}'>
                                @foreach($dtrs->where('project_name', $pepe) as $poke)
                                <tr>
                                    <td>
                                        {{date('F j, Y', strtotime($poke->date))}}
                                    </td>
                                    <td>
                                        {{$poke->time}}
                                    </td>
                                    <td>
                                        {{$poke->pay/8 * $poke->time}}
                                    </td>
                                </tr>

                                @endforeach

                                <tr>
                                    <td></td>
                                    <td>
                                        <b>{{$dtrs->where('project_name', $pepe)->sum('time')}}</b>
                                    </td>
                                    <td>
                                        <b>{{$dtrs->where('project_name', $pepe)->sum('time') * $poke->pay/8}}</b>
                                    </td>
                                </tr>

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