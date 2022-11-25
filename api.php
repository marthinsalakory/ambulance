<?php
include 'function.php';
if (isset($_POST['query'])) {
    echo json_encode(db_query($_POST['query'])->fetch_assoc());
}

if (isset($_POST['update'])) {
    echo db_query($_POST['update']);
}

if (isset($_POST['insert'])) {
    echo db_query($_POST['update']);
}
