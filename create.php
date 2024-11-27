<!DOCTYPE html>
<html>
<head>
    <title>Input Data Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script>
        // Format berat dengan "(kg)" dan tanda koma sebagai pemisah desimal
        function formatBerat(input) {
    // Ambil nilai input dan hapus " kg" jika sudah ada
    let value = input.value.replace(/\s*kg$/i, '').trim();
    
    // Izinkan hanya angka, koma, dan titik
    value = value.replace(/[^0-9,.]/g, '');

    // Pastikan hanya ada satu koma atau titik untuk desimal
    let parts = value.split(/,|\,/);
    if (parts.length > 2) {
        value = parts[0] + ',' + parts.slice(1).join('');
    } else {
        value = value.replace(',', ','); // Ubah koma ke titik untuk desimal
    }

    // Tambahkan "kg" di akhir
    input.value = value + " kg";
}


// Format harga dengan "Rp" di depan angka dan tanda titik sebagai pemisah ribuan
function formatHarga(input) {
    let value = input.value.replace(/[^0-9]/g, ''); // Hanya angka
    if (!isNaN(value) && value.trim() !== '') {
        input.value = "Rp " + parseInt(value, 10).toLocaleString('id-ID');
    } else {
        input.value = '';
    }
}

    </script>
</head>
<body>
<div class="container">
    <?php
    // Include file koneksi, untuk koneksikan ke database
    include "service/konek_jastip.php";

    // Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Cek apakah ada kiriman form dari method POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $no_pnrm = input($_POST["no_pnrm"]);
        $nama = input($_POST["nama"]);
        $resi = input($_POST["resi"]);
        $berat_kg = input($_POST["berat_kg"]);
        $harga_bayar = input($_POST["harga_bayar"]);
        $Total = input($_POST["Total"]);

        // Query to check if the NO already exists
        $check_no_query = "SELECT * FROM reguler_data WHERE no_pnrm = '$no_pnrm'";
        $check_no_result = mysqli_query($kon, $check_no_query);

        // Check if NO already exists
        if (mysqli_num_rows($check_no_result) > 0) {
            echo "<div class='alert alert-danger'>NO already exists. Data cannot be added.</div>";
        }
        else {
            // Insert data into the database
            $sql = "INSERT INTO reguler_data (no_pnrm, nama, resi, berat_kg, harga_bayar, Total) VALUES ('$no_pnrm','$nama','$resi','$berat_kg','$harga_bayar','$Total')";
            $hasil = mysqli_query($kon, $sql);

            // Check if insertion was successful
            if ($hasil) {
                header("Location: index.php");
            } else {
                echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
            }
        }
    }
    ?>
    <h2>Input Data</h2>

    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <div class="form-group">
            <label>No Penerima:</label>
            <input type="number" name="no_pnrm" class="form-control" placeholder="Masukan No Penerima" required />
        </div>
        <div class="form-group">
            <label>Nama Penerima:</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukan Nama Penerima" required/>
        </div>
        <div class="form-group">
            <label>Resi Barang:</label>
            <input type="text" name="resi" class="form-control" placeholder="Masukan No Resi Barang" required/>
        </div>
        <div class="form-group">
            <label>Berat Barang (kg):</label>
            <input type="text" name="berat_kg" class="form-control" placeholder="Masukan Berat Barang" oninput="formatBerat(this)" required/>
        </div>
        <div class="form-group">
            <label>Harga Barang (Rp):</label>
            <input type="text" name="harga_bayar" class="form-control" placeholder="Masukan Harga Barang" oninput="formatHarga(this)" required/>
        </div>
        <div class="form-group">
            <label>Total Barang (Rp):</label>
            <input type="text" name="Total" class="form-control" placeholder="Masukan Total Harga" oninput="formatHarga(this)" required/>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
