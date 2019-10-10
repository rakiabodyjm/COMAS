@php($title = 'Manage Inventory') @extends('layouts.app') @section('content')

<div class="content">
    <div class="container-fluid">
        <form method="post" action="{{action('InventoryTransfersController@update', $inventory->transferid)}}">
            @csrf



    </div>
    </form>

</div>





@endsection