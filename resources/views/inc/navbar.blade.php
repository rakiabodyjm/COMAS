<nav class="navbar navbar-default navbar-fixed">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2"
                id='toggleClicked'>
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


            <a class="navbar-brand" id="back" style="cursor:pointer" rel='tooltip' data-original-title="Back"
                data-placement="bottom">
                <span class="pe-7s-back">
                </span>
            </a>

            @if(Route::is('projects.show') or Route::is('attendance.view'))

            <a href="#" class="navbar-brand" data-toggle="dropdown" aria-expanded="false">

                {{$title}}
                <b class="caret"></b>


            </a>
            <ul class="dropdown-menu" style='margin-left:70px'>
                @foreach($projects as $project)
                @if(Route::is('projects.show'))
                <li><a href="/projects/{{$project->projectid}}">{{$project->projectname}}</a></li>
                @else

                <li><a href="/projects/{{$project->projectid}}/attendance/{{$date}}">{{$project->projectname}}</a></li>
                @endif
                @endforeach



                {{-- <li class="divider"></li> --}}
            </ul>

            @else
            <a class="navbar-brand" href="#">{{$title}}</a>

            @endif
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right" id='ulRight'>
                @if (Request::is('employees'))

                <li id='modalTrigger'>
                    <a href='' data-target="#employee" data-toggle='modal' rel='tooltip'
                        data-original-title="Add Employee" data-placement="bottom" class="dropdown-toggle">
                        <i class="fa fa-plus"></i>
                        <p class="hidden-lg hidden-md">
                            Add Employee
                        </p>
                    </a>
                </li>


                <ul class="nav navbar-nav navbar-left" id='navItems' style="visibility:hidden">
                    <li class='dropdown'>
                        <a href='employees/skills' rel='tooltip' data-original-title="Skills" data-placement="bottom"
                            class="dropdown-toggle">
                            <i class="fa fa-legal"></i>
                            <p class="hidden-lg hidden-md">
                                Skills
                            </p>
                        </a>
                    </li>
                    <li class='dropdown'>
                        <a href='' rel='tooltip' data-original-title="Payables" data-placement="bottom"
                            data-toggle='dropdown' aria-expanded='false' class="dropdown-toggle">
                            <i class="fa fa-money"></i>
                            <b class='caret hidden-sm hidden-xs'></b>

                            <p class="hidden-lg hidden-md">
                                Payables
                                <b class='caret'></b>
                            </p>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/employees/sss">SSS</a></li>
                            <li><a href="/employees/philhealth">PhilHealth</a></li>
                            <li><a href="/employees/cashadvance">Cash Advance</a></li>
                        </ul>
                    </li>

                </ul>

                @endif



                @if(Request::is('projects'))
                <ul class="nav navbar-nav navbar-left" id='navItems' style="visibility:hidden">

                    <li>
                        <a href='projects/all' rel='tooltip' data-original-title="All Projects" data-placement="bottom"
                            class="dropdown-toggle">
                            <i class="fa fa-university"></i>
                            <p class="hidden-lg hidden-md">
                                All Projects
                            </p>
                        </a>
                    </li>

                    <li>
                        <a href="/projects/assign" rel='tooltip' data-original-title="Assign" data-placement="bottom"
                            class="dropdown-toggle">
                            <i class="fa fa-users"></i>
                            <p class="hidden-lg hidden-md">
                                Assign
                            </p>
                        </a>
                    </li>


                </ul>



                @endif

                @if(Request::is('projects/all'))
                <li>
                    <a href="{{url('projects/locations')}}">
                        <p>Locations</p>
                    </a>
                </li>

                @endif

                @if(Route::is('projects.show'))
                <ul class="nav navbar-nav navbar-left" id='navItems' style="visibility:hidden">

                    <li>
                        <a href="/projects/assign" rel='tooltip' data-original-title="Assign" data-placement="bottom"
                            class="dropdown-toggle">
                            <i class="fa fa-users"></i>
                            <p class="hidden-lg hidden-md">
                                Assign
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="/projects/{{$projectid}}/attendance/{{date('Y-m-d')}}" rel='tooltip'
                            data-original-title="Attendance" data-placement="bottom" class="dropdown-toggle">
                            <i class="fa fa-list-alt"></i>
                            <p class="hidden-lg hidden-md">
                                Attendance
                            </p>
                        </a>
                    </li>


                </ul>

                @endif

                @if(Route::is('saldec.index') OR Route::is('saldec.show'))
                <ul class="nav navbar-nav navbar-left" id='navItems' style="visibility:hidden">
                    <li class='dropdown'>
                        <a href='' data-target="#employee" rel='tooltip' data-original-title="Payables"
                            data-placement="bottom" data-toggle='dropdown' aria-expanded='false'
                            class="dropdown-toggle">
                            <i class="fa fa-money"></i>
                            <b class='caret hidden-sm hidden-xs'></b>

                            <p class="hidden-lg hidden-md">
                                Payables
                                <b class='caret'></b>
                            </p>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/employees/sss">SSS</a></li>
                            <li><a href="/employees/philhealth">PhilHealth</a></li>
                            <li><a href="/employees/cashadvance">Cash Advance</a></li>
                        </ul>
                    </li>

                </ul>
                @if(Request::is('employees/cashadvance/*'))
                <li id='payModal'>
                    <a href='' class="dropdown-toggle" rel='tooltip' data-original-title="Add Cash Advance"
                        data-placement="bottom" data-toggle="modal" data-target='#paymodal'>
                        <i class="fa fa-plus"></i>
                        <p class="hidden-lg hidden-md">Add Cash Advance</p>
                    </a>
                </li>
                @endif

                @endif

                @if(Route::is('attendance.view'))


                <!--This is the NAVIGATION left items FOR THIS SHIT-->
                <ul class="nav navbar-nav navbar-left" id='navItems' style="visibility:hidden">

                    <li>
                        <a href="/projects/assign" rel='tooltip' data-original-title="Assign" data-placement="bottom"
                            class="dropdown-toggle">
                            <i class="fa fa-users"></i>
                            <p class="hidden-lg hidden-md">
                                Assign
                            </p>
                        </a>
                    </li>


                </ul>
                <li id='summon'>
                    <a href='' class="dropdown-toggle" rel='tooltip' data-original-title="Summon"
                        data-placement="bottom" data-toggle="modal" data-target='#summonModal'>
                        <i class="fa fa-user-plus"></i>
                        <p class="hidden-lg hidden-md">Summon</p>
                    </a>
                </li>
                @endif
                @if(Route::is('payroll.index'))

                <li>
                    <a href="#" rel='tooltip' data-original-title="Holidays" data-toggle="modal"
                        data-target='#holidaysModal' data-placement="bottom" class="dropdown-toggle">
                        <i class="fa fa-calendar-check-o "></i>
                        <p class="hidden-lg hidden-md">
                            Holidays
                        </p>
                    </a>
                </li>
                @endif

                <li>
                    <a href="#" rel='tooltip' data-original-title="Log Out" data-placement="bottom"
                        class="dropdown-toggle">
                        <i class="fa fa-sign-out"></i>
                        <p class="hidden-lg hidden-md">
                            Log Out
                        </p>
                    </a>
                </li>
                <li class="separator hidden-lg"></li>
            </ul>
            {{-- for inventorytransfer --}}
            @if (Request::is('inventorytransfer'))

            <ul class="nav navbar-nav navbar-left" id='navItems' style="visibility:hidden">
                <li class='dropdown'>
                    <a href='inventorytransfer/inventory' rel='tooltip' data-original-title="Inventory"
                        data-placement="bottom" class="dropdown-toggle">
                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                        <p class="hidden-lg hidden-md">
                            Inventory Summary
                        </p>
                    </a>
                </li>



                <li id='inventorycheckouttrigger'>
                    <a href='#' data-target="#inventorycheckoutmodal" data-toggle='modal' rel='tooltip'
                        data-original-title="Checkout Inventory" data-placement="bottom" class="dropdown-toggle">
                        <i class="fa fa-cart-arrow-down"></i>
                        <p class="hidden-lg hidden-md">
                            Inventory Checkout
                        </p>
                    </a>
                </li>





            </ul>
            @endif
            @if(Request::is('/'))
            <ul class="nav navbar-nav navbar-right" id='ulRight'>
                <li>
                    <a href="/logs" rel='tooltip' data-original-title="Logs" data-placement="bottom"
                        class="dropdown-toggle">
                        <i class="fa fa-bookmark"></i>
                        <p class="hidden-lg hidden-md">
                            Logs
                        </p>
                    </a>
                </li>
            </ul>

            @endif
        </div>
    </div>
</nav>

<script>
    $("#back").click(function(){
        var url = window.location.href;

        // if(url.indexOf('deductions')>-1)
        // {
        //     back=(url.substring(0, url.lastIndexOf("/deductions/")+1))
        // }
        if(url.indexOf('attendance')>-1)
        {
            back=(url.substring(0, url.lastIndexOf("/attendance/")+1));
        }
        if(url.indexOf('inventory')>-1)
        {
        back=(url.substring(0, url.lastIndexOf("/inventory/")+1));
        }
        else
        {
            back=(url.substring(0, url.lastIndexOf("/")+1));
        }
            
      
        window.location.replace(back);


    })

    $(document).ready(function()
    {
        var attendanceItems=$('#navItems').detach();
        attendanceItems.insertBefore('#ulRight');
        $('#navItems').css({"visibility":"visible"});
    });
</script>