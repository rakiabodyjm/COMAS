@php($title = 'Loans Application') @extends('layouts.app') @section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <div class="col-xs-7">
                            <h4 class="title">
                                Active Loans
                            </h4>
                        </div>

                        <div class="col-xs-5">
                            <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                        </div>

                    </div>
                    <div class="content table-responsive table-full-width">
                        <table id="myTable" class="table table-hover table-striped tablesorter">
                            <thead>
                                <th>Employee Name</th>
                                <th>Outstanding Balance</th>
                                <th>Last Payment Done</th>
                            </thead>

                            <tbody id="table">
                                @if(count($loans)>0) @foreach($loans as $loan)
                                <tr class="clickable-row" data-href="/employees/loans/{{$loan->employeez->employeeid}}">
                                    <td>{{$loan->employeez->lname}}, {{$loan->employeez->fname}}</td>
                                    <td>₱{{$loan->where('employeeid', $loan->employeeid)->sum('amount')}}</td>
                                    <td>{{$loan->date}}</td>
                                </tr>
                                @endforeach @else
                                <tr>
                                    <td colspan="5" class='text-center'>
                                        No Employees on Loan
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

                    <div class="content">
                        <button type="button" class="btn btn-fill btn-info col-xs-12 container-fluid"
                            data-toggle="collapse" data-target="#collapse" style="white-space:">
                            Add Loan
                        </button>
                        <hr>
                        <br>
                        <div id="collapse" class="collapse">

                            <form method="post" action="{{action('LoansController@store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Employee Name</label>
                                            <br>
                                            <input type="text" class="typeahead form-control"
                                                placeholder="Employee Name" value="" name="ename">
                                        </div>

                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" id="amount" class="form-control" placeholder="Amount"
                                                value="" name="amount">
                                        </div>
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="date" id="date" class="form-control" placeholder="Date"
                                                value="" name="date">
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info btn-fill" name="loan"
                                                value="add">Add New Loan</button>

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

<!--<script>
    Date.prototype.toDateInputValue = (function() {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0,10);
    });

    document.getElementById('date').value = new Date().toDateInputValue();
</script>-->
<script>
    $(function() {
        $("#myTable").tablesorter();
    });
</script>
@endsection