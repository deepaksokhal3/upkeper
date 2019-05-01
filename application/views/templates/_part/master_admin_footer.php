        
</body>
<script src="<?= site_url('assets/admin/jquery/jquery.min.js') ?>"></script>
<script src="<?= site_url('assets/admin/responsejs/response.min.js') ?>"></script>
<script src="<?= site_url('assets/admin/loading-overlay/loadingoverlay.min.js') ?>"></script>
<script src="<?= site_url('assets/admin/tether/js/tether.min.js') ?>"></script>
<script src="<?= site_url('assets/admin/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= site_url('assets/admin/jscrollpane/jquery.jscrollpane.min.js') ?>"></script>
<script src="<?= site_url('assets/admin/jscrollpane/jquery.mousewheel.js') ?>"></script>
<script src="<?= site_url('assets/admin/flexibility/flexibility.js') ?>"></script>
<script src="<?= site_url('assets/admin/noty/noty.min.js') ?>"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?= site_url('assets/admin/scripts/common.min.js') ?>"></script>
<script src="<?= site_url('assets/admin/scripts/commonfun.js') ?>"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script src="<?= site_url('assets/admin/datatables-net/media/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= site_url('assets/admin/datatables-net/media/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= site_url('assets/admin/d3/d3.min.js') ?>"></script>
<script src="<?= site_url('assets/admin/c3js/c3.min.js') ?>"></script>
<script src="<?= site_url('assets/admin/noty/noty.min.js') ?>"></script>
<script src="<?= site_url('assets/admin/maplace/maplace.min.js') ?>"></script>
<!--script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDvFu1GSsQ0_94r5QicoTtDr7Sz3jhtJqg" type="text/javascript"></script-->
<script src="<?= site_url('assets/admin/select2/js/select2.min.js'); ?>"></script>
<script src="<?= site_url('assets/admin/summernote/summernote.min.js') ?>"></script>
<script src="<?= site_url('assets/admin/jquery-form-validator/jquery.form-validator.min.js') ?>"></script>
<script type="application/javascript">
(function ($) {
    $(document).ready(function() {
        function formatRepo (repo) {
            if (repo.loading) return repo.text;

            var markup = "<div class='ks-search-result'>" +
                "<div class='ks-avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
                "<div class='ks-meta'>" +
                "<div class='ks-title'>" + repo.full_name + "</div>";

            if (repo.description) {
                markup += "<div class='ks-description'>" + repo.description + "</div>";
            }

            markup += "<div class='ks-statistics'>" +
                "<div class='ks-forks'><i class='la la-flash'></i> " + repo.forks_count + " Forks</div>" +
                "<div class='ks-stargazers'><i class='la la-star'></i> " + repo.stargazers_count + " Stars</div>" +
                "<div class='ks-watchers'><i class='la la-eye'></i> " + repo.watchers_count + " Watchers</div>" +
                "</div>" +
                "</div></div>";

            return markup;
        }

        function formatRepoSelection (repo) {
            return repo.full_name || repo.text;
        }

        function formatState (state) {
            if (!state.id) {
                return state.text;
            }

            var $state = $(
                '<span class="ks-user"><img src="assets/img/avatars/avatar-1.jpg" class="ks-avatar" /> <span class="ks-text">' + state.text + '</span></span>'
            );

            return $state;
        }

        $('select.ks-select').select2();

        $('select.ks-select-placeholder-single').select2({
            placeholder: "Select a state",
            allowClear: true
        });

        $('select.ks-select-placeholder-multiple').select2({
            placeholder: "Select a state"
        });

        $(".ks-load-remote-data").select2({
            ajax: {
                url: "https://api.github.com/search/repositories",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        });

        $('select.ks-select-limited-number-of-selections').select2({
            maximumSelectionLength: 2
        });

        $('select.ks-select-hiding-search-box').select2({
            minimumResultsForSearch: Infinity
        });

        $('select.ks-select-tagging-support').select2({
            tags: true
        });

        $('select.ks-select-rtl-support').select2({
            dir: 'rtl'
        });

        $('select.ks-select-templating').select2({
            templateResult: formatState
        });
    });
})(jQuery);
</script>
<script type="application/javascript">
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
<script type="application/javascript">
    (function ($) {
    $(document).ready(function() {
    $('#ks-datatable').DataTable({
    "initComplete": function () {
    $('.dataTables_wrapper select').select2({
    minimumResultsForSearch: Infinity
    });
    }
    });
    });
    })(jQuery);
    (function ($) {
    $('#ks-summernote-editor-default').summernote();
    $('#ks-summernote-editor-air-mode').summernote({
    airMode: true
    });
    $('#ks-summernote-editor-default-sms').summernote();

    })(jQuery);
</script>
<script type="application/javascript">
    (function ($) {
    $(document).ready(function() {
    $.validate({
    modules : 'location, date, security, file',
    onModulesLoaded : function() {

    }
    });
    $('#sms-template').restrictLength($('#ks-maxlength-label'));
    });
    })(jQuery);
</script>
<script type="application/javascript">
    (function ($) {
    $(document).ready(function() {
    $.validate({
    modules : 'location, date, security, file',
    onModulesLoaded : function() {

    }
    });
    //$('#ks-maxlength-area').restrictLength($('#ks-maxlength-label'));
    });
    })(jQuery);
</script>
<!--script type="application/javascript">
(function ($) {
    $(document).ready(function () {
        c3.generate({
            bindto: '#ks-next-payout-chart',
            data: {
                columns: [
                    ['data1', 6, 5, 6, 5, 7, 8, 7]
                ],
                types: {
                    data1: 'area'
                },
                colors: {
                    data1: '#81c159'
                }
            },
            legend: {
                show: false
            },
            tooltip: {
                show: false
            },
            point: {
                show: false
            },
            axis: {
                x: {show:false},
                y: {show:false}
            }
        });

        c3.generate({
            bindto: '#ks-total-earning-chart',
            data: {
                columns: [
                    ['data1', 6, 5, 6, 5, 7, 8, 7]
                ],
                types: {
                    data1: 'area'
                },
                colors: {
                    data1: '#4e54a8'
                }
            },
            legend: {
                show: false
            },
            tooltip: {
                show: false
            },
            point: {
                show: false
            },
            axis: {
                x: {show:false},
                y: {show:false}
            }
        });

        c3.generate({
            bindto: '.ks-chart-orders-block',
            data: {
                columns: [
                    ['Revenue', 150, 200, 220, 280, 400, 160, 260, 400, 300, 400, 500, 420, 500, 300, 200, 100, 400, 600, 300, 360, 600],
                    ['Profit', 350, 300,  200, 140, 200, 30, 200, 100, 400, 600, 300, 200, 100, 50, 200, 600, 300, 500, 30, 200, 320]
                ],
                colors: {
                    'Revenue': '#f88528',
                    'Profit': '#81c159'
                }
            },
            point: {
                r: 5
            },
            grid: {
                y: {
                    show: true
                }
            }
        });

        setTimeout(function () {
            new Noty({
                text: '<strong>Welcome to Kosmo Admin Template</strong>! <br> You successfully read this important alert message.',
                type   : 'information',
                theme  : 'mint',
                layout : 'topRight',
                timeout: 3000
            }).show();
        }, 1500);

        var maplace = new Maplace({
            map_div: '#ks-payment-widget-table-and-map-map',
            controls_on_map: false
        });
        maplace.Load();
    });
})(jQuery);
</script-->
