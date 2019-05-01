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
    $.ajax({
        Type: "get",
        url: SITE_URL + "acquisation",
        async: false,
        data: {'start_date': startDate, 'end_date': endDate},
        success: function (data) {
            try {
                var obj = JSON.parse(data);
                if (!obj.html && obj.link != '' && !obj.error) {
                    $('.Outh-option').html('<a class="btn btn-success " href="' + obj.link + '">Please Authentication For Google Analytics And Webmaster Reports </a>');
                    $('.date-option').hide();
                } else if (obj.html) {
                    $('.Outh-option').hide();
                    $('.date-option').show();
                    $('.acquisition').html(obj.html);
                } else {
                    $('.Outh-option').html('<div class="alert alert-danger ks-solid-light ks-active-borde"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Sorry!</strong>You google analytic account unable to connect.</div><a class="btn btn-success " href="' + obj.relink + '">Please Authentication For Google Analytics And Webmaster Reports </a>');
                }
            } catch (err) {
                console.log(err.message);
            }
        }
    });
    /******************************* KEYWORDS REPORT *************************************/
    $.ajax({
        type: "get",
        url: SITE_URL + "keywords",
        async: false,
        data: {'start_date': startDate, 'end_date': endDate},
        success: function (data) {
            try {
                $('.kewyord-analytic').html(data);
            } catch (err) {
                console.log(err.message);
            }
        }
    });
    /******************************* VISITOR REPORT *************************************/

    $.ajax({
        type: "get",
        url: SITE_URL + "new-vs-return",
        async: false,
        data: {'start_date': startDate, 'end_date': endDate},
        success: function (data) {
            try {
                $('.visitor-analytic').html(data);
            } catch (err) {
                console.log(err.message);
            }
        }
    });
    /******************************* LANDING REPORT *************************************/

    $.ajax({
        type: "get",
        url: SITE_URL + "landing-page",
        data: {'start_date': startDate, 'end_date': endDate},
        async: false,
        success: function (data) {
            try {
                $('.langing-report-analytic').html(data);
            } catch (err) {
                console.log(err.message);
            }
        }
    });
    /******************************* NEW VS RETURNING VISITORS ******************************/
    google.charts.load('current', {'packages': ['corechart']});
    jQuery(document).ready(function () {
        $.ajax({
            type: "get",
            url: SITE_URL + "returning-graph",
            data: {'start_date': startDate, 'end_date': endDate},
            async: false,
            success: function (data) {
                try {
                    if (data) {
                        newVsReturning(JSON.parse(data));
                    }
                } catch (err) {
                    console.log(err.message);
                }
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
    }
    /******************************* DEVICE USER GRAPH ******************************/

    jQuery(document).ready(function () {

        $.ajax({
            type: "get",
            url: SITE_URL + "device-perform",
            data: {'start_date': startDate, 'end_date': endDate},
            async: false,
            success: function (data) {
                try {
                    if (data) {
                        deviceChart(JSON.parse(data));
                    }
                } catch (err) {
                    console.log(err.message);
                }
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
    }


    /******************************* DEVICE USER GRAPH ******************************/

    jQuery(document).ready(function () {
        $.ajax({
            type: "get",
            url: SITE_URL + "bounce-vs-exit",
            data: {'start_date': startDate, 'end_date': endDate},
            async: false,
            success: function (data) {
                try {
                    if (data) {
                        bounceVsExitRate(JSON.parse(data));
                    }
                } catch (err) {
                    console.log(err.message);
                }
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
    }
}
/*************************************** WEBMASTER ****************************************/

jQuery(document).ready(function () {
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
});
jQuery(document).ready(function () {
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

});