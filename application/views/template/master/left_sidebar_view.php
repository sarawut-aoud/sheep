<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion position-relative" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <div class="sidebar-brand d-flex align-items-center justify-content-center" >
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{base_url}/assets/images/application/s-icon.png" alt="" style="width: 50px;filter: invert(1);">
        </div>
        <div class="sidebar-brand-text mx-3" style="line-height: 14px;">
            <strong style="font-size: 22px;">{application_name}</strong>
            <span>{application_sub_name}</span>
        </div>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{base_url}dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>HOME</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-sliders-h"></i>
            <span>ตั้งค่า</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Setting : </h6>
                <a class="collapse-item" href="{base_url}">รายการแก้ไข-อัพเดต</a>
                <a class="collapse-item" href="">Register</a>
                <a class="collapse-item" href="">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="">404 Page</a>
                <a class="collapse-item" href="">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Heading -->
    <div class="sidebar-heading">
        progame list
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-toolbox"></i>
            <span>ระบบแจ้งซ่อม</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="">Buttons</a>
                <a class="collapse-item" href="">Cards</a>
            </div>
        </div>
    </li>


    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-store-alt"></i>
            <span>ระบบร้านขายสินค้า</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="">Colors</a>
                <a class="collapse-item" href="">Borders</a>
                <a class="collapse-item" href="">Animations</a>
                <a class="collapse-item" href="">Other</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0 text-color" id="sidebarToggle">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>

    <div class="sidebar-bottom">
        <hr class="sidebar-divider d-none d-md-block">
        <div class="logout-content-bottom">
            <a href="{base_url}Process/logout">
                <button class="btn btn-danger bottombtnlogout" type="button">
                    <div class="icon"> <i class="fas fa-sign-out-alt"></i> </div>
                    <div class="text">ออกจากระบบ</div>
                </button>
            </a>
        </div>
    </div>
</ul>