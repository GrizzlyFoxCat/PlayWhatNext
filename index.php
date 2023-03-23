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
</body>
</html>