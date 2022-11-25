<?php include 'function.php' ?>
<?php isLogin('masukuser.php'); ?>
<?php mustRole('user', 'masukuser.php'); ?>
<?php
$user_id = user()->id;
if ($row = db_query("SELECT * FROM pesanmasuk WHERE user_id = '$user_id' && tugas_pasien != 'selesai'")->fetch_object()) {
    header("Location: penjemputan.php");
    exit;
} ?>
<?php include 'header_user.php' ?>
<div class="container-fluid">
    <div class="row fw-bold" style="background-color: #DDDDDD;">
        <div class="col-4 h-100 my-auto ps-5">
            <a href="darurat.php" class="text-dark text-decoration-none"><i class="fa-solid fa-chevron-left"></i></a>
        </div>
        <div class="col-4 d-flex justify-content-center">
            <div class="text-center" style="width: 100px;">
                <img src="assets/img/ambulance-car.png" width="60">
                <span>Ambulance</span>
            </div>
        </div>
    </div>
</div>
<?= flash(); ?>
<div class="mx-auto position-relative" style="width: 100%;height: 91vh;">
    <div class="row border border-dark border-1">
        <div class="col-12 text-center pt-1" style="height: 30px;">
            <p>Rumah Sakit</p>
        </div>
        <?php foreach (db_query("SELECT * FROM users WHERE role = 'admin'") as $rs) : ?>
            <div class="col-12 mt-1 position-relative" style="background-color: #ddd;height: 70px;">
                <span id="tampil_status" class="position-absolute <?= db_count('users', ['user_id' => $rs['id'], 'status' => 'tersedia']) == 0 ? 'bg-danger' : 'bg-primary'; ?> border border-1 border-dark rounded-circle end-0 top-50 translate-middle-y me-5" style="height: 30px; width: 30px;"></span>
                <div class="ps-2">
                    <a class="text-dark text-decoration-none" target="_blank" href="https://www.google.com/maps/search/?api=1&query=<?= $rs['asal_rumah_sakit']; ?>"><?= $rs['nama']; ?></a><br>
                    <a href="tel:<?= $rs['no_telp']; ?>"><?= $rs['no_telp']; ?></a><br>
                    <a href="mailto:<?= $rs['email']; ?>"><?= $rs['email']; ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'footer_auth.php' ?>