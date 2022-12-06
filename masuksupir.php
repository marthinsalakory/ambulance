<?php include 'function.php' ?>
<?php
noLogin();
if (!empty($_POST)) {
    $no_telp = htmlspecialchars(strtolower($_POST['no_telp']));
    $sandi = $_POST['sandi'];

    if ($row = db_find("users", ['no_telp' => $no_telp, 'role' => 'supir'])) {
        if (password_verify($sandi, $row->sandi)) {
            $_SESSION['login'] = true;
            $_SESSION['user'] = $row;
            header("Location: permintaan.php");
            exit;
        } else {
            setFlash('Gagal Masukk');
        }
    } else {
        setFlash('Gagal Masuk');
    }
}
?>
<?php include 'header_user.php' ?>
<div class="container-fluid">
    <div class="row fw-bold" style="background-color: #DDDDDD;">
        <div class="col-12 d-flex justify-content-center">
            <a href="" class="text-center text-decoration-none text-dark" style="width: 100px;">
                <img src="assets/img/ambulance-car.png" width="60">
                <span>Ambulance</span>
            </a>
        </div>
    </div>
</div>
<?= flash(); ?>
<div class="mx-auto position-relative" style="width: 100%;height: 91vh;">
    <div class="card mt-5">
        <form method="POST" class="card-body">
            <div class="row">
                <div class="col-3">
                    <label for="no_telp">No Telp</label>
                </div>
                <div class="col-9">
                    <input required class="input-akun" type="number" name="no_telp" id="no_telp">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3">
                    <label for="sandi">Sandi</label>
                </div>
                <div class="col-9">
                    <input required class="input-akun password-hash" type="password" name="sandi" id="sandi">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3">
                </div>
                <div class="col-9">
                    <input class="show-password" type="checkbox" id="show_password">
                    <label for="show_password">Tampilkan</label>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <button class="btn btn-light border border-dark border-1">Masuk</button><br>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include 'footer.php' ?>