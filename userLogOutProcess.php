<?php
session_start();
session_destroy();
header("location:userLogin.php");
exit();
?>
