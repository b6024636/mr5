<?php
/**
 * Created by PhpStorm.
 * User: graham.catterall
 * Date: 30/07/2019
 * Time: 13:52
 */
session_start();
if($_FILES['image']['name'] != '') {
    $targetDir = '/app/media/img/artist-pics/';

    $target_file = $targetDir . basename($_FILES['image']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_POST['submit'])) {
        $check = getimagesize($_FILES['image']['tmp_name']);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$servername = 'localhost';
$username = 'inspectionsystem';
$password = "Kinspeed1#";

$conn = mysqli_connect($servername, $username, $password, 'inspecti_wordpress');

if($conn->connect_error){
    die('error connecting to db');
}

$sql = "UPDATE user_data SET ";
if($_POST['name'] != $_POST['current-name'])
    $sql .= "stagename = '".htmlspecialchars($_POST['name'])."', ";
if($_POST['password'] != '')
    $sql .= "password = '".htmlspecialchars($_POST['password'])."', ";

$sql .= "description = '".htmlspecialchars($_POST['description'])."' WHERE stagename = '".$_POST['current-name']."';";

if(mysqli_query($conn, $sql)){
    $oldName = $_POST['current-name'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $img = $_FILES['image']['name'];
    $artists = file_get_contents('http://inspectionssdev.kinspeed.com/app/lib/constants/artists.json');
//    print_r($artists);
    $tempArray = json_decode($artists, true);

//    $tempArray->tamots = ToObject($_SESSION['artist_data']);

    if($tempArray[$oldName]){
        $tempArray[$name] = $tempArray[$oldName];

        $tempArray[$name]['name'] = $name;
        $tempArray[$name]['description'] = $description;
        $tempArray[$name]['description'] = $_POST['description'];

        if($oldName != $_POST['name'])
            unset($tempArray[$oldName]);
    }else{
        $tempArray[$name]['name'] = $name;
        $tempArray[$name]['description'] = $description;
        if($img != '' && $img)
            $tempArray[$name]['image'] = $img;
    }

    $jsonData = json_encode($tempArray);
//    print_r($oldName);
//    print_r($_POST);
//    print_r($tempArray);
//    print_r($jsonData);
//    die();
    echo getmyuid().':'.getmygid();
    var_dump(is_writable('http://inspectionssdev.kinspeed.com/app/lib/constants/artists.json'));
    var_dump(file_put_contents('http://inspectionssdev.kinspeed.com/app/lib/constants/artists.json', $jsonData));
    $_SESSION['updated_artist'] = true;
    $_SESSION['artist_data'] = [
        'name' => $name,
        'description' => $description
    ];


//    echo '<script>window.location.href = "artistProfile.php"</script>';
}else{
    $_SESSION['updated_artist'] = false;
    echo '<script>window.location.href = "artistProfile.php"</script>';
}
