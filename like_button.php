<?php
session_start();
$_SESSION['user_id'] = 1;

define("DB_HOST", "localhost");
define("DB_NAME", "tut_db");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");

include('Database.php');

$db = new Database();

if(!empty($_POST['post_id'])){
    $post_id = (int)$_POST['post_id'];

    $likedAlready = $db->selectOne("SELECT id FROM liked WHERE user_id = '".$_SESSION['user_id']."' AND post_id = '$post_id'");
    if(empty($likedAlready)){
        $insertData = array(
            'user_id' => $_SESSION['user_id'],
            'post_id' => $post_id,

        );
        $db->insert('liked', $insertData);
        echo '1';
    }else{
        $db->query("DELETE FROM liked WHERE id = '".$likedAlready['id']."'");
        echo '0';
    }
}