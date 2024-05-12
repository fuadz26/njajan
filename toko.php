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
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="asset/css/output.css">
    <title>Toko</title>
</head>

<body>
    <?php
    include 'asset/php/navbar.php';
    include 'asset/php/connection.php';
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        
    } else
        echo 'Fail contol';
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * from toko where user_id = $user_id";
    $result = pg_query($conn, $sql);
    if (pg_num_rows($result) < 1){
        
        ?>
    <div class="mt-4 flex flex-col items-center h-screen">
        <p class="mb-4">Anda belum memiliki Toko, Silahkan buka Toko dengan klik dibawah</p>
        <a href="regis_toko.php"
            class="block w-64 py-2 text-center text-white bg-green-500 border border-green-500 rounded hover:bg-transparent hover:text-green-500 transition uppercase font-roboto font-medium">BUKA
            TOKO</a>
        </div>



        <?php
    }else{
        $sql = "SELECT * from users where username = '$user'";
        $result = pg_query($conn, $sql);
        while ($row = pg_fetch_object($result)){
    
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

            <!-- ./sidebar -->
            <?php }?>

            <div class="grid grid-cols-9 md:grid-cols-4 gap-16 w-full col-span-9 ">
                <?php 

        $sql = "SELECT * from toko t,user u where t.user_id = '$user_id'";
        $result = pg_query($conn,$sql);
        if ($result && pg_num_rows($result) > 0) {
        
        while($row = pg_fetch_object($result)){
            $_SESSION['toko_id']= $row->toko_id;
            $toko_id = $_SESSION['toko_id'];
    

            }
        $sql = "SELECT p.*
        FROM produk p
        JOIN toko t ON p.toko_id = t.toko_id
        WHERE t.toko_id = $toko_id;
        ";
        $result = pg_query($conn,$sql);
        while($row = pg_fetch_object($result)){
            ?>
                <div class="bg-white shadow rounded group w-52 h-80">
                    <div class="relative">
                        <img src="<?php echo $row->produk_img ?>" alt="product 1" class="w-full">
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center 
                    justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            <a href="product.php?id=<?php echo $row->produk_id;?>"
                                class="text-white text-lg w-9 h-8 rounded-full bg-green-500 flex items-center justify-center hover:bg-gray-800 transition"
                                title="view product">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>


                        </div>
                    </div>
                    <div class="pt-4 pb-3 px-4">
                        <a href="#">
                            <h4
                                class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-green-500 transition">
                                <?php echo $row->nama_produk ?></h4>
                        </a>
                        <div class="flex items-baseline mb-1 space-x-2">
                            <p class="text-xl text-green-500 font-semibold">Rp. <?php echo $row->harga_produk?></p>

                        </div>
                    </div>
                </div>
                <?php }
            } else { 
            
            ?>


                <?php }
            
            }?>

            </div>
        </div>

</body>

</html>