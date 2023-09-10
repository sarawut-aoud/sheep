<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 5 Dashboard Template">
    <meta name="author" content="ParkerThemes">
    <!-- Title -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{title_html}</title>
    <link rel="icon" type="image/x-icon" href="{base_url}favicon.ico">

    <!-- bootstap 5 -->
    <link rel="stylesheet" href="{base_url}assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{base_url}assets/css/jquery-ui.min.css">
    <!-- datatable -->
    <link rel="stylesheet" href="{base_url}assets/css/dataTables.bootstrap5.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="{base_url}assets/js/table5/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{base_url}assets/js/table5/buttons.bootstrap5.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="{base_url}assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{base_url}assets/css/sweetalert2.min.css">
    <!-- select2 -->
    <link rel="stylesheet" href="{base_url}assets/g_template/vendor/bs-select/bs-select.css" />
    <link rel="stylesheet" href="{base_url}assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="{base_url}assets/plugins/daterangepicker/daterangepicker.css">

    <!-- Main Css -->

    <link rel="stylesheet" href="{base_url}assets/css/_var_main.css">
    <link rel="stylesheet" href="{base_url}assets/dist/master.min.css">
    <link rel="stylesheet" href="{base_url}assets/css/style_custom.css">
    <link rel="stylesheet" href="{base_url}assets/css/style_m_custom.css">
    <link rel="stylesheet" href="{base_url}assets/css/loading.css">
    <link rel="stylesheet" href="{base_url}assets/icomoon/style.css">
    <link rel="stylesheet" href="{base_url}assets/css/dashboard.css">


    {another_css}


</head>


<body style="height: auto;">
    <input type="hidden" id="is_mobile" value="<?= true ?>">
    <div class="header">
        {top_navbar}
    </div>
    <div class="mb-container">
        {page_content}
    </div>
    <div class="promote">
        <p> Copyright © {application_varsion_mobile} </p>
    </div>
    <div class="footer">
        {menu}
    </div>

    <!-- jquery -->
    <script src="{base_url}assets/js/jquery-3.6.0.min.js"></script>
    <script src="{base_url}assets/js/jquery-ui.min.js"></script>
    <script src="{base_url}assets/js/jquery.cookie.min.js"></script>
    <script src="{base_url}assets/dist/jquery.easing.min.js"></script>

    <!-- bootstap 5 -->
    <script src="{base_url}assets/js/bootstrap.bundle.min.js"></script>
    <!-- Sweetalert2 -->
    <script src="{base_url}assets/js/sweetalert2.all.min.js"></script>

    <script src="{base_url}assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="{base_url}assets/bootstrap_extras/select2/select2.full.min.js"></script>

    <!-- DataTables -->
    <script src="{base_url}assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{base_url}assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="{base_url}assets/js/table5/dataTables.buttons.min.js"></script>
    <script src="{base_url}assets/js/table5/buttons.bootstrap5.min.js"></script>
    <script src="{base_url}assets/js/table5/buttons.html5.min.js"></script>
    <script src="{base_url}assets/js/table5/buttons.print.min.js"></script>
    <script src="{base_url}assets/js/table5/buttonsvis.min.js"></script>

    <!-- Sortable -->
    <script src="{base_url}assets/js/Sortable.js"></script>

    <script src="{base_url}assets/dist/master.min.js"></script>

    <script src="{base_url}assets/g_template/js/moment.js"></script>
    <script src="{base_url}assets/plugins/daterangepicker/daterangepicker.js?ft=<?= filemtime('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>

    <!-- Main java Script -->
    <script src="{base_url}assets/js/ci_utilities.js?ft=<?= date('His') ?>"></script>

    <script>
        var baseURL = '{base_url}';
        var siteURL = '{site_url}';
        var csrf_token_name = '{csrf_token_name}';
        var csrf_cookie_name = '{csrf_cookie_name}';
        localStorage.setItem('lang_js', '<?= $this->session->userdata('language'); ?>')
        $.widget.bridge('uibutton', $.ui.button)
        var mobile = true;
    </script>

    {another_js}


</body>

</html>