<?php include 'function.php' ?>
<?php isLogin('masuksupir.php'); ?>
<?php mustRole('supir', 'masuksupir.php'); ?>
<?php
$user_id = user()->id;
if (db_query("SELECT * FROM pesanmasuk WHERE supir_id = '$user_id' && tugas_supir != 'selesai'")->fetch_object()) {
    header("Location: jemput.php");
    exit;
}
if (!empty($_POST)) {
    if (empty($_POST['lokasi_supir'])) {
        setFlash('Lokasi Tidak di Suport');
    } else {
        if (db_update('pesanmasuk', ['id' => $_POST['id_pesan']], [
            'supir_id' => user()->id,
            'lokasi_supir' => $_POST['lokasi_supir'],
            'tugas_pasien' => 'Menunggu Ambulance',
            'tugas_supir' => 'Dikonfirmasi'
        ])) {
            header('Location: jemput.php?id_pesan=' . $_POST['id_pesan']);
        } else {
            setFlash('Gagal Konfirmasi');
        }
    }
}
?>
<?php include 'header_user.php' ?>
<div class="container-fluid">
    <div class="row fw-bold" style="background-color: #DDDDDD;">
        <!-- <div class="col-4 h-100 my-auto ps-5">
            <a href="darurat.php" class="text-dark text-decoration-none"><i class="fa-solid fa-chevron-left"></i></a>
        </div> -->
        <div class="col-12 d-flex justify-content-center">
            <div class="text-center" style="width: 100px;">
                <img src="assets/img/ambulance-car.png" width="60">
                <span>Ambulance</span>
            </div>
        </div>
    </div>
</div>
<?= flash(); ?>
<?php foreach (db_findAll('pesanmasuk', ['rs_id' => user()->user_id, 'supir_id' => null]) as $pesan) : ?>
    <div class="card text-center position-relative w-100" style="background-color: #EEEEEE;">
        <i class="fa-solid fa-bullhorn position-absolute ms-3 text-danger start-0 top-50 translate-middle-y"></i>
        <form method="POST" class="card-body">
            <h4>Pesan Gawat Darurat</h4>
            <input value="<?= $pesan['id']; ?>" type="hidden" name="id_pesan" id="id_pesan">
            <input type="hidden" name="lokasi_supir" id="lokasi_supir">
            <button type="submit" class="btn btn-light border border-1 border-dark">Konfirmasi</button>
        </form>
    </div>
<?php endforeach; ?>
<div class="mx-auto position-relative" style="width: 100%;height: 91vh;">

</div>
<script>
    getLocation();

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Lokasi Tidak Suport Pada Perangkat Anda";
        }
    }

    function showPosition(position) {
        $('#lokasi_supir').val(position.coords.latitude + ', ' + position.coords.longitude);
    }
</script>
<?php include 'footer_auth.php' ?>