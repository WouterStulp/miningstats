<?php include 'head.html'?> 
<?php
	include 'connection.php';

    $json_stringe = 'https://ethermine.org/api/miner_new/Ef74202A92cBDe623Df0945Cfa885D83c3769B21';
    $jsone = file_get_contents($json_stringe);
    $datae = json_decode($jsone,true);

    $address = $datae["address"];
    $hashrate = $datae["hashRate"];
    $rephash = $datae["reportedHashRate" ];
    $workers = $datae["workers"];
    // $valid = $workers["validShares"];
    // $stale = $workers["staleShares"];
    // $invalid = $workers["invalidShares"];
    $ethpm = $datae["ethPerMin"];
    $usdpm = $datae["usdPerMin"];
    $balance = $datae["unpaid"];
    $amount = $datae["payouts"][0]["amount"];
    $payouts = $datae["payouts"];

     //koers ethereum
    $dataeth = file_get_contents('https://api.coinmarketcap.com/v1/ticker/ethereum/');
    $jsoneth = json_decode($dataeth)[0];

    //wisselkoers base=usd
    $datausd = file_get_contents('http://api.fixer.io/latest?base=USD');
    $jsonusd = json_decode($datausd);

    $ethereur = $jsoneth->price_usd*$jsonusd->rates->EUR;
    $etherusd = $jsoneth->price_usd;

?>
<div id="wrap">
<?php include'navbar.html'?>
<div class="container">
     <div class="col-md-4" style="text-align: center;">
        <h4 class="alert alert-warning"><span class="glyphicon glyphicon-random"> </span> <span> Reload timer: </span><span id="timer">02:00</span></h4>
     </div>
<?php
    echo "<table id='example' class='table table-striped''>";
    echo "<thead>";
    echo "<tr>";
	echo "<th>Ether Date</th>";
    echo "<th>Ether price in USD</th>";
    echo "<th>Ether Price in EUR</th>";
    echo "</tr";
    echo "</thead>";
    echo "<tbody>";
    class TableRows extends RecursiveIteratorIterator { 
        function __construct($it) { 
            parent::__construct($it, self::LEAVES_ONLY); 
        }

        function current() {
            return "<td>" . parent::current(). "</td>";
        }

        function beginChildren() { 
            echo "<tr>"; 
        } 

        function endChildren() { 
            echo "</tr>" . "\n";
        }
    } 
    //PUT STUFF IN THE DATABASE
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo ' <div class="col-md-4" style="text-align: center;">
                    <h4 class="alert alert-success"><span class="glyphicon glyphicon-random"> </span> <span>Connected to the database</h4>
                </div>';
        $sql = "INSERT INTO prijs (usd, eur) VALUES ('$etherusd', '$ethereur')";
        $conn->exec($sql);
        } 
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }

        //GET DATA
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT date, usd, eur FROM prijs ORDER BY id DESC LIMIT 500");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
            echo $v;
        }
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";
?>
</div>
</div>

<script>
$(document).ready(function() {
    $('#example').DataTable({
    	"iDisplayLength": 25,
    	"order": [[ 0, "desc" ]]
    });
} );
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
</script>
