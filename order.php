<?php
session_start();
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
    <title>Login</title>
</head>

<body>
    <?php
    include 'asset/php/navbar.php';
    include 'asset/php/connection.php';

    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else {
        echo 'Fail control';
    }

    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = pg_query($conn, $sql);
    while ($row = pg_fetch_object($result)) {
        $_SESSION['user_id'] = $row->user_id;
    ?>

        <!-- wrapper -->
        <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16 mx-auto" style="padding-left: 100px;padding-right: 100px">

            <!-- sidebar -->
            <div class="col-span-3">
                <div class="px-4 py-3 shadow flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <img src="<?php echo $row->user_img; ?>" alt="profile" class="rounded-full w-14 h-14 border border-gray-200 p-1 object-cover">
                    </div>
                    <div class="flex-grow">
                        <p class="text-gray-600">Hello,</p>
                        <h4 class="text-gray-800 font-medium"><?php echo $row->username; ?></h4>
                    </div>
                </div>

                <div class="mt-6 bg-white shadow rounded p-4 divide-y divide-gray-200 space-y-4 text-gray-600">
                    <div class="space-y-1 pl-8">
                        <a href="profile.php" class="block font-medium capitalize transition">
                            <span class="absolute -left-8 top-0 text-base">
                                <i class="fa-regular fa-address-card"></i>
                            </span>
                            Manage account
                        </a>
                        <a href="profile.php" class="relative text-green-500 hover:text-green-500 block capitalize transition">
                            Profile information
                        </a>
                        <a href="address.php?id=<?php echo $user_id; ?>" class="relative hover:text-green-500 block capitalize transition">
                            Manage addresses
                        </a>
                        <a href="#" class="relative hover:text-green-500 block capitalize transition">
                            Change password
                        </a>
                    </div>

                    <div class="space-y-1 pl-8 pt-4">
                        <a href="wishlist.php" class="relative block font-medium capitalize transition">
                            <span class="absolute -left-8 top-0 text-base">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </span>
                            My Cart
                        </a>
                    </div>
                    <div class="space-y-1 pl-8 pt-4">
                        <a href="toko.php" class="relative block font-medium capitalize transition">
                            <span class="absolute -left-8 top-0 text-base">
                                <i class="fa-solid fa-shop"></i>
                            </span>
                            TOKO kuu
                        </a>
                        </a>
                        <a href="tambah_produk.php" class="relative hover:text-green-500 block capitalize transition">
                            add Product
                        </a>
                        <a href="list_product.php" class="relative block capitalize transition">
                            Product Listed
                        </a>
                    </div>

                    <div class="space-y-1 pl-8 pt-4">
                        <a href="asset/php/logout.php" class="relative hover:text-green-500 block font-medium capitalize transition">
                            <span class="absolute -left-8 top-0 text-base">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </span>
                            Logout
                        </a>
                    </div>

                </div>
            </div>
            <!-- ./sidebar -->
    <?php } ?>

            <div class="col-span-9">
                <!-- Tabel List Transaksi -->
                <table class="border-collapse w-full">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Nomor Transaksi</th>
                            <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
                            <th class="border border-gray-300 px-4 py-2">Jumlah Pesanan</th>
                            <th class="border border-gray-300 px-4 py-2">Waktu Pesan</th>
                            <th class="border border-gray-300 px-4 py-2">Alamat Pengiriman</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $user_id = $_SESSION['user_id'];
                        $toko_id = $_SESSION['toko_id'];

                        $sql = "SELECT
                        t.alamat_pengiriman,t.waktu_transaksi,t.transaksi_id,
                        COUNT(tp.produk_id) AS jumlah_produk,
                        p.nama_produk
                    FROM
                        transaksi t
                    JOIN
                        transaksi_produk tp ON t.transaksi_id = tp.transaksi_id
                    JOIN
                        produk p ON tp.produk_id = p.produk_id
                    WHERE
                        p.toko_id = $toko_id
                    GROUP BY
                        t.alamat_pengiriman, p.nama_produk,t.waktu_transaksi, t.transaksi_id";
                    
                        $result = pg_query($conn, $sql);
                        
                        while ($row = pg_fetch_object($result)) {
                            ?>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row->transaksi_id; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row->nama_produk; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row->jumlah_produk; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row->waktu_transaksi; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row->alamat_pengiriman; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

</body>

</html>
