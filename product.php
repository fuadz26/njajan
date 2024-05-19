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
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="asset/css/output.css">
    <style>
        /* Ubah warna latar belakang dan teks tombol menjadi coklat */
        .btn-add-to-cart {
            background-color: #964B00;
            border-color: #964B00;
        }

        .btn-add-to-cart:hover {
            background-color: transparent;
            color: #964B00;
        }

        /* Atur ukuran gambar agar tidak terlalu besar */
        .product-image {
            max-width: 100%;
            height: auto;
        }

        /* Atur margin atas agar tidak terlalu nempel dengan navbar */
        .product-container {
            margin-top: 20px;
        }
    </style>
    <title>Login</title>
</head>

<body>
    <?php
    include 'asset/php/navbar.php';
    include 'asset/php/connection.php';

    $produk_id = $_GET['id'];
    $sql = "SELECT p.*, k.nama_kategori 
        FROM produk p
        INNER JOIN kategori k ON p.kategori_id = k.kategori_id
        WHERE p.produk_id = '$produk_id'";
    $result = pg_query($conn, $sql);

    while ($row = pg_fetch_object($result)) {
    ?>
        <!-- product-detail -->
        <div class="container mx-auto product-container" style="padding-left: 100px;padding-right: 100px">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <img src="<?php echo $row->produk_img; ?>" alt="product" class="product-image">
                </div>
                <div>
                    <h2 class="text-3xl font-medium mb-2"><?php echo $row->nama_produk; ?></h2>
                    <p class="text-gray-600"><?php echo $row->deskripsi_produk; ?></p>
                    <div class="mt-4">
                        <h3 class="text-sm text-gray-800 uppercase mb-1">Quantity</h3>
                        <div class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300 w-max">
                            <div class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none quantity-btn" onclick="decreaseQuantity()">-</div>
                            <div id="quantity" class="h-8 w-8 text-base flex items-center justify-center">1</div>
                            <div class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none quantity-btn" onclick="increaseQuantity()">+</div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="asset/php/insert_cart.php?id=<?php echo $row->produk_id ?>&harga=<?php echo $row->harga_produk ?>" class="btn-add-to-cart bg-brown-500 border border-brown-500 text-white px-8 py-2 font-medium rounded uppercase hover:bg-transparent hover:text-brown-500 transition">
                            <i class="fas fa-shopping-cart mr-2"></i> Add to cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <script>
        var quantity = 1;

        function decreaseQuantity() {
            if (quantity > 1) {
                quantity--;
                updateQuantity();
            }
        }

        function increaseQuantity() {
            quantity++;
            updateQuantity();

            // Kirim data quantity ke backend
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_quantity.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('quantity=' + quantity);
        }

        function updateQuantity() {
            var quantityElement = document.getElementById("quantity");
            quantityElement.textContent = quantity;
        }
    </script>

</body>

</html>