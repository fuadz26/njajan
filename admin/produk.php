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
if (isset($_SESSION['admin']) && $_SESSION['admin_is_logged_in']) {
    $user = $_SESSION['admin'];
}
    ?>
    <?php
        
        $sql = "SELECT * FROM admin where admin_name = '$user'";
        $result = pg_query($conn, $sql);

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
                    
                    <li class="mb-2 rounded hover:shadow hover:bg-gray-800">
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
                    <li class="mb-2 rounded hover:shadow bg-gray-800">
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
    </a><a href="../asset/php/logout.php"
        class="block w-full px-3 py-2 mt-4 font-bold text-white bg-blue-500 hover:bg-blue-600 rounded-lg text-center">
        Logout
    </a>
        </div>
        <?php } 
        ?>

        <div class="w-full px-4 py-2 bg-gray-200 lg:w-full">
            <div class="container mx-auto mt-12">

                <div class="flex flex-col mt-8">
                    <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                        <div
                            class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                            Nama Produk</th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                            Kategori</th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                            Toko</th>


                                        <th
                                            class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                            Harga</th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                            Edit</th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                            Delete</th>
                                    </tr>
                                </thead>


                                <tbody class="bg-white">
                                    <?php 
        
                                $sql = "SELECT p.*, k.nama_kategori, t.nama_toko
                                FROM produk p
                                JOIN kategori k ON p.kategori_id = k.kategori_id
                                JOIN toko t ON p.toko_id = t.toko_id";
                                $result = pg_query($conn, $sql);
       
                                while($row=pg_fetch_object($result)){
                                ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-10 h-10 rounded-full"
                                                        src="../<?php echo $row->produk_img ;?>"
                                                        alt="admin dashboard ui">
                                                </div>

                                                <div class="ml-4">
                                                    <div class="text-sm font-medium leading-5 text-gray-900">
                                                        <?php echo $row->nama_produk ;?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-500">
                                                <?php echo $row->nama_kategori;?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-500"><?php echo $row->nama_toko;?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-500">
                                                <?php echo $row->harga_produk;?></div>
                                        </td>


                                        <td
                                            class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                            <a href="#.php">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                            <a href="hapus_produk.php?id=<?php echo $row->produk_id; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </a>
                                        </td>

                                    </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>