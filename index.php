<script src="jquery.js"></script>
<?php
session_start();
$_SESSION['user_id'] = 1;

define("DB_HOST", "localhost");
define("DB_NAME", "tut_db");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");

include('Database.php');

$db = new Database();

$select_posts = $db->selectAll("
    SELECT p.*, l.id AS liked_id 
    FROM posts AS p
        LEFT JOIN liked AS l ON l.user_id = '".$_SESSION['user_id']."' AND l.post_id = p.id
    ORDER BY p.id DESC
");
$text = '';
foreach($select_posts AS $p){
    $text = (!empty($p['liked_id']) ? 'Unlike' : 'Like');
    ?>
        <b><?php echo $p['text'] ?></b>
        <button id="like_button_<?php echo $p['id']; ?>" onclick="like(<?php echo $p['id']; ?>)"><?php echo $text; ?></button><br><br>
    <?php

}



?>


<script>
    function like(id){
       
        $.ajax({
            type: 'POST',
            url: "like_button.php",
            data: {
                post_id: id,
            },
            success: function(data){
             
                if(data == 1){
                    $('#like_button_'+id).text('Unlike');
                }else{
                    $('#like_button_'+id).text('Like');
                }
            }
        });
    }

</script>