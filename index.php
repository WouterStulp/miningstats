<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="refresh" content="120"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>MiningStats</title>
  <link rel="shortcut icon" href="http://bitcoinmacroeconomics.com/wp-content/uploads/2014/05/dogeminer.png" type="image/x-icon" />
  <link rel="stylesheet" href="custom.css" type="text/css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body id="content">
<?php

    // PASTE HERE YOUR DECREDPOOL API LINK [GET USER STATUS]
    $json_string = 'PASTE HERE YOUR DECREDPOOL API LINK [GET USER STATUS]';
    $json = file_get_contents($json_string);
    $data = json_decode($json,true);

    $userstats = $data["getuserstatus"];
    $username = $data["getuserstatus"]['data']['username'];
    $shares = $userstats["data"]["shares"];
    $validshares = $shares["valid"];
    $invalidshares = $shares["invalid"];
    $hash = $userstats["data"]["hashrate"];
    $sharerate = $userstats["data"]["sharerate"];

    // PASTE HERE YOUR DECREDPOOL API LINK [GET USER BALANCE]
    $json_string = '// PASTE HERE YOUR DECREDPOOL API LINK [GET USER BALANCE]';
    $json = file_get_contents($json_string);
    $data = json_decode($json,true);

    $confirmed = $data["getuserbalance"]["data"]["confirmed"];
    $unconfirmed = $data["getuserbalance"]["data"]["unconfirmed"];
    $total = $confirmed+$unconfirmed;


    //PASTE HERE YOUR ETHERMINE API LINK
    $json_stringe = 'paste here your ethermine api link';
    $jsone = file_get_contents($json_stringe);
    $datae = json_decode($jsone,true);

    $address = $datae["address"];
    $hashrate = $datae["hashRate"];
    $rephash = $datae["reportedHashRate" ];
    $workers = $datae["workers"];
    $valid = $workers["validShares"];
    $stale = $workers["staleShares"];
    $invalid = $workers["invalidShares"];
    $ethpm = $datae["ethPerMin"];
    $usdpm = $datae["usdPerMin"];
    $balance = $datae["unpaid"];
    $amount = $datae["payouts"][0]["amount"];
    $payouts = $datae["payouts"];


    $amountsum = 0;
    foreach($payouts as $p){
        $amountsum += $p["amount"];
    };
    $ethamount = "$balance"+"$amountsum";

    $validsum = 0;
    foreach($workers as $v){
        $validsum += $v["validShares"];
    };
    
    $stalesum = 0;
    foreach($workers as $s){
        $stalesum += $s["staleShares"];
    };
    
    $invalidsum = 0;
    foreach($workers as $u){
        $invalidsum += $u["invalidShares"];
    };

    //koers ethereum
    $dataeth = file_get_contents('https://api.coinmarketcap.com/v1/ticker/ethereum/');
    $jsoneth = json_decode($dataeth)[0];

    $percent = $jsoneth->percent_change_24h;

    //koers decred
    $datadcr = file_get_contents('https://api.coinmarketcap.com/v1/ticker/decred/');
    $jsondcr = json_decode($datadcr)[0];

    $percentdcr = $jsondcr->percent_change_24h;

    //wisselkoers base=usd
    $datausd = file_get_contents('http://api.fixer.io/latest?base=USD');
    $jsonusd = json_decode($datausd);
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">MINER-PC</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#" target="_blank">Ethereum</a></li>
        <li><a href="#">Decred</a></li>
        <li><a href="https://myetherwallet.com/#view-wallet-info" target="_blank">Ethereum Wallet</a></li>
        <li><a href="https://wallet.decred.org/#/" target="_blank">Decred Wallet</a></li>
        <li><a href="https://coinmarketcap.com/currencies/ethereum/" target="_blank">Coinmarketcap ETH</a></li>
        <li><a href="https://coinmarketcap.com/currencies/decred/" target="_blank">Coinmarketcap DCR</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container">
      <div class="col-md-4 col-md-offset-8" style="text-align: center;">
        <h4 class="alert alert-warning"><span class="glyphicon glyphicon-random"> </span> <span> Reload timer: </span><span id="timer">02:00</span></h4>
      </div>
      <div class="col-md-12">
        <h2 class="col-md-12">Ethereum: </h2>
      </div>
    <div id="shares">
      <div class="col-md-4">
        <h3 class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Valid shares: <?php echo round("$validsum", 2); ?></h3>
      </div>
      <div class="col-md-4">
        <h3 class="alert alert-warning"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span> Stale shares: <?php echo round("$stalesum", 2)?></h3>
      </div>
      <div class="col-md-4">
        <h3 class="alert alert-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Invalid shares: <?php echo round("$invalidsum", 2)?></h3>
      </div>
    </div>
      <div id="hash">
        <div class="col-md-6">
          <h3 class="alert alert-info"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Hashrate: <?php echo "$rephash"?></h3>
        </div>
        <div class="col-md-6">
          <h3 class="alert alert-info"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Effective hashrate: <?php echo "$hashrate"?></h3>
        </div>
      </div>
      <div id="epm">
        <div class="col-md-4">
          <h3 class="alert alert-info"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> ETH per minute: <?php echo number_format($ethpm, 5)?></h3>
        </div>
        <div class="col-md-4">
          <h3 class="alert alert-info"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> ETH per week: <?php echo round(($ethpm*60*24*7), 4)?></h3>
        </div>
        <div class="col-md-4">
          <h3 class="alert alert-info"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> ETH per month: <?php echo round(($ethpm*60*24*7*4.34812141), 4)?></h3>
        </div>
        <div class="col-md-4">
          <h3 class="alert alert-info"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> EUR per minute: &euro;<?php echo number_format(($usdpm*$jsonusd->rates->EUR), 4)?></h3>
        </div>
        <div class="col-md-4">
          <h3 class="alert alert-info"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> EUR per week: &euro;<?php echo round(($usdpm*$jsonusd->rates->EUR*60*24*7), 2)?></h3>
        </div>
        <div class="col-md-4">
          <h3 class="alert alert-info"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> EUR per month: &euro;<?php echo round(($usdpm*$jsonusd->rates->EUR*60*24*7*4.34812141), 2)?></h3>
        </div>
      </div>
      <div id="balance">
        <div class="col-md-6">
          <h3 class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span> ETH Pool: <?php echo round($balance/1000000000000000000, 10)?></h3>
        </div>
        <div class="col-md-6">
          <h3 class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span> ETH Overall: <?php echo round($ethamount/1000000000000000000, 10)?></h3>
        </div>
      </div>
        <div id="koers">
          <div class="col-md-4">
            <h3 class="alert alert-info"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> ETH price in USD: $<?php echo round($jsoneth->price_usd, 2) ?></h3>
          </div>
          <div class="col-md-4">
            <h3 class="alert alert-info"><span class="glyphicon glyphicon-euro" aria-hidden="true"></span> ETH price in EUR: &euro;<?php echo round($jsoneth->price_usd*$jsonusd->rates->EUR, 2) ?></h3>
          </div>
          <div class="col-md-4">
            <h3 <?php if($percent < 0){ echo "<div class='alert alert-danger'>";} else{ echo "<div class='alert alert-success'>";} ?> <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> ETH Change 24H: <?php echo $jsoneth->percent_change_24h ?>%</h3>
          </div>
        </div>
        <div id="mined">
          <div class="col-md-4">
            <h3 class="alert alert-success"><span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span> Last Payout: <?php echo round($amount/1000000000000000000, 5) ?></h3>
          </div>
          <div class="col-md-4">
            <h3 class="alert alert-success"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> USD mined: $<?php echo round(($ethamount/1000000000000000000*$jsoneth->price_usd), 2) ?></h3>
          </div>
          <div class="col-md-4">
            <h3 class="alert alert-success"><span class="glyphicon glyphicon-euro" aria-hidden="true"></span> EUR mined: &euro;<?php echo round(($ethamount/1000000000000000000*$jsoneth->price_usd*$jsonusd->rates->EUR), 2) ?></h3>
          </div>
        </div>
      <div class="col-md-12">
        <h2>Decred:</h2>
      </div>
        <div id="dshares">
          <div class="col-md-6">
            <h3 class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Valid shares: <?php echo round("$validshares", 2); ?></h3>
          </div>
          <div class="col-md-6">
            <h3 class="alert alert-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Invalid shares: <?php echo round("$invalidshares", 2)?></h3>
          </div>
        </div>
          <div id="dhash">
            <div class="col-md-6">
              <h3 class="alert alert-info"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Hashrate: <?php echo round(($hash/1000), 2)?>  MH/s</h3>
            </div>
            <div class="col-md-6">
              <h3 class="alert alert-info"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Sharerate: <?php echo "$sharerate"?>  S/s</h3>
            </div>
          </div>

            <div id="dbalance">
              <div class="col-md-4">
                <h3 class="alert alert-success"><span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span> DCR balance confirmed: <?php echo round($confirmed ,6)?></h3>
              </div>
              <div class="col-md-4">
                <h3 class="alert alert-warning"><span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span> DCR balance unconfirmed: <?php echo round($unconfirmed ,6)?></h3>
              </div>
              <div class="col-md-4">
                <h3 class="alert alert-info"><span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span> DCR balance total: <?php echo round($total ,6)?></h3>
              </div>
            </div>

              <div id="dkoers">
                <div class="col-md-4">
                  <h3 class="alert alert-info"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> DCR price in USD: $<?php echo round($jsondcr->price_usd ,2)?></h3>
                </div>
                <div class="col-md-4">
                  <h3 class="alert alert-info"><span class="glyphicon glyphicon-euro" aria-hidden="true"></span> DCR price in EUR: &euro;<?php echo round(($jsondcr->price_usd*$jsonusd->rates->EUR) ,2)?></h3>
                </div>
                <div class="col-md-4">
                  <h3 <?php if($percentdcr < 0){ echo "<div class='alert alert-danger'>";} else{ echo "<div class='alert alert-success'>";} ?> <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> DCR change 24H: <?php echo $percentdcr ?>%</h3>
                </div>
              </div>
                <div id="dmined">
                  <div class="col-md-6">
                    <h3 class="alert alert-success"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> USD mined: $<?php echo round(($total*$jsondcr->price_usd), 2) ?></h3>
                  </div>
                  <div class="col-md-6">
                    <h3 class="alert alert-success"><span class="glyphicon glyphicon-euro" aria-hidden="true"></span> EUR mined: &euro;<?php echo round(($total*$jsondcr->price_usd*$jsonusd->rates->EUR), 2) ?></h3>
                  </div>
                </div>
    </div>
    <div id="footer" class="container">
    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="navbar-inner navbar-content-center">
            <p class="text-muted credit" style="text-align: center;">MiningStats Made by: &copy; <a href="https://github.com/GiantHoax">GiantHoax</a></p>
        </div>
    </nav>
</div>
</body>

<script>
var interval = setInterval(function() {
    var timer = $('#timer').html();
    timer = timer.split(':');
    var minutes = parseInt(timer[0], 10);
    var seconds = parseInt(timer[1], 10);
    seconds -= 1;
    if (minutes < 0) return clearInterval(interval);
    if (minutes < 10 && minutes.length != 2) minutes = '0' + minutes;
    if (seconds < 0 && minutes != 0) {
        minutes -= 1;
        seconds = 59;
    }
    else if (seconds < 10 && length.seconds != 2) seconds = '0' + seconds;
    $('#timer').html(minutes + ':' + seconds);

    if (minutes == 0 && seconds == 0)
        clearInterval(interval);
}, 1000);

// $(document).ready(function () {
//     var interval = 60000;   //number of mili seconds between each call
//     var refresh = function() {
//         $.ajax({
//             url: "",
//             cache: false,
//             success: function(html) {
//                 $('#content').html(html);
//                 setTimeout(function() {
//                     refresh();
//                 }, interval);
//             }
//         });
//     };
//     refresh();
// });
</script>
<!-- <script src="timer.js"></script> -->
</html>
