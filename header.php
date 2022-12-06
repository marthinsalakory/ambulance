<?php isLogin('logout.php'); ?>
<?php mustRole('admin', 'logout.php'); ?>
<?php
if (isset($_POST['tersedia'])) {
    if (user()->tersedia == 'on') {
        db_update('users', ['id' => user()->id], ['tersedia' => 'off']);
    } else {
        db_update('users', ['id' => user()->id], ['tersedia' => 'on']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambulance</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/img/ambulance-car.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/leaflet/leaflet.css">
    <script src="assets/leaflet/leaflet.js"></script>
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <script src="assets/fontawesome/js/all.min.js"></script>
    <script src="assets/js/main.js"></script>
</head>

<body>
    <div class="container-fluid" style="background-color: #DDDDDD;">
        <div class="d-flex justify-content-between fw-bold">
            <div class="text-start h-100 my-auto">
                <div class="text-center" style="width: 100px;">
                    <img src="assets/img/ambulance-car.png" width="60">
                    <span>Ambulance</span>
                </div>
            </div>
            <div class="col-4 text-center h-100 my-auto">
                <button class="btn" id="show_sidebar" onclick="$('.content .sidebar').toggle()"><i class="fa-solid fa-caret-down"></i></button>
                <h3>ADMIN</h3>
            </div>
            <div class="h-100 my-auto d-flex justify-content-end">
                <form onclick="$(this).submit();" method="POST" class="form-check form-switch">
                    <input type="hidden" name="tersedia">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?= user()->tersedia == 'on' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="flexSwitchCheckChecked">Tersedia</label>
                </form>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="sidebar" style="z-index: 999;">
            <ul>
                <li class="<?= navon('index'); ?>"><a href="index.php"><i class="fa-solid fa-house-chimney"></i> Beranda</a></li>
                <li class="<?= navon('pesanmasuk'); ?>"><a href="pesanmasuk.php"><i class="fa-solid fa-envelope"></i> Pesan Masuk</a></li>
                <li class="<?= navon('user'); ?>"><a href="user.php"><i class="fa-regular fa-address-card"></i> User</a></li>
                <li class="<?= navon('supir'); ?>"><a href="supir.php"><i class="fa-solid fa-address-card"></i> Supir</a></li>
                <li class="<?= navon('akun'); ?>"><a href="akun.php"><i class="fa-solid fa-circle-user"></i> Akun</a></li>
            </ul>
        </div>
        <div class="main">
            <div class="container-fluid">
                <?= flash(); ?>