<!DOCTYPE html>
<html>
<head>
    <title>Update Data Penerima</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
    // Include file koneksi ke database
    include "service/konek_jastip.php";

    // Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Inisialisasi variabel kosong untuk form
    $no_pnrm = $nama = $resi = $berat_kg = $harga_bayar = $Total = "";

    // Cek apakah ada nilai `no_pnrm` yang dikirim menggunakan GET
    if (isset($_GET['no_pnrm'])) {
        $no_pnrm = input($_GET["no_pnrm"]);

        // Query untuk mendapatkan data berdasarkan `no_pnrm`
        $sql = "SELECT * FROM reguler_data WHERE no_pnrm='$no_pnrm'";
        $hasil = mysqli_query($kon, $sql);
        $data = mysqli_fetch_assoc($hasil);

        // Isi variabel dengan data dari database
        if ($data) {
            $no_pnrm = $data['no_pnrm'];
            $nama = $data['nama'];
            $resi = $data['resi'];
            $berat_kg = $data['berat_kg'];
            $harga_bayar = $data['harga_bayar'];
            $Total = $data['Total'];
        }
    }

    // Cek apakah ada kiriman form dari method POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $no_pnrm = input($_POST["no_pnrm"]);
        $nama = input($_POST["nama"]);
        $resi = input($_POST["resi"]);
        $berat_kg = input($_POST["berat_kg"]);
        $harga_bayar = input($_POST["harga_bayar"]);
        $Total = input($_POST['Total']);

        // Query untuk mengupdate data pada tabel reguler_data
        $sql = "UPDATE reguler_data SET 
            nama='$nama', 
            resi='$resi', 
            berat_kg='$berat_kg', 
            harga_bayar='$harga_bayar', 
            Total='$Total' 
            WHERE no_pnrm='$no_pnrm'";

        // Mengeksekusi query
        $hasil = mysqli_query($kon, $sql);

        // Cek apakah query berhasil dijalankan
        if ($hasil) {
            header("Location: index.php");
        } else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
        }
    }
    ?>

    <h2>Update Data</h2>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <div class="form-group">
            <label>No Penerima:</label>
            <input type="number" name="no_pnrm" class="form-control" value="<?php echo $no_pnrm; ?>" readonly />
        </div>
        <div class="form-group">
            <label>Nama Penerima:</label>
            <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>" placeholder="Masukan Nama Penerima" required />
        </div>
        <div class="form-group">
            <label>Resi Barang:</label>
            <input type="text" name="resi" class="form-control" value="<?php echo $resi; ?>" placeholder="Masukan No Resi Barang" required />
        </div>
        <div class="form-group">
            <label>Berat Barang (kg):</label>
            <input type="text" name="berat_kg" class="form-control" value="<?php echo $berat_kg; ?>" placeholder="Masukan Berat Barang" required />
        </div>
        <div class="form-group">
            <label>Harga Barang (Rp):</label>
            <input type="text" name="harga_bayar" class="form-control" value="<?php echo $harga_bayar; ?>" placeholder="Masukan Harga Barang" required />
        </div>
        <div class="form-group">
            <label>Total Barang (Rp):</label>
            <input type="text" name="Total" class="form-control" value="<?php echo $Total; ?>" placeholder="Masukan Total Harga" required />
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
