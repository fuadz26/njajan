<?php
session_start();
include 'asset/php/connection.php';

if (!isset($_SESSION['user'])) {

    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_SESSION['user'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];


    if ($_FILES['user_img']['name']) {
        $target_dir = "D:/KULIAH/semester 2/Pemograman web/uas/asset/file/img_profil/";
        $target_file = $target_dir . basename($_FILES["user_img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


        $check = getimagesize($_FILES["user_img"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }


        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }


        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            $uploadOk = 0;
        }


        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {

            if (move_uploaded_file($_FILES["user_img"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["user_img"]["name"]) . " has been uploaded.";


                $sql = "UPDATE users SET 
                        nama_lengkap = '$nama_lengkap',
                        email = '$email',
                        alamat = '$alamat',
                        nomor_telepon = '$nomor_telepon',
                        user_img = '$target_file'
                        WHERE username = '$username'";

                $result = pg_query($conn, $sql);

                if ($result) {

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

        $sql = "UPDATE users SET 
                nama_lengkap = '$nama_lengkap',
                email = '$email',
                alamat = '$alamat',
                nomor_telepon = '$nomor_telepon'
                WHERE username = '$username'";

        $result = pg_query($conn, $sql);

        if ($result) {

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

    <style>
        .text-brown-500 {
            color: #8B4513;
        }

        .text-brown-600 {
            color: #A0522D;
        }

        .text-brown-800 {
            color: #5C4033;
        }

        .bg-brown-500 {
            background-color: #8B4513;
        }

        .border-brown-500 {
            border-color: #8B4513;
        }

        .hover\:text-brown-500:hover {
            color: #8B4513;
        }

        .hover\:bg-brown-500:hover {
            background-color: #8B4513;
            color: #FFF;
        }

        .hover\:bg-transparent:hover {
            background-color: transparent;
            color: #8B4513;
        }

        .sidebar {
            background-color: #8B4513;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #FFF;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #FFF;
        }

        .sidebar-header img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 2px solid #FFF;
        }

        .sidebar-content {
            margin-top: 20px;
        }

        .sidebar-link {
            display: block;
            padding: 10px;
            border-radius: 5px;
            color: #FFF;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar-link:hover {
            background-color: #A0522D;
        }

        .sidebar-link i {
            margin-right: 10px;
        }
    </style>
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
    while ($row = pg_fetch_object($result)) {
    ?>
        <!-- wrapper -->
        <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16 mx-auto" style="padding-left: 100px;padding-right: 100px">

            <!-- sidebar -->
            <div class="col-span-3">
                <div class="sidebar">
                    <div class="sidebar-header">
                        <img src="<?php echo $row->user_img; ?>" alt="profile">
                        <div>
                            <p>Hello,</p>
                            <h4><?php echo $row->username; ?></h4>
                        </div>
                    </div>

                    <div class="sidebar-content">
                        <a href="profile.php" class="sidebar-link">
                            <i class="fa-regular fa-address-card"></i> Manage account
                        </a>
                        <a href="profile.php" class="sidebar-link ">
                            Profile information
                        </a>
                        <a href="address.php?id=<?php echo $row->user_id; ?>" class="sidebar-link ">
                            Manage addresses
                        </a>
                        <a href="wishlist.php" class="sidebar-link">
                            <i class="fa-solid fa-bag-shopping"></i>
                            My Cart
                        </a>
                        <a href="toko.php" class="sidebar-link">
                            <i class="fa-solid fa-shop"></i>
                            My Store
                        </a>
                        <a href="tambah_produk.php" class="sidebar-link text-brown-500">
                            Add Product
                        </a>
                        <a href="list_product.php" class="sidebar-link ">
                            Product Listed
                        </a>
                        <a href="order.php" class="sidebar-link ">
                            Order
                        </a>
                        <a href="asset/php/logout.php" class="sidebar-link ">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </a>
                    </div>
                </div>
            </div>


            <!-- ./main content -->

            <div class="col-span-9">
                <form action="" method="POST">
                    <div class="mb-4">
                        <label for="username" class="block font-medium mb-2">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo $row->username; ?>" class="w-full px-4 py-2 border border-brown-500 rounded" disabled>
                    </div>
                    <div class="mb-4">
                        <label for="nama_lengkap" class="block font-medium mb-2">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $row->nama_lengkap; ?>" class="w-full px-4 py-2 border border-brown-500 rounded">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $row->email; ?>" class="w-full px-4 py-2 border border-brown-500 rounded">
                    </div>
                    <div class="mb-4">
                        <label for="alamat" class="block font-medium mb-2">Alamat</label>
                        <textarea id="alamat" name="alamat" class="w-full px-4 py-2 border border-brown-500 rounded"><?php echo $row->alamat; ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="nomor_telepon" class="block font-medium mb-2">Nomor Telepon</label>
                        <input type="text" id="nomor_telepon" name="nomor_telepon" value="<?php echo $row->nomor_telepon; ?>" class="w-full px-4 py-2 border border-brown-500 rounded">
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" name="submit" class="px-6 py-2 bg-brown-500 text-white font-medium rounded">Save Changes</button>
                    </div>
                </form>
            </div>


            <!-- ./main content -->
        </div>
    <?php } ?>
    <!-- ./wrapper -->

</body>

</html>