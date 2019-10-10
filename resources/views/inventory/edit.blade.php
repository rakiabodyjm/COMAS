@php($title = 'Inventory') @extends('layouts.app') @section('content')

<div class="content">
    <div class="container-fluid">
        <form method="post" action="{{action('InventoriesController@update',$inventoryid)}}">
            @csrf {{ method_field('PATCH') }}

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">
                                Edit {{$title}}
                            </h4>

                        </div>

                        <div class="content">


                            <div class="form-group">


                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" value="{{$inventorys->name}}"
                                    name="name">

                                <br>

                                <label>Classification</label>
                                {{-- <tr>
                                    <td>
                                        <div class="radio">
                                            <input type="radio" value="Equipment" name=classification id='equipment'>
                                            <label for='equipment'>
                                                Equipment
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio">
                                            <input type="radio" value="Material" name=classification id='material'>
                                            <label for='material'>
                                                Material
                                            </label>
                                        </div>
                                    </td>
                                </tr> --}}
                                @if ($inventorys->classification == 'Equipment')
                                <div class="radio">
                                    <input type="radio" value='Equipment' name='classification' id='equipment' checked>
                                    <label for="equipment">Equipment</label>
                                </div>

                                <div class="radio">
                                    <input type="radio" value='Material' name='classification' id='material'>
                                    <label for="material">Material</label>
                                </div>

                                @elseif($inventorys->classification == 'Material')
                                <div class="radio">
                                    <input type="radio" value='Equipment' name='classification' id='equipment'>
                                    <label for="equipment">Equipment</label>
                                </div>

                                <div class="radio">
                                    <input type="radio" value='Material' name='classification' id='material' checked>
                                    <label for="material">Material</label>
                                </div>
                                @endif



                                <br>

                                <label>Quantity</label>
                                <input type="number" class="form-control" placeholder="Quantity"
                                    value="{{$inventorys->quantity}}" name="quantity">

                                <br>


                                <label>Restriction</label>
                                <select class="form-control" name="restrictionid">
                                    @if ($inventorys->skillz !=null)
                                    <option value="{{$inventorys->skillz->skillid}}">
                                        {{$inventorys->skillz->description}}</option>
                                    @else
                                    <option value=""></option>
                                    @endif
                                    @foreach($skills as $skill)
                                    <option value="{{$skill->skillid}}">{{$skill->description}}</option>
                                    @endforeach
                                </select>


                                <br>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-info btn-fill">Edit inventory</button>

                                </div>

                            </div>


                            <br>

                            <div class="clearfix"></div>

                        </div>

                    </div>
                </div>
                <div class="clearfix"></div>
        </form>


    </div>
</div>
@endsection
