/******************************* DATE LIMITATION ****************************************/
get_google_analytic_reports();

$('.get-report').click(function () {
    $('.acquisition').html('');
    $('.kewyord-analytic').html('');
    $('.visitor-analytic').html('');
    $('.langing-report-analytic').html('');
    get_google_analytic_reports();
});

/******************************* ACQUISATION REPORT *************************************/
function get_google_analytic_reports() {
    
    var endDate;
    var startDate;
    var current = new Date();
    var curr_date = current.getDate();
    var curr_month = current.getMonth() + 1;
    var curr_year = current.getFullYear();
    if ($('#start-date').val() && $('#end-date').val()) {
        endDate = $('#end-date').val();
        startDate = $('#start-date').val();
    } else {
        endDate = curr_year + '-' + curr_month + '-' + curr_date;
        current.setDate(current.getDate() - 30);
        startDate = current.getFullYear() + '-' + (current.getMonth() + parseInt(1)) + '-' + current.getDate();
    }
    $('.acquisition-loader img').css('display','block');
    $('.kewyord-analytic-loader img').css('display','block');
    $('.returningVsNew-loader img').css('display','block');
    $('.visitor-analytic-loader img').css('display','block');
    $('.langing-report-analytic-loader img').css('display','block');
    $('.bounce-exit-loader img').css('display','block');
    
    
    
    
    
    
    $.get(SITE_URL + "acquisation", {'start_date': startDate, 'end_date': endDate}, function (data, status) {

        var obj = JSON.parse(data);

        if (!obj.html && obj.link != '' && !obj.error) {
            $('.Outh-option').html('<a class="btn btn-success " href="' + obj.link + '">Please Authentication For Google Analytics And Webmaster Reports </a>');
            $('.date-option').hide();
        } else if (obj.html) {
            $('.Outh-option').hide();
            $('.date-option').show();
            $('.acquisition').html(obj.html);
             $('.acquisition-loader img').css('display','none');
            
        } else {
            $('.Outh-option').html('<div class="alert alert-danger ks-solid-light ks-active-borde"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Sorry!</strong>You google analytic account unable to connect.</div><a class="btn btn-success " href="' + obj.relink + '">Please Authentication For Google Analytics And Webmaster Reports </a>');
        }
    });
    /******************************* KEYWORDS REPORT *************************************/
    $.get(SITE_URL + "keywords", {'start_date': startDate, 'end_date': endDate}, function (data, status) {
        $('.kewyord-analytic').html(data);
        $('.kewyord-analytic-loader img').css('display','none');
    });

    /******************************* VISITOR REPORT *************************************/

    $.get(SITE_URL + "new-vs-return", {'start_date': startDate, 'end_date': endDate}, function (data, status) {
        $('.visitor-analytic').html(data);
        $('.visitor-analytic-loader img').css('display','none');
    });

    /******************************* LANDING REPORT *************************************/

    $.get(SITE_URL + "landing-page", {'start_date': startDate, 'end_date': endDate}, function (data, status) {
        $('.langing-report-analytic').html(data);
        $('.langing-report-analytic-loader img').css('display','none');
    });

    /******************************* NEW VS RETURNING VISITORS ******************************/
    google.charts.load('current', {'packages': ['corechart']});
    jQuery(document).ready(function () {
        $.get(SITE_URL + "returning-graph", {'start_date': startDate, 'end_date': endDate}, function (data, status) {
            if (data) {
                newVsReturning(JSON.parse(data));
            }
        });
    });
    function newVsReturning(chartData) {
        Highcharts.chart('returningVsNew', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
            },
            exporting: {enabled: false},
            xAxis: {
                categories: chartData.date,
                tickmarkPlacement: 'on',
                title: {
                    enabled: true
                }
            },
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    enabled: false
                }
            },
            tooltip: {
                valueSuffix: null,
                split: true
            },
            series: [chartData.NEW, chartData.RETURN]
        });
        $('.returningVsNew-loader img').css('display','none');
    }
    /******************************* DEVICE USER GRAPH ******************************/

    jQuery(document).ready(function () {
        $('.device_chart-loader img').css('display','block');
        $.get(SITE_URL + "device-perform", {'start_date': startDate, 'end_date': endDate}, function (data, status) {
            if (data) {
                deviceChart(JSON.parse(data));
            }
        });
    });
    function deviceChart(DtableData) {
        Highcharts.chart('device_chart', {
            chart: {
                type: 'area'
            },
            title: {
                text: '',
            },
            exporting: {enabled: false},
            xAxis: {
                categories: DtableData.date,
                tickmarkPlacement: 'on',
                title: {
                    enabled: false
                }
            },
            yAxis: {
                title: {
                    text: 'Session'
                },
            },
            tooltip: {
                valueSuffix: ' users',
                split: true
            },
            series: [DtableData.desktop, DtableData.mobile]
        });
        $('.device_chart-loader img').css('display','none');
    }


    /******************************* DEVICE USER GRAPH ******************************/

    jQuery(document).ready(function () {
        $.get(SITE_URL + "bounce-vs-exit", {'start_date': startDate, 'end_date': endDate}, function (data, status) {
            if (data) {
                bounceVsExitRate(JSON.parse(data));
            }
        });
    });
    function bounceVsExitRate(DtableData) {
        Highcharts.chart('bounce-exit', {
            chart: {
                type: 'area'
            },
            title: {
                text: '',
            },
            exporting: {enabled: false},
            xAxis: {
                categories: DtableData.date,
                tickmarkPlacement: 'on',
                title: {
                    enabled: false
                }
            },
            yAxis: {
                title: {
                    text: null,
                },
                labels: {
                    enabled: false,
                    formatter: function () {
                        return this.value;
                    }
                }
            },
            tooltip: {
                valueSuffix: '%',
                split: true
            },
            series: [DtableData.bounceRate, DtableData.exitRate]
        });
        $('.bounce-exit-loader img').css('display','none');
    }
    
}
/*************************************** WEBMASTER ****************************************/

jQuery(document).ready(function () {
    setTimeout(function () {
        var chartData = JSON.parse($('.sitemap').attr('site-index'));

        Highcharts.chart('site-map', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
            },
            exporting: {enabled: false},
            xAxis: {
                categories: chartData.type,
                tickmarkPlacement: 'on',
                title: {
                    enabled: true
                }
            },
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    enabled: false
                }
            },
            tooltip: {
                valueSuffix: null,
                split: true
            },
            series: [chartData.submitted, chartData.Indexed]
        });
    }, 3000);
});

jQuery(document).ready(function () {
    setTimeout(function () {
        var chartData = JSON.parse($('.ctr').attr('site-index'));

        Highcharts.chart('ctr-graph', {
            chart: {
                type: 'area'
            },
            title: {
                text: '',
            },
            exporting: {enabled: false},
            xAxis: {
                categories: chartData.date,
                tickmarkPlacement: 'on',
                title: {
                    enabled: false
                }
            },
            yAxis: {
                title: {
                    text: 'CTR',
                },
                labels: {
                    enabled: false,
                    formatter: function () {
                        return this.value;
                    }
                }
            },
            tooltip: {
                valueSuffix: '%',
                split: true
            },
            series: [chartData.CLICK]
        });
    }, 3000);
});