<!DOCTYPE html>
<html>
<?php
  include 'includes/head.html';
  include 'includes/connection.php';
  include 'includes/json.php';
  include 'includes/database.php';
?>
<div id="wrap">
<?php include'includes/navbar.html';?>
<div class="container">
    <?php 
    include 'includes/dbconnected.php';
    ?>
     <div class="col-md-4" style="text-align: center;">
        <h4 class="alert alert-warning"><span class="glyphicon glyphicon-random"> </span> <span> Reload timer: </span><span id="timer">02:00</span></h4>
     </div>
     <div class="col-md-12">
        <h2 class="col-md-12">Ethereum: </h2>
      </div>
    <div id="shares">
      <div class="col-md-4">
        <a href="share.php"><h3 class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Valid shares: <?php echo round("$validsum", 2); ?></h3></a>
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
          <a href="hashrate.php" ><h3 class="alert alert-info"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Hashrate: <?php echo "$rephash"?></h3></a>
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
            <a href="rate.php"><h3 class="alert alert-info"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> ETH price in USD: $<?php echo round($jsoneth->price_usd, 2) ?></h3></a>
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
