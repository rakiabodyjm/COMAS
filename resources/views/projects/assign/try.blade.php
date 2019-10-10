@extends('layouts.app') @section('content')
@php($title = 'Assignment')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <div class="col-xs-8">
                            <h4 class="title">Employees</h4>
                        </div>
                        <div class="col-xs-4">
                            <input class="form-control pull-right" id="search" type="text" placeholder="Search..">
                        </div>
                        <hr>
                    </div>

                    <div class="content table-responsive table-full-width" style="overflow-y:scroll;max-height:330px;">

                        <table id="myTable" class="table table-hover tablesorter">
                            <thead>
                                <th>Employees</th>
                            </thead>

                            {{-- <tbody id=table class="assignmenttable">

                            </tbody> --}}

                        </table>

                    </div>
                    <hr>
                    <div class="text-center">
                        <div class="d-flex mx-3">
                            <button type="submit" id="sumite" class="col-md-12 btn btn-info btn-fill">Assign</button>
                        </div>

                    </div>
                    <hr>

                </div>
            </div>
            <div class="col-md-6" id="projectCards">

            </div>





        </div>


    </div>
</div>
</div>
<script>
    var modalhtml
    var val=[];
    function populateEmployees(){
        $("tbody").remove();

        $.getJSON('/employees/try.json', function(data){
            var items=[];
            // $.each(data, function(key, val){
            //     items.push("<tr>")
            //     items.push("<td>"+val.full_name+"</td>")
            //     console.log(val.full_name);
            //     items.push("</tr>")
            // });

            $.each(data, function(key, val){
                items.push("<tr> <td> <div class='d-flex justify-content-between bg-secondary'> <div>")
                    items.push(val.full_name)
                    items.push("</div><div><label class='form-check-label'><input id='assCheck' class='form-check-input' name='assign[]' type='checkbox' value=")
                    items.push(val.employeeid)
                    items.push('>Select</label></div></div></td></tr>')
            });
            $('<tbody/>', {html:items.join("")}).appendTo("table")
        });
    };
   
    $(document).ready(function()
    {
        populateEmployees();
        modalhtml = $('#assignModal').detach();
        modalhtml.appendTo("body");

        $("#submitAss").click(function(e)
        {
            e.preventDefault();

            var project = $("select[name='project']").val();
            var employee = val;

            var realData = {
                "_token":'{{ csrf_token() }}',
                "project":project,
                "employees":employee
            };
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                $.ajax({
                    type: 'POST',
                    // headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: '/projects/assign',
                    data: realData,
                    dataType: 'JSON',
                    crossDomain: true,
                    success:function(response){
                        console.log(response)
                                          
                    },
            });


        });
    });

    $("#sumite").click(function()
    {
        populate();

        $('#assCheck:checked').each(function(i)
        {
            val[i] = $(this).val();

            //try 
           

        });
            $('#assignModal').modal('show');
    });

    

    $(function() {
        $("#myTable").tablesorter();
    });

</script>
@endsection