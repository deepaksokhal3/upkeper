<!DOCTYPE html>
<html lang="en">

    <!-- BEGIN HEAD -->
    <head>
        <meta charset="UTF-8">
        <title><?= isset($metatitle) ? $metatitle : 'UpKepr | Monitor Your Web Assests '; ?></title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="google-site-verification" content="CHPt-kUuTUmF8dSSXLerGfCu-h63e5zwnFoYdcnKidk" />
        <meta name="msvalidate.01" content="465339B23D8E4D8D380096F6230F42B3" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="<?= site_url('assets/images/favicon.png') ?>" type="image/gif">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/bootstrap/css/bootstrap.min.css') ?>">
       

        <link href="<?= site_url('assets/css/font-awesome.min.css'); ?>"  rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/fonts/line-awesome/css/line-awesome.min.css') ?>">
        <!--<link rel="stylesheet" type="text/css" href="assets/fonts/open-sans/styles.css">-->

        <!--link rel="stylesheet" type="text/css" href="<?php //site_url('assets/public/fonts/montserrat/styles.css')    ?>"-->

        <!--<link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/tether/css/tether.min.css') ?>">-->
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/jscrollpane/jquery.jscrollpane.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/styles/common.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/styles/pages/auth.min.css') ?>">
        <!-- END GLOBAL MANDATORY STYLES -->

<!--        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/datatables-net/media/css/dataTables.bootstrap4.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/styles/libs/datatables-net/datatables.min.css') ?>">-->
        <!-- END THEME STYLES -->

        <!--link rel="stylesheet" type="text/css" href="<?php // site_url('assets/public/fonts/weather/css/weather-icons.min.css')    ?>"-->
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/styles/themes/primary.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php site_url('assets/public/styles/custom.css') ?>">
         <link href="<?= site_url('assets/css/style.css'); ?>" rel="stylesheet">
        <link class="ks-sidebar-dark-style" rel="stylesheet" type="text/css" href="<?= site_url('assets/public/styles/themes/sidebar-black.min.css') ?>">
        <!-- END THEME STYLES -->

        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/styles/form/steps/progress.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/bootstrap-table/bootstrap-table.min.css') ?>"> <!-- Original -->
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/styles/libs/bootstrap-table/bootstrap-table.min.css') ?>"> <!-- Customization -->
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/izi-modal/css/iziModal.min.css'); ?>"> <!-- Original -->
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/styles/libs/izi-modal/izi-modal.min.css'); ?>"> <!-- Original -->

        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/flatpickr/flatpickr.min.css'); ?>"> <!-- original -->
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/styles/libs/flatpickr/flatpickr.min.css'); ?>"> <!-- customization -->
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/sweet-alert/sweetalert.css') ?>"> <!-- Original -->
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/summernote/summernote.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= site_url('assets/public/styles/libs/summernote/summernote.min.css') ?>">



        <script src="<?= site_url('assets/public/jquery/jquery.min.js') ?>"></script>
        <script src="<?= site_url('assets/public/js/credential.js') ?>"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        
        <!---------------- Google analytics code ---------------->
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111954110-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-111954110-1');
        </script>
        <!---------------- End Google analytics code ---------------->
        
        <?php $token = $this->session->userdata('google_access'); ?>
        <script>
            var LOGS = '<?= isset($project_counter)?$project_counter:0;?>';
            var SITE_URL = '<?php echo site_url(); ?>';
            var AUTH_TOKEN = '<?= isset($token['access_token']) ? $token['access_token'] : ''; ?>';
            var VIEW_ID = '<?= isset($token['VIEWID']) ? $token['VIEWID'] : ''; ?>';
        </script>
    </head>
    <!-- END HEAD -->
    <body class="ks-navbar-fixed ks-sidebar-empty ks-sidebar-position-fixed ks-page-header-fixed ks-theme-primary ks-page-loading"> 