<?php session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
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
    } else
        echo 'Fail contol';
    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = pg_query($conn, $sql);
    while($row = pg_fetch_object($result)){
        $user_id = $row->user_id;
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
                    <a href="profile.php" class="relative   hover:text-green-500 block capitalize transition">
                        Profile information
                    </a>
                    <a href="address.php?id=<?php echo $user_id;?> "
                        class="relative  text-green-500 hover:text-green-500 block capitalize transition">
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
                    <a href="list_product.php" class="relative hover:text-green-500 block capitalize transition">
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
        <?php } ?>
        <!-- ./sidebar -->
        <div class="col-span-9 space-y-4">
            <?php 
        $sql = "SELECT k.*, p.*
        FROM keranjang k
        JOIN produk p ON k.produk_id = p.produk_id
        WHERE k.user_id = $user_id";

        $result = pg_query($conn, $sql);
        while($row = pg_fetch_object($result)){
        ?>
            <!-- wishlist -->

            <div class="flex items-center justify-between border gap-6 p-4 border-gray-200 rounded">
                <div class="w-28">
                    <img src="<?php echo $row->produk_img;?>" alt="product 6" class="w-50">
                </div>
                <div class="w-1/3">
                    <h2 class="text-gray-800 text-xl font-medium uppercase"><?php echo $row->nama_produk;?></h2>
                    <p class="text-gray-500 text-sm">Quantity: <?php echo $row->quantity;?> <span
                            class="text-green-600"></span></p>
                </div>
                <div class="text-green-500 text-lg font-semibold"><?php echo $row->total_harga?></div>
                <div class="text-gray-600 cursor-pointer hover:text-green-500">
                <a href="hapus.php?id=produk_id" class="text-gray-600 cursor-pointer hover:text-green-500">
                <i class="fa-solid fa-trash"></i>
            </a>

                </div>
            </div>
            <?php $_temp_total = 0;
            $temp_total += $row->total_harga ; ?>



            <!-- ./wishlist -->
            <?php } ?>

            <p class=" flex justify-end mr-10 text-lg font-semibold">Total = <?php echo $temp_total; ?></p>
            <div class="flex items-end justify-end pr-10">
                <a href="checkout.php"
                    class="px-6 py-2 mt-2 text-center text-sm text-white bg-green-500 border border-green-500 rounded hover:bg-transparent hover:text-green-500 transition uppercase font-roboto font-medium">Checkout</a>
            </div>


        </div>
        <!-- ./wrapper -->
</body>

</html>