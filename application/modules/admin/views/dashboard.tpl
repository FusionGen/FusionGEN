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
                <div class="chart chart-sm chart-active" data-graph-rel="Monthly" id="graphData1" style="height: 200px;"></div>
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

                <div class="chart chart-sm chart-hidden" data-graph-rel="Daily" id="graphData2" style="height: 200px;"></div>

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
        <table class="table table-sm table-borderless mb-0">
            <tbody>
            <tr>
                <td>Unique this month</td>
                <td class="text-end fw-semibold">{$unique.month}</td>
            </tr>
            <tr>
                <td>Views today</td>
                <td class="text-end fw-semibold">{$views.today}</td>
            </tr>
            <tr>
                <td>Views this month</td>
                <td class="text-end fw-semibold">{$views.month}</td>
            </tr>
            </tbody>
        </table>
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
        <table class="table table-sm table-borderless mb-0">
            <tbody>
            <tr>
                <td>Income last month</td>
                <td class="text-end fw-semibold">$ {$income.last}</td>
            </tr>
            <tr>
                <td>Votes this month</td>
                <td class="text-end fw-semibold">{$votes.this}</td>
            </tr>
            <tr>
                <td>Votes last month</td>
                <td class="text-end fw-semibold">{$votes.last}</td>
            </tr>
            </tbody>
        </table>
    </div>
</section>
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
        <table class="table table-sm table-borderless mb-0">
            <tbody>
            <tr>
                <td>Today</td>
                <td class="text-end fw-semibold">{$signups.today}</td>
            </tr>
            <tr>
                <td>This month</td>
                <td class="text-end fw-semibold">{$signups.this}</td>
            </tr>
            <tr>
                <td>Last month</td>
                <td class="text-end fw-semibold">{$signups.last}</td>
            </tr>
            </tbody>
        </table>
    </div>
</section>
</div>
</div>
</div>

<div class="col-lg-4 mb-3">
    <div class="card">
    <header class="card-header">
        <h2 class="card-title">System information</h2>
    </header>
    <div class="card-body">
        <table class="table table-sm table-borderless mb-0">
            <tbody>
                <tr>
                    <td>PHP version</td>
                    <td class="text-end fw-semibold">{$php_version}</td>
                </tr>
                <tr>
                    <td>CodeIgniter version</td>
                    <td class="text-end fw-semibold">{$ci_version}</td>
                </tr>
                <tr>
                    <td>Smarty version</td>
                    <td class="text-end fw-semibold">{$smarty.version}</td>
                </tr>
                <tr>
                    <td>CMS version</td>
                    <td class="text-end fw-semibold">{$version}</td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>

    <div class="card mt-3">
    <header class="card-header">
        <h2 class="card-title">Theme information</h2>
    </header>
    <div class="card-body">
    <table class="table table-sm table-borderless mb-0">
    <tbody>
        <tr>
            <td>Name</td>
            <td class="text-end fw-semibold">{$theme.name}</td>
        </tr>
        <tr>
            <td>Author</td>
            <td class="text-end fw-semibold"><a href="{$theme.website}" target="_blank">{$theme.author}</a></td>
        </tr>
    </tbody>
    </table>
    {if hasPermission("changeTheme")}
        <a href="{$url}admin/theme" class="btn btn-sm btn-primary mt-3">Change theme</a>
    {/if}
    </div>
    </div>
</div>

<div class="col-lg-8 mb-3">
    <section class="card">
        <header class="card-header">
            <div class="card-actions">
                <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
            </div>

            <h2 class="card-title">Latest FusionGEN updates</h2>
        </header>
        <div class="card-body scrollable" style="height: 350px;">
            <div id="fg-commits" class="lh-lg scrollable-content p-3">
            <script>
            $(function() {
                $('#fg-commits').githubInfoWidget(
                { user: 'FusionGen', repo: 'FusionGEN', branch: 'main', last: 40, limitMessageTo: 130 });
            });
            </script>
            </div>
        </div>
    </section>
</div>

<script>
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
</div>
