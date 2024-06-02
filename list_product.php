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
    <title>List Product</title>

    <style>
        .text-brown-500 {
            color: #8B4513;
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


        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #8B4513;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #8B4513;
            color: #FFF;
        }

        .table tbody tr:nth-child(even) {
            background-color: #F5F5DC;
        }
    </style>

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
                            <i class="fa-regular fa-address-card"></i> Manage account
                        </a>
                        <a href="profile.php" class="sidebar-link ">
                            Profile information
                        </a>
                        <a href="address.php?id=<?php echo $row->user_id; ?>" class="sidebar-link ">
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
                        <a href="tambah_produk.php" class="sidebar-link text-brown-500">
                            Add Product
                        </a>
                        <a href="list_product.php" class="sidebar-link ">
                            Product Listed
                        </a>
                        <a href="order.php" class="sidebar-link ">
                            Order
                        </a>
                        <a href="asset/php/logout.php" class="sidebar-link ">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </a>
                    </div>
                </div>
            </div>

        <?php } ?>

        <div class="col-span-9">
            <table class="table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stock</th>
                        <th>Aksi</th>
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
                        <tr>
                            <td><img class="w-20 " src="<?php echo $row->produk_img; ?>" alt=""></td>
                            <td><?php echo $row->nama_produk; ?></td>
                            <td>Rp.<?php echo $row->harga_produk; ?></td>
                            <td><?php echo $row->stok_produk; ?></td>
                            <td>
                                <a href="edit_produk.php?id=<?php echo $row->produk_id; ?>" class="text-brown -500 hover:text-brown-700 mr-2" title="Edit">
                                    <i class="fa-solid fa-pencil"></i>
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