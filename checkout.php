<?php
session_start();

include 'asset/php/connection.php';

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $user_id = $_SESSION['user_id'];
}

// Query untuk mendapatkan daftar alamat dari tabel
$query = "SELECT * FROM alamatpengiriman WHERE user_id = $user_id";
$result = pg_query($conn, $query);

if (!$result) {
    die("Query error: " . pg_last_error($conn));
}

$alamatpengiriman = pg_fetch_all($result);

// Proses Checkout
if (isset($_POST['checkout'])) {
    $selectedAddressId = $_POST['address-select'];

    // Mendapatkan data alamat yang dipilih
    $selectedAddress = pg_fetch_array(pg_query($conn, "SELECT * FROM alamatpengiriman WHERE alamat_id = $selectedAddressId"));

    // Mengambil daftar produk dari keranjang
    $keranjangQuery = "SELECT k.*, p.*
                        FROM keranjang k
                        JOIN produk p ON k.produk_id = p.produk_id
                        WHERE k.user_id = $user_id";
    $keranjangResult = pg_query($conn, $keranjangQuery);

    // Memasukkan data ke tabel transaksi
    while ($row = pg_fetch_array($keranjangResult)) {
        $keranjangId = $row['keranjang_id'];
        $produkId = $row['produk_id'];
        $quantity = $row['quantity'];
        $totalHarga = $row['total_harga'];

        // Query untuk insert data ke tabel transaksi
        $insertQuery = "INSERT INTO transaksi (produk_id, user_id, alamat_pengiriman, total_harga)
        VALUES ($produkId, $user_id, '{$selectedAddress['alamat']}', $totalHarga)";
        $insertResult = pg_query($conn, $insertQuery);

        if (!$insertResult) {
            die("Query error: " . pg_last_error($conn));
        }

        // Mendapatkan transaksi_id dari data yang baru dimasukkan
        $transaksiId = pg_fetch_result(pg_query($conn, "SELECT currval(pg_get_serial_sequence('transaksi', 'transaksi_id'))"), 0);

        // Memasukkan data ke tabel transaksi_produk
        $insertTransaksiProdukQuery = "INSERT INTO transaksi_produk (transaksi_id, produk_id, jumlah)
        VALUES ($transaksiId, $produkId, $quantity)";
        $insertTransaksiProdukResult = pg_query($conn, $insertTransaksiProdukQuery);

        if (!$insertTransaksiProdukResult) {
            die("Query error: " . pg_last_error($conn));
        }

        // Menghapus data keranjang setelah checkout
        $deleteKeranjangQuery = "DELETE FROM keranjang WHERE keranjang_id = $keranjangId";
        $deleteKeranjangResult = pg_query($conn, $deleteKeranjangQuery);

        if (!$deleteKeranjangResult) {
            die("Query error: " . pg_last_error($conn));
        }
    }

    // Redirect ke halaman sukses atau halaman lain yang diinginkan
    header("Location: checkout_sukses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="asset/css/output.css">
    <title>Home</title>
</head>

<body>
    <?php include 'asset/php/navbar.php'; ?>

    <!-- wrapper -->
    <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16 mx-auto" style="padding-left: 100px; padding-right: 100px;">
        <div class="col-span-8 border border-gray-200 p-4 rounded">
            <h3 class="text-lg font-medium capitalize mb-4">Checkout</h3>
            <div class="space-y-4">
                <form method="POST" action="">
                    <label for="address-select" class="text-gray-600">Pilih Alamat</label>
                    <select name="address-select" id="address-select" class="input-box">
                        <?php if (!empty($alamatpengiriman)) : ?>
                            <?php foreach ($alamatpengiriman as $address) : ?>
                                <option value="<?= $address['alamat_id'] ?>"><?= $address['nama_penerima'] ?> - <?= $address['alamat'] ?></option>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <option value="" disabled>No addresses found.</option>
                        <?php endif; ?>
                    </select>
                    <a href="tambah_alamat.php" class="p-10 px-3 py-2 text-center text-white bg-green-500 border border-green-500 rounded-b hover:bg-transparent hover:text-green-500 transition">Tambah Alamat</a>

                    <div id="address-details" class="mt-4" style="display: none;">
                        <h4 class="text-lg font-medium">Address Details:</h4>
                        <div id="address-info" class="mt-2"></div>
                    </div>

                    <button type="submit" name="checkout" class="block w-full py-3 px-4 text-center text-white bg-green-500 border border-green-500 rounded-md hover:bg-transparent hover:text-green-500 transition font-medium">Place order</button>
                </form>
            </div>
        </div>
        <div class="col-span-4 border border-gray-200 p-4 rounded">
            <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">order summary</h4>
            <div class="space-y-2">
                <?php
                $sql = "SELECT k.*, p.*
                        FROM keranjang k
                        JOIN produk p ON k.produk_id = p.produk_id
                        WHERE k.user_id = $user_id";

                $result = pg_query($conn, $sql);
                $temp_total = 0;
                while ($row = pg_fetch_object($result)) {
                    $temp_total += $row->total_harga;
                ?>
                    <div class="flex justify-between">
                        <div>
                            <h5 class="text-green-500 font-medium"><?php echo $row->nama_produk; ?></h5>
                        </div>
                        <div>
                            <h5 class="text-gray-600">Qty: <?php echo $row->quantity; ?></h5>
                            <h5 class="text-gray-600">Rp. <?php echo number_format($row->total_harga, 0, ".", "."); ?></h5>
                        </div>
                    </div>
                <?php } ?>
                <div class="flex justify-between border-t border-gray-200 py-2">
                    <h5 class="font-medium">Total</h5>
                    <h5 class="text-gray-600">Rp. <?php echo number_format($temp_total, 0, ".", "."); ?></h5>
                </div>
            </div>
        </div>
    </div>
    <!-- /wrapper -->

    <script src="asset/js/main.js"></script>
    <script>
        // Update address details on select change
        const addressSelect = document.getElementById('address-select');
        const addressDetails = document.getElementById('address-details');
        const addressInfo = document.getElementById('address-info');

        addressSelect.addEventListener('change', function() {
            const selectedIndex = addressSelect.selectedIndex;
            const selectedOption = addressSelect.options[selectedIndex];
            const addressText = selectedOption.text;

            addressDetails.style.display = 'block';
            addressInfo.innerText = addressText;
        });
    </script>
</body>

</html>
