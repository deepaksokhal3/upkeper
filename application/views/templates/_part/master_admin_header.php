<!DOCTYPE html>
<html lang="en">

    <!-- BEGIN HEAD -->
    <head>
        <meta charset="UTF-8">
        <title>UpKepr-Web Toolkit+Maintenance</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="<?= site_url('assets/css/font-awesome.min.css'); ?>"  rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/bootstrap/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/fonts/line-awesome/css/line-awesome.min.css') ?>">
        <!--<link rel="stylesheet" type="text/css" href="assets/fonts/open-sans/styles.css">-->

        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/fonts/montserrat/styles.css') ?>">

        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/tether/css/tether.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/jscrollpane/jquery.jscrollpane.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/flag-icon-css/css/flag-icon.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/common.min.css') ?>">
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN THEME STYLES -->

        <link class="ks-sidebar-dark-style" rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/themes/sidebar-black.min.css') ?>">
        <!-- END THEME STYLES -->

        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/fonts/kosmo/styles.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/fonts/weather/css/weather-icons.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/c3js/c3.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/noty/noty.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/widgets/payment.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/widgets/panels.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/dashboard/tabbed-sidebar.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/themes/primary.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/custom.css') ?>">
        
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/datatables-net/media/css/dataTables.bootstrap4.min.css'); ?>"> <!-- original -->
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/libs/datatables-net/datatables.min.css'); ?>"> <!-- customization -->
        
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/summernote/summernote.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/libs/summernote/summernote.min.css') ?>">
        
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/select2/css/select2.min.css'); ?>"> <!-- Original -->
<link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/libs/select2/select2.min.css'); ?>"> <!-- Customization -->
        <script src="<?= site_url('assets/admin/jquery/jquery.min.js') ?>"></script>
        <script>
            var SITE_URL = '<?php echo site_url(); ?>';
        </script>
    </head>
    <!-- END HEAD -->
    <body class="ks-navbar-fixed ks-sidebar-empty ks-sidebar-position-fixed ks-page-header-fixed ks-theme-primary ks-page-loading"> <!-- remove ks-page-header-fixed to unfix header -->