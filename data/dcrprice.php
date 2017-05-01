<?php
  include '../includes/head.html';
  include '../includes/connection.php';
  include '../includes/json.php';
  include '../includes/database.php'
?>
<div id="wrap">
<?php include'../includes/navdata.html';?>
<div class="container">
    <?php 
    include '../includes/dbconnected.php';
    ?>
     <div class="col-md-4" style="text-align: center;">
        <h4 class="alert alert-warning"><span class="glyphicon glyphicon-random"> </span> <span> Reload timer: </span><span id="timer">02:00</span></h4>
     </div>
<?php
    echo "<table id='example' class='table table-striped''>";
    echo "<thead>";
    echo "<tr>";
	echo "<th>Date</th>";
    echo "<th>DCR price in USD</th>";
    echo "<th>DCR Price in EUR</th>";
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
//GET DATA
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT date, dcrusd, dcreur FROM dcrprice ORDER BY id DESC LIMIT 500");
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
