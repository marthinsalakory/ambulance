<?php

session_start();
if ($_SESSION) session_destroy();
header("Location: masukuser.php");
exit;
