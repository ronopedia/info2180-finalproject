<?php
session_start();
require_once 'dbconfig.php';

try{
    //if(isset($_POST['title'], $_POST['description'], $_POST['assigned_to'], $_SESSION['id'], $_POST['type'], $_POST['priority'])){
    $title = $_POST['title'];
    $description = $_POST['descrip'];
    $assign = $_POST['assigned'];
    $created = $_SESSION['id'];
    $typeof = $_POST['typeof'];
    $priority = $_POST['pri'];
    $datetime = date("Y-m-d");
    $stat ='Open';

    if($typeof=='1'){
        $typeof ='Bug';
    }
    elseif($typeof=='2'){
        $typeof ='Proposal';
    }
    elseif($typeof=='3'){
        $typeof ='Task';
    }

    if($priority=='1'){
        $priority ='Minor';
    }
    elseif($priority=='2'){
        $priority ='Major';
    }
    elseif($priority=='3'){
        $priority ='Critical';
    }

    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $stmt = $conn->query("SELECT id, firstname, lastname FROM users");
    $insertdata = "INSERT INTO issues(title,description,type,priority,status,assigned_to, created_by,created,updated) VALUES('$title','$description','$typeof','$priority','$stat','$assign','$created',NOW(),NOW())";
    $stmt = $conn->query($insertdata);

    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
    exit;

    //}else{
        //header("location: ../login.html");
        //echo "User must log in to create an issue.";
    //}

}
catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}


?>
