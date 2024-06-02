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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="asset/css/output.css">
    <title>Toko</title>
    <style>
        .sidebar {
            background-color: #8B4513;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #FFF;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #FFF;
        }

        .sidebar-header img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 2px solid #FFF;
        }

        .sidebar-content {
            margin-top: 20px;
        }

        .sidebar-link {
            display: block;
            padding: 10px;
            border-radius: 5px;
            color: #FFF;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar-link:hover {
            background-color: #A0522D;
        }

        .sidebar-link i {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <?php
    include 'asset/php/navbar.php';
    include 'asset/php/connection.php';
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else
        echo 'tidak ada user id';
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * from toko where user_id = $user_id";
    $result = pg_query($conn, $sql);
    if (pg_num_rows($result) < 1) {

    ?>
        <div class="mt-4 flex flex-col items-center h-screen">
            <p class="mb-4">Anda belum memiliki Toko, Silahkan buka Toko dengan klik dibawah</p>
            <a href="regis_toko.php" class="block w-64 py-2 text-center text-white bg-8B4513 border border-8B4513 rounded hover:bg-transparent hover:text-8B4513 transition uppercase font-roboto font-medium">BUKA
                TOKO</a>
        </div>

        <?php
    } else {
        $sql = "SELECT * from users where username = '$user'";
        $result = pg_query($conn, $sql);
        while ($row = pg_fetch_object($result)) {

        ?>
            <!-- wrapper -->
            <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16 mx-auto" style="padding-left: 100px;padding-right: 100px">

                <!-- sidebar -->
                <div class="col-span-3">
                    <div class="sidebar">
                        <div class="sidebar-header">
                            <img src="<?php echo $row->user_img; ?>" alt="profile">
                            <div>
                                <p>Hello,</p>
                                <h4><?php echo $row->username; ?></h4>
                            </div>
                        </div>
                        <div class="sidebar-content">
                            <a href="profile.php" class="sidebar-link">
                                <i class="fa-regular fa-address-card"></i>
                                Manage account
                            </a>
                            <a href="profile.php" class="sidebar-link">
                                Profile information
                            </a>
                            <a href="address.php?id=<?php echo $user_id; ?>" class="sidebar-link">
                                Manage addresses
                            </a>

                            <a href="wishlist.php" class="sidebar-link">
                                <i class="fa-solid fa-bag-shopping"></i>
                                My Cart
                            </a>
                            <a href="toko.php" class="sidebar-link">
                                <i class="fa-solid fa-shop"></i>
                                My Store
                            </a>
                            <a href="tambah_produk.php" class="sidebar-link">
                                Add Product
                            </a>
                            <a href="list_product.php" class="sidebar-link">
                                Product Listed
                            </a>
                            <a href="order.php" class="sidebar-link">
                                Orders
                            </a>
                            <a href="asset/php/logout.php" class="sidebar-link">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="grid grid-cols-9 md:grid-cols-4 gap-16 w-full col-span-9 ">
                <?php

                $sql = "SELECT * from toko t,user u where t.user_id = '$user_id'";
                $result = pg_query($conn, $sql);
                if ($result && pg_num_rows($result) > 0) {

                    while ($row = pg_fetch_object($result)) {
                        $_SESSION['toko_id'] = $row->toko_id;
                        $toko_id = $_SESSION['toko_id'];
                    }
                    $sql = "SELECT p.*
        FROM produk p
        JOIN toko t ON p.toko_id = t.toko_id
        WHERE t.toko_id = $toko_id;
        ";
                    $result = pg_query($conn, $sql);
                    while ($row = pg_fetch_object($result)) {
                ?>
                        <div class="bg-white shadow rounded group w-52 h-80">
                            <div class="relative">
                                <img src="<?php echo $row->produk_img ?>" alt="product 1" class="w-full">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center 
                    justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                                    <a href="product.php?id=<?php echo $row->produk_id; ?>" class="text-white text-lg w-9 h-8 rounded-full bg-green-500 flex items-center justify-center hover:bg-gray-800 transition" title="view product">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>


                                </div>
                            </div>
                            <div class="pt-4 pb-3 px-4">
                                <a href="#">
                                    <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-8B4513 transition">
                                        <?php echo $row->nama_produk ?></h4>
                                </a>
                                <div class="flex items-baseline mb-1 space-x-2">
                                    <p class="text-xl text-8B4513 font-semibold">Rp. <?php echo $row->harga_produk ?></p>

                                </div>
                            </div>
                        </div>
                    <?php }
                } else {

                    ?>


            <?php }
            } ?>

            </div>

</body>

</html>