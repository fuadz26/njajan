<?php
session_start();
include 'asset/php/connection.php';

if (!isset($_SESSION['user'])) {
    // Jika pengguna belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form
    $username = $_SESSION['user'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];

    // Menghandle upload foto jika ada perubahan
    if ($_FILES['user_img']['name']) {
        $target_dir = "D:/KULIAH/semester 2/Pemograman web/uas/asset/file/img_profil/";
        $target_file = $target_dir . basename($_FILES["user_img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file gambar valid atau bukan
        $check = getimagesize($_FILES["user_img"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Cek apakah file sudah ada atau belum
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Batasi jenis file yang diizinkan
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            $uploadOk = 0;
        }

        // Cek jika $uploadOk bernilai 0 karena terdapat kesalahan
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Jika semua validasi berhasil, upload file
            if (move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["user_img"]["name"]) . " has been uploaded.";

                // Update informasi pengguna ke dalam database
                $sql = "UPDATE users SET 
                        nama_lengkap = '$nama_lengkap',
                        email = '$email',
                        alamat = '$alamat',
                        nomor_telepon = '$nomor_telepon',
                        user_img = '$target_file'
                        WHERE username = '$username'";

                $result = pg_query($conn, $sql);

                if ($result) {
                    // Jika update berhasil, redirect ke halaman profil pengguna
                    header("Location: profile.php");
                    exit();
                } else {
                    echo "Failed to update user information.";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Update informasi pengguna ke dalam database (tanpa perubahan gambar)
        $sql = "UPDATE users SET 
                nama_lengkap = '$nama_lengkap',
                email = '$email',
                alamat = '$alamat',
                nomor_telepon = '$nomor_telepon'
                WHERE username = '$username'";

        $result = pg_query($conn, $sql);

        if ($result) {
            // Jika update berhasil, redirect ke halaman profil pengguna
            header("Location: profile.php");
            exit();
        } else {
            echo "Failed to update user information.";
        }
    }
}

$user = $_SESSION['user'];
$sql = "SELECT * FROM users WHERE username = '$user'";
$result = pg_query($conn, $sql);
$row = pg_fetch_object($result);
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
    <link rel="stylesheet" href="asset/css/output.css">
    <title>Edit User</title>
</head>

<body>
    <?php include 'asset/php/navbar.php';
    
    include 'asset/php/connection.php';
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else
        echo 'Fail contol';
    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = pg_query($conn, $sql);
    while($row = pg_fetch_object($result)){
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
                        class="relative   text-green-500 hover:text-green-500 block capitalize transition">
                        Profile information
                    </a>
                    <a href="address.php?id=<?php echo $user_id;?> "
                        class="relative  hover:text-green-500 block capitalize transition">
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
                    <a href="list_product.php" class="relative block capitalize transition">
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


        <!-- ./main content -->

        <div class="col-span-9">
            <form action="" method="POST">
                <div class="mb-4">
                    <label for="username" class="block font-medium mb-2">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $row->username; ?>" class="w-full px-4 py-2 border border-gray-300 rounded" disabled>
                </div>
                <div class="mb-4">
                    <label for="nama_lengkap" class="block font-medium mb-2">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $row->nama_lengkap; ?>" class="w-full px-4 py-2 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label for="email" class="block font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $row->email; ?>" class="w-full px-4 py-2 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block font-medium mb-2">Alamat</label>
                    <textarea id="alamat" name="alamat" class="w-full px-4 py-2 border border-gray-300 rounded"><?php echo $row->alamat; ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="nomor_telepon" class="block font-medium mb-2">Nomor Telepon</label>
                    <input type="text" id="nomor_telepon" name="nomor_telepon" value="<?php echo $row->nomor_telepon; ?>" class="w-full px-4 py-2 border border-gray-300 rounded">
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" name="submit" class="  px-6 py-2 bg-green-500 text-white font-medium rounded">Save Changes</button>
                </div>
            </form>
        </div>

        <!-- ./main content -->
    </div>
    <?php } ?>
    <!-- ./wrapper -->

</body>

</html>
