<?php include 'function.php' ?>
<?php include 'header.php' ?>
<h3 class="mt-3">Pesan Masuk</h3>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">E-Mail</th>
            <th scope="col">Lokasi User</th>
            <th scope="col">Pesan</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Tugas</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach (db_findAll('pesanmasuk') as $pesan) : ?>
            <tr>
                <td><?= db_find('users', ['id' => $pesan['id']])->email; ?></td>
                <th><a target="_blank" href="https://www.google.com/maps/search/?api=1&query=<?= $pesan['lokasi_user']; ?>"><?= $pesan['lokasi_user']; ?></a></th>
                <td>Gawat Darurat</td>
                <td><?= $pesan['keterangan']; ?></td>
                <td><?= $pesan['tugas']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'footer.php' ?>