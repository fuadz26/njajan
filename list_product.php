<?php
    session_start();
    if (isset($_SESSION['alert_message'])) {
        echo "<script>alert('" . $_SESSION['alert_message'] . "');</script>";
        unset($_SESSION['alert_message']);
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
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
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
    <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16 mx-auto"
        style="padding-left: 100px;padding-right: 100px">

        <!-- sidebar -->
        <div class="col-span-3">
            <div class="px-4 py-3 shadow flex items-center gap-4">
                <div class="flex-shrink-0">
                    <img src="<?php echo $row->user_img; ?>" alt="profile"
                        class="rounded-full w-14 h-14 border border-gray-200 p-1 object-cover">
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
                    <a href="profile.php"
                        class="relative   text-green-500 hover:text-green-500 block capitalize transition">
                        Profile information
                    </a>
                    <a href="address.php?id=<?php echo $user_id;?> "
                        class="relative  hover:text-green-500 block capitalize transition">
                        Manage addresses
                    </a>
                    <a href="#" class="relative hover:text-green-500 block capitalize transition">
                        Change password
                    </a>
                </div>

                <div class="space-y-1 pl-8 pt-4">
                    <a href="wishlist.php" class="relative  block font-medium capitalize transition">
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
                    <a href="tambah_produk.php" class="relative  hover:text-green-500 block capitalize transition">
                        add Product
                    </a>
                    <a href="list_product.php" class="relative block capitalize transition">
                        Product Listed
                    </a>
                    <a href="Order.php" class="relative block capitalize transition">
                        Order
                    </a>
                </div>

                <div class="space-y-1 pl-8 pt-4">
                    <a href="asset/php/logout.php"
                        class="relative hover:text-green-500 block font-medium capitalize transition">
                        <span class="absolute -left-8 top-0 text-base">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </span>
                        Logout
                    </a>
                </div>

            </div>
        </div>

        <!-- ./sidebar -->
        <?php }?>
        <!-- ./sidebar -->

        <div class="col-span-9">
            <!-- Tabel List Produk -->
            <table class="border-collapse w-full">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Foto</th>
                        <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
                        <th class="border border-gray-300 px-4 py-2">Harga</th>
                        <th class="border border-gray-300 px-4 py-2">Stock</th>

                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_id = $_SESSION['user_id'];

                    $sql = "SELECT t.toko_id FROM toko t, user u WHERE t.user_id = '$user_id'";
                    $result = pg_query($conn, $sql);
                    while ($row = pg_fetch_object($result)) {
                        $_SESSION['toko_id'] = $row->toko_id;
                        $toko_id = $_SESSION['toko_id'];
                    }

                    $sql = "SELECT p.*
                    FROM produk p
                    JOIN toko t ON p.toko_id = t.toko_id
                    WHERE t.toko_id = $toko_id";
                    $result = pg_query($conn, $sql);
                    while ($row = pg_fetch_object($result)) {
                        ?>
                    <tr class="text-center">
                        <td class="border border-gray-300 px-4 py-2"><img class="w-20 " src="<?php echo $row->produk_img; ?>" alt="">
                        </td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $row->nama_produk; ?></td>
                        <td class="border border-gray-300 px-4 py-2">Rp.<?php echo $row->harga_produk; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $row->stok_produk; ?></td>

                        <td class=" text-center border border-gray-300 px-4 py-2">
                            <a href="edit_produk.php?id=<?php echo $row->produk_id; ?>"
                                class="text-green-500 hover:text-green-700 mr-2" title="Edit">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <a href="hapus_produk.php?id=<?php echo $row->produk_id; ?>"
                                class="text-red-500 hover:text-red-700" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>