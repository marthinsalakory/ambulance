<?php include 'function.php' ?>
<?php
if (!empty($_POST)) {
    $id = htmlspecialchars(strtolower($_POST['id']));
    $nama = htmlspecialchars(strtolower($_POST['nama']));
    $no_telp = htmlspecialchars(strtolower($_POST['no_telp']));
    $email = htmlspecialchars(strtolower($_POST['email']));
    $asal_rumah_sakit = htmlspecialchars(strtolower($_POST['asal_rumah_sakit']));

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
            'asal_rumah_sakit' => "$asal_rumah_sakit",
            'no_telp' => "$no_telp",
            'sandi' => "$sandi",
        ])) {
            setFlash("Berhasil Mengubah Data Akun");
            header("Location: akun.php");
            exit;
        } else {
            setFlash("Gagal Mengubah Data Akun");
        }
    }
}
?>
<?php include 'header.php' ?>
<div class="card mt-5 border border-3 border-dark position-relative">
    <h3 class="position-absolute" style="top: -20px; left: 20px;background-color: #fff;">Akun</h3>
    <form method="POST" class="card-body">
        <div class="row">
            <div class="col-2">
                <label for="nama">Nama</label>
            </div>
            <div class="col-lg-8 col-sm-10">
                <input type="hidden" name="id" value="<?= user()->id; ?>">
                <input required class="input-akun" name="nama" type="text" value="<?= user()->nama; ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-2">
                <label for="no_telp">No Telp</label>
            </div>
            <div class="col-lg-8 col-sm-10">
                <input required class="input-akun" name="no_telp" type="text" value="<?= user()->no_telp; ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-2">
                <label for="email">Email</label>
            </div>
            <div class="col-lg-8 col-sm-10">
                <input required class="input-akun" name="email" type="email" value="<?= user()->email; ?>">
            </div>
            <div class="col-2">
                <button class="btn btn-light border border-dark border-1 btn-simpan_akun1">Simpan</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-2">
                <label for="asal_rumah_sakit">Asal Rumah Sakit</label>
            </div>
            <div class="col-lg-8 col-sm-10">
                <input required class="input-akun" name="asal_rumah_sakit" type="text" value="<?= user()->asal_rumah_sakit; ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-2">
                <label for="sandi">Sandi</label>
            </div>
            <div class="col-lg-8 col-sm-10">
                <input class="input-akun password-hash" name="sandi" type="password">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-2">
                <label for="konfirmasi_sandi">Konfirmasi Sandi</label>
            </div>
            <div class="col-lg-8 col-sm-10">
                <input class="input-akun password-hash" name="sandi1" type="password">
            </div>
            <div class="col-lg-2 col-sm-12">
                <input value="on" class="show-password" type="checkbox" id="tampilkan_password">
                <label for="tampilkan_password">Tampilkan</label>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <button class="btn btn-light border border-dark border-1 btn-simpan_akun2">Simpan</button>
            </div>
        </div>
    </form>
</div>
<?php include 'footer.php' ?>