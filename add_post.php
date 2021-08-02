<?php
session_start();
$_SESSION['user_id'] = 1;

define("DB_HOST", "localhost");
define("DB_NAME", "tut_db");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");

include('Database.php');

$db = new Database();

if(!empty($_POST['text'])){
    $text = addslashes(htmlspecialchars($_POST['text']));

    $insertArray = array(
        'user_id' => $_SESSION['user_id'],
        'text' => $text,
    );
    $insert_id = $db->insert('posts', $insertArray);

    echo '
    <b>'.$text.'</b>
    <button id="like_button_'.$insert_id.'" onclick="like('.$insert_id.')">Like</button><br><br>
    ';
}