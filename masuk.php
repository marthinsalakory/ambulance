<?php include 'function.php' ?>
<?php
noLogin();
if (!empty($_POST)) {
    $email = htmlspecialchars(strtolower($_POST['email']));
    // $asal_rumah_sakit = htmlspecialchars(strtolower($_POST['asal_rumah_sakit']));
    $sandi = $_POST['sandi'];

    if ($row = db_find("users", [
        'email' => $email,
        // 'asal_rumah_sakit' => $asal_rumah_sakit,
        'role' => 'admin'
    ])) {
        if (password_verify($sandi, $row->sandi)) {
            $_SESSION['login'] = true;
            $_SESSION['user'] = $row;
            header("Location: index.php");
            exit;
        } else {
            setFlash('Gagal Masuk');
        }
    } else {
        setFlash('Gagal Masuk');
    }
}
?>
<?php include 'header_auth.php' ?>
<form method="post">
    <div class="row mt-3">
        <div class="col-12">
            <label for="email">E-mail</label>
        </div>
        <div class="col-12">
            <input value="<?= old_value('email'); ?>" required class="w-100" type="email" name="email" id="email">
        </div>
    </div>
    <!-- <div class="row mt-3">
        <div class="col-12">
            <label for="asal_rumah_sakit">Asal Rumah Sakit</label>
        </div>
        <div class="col-12">
            <input value="<?= old_value('asal_rumah_sakit'); ?>" required class="w-100" type="text" name="asal_rumah_sakit" id="asal_rumah_sakit">
        </div>
    </div> -->
    <div class="row mt-3">
        <div class="col-12">
            <label for="sandi">Sandi</label>
        </div>
        <div class="col-12">
            <input value="<?= old_value('sandi'); ?>" required class="w-100 password-hash" type="password" name="sandi" id="sandi">
        </div>
        <div class="col-12 mt-2">
            <input class="show-password" type="checkbox" id="show_pass">
            <label for="show_pass">Tampilkan</label>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 text-center">
            <button class="btn btn-light border border-dark border-1">Masuk</button>
        </div>
    </div>
</form>
<?php include 'footer.php' ?>