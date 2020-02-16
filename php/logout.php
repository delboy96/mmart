<?php
    @session_start();
    unset($_SESSION["user"]);
    session_destroy($_SESSION["user"]);
    header("Location: ../index.php?page=login");
    // header("Location: ../index.php?page=login&message=You have successfully logged out");