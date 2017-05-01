<?php
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo ' <div class="col-md-4" style="text-align: center;">
                    <h4 class="alert alert-success"><span class="glyphicon glyphicon-random"> </span> <span>Connected to the database</h4>
                </div>';
    $conn->exec($sql);
    } 
catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
?>