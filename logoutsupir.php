<?php

session_start();
if ($_SESSION) session_destroy();
header("Location: masuksupir.php");
exit;
