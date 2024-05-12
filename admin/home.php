<?php 
session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user</title>
    <link rel="stylesheet" href="../asset/css/output.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
<?php

    include '../asset/php/connection.php';
    if (isset($_SESSION['admin']) && isset($_SESSION['admin_is_logged_in'])){
        $user = $_SESSION['admin'];
    }
    else 
    {
        echo $user;
        print_r($_SESSION);
        exit('../login.php');
        header('Location: ../login.php');
    }
    ?>
        <?php
        
        $sql = "SELECT * FROM admin where admin_name = '$user'";
        $result = pg_query($conn, $sql);
        pg_query($conn, $sql);
        while($row=pg_fetch_object($result)){
    ?>

    <div class="flex h-screen">
    <div class="px-4 py-2 bg-indigo-600 lg:w-1/4">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline w-8 h-8 text-white lg:hidden" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <div class="hidden lg:block">
                <div class="my-2 mb-6">
                    <h1 class="text-2xl font-bold text-white">Admin Dashboard - <?php echo $row->admin_name;?></h1>
                </div>
                <ul>
                    
                    <li class="mb-2 rounded hover:shadow bg-gray-800">
                        <a href="home.php" class="inline-block w-full h-full px-3 py-2 font-bold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-6 h-6 mr-2 -mt-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li class="mb-2 hover:bg-gray-800 rounded hover:shadow">
                        <a href="user.php" class="inline-block w-full h-full px-3 py-2 font-bold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-6 h-6 mr-2 -mt-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Users
                        </a>
                    </li>
                    <li class="mb-2 rounded hover:shadow hover:bg-gray-800">
                        <a href="pesanan.php" class="inline-block w-full h-full px-3 py-2 font-bold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-6 h-6 mr-2 -mt-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Pesanan
                        </a>
                    </li>
                    <li class="mb-2 rounded hover:shadow hover:bg-gray-800">
                        <a href="produk.php" class="inline-block w-full h-full px-3 py-2 font-bold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-6 h-6 mr-2 -mt-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Data - Produk
                        </a>
                    </li>
                </ul>
            </div>
            <a href="regis_admin.php"
        class="block w-full px-3 py-2 mt-4 font-bold text-white bg-blue-500 hover:bg-blue-600 rounded-lg text-center">
        Register
    </a>
    <a href="../asset/php/logout.php"
        class="block w-full px-3 py-2 mt-4 font-bold text-white bg-blue-500 hover:bg-blue-600 rounded-lg text-center">
        Logout
    </a>

        </div>
        <?php } 
        ?>
        <div class="w-full px-4 py-2 bg-gray-200 lg:w-full">
            <div class="container mx-auto mt-12">
                <div class="grid gap-4 lg:grid-cols-3">
                    <div class="flex items-center px-4 py-6 bg-white rounded-md shadow-md">
                        <div class="p-3 bg-indigo-600 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <?php 
        
                        $sql = "SELECT COUNT(*) AS totalUsers FROM users";
                        $result = pg_query($conn, $sql);
                        pg_query($conn, $sql);
                        while($row=pg_fetch_object($result)){
                        ?>
                        <div class="mx-4">
                            <h4 class="text-2xl font-semibold text-gray-700"><?php echo $row->totalusers;?></h4>
                            <div class="text-gray-500">All Users</div>
                        </div>
                        <?php }?>
                    </div>
                    <div class="flex items-center px-4 py-6 bg-white rounded-md shadow-md">
                        <div class="p-3 bg-indigo-600 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                        </div>
                        <?php 
        
                        $sql = "SELECT COUNT(*) AS totalProduk FROM produk";
                        $result = pg_query($conn, $sql);
                        pg_query($conn, $sql);
                        while($row=pg_fetch_object($result)){
                        ?>
                        <div class="mx-4">
                            <h4 class="text-2xl font-semibold text-gray-700"><?php echo $row->totalproduk ;?></h4>
                            <div class="text-gray-500">All Produk</div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="flex items-center px-4 py-6 bg-white rounded-md shadow-md">
                        <div class="p-3 bg-indigo-600 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <?php 
        
                        $sql = "SELECT COUNT(*) AS totalUsers FROM transaksi";
                        $result = pg_query($conn, $sql);
                        pg_query($conn, $sql);
                        while($row=pg_fetch_object($result)){
                        ?>
                        <div class="mx-4">
                            <h4 class="text-2xl font-semibold text-gray-700"><?php echo $row->totalusers ;?></h4>
                            <div class="text-gray-500">All Transaction</div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="flex flex-col mt-8">
                    <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                        <div
                            class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                            <h1 class=" text-center text-4xl font-bold">SELAMAT DATANG DI HALAMAN ADMIN</h1>

                            
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</body>
</html>