<?php
try{
    set_time_limit(0);
   // Including Google Analytics SDK
    require_once PLUGINPATH.'ga-sdk/Google_Client.php';
    require_once PLUGINPATH.'ga-sdk/contrib/Google_AnalyticsService.php';
    $client = new Google_Client();
    $client->setApplicationName('FX Digital');
    $client->setAccessType('offline');
    $client->setUseObjects(true);
    // Reading plugin settings from option variable
    $ganalytics_settings = get_option('ganalytics_settings');
    $redirect_url = get_bloginfo('wpurl').'/wp-admin/admin.php?page=fxd_setting';
    if(!$ganalytics_settings['use_own_api']){
        $formtype = 'code';
        $client->setClientId('76132870952-crrv4ap1tr6puq5hsmft6n1svaqfc6nv.apps.googleusercontent.com');
        $client->setClientSecret('Y_jQ1ZN_AT-SW3zWz2hmTPuM');
        $client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
    }else{
        $formtype = 'api';
        $client->setClientId($ganalytics_settings['google_client_id']);
        $client->setClientSecret($ganalytics_settings['google_client_secret']);
        $client->setDeveloperKey($ganalytics_settings['google_api_key']);
    }
    $analytics = new Google_AnalyticsService($client);
    // Setting Access Token
    $access_token = $ganalytics_settings['google_access_token'];
    ?>
<div class='wrap ganalytics dashboard'>
<div class="icon32 ga-header-app-icon"></div>
    <?php
    if($access_token){
        try{
            $client->setAccessToken($access_token);
            $blog_domain_property =  $ganalytics_settings['ga_active_web_property']; ?>  <div class="ga-header-block-wrapper">
            <?php
            // PHP code to fetch figures for dashboard header block
            $timestamp_3months_end = time() - 86400;
            $timestamp_3months_start = $timestamp_3months_end - 7776000;
            $timestamp_6months_end = $timestamp_3months_start - 86400;
            $timestamp_6months_start = $timestamp_6months_end - 7776000;
            $date_3months_start = date('Y-m-d',$timestamp_3months_start);
            $date_3months_end = date('Y-m-d',$timestamp_3months_end);
            $date_6months_start = date('Y-m-d',$timestamp_6months_start);
            $date_6months_end = date('Y-m-d',$timestamp_6months_end);
            $results_3months = $analytics->data_ga->get(
                'ga:'.$ganalytics_settings['ga_profile_id'],
                $date_3months_start,
                $date_3months_end,
                'ga:visits,ga:pageviews,ga:avgTimeOnSite,ga:entranceBounceRate');
            $results_6months = $analytics->data_ga->get(
                'ga:'.$ganalytics_settings['ga_profile_id'],
                $date_6months_start,
                $date_6months_end,
                'ga:visits,ga:pageviews,ga:avgTimeOnSite,ga:entranceBounceRate');
            //fetching results - last 3 months
            $visits_3month = (int)$results_3months->rows[0][0];
            $pageviews_3month = (int)$results_3months->rows[0][1];
            $visitdur_3month = (int)$results_3months->rows[0][2];
            $bouncerate_3month = round((float)$results_3months->rows[0][3],2);
            //fetching results - last 6 months
            $visits_6month = (int)$results_6months->rows[0][0];
            $pageviews_6month = (int)$results_6months->rows[0][1];
            $visitdur_6month = (int)$results_6months->rows[0][2];
            $bouncerate_6month = round((float)$results_6months->rows[0][3],2);
            //calculate visit data
            $diff_visits = $visits_3month - $visits_6month;
            $change_diff_visits = "up";
            $change_icon_visits = "&#9650;";
            if($diff_visits < 0){
                $change_diff_visits = "down";
                $change_icon_visits = "&#9660;";
            }
            else{
                $change_diff_visits = "up";
                $change_icon_visits = "&#9650;";
            }
            $formatted_visits_3month = number_format(abs($visits_3month));
            $formatted_diff_visits = number_format(abs($diff_visits));
            //calculate page view data
            $diff_pageviews = $pageviews_3month - $pageviews_6month;
            $change_diff_pageviews = "up";
            $change_icon_pageviews = "&#9650;";
            if($diff_pageviews < 0){
                $change_diff_pageviews = "down";
                $change_icon_pageviews = "&#9660;";
            }
            else{
                $change_diff_pageviews = "up";
                $change_icon_pageviews = "&#9650;";
            }
            $formatted_pageviews_3month = number_format(abs($pageviews_3month));
            $formatted_diff_pageviews = number_format(abs($diff_pageviews));
            //calculate average visit duration
            $diff_timeduration = $visitdur_3month - $visitdur_6month;
            $change_diff_visitduration = "up";
            $change_icon_visitduration = "&#9650;";
            if($diff_timeduration < 0){
                $change_diff_visitduration = "down";
                $change_icon_visitduration = "&#9660;";
            }else{
                $change_diff_visitduration = "up";
                $change_icon_visitduration = "&#9650;";
            }
            if($visitdur_3month != 0){
                $percentage_diff_timeduration = abs(round(($diff_timeduration/$visitdur_3month)*100,2));
            }else{
                $percentage_diff_timeduration = 0;
            }
            $formatted_visit_duration_3months = gmdate("H:i:s",$visitdur_3month);
            $formatted_diff_visit_duration = $percentage_diff_timeduration.'%';
            //calculate bounce rate
            $diff_bouncerate = $bouncerate_3month - $bouncerate_6month;
            $change_icon_bouncerate = "&#9650;";
            if($diff_bouncerate < 0){
                $change_icon_bouncerate = "&#9660;";
            }
            else {
                $change_icon_bouncerate = "&#9650;";
            }
            $formatted_bouncerate_3months = $bouncerate_3month.'%';
            $formatted_diff_bouncerate = abs($diff_bouncerate).'%';
            ?>
            <table class="form-table">
                <tbody>
                <tr>
                 <td class="ga-header-table-cell">
                        <div class="ga-header-title">
                            Page Visits
                            <img src="<?php echo PLUGIN_URL; ?>/assets/img/help-icon.png" class="tooltip" title="Number of visits during last 3 months time period. The change shows the difference compared to previous 3 month time period."/>
</div>                  <div class="ga-header-value">                            <span class="ga-header-value-current">
                                <?php echo $formatted_visits_3month; ?>
                            </span>
                            <span class="ga-header-value-change change-<?php echo $change_diff_visits; ?>"><?php echo $change_icon_visits; ?> <?php echo $formatted_diff_visits; ?></span>
</div> </td><td class="ga-header-table-cell">
<div class="ga-header-title"> Page Views
<img src="<?php echo PLUGIN_URL; ?>/assets/img/help-icon.png" class="tooltip"
title="Number of page views during last 3 months time period. The change shows the difference compared to previous 3 month time period."/>
</div><div class="ga-header-value"> <span class="ga-header-value-current">
<?php echo $formatted_pageviews_3month; ?> </span> <span class="ga-header-value-change change-<?php echo $change_diff_pageviews; ?>"><?php echo $change_icon_pageviews ?> <?php echo $formatted_diff_pageviews; ?> </span></div>
 </td><td class="ga-header-table-cell"><div class="ga-header-title"> Avg. Visit Duration<img src="<?php echo PLUGIN_URL; ?>/assets/img/help-icon.png" class="tooltip"title="Time of average visit duration during last 3 months time period. The change shows the difference compared to previous 3 month time period."/>
 </div> <div class="ga-header-value"> <span class="ga-header-value-current"> <?php echo $formatted_visit_duration_3months; ?>  </span><span class="ga-header-value-change change-<?php echo $change_diff_visitduration; ?>">
 <?php echo $change_icon_visitduration; ?> <?php echo $formatted_diff_visit_duration; ?> </span></div></td><td class="ga-header-table-cell"><div class="ga-header-title"> Bounce Rate<img src="<?php echo PLUGIN_URL; ?>/assets/img/help-icon.png" class="tooltip"
title="Percentage of bounce rate during last 3 months time period. The change shows the difference compared to previous 3 month time period."/></div>
<div class="ga-header-value"><span class="ga-header-value-current">
<?php echo $formatted_bouncerate_3months; ?>
</span><span class="ga-header-value-change"><?php echo $change_icon_bouncerate; ?> <?php echo $formatted_diff_bouncerate; ?></span></div>
</td></tr></tbody></table></div><div class="ga-visits-graph-wrapper">
 <?php $results_visits_graph = $analytics->data_ga->get(
                'ga:'.$ganalytics_settings['ga_profile_id'],
                 $date_3months_start,
                $date_3months_end,
                'ga:visits',
                array(
                    'dimensions' => 'ga:date'
                ));
            ?>
            <div id="visits_chart_div" style="width: 100%; height: 250px;"></div>
            <script type="text/javascript">
                google.load("visualization", "1", {packages:["corechart"]});
                google.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Date', 'Visits']
                        <?php
                        foreach($results_visits_graph->getRows() as $key=>$row){
                            $year = substr($row[0],0,4);
                            $month = substr($row[0],4,2);
                            $day = substr($row[0],6,2);
                            $date = date('M j, Y',strtotime("$day.$month.$year"));
                            echo ",['$date',{$row[1]}]";
                        }
                        ?>
                    ]);
                    var options = {
                        chartArea : {width: "90%"},
                        fontSize : 11,
                        hAxis: {
                            showTextEvery: 30,
                            format:'MMM d, y'
                        },
                        legend : {position: 'none'},
                        title: 'Visits: Last 3 Months',
                        vAxis:{
                            gridlines:{
                                count : 5,
                                color : '#eee'
                            },
                            minValue : 0,
                            baselineColor: "#999"
                        }
                    };
                    var chart = new google.visualization.AreaChart(document.getElementById('visits_chart_div'));
                    chart.draw(data, options);
                }
            </script>
        </div>
            <?php
        }
        catch(Exception $e){
            ?>
        <div class="updated below-h2">
            <p>Plugin could not connect to Google Analytics. Please visit <a href="<?php echo $redirect_url; ?>">settings</a> page to check connection status.
            </p>
        </div>
            <?php
        }}else{
        ?>
    <div class="updated below-h2">
        <p>Please update <a href="<?php echo $redirect_url; ?>">Analytics Settings</a>. Once you are connected, you can view your important .Google Analytics statistics here.
</p></div>
<?php
}?>
</div>
<?php
}
catch(Exception $e){
    ?>
<div class="updated below-h2" style="margin-left: 0px;">
    <p> Plugin could not connect to Google Analytics. Please visit <a href="<?php echo $redirect_url; ?>">settings</a> page to check connection status.
    </p>
</div>
<?php
}
?>