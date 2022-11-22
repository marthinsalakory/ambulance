<?php include 'function.php' ?>
<?php isLogin('masukuser.php'); ?>
<?php mustRole('user', 'masukuser.php'); ?>
<?php
$pesan = db_find('pesanmasuk', ['id' => $_GET['pesan_id']]);

$user_location = $pesan->lokasi_user;
$rs_location = db_find('users', ['id' => $pesan->rs_id])->asal_rumah_sakit;

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
    <div class="card position-fixed bottom-0 w-100" style="z-index: 9999;">
        <div class="card-header text-center" style="background-color: #fff;">
            <h3 class="fw-bold"><?= $pesan->tugas_pasien; ?>!!!</h3>
        </div>
        <div class="card-body bg-light text-center">
            <div>RSU Bhakti Rahayu</div>
            <div><a href="tel:091134098">(0911) 342746</a></div>
            <div>-</div>
            <?php if ($pesan->supir_id) : ?>
                <div>Nama Supir</div>
                <div><a href="tel:080183908 ">08123498400</a></div>
            <?php else : ?>
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden"></span>
                </div>
                <div>Sedang Mencari</div>
            <?php endif; ?>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-light border border-1 border-dark">Selesai</button>
        </div>
    </div>
</div>
<script>
    const map = L.map('map', {
        attributionControl: false
    }).setView([<?= $user_location; ?>], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    L.marker([<?= $user_location; ?>], {
        icon: L.icon({
            iconUrl: 'assets/img/icon_location_blue.png',
            iconSize: [20, 20],
            iconAnchor: [10, 20],
            popupAnchor: [0, -20]
        })
    }).addTo(map).bindPopup('Lokasi Penjemputan Ambulance.').openPopup();
    L.marker([<?= $rs_location ?>], {
        icon: L.icon({
            iconUrl: 'assets/img/icon_location_red.png',
            iconSize: [20, 20],
            iconAnchor: [10, 20],
            popupAnchor: [0, -20]
        })
    }).addTo(map).bindPopup('Lokasi Rumah Sakit.');

    L.Routing.control({
        waypoints: [
            L.latLng(<?= $user_location; ?>),
            L.latLng(<?= $rs_location ?>)
        ],
        lineOptions: {
            styles: [{
                color: 'blue',
                weight: 2
            }],
            addWaypoints: false
        },
        fitSelectedRoutes: true,
        draggableWaypoints: false,
        routeWhileDragging: false,
        createMarker: function() {
            return null;
        }
    }).addTo(map);
</script>
<?php include 'footer_user.php'; ?>