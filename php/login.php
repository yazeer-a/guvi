<?php
    require("./dbconnection.php");
    require "./vendor/autoload.php";
?>

<?php
    $redis = new Predis\Client();
    $client = new MongoDB\Client;
    $db = $client->test;
    $collection = $db->users;
    if(isset($_POST['email']) && isset($_POST['password']) ){
        try{
            $email = $_POST['email'];
            $password = $_POST['password'];
            $stmt =$sqllink ->prepare("SELECT * FROM users WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if(mysqli_num_rows($result) == 0){
                echo "No user";
            }else{
                $row = $result->fetch_assoc();
                if($row['Password']!=$password){
                    echo "wrong password";
                }else{
                    session_start();
                    $redis->set('user' , $email);
                    $updateResult = $collection->updateOne(
                        ["email" => $email],
                        ['$set' =>  ['sessionid' => session_id() ]]
                    );
                    echo session_id();
                }
            }
        }catch(Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        
    }else{
        echo "Missing details";
    }
?>