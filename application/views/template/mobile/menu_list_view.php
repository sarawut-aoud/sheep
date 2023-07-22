<ul class="menu_footer  d-flex justify-content-center">

    <li class="navi-home ">
        <a class="d-flex flex-column gap-1 justify-content-center align-items-center" href="{base_url}dashboard">
            <i class="m-color--text g-icon fas fa-home"></i>
            <span class="m-color--text g-text">Home</span>
        </a>
    </li>
    <li class="navi-message">
        <a class="d-flex flex-column gap-1 justify-content-center align-items-center" href="">
            <i class="m-color--text g-icon fas fa-comment-alt"></i>
            <span class="m-color--text g-text">Messages</span>
        </a>
    </li>
    <li class="navi-notification">
        <a class="d-flex flex-column gap-1 justify-content-center align-items-center" href="">
            <i class="m-color--text g-icon fas fa-bell position-relative">
                <div class="noti-unread-count"></div>
            </i>
            <span class="m-color--text g-text">Notification</span>
        </a>
    </li>
    <li class="navi-profile ">
        <a class="d-flex flex-column gap-1 justify-content-center align-items-center" href="{base_url}profile">
            <i class="m-color--text g-icon fas fa-user-alt"></i>
            <span class="m-color--text g-text">Profile</span>
        </a>
    </li>
    <li class="navi-settings">
        <a class="d-flex flex-column gap-1 justify-content-center align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#settingmenu" aria-controls="settingmenu">
            <i class="m-color--text g-icon fas fa-cog"></i>
            <span class="m-color--text g-text">Setting</span>
        </a>
    </li>

</ul>
<div class="offcanvas offcanvas-end w-100" tabindex="-1" id="settingmenu" aria-labelledby="settingmenu">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Setting</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-4">
        <div class="contents-setting">
            <a href="{base_url}Process/logout">
                <div class="contents">
                    <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
                    <div class="text">ออกจากระบบ</div>
                </div>
            </a>
        </div>
    </div>
</div>