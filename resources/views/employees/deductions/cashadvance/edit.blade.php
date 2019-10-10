@php($title = strtoupper($which)) @extends('layouts.app') @section('content')

<div class="content">
    <div class="container-fluid">
        <form method="post" action="/employees/{{$which}}/{{$employee[0]->salarydeductionsid}}/edit/post" Prin>
            @csrf

            <div class="row">
                <div class="col-md-5">
                    <div class="card">

                        <div class="content">
                            <div class="row">
                                <div class="header pull-left">
                                    <h4 class="title">
                                        Edit {{$title}} for {{$employee[0]->employeez['full_name']}}
                                    </h4>

                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group col-md-12 text-center">
                                    <label>Contribution Amount</label>
                                    <input type="text" class="form-control" value={{$employee[0]->amount}}
                                        placeholder="Amount" name="amount">
                                </div>

                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-info btn-fill">Edit</button>

                            </div>

                        </div>
                    </div>
                    <hr>
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