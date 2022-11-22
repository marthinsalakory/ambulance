<?php include 'function.php' ?>
<?php isLogin('masukuser.php'); ?>
<?php mustRole('user', 'masukuser.php'); ?>
<?php
if (!empty($_POST)) {
    $id = user()->id;
    $nama = htmlspecialchars(strtolower($_POST['nama']));
    $no_telp = htmlspecialchars(strtolower($_POST['no_telp']));
    $email = htmlspecialchars(strtolower($_POST['email']));

    // Cek Sandi
    if ($_POST['sandi']) {
        if ($_POST['sandi'] != $_POST['sandi1']) {
            setFlash('Konfirmasi sandi tidak sama');
        } else {
            $sandi = password_hash($_POST['sandi'], PASSWORD_DEFAULT);
        }
    } else {
        $sandi = user()->sandi;
    }

    // Cek email
    if ($email != user()->email) {
        if (db_find('users', ['email' => '$email'])) {
            setFlash('Email sudah terdaftar');
        }
    }

    // Cek Nomor Telepon
    if ($no_telp != user()->no_telp) {
        if (db_find('users', ['no_telp' => '$no_telp'])) {
            setFlash('Nomor Telepon sudah terdaftar');
        }
    }

    if (!isFlash()) {
        if (db_update('users', ['id' => $id], [
            'id' => "$id",
            'nama' => "$nama",
            'email' => "$email",
            'no_telp' => "$no_telp",
            'sandi' => "$sandi",
        ])) {
            setFlash("Berhasil Mengubah Data Akun");
            header("Location: akunuser.php");
            exit;
        } else {
            setFlash("Gagal Mengubah Data Akun");
        }
    }
}
?>
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
    <h3 class="text-center mt-3">Akun</h3>
    <form method="POST" class="mt-3 px-3">
        <div class="row">
            <div class="col-12">
                <label for="nama">Nama</label>
            </div>
            <div class="col-12">
                <input required class="input-akun" name="nama" type="text" value="<?= user()->nama; ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <label for="no_telp">No Telp</label>
            </div>
            <div class="col-12">
                <input required class="input-akun" name="no_telp" type="text" value="<?= user()->no_telp; ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <label for="email">Email</label>
            </div>
            <div class="col-12">
                <input required class="input-akun" name="email" type="email" value="<?= user()->email; ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <label for="sandi">Sandi</label>
            </div>
            <div class="col-12">
                <input class="input-akun password-hash" name="sandi" type="password">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <button class="btn btn-light border border-dark border-1">Simpan</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 text-end mt-4">
            <a href="logoutuser.php" class="btn btn-light border border-dark border-1 me-3"><i class="fa fa-power-off"></i> Keluar</a>
        </div>
    </div>
</div>
<?php include 'footer_user.php' ?>