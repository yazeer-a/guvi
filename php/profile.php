<?php
    require("./dbconnection.php");
    require "./vendor/autoload.php";
    session_start();
?>

<?php
    $client = new MongoDB\Client;
    $redis = new Predis\Client();
    $db = $client->test;
    $collection = $db->users;
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['age']) && isset($_POST['mobile']) && isset($_POST['dob']) ){
        try{
            $name = $_POST['name'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $mobile = $_POST['mobile'];
            $dob = $_POST['dob'];
            $update = array("name" => $name, 
            "age" => $age,
            "mobile" => $mobile,
            "dob" =>$dob,
            "session_id" => session_id()
        );
            $updateResult = $collection->updateOne(
                ["email" => $email],
                ['$set' =>  $update]
            );
            echo "Update success";
        }catch(Exception $e) {
            echo "Error: " . $e->getMessage();
        }

    }else if(isset($_POST['sessionid'])){
        if($_POST['sessionid'] == 'empty'){
            echo 'no user';
            exit();
        }
        $email = $redis->get('user');
        $_SESSION["email"] = $email;
        $doc = $collection->findOne(['email' => $email]);
        $data = array(
            'email' => $email,
            'name' => $doc['name'],
            'age' => $doc['age'],
            'dob' => $doc['dob'],
            'mobile' => $doc['mobile'],
            'session_id' => session_id()
        );
        echo json_encode($data);

    }else{
        session_destroy();
        $redis->flushall();
    }
?>
