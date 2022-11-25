<?php include 'function.php' ?>
<?php isLogin('masukuser.php'); ?>
<?php mustRole('user', 'masukuser.php'); ?>
<?php
$user_id = user()->id;
if ($row = db_query("SELECT * FROM pesanmasuk WHERE user_id = '$user_id' && tugas_pasien != 'selesai'")->fetch_object()) {
    header("Location: penjemputan.php");
    exit;
}
if (!empty($_POST)) {
    if ($_POST['jumlah_supir'] != 0) {
        $id = uniqid();
        if (db_insert('pesanmasuk', [
            'id' => $id,
            'user_id' => user()->id,
            'lokasi_user' => $_POST['titik_jemput'],
            'rs_id' => $_POST['rs_id']
        ])) {
            header('Location: penjemputan.php');
            exit;
        } else {
            setFlash('Gagal Memesan Ambulance');
        }
    } else {
        setFlash("Gagal, Tidak ada supir ambulance pada rumah sakit ini.");
    }
}
?>
<?php include 'header_user.php' ?>
<div class="container-fluid">
    <div class="row fw-bold" style="background-color: #DDDDDD;">
        <div class="col-12 d-flex justify-content-center">
            <div class="text-center" style="width: 100px;">
                <img src="assets/img/ambulance-car.png" width="60">
                <span>Ambulance</span>
            </div>
        </div>
    </div>
</div>
<?= flash(); ?>
<div class="mx-auto position-relative" style="width: 100%;height: 91vh;">
    <div id="map" style="width: 100%; height: 350px;"></div>
    <div class="row border border-dark border-1">
        <div class="col-12 text-center" style="height: 25px;">
            <p>Rumah Sakit Terdekat</p>
        </div>
        <?php foreach (db_findAll('users', ['role' => 'admin']) as $rs) : ?>
            <div onclick="$('#jumlah_supir').val('<?= db_count('users', ['role' => 'supir', 'status' => 'tersedia', 'user_id' => $rs['id']]); ?>');$('#rs_id').val('<?= $rs['id']; ?>');$('#nama_rs').val('<?= $rs['nama']; ?>')" data-bs-toggle="modal" data-bs-target="#modal_rs" class="col-12 position-relative mt-1" style="background-color: #ddd;height: 50px; cursor: pointer;">
                <span class="position-absolute <?= db_count('users', ['role' => 'supir', 'status' => 'tersedia', 'user_id' => $rs['id']]) != 0 ? 'bg-primary' : 'bg-danger'; ?> border border-1 border-dark rounded-circle end-0 top-50 translate-middle-y me-5" style="height: 30px; width: 30px;"></span>
                <p class="ps-2">
                    <span><?= $rs['nama']; ?></span><br>
                    <span><?= $rs['no_telp']; ?></span>
                </p>
            </div>
        <?php endforeach; ?>
    </div><br><br><br><br><br><br>
    <div class="card position-fixed bottom-0 w-100">
        <div class="card-body d-flex justify-content-evenly">
            <a href="akunuser.php" class="pt-3 btn btn-secondary btn-sm mt-3 p-0 m-0" style="font-size: 10px;;width: 70px; height: 70px; border-radius: 50%;"><i class="fa-solid fa-address-card"></i><br> Akun</a>
            <a href="" class="pt-3 btn btn-danger btn-sm mb-3 p-0 m-0" style="font-size: 10px;;width: 70px; height: 70px; border-radius: 50%;"><i class="fa-solid fa-truck-medical"></i><br> Darurat</a>
            <a href="rumahsakit.php" class="pt-3 btn btn-secondary btn-sm mt-3 p-0 m-0" style="font-size: 10px;;width: 70px; height: 70px; border-radius: 50%;"><i class="fa-solid fa-hospital"></i><br> Rumah Sakit</a>
        </div>
    </div>
</div>
<!-- Modal Rs -->
<div class="modal fade" id="modal_rs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Pesan Ambulance <img src="assets//img/ambulance-car.png" width="60"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label for="nama_rs">Nama Rumah Sakit</label>
                    </div>
                    <div class="col-12 mt-1"><input readonly class="form-control" type="text" id="nama_rs"></div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <label for="titik_jemput">Titik Jemput</label>
                    </div>
                    <div class="col-12 mt-1">
                        <input type="hidden" name="jumlah_supir" id="jumlah_supir">
                        <input type="hidden" name="rs_id" id="rs_id">
                        <input required class="form-control" type="text" name="titik_jemput" id="titik_jemput" placeholder="Masukan Latitude dan Longitude">
                    </div>
                    <div class="col-12 mt-1">
                        <div id="pilih_map" style="width: 100%; height: 350px;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary">PESAN SEKARANG</button>
            </div>
        </form>
    </div>
</div>

<script>
    const map = L.map('map').setView([-3.658062, 128.193283], 10);
    const pilih_map = L.map('pilih_map').setView([-3.658062, 128.193283], 10);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(pilih_map);

    var marker = L.marker([-3.658062, 128.193283]);
    var icon_pilih = L.icon({
        iconUrl: 'assets/img/icon_location_green.png',
        iconSize: [20, 20],
        iconAnchor: [10, 20],
        popupAnchor: [0, -20]
    })
    pilih_map.on('click', function(pl) {
        if (!marker) {
            marker = L.marker(pl.latlng, {
                icon: icon_pilih
            });
        } else {
            pilih_map.removeLayer(marker);
            marker = L.marker(pl.latlng, {
                icon: icon_pilih
            });
        }
        $('#titik_jemput').val(pl.latlng.lat + ', ' + pl.latlng.lng);
        marker.addTo(pilih_map);
    });

    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    <?php foreach (db_findAll('users', ['role' => 'admin']) as $rs) : ?>
        L.marker([<?= $rs['asal_rumah_sakit']; ?>], {
            icon: L.icon({
                iconUrl: 'assets/img/icon_location_<?= db_count('users', ['role' => 'supir', 'status' => 'tersedia', 'user_id' => $rs['id']]) == 0 ? 'red.png' : 'blue.png'; ?>',
                iconSize: [20, 20],
                iconAnchor: [10, 20],
                popupAnchor: [0, -20]
            })
        }).addTo(map).bindPopup(`<div onclick="$('#rs_id').val('<?= $rs['id']; ?>');$('#nama_rs').val('<?= $rs['nama']; ?>')" data-bs-toggle="modal" data-bs-target="#modal_rs" class="col-12 position-relative mt-1" style="cursor: pointer"><b><?= $rs['nama']; ?></b><br /><?= $rs['no_telp']; ?><br>supir: <?= db_count('users', ['role' => 'supir', 'status' => 'tersedia', 'user_id' => $rs['id']]) == 0 ? 'tidak tersedia' : 'tersedia'; ?>.</div>`);
    <?php endforeach; ?>
</script>
<?php include 'footer_auth.php' ?>