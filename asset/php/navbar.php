<?php session_start(); ?>
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
    <title>Njajan</title>
    <style>
        /* Default styling for larger screens */
        .search-form {
            width: 100%;
            max-width: 36rem;
            /* Max width of 576px */
        }

        .search-input,
        .search-button {
            display: flex;
        }

        /* Media query for smaller screens */
        @media (max-width: 768px) {
            .search-form {
                max-width: 100%;
                /* Allow the form to take full width */
            }

            .search-input,
            .search-button {
                width: 100%;
                border-radius: 0;
            }

            .search-input {
                border-right: 1px solid #8B4513;
                /* Re-add right border to the input */
            }
        }

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
    </style>
</head>

<body>
    <!-- header -->
    <header class="py-4 shadow-sm bg-beige">
        <div class="container flex items-center justify-between mx-auto">
            <a href="../../index.php" class="text-brown font-bold">NJAJAN</a>

            <form action="../../search.php" method="post" class="search-form relative flex">
                <span class="absolute left-4 top-3 text-lg text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" id="search" class="search-input w-full border border-brown hover:border-brown border-r-0 pl-12 py-3 pr-3 rounded-l-md focus:outline-none hidden md:flex" placeholder="search">
                <button class="btn-brown pt-3 border border-brown text-white px-8 rounded-r-md hover:bg-transparent hover:text-brown transition hidden md:flex">Search</button>
            </form>

            <div class="flex items-center space-x-4">
                <a href="../../wishlist.php" class="text-center text-gray-700 hover-text-brown transition relative">
                    <div class="text-2xl">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div class="text-xs leading-3">Cart</div>
                </a>
                <a href="../../profile.php" class="text-center text-gray-700 hover-text-brown transition relative">
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
    <nav class="bg-brown">
        <div class="container flex mx-auto px-6 lg:px-16">
            <div class="px-8 py-4 bg-brown text-beige md:flex items-center cursor-pointer relative group hidden">
                <span>
                    <i class="fa-solid fa-bars"></i>
                </span>
                <span class="capitalize ml-2">All Categories</span>
                <?php
                $sql = "SELECT * FROM kategori";
                include 'connection.php';
                $result = pg_query($conn, $sql);
                while ($row = pg_fetch_object($result)) {
                ?>
                    <!-- dropdown -->
                    <div class="absolute w-full left-0 top-full bg-white shadow-md py-3 divide-y divide-gray-300 divide-dashed opacity-0 group-hover:opacity-100 transition duration-300 invisible group-hover:visible">
                        <a href="../../search.php?id=<?php echo $row->kategori_id; ?>" class="flex items-center px-6 py-3 hover:bg-gray-100 transition">
                            <img src="<?php echo $row->kategori_img; ?>" alt="category" class="w-5 h-5 object-contain">
                            <span class="ml-6 text-gray-600 text-sm"><?php echo $row->nama_kategori; ?></span>
                        </a>
                    </div>
                <?php } ?>
            </div>

            <div class="flex items-center justify-between flex-grow md:pl-12 py-5">
                <div class="flex items-center space-x-6 capitalize">
                    <a href="../../index.php" class="text-beige hover-text-white transition">Home</a>
                    <a href="../../shop.php" class="text-beige hover-text-white transition">Shop</a>
                </div>
                <?php if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['user_is_logged_in'] !== true) { ?>
                    <a href="../../login.php" class="text-beige hover-text-white transition">Login</a>
                <?php } else { ?>
                    <a href="toko.php" class="text-beige hover-text-white transition">Toko</a>
                <?php } ?>
            </div>
        </div>
    </nav>
    <!-- ./navbar -->
</body>

</html>