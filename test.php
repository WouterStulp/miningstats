<?php    
    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // PASTE HERE YOUR DECREDPOOL API LINK [GET USER STATUS]
    $json_string = 'http://www.decredpool.org/index.php?page=api&action=getuserstatus&api_key=eb8aeaab3889cfe4af42f51c29730ffa294565682fc194ef3afe273411a9a0ee&id=3034';
    $json = file_get_contents($json_string);
    $data = json_decode($json,true);

    $userstats = $data["getuserstatus"];
    //$username = $data["getuserstatus"]['data']['username'];
    $shares = $userstats["data"]["shares"];
    $validshares = $shares["valid"];
    $invalidshares = $shares["invalid"];
    $hash = $userstats["data"]["hashrate"];
    $sharerate = $userstats["data"]["sharerate"];
    $roundhash = round(($hash/1000), 2);

    // PASTE HERE YOUR DECREDPOOL API LINK [GET USER BALANCE]
    $json_string = 'http://www.decredpool.org/index.php?page=api&action=getuserbalance&api_key=eb8aeaab3889cfe4af42f51c29730ffa294565682fc194ef3afe273411a9a0ee&id=3034';
    $json = file_get_contents($json_string);
    $data = json_decode($json,true);

    $confirmed = $data["getuserbalance"]["data"]["confirmed"];
    $unconfirmed = $data["getuserbalance"]["data"]["unconfirmed"];
    $total = $confirmed+$unconfirmed;


    //PASTE HERE YOUR ETHERMINE API LINK
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
	
    $ethereur = $jsoneth->price_usd*$jsonusd->rates->EUR;
    $etherusd = $jsoneth->price_usd;

   	var_dump($roundhash);
?>