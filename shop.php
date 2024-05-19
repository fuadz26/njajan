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
    <title>Njajan</title>
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

        .text-brown {
            color: #8B4513;
        }

        .hover-text-brown:hover {
            color: #8B4513;
        }

        .border-brown {
            border-color: #8B4513;
        }

        .bg-brown {
            background-color: #8B4513;
        }

        .hover-bg-brown:hover {
            background-color: #8B4513;
        }

        .bg-beige {
            background-color: #F5F5DC;
        }

        .text-beige {
            color: #F5F5DC;
        }

        .hover-text-beige:hover {
            color: #F5F5DC;
        }

        .border-beige {
            border-color: #F5F5DC;
        }

        .product-img {
            height: 15rem;
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
    <div class="col-span-3 mx-auto" style="padding-left: 100px; padding-right: 100px; padding-top: 30px">
        <?php
        $sql = "SELECT * FROM produk";
        $result = pg_query($conn, $sql);
        ?>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <?php
            while ($row = pg_fetch_object($result)) {
            ?>
                <div class="bg-white shadow rounded overflow-hidden group">
                    <div class="relative">
                        <img src="<?php echo $row->produk_img ?>" alt="product 1" class="w-full product-img">
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center 
                    justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            <a href="product.php?id=<?php echo $row->produk_id ?>" class="text-white text-lg w-9 h-8 rounded-full bg-brown flex items-center justify-center hover:bg-gray-800 transition" title="view product">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                        </div>
                    </div>
                    <div class="pt-4 pb-3 px-4">
                        <a href="product.php?id=<?php echo $row->produk_id ?>">
                            <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover-text-brown transition">
                                <?php echo $row->nama_produk ?></h4>
                        </a>
                        <div class="flex items-baseline mb-1 space-x-2">
                            <p class="text-xl text-brown font-semibold">Rp. <?php echo $row->harga_produk ?></p>
                        </div>
                    </div>
                    <a href="asset/php/insert_cart.php?id=<?php echo $row->produk_id ?>&harga=<?php echo $row->harga_produk ?>" id="addcart" class="block w-full py-1 text-center text-white bg-brown border border-brown rounded-b hover:bg-transparent hover-text-brown transition">Add
                        to cart</a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>