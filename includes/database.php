<?php
//add dcr shares to the database
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO prijs (usd, eur) VALUES ('$etherusd', '$ethereur')";
        $sql = "INSERT INTO hashrate (reported, effective) VALUES ('$hashrate', '$rephash')";
        $sql = "INSERT INTO share (valid, invalid, stale) VALUES ('$validsum', '$invalidsum', '$stalesum' )";
        $conn->exec($sql);
        } 
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
        //add dcr shares to the database
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO dcrshare (valid, invalid) VALUES ('$validshares', '$invalidshares')";
        $sql = "INSERT INTO dcrhash (hashrate, sharerate) VALUES ('$roundhash', '$sharerate')";
        $conn->exec($sql);
        } 
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
?>