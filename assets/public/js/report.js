/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



jQuery(document).ready(function () {
    setTimeout(function () {
        var chartData = JSON.parse($('.sitemap').attr('site-index'));
        // debugger;

        Highcharts.chart('site-map', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Sitemaps Submitted and Indexed content',
                style: {
                    fontSize: '25',
                    fontWeight: 'bold',
                    color: '#000000',
                }
            },
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
                text: 'Click Through Rate',
                style: {
                    fontSize: '25',
                    fontWeight: 'bold',
                    color: '#000000',
                }
            },
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