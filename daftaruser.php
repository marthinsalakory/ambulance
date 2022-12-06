<?php include 'function.php' ?>
<?php
noLogin();
if (!empty($_POST)) {
    $nama = htmlspecialchars(strtolower($_POST['nama']));
    $no_telp = htmlspecialchars(strtolower($_POST['no_telp']));
    $email = htmlspecialchars(strtolower($_POST['email']));
    $sandi = password_hash($_POST['sandi'], PASSWORD_DEFAULT);
    $id = uniqid();

    // Cek Email
    if (db_find('users', ['email' => $email])) {
        setFlash('Email sudah terdaftar');
    }

    // Cek Nomor Telephone
    if (db_find('users', ['no_telp' => $no_telp])) {
        setFlash('Nomor Telepon sudah terdaftar');
    }

    if (!isFlash()) {
        if (db_insert('users', [
            'id' => "$id",
            'nama' => "$nama",
            'no_telp' => "$no_telp",
            'email' => "$email",
            'sandi' => "$sandi",
            'role' => "user"
        ])) {
            $_SESSION['login'] = true;
            $_SESSION['user'] = db_find('users', ['id' => $id]);
            header("Location: darurat.php");
            exit;
        } else {
            setFlash('Gagal mendaftar');
        }
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
<div class="card mt-5">
    <form method="POST" class="card-body">
        <div class="row">
            <div class="col-3">
                <label for="nama">Nama</label>
            </div>
            <div class="col-9">
                <input value="<?= old_value('nama'); ?>" required class="input-akun" type="text" name="nama" id="nama">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <label for="no_telp">No Telp</label>
            </div>
            <div class="col-9">
                <input value="<?= old_value('no_telp'); ?>" required class="input-akun" type="number" name="no_telp" id="no_telp">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <label for="email">E-mail</label>
            </div>
            <div class="col-9">
                <input value="<?= old_value('email'); ?>" required class="input-akun" type="email" name="email" id="email">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <label for="sandi">Sandi</label>
            </div>
            <div class="col-9">
                <input value="<?= old_value('sandi'); ?>" required class="input-akun password-hash" type="password" name="sandi" id="sandi">
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
                <button class="btn btn-light border border-dark border-1">Daftar</button><br>
                <a href="masukuser.php" class="btn btn-light border border-dark border-1 my-2">Masuk</a>
            </div>
        </div>
    </form>
</div>
<?php include 'footer.php' ?>