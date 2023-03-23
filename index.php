<?php
require 'steamauth/steamauth.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>PlayWhatNext</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="logo">
        <h1>PlayWhatNext</h1>
    </div>
    <div class="login">
<?php
if(!isset($_SESSION['steamid'])) {

    loginbutton(); //login button

}  else {

    include ('steamauth/userInfo.php'); //To access the $steamprofile array
    
    $steamid = $steamprofile['steamid'];
    $apikey = $steamauth['apikey'];

    echo "Welcome back " . $steamprofile['personaname'] . "</br>";
    echo "here is your avatar: </br>" . '<img src="'.$steamprofile['avatarfull'].'" title="" alt="" /><br>'; // Display their avatar!
    logoutbutton(); //Logout Button

    // Make request to get list of owned games
$api_url = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=$apikey&steamid=$steamid&include_played_free_games=1&include_appinfo=1";
$games_data = json_decode(file_get_contents($api_url), true);
$games = $games_data['response']['games'];

// Loop through owned games and get playtime for last 2 weeks
$played_games = array();
foreach ($games as $game) {
    $appid = $game['appid'];
    $playtime_url = "http://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/?key=$apikey&steamid=$steamid&count=1";
    $playtime_data = json_decode(file_get_contents($playtime_url), true);
    $playtime = $playtime_data['response']['games'][0]['playtime_2weeks'];
    $played_games[] = array('name' => $game['name'], 'playtime' => $playtime);
}

// Display list of owned games and their playtime in last 2 weeks
if (count($played_games) > 0) {
    echo "<h2>Games you own and their playtime in the last 2 weeks:</h2>";
    echo "<ul>";
    foreach ($played_games as $game) {
        echo "<li>" . $game['name'] . ": " . $game['playtime'] . " minutes</li>";
    }
    echo "</ul>";
} else {
    echo "<p>You don't appear to have played any games in the last 2 weeks.</p>";
}
}     
?>
    </div>
</body>
</html>