<?php
include 'function.php';
if (!empty($_POST)) {
    $id = uniqid();
    $nama = htmlspecialchars(strtolower($_POST['nama']));
    $email = htmlspecialchars(strtolower($_POST['email']));
    $no_telp = htmlspecialchars(strtolower($_POST['no_telp']));
    $asal_rumah_sakit = htmlspecialchars(strtolower($_POST['asal_rumah_sakit']));
    $sandi = password_hash($_POST['sandi'], PASSWORD_DEFAULT);

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
            'email' => "$email",
            'no_telp' => "$no_telp",
            'asal_rumah_sakit' => "$asal_rumah_sakit",
            'sandi' => "$sandi",
            'role' => "admin"
        ])) {
            $_SESSION['login'] = true;
            $_SESSION['user'] = db_find('users', ['id' => $id]);
            header("Location: index.php");
            exit;
        } else {
            setFlash('Gagal mendaftar');
        }
    }
}

include 'header_auth.php';
?>
<form method="POST">
    <div class="row mt-3">
        <div class="col-12">
            <label for="nama">Nama</label>
        </div>
        <div class="col-12">
            <input value="<?= old_value('nama'); ?>" required class="w-100" type="text" name="nama" id="nama">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <label for="email">E-mail</label>
        </div>
        <div class="col-12">
            <input value="<?= old_value('email'); ?>" required class="w-100" type="email" name="email" id="email">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <label for="no_telp">No Telp</label>
        </div>
        <div class="col-12">
            <input value="<?= old_value('no_telp'); ?>" required class="w-100" type="number" name="no_telp" id="no_telp">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <label for="sandi1">Sandi</label>
        </div>
        <div class="col-12">
            <input value="<?= old_value('sandi'); ?>" required class="w-100 password-hash" type="password" name="sandi" id="sandi">
        </div>
        <div class="col-12 mt-2">
            <input class="show-password" type="checkbox" id="show_pass">
            <label for="show_pass">Tampilkan</label>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <label for="asal_rumah_sakit">Asal Rumah Sakit</label>
        </div>
        <div class="col-12">
            <input value="<?= old_value('asal_rumah_sakit'); ?>" required class="w-100" type="text" name="asal_rumah_sakit" id="asal_rumah_sakit">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 text-center">
            <button class="btn btn-light border border-dark border-1">Daftar</button>
        </div>
    </div>
</form>
<?php include 'footer.php' ?>