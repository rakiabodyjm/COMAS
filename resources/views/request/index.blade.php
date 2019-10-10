@php($title = 'Requests')

@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col-md-10">
            <div class="card">

                <div class="header">
                    <div class="col-xs-7">
                        <h4 class="title">Requests</h4>
                    </div>


                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th>Accept</th>
                            <th>Reject</th>
                            <th>Inventory Name</th>
                            <th>Quantity</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Employee</th>
                            <th>Date Requested</th>

                        </thead>
                        <tbody id="table">
                            <form>
                                @csrf
                                @foreach($requestz as $req)
                                <tr id='{{$req->requestid}}'>
                                    {{-- class="clickable-row" data-href='request/details/{{$req->requestid}}' --}}
                                    <td>
                                        <div class="checkbox">

                                            <input id="reqID{{$req->requestid}}" type="checkbox"
                                                onclick="acceptFunction({{$req->requestid}})" value=1
                                                name='checkboxes{{$req->requestid}}'>
                                            <label for="reqID{{$req->requestid}}">

                                            </label>
                                        </div>

                                    </td>
                                    <td class=>
                                        <button type="button" rel="tooltip" title=""
                                            onclick="deleteFunction({{$req->requestid}})"
                                            class="btn btn-danger btn-simple btn-xs" data-original-title="Remove">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                    <td>
                                        {{$req->inventoryname}}
                                    </td>
                                    <td>
                                        {{$req->quantity}}
                                    </td>
                                    <td>
                                        {{$req->profrom}}
                                    </td>
                                    <td>
                                        {{$req->proto}}
                                    </td>
                                    <td>
                                        {{$req->employeename}}

                                    </td>
                                    <td>
                                        {{$req->date}}
                                    </td>


                                </tr>
                                @endforeach

                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function deleteFunction(requestid)
    {


        $('#'+requestid).fadeOut('fast');

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                $.ajax({
                    type: 'POST',
                    url: window.location.pathname+'/'+requestid+'/delete',

                    dataType: 'JSON',
                    crossDomain: true,
                    success:function(response){
                        // window.location=window.location.pathname;
                        console.log(response);

                        notification(response.success, 'danger')

                    }
            })
    }
    function acceptFunction(requestid)
    {


        $('#'+requestid).fadeOut('fast');

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                $.ajax({
                    type: 'POST',
                    url: window.location.pathname+'/'+requestid+'/accept',
                    dataType: 'JSON',
                    crossDomain: true,
                    success:function(response){
                        console.log(response);

                        notification(response.success, 'success')

                    }
            })
    }
    function notification(string, type)
    {
        $.notify({
        message: string,
        icon: "pe-7s-attention",

        },{
        type: type,
        delay: 7000,
        template: '<div data-notify="container" class="col-xs-11 col-sm-9 alert alert-{0}" role="alert">'+
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>'+
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">x</button>'
            ,
            placement: {
            from: "top",
            align: "center"
            }

            })
    }
</script>
@endsection
