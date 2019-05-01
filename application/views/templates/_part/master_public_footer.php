<footer>
    <!--ul class="list-inline">
            <li><img src="assets/images/facebook.png"></li>
            <li><img src="assets/images/twitter.png"></li>
            <li><img src="assets/images/linkedin.png"></li>
            <li><img src="assets/images/google-plus.png"></li>
    </ul-->
    <p>UpKepr©2018 , a venture of webgarh solutions</p>
</footer>       
</body>
</html>
<script>
    $(document).ready(function () {
        if($('.ks-page-container').height() < 900){
            $('.ks-page-container').css('min-height', '900px');
        }
//          if ($('.ks-page-container').height() < ($(window).height())) {
//               $('.ks-page-container').css('height', '85%');
//            }else{
//               $('.ks-page-container').css('height', 'auto');;
//            }
//        $(document).live('click', 'body', function () {
//            if ($('.ks-page-container').height() < ($(window).height())) {
//               $('.ks-page-container').css('height', '85%');
//            }else{
//               $('.ks-page-container').css('height', 'auto');;
//            }
//        });
    });
</script>
<script src="<?= site_url('assets/public/responsejs/response.min.js') ?>"></script>
<script src="<?= site_url('assets/public/loading-overlay/loadingoverlay.min.js') ?>"></script>
<script src="<?= site_url('assets/public/tether/js/tether.min.js') ?>"></script>
<script src="<?= site_url('assets/public/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= site_url('assets/public/jscrollpane/jquery.jscrollpane.min.js') ?>"></script>
<script src="<?= site_url('assets/public/jscrollpane/jquery.mousewheel.js') ?>"></script>
<script src="<?= site_url('assets/public/flexibility/flexibility.js') ?>"></script>
<script src="<?= site_url('assets/public/noty/noty.min.js') ?>"></script>
<script src="<?= site_url('assets/public/jquery/jquery-ui.min.js') ?>"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?= site_url('assets/public/scripts/common.min.js') ?>"></script>
<script src="<?= site_url('assets/public/scripts/commonfun.js') ?>"></script>
<script src="<?= site_url('assets/public/scripts/profile.js') ?>"></script>
<script src="<?= site_url('assets/public/js/project.js') ?>"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script src="<?= site_url('assets/public/sweet-alert/sweetalert.js') ?>"></script>

<script src="<?= site_url('assets/public/izi-modal/js/iziModal.min.js'); ?>"></script>
<script src="<?= site_url('assets/public/d3/d3.min.js') ?>"></script>
<script src="<?= site_url('assets/public/c3js/c3.min.js') ?>"></script>
<script src="<?= site_url('assets/public/noty/noty.min.js') ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDvFu1GSsQ0_94r5QicoTtDr7Sz3jhtJqg" type="text/javascript"></script>
<script src="<?= site_url('assets/public/jquery-form-validator/jquery.form-validator.min.js') ?>"></script>
<script src="<?= site_url('assets/public/flatpickr/flatpickr.min.js'); ?>"></script>
<script src="<?= site_url('assets/admin/summernote/summernote.min.js') ?>"></script>
<script type="">
    (function ($) {
    $(document).ready(function() {
    $.validate({
    modules : 'location, date, security, file',
    onModulesLoaded : function() {

    }
    });
    $('#ks-maxlength-area').restrictLength($('#ks-maxlength-label'));
    });
    })(jQuery);
</script>
<script>
    (function ($) {
        $('#ks-izi-modal-success').iziModal();
//        if (LOGS == 0) {
//            $('#ks-izi-modal-success').iziModal('open');
//        }
        $('#ks-summernote-editor-default').summernote();
        $('#ks-summernote-editor-air-mode').summernote({
            airMode: true
        });
        $('#ks-summernote-editor-default-sms').summernote();

    })(jQuery);
</script>
<script>
    $(document).ready(function () {
        $('.config-host-exp').flatpickr();
        $('.config-host').click(function () {
            $('.host-config-sec').toggle();
            $('#datepic').flatpickr();
        });
    });
    (function ($) {
        $(document).ready(function () {

            $('.flatpickr1').flatpickr();
            $('.flatpickr').flatpickr();
        });
    })(jQuery);
</script>
<script>
    function goBack() {
        window.history.back();
    }

</script>



