<?php include 'function.php' ?>
<?php
// Jika klik delete
if (isset($_POST['btn-delete'])) {
    if (db_delete('pesanmasuk', ['id' => $_POST['id']])) {
        setFlash("Berhasil Menghapus Data");
        header("Location: user.php");
        exit;
    } else {
        setFlash("Gagal Menghapus Data");
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
            <th scope="col">Pesan</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach (db_findAll('pesanmasuk', ['rs_id' => user()->id]) as $p) : ?>
            <tr>
                <td>
                    <form method="POST">
                        <input value="<?= $p['id']; ?>" type="hidden" name="id" id="id">
                        <input readonly value="<?= db_find('users', ['id' => $p['user_id']])->nama; ?>" required class="input-supir" type="text" name="nama" id="nama">
                </td>
                <td><input readonly value="<?= db_find('users', ['id' => $p['user_id']])->no_telp; ?>" required class="input-supir" type="number" name="no_telp" id="no_telp"></td>
                <td><input readonly value="<?= db_find('users', ['id' => $p['user_id']])->email; ?>" required class="input-supir" type="email" name="email" id="email"></td>
                <td>Gawat Darurat</td>
                <td>
                    <button onclick="return confirm('Hapus user ini?')" name="btn-delete" class="btn btn-light btn-sm" style="background-color: #fff;"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'footer.php' ?>