<?php

if(!$_POST['page']) die("0");

$page = (int)$_POST['page'];

if(file_exists('../user/page_'.$page.'.php'))
echo file_get_contents('../user/page_'.$page.'.php');

else echo 'There is no such page!';
?>
