<?php include 'function.php' ?>
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
        <div class="col-12">
            <form method="POST">
                <input type="hidden" name="user_id" id="user_id">
                <input type="hidden" name="user_location" id="user_location">
                <input type="hidden" name="id_rs" id="id_rs">
            </form>
        </div>
        <div class="col-12 position-relative" id="tampil" style="background-color: #ddd;height: 50px; display: none;cursor: pointer;">
            <span id="tampil_status" class="position-absolute bg-primary border border-1 border-dark rounded-circle end-0 top-50 translate-middle-y me-5" style="height: 30px; width: 30px;"></span>
            <p class="ps-2"><span id="tampil_nama"></span><br><span id="tampil_no_telp"></span></p>
        </div>
    </div>
    <div class="card position-fixed bottom-0 w-100">
        <div class="card-body d-flex justify-content-evenly">
            <a href="akunuser.php" class="pt-3 btn btn-secondary btn-sm mt-3 p-0 m-0" style="font-size: 10px;;width: 70px; height: 70px; border-radius: 50%;"><i class="fa-solid fa-address-card"></i><br> Akun</a>
            <a href="" class="pt-3 btn btn-danger btn-sm mb-3 p-0 m-0" style="font-size: 10px;;width: 70px; height: 70px; border-radius: 50%;"><i class="fa-solid fa-truck-medical"></i><br> Darurat</a>
            <a href="rumahsakit.php" class="pt-3 btn btn-secondary btn-sm mt-3 p-0 m-0" style="font-size: 10px;;width: 70px; height: 70px; border-radius: 50%;"><i class="fa-solid fa-hospital"></i><br> Rumah Sakit</a>
        </div>
    </div>
</div>

<script>
    const map = L.map('map').setView([-3.6814045, 128.0299189], 10);

    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = new L.marker([-3.6814045, 128.0299189]);

    var myIconn = L.icon({
        iconUrl: 'assets/img/icon_location_blue.png',
        iconSize: [20, 20],
        iconAnchor: [10, 20],
        popupAnchor: [0, -20]
    });

    function onMapClick(e) {
        map.removeLayer(marker);
        marker = L.marker(e.latlng, {
            icon: myIconn
        });
        $('#user_location').val(e.latlng.lat + ',' + e.latlng.lng);
        $('#user_id').val('<?= user()->id; ?>');
        marker.addTo(map).bindPopup('Titik jemput ambulance').openPopup();
    }
    map.on('click', onMapClick);

    // lokasi rumah sakit
    var myIcon = L.icon({
        iconUrl: 'assets/img/icon_location_red.png',
        iconSize: [20, 20],
        iconAnchor: [10, 20],
        popupAnchor: [0, -20]
    });
    <?php foreach (db_query("SELECT * FROM users WHERE role = 'admin'") as $rs) : ?>
        var marker_rs = L.marker([<?= $rs['asal_rumah_sakit']; ?>], {
            icon: myIcon
        }).addTo(map);
        // .bindPopup(`<?= $rs['nama']; ?>`);
        marker_rs.on('click', function() {
            var status = <?= db_count('users', ['user_id' => $rs['id'], 'status' => 'tersedia']); ?>;
            if (status == 0) {
                $('#tampil_status').attr('class', 'position-absolute bg-danger border border-1 border-dark rounded-circle end-0 top-50 translate-middle-y me-5');
            } else {
                $('#tampil_status').attr('class', 'position-absolute bg-primary border border-1 border-dark rounded-circle end-0 top-50 translate-middle-y me-5');
            }
            $('#tampil').show();
            $('#tampil_nama').text('<?= $rs['nama']; ?>');
            $('#tampil_no_telp').text('<?= $rs['no_telp']; ?>');
            $('#id_rs').val('<?= $rs['id']; ?>');
        });
    <?php endforeach; ?>
    $('#tampil').on('click', function() {
        var err = 0;
        if (status == 0) {
            alert('Gagal pesan ambulance!\nKarena supir belum ada.');
            err = 1;
        } else if ($('#user_location').val() == '') {
            alert('Gagal pesan ambulance!\nSilahkan pilih lokasi jemput terlebih dahulu.');
            err = 1;
        }
        if (err == 0) {
            alert('berhasil');
        }
    });
</script>
<?php include 'footer_auth.php' ?>