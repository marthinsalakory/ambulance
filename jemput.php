<?php include 'function.php' ?>
<?php isLogin('masuksupir.php'); ?>
<?php mustRole('supir', 'masuksupir.php'); ?>
<?php
$user_id = user()->id;
$pesan = db_query("SELECT * FROM pesanmasuk WHERE supir_id = '$user_id' && tugas_supir != 'selesai'")->fetch_object();

$user_location = $pesan->lokasi_user;
$rs_location = db_find('users', ['id' => $pesan->rs_id])->asal_rumah_sakit;

if (isset($_POST['selesai'])) {
    if (db_update('pesanmasuk', ['id' => $pesan->id], [
        'tugas_supir' => 'selesai'
    ])) {
        setFlash('Terimakasih telah memesan ambulance');
        header("Location: permintaan.php");
        exit;
    } else {
        setFlash('Gagal Selesai');
    }
}

?>
<?php include 'header_user.php' ?>
<div class="container-fluid">
    <div class="row fw-bold" style="background-color: #DDDDDD;">
        <div class="col-12 d-flex justify-content-center">
            <a href="" class="text-center text-decoration-none text-dark" style="width: 100px;">
                <img src="assets/img/ambulance-car.png" width="60">
                <span>Ambulance</span>
            </a>
        </div>
    </div>
</div>
<?= flash(); ?>
<div class="mx-auto position-relative" style="width: 100%;height: 91vh;">
    <div id="map" style="width: 100%; height: 380px;"></div>
    <div class="card position-fixed bottom-0 w-100" style="z-index: 9999;">
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-12">
                    Info:
                </div>
            </div>
            <div class="row">
                <div class="col-1 text-end">
                    <i class="fa-solid fa-bullhorn position-absolute"></i>&nbsp;&nbsp;
                </div>
                <div class="col-11">
                    <input id="pesan_user" readonly class="input-akun bg-transparent text-center" type="text" placeholder="Pesan User">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1 text-end">
                    <i class="fa-solid fa-circle-user"></i>
                </div>
                <div class="col-11">
                    <input id="nama_user" readonly class="input-akun bg-transparent text-center" type="text" placeholder="Nama User">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-1 text-end">
                    <i class="fa-solid fa-mobile-screen"></i>
                </div>
                <div class="col-11">
                    <input onclick="copyToClipboard()" id="no_telp_user" readonly class="input-akun bg-transparent text-center" type="text" placeholder="No Telp User">
                </div>
            </div>
        </div>
        <form method="POST" class="card-footer text-center">
            <input type="hidden" name="selesai" id="selesai">
            <button class="btn btn-light border border-1 border-dark">Selesai</button>
        </form>
    </div>
</div>
<script>
    api_pesan();
    api_rs();
    window.setInterval(function() {
        api_pesan();
        api_rs();
        geoLocation();
    }, 5000);

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
                $.ajax({
                    url: "api.php",
                    data: {
                        query: "SELECT * FROM users WHERE id = '" + result.user_id + "'"
                    },
                    type: "POST",
                    dataType: 'json',
                    success: function(res) {
                        $('#pesan_user').attr('placeholder', 'Gawat Darurat');
                        $('#nama_user').attr('placeholder', res.nama);
                        $('#no_telp_user').attr('placeholder', res.no_telp);
                    }
                });
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

    const map = L.map('map', {
        attributionControl: false
    }).setView([<?= $user_location; ?>], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    geoLocation();

    function geoLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert('Browser tidak mendukung geolocation');
        }
    }

    function showError(err) {
        alert('Akses lokasi tidak diijinkan');
    }

    var marker_ambulance = L.marker([-3.658062, 128.193283]);
    var route_ambulance = L.Routing.control({
        waypoints: [
            L.latLng([1, 1]),
            L.latLng([12, 12]),
        ]
    });

    function showPosition(position) {
        // alert(position.coords.latitude);
        $.ajax({
            url: "api.php",
            data: {
                update: "UPDATE `pesanmasuk` SET `lokasi_supir`=\"" + position.coords.latitude + ', ' + position.coords.longitude + "\" WHERE id = '<?= $pesan->id; ?>'"
            },
            type: "POST",
            success: function(result) {
                // alert(result);
            }
        });

        map.removeLayer(marker_ambulance);
        marker_ambulance = L.marker([position.coords.latitude, position.coords.longitude], {
            icon: L.icon({
                iconUrl: 'assets/img/icon_location_red.png',
                iconSize: [20, 20],
                iconAnchor: [10, 20],
                popupAnchor: [0, -20]
            })
        });
        marker_ambulance.addTo(map).bindPopup('Lokasi Ambulance.');

        map.removeControl(route_ambulance);
        route_ambulance = L.Routing.control({
            waypoints: [
                L.latLng([position.coords.latitude, position.coords.longitude]),
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
            show: false,
            fitSelectedRoutes: true,
            draggableWaypoints: false,
            routeWhileDragging: false,
            createMarker: function() {
                return null;
            }
        });
        route_ambulance.addTo(map);
    }


    L.marker([<?= $user_location; ?>], {
        icon: L.icon({
            iconUrl: 'assets/img/icon_location_green.png',
            iconSize: [20, 20],
            iconAnchor: [10, 20],
            popupAnchor: [0, -20]
        })
    }).addTo(map).bindPopup('Lokasi Penjemputan Pasien.').openPopup();

    L.marker([<?= $rs_location ?>], {
        icon: L.icon({
            iconUrl: 'assets/img/icon_location_blue.png',
            iconSize: [20, 20],
            iconAnchor: [10, 20],
            popupAnchor: [0, -20]
        })
    }).addTo(map).bindPopup('Lokasi Rumah Sakit.');

    function copyToClipboard() {
        // Get the text field
        var copyText = document.getElementById("no_telp_user");

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        // Alert the copied text
        alert("Copied the text: " + copyText.value);
    }
</script>
<?php include 'footer_user.php'; ?>