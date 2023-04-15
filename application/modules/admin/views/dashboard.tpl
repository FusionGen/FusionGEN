<div class="row">

<div id="soapcheck"></div>

<div class="col-lg-8">

{if $graphMonthly}
<div class="row mb-3">
<section class="card">
    <div class="card-body">
        <div class="chart-data-selector" id="graphSelectorWrapper">
            <h2>
                Visitors:
                <small class="float-end">
                    <select class="form-control" id="graphSelector">
                        <option value="Monthly" selected>Monthly</option>
                        <option value="Daily">Daily</option>
                    </select>
                </small>
            </h2>

            <div id="visitorsSelectorItems" class="chart-data-selector-items mt-3">
                <div class="chart chart-sm" data-graph-rel="Monthly" id="graphData1" class="chart-active" style="height: 200px;"></div>
                <script>
                    var monthNames = ["", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    var monthlyData = [{
                        data: [
                            {foreach from=$graphMonthly item=data key=key}
                                {if isset($data["month"])}
                                    {foreach from=$data["month"] item=month key=keyMonth}
                                        ["{$key}-" + monthNames[{$keyMonth}], {$month}],
                                    {/foreach}
                                {else}
                                    ["{$key}-" + monthNames[{$keyMonth}], {$month}],
                                {/if}
                            {/foreach}
                        ],
                        color: "#0088cc"
                    }];
                </script>

                <div class="chart chart-sm" data-graph-rel="Daily" id="graphData2" class="chart-hidden" style="height: 200px;"></div>

                <script>
                    var dailyData = [{
                        data: [
                            {foreach from=$graphDaily item=day key=key}
                                ["{$key}", {$day}],
                            {/foreach}
                        ],
                        color: "#0088cc"
                    }];
                </script>
            </div>
        </div>
    </div>
</section>
</div>     

<script>
    (function($) {

    'use strict';

    $('#graphSelector').themePluginMultiSelect().on('change', function() {
        var rel = $(this).val();
        $('#visitorsSelectorItems .chart').removeClass('chart-active').addClass('chart-hidden');
        $('#visitorsSelectorItems .chart[data-graph-rel="' + rel + '"]').addClass('chart-active').removeClass('chart-hidden');
    });

    $('#graphSelector').trigger('change');

    $('#graphSelectorWrapper').addClass('ready');

    if( $('#graphData1').get(0) )
    {
        var graphData1 = $.plot('#graphData1', monthlyData, {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2
                },
                points: {
                    show: true
                },
                shadowSize: 0
            },
            grid: {
                hoverable: true,
                clickable: true,
                borderColor: 'rgba(0,0,0,0.1)',
                borderWidth: 1,
                labelMargin: 15,
                backgroundColor: 'transparent'
            },
            yaxis: {
                min: 0,
                color: 'rgba(0,0,0,0.1)'
            },
            xaxis: {
                mode: 'categories',
                color: 'rgba(0,0,0,0)'
            },
            legend: {
                show: false
            },
            tooltip: true,
            tooltipOpts: {
                content: '%x: %y',
                shifts: {
                    x: -30,
                    y: 25
                },
                defaultTheme: false
            }
        });

    }

    if( $('#graphData2').get(0) )
    {
        var graphData2 = $.plot('#graphData2', dailyData, {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2
                },
                points: {
                    show: true
                },
                shadowSize: 0
            },
            grid: {
                hoverable: true,
                clickable: true,
                borderColor: 'rgba(0,0,0,0.1)',
                borderWidth: 1,
                labelMargin: 15,
                backgroundColor: 'transparent'
            },
            yaxis: {
                min: 0,
                color: 'rgba(0,0,0,0.1)',
                tickDecimals: 0
            },
            xaxis: {
                mode: 'categories',
                color: 'rgba(0,0,0,0)'
            },
            legend: {
                show: false
            },
            tooltip: true,
            tooltipOpts: {
                content: '%x: %y',
                shifts: {
                    x: -30,
                    y: 25
                },
                defaultTheme: false
            }
        });
    }
}).apply(this, [jQuery]);
</script>
{/if}

<div class="row">
<div class="col-lg-6 col-xl-4">
<section class="card card-featured-left card-featured-danger mb-3">
    <div class="card-body">
        <div class="widget-summary">
            <div class="widget-summary-col">
                <div class="summary">
                    <h4 class="title">Unique Visitors today</h4>
                    <div class="info">
                        <strong class="amount">{$unique.today}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="padding:0;">
            <table class="table table-sm table-borderless">
            <tbody>
            <tr>
                <td>Unique this month</td>
                <td>{$unique.month}</td>
            </tr>
            <tr>
                <td>Views today</td>
                <td>{$views.today}</td>
            </tr>
            <tr>
                <td>Views this month</td>
                <td>{$views.month}</td>
            </tr>
            </tbody>
            </table>
        </div>
    </div>
</section>
</div>

<div class="col-lg-6 col-xl-4">
<section class="card card-featured-left card-featured-primary mb-3">
    <div class="card-body">
        <div class="widget-summary">
            <div class="widget-summary-col">
                <div class="summary">
                    <h4 class="title">Income this month</h4>
                    <div class="info">
                        <strong class="amount">{$income.this}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="padding:0;">
            <table class="table table-sm table-borderless">
            <tbody>
            <tr>
                <td>Income last month</td>
                <td>$ {$income.last}</td>
            </tr>

            <tr>
                <td>Votes this month</td>
                <td>{$votes.this}</td>
            </tr>
            <tr>
                <td>Votes last month</td>
                <td>{$votes.last}</td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>

<div class="col-lg-6 col-xl-4">
<section class="card card-featured-left card-featured-warning mb-3">
    <div class="card-body">
        <div class="widget-summary">
            <div class="widget-summary-col">
                <div class="summary">
                    <h4 class="title">Registrations today</h4>
                    <div class="info">
                        <strong class="amount">{$signups.today}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="padding:0;">
            <table class="table table-sm table-borderless">
            <tbody>
            <tr>
                <td>Today</td>
                <td>{$signups.today}</td>
            </tr>
            <tr>
                <td>This month</td>
                <td>{$signups.this}</td>
            </tr>
            <tr>
                <td>Last month</td>
                <td>{$signups.last}</td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>
</div>
</div>

<div class="col-lg-4 mb-3">
    <div class="card">
    <header class="card-header">
        <h2 class="card-title">System information</h2>
    </header>
    <div class="card-body">
        <table class="table table-sm table-borderless">
            <tbody style="border-top:none;">
                <tr>
                    <td>PHP version</td>
                    <td style="text-align:right;">{$php_version}</td>
                </tr>
                <tr>
                    <td>CodeIgniter version</td>
                    <td style="text-align:right;">{$ci_version}</td>
                </tr>
                <tr>
                    <td>CMS version</td>
                    <td style="text-align:right;">{$version}</td>
                </tr>
            </tbody>
        </table>
    <div class="fusion-update"></div>
    </div>
    </div>

    <div class="card mt-3">
    <header class="card-header">
        <h2 class="card-title">Theme information</h2>
    </header>
    <div class="card-body">
    <table class="table table-sm table-borderless">
    <tbody style="border-top:none;">
        <tr>
            <td>Name</td>
            <td>{$theme.name}</td>
        </tr>
        <tr>
            <td>Author</td>
            <td><a href="{$theme.website}" target="_blank">{$theme.author}</a></td>
        </tr>
    </tbody>
    </table>
    {if hasPermission("changeTheme")}
        <a href="{$url}admin/theme" class="mb-1 mt-1 me-1 btn btn-sm btn-primary">Change theme</a>
    {/if}
    </div>
    </div>
</div>

<div class="col-lg-6 mb-3">
    <section class="card">
        <header class="card-header">
            <div class="card-actions">
                <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
            </div>
    
            <h2 class="card-title">FusionGen News</h2>
        </header>
        <div class="card-body news-loading-overlay scrollable" style="height: 300px;" ic-get-from="https://fusiongen.net/api/news" ic-target="#ScrollableNews" ic-trigger-on="load" ic-trigger-delay="1500ms">
            <div id="ScrollableNews" class="scrollable-content p-2">
            </div>
        </div>
    </section>
</div>

<div class="col-lg-6">
    <section class="card">
        <header class="card-header">
            <div class="card-actions">
                <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
            </div>
    
            <h2 class="card-title">FusionGen Market newest items</h2>
        </header>
        <div class="card-body market-loading-overlay scrollable" style="height: 300px;" ic-get-from="https://fusiongen.net/api/market" ic-target="#ScrollableMarket" ic-trigger-on="load" ic-trigger-delay="1500ms">
            <div id="ScrollableMarket" class="scrollable-content p-2">
            </div>
        </div>
    </section>
</div>

</div>

<script>
(function ($) {
    'use strict';

    $('.news-loading-overlay, .market-loading-overlay').loadingOverlay({
        startShowing: true,
        css: {
            'color': '#000',
            'backgroundColor': '#2e353e'
        }
    });
}).apply(this, [jQuery]);
</script>

<script type="text/javascript">
    var checkSoap = {
        check: function() {
            $.get(Config.URL + "admin/checkSoap", function(data) {        
                try {
                    if(data.includes("Something")) {
                        $("#soapcheck").html('<div class="alert alert-danger alert-dismissible fade show text-center" role="alert"><a href="'+ Config.URL +'admin/checkSoap" class="alert-link"><strong>Oh no!</strong> Looks like a realm has a soap problem!</a></div>');
                    }
                } catch(e) {
                    console.log(e);
                }
            });
        }
    }

    checkSoap.check();
</script>
