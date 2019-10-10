@php($title = 'Inventory')

@extends('layouts.app')
@section('content')
<div class="content">

    <div class="container-fluid">
        <div class="row">

            <div class="col-xs-7">

                <div class="card">
                    <div class="header">
                        <div class="col-xs-7">
                            <h4 class="title">
                                Inventory Summary
                            </h4>
                        </div>
                        <div class="col-xs-5">
                            <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                        </div>
                    </div>

                    <div class="content table-responsive table-full-width" style="overflow-y:scroll; max-height:580px;">
                        <table class="table table-hover table-striped tablesorter" id="myTable">
                            <thead>
                                <th>Name</th>
                                <th>Classification</th>
                                <th>Quantity</th>
                                <th>Restrictions</th>
                            </thead>

                            <tbody id=table>


                                @if(count($inventorys)>0)
                                @foreach($inventorys as $inventory)
                                <tr>
                                    <td>{{$inventory->name}}</td>
                                    <td>{{$inventory->classification}}</td>
                                    <td>{{$inventory->quantity}}</td>
                                    @if($inventory->skillz==null)

                                    <td>No Restriction</td>
                                    @else
                                    <td>{{$inventory->skillz['description']}}</td>
                                    @endif
                                    <td>
                                        <a class="edit-menu" href="inventory/{{$inventory->inventoryid}}/edit">
                                            <span class="pe-7s-edit">
                                            </span>
                                        </a>
                                    </td>

                                </tr>
                                @endforeach

                                @else
                                <tr>
                                    <td colspan="5" class='text-center'>
                                        No inventory Found
                                    </td>
                                </tr>

                                @endif

                            </tbody>
                        </table>

                    </div>
                    <div class="footer">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"> </i>
                            Total Inventories:
                            {{count($inventorys)}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-5">
                <div class="card">
                    <div class="content">
                        <button type="button" class="btn btn-fill btn-info col-xs-12 container-fluid"
                            data-toggle="collapse" data-target="#collapse" style="white-space:">
                            Add Inventory
                        </button>
                        <hr>
                        <br>

                        <div id="collapse" class="collapse">
                            <form method="post" action="{{action('InventoriesController@store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label>Inventory Name</label>
                                            <input type="text" class="form-control" placeholder="Inventory Name"
                                                value="" name="name">
                                        </div>

                                        {{-- <div class="form-group">
                                            <label>Classification</label>
                                            <select class="form-control" name="classification" id="classification"
                                            value="{{$inventory->classification}}">

                                        @foreach($inventorys as $inventory)
                                        <option value=>{{$inventory->classification}}</option>
                                        @endforeach
                                        </select>

                                        {{-- <input type="text" class="form-control" placeholder="Classification" value=""
                                                name="classification">
                                    </div> --}}
                                        <div class="form-group">
                                            <label>Classification</label>
                                            <tr>
                                                <td>
                                                    <div class="radio">
                                                        <input type="radio" value="Equipment" name=classification
                                                            id='equipment'>
                                                        <label for='equipment'>
                                                            Equipment
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="radio">
                                                        <input type="radio" value="Material" name=classification
                                                            id='material'>
                                                        <label for='material'>
                                                            Material
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>



                                        </div>

                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control" placeholder="Quantity" value=""
                                                name="quantity">
                                        </div>


                                        <div class="form-group">
                                            <label>Restriction</label>
                                            <select class="form-control" name="restrictionid" id="skill">
                                                <option value=''></option>
                                                @foreach($skills as $skill)
                                                <option value="{{$skill->skillid}}">{{$skill->description}}</option>
                                                @endforeach
                                            </select>
                                        </div>





                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info btn-fill">Add New
                                                Inventory</button>

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
