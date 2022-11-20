<?php include 'function.php' ?>
<?php
// Jika klik tambah
if (isset($_POST['btn-add'])) {
    $nama = htmlspecialchars(strtolower($_POST['nama']));
    $no_telp = htmlspecialchars($_POST['no_telp']);
    $email = htmlspecialchars(strtolower($_POST['email']));
    $no_kendaraan = htmlspecialchars(strtolower($_POST['no_kendaraan']));

    // Cek Email
    if (db_find('users', ['email' => $email])) {
        setFlash('Email sudah terdaftar');
    }

    // Cek Nomor Telephone
    if (db_find('users', ['no_telp' => $no_telp])) {
        setFlash('Nomor Telepon sudah terdaftar');
    }

    // Cek Nomor Kendaraan
    if (db_find('users', ['no_kendaraan' => $no_kendaraan])) {
        setFlash('Nomor Nomor Kendaraan sudah terdaftar');
    }

    if (!isFlash()) {
        if (db_insert('users', [
            'user_id' => user()->id,
            'id' => uniqid(),
            'nama' => $nama,
            'no_telp' => $no_telp,
            'email' => $email,
            'no_kendaraan' => $no_kendaraan,
            'role' => 'supir'
        ])) {
            setFlash("Berhasil Menambahkan Supir");
            header("Location: supir.php");
            exit;
        } else {
            setFlash("Gagal Menambahkan Supir");
        }
    }
}

// Jika klik edit
if (isset($_POST['btn-edit'])) {
    $nama = htmlspecialchars(strtolower($_POST['nama']));
    $no_telp = htmlspecialchars($_POST['no_telp']);
    $email = htmlspecialchars(strtolower($_POST['email']));
    $no_kendaraan = htmlspecialchars(strtolower($_POST['no_kendaraan']));
    $row = db_find('users', ['id' => $_POST['id']]);
    if (empty($row)) {
        setFlash('Gagal mengubah data supir');
        header('Location: supir.php');
        exit;
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

    // Cek Nomor Kendaraan
    if ($no_kendaraan != $row->no_kendaraan) {
        if (db_find('users', ['no_kendaraan' => $no_kendaraan])) {
            setFlash('Nomor Kendaraan sudah terdaftar');
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
            'role' => 'supir'
        ])) {
            setFlash("Berhasil Mengubah Data Supir");
            header("Location: supir.php");
            exit;
        } else {
            setFlash("Gagal Mengubah Data Supir");
        }
    }
}

// Jika klik delete
if (isset($_POST['btn-delete'])) {
    if (db_delete('users', ['id' => $_POST['id']])) {
        setFlash("Berhasil Menghapus Supir");
        header("Location: supir.php");
        exit;
    } else {
        setFlash("Gagal Menghapus Supir");
    }
}
?>
<?php include 'header.php' ?>
<h3 class="mt-3">Data Supir</h3>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Nama</th>
            <th scope="col">No Telp</th>
            <th scope="col">E-Mail</th>
            <th scope="col">No Kendaraan</th>
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
            <td><input placeholder="Masukan No Kendaraan" required class="w-100" type="text" name="no_kendaraan" id="no_kendaraan"></td>
            <td>
                <button name="btn-add" class="btn btn-light border border-dark border-1 btn-sm"><i class="fa fa-add"></i></button>
                </form>
            </td>
        </tr>
        <?php foreach (db_query("SELECT * FROM users WHERE role = 'supir'") as $supir) : ?>
            <tr>
                <td>
                    <form method="POST">
                        <input value="<?= $supir['id']; ?>" type="hidden" name="id" id="id">
                        <input value="<?= $supir['nama']; ?>" required class="input-supir" type="text" name="nama" id="nama">
                </td>
                <td><input value="<?= $supir['no_telp']; ?>" required class="input-supir" type="number" name="no_telp" id="no_telp"></td>
                <td><input value="<?= $supir['email']; ?>" required class="input-supir" type="email" name="email" id="email"></td>
                <td><input value="<?= strtoupper($supir['no_kendaraan']); ?>" required class="input-supir" type="text" name="no_kendaraan" id="no_kendaraan"></td>
                <td>
                    <button onclick="return confirm('Ubah data supir ini?')" name="btn-edit" class="btn btn-light btn-sm" style="background-color: #fff;"><i class="fa fa-edit"></i></button>
                    <button onclick="return confirm('Hapus supir ini?')" name="btn-delete" class="btn btn-light btn-sm" style="background-color: #fff;"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<!-- <div class="w-100 text-center">
    <button class="btn border border-2 border-dark"><i class="fa fa-add"></i></button>
</div> -->
<?php include 'footer.php' ?>