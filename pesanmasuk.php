<?php include 'function.php' ?>
<?php include 'header.php' ?>
<h3 class="mt-3">Pesan Masuk</h3>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col" rowspan="2">E-Mail</th>
            <th scope="col" rowspan="2">Lokasi User</th>
            <th scope="col" rowspan="2">Pesan</th>
            <th class="text-center" scope="col" colspan="2">Keterangan</th>
        </tr>
        <tr>
            <th class="text-center" scope="col">User</th>
            <th class="text-center" scope="col">Supir</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach (db_findAll('pesanmasuk') as $pesan) : ?>
            <tr>
                <td><?= db_find('users', ['id' => $pesan['user_id']])->email; ?></td>
                <th><a target="_blank" href="https://www.google.com/maps/search/?api=1&query=<?= $pesan['lokasi_user']; ?>"><?= $pesan['lokasi_user']; ?></a></th>
                <td>Gawat Darurat</td>
                <td><?= $pesan['tugas_pasien']; ?></td>
                <td><?= $pesan['tugas_supir']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'footer.php' ?>