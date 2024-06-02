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
    <title>Profile</title>
    <style>
        .text-brown-500 {
            color: #8B4513;
        }

        .text-brown-600 {
            color: #A0522D;
        }

        .bg-brown-500 {
            background-color: #8B4513;
        }

        .border-brown-500 {
            border-color: #8B4513;
        }

        .hover\:text-brown-500:hover {
            color: #8B4513;
        }

        .hover\:bg-brown-500:hover {
            background-color: #8B4513;
            color: #FFF;
        }

        .hover\:bg-transparent:hover {
            background-color: transparent;
            color: #8B4513;
        }

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
    session_start();
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
        $user_id = $row->user_id;
        $_SESSION['user_id'] = $user_id;
    ?>

        <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16 mx-auto" style="padding-left: 100px;padding-right: 100px">


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

            <div class="col-span-9 space-y-4">
                <div class="flex justify-end">
                    <a href="tambah_alamat.php" class="px-6 py-2 text-center text-sm text-white bg-brown-500 border border-brown-500 rounded hover:bg-transparent hover:text-brown-500 transition uppercase font-roboto font-medium">Tambah</a>
                </div>
                <?php
                $sql = "SELECT * FROM alamatpengiriman WHERE user_id = '$user_id'";
                $result = pg_query($conn, $sql);
                $i = 1;
                while ($row = pg_fetch_object($result)) {
                ?>
                    <div class="grid grid-cols-1 gap-4 mt-4">
                        <div class="shadow rounded bg-white px-4 pt-6 pb-8">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-medium text-gray-800 text-lg">Alamat <?php echo $i; ?></h3>
                                <a href="edit_alamat.php" class="text-brown-500">Edit</a>
                            </div>
                            <div class="space-y-1 pl-10">
                                <h4 class="text-gray-700 font-medium">Penerima: <?php echo $row->nama_penerima; ?></h4>
                                <p class="text-gray-800">Alamat: <?php echo $row->alamat; ?></p>
                                <p class="text-gray-800">Kota: <?php echo $row->kota; ?></p>
                                <p class="text-gray-800">Kode Pos: <?php echo $row->kode_pos; ?></p>
                                <p class="text-gray-800">No. HP: <?php echo $row->nomor_telepon; ?></p>
                            </div>
                        </div>
                    </div>
                <?php $i++;
                } ?>
            </div>
        </div>
    <?php } ?>
</body>

</html>