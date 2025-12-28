<?php
$meja_list = ['M1', 'M2'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Kartu Meja Coffee Shop</title>
<style>
.card {
    border: 2px solid #444;
    padding: 20px;
    width: 320px;
    margin: 20px;
    display: inline-block;
    text-align: center;
    font-family: Arial;
    border-radius: 12px;
    background: #fff7e6;
}
h2 {
    margin: 0;
    font-size: 28px;
}
.qr, .barcode {
    margin-top: 10px;
}
</style>
</head>
<body>

<h1>Daftar Kartu Meja</h1>

<?php foreach ($meja_list as $meja): ?>
<div class="card">
    <h2>Meja <?php echo $meja; ?></h2>

    <div class="qr">
        <img src="qr_meja.php?meja=<?php echo $meja; ?>" width="200">
    </div>

    <div class="barcode">
        <img src="barcode_meja.php?meja=<?php echo $meja; ?>" height="70">
    </div>

    <p style="margin-top:10px;">Scan QR untuk order</p>
</div>
<?php endforeach; ?>

</body>
</html>
