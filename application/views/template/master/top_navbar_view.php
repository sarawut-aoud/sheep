<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>
<ul class="navbar-nav ms-auto">
    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
    <li class="nav-item dropdown no-arrow d-sm-none">
        <!-- Dropdown - Messages -->
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </li>

    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <!-- Counter - Alerts -->
            <span class="badge badge-danger badge-counter">3+</span>
        </a>
        <!-- Dropdown - Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
                แจ้งเตือน
            </h6>
            <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                    <div class="icon-circle bg-success">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">date</div>
                    <span class="font-weight-bold">fullname ได้สมัครเข้าใช้งาน</span>
                </div>
            </a>
        </div>
    </li>



    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="d-flex flex-column gap-1 justify-content-end align-items-end">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') ?></span>
                <span class="mr-2 d-none d-lg-inline text-gray-600 small" style=" text-transform: uppercase;"> <?= $this->session->userdata('loginby') ?></span>
            </div>

            <img class="img-profile rounded-circle" src="<?= $this->session->userdata('picture') ? base_url($this->session->userdata('picture')) : base_url('/assets/images/blank_person.jpg') ?>">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in menu-profile " aria-labelledby="userDropdown">
            <a class="dropdown-item" href="{base_url}profile/">
                <div class="icon primary"><i class="fas fa-user fa-sm fa-fw "></i></div>
                <div class="text">ข้อมูลส่วนตัว</div>
            </a>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{base_url}/process/logout">
                <div class="icon danger"> <i class="fas fa-sign-out-alt fa-sm fa-fw "></i></div>
                <div class="text">ออกจากระบบ</div>
            </a>
        </div>
    </li>

</ul>