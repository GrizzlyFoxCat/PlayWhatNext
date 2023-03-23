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
}
?>
</div>
<div class="main">
    <?php
if(isset($_SESSION['steamid'])) {
    // Make request to get list of owned games
    $api_url = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=$apikey&steamid=$steamid&include_played_free_games=1&include_appinfo=1";
    $games_data = json_decode(file_get_contents($api_url), true);
    $games = $games_data['response']['games'];

    // Get total playtime for last 2 weeks
    $total_playtime_2weeks = 0;
    $playtime_url = "http://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/?key=$apikey&steamid=$steamid&count=2";
    $playtime_data = json_decode(file_get_contents($playtime_url), true);
    $played_games = $playtime_data['response']['games'];
    foreach ($played_games as $game) {
        $total_playtime_2weeks += $game['playtime_2weeks'];
    }

    // Calculate average playtime per day
    $hours_played_per_day = round($total_playtime_2weeks / 60 / 14, 2);

    // Display total playtime and average playtime per day
    echo "<h2>Total playtime in last 2 weeks:</h2>";
    echo "<p>" . $total_playtime_2weeks . " minutes</p>";
    echo "<h2>Average playtime per day in last 2 weeks:</h2>";
    echo "<p>" . $hours_played_per_day . " hours per day</p>";

}

?>
    </div>
</body>
</html>