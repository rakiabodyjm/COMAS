@php($title = 'Inventory Transfers')

@extends('layouts.app')
@section('content')
<div class="content">

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <a class="navbar-brand" onclick="clicked('all')" href="#"
                                    style='color:black'>Inventory</a>
                            </div>

                            <ul class="nav navbar-nav">
                                <li><a href="#" onclick="clicked('equipment')">Equipment</a></li>
                                <li><a href="#" onclick="clicked('material')">Material</a></li>

                            </ul>

                        </nav>
                    </div>
                    <div id='containerz' class="content table-responsive table-full-width"
                        style="overflow-y:scroll; max-height:480px;">

                        <table class="table table-hover table-striped tablesorter" id="equipmentTable">
                            <thead>
                                <th>Equipment Name</th>
                                <th>Project Name</th>
                                <th>Employee</th>
                                <th>Quantity</th>
                                <th>Date</th>
                            </thead>

                            <tbody id=eqTable>


                                @if(count($ifEquipment)>0)
                                @foreach($ifEquipment as $eq)
                                <tr>
                                    <td>{{$eq->inventoryz['name']}}</td>
                                    @if($eq->project1!=null)
                                    <td>{{$eq->project1->projectname}}</td>
                                    @else
                                    <td>Employee has no Project</td>
                                    @endif
                                    <td>{{$eq->employeez['full_name']}}</td>
                                    <td>{{$eq->quantity}}</td>
                                    <td>{{date('F j, Y'), strtotime($eq->date)}}</td>


                                    <td><a class="edit-menu" data-target='#manageInventory' data-toggle="modal"
                                            onclick='manageModal({{$eq->transferid}})'>
                                            <span class="pe-7s-edit">
                                            </span>
                                        </a>
                                    </td>


                                </tr>
                                @endforeach

                                @else
                                <tr>
                                    <td colspan="5" class=' text-center'>
                                        No inventory record Found
                                    </td>
                                </tr>

                                @endif

                            </tbody>
                        </table>

                        <table class="table table-hover table-striped tablesorter" id="materialTable">
                            <thead>
                                <th>Material Name</th>
                                <th>Project Name</th>
                                <th>Employee</th>
                                <th>Quantity</th>
                                <th>Date</th>
                            </thead>

                            <tbody id="matTable">


                                @if(count($ifMaterial)>0)
                                @foreach($ifMaterial as $inv)
                                <tr>
                                    <td>{{$inv->inventoryz['name']}}</td>
                                    @if($inv->project1['projectname']!=null)
                                    <td>{{$inv->project1->projectname}}</td>
                                    @else
                                    <td>Employee Has no Project</td>
                                    @endif
                                    <td>{{$inv->employeez['full_name']}}</td>
                                    <td>{{$inv->quantity}}</td>

                                    <td>{{date('F j, Y'), strtotime($inv->date)}}</td>


                                    <td>
                                        <a class="edit-menu" data-target='#manageInventory' data-toggle="modal"
                                            onclick="manageModal({{$inv->transferid}})">
                                            <span class="pe-7s-edit">
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="edit-menu" data-target='#trashModal' data-toggle="modal"
                                            onclick="trashModal({{$inv->transferid}})">
                                            <span class="pe-7s-trash">
                                            </span>
                                        </a>
                                    </td>


                                </tr>
                                @endforeach

                                @else
                                <tr>
                                    <td colspan="5" class='text-center'>
                                        No inventory record Found
                                    </td>
                                </tr>

                                @endif

                            </tbody>
                        </table>

                    </div>



                </div>
            </div>


            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-xs-7">
                                <h4 class="title">
                                    Available Inventories
                                </h4>
                            </div>
                            <div class="col-xs-5">
                                <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                            </div>
                        </div>

                    </div>
                    <div class="content table-responsive table-full-width" style="overflow-y:scroll; max-height:480px;">
                        <table class="table table-hover table-striped tablesorter" id="myTable">
                            <thead>

                                <th>Name</th>
                                <th>Classification</th>
                                <th>Quantity</th>
                                <th>Restrictions</th>
                            </thead>

                            <tbody id=table>


                                @if(count($inventory)>0)
                                @foreach ($inventory as $i)
                                <tr>


                                    <td>{{$i->name}}</td>
                                    <td>{{$i->classification}}</td>
                                    <td>{{$i->quantity}}</td>

                                    @if($i->skillz==null)

                                    <td>No Restriction</td>
                                    @else
                                    <td>{{$i->skillz['description']}}</td>
                                    @endif
                                    @endforeach
                                    @else
                                    <td>No inventory Found</td>
                                    @endif

                                </tr>
                            </tbody>
                        </table>

                        <div class="footer">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-refresh"> </i>
                                Total Inventory:
                                {{count($inventory)}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>



    </div>
    <script>

    </script>
    <div class='modal' id="manageInventory">
        <div class="modal-dialog">
            <div class="card text-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Transfer or Return Item</h3>
                    </div>
                    <div class="modal-body">
                        <div class="content">


                            <form method="post" action="/inventorytransfer/inventorytransfer/transfer">
                                @csrf
                                <div class="row">
                                    <div class='col-md-12'>

                                        <div class="card">

                                            <div class='header'>
                                                <div class="row">
                                                    <i class="pe-7s-cart"
                                                        style='font-size: 70px;margin-left:20px;color:black'></i>
                                                    <div class="col-md-8">
                                                        <h4 class="title" id='itemName'></h4>
                                                        <label id='employeeName'></label>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-hover table-striped tablesorter">
                                                    <thead>
                                                        <th class='text-center'>Project Name</th>
                                                        <th class='text-center'>Quantity</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id='projectName'>
                                                                {{-- {{$inventory->project1->projectname}} --}}

                                                            </td>
                                                            <td id='quantity'>
                                                                {{-- <input type='number' value={{$inventory->quantity}}
                                                                min='0'
                                                                max="{{$inventory->quantity}}"> --}}
                                                                {{-- {{$inventory->quantity}} --}}

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="footer">
                                                <div class="radio">
                                                    <input type="radio" value='transfer'
                                                        onclick="showSelected('transfer')" name='lyra'
                                                        id='radioTransfer' checked>
                                                    <label for="radioTransfer">Transfer</label>
                                                </div>
                                                <div class="radio">
                                                    <input type="radio" value='return' onclick="showSelected('return')"
                                                        name='lyra' id='radioReturn' checked>
                                                    <label for="radioReturn">Return</label>
                                                </div>

                                            </div>
                                            <input id='transferid' type='hidden' name='transferid' value=''>
                                            <input id='inventoryid' type='hidden' name='inventoryid' value=''>
                                            <script>
                                                function showSelected(which)
                                                    {

                                                        if(which == 'transfer')
                                                        {
                                                            $('#returnSelected').fadeOut(0);
                                                            $('#transferSelected').fadeIn(0);

                                                        }else{
                                                            $('#returnSelected').fadeIn(0);
                                                            $('#transferSelected').fadeOut(0);

                                                        }

                                                    }
                                            </script>

                                            <div id="transferorreturn">



                                            </div>
                                            <div id="transferSelected">

                                                <div class="form-group col-md-12">
                                                    <label>Transfer To</label>
                                                    <select class="form-control" name="project" id="projectName">
                                                        @foreach($projects as $project)
                                                        <option value="{{$project->projectid}}">
                                                            {{$project->projectname}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>






                                            </div>
                                            <div id="returnSelected">


                                            </div>
                                            <div class="form-group col-md-12">
                                                <label> Confirm Quantity</label>
                                                <input id='quantityInput' onload='getQuantity()' class='form-control'
                                                    type='number' name="quantity" min="1">

                                            </div>


                                            <div class="modal-footer d-flex justify-content-center">

                                                <button type="submit" style="display:inline-block"
                                                    class="btn btn-primary btn-fill col-md-2">Confirm</button>

                                                <button type="button" style="display:inline-block"
                                                    class="btn btn-danger btn-fill col-md-2"
                                                    data-dismiss="modal">Close</button>
                                            </div>

                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>


        <script>
            function clicked(which)
                {
                    if(which == 'equipment')
                    {
                        $('#materialTable').fadeOut(0);
                        $('#equipmentTable').fadeIn(0);
                    }else if(which=='all')
                    {
                        $('#materialTable').fadeIn(0);
                        $('#equipmentTable').fadeIn(0);
                    }
                    else
                    {
                        $('#materialTable').fadeIn(0);
                        $('#equipmentTable').fadeOut(0);
                    }
                }
        </script>

    </div>


    <div class='modal' id="trashModal">
        <div class="modal-dialog">
            <div class="card text-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Remove Used Materials</h3>
                    </div>
                    <div class="modal-body">
                        <div class="content">


                            <form method="post" action="/inventorytransfer/inventorytransfer/materialdelete">
                                @csrf
                                <div class="row">
                                    <div class='col-md-12'>

                                        <div class="card">

                                            <div class='header'>
                                                <div class="row">
                                                    <i class="pe-7s-cart"
                                                        style='font-size: 70px;margin-left:20px;color:black'></i>
                                                    <div class="col-md-8">
                                                        <h4 class="title" id='Itemname'></h4>
                                                        <label id='Employeename'></label>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-hover table-striped tablesorter">
                                                    <thead>
                                                        <th class='text-center'>Project Name</th>
                                                        <th class='text-center'>Quantity</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id='Projectname'>
                                                                {{-- {{$inventory->project1->projectname}} --}}

                                                            </td>
                                                            <td id='Quantity'>
                                                                {{-- <input type='number' value={{$inventory->quantity}}
                                                                min='0'
                                                                max="{{$inventory->quantity}}"> --}}
                                                                {{-- {{$inventory->quantity}} --}}

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>



                                        </div>
                                        <div class="form-group col-md-12">
                                            <label> Confirm Quantity</label>
                                            <input id='Quantityinput' class='form-control' type='number' name="Quantity"
                                                min="1">

                                        </div>
                                        <input id='Transferid' type='hidden' name='Transferid' value=''>
                                        <input id='Inventoryid' type='hidden' name='Inventoryid' value=''>

                                        <div class="modal-footer d-flex justify-content-center">

                                            <button type="submit" style="display:inline-block"
                                                class="btn btn-primary btn-fill col-md-2">Confirm</button>

                                            <button type="button" style="display:inline-block"
                                                class="btn btn-danger btn-fill col-md-2"
                                                data-dismiss="modal">Close</button>
                                        </div>

                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>


        <script>
            function clicked(which)
                    {
                        if(which == 'equipment')
                        {
                            $('#materialTable').fadeOut(0);
                            $('#equipmentTable').fadeIn(0);
                        }else if(which=='all')
                        {
                            $('#materialTable').fadeIn(0);
                            $('#equipmentTable').fadeIn(0);
                        }
                        else
                        {
                            $('#materialTable').fadeIn(0);
                            $('#equipmentTable').fadeOut(0);
                        }
                    }
        </script>

    </div>




</div>
<div class="modal fade" id="inventorycheckoutmodal">
    <div class="modal-dialog">
        <div class="card text-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Checkout Equipment</h3>
                </div>
                <div class="modal-body">
                    <div class="content">


                        <form method="post" action="/inventorytransfer/inventorytransfer/checkout">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Employee Name</label>
                                        <br>
                                        <span class="twitter-typeahead"
                                            style="position: relative; display: block;"><input type="text"
                                                class="typeahead form-control tt-hint" value="" readonly=""
                                                autocomplete="off" spellcheck="false" tabindex="-1" dir="ltr"
                                                style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 5; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(255, 255, 255);"><input
                                                type="text" class="typeahead form-control tt-input"
                                                placeholder="Employee Name" value="" name="ename" autocomplete="off"
                                                spellcheck="false" dir="auto"
                                                style="position: relative; vertical-align: top; background-color: transparent;">
                                            <pre aria-hidden="true"
                                                style="position: absolute; visibility: hidden; white-space: pre; font-family: Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;"></pre>
                                            <div class="tt-menu"
                                                style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none; background-color: white;">
                                                <div class="tt-dataset tt-dataset-0"></div>
                                            </div></span>
                                    </div>

                                    <div class="card">
                                        <div class="header">
                                            <div class="col-xs-7">
                                                <h5 class="title">
                                                    List of Equipment
                                                </h5>
                                            </div>
                                            <div class="col-xs-5">
                                                <input class="form-control pull-right" id="search" type="text"
                                                    placeholder="Search..">
                                            </div>
                                        </div>

                                        <div class="content table-responsive table-full-width"
                                            style="overflow-y:scroll; height:350px;">
                                            <table class="table table-hover table-striped tablesorter" id="myTable">
                                                <thead>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Classification</th>
                                                    <th>Quantity</th>
                                                    <th></th>
                                                    <th>Restrictions</th>
                                                </thead>

                                                <tbody id=table>


                                                    @if(count($inventory)>0)
                                                    @foreach ($inventory as $i)
                                                    <tr>
                                                        <td>
                                                            <div class="checkbox">
                                                                <input id="checkbox{{$i->inventoryid}}" name='select[]'
                                                                    type="checkbox" value="{{$i->inventoryid}}">
                                                                <label for="checkbox{{$i->inventoryid}}"></label>
                                                            </div>
                                                        </td>

                                                        <td>{{$i->name}}</td>
                                                        <td>{{$i->classification}}</td>
                                                        <td>{{$i->quantity}}</td>
                                                        <td>
                                                            <input type="number" id="noEquipment" class="form-control"
                                                                placeholder="Number" name={{$i->inventoryid}} min="1"
                                                                max={{$i->quantity}}>
                                                        </td>
                                                        @if($i->skillz==null)

                                                        <td>No Restriction</td>
                                                        @else
                                                        <td>{{$i->skillz['description']}}</td>
                                                        @endif
                                                        @endforeach
                                                        @else
                                                        <td>No inventory Found</td>
                                                        @endif

                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="footer">
                                            <hr>
                                            <div class="stats">
                                                <i class="fa fa-refresh"> </i>
                                                Total Inventory:
                                                {{count($inventory)}}
                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </div>

                            <div class="clearfix"></div>







                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">

                    <button type="submit" style="display:inline-block"
                        class="btn btn-primary btn-fill col-md-2">Confirm</button>
                    </form>
                    <button type="button" style="display:inline-block" class="btn btn-danger btn-fill col-md-2"
                        data-dismiss="modal">Close</button>



                </div>

            </div>
        </div>
    </div>
</div>




<script>
    $(function() {
$("#equipmentTable").tablesorter();
$("#materialTable").tablesorter();
$("#myTable").tablesorter();
});
</script>

<script>
    $('#inventorycheckoutmodal').detach().appendTo('body');
    $('#deleteMaterial').detach().appendTo('body');
</script>

<script>
    var container;

    function manageModal(which)
    {

        $.ajax({
            type: "GET",
            url: "/inventorytransfer/"+which+"/edit",

            success: function (data) {
                console.log(data);
                container = data;
                $('#itemName').text(container.inventoryname);
                $('#employeeName').text(container.employeename);
                $('#projectName').text(container.projectname);
                $('#quantity').text(container.quantity);
                $('#transferid').val(container.transferid);
                $('#inventoryid').val(container.inventoryid);
                $('#manageInventory').detach().appendTo('body');
                var val = ($('#quantity').text());
                console.log(val);

                $('#quantityInput').attr('max', val)

                showSelected('return')
            }
        });

        if($function=='delete')
        {

        }


    }

     function trashModal(which)
    {

        $.ajax({
            type: "GET",
            url: "/inventorytransfer/"+which+"/edit",

            success: function (data) {
                console.log(data);
                container = data;
                $('#Itemname').text(container.inventoryname);
                $('#Employeename').text(container.employeename);
                $('#Projectname').text(container.projectname);
                $('#Quantity').text(container.quantity);
                $('#Transferid').val(container.transferid);
                $('#Inventoryid').val(container.inventoryid);
                $('#trashModal').detach().appendTo('body');
                var val = ($('#Quantity').text());
                console.log(val);

                $('#Quantityinput').attr('max', val)

            }
        });



    }



</script>
@endsection
