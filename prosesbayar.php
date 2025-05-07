<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pendaftaran = $_POST['id_pendaftaran'];
    $part_tambahan = $_POST['part_motor'];
    $total_pembayaran = $_POST['total_pembayaran'];
    $tanggal_pembayaran = date('Y-m-d');

    $query = "INSERT INTO pembayaran (id_pendaftaran, part_tambahan, total_pembayaran, tanggal_pembayaran) 
              VALUES ('$id_pendaftaran', '$part_tambahan', '$total_pembayaran', '$tanggal_pembayaran')";
    mysqli_query($conn, $query);

    header("Location: index.php");
} else {
    $id_pendaftaran = $_GET['id'];
    $query = "SELECT * FROM pendaftaran WHERE id_pendaftaran = '$id_pendaftaran'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $nama = $row['nama'];
    $nopol = $row['nopol'];
    $paket_service = $row['paket_service'];
    $harga_service = $row['harga_service'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pembayaran</title>
        <link rel="stylesheet" href="core.css">
    </head>

    <body>
        <h1>Input Pembayaran</h1>
        <form method="post" action="prosesbayar.php">
            <input type="hidden" name="id_pendaftaran" value="<?php echo $id_pendaftaran; ?>">

            <p><strong>Nama:</strong> <?php echo $nama; ?></p>
            <p><strong>Nopol:</strong> <?php echo $nopol; ?></p>
            <p><strong>Paket Service:</strong> <?php echo $paket_service; ?></p>

            <label for="part_motor">Part Motor:</label>
            <select id="part_motor" name="part_motor" onchange="updateTotalPembayaran()">
                <option value="0">Pilih Part Motor</option>
                <option value="50000">Kampas Rem - 50rb</option>
                <option value="30000">Lampu Depan - 30rb</option>
                <option value="150000">Ban - 150rb</option>
            </select>

            <p><strong>Harga Service:</strong> <?php echo number_format($harga_service, 0, ',', '.'); ?> IDR</p>
            <input type="hidden" id="harga_service" name="harga_service" value="<?php echo $harga_service; ?>">
            <br>

            <label for="total_pembayaran">Total Pembayaran:</label>
            <input type="number" id="total_pembayaran" name="total_pembayaran" step="0.01" readonly><br><br>

            <input type="submit" value="Bayar">
        </form>
    </body>
    <script>
        function updateTotalPembayaran() {
            var partMotor = parseFloat(document.getElementById('part_motor').value) || 0;
            var hargaService = parseFloat(document.getElementById('harga_service').value) || 0;
            var totalPembayaran = partMotor + hargaService;
            document.getElementById('total_pembayaran').value = totalPembayaran.toFixed(2);
        }

        // Tambahkan event listener setelah halaman selesai dimuat
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('part_motor').addEventListener('change', updateTotalPembayaran);
            updateTotalPembayaran(); // Hitung ulang saat halaman pertama kali dimuat
        });
    </script>


    </html>
<?php
}
mysqli_close($conn);
