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
    <title>Document</title>
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
    <div class="col-span-3 mx-auto" style="padding-left: 100px;padding-right: 100px; padding-top: 30px">
        <?php

        if (isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql = "SELECT * FROM produk WHERE  nama_produk ILIKE '%$search%'";
            $result = pg_query($conn, $sql);
        ?>

            <div class="flex items-center mb-4 pt-5 ">
                <p class="  w-full  text-black  py-3 px-6 border-gray-300 shadow rounded focus:ring-brown-500 focus:border-brown-500">
                    Search : "<?php echo $search; ?>""
                </p>

            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <?php } else if (isset($_GET['id'])) {
            $kategori = $_GET['id'];
            $sql = "SELECT p.*, k.nama_kategori 
        FROM produk p 
        INNER JOIN kategori k ON p.kategori_id = k.kategori_id 
        WHERE p.kategori_id = $kategori";
            $result = pg_query($conn, $sql);


            ?>

                <div class="flex items-center mb-4 pt-5 ">
                    <p class="  w-full  text-black  py-3 px-6 border-gray-300 shadow rounded focus:ring-brown-500 focus:border-brown-500">
                        Search by Category
                    </p>

                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <?php
            }

            while ($row = pg_fetch_object($result)) {

                ?>

                    <div class="bg-white shadow rounded overflow-hidden group ">
                        <div class="relative">
                            <img src="<?php echo $row->produk_img ?>" alt="product 1" class="w-full product-image">
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center 
                    justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                                <a href="product.php?id=<?php echo $row->produk_id ?>" class="text-white text-lg w-9 h-8 rounded-full bg-brown-500 flex items-center justify-center hover:bg-gray-800 transition" title="view product">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </a>


                            </div>
                        </div>
                        <div class="pt-4 pb-3 px-4">
                            <a href="product.php?id=<?php echo $row->produk_id ?>">
                                <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-brown-500 transition">
                                    <?php echo $row->nama_produk ?></h4>
                            </a>
                            <div class="flex items-baseline mb-1 space-x-2">
                                <p class="text-xl text-brown-500 font-semibold">Rp. <?php echo $row->harga_produk ?></p>

                            </div>

                        </div>
                        <a href="asset/php/insert_cart.php?id=<?php echo $row->produk_id ?>&harga=<?php echo $row->harga_produk ?>" id="addcart" class="btn-brown btn-brown:hover block w-full py-1 text-center text-white bg-brown-500 border border-brown-500 rounded-b hover:bg-transparent hover:text-brown-500 transition">Add
                            to cart</a>
                    </div>

                <?php } ?>
                </div>
            </div>


            <!-- ./products -->
</body>

</html>