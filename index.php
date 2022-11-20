<?php include 'function.php' ?>
<?php include 'header.php' ?>
<div class="row">
    <div class="col-12">
        <div id="map" style="width: 100%; height: 100vh;"></div>
    </div>
</div>
<script>
    const map = L.map('map').setView([<?= user()->asal_rumah_sakit; ?>], 13);

    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const marker = L.marker([<?= user()->asal_rumah_sakit; ?>]).addTo(map)
        .bindPopup('<a class="text-decoration-none text-dark" href="akun.php"><?= user()->nama; ?></a>').openPopup();

    const circle = L.circle([<?= user()->asal_rumah_sakit; ?>], {
        color: '#2B82CB',
        fillColor: '#2B82CB',
        fillOpacity: 0.5,
        radius: 500
    }).addTo(map).bindPopup('<a class="text-decoration-none text-dark" href="akun.php"><?= user()->nama; ?></a>');
</script>
<?php include 'footer.php' ?>