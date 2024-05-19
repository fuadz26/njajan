<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="asset/css/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <title>Home</title>
    <style>
        .btn-brown {
            background-color: #8B4513;
            border-color: #8B4513;
            color: white;
        }

        .btn-brown:hover {
            background-color: transparent;
            color: #8B4513;
        }

        .product-image {
            height: 300px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <?php
    include 'asset/php/navbar.php';
    include 'asset/php/connection.php';
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    }
    ?>

    <!-- Banner -->
    <div class="bg-cover bg-no-repeat bg-center py-36">
        <div class="container mx-auto px-6 lg:px-16">
            <h1 class="text-6xl text-gray-800 font-medium mb-4 capitalize">
                NJAJAN REK!!!!!!!! <br> NJAJAN.COM
            </h1>
            <p class="text-lg">AYO NJAJAN NANG KENE LURR PENAK ASIK POLL</p>
            <div class="mt-12">
                <a href="shop.php" class="btn-brown text-white px-8 py-3 font-medium rounded-md hover:bg-transparent hover:text-brown transition">Shop Now</a>
            </div>
        </div>
    </div>
    <!-- ./Banner -->

    <div class="container py-16 mx-auto px-6 lg:px-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">Shop by Category</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $sql = "SELECT * FROM kategori";
            $result = pg_query($conn, $sql);
            while ($row = pg_fetch_object($result)) {
                echo '<div class="relative rounded-sm overflow-hidden group">';
                echo '<img src="' . htmlspecialchars($row->kategori_img) . '" alt="' . htmlspecialchars($row->nama_kategori) . '" class="w-full">';
                echo '<a href="search.php?id=' . htmlspecialchars($row->kategori_id) . '" class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">' . htmlspecialchars($row->nama_kategori) . '</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <!-- ./Categories -->

    <!-- New Arrivals -->
    <div class="container py-16 mx-auto px-6 lg:px-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">Jajanan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $sql = "SELECT * FROM produk ORDER BY produk_id";
            $result = pg_query($conn, $sql);
            while ($row = pg_fetch_object($result)) {
                echo '<div class="bg-white shadow rounded overflow-hidden group">';
                echo '<div class="relative">';
                echo '<img src="' . htmlspecialchars($row->produk_img) . '" alt="' . htmlspecialchars($row->nama_produk) . '" class="w-full product-image">';
                echo '<div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition">';
                echo '<a href="product.php?id=' . htmlspecialchars($row->produk_id) . '" class="text-white text-lg w-9 h-8 rounded-full btn-brown flex items-center justify-center hover:bg-gray-800 transition" title="view product"><i class="fa-solid fa-magnifying-glass"></i></a>';
                echo '</div>';
                echo '</div>';
                echo '<div class="pt-4 pb-3 px-4">';
                echo '<a href="product.php?id=' . htmlspecialchars($row->produk_id) . '"><h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-brown transition">' . htmlspecialchars($row->nama_produk) . '</h4></a>';
                echo '<div class="flex items-baseline mb-1 space-x-2"><p class="text-xl text-brown font-semibold">Rp. ' . htmlspecialchars($row->harga_produk) . '</p></div>';
                echo '</div>';
                echo '<a href="asset/php/insert_cart.php?id=' . htmlspecialchars($row->produk_id) . '" class="block w-full py-1 text-center text-white btn-brown border rounded-b hover:bg-transparent hover:text-brown transition">Add to cart</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <!-- ./New Arrivals -->

</body>

</html>