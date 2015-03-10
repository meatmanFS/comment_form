<?php
include('commentClass.php');


$comment = new commentClass;

if (isset($_POST['submit_button']))
{
    $comment->post_comment($_POST['email'], $_POST['fio'], $_POST['phone'], $_POST['comment']);
}
else
{
   $comment->get_all_comment(); 
}

