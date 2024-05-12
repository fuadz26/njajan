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
    } else
        echo 'Fail contol';
    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = pg_query($conn, $sql);
    while($row = pg_fetch_object($result)){
        $user_id = $row->user_id;
        $_SESSION['user_id']=$user_id;
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
                        class="relative   hover:text-green-500 block capitalize transition">
                        Profile information
                    </a>
                    <a href="address.php?id=<?php echo $user_id;?> " class="relative  text-green-500 hover:text-green-500 block capitalize transition">
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
                    <a href="tambah_produk.php"
                        class="relative  hover:text-green-500 block capitalize transition">
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
        <?php } 
        
        $sql = "SELECT * FROM alamatpengiriman WHERE user_id = '$user_id'";
        $result = pg_query($conn, $sql);
        $i =1;
        ?>
        <!-- ./sidebar -->
        <!-- info -->
        <div class="col-span-9">
            <div class="flex justify-end">
                <a href="tambah_alamat.php"
                    class="px-6 py-2 text-center text-sm text-white bg-green-500 border border-green-500 rounded hover:bg-transparent hover:text-green-500 transition uppercase font-roboto font-medium">Tambah</a>
            </div>
            <?php 
            while($row = pg_fetch_object($result)){
            ?>
            <div class="grid grid-cols-1 gap-4 mt-4">
                <div class="shadow rounded bg-white px-4 pt-6 pb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-medium text-gray-800 text-lg">Alamat <?php echo $i ;?></h3>
                        <a href="edit_alamat.php" class="text-green-500">Edit</a>
                    </div>
                    <div class="space-y-1 pl-10">
                        <h4 class="text-gray-700 font-medium">Penerima : <?php echo $row->nama_penerima; ?></h4>
                        <p class="text-gray-800">alamat :   <?php echo $row->alamat ;?></p>
                        <p class="text-gray-800">Kota :      <?php echo $row->kota ?></p>
                        <p class="text-gray-800">Kode Pos : <?php echo $row->kode_pos ;?></p>
                        <p class="text-gray-800">No. HP :   <?php echo $row->nomor_telepon;?></p>
                        <br>
                    </div>
                </div>
            </div>
            <?php $i++; } ?>
        </div>
        

        <!-- ./ info -->
    </div>


</body>

</html>