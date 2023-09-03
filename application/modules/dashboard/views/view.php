<?php

if (!empty($menu_list['menu_admin'])) {
    $menu = array_merge($menu_list['menu_admin'], $menu_list['progamelist'] ? $menu_list['progamelist'] : []);
} else {
    $menu = $menu_list['progamelist'];
}

?>
<div class="homepage">
    <div class="containner">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12">
                <div class="menu-list-item">
                    <?php foreach ($menu as $key => $val) : ?>
                        <a href="<?= base_url($val->href_module) ?>">
                            <div class="contents">
                                <div class="icon-value"><i class="<?= ($val->menu_icon) ?>"></i></div>
                                <div class="text-value"><?= ($val->application_name) ?></div>
                            </div>
                        </a>
                    <?php endforeach ?>
                    <a href="<?= base_url('/message') ?>">
                        <div class="contents">
                            <div class="icon-value"><i class="fas fa-comments"></i></div>
                            <div class="text-value">แชท</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>