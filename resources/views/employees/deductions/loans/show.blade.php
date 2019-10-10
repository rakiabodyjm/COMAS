@extends('layouts.app')
@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-6">

                <div class="card">
                    <div class="header">
                        <h4 class="title">
                            Transaction Records
                        </h4>
                    </div>

                    <div class="content table-responsive table-full-width">
                        <table id="myTable" class="table table-hover table-striped tablesorter">
                            <thead>
                                <th>Loan Date</th>
                                <th>Amount</th>
                            </thead>

                            <tbody>
                                @foreach($loans as $loan)
                                <tr>
                                    <td>{{$loan->date}}</td>
                                    <td>₱{{$loan->amount}}</td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot style="background-color: #C0C0C0">
                                <tr>
                                    <td>Balance:</td>
                                    <td style="color:red;">₱{{$balance}}</td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">
                                New Loan Record
                            </h4>
                        </div>

                        <div class="content">
                            <form method="post" action="{{action('LoansController@store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Employee Name</label><br>
                                            <input type="text" style="position" class="typeahead form-control"
                                                placeholder="Employee Name" value="{{$name}}" name="ename">
                                        </div>

                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" class="form-control" placeholder="Amount" value=""
                                                name="amount">
                                        </div>
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="date" id="date" class="form-control" placeholder="Date"
                                                value="" name="date">
                                        </div>


                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-fill" name="cashadvance"
                                                value="add">Add Loan</button>
                                            <button type="submit" class="btn btn-success btn-fill" name="cashadvance"
                                                value="pay">Pay Loan</button>

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
    var modalhtml;


    


    $("#payModal").click(function(){
        // console.log('itworked')
        $("body").append(modalhtml)
})

    $(function() {
        $("#myTable").tablesorter();
    });

</script>


@endsection