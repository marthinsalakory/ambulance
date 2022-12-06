<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambulance</title>
    <link rel="icon" type="image/x-icon" href="assets/img/ambulance-car.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
            <div class="h-100 my-auto">
                <button class="btn" id="show_sidebar" onclick="$('.content .sidebar').toggle()"><i class="fa-solid fa-caret-down"></i></button>
                <h3>ADMIN</h3>
            </div>
            <div class="h-100 my-auto d-flex justify-content-end">
                <div class="text-center" style="width: 150px;">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="masuk.php" type="button" class="btn border border-dark border-1" style="<?= $FILENAME == 'masuk' ? 'background-color: #95BCF2;' : ''; ?>">Masuk</a>
                        <a href="daftar.php" type="button" class="btn border border-dark border-1" style="<?= $FILENAME == 'daftar' ? 'background-color: #95BCF2;' : ''; ?>">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= flash(); ?>
    <div class="mx-auto" style="width: 500px;">