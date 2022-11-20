<?php include 'function.php' ?>
<?php
// Jika klik tambah
if (isset($_POST['btn-add'])) {
    $nama = htmlspecialchars(strtolower($_POST['nama']));
    $no_telp = htmlspecialchars($_POST['no_telp']);
    $email = htmlspecialchars(strtolower($_POST['email']));
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
            'user_id' => user()->id,
            'id' => uniqid(),
            'nama' => $nama,
            'no_telp' => $no_telp,
            'email' => $email,
            'sandi' => $sandi,
            'role' => 'user'
        ])) {
            setFlash("Berhasil Menambahkan user");
            header("Location: user.php");
            exit;
        } else {
            setFlash("Gagal Menambahkan user");
        }
    }
}

// Jika klik edit
if (isset($_POST['btn-edit'])) {
    $nama = htmlspecialchars(strtolower($_POST['nama']));
    $no_telp = htmlspecialchars($_POST['no_telp']);
    $email = htmlspecialchars(strtolower($_POST['email']));
    $row = db_find('users', ['id' => $_POST['id']]);
    if (empty($row)) {
        setFlash('Gagal mengubah data user');
        header('Location: supir.php');
        exit;
    }

    // Cek Sandi
    if (empty($_POST['sandi'])) {
        $sandi = $row->sandi;
    } else {
        $sandi = password_hash($_POST['sandi'], PASSWORD_DEFAULT);
    }

    // Cek Email
    if ($email != $row->email) {
        if (db_find('users', ['email' => $email])) {
            setFlash('Email sudah terdaftar');
        }
    }

    // Cek Nomor Telephone
    if ($no_telp != $row->no_telp) {
        if (db_find('users', ['no_telp' => $no_telp])) {
            setFlash('Nomor Telepon sudah terdaftar');
        }
    }

    if (!isFlash()) {
        if (db_update('users', ['id' => $_POST['id']], [
            'user_id' => user()->id,
            'id' => uniqid(),
            'nama' => $nama,
            'no_telp' => $no_telp,
            'email' => $email,
            'no_kendaraan' => $no_kendaraan,
        ])) {
            setFlash("Berhasil Mengubah Data user");
            header("Location: user.php");
            exit;
        } else {
            setFlash("Gagal Mengubah Data user");
        }
    }
}

// Jika klik delete
if (isset($_POST['btn-delete'])) {
    if (db_delete('users', ['id' => $_POST['id']])) {
        setFlash("Berhasil Menghapus user");
        header("Location: user.php");
        exit;
    } else {
        setFlash("Gagal Menghapus user");
    }
}
?>
<?php include 'header.php' ?>
<h3 class="mt-3">Data User</h3>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Nama</th>
            <th scope="col">No Telp</th>
            <th scope="col">E-Mail</th>
            <th scope="col">Sandi</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <form method="post">
                    <input placeholder="Masukan Nama" required class="w-100" type="text" name="nama" id="nama">
            </td>
            <td><input placeholder="Masukan No Telepon" required class="w-100" type="number" name="no_telp" id="no_telp"></td>
            <td><input placeholder="Masukan Email" required class="w-100" type="email" name="email" id="email"></td>
            <td><input placeholder="Masukan Sandi" required class="w-100" type="password" name="sandi" id="sandi"></td>
            <td>
                <button name="btn-add" class="btn btn-light border border-dark border-1 btn-sm"><i class="fa fa-add"></i></button>
                </form>
            </td>
        </tr>
        <?php foreach (db_query("SELECT * FROM users WHERE role = 'user'") as $supir) : ?>
            <tr>
                <td>
                    <form method="POST">
                        <input value="<?= $supir['id']; ?>" type="hidden" name="id" id="id">
                        <input value="<?= $supir['nama']; ?>" required class="input-supir" type="text" name="nama" id="nama">
                </td>
                <td><input value="<?= $supir['no_telp']; ?>" required class="input-supir" type="number" name="no_telp" id="no_telp"></td>
                <td><input value="<?= $supir['email']; ?>" required class="input-supir" type="email" name="email" id="email"></td>
                <td><input placeholder="Masukan Sandi Baru" class="w-100" type="password" name="sandi" id="sandi"></td>
                <td>
                    <button onclick="return confirm('Ubah data user ini?')" name="btn-edit" class="btn btn-light btn-sm" style="background-color: #fff;"><i class="fa fa-edit"></i></button>
                    <button onclick="return confirm('Hapus user ini?')" name="btn-delete" class="btn btn-light btn-sm" style="background-color: #fff;"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'footer.php' ?>