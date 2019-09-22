<?php
    session_start();
    session_regenerate_id(true);
    session_destroy();
    session_unset();
    header("Location:index.php");
?>