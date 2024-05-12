<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../css/output.css">
    <title>Document</title>
</head>

<body>

    <!-- header -->
    
    <header class="py-4 shadow-sm bg-white">
        <div class="container flex items-center justify-between mx-auto " style="padding-left: 100px;padding-right: 100px">
            <a href="../../index.php" class=" text-green-500 font-bold"> TUMBAS 
            </a>

            <form action="../../search.php" method="post" class="w-full max-w-xl relative flex">
                <span class="absolute left-4 top-3 text-lg text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                    <input type="text" name="search" id="search" class="w-full border border-green-500 hover:border-green-500  border-r-0 pl-12 py-3 pr-3 rounded-l-md focus:outline-none hidden md:flex" placeholder="search">
                    <button class=" bg-green-500 pt-3 border border-green-500 text-white px-8 rounded-r-md hover:bg-transparent hover:text-green-500 transition hidden md:flex">Search</button>
            </form>

            <div class="flex items-center space-x-4">

                <a href="../../wishlist.php" class="text-center text-gray-700 hover:text-green-500 transition relative">
                    <div class="text-2xl">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div class="text-xs leading-3">Cart</div>
                    
                </a>
                <a href="../../profile.php" class="text-center text-gray-700 hover:text-green-500 transition relative">
                    <div class="text-2xl">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="text-xs leading-3">Account</div>
                </a>
            </div>
        </div>
    </header>
    <!-- ./header -->

    <!-- navbar -->
    <nav class="bg-gray-800">
        <div class="container  flex mx-auto  " style="padding-left: 100px;padding-right: 100px">
            <div class="px-8 py-4  bg-green-500 md:flex items-center cursor-pointer relative group hidden">
                <span class="text-white">
                    <i class="fa-solid fa-bars"></i>
                </span>
                <span class="bg-gray capitalize ml-2 text-white ">All Categories</span>
                <?php 
                    $sql = "SELECT * FROM kategori";
                    include 'connection.php';
                    $result= pg_query($conn, $sql);
                    while($row= pg_fetch_object($result)){
                        ?>
                <!-- dropdown -->
                <div class="absolute w-full left-0 top-full bg-white shadow-md py-3 divide-y divide-gray-300 divide-dashed opacity-0 group-hover:opacity-100 transition duration-300 invisible group-hover:visible">
                    <a href="../../search.php?id=<?php echo $row->kategori_id;?>" class="flex items-center px-6 py-3 hover:bg-gray-100 transition">
                        <img src="<?php echo $row->kategori_img;?>" alt="sofa" class="w-5 h-5 object-contain">
                        <span class="ml-6 text-gray-600 text-sm"><?php echo $row->nama_kategori;?></span>
                    </a>
                    
                </div>
                <?php } ?>
            </div>

            <div class="flex items-center justify-between flex-grow md:pl-12 py-5">
                <div class="flex items-center space-x-6 capitalize">
                    <a href="../../index.php" class="text-gray-200 hover:text-white transition">Home</a>
                    <a href="../../shop.php" class="text-gray-200 hover:text-white transition">Shop</a>
                </div>
                <?php if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['user_is_logged_in'] !== true) {
                    
                 ?>
                    <a href="../../login.php" class="text-gray-200 hover:text-white transition">Login</a>
                <?php } else { ?>
                    <a href="toko.php" class="text-gray-200 hover:text-white transition">Toko</a>
                <?php }?>
            </div>
        </div>
    </nav>
    <!-- ./navbar -->
</body>

</html>