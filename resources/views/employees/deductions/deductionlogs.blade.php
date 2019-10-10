@extends('layouts.app')
@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row">





            <div class="col-xs-6">

                <div class="card">
                    <div class="header">
                        <h4 class="title">
                            {{$title}}
                        </h4>
                        <label class="category">Records of {{$name}}</label>

                    </div>

                    <div class="content table-responsive table-full-width">
                        <table id="myTable" class="table table-hover table-striped tablesorter">
                            <thead>
                                <th>Date</th>
                                <th>Amount</th>
                                @if($which=='cashadvance')
                                <th>Status</th>
                                @endif
                            </thead>

                            <tbody>
                                @if(count($logs)>0)

                                @foreach($logs as $log)

                                <tr>
                                    <td>{{date('F j, Y', strtotime($log->sdlogs_date))}}</td>
                                    <td style="align-items: center">

                                        ₱{{$log->sdlogs_amount}}

                                    </td>
                                    <td>
                                        @if($which=='cashadvance' && $log->sdlogs_amount>0)
                                        <div>
                                            <button style="pointer-events: none;" type="button"
                                                class="btn btn-fill btn-primary btn-sm">Advance</button>
                                        </div>
                                        @else
                                        <div>
                                            <button style="pointer-events: none;" type="button"
                                                class="btn btn-fill btn-success btn-sm">Payment</button>
                                        </div>
                                        @endif
                                    </td>
                                    {{-- <td><label style="text-align:end;right:0;">
                                            @if($which=='cashadvance' && $log->sdlogs_amount>0)Loan @else
                                            Payment @endif</label> --}}
                                </tr>
                                @endforeach

                                @else
                                <tr>
                                    <td class='text-center' colspan="3">No payment done yet</td>
                                </tr>
                                @endif
                            </tbody>

                            <tfoot style="background-color: #C0C0C0">
                                <tr>
                                    @if($which=='cashadvance')
                                    <td>Balance</td>
                                    <td colspan="2" style="color:crimson; font-weight:900">
                                        ₱{{$logs->sum('sdlogs_amount')}}
                                    </td>
                                    @else
                                    <td><b>Contribution: </b></td>
                                    @endif

                                </tr>

                            </tfoot>

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
    var modalhtml= `<div class="modal fade" id="paymodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Add Employee</h3>
                </div>
                <div class="modal-body">
                    <form method="post" action="/employees/{{$where}}/{{$id}}/store">
@csrf
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Employee Name</label><br>
            <input type="text" disabled style="position" class="typeahead form-control" placeholder="Employee Name"
                value="{{$name}}" name="ename">
        </div>

        <div class="form-group">
            <label>Amount</label>
            <input type="number" class="form-control" placeholder="Amount" value="" name="amount">
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" id="date" class="form-control" placeholder="Date" value="" name="date">
        </div>


        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-fill" name="loan" value="loan">Add
                Loan</button>
            <button type="submit" class="btn btn-success btn-fill" name="loan" value="pay">Pay
                Loan</button>

        </div>

    </div>

</div>

<div class="clearfix"></div>
</form>
</div>
<div class="modal-footer">
    <div class="col-xs-5">

    </div>
    <button type="button" class="btn btn-secondary btn-fill col-xs-2" data-dismiss="modal">Close</button>

</div>
</div>
</div>
</div>`




$("#payModal").click(function(){
// console.log('itworked')
$('#paymodal').detach();

$("body").append(modalhtml)
document.getElementById('date').valueAsDate = new Date();
});


    $(function() {
        $("#myTable").tablesorter();
    });

</script>


@endsection