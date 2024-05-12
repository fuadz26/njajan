<?php session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="asset/css/output.css">
    <title>Document</title>
</head>

<body>
    <?php
    include 'asset/php/navbar.php';
    ?>
    <!-- register toko -->
    <div class="contain py-16">
        <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
            <h2 class="text-2xl uppercase font-medium mb-1">Register Your Store</h2>
            <p class="text-gray-600 mb-6 text-sm">
                Register your store details
            </p>
            <form action="asset/php/regis_toko_aksi.php" method="post" autocomplete="off">
                <div class="space-y-2">
                    <div>
                        <label for="nama_toko" class="text-gray-600 mb-2 block">Store Name</label>
                        <input type="text" name="nama_toko" id="nama_toko"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400"
                            placeholder="Your Store Name">
                    </div>
                    <div>
                        <label for="deskripsi_toko" class="text-gray-600 mb-2 block">Store Description</label>
                        <textarea name="deskripsi_toko" id="deskripsi_toko"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400"
                            placeholder="Description"></textarea>
                    </div>
                    <div>
                        <label for="nomor_telepon" class="text-gray-600 mb-2 block">Phone Number</label>
                        <input type="text" name="nomor_telepon" id="nomor_telepon"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400"
                            placeholder="Phone Number">
                    </div>
                    <div>
                        <label for="alamat_toko" class="text-gray-600 mb-2 block">Alamat Toko</label>
                        <input type="text" name="alamat_toko" id="alamat_toko"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400"
                            placeholder="Alamat">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit"
                        class="block w-full py-2 text-center text-white bg-green-500 border border-green-500 rounded hover:bg-transparent hover:text-green-500 transition uppercase font-roboto font-medium">Register
                        Store</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
