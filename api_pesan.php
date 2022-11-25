<?php
include 'function.php';
$user_id = user()->id;
$row = db_query("SELECT * FROM pesanmasuk WHERE user_id = '$user_id' && tugas_pasien != 'selesai'")->fetch_assoc();
echo json_encode($row);
