<?php
require_once('TwitterAPIExchange.php');
require_once('config.php');

$settings = array(
    'oauth_access_token' => TOKEN,
    'oauth_access_token_secret' => TOKEN_SECRET,
    'consumer_key' => CONSUMER_KEY,
    'consumer_secret' => CONSUMER_SECRET
);

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/

$username = $_POST['username']; // train_109_tyk
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=' . $username .'&count=50';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod);

$tweet_data = $twitter->performRequest();

$tweet_data = json_decode($tweet_data, true); //getting the file content as array

$dateArr = array();
$dateArr_unique = array();
$dateArr_final = array();

///////////////////////////////////////////
for ($i=0; $i < count($tweet_data); $i++) {
    $date = strtotime($tweet_data[$i]['created_at']);
    $date = date('d/m/Y', $date);

    array_push($dateArr, $date);

    // add an element $dateArr_unique if not there already
    if(!in_array($date, $dateArr_unique) && count($dateArr_unique) < 10 ) {
        $dateArr_unique[$date] = $date;
    }
}
///////////////////////////////////////////

// resets the values in $dateArr_unique to 0
foreach ($dateArr_unique as $key => $value) { 
    if ($key == $value) {
        $dateArr_unique[$key] = "0";
    } 
}

// Changes the keys to $dateArr_unique to a date and counts unique # of days
foreach ($dateArr as $key => $value) {
    foreach ($dateArr_unique as $unique_key => $unique_value) {
        if ($value == $unique_key) {
            $dateArr_unique[$unique_key] = $unique_value + 1;
        }
    }
}

// grabs dats from $dataArr_unique and places them in the final array as a 2D array
//for ($i=0; $i < count($dateArr_unique); $i++) {
foreach ($dateArr_unique as $key => $value) {
    array_push($dateArr_final, array($key, $value));
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Twitter User Results</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery-2.0.3.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="js/globalize.js"></script>
    <script src="js/dx.chartjs.js"></script>
</head>
<body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class=""><a href="index.php">Home</a></li>
            <li class="active"><a href="#">Result for "<?php echo $username ?>"</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
        <script>
            $(function ()  
                {
   var dataSource = [
    { day: "<?php echo $username ?>", <?php foreach ($dateArr_final as $final) echo '"' . $final[0] . '": ' . $final[1] . ", "; ?>} 
];

$("#chartContainer").dxChart({
    dataSource: dataSource,
    commonSeriesSettings: {
        argumentField: "day",
        type: "bar",
        hoverMode: "onlyPoint",
        selectionMode: "onlyPoint",
        label: {
            visible: true,
            format: "fixedPoint",
            precision: 0
        }
    },
    series: [
    <?php foreach ($dateArr_final as $final) { ?>
        { valueField: "<?php echo $final[0] ?>", name: "<?php echo $final[0] ?>" },
    <?php } ?>
    ],
    title: "<?php echo $username ?>" + "の10日間のツイート数", 
    legend: {
        verticalAlignment: "bottom",
        horizontalAlignment: "center"
    },
    pointClick: function (point) {
        this.select();
    }
});
}
            );
        </script>
    <div class="container">
    <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="content" style="margin-top: 60px;">
            <div class="pane">
                <div class="long-title"><h3></h3></div>
                <div id="chartContainer" style="width: 100%; height: 440px;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
    </div>
    </div>
    
</body>
</html>