<?php
    require("./dbconnection.php"); 
    require "./vendor/autoload.php";
    session_start();
?>

<?php
    $m = new MongoDB\Client;
    $redis = new Predis\Client();
    $db = $m->test;
    $collection = $db->users;
    if($redis->get('user')){
        echo "session is on";
    }else{
        if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['age']) && isset($_POST['mobile']) && isset($_POST['dob']) && isset($_POST['password']) ){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $mobile = $_POST['mobile'];
            $dob = $_POST['dob'];
            $password = $_POST['password'];
            $stmt =$sqllink->prepare("INSERT INTO users(Email,Password) VALUES(?,?)");
            $stmt->bind_param("ss",$email,$password);
            if($stmt->execute()){
                $collection->insertOne([ 
                    "name" => $name, 
                    "email" => $email, 
                    "age" => $age,
                    "mobile" => $mobile,
                    "dob" =>$dob,
                ]);
                echo "inserted success";
            }else{
                echo "Already a user";
            }
        }else{
            echo "Missing details";
        }
    }
?>