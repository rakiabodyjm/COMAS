@php($title = 'Payroll')

@extends('layouts.app')

@section('content')

<div class="modal fade" id="holidaysModal">
    <div class="modal-dialog">
        <div class="card text-center">
            <div class="modal-content">

                {{-- @csrf --}}
                <div class="modal-header">

                    <h3>Dates of Holidays</h3>
                    <input type='date' id='date' value={{date('Y-m-d')}}>
                    <button onclick='addHoliday()' type="button" rel="tooltip" title=""
                        class="btn btn-success btn-simple btn-md" data-original-title="Add">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <table id="myTable" class='table table-hover tablesorter'>
                        <thead>
                            <tr>
                                <th class=text-center>
                                    Dates
                                </th>
                            </tr>

                        </thead>


                        <tbody>
                            @foreach($holidates as $h)
                            <tr id='tr{{$h}}'>
                                <td>
                                    <button id='delete{{$h}}' onclick=deleteHoliday() type="button" rel="tooltip"
                                        title="" class="btn btn-danger btn-simple btn-md" data-original-title="Remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                                <td>
                                    {{Date('F j, Y', strtotime($h))}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <div>
                    <table>

                    </table>
                </div>

                <div class="modal-footer text-center">

                    <button type="submit" class="btn btn-info btn-fill col-md-2 pull-left"
                        id="confirmButton">Confirm</button>


                    <button type="button" class="btn btn-secondary btn-fill col-md-2 pull-right"
                        data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">

        <div class="row">

            <div class='col-md-2'>

                <div class="card">
                    <div class="header">
                        <h4 class="title">
                            Active Projects and their Payroll
                        </h4>
                    </div>
                    <div class="content">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($projects as $pr)

                                <div class="card card-shadow" id='project{{$pr['projectid']}}' style='cursor:pointer'>

                                    <div class='header'>
                                        <div class="row">
                                            <i class="pe-7s-culture"
                                                style='font-size: 70px;margin-left:10px;color:black'></i>
                                            <div class="col-md-8">
                                                <h4 class="title">{{$pr['projectname']}}</h4>


                                            </div>
                                        </div>

                                    </div>


                                    <div class='content' style="padding-top:0">
                                        {{-- <div class="footer">
                                            <hr>
                                            <div class="stats">
                                                <i class="fa fa-refresh"> </i>
                                                Last DTR Record:
                                                @foreach($projectDates->where('projectid', $pr['projectid']) as $d)
                                                @if($loop->last)
                                                {{date('F j, Y', strtotime($d['date']))}}
                                        @endif
                                        @endforeach
                                    </div>
                                </div> --}}
                            </div>

                        </div>

                        @endforeach

                    </div>
                </div>





            </div>
        </div>




    </div>

    <div class="col-md-2">
        <div class="card">
            <div class='header'>
                <div class='row'>
                    <div class="col-xs-offset-9 col-xs-2">
                        <a href='#' id='openPayrollModal' data-toggle='modal' data-target='#payrollModal'>
                            <i class='fa fa-print' style='font-size:20px;margin-right:0px;color:black'></i>
                        </a>

                    </div>

                </div>
                <div class="">

                    <i class="pe-7s-note2" style='font-size: 70px;margin-left:20px;color:black'></i>
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <h4 class="title">Attendances Available</h4>
                            <br>

                            <h5 class='title' style='color:midnightblue;'><b class="" id='b' hidden>
                                    Building</b></h5>

                        </div>
                    </div>

                </div>

            </div>
            <hr>

            <div class='content' style="padding-top:0">
                <table id="myTable" class="table table-hover tablesorter">
                    <thead>
                        <th class='text-center'>Dates Available</th>
                    </thead>
                    <tbody id='tableAttendance'>

                    </tbody>
                </table>
                <div class="footer">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"> </i>
                        Last DTR Record:

                    </div>
                </div>
            </div>

        </div>



    </div>
    <div class="col-md-8">
        <div class="card">
            <div class='header'>
                <div class="row">

                    <i class="pe-7s-cash" style='font-size: 70px;margin-left:20px;color:black'></i>
                    <div class="col-md-4">
                        <h4 class="title">Payroll</h4>
                        <h6 id='titulo'>
                            Tiongson Building
                        </h6>
                        <label id='titulodate'>
                        </label>
                        <br>
                        <br>
                        <h5 class='title' style='color:crimson;'><b class="" id='a' hidden>
                                Amount</b>

                        </h5>


                        {{-- <div class="checkbox">
                                    <input id="checkbox" name='holiday' type="checkbox" value="1">
                                    <label for="checkbox">Holiday</label>
                                </div> --}}
                    </div>




                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-md-6 salarydeductionsTitle">
                        <script>
                            $(document).ready(function(){$('.salarydeductionsTitle').attr('hidden', true)})
                        </script>
                        <label>
                            <h6 style="color:black">Payments Due:</h4>
                        </label>
                        <div id='salaryDeductionsTitle'>
                            {{-- <button style='pointer-events:none' class='btn btn-fill btn-info'>

                            </button> --}}
                        </div>

                    </div>
                    <script>
                        $(document).ready(function(){
                            $('.holidayTitle').attr('hidden', true);
                        });
                    </script>

                    <div class="col-md-6 holidayTitle">
                        <label>
                            <h6 style="color:black">Holiday:</h4>
                        </label>
                        <br>
                        <button style='pointer-events:none' id='holidayTitle' hidden='true'
                            class='btn btn-fill btn-warning'>
                    </div>

                    </button>
                    </h5>

                </div>

            </div>
            <hr>

            <div class='content table-responsive table-full-width' style="padding-top:0">
                <table id="myTable" class="table table-hover tablesorter">
                    <thead>
                        <th class='text-center'>Employee Name</th>
                        <th class='text-center'>Skill</th>
                        <th class='text-center'>Base Pay</th>
                        <th class='text-center'>Total Time</th>
                        <th class='text-center'>Over Time</th>
                        <th class='text-center'>Over Time Pay</th>
                        <th class='text-center'>Location Rate</th>
                        <th class='text-center'>Final Pay</th>
                        <th class='text-center'>CA</th>
                        <th class='text-center'>SSS</th>
                        <th class='text-center'>PH</th>


                    </thead>
                    <tbody id='tableFinal'>

                    </tbody>
                </table>
                {{-- <div class="footer">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"> </i>

                    </div>
                </div> --}}
            </div>

        </div>



    </div>


</div>
</div>
</div>
<div class="modal fade" id="payrollModal">
    <div class="modal-dialog">
        <div class="card text-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Select Dates to Summarize</h3>
                </div>
                <div class="modal-body">
                    <label>
                        Date From:
                    </label>
                    <input type="date" id="dateFrom" class="form-control" placeholder="Date"
                        value="{{date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))))}}" name="date">
                    <label>
                        Date To:
                    </label>
                    <input type="date" id="dateTo" class="form-control" placeholder="Date" value="{{date('Y-m-d')}}"
                        name="date">
                </div>

                <div>
                    <table>

                    </table>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-info btn-fill col-xs-2" id="confirmButton">Confirm</button>


                    <button type="button" class="btn btn-secondary btn-fill col-xs-2"
                        data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .td-padding-zero {
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
</style>
<div class="modal modal-fade" id="modalPay">
    <div class="modal-dialog">
        <div class="card text-center">
            <div class="modal-content">
                <form id='submitBayad' method='POST' action="/bayad">
                    @csrf
                    <div class="modal-header">
                        <h3 id='title'>Payments Due</h3>
                    </div>
                    <div class="modal-body">
                        <div class="content table-responsive table-full-width">
                            <table class='table table-hover tablesorter'>
                                <thead>
                                    <th class="text-center">Check to Pay</th>
                                    <th class='text-center'>Salary Deduction</th>
                                    <th class='text-center'>Employee Name</th>
                                </thead>
                                <tbody class='dedHere'>

                                </tbody>

                            </table>
                        </div>

                    </div>


                </form>
                <div class="modal-footer d-flex justify-content-center">

                    <button id='submitBayadButton' type="submit" class="btn btn-info btn-fill col-xs-2">Confirm</button
                        data-dismiss='modal'>
                    <button type="button" class="btn btn-secondary btn-fill col-xs-2"
                        data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    var isHoliday = $('#checkbox').val();

   
    $(document).ready(function()
    {
        $('#openPayrollModal').hide();
        $('#titulo').text('');
        $('#titulodate').text('');
    })
    $('#confirmButton').click(function()
    {
        location.reload();
    });
    $('#openPayrollModal').click(function()
    {
        $('#payrollModal').detach().appendTo('body');
    });
    $('[id^=project]').click(function()
    {
        $('.date').fadeOut('normal');
        $('.payroll').fadeOut('normal');
        $('.date').remove();
        $('.payroll').remove();
        $('.dedo').remove();
        $('#openPayrollModal').show();
        $('#a').text('');
        $('.holidayTitle').attr('hidden', true);
        // $('#salarydeductionsTitle').parent().attr('hidden', true);
        $('.salarydeductionsTitle').attr('hidden', true);
        $('.dedHere').empty();
        var selected = $(this).attr('id');
        selected = selected.substr(7);

        postProject(selected);

    });

    $('#tableAttendance').on('click', '[id^=attendance]', function()
    {
        var id = ($(this).attr('id'));

        var projectid = id.slice(11,id.length -11 );
        var date = id.slice(projectid.length + 12, 24);
        

        $('.payroll').fadeOut('normal');
        $('.payroll').remove()

        postProjectDate(projectid, date);

        var mema = $(this).attr('id');
        

        string = $("#"+mema +" td").text();
        
        $('#titulodate').text(string);
        $('.salarydeductionsTitle').attr('hidden', true);
        $('#salaryDeductionsTitle').children().remove();
        $('.dedHere').empty();
        getPaymentLabel(date);
    });
    function getPaymentLabel(date)
    {

        var newdate = new Date(date);
        var data='';

        $.ajax({
            type: 'GET',
            url: '/payroll/holiday',
            dataType: 'JSON',
            crossDomain: true,
            success:function(response){
                var container =[];
                $.each(response, function(i, item)
                {
                    container.push((item.date));
                });
                
                if(container.includes(date))
                {
                    $('.holidayTitle').attr('hidden', false);
                    $('#holidayTitle').text('Holiday Today');
                }else
                {
                    $('.holidayTitle').attr('hidden', true);
                    $('#holidayTitle').text('Holiday Today')
                }
            }
         
            
        });
        console.log('newdate ='+newdate.getDate());
          
            if(newdate.getDate() == 15)
            {
                // console.log('getDate 15 worked');
                $('.salarydeductionsTitle').attr('hidden', false);
                $('#salaryDeductionsTitle').append($("<button>").addClass('btn btn-info payment').text('SSS Payments Today').attr('data-toggle', 'modal').attr('data-target', '#modalPay'));
            }
            if(newdate.getDate() == 25)
            {
                $('.salarydeductionsTitle').attr('hidden', false);
              $('#salaryDeductionsTitle').append($("<button>").addClass('btn btn-info payment').text('PhilHealth Payments Today').attr('data-toggle', 'modal').attr('data-target', '#modalPay'));
           
            }
            if(newdate.getDay() == 6)
            {
                $('.salarydeductionsTitle').attr('hidden', false);
                $('#salaryDeductionsTitle').append($("<button>").addClass('btn btn-info payment').text('Cash Advance Payments Today').attr('data-toggle', 'modal').attr('data-target', '#modalPay'));
         
            };
            
            $('#salaryDeductionsTitle').unbind().on('click', '.payment', function(){
                    $('.dedHere').empty();
                    $('#modalPay').detach().appendTo('body');
                    $.ajax({
                    type: 'GET',
                    url: '/singil/'+date,
                    dataType: 'JSON',
                    crossDomain: true,
                    success:function(response){
                         console.log(response);
                        
                        $('.dedHere').empty();
                        $.each(response, function(index, value)
                        {
                            $.each(value.deductionz, function(index, val)
                            {
                               $('.dedHere').append($("<tr>").attr("role", "row").append($("<td>").append($("<div>").addClass("checkbox").addClass("text-center")
                                .append($("<input>").attr("id", "checkbox"+val.salarydeductionsid).attr("type", "checkbox").attr("value",
                                val.salarydeductionsid).attr("name", "ded[]")).append($("<label>").attr("for", "checkbox"+val.salarydeductionsid))
                                    ))
                                  
                                    .append($('<td>').text(val.deductiontypeid.toUpperCase()))
                                        .append($('<td>').text(value.employeename))
                                            )
                            });
                        });
                    }
         
            
                });

                $('#modalPay').detach().appendTo('body');

                $('#submitBayadButton').unbind().click(function()
                {
                    $.post('/bayad', $('#submitBayad').serialize(), function(response)
                    {
                        console.log(response);
                        $('#modalPay').modal('hide');

                        notification(response.message, response.type)
                    });
                });
            });

            // if(data=='')
            // {

            //     $('.salarydeductionsTitle').attr('hidden', true);
            // }else{

            //     $.each(data, function()
            //     {
                    
            //         $('#salaryDeductionsTitle').append('<button>').addClass('btn btn-info')
            //     });
            //     $('#salarydeductionsTitle').attr('hidden', false).text('Payments Today: '+data);
            //     $('.salarydeductionsTitle').attr('hidden', false)
            //     console.log(data);
            // }
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

    function postProject(projectid)
    {
        var data ={
            "_token":'{{ csrf_token() }}',
            'isHoliday':isHoliday
        }
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'POST',
         
            url: window.location.pathname+'/'+projectid+'/nothing',
            dataType: 'JSON',
            crossDomain: true,
            success:function(response){
                popAttendanceTable(response);
            },
            error:function(response){
            }
        })
    }
    function postProjectDate(projectid, projecdate){

        
        var data = {
            "_token":'{{ csrf_token() }}',
            "isHoliday":isHoliday
        };
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
         
            url: window.location.pathname+'/get/'+projectid+'/'+projecdate,
            data: data,
            dataType: 'JSON',
            crossDomain: true,
            success:function(response){
                popPayrollTable(response);
            }
        })
    }

    function popPayrollTable(data)
    {
        $.each(data, function(i, item)
        {
            //PUTANGINA MO ETO YUNG PINALITAN MO
            $('#tableFinal').append($('<tr>').addClass('payroll').attr('id', 'dtrid'+item.dtr_id).attr('onclick', 'payrollSummarize('+item.dtr_id+')')
                .append($('<td>').text(item.employeeName))
                    .append($('<td>').text(item.skill))
                        .append($('<td>').text(item.basePay))
                            .append($('<td>').text(item.totalTime))
                                .append($('<td>').text(item.overTime))
                                    .append($('<td>').text(item.overTimePay))
                                        .append($('<td>').text(item.locationRate))
                                            .append($('<td>').text(item.finalPay))
                                                .append($('<td>').text(item.cashadvance).addClass("cashadvance"))
                                                    .append($('<td>').text(item.sss).addClass("sss"))
                                                        .append($('<td>').text(item.philhealth).addClass('philhealth'))
                                                          
                  
                            );
           
        });
        $('#tableFinal tr').hide();
        $("#tableFinal tr").each(function(index)
        {
            $(this).delay(index*250).show(100);
        });

        var sum =0;
        $('[id^=perPay]').each(function()
        {
            sum+= parseInt($(this).text());
            $('#a').text('PhP '+sum).show();
        });

    }
  
    function popAttendanceTable(data)
    {       
        
        $.each(data, function(i, item)
        {
            $('#tableAttendance').append($('<tr class=text-center>').addClass('date clickable-row').attr('id', 'attendance_'+item.projectid+'-'+item.date)
                .append($('<td>').text( item.dateString).addClass('td-padding-zero'))
            );
            $('#b').text(item.projectname).removeClass().addClass(''+item.projectid).show();
            $('#titulo').text(item.projectname);
        });

        $('#tableAttendance tr').hide();
        $("#tableAttendance tr").each(function(index)
        {
            $(this).delay(index*250).show(100);
        });
        

        
    }

</script>

<script>
    $("#holidaysModal").detach().appendTo('body');

    function deleteHoliday(date)
    {
        var selected =  $('[id^=delete]').attr('id');

        
        selected = selected.substr(6,10);
        
        $('#tr'+selected).remove();
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
            url: 'payroll/datepost/delete/'+selected,
            dataType: 'JSON',
            crossDomain: true,
            success:function(response){
                // location.reload();
                $()
                // console.log(response);
            }
        })
    }
    function addHoliday()
    {
        var date = $('#date').val();

        postDate(date);

    }


    function postDate(date)
    {
        
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
            url: 'payroll/datepost/add/'+date,
            dataType: 'JSON',
            crossDomain: true,
            success:function(response){
                // location.reload();

                // console.log(response);
                location.reload();

            }
        })
    }
</script>
<script>
    $('#confirmButton').click(function()
    {
    var projectid = $('#b').attr('class');
    var datefrom = $('#dateFrom').val();
    var dateto = $('#dateTo').val();

    // console.log(projectid+datefrom+dateto);
    window.location.href='/payroll/print/'+projectid+'/'+datefrom+'/'+dateto
    });
</script>
<script>
    function payrollSummarize(dtrid)
    {
            $.ajax({
            type: "GET",
            url: "/papa/"+dtrid,
            
            success: function (data) {
                payrollSummarizeModal(data);
            }
            });
    }
    function payrollSummarizeModal(datakan)
    {

    }
</script>

<script>

</script>
<div class="modal fade" id="payrollSummary">
    <div class="modal-dialog">
        <div class="card text-center">
            <div class="modal-content">

                {{-- @csrf --}}
                <div class="modal-header">
                    <h3>Select Dates to Summarize</h3>
                </div>
                <div class="modal-body">
                    <label>
                        Date From:
                    </label>
                    <input type="date" id="dateFrom" class="form-control" placeholder="Date"
                        value="{{date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))))}}" name="date">
                    <label>
                        Date To:
                    </label>
                    <input type="date" id="dateTo" class="form-control" placeholder="Date" value="{{date('Y-m-d')}}"
                        name="date">
                </div>

                <div>
                    <table>

                    </table>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-info btn-fill col-xs-2" id="confirmButton">Confirm</button>


                    <button type="button" class="btn btn-secondary btn-fill col-xs-2"
                        data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $('td').addClass('text-center');
</script>
@endsection