<?php 
// step 1: connect to database
// mysqli_connect function has 4 params (host,user name, password,database_name)
$db_con = mysqli_connect("localhost","root","root","android_app");

$response = array();
header('Content-Type: application/json');

if(mysqli_connect_errno())
{
    $response["error"] = TRUE;
    $response["message"] ="Faild to connect to database";
    echo json_encode($response);
    exit;
}


if(isset($_POST["type"]) && ($_POST["type"]=="signup") && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"])){
    // signup user
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = md5($_POST["password"]);

    //check user email whether its already regsitered
    $checkEmailQuery = "select * from users where email = '$email'";
    $result = mysqli_query($db_con,$checkEmailQuery);
    // print_r($result); exit;
    if($result->num_rows>0){
        $response["error"] = TRUE;
        $response["message"] ="Sorry email already found.";
        echo json_encode($response);
        exit;
    }else{
        $signupQuery = "INSERT INTO users(name,email,password) values('$name','$email','$password')";
        $signupResult = mysqli_query($db_con,$signupQuery);
        if($signupResult){
            // Get Last Inserted ID
            $id = mysqli_insert_id($db_con);
            // Get User By ID
            $userQuery = "SELECT id,name,email FROM users WHERE id = ".$id;
            $userResult = mysqli_query($db_con,$userQuery);
            
            $user = mysqli_fetch_assoc($userResult);
            
            $response["error"] = FALSE;
            $response["message"] = "Successfully signed up.";
            $response["user"] = $user;
            echo json_encode($response);
            exit;
        }else{
            $response["error"] = TRUE;
            $response["message"] ="Unable to signup try again later.";
            echo json_encode($response);
            exit;
        }
        
    }

}else if(isset($_POST["type"]) && ($_POST["type"]=="login") && isset($_POST["email"]) && isset($_POST["password"])){
    //login user

    $email = $_POST["email"];
    $password = md5($_POST["password"]);

    $userQuery = "select id,name,email from users where email = '$email' && password = '$password'";
    $result = mysqli_query($db_con,$userQuery);
    // print_r($result); exit;
    if($result->num_rows==0){
        $response["error"] = TRUE;
        $response["message"] ="user not found or Invalid login details.";
        echo json_encode($response);
        exit;
    }else{
        $user = mysqli_fetch_assoc($result);
        $response["error"] = FALSE;
        $response["message"] = "Successfully logged in.";
        $response["user"] = $user;
        echo json_encode($response);
        exit;
    }

}else {
    // Invalid parameters
    $response["error"] = TRUE;
    $response["message"] ="Invalid parameters";
    echo json_encode($response);
    exit;
}




?>