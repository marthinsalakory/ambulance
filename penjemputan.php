<?php include 'function.php' ?>
<?php isLogin('masukuser.php'); ?>
<?php mustRole('user', 'masukuser.php'); ?>
<?php
$user_id = user()->id;
$pesan = db_query("SELECT * FROM pesanmasuk WHERE user_id = '$user_id' && tugas_pasien != 'selesai'")->fetch_object();

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
            <h3 class="fw-bold" id="tugas_pasien"></h3>
        </div>
        <div class="card-body bg-light text-center">
            <div id="nama_rs"></div>
            <div><a id="no_telp_rs"></a></div>
            <div>-</div>
            <div id="data_supir">
            </div>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-light border border-1 border-dark">Selesai</button>
        </div>
    </div>
</div>
<script>
    api_pesan();
    api_rs();
    window.setInterval(function() {
        api_pesan();
        api_rs();
    }, 5000);


    const map = L.map('map', {
        attributionControl: false
    }).setView([<?= $user_location; ?>], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    function api_pesan() {
        $.ajax({
            url: "api.php",
            data: {
                query: "SELECT * FROM pesanmasuk WHERE id = '<?= $pesan->id; ?>'"
            },
            type: "POST",
            dataType: 'json',
            success: function(result) {
                $('#tugas_pasien').text(result.tugas_pasien);
                if (result.supir_id) {
                    L.marker(result.lokasi_supir.split(", "), {
                        icon: L.icon({
                            iconUrl: 'assets/img/icon_location_red.png',
                            iconSize: [20, 20],
                            iconAnchor: [10, 20],
                            popupAnchor: [0, -20]
                        })
                    }).addTo(map).bindPopup('Lokasi Ambulance.').openPopup();

                    L.marker([<?= $user_location; ?>], {
                        icon: L.icon({
                            iconUrl: 'assets/img/icon_location_green.png',
                            iconSize: [20, 20],
                            iconAnchor: [10, 20],
                            popupAnchor: [0, -20]
                        })
                    }).addTo(map).bindPopup('Lokasi Penjemputan Ambulance.');

                    L.marker([<?= $rs_location ?>], {
                        icon: L.icon({
                            iconUrl: 'assets/img/icon_location_blue.png',
                            iconSize: [20, 20],
                            iconAnchor: [10, 20],
                            popupAnchor: [0, -20]
                        })
                    }).addTo(map).bindPopup('Lokasi Rumah Sakit.');

                    L.Routing.control({
                        waypoints: [
                            L.latLng(result.lokasi_supir.split(", ")),
                            L.latLng(<?= $user_location; ?>),
                            L.latLng(<?= $rs_location ?>)
                        ],
                        lineOptions: {
                            styles: [{
                                color: 'red',
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

                    $.ajax({
                        url: "api.php",
                        data: {
                            query: "SELECT * FROM users WHERE id = '" + result.supir_id + "'"
                        },
                        type: "POST",
                        dataType: 'json',
                        success: function(res) {
                            $('#data_supir').html(`
                                <div id="nama_supir">` + res.nama + `</div>
                                <div><a id="no_telp_supir" href="tel:` + res.no_telp + `">` + res.no_telp + `</a></div>
                            `);
                        }
                    });
                } else {
                    L.marker([<?= $user_location; ?>], {
                        icon: L.icon({
                            iconUrl: 'assets/img/icon_location_green.png',
                            iconSize: [20, 20],
                            iconAnchor: [10, 20],
                            popupAnchor: [0, -20]
                        })
                    }).addTo(map).bindPopup('Lokasi Penjemputan Ambulance.').openPopup();

                    L.marker([<?= $rs_location ?>], {
                        icon: L.icon({
                            iconUrl: 'assets/img/icon_location_blue.png',
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
                                color: 'green',
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
                    $('#data_supir').html(`
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <div>Sedang Mencari Ambulance</div>
                    `);
                }
            }
        });
    }

    function api_rs() {
        $.ajax({
            url: "api.php",
            data: {
                query: "SELECT * FROM users WHERE id = '<?= $pesan->rs_id; ?>'"
            },
            type: "POST",
            dataType: 'json',
            success: function(result) {
                $('#nama_rs').text(result.nama);
                $('#no_telp_rs').text(result.no_telp);
                $('#no_telp_rs').attr('href', 'tel:' + result.no_telp);
            }
        });
    }
</script>
<?php include 'footer_user.php'; ?>