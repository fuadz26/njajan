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
    <link rel="stylesheet" href="../asset/css/output.css">
    <title>Tambah Alamat</title>
</head>

<body>
    <?php
    include 'asset/php/navbar.php';
    include 'asset/php/connection.php';
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    }
    ?>

    <body>
        <?php
        ?>
        <!-- login -->
        <div class="contain py-16">
            <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
                <h2 class="text-2xl uppercase font-medium mb-1">Tambah Alamat</h2>
                <p class="text-gray-600 mb-6 text-sm">
                    Tambah Alamat
                </p>
                <form action="/asset/php/tambah_alamat_aksi.php" method="post" autocomplete="off">
                    <div class="space-y-2">
                        <div>
                            <label for="name" class="text-gray-600 mb-2 block">Nama Penerima</label>
                            <input type="text" name="name" id="name" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400" placeholder="">
                        </div>
                        <div>
                            <label for="address" class="text-gray-600 mb-2 block">Alamat</label>
                            <input type="text" name="address" id="address" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400" placeholder="">
                        </div>
                        <div>
                            <label for="city" class="text-gray-600 mb-2 block">Kota</label>
                            <input type="text" name="city" id="city" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400" placeholder="">
                        </div>
                        <div>
                            <label for="kodepos" class="text-gray-600 mb-2 block">Kode Pos</label>
                            <input type="text" name="kodepos" id="kodepos" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400" placeholder="">
                        </div>
                        <div>
                            <label for="telepon" class="text-gray-600 mb-2 block">Nomor Telepon</label>
                            <input type="text" name="telepon" id="telepon" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-green-500 placeholder-gray-400" placeholder="">
                        </div>

                    </div>
                    <div class="mt-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="aggrement" id="aggrement" class="text-green-500 focus:ring-0 rounded-sm cursor-pointer">
                            <label for="aggrement" class="text-gray-600 ml-3 cursor-pointer">Yakin ta rek???

                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="block w-full py-2 text-center text-white bg-green-500 border border-green-500 rounded hover:bg-transparent hover:text-green-500 transition uppercase font-roboto font-medium">Tambah Alamat</button>
                    </div>
                </form>
    </body>
</body>

</html>