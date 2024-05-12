<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="asset/css/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <title>Home</title>
</head>

<body>

    <?php

        include 'asset/php/navbar.php';
        include 'asset/php/connection.php';
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        } 
    ?>
    <!-- banner -->
    <div class="bg-cover bg-no-repeat bg-center py-36" style="background-image: url('asset\file\imgtumbas.png');">
        <div class="container mx-auto " style="padding-left: 100px;padding-right: 100px;">
            <h1 class="text-6xl text-gray-800 font-medium mb-4 capitalize">
                TUMBASS REK!!!!!!!! <br> TUMBAS.COM
            </h1>
            <p>AYO TUMBAS NANG KENE LURR PENAK ASIK POLL</p>
            <div class="mt-12">
                <a href="shop.php" class="bg-green-500 border border-green-500 text-white px-8 py-3 font-medium 
                    rounded-md hover:bg-transparent hover:text-green-500">Shop Now</a>
            </div>
        </div>
    </div>
    <!-- ./banner -->'
    <div class="container py-16 mx-auto" style="padding-left: 100px; padding-right: 100px">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">shop by category</h2>
        <div class="grid grid-cols-3 gap-3">
            <?php
        $sql = "SELECT * FROM kategori ";
        $result = pg_query($conn, $sql);
        while ($row = pg_fetch_object($result)){


    ?>
            <!-- categories -->


            <div class="relative rounded-sm overflow-hidden group ">
                <img src="<?php echo $row->kategori_img ;?>" alt="<?php echo $row->nama_kategori ;?>" class=" w-full">
                <a href="search.php?id=<?php echo $row->kategori_id ;?>;"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition"><?php echo $row->nama_kategori ?></a>
            </div>

            <?php } ?>
        </div>
    </div>
    <!-- ./categories -->

    <!-- new arrival -->
    <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6 mx-auto"
        style="padding-left: 100px;padding-right: 100px">Anyar Rekk</h2> <br>
    <div class="container flex pb-16 mx-auto" style="padding-left: 100px;padding-right: 100px">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <?php
        $sql = "SELECT * FROM produk ORDER BY produk_id DESC LIMIT 8";
        $result = pg_query($conn, $sql);
        while ($row = pg_fetch_object($result)){

    ?>


            <div class="bg-white shadow rounded overflow-hidden group">
                <div class="relative">
                    <img src="<?php echo $row->produk_img ?>" alt="product 1" class="w-full">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center 
                    justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                        <a href="product.php?id=<?php echo $row->produk_id ?>"
                            class="text-white text-lg w-9 h-8 rounded-full bg-green-500 flex items-center justify-center hover:bg-gray-800 transition"
                            title="view product">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </a>


                    </div>
                </div>
                <div class="pt-4 pb-3 px-4">
                    <a href="product.php?id=<?php echo $row->produk_id ?>">
                        <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-green-500 transition">
                            <?php echo $row->nama_produk ?></h4>
                    </a>
                    <div class="flex items-baseline mb-1 space-x-2">
                        <p class="text-xl text-green-500 font-semibold">Rp. <?php echo $row->harga_produk?></p>

                    </div>

                </div>
                <a href="asset/php/insert_cart.php?id=<?php echo $row->produk_id ?>" id="addcart"
                    class="block w-full py-1 text-center text-white bg-green-500 border border-green-500 rounded-b hover:bg-transparent hover:text-green-500 transition">Add
                    to cart</a>
            </div>


            <?php } ?>
        </div>
    </div>
</body </html>