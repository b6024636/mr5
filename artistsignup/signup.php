<?php
/**
 * signup
 *
 * @copyright Copyright © 2019 Kinspeed. All rights reserved.
 * @author    graham.catterall@kinspeed.com
 */

if(isset($_POST['name']) && isset($_POST['password'])){
    $servername = 'localhost';
    $username = 'inspectionsystem';
    $password = "Kinspeed1#";

    $conn = mysqli_connect($servername, $username, $password, 'inspecti_wordpress');

    if($conn->connect_error){
        die('error connecting to db');
    }
    $sql = "SELECT stagename, description, image FROM user_data WHERE stagename = '".htmlspecialchars($_POST['name'])."' AND password = '".htmlspecialchars($_POST['password'])."';";

    $result = mysqli_query($conn, $sql);
    $conn->close();
    $data = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $data['success'] = true;
        print_r(json_encode($data));
        return json_encode(['success' => true, 'name' => $data['stagename']]);
    }else{
        $data['success'] = false;
        print_r(json_encode($data));
//        return 'No data found';
    }
}