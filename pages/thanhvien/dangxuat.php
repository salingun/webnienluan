<?php
    $tvClass = new Thanhvien();
    $tvClass->checkLoggedGoLogin();
?>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
unset($_SESSION['User']);
echo '<meta http-equiv="refresh" content="0;URL=index.php">';
?>
