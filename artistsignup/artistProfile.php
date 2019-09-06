<?php
/**
 * Created by PhpStorm.
 * User: graham.catterall
 * Date: 30/07/2019
 * Time: 13:32
 */
session_start();
$data = json_decode($_COOKIE['artist_data']);

if(!$_SESSION['updated_artist'])
    echo '<div class="warning">Something went wrong when updating your profile</div>';

if($_SESSION['updated_artist']){
    $name = $_SESSION['artist_data']['name'];
    $description = $_SESSION['artist_data']['description'];
}else{
    $name = $data->stagename;
    $description = $data->description;
}

?>
<head>
    <script src="/app/js/jquery.min.js"></script>
    <link rel="stylesheet" href="/app/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <link rel="stylesheet" href="/app/css/bootstrap.css">
</head>
<body>
<div class="container px-4">
    <h1><?= ucfirst($data->stagename) ?></h1>

    <form class="artist-form" action="updateArtistInfo.php" method="post" enctype="multipart/form-data">
        <label>Your Name:</label><br/>
        <input type="text" name="name" value="<?=$name?>"/><br/><br/>
        <label>Your Description:</label><br/>
        <textarea id="txtArea" rows="10" cols="70" name="description"><?= isset($description) ? $description : '' ?></textarea><br/><br/>
        <label>Your Image:</label>
        <input type="file" name="image" id="image"/><br/><br/>
        <label>Your Password:</label><br/>
        <input type="password" name="password"/><br/><br/>
        <input type="submit" name="submit"/>
        <input type="hidden" name="current-name" value="<?=$name?>"/>
    </form>
</div>
</body>




