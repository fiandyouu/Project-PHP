<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<title>JASTIP KING FOUR</title>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">REGULER PAKET</span>
    </nav>
    <div class="container">
        <br>
        <h4><center>KING FOUR</center></h4>
        <?php
        include "service/konek_jastip.php";

        // Cek apakah ada kiriman form dari method post
        if (isset($_GET['no_pnrm'])) {
            $no_pnrm = htmlspecialchars($_GET["no_pnrm"]);

            // Function untuk menampilkan popup konfirmasi
            function confirmDelete() {
                return confirm("Apakah Anda yakin ingin menghapus data?");
            }

            $sql = "DELETE FROM reguler_data WHERE no_pnrm='$no_pnrm' ";
            $hasil = mysqli_query($kon, $sql);

            // Kondisi apakah berhasil atau tidak
            if ($hasil) {
                header("Location:index.php");
            } else {
                echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
            }
        }
        ?>
        <table class="my-3 table table-bordered">
            <thead>
                <tr class="table-primary">           
                    <th><center>No</center></th>
                    <th><center>Nama Penerima</center></th>
                    <th><center>No Resi</center></th>
                    <th><center>Berat Paket</center></th>
                    <th><center>Harga Paket</center></th>
                    <th><center>Total</center></th>
                    <th colspan='2'><center>Aksi</center></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM reguler_data ORDER BY no_pnrm ASC";
                $hasil = mysqli_query($kon, $sql);
                $no = 0;
                while ($data = mysqli_fetch_array($hasil)) {
                    $no++;
                ?>
                    <tr>
                        <td><?php echo $data["no_pnrm"]; ?></td>
                        <td><?php echo $data["nama"]; ?></td>
                        <td><?php echo $data["resi"]; ?></td>
                        <td><?php echo $data["berat_kg"]; ?></td>
                        <td><?php echo $data["harga_bayar"]; ?></td>
                        <td><?php echo $data["Total"]; ?></td>
                        <td>
                            <a href="update.php?no_pnrm=<?php echo htmlspecialchars($data['no_pnrm']); ?>" class="btn btn-warning" role="button">Update</a>
                            <!-- Tambahkan fungsi JavaScript untuk menampilkan popup konfirmasi -->
                            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?no_pnrm=<?php echo $data['no_pnrm']; ?>" onclick="return confirmDelete();" class="btn btn-danger" role="button">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <a href="create.php" class="btn btn-primary" role="button">Tambah Data</a>
        <!-- <a href="index.php" class="btn btn-primary" role="button">Lihat Mata Kuliah</a> -->
    </div>
    <!-- Script untuk menampilkan popup konfirmasi -->
    <script>
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus data?");
        }
    </script>
</body>
</html>