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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="asset/css/output.css">
    <title>Login</title>
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

        .product-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            border-radius: 10px;
            background-color: #FFF;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .product-card img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }

        .product-info {
            flex: 1;
            margin-left: 20px;
        }

        .product-info h2 {
            font-size: 18px;
            font-weight: 500;
            color: #111827;
            margin-bottom: 5px;
        }

        .product-info p {
            color: #6b7280;
            margin-bottom: 0;
        }

        .product-price {
            font-size: 18px;
            font-weight: 600;
            color: #8B4513;
        }

        .total-price {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin-top: 20px;
        }

        .checkout-button {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #8B4513;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            transition: background-color 0.3s, color 0.3s;
        }

        .checkout-button:hover {
            background-color: #ffffff;
            color: #8B4513;
            border: 1px solid #8B4513;
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
        $user_id = $row->user_id;
    ?>
        <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16 mx-auto" style="padding-left: 100px; padding-right: 100px">

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
        <div class="col-span-9 space-y-4">
            <?php
            $sql = "SELECT k.*, p.*
                    FROM keranjang k
                    JOIN produk p ON k.produk_id = p.produk_id
                    WHERE k.user_id = $user_id";

            $result = pg_query($conn, $sql);
            $temp_total = 0;
            while ($row = pg_fetch_object($result)) {
            ?>
                <div class="product-card">
                    <img src="<?php echo $row->produk_img; ?>" alt="Product Image">
                    <div class="product-info">
                        <h2><?php echo $row->nama_produk; ?></h2>
                        <p>Quantity: <?php echo $row->quantity; ?></p>
                    </div>
                    <div class="product-price text-brown-500"><?php echo $row->total_harga ?></div>
                    <div class="text-gray-600 cursor-pointer hover:text-brown-500">
                        <a href="hapus_cart.php?id=<?php echo $row->keranjang_id; ?>" class="text-gray-600 cursor-pointer hover:text-brown-500">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                </div>
                <?php
                $temp_total += $row->total_harga;
                ?>
            <?php } ?>

            <p class="flex justify-end mr-10 total-price text-brown-500">Total = <?php echo $temp_total; ?></p>

            <div class="flex items-end justify-end pr-10">
                <a href="checkout.php" class="checkout-button bg-brown-500 hover:bg-transparent hover:text-brown-500 border border-brown-500">Checkout</a>
            </div>
        </div>
        </div>
</body>

</html>