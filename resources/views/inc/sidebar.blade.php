<div class="sidebar" data-color='gray' data-image="{{asset('img/sidebar-photo.jpg')}}">

    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="/" class="simple-text">
                <img src="{{asset('img/comas-logo.png')}}" class="navbar-brand-img" width="100px" height="100px">

            </a>
        </div>

        <ul class="nav">
            <li class="{{Request::is('/')?'active':''}}">
                <a href="/">
                    <i class="pe-7s-graph"></i>
                    <p>Dashboard</p>
                </a>
            </li>


            <li class="{{Request::is('employees*')?'active':''}}">
                <a href="/employees">
                    <i class="pe-7s-users"></i>
                    <p>Employee</p>
                </a>
            </li>

            <li class="{{ Request::is('projects*') ? 'active' : ''}}">
                <a href="/projects">
                    <i class="pe-7s-culture"></i>
                    <p>Project</p>
                </a>
            </li>

            <li class="{{ Request::is('inventory') ? 'active' : ''}}">
                <a href="/inventorytransfer">
                    <i class="pe-7s-tools"></i>
                    <p>Inventory</p>
                </a>
            </li>

            <li class="{{ Request::is('payroll') ? 'active' : ''}}">
                <a href="/payroll">
                    <i class="pe-7s-news-paper"></i>
                    <p>Payroll</p>
                </a>
            </li>

            <li class="{{Request::is('request') ? 'active' : ''}}">
                <a href="/request">
                    <i class="pe-7s-bell"></i>
                    <p>Inventory Transfer Report</p>
                </a>
            </li>

        </ul>
    </div>
</div>