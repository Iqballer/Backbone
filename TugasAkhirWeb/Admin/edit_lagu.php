<?php
// edit_lagu.php
include '../koneksi.php';
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM musik WHERE id_musik = $id";
    $result = mysqli_query($conn, $query);
    $song = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $id_provinsi = $_POST['id_provinsi'];
    $daerah = $_POST['daerah'];
    $deskripsi = $_POST['deskripsi'];
    $lirik = $_POST['lirik'];

    $query = "UPDATE musik SET judul = '$judul', id_provinsi = '$id_provinsi', daerah = '$daerah', deskripsi = '$deskripsi', lirik = '$lirik' WHERE id_musik = $id";
    if (mysqli_query($conn, $query)) {
        header('Location: manage_lagu.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Song</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
 * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'poppins',sans-serif;
            }

            .container {
                display: flex;
                height: 100vh;
            }

            .logo {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                gap: 1rem;
            }

            .logo img {
                width: 60px;
                height: 60px;
            }

            .sidebar {
                width: 250px; 
                background-color: #E7BC91; 
                color: white;
                padding: 20px;
                position: fixed; 
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .sidebar h2 {
                font-family: 'Kaushan Script', cursive;
                color: #212529;
                margin-bottom: 20px;
                font-size: 24px;
            }

            .sidebar ul {
                list-style-type: none;
            }

            .sidebar ul li {
                margin: 15px 0;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .sidebar ul li a {
                text-decoration: none;
                color: #212529;
                font-size: 18px;
                font-weight: 400;
                display: block;
                padding: 8px 0;
            }

            .sidebar ul li a:hover,
.sidebar ul li a.active {
    font-weight: bold;
}

            .sidebar p {
                color: #212529;
            }

            /* Styling untuk konten utama */
            .content {
                display: flex;
                margin-left: 250px;
                padding: 20px;
                width: 100%;
            }

            .logo {
                font-size: 20px;
                color: #212529;
                display: flex;
                gap: 8px;
                align-items: center;
            }
            .logo a{
                font-family: 'kaushan script',sans-serif;
            }

            .main-content {
                flex: 1;
                display: flex;
                padding: 3rem;
                gap: 4rem;
                max-width: 900px;
                margin: 0 ;
                width: 100%;
            }

            .admin-section {
                flex: 1;
            }
            .admin-section h2 {
                margin-bottom: 40px;
            }

            .admin-container {
                background: transparent;
                border: 2px solid #8B4513;
                padding: 2rem;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .admin-container h2 {
                margin-bottom: 1.5rem;
                color: #000000;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-group label {
                display: block;
                margin-bottom: 0.5rem;
                color: #000000;
                font-weight: bold;
            }

            .form-group input {
                width: 100%;
                padding: 0.8rem;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 1rem;
            }

            .upload-label {
                display: inline-block;
                padding: 10px 20px;
                background-color: #ffffff;
                color: rgb(0, 0, 0);
                border: 1px solid #ddd;
                font-size: 16px;
                font-weight: bold;
                cursor: pointer;
                border-radius: 5px;
                margin-bottom: 20px;
                
            }

            input[type="file"] {
                display: none; /* Menyembunyikan input file asli */
            }

            .admin-submit {
                width: 15%;
                padding: 0.8rem;
                background-color: #E7BC91;
                color: #000000;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1rem;
                transition: background-color 0.3s;
                font-weight: bold;
            }
            .admin-button {
                width: 15%;
                padding: 0.8rem;
                background-color: #fff;
                color: #000000;
                border: 1px solid #ddd;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1rem;
                transition: background-color 0.3s;
                font-weight: bold;
                text-decoration: none;
            }

            .admin-button a {
                color: #000000;
                text-decoration: none;
            }

            .admin-submit:hover {
                background-color: #d8c5b4;
            }
            .admin-button:hover {
                background-color: #d8c5b4;
            }
            .footer {
                color: #000000;
            }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="../img/logo.png" alt="">
            <h2>Ensiklovadya</h2>
        </div>
        <ul>
                <li><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#00000"><path d="M226.67-186.67h140v-246.66h226.66v246.66h140v-380L480-756.67l-253.33 190v380ZM160-120v-480l320-240 320 240v480H526.67v-246.67h-93.34V-120H160Zm320-352Z"/></svg><a href="admin_page.php">Beranda Admin</a></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#00000"><path d="M430-200q38 0 64-26t26-64v-150h120v-80H480v155q-11-8-23.5-11.5T430-380q-38 0-64 26t-26 64q0 38 26 64t64 26ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg><a href="#">Manajemen Lagu</a></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#00000"><path d="M226-262q59-42.33 121.33-65.5 62.34-23.17 132.67-23.17 70.33 0 133 23.17T734.67-262q41-49.67 59.83-103.67T813.33-480q0-141-96.16-237.17Q621-813.33 480-813.33t-237.17 96.16Q146.67-621 146.67-480q0 60.33 19.16 114.33Q185-311.67 226-262Zm253.88-184.67q-58.21 0-98.05-39.95Q342-526.58 342-584.79t39.96-98.04q39.95-39.84 98.16-39.84 58.21 0 98.05 39.96Q618-642.75 618-584.54t-39.96 98.04q-39.95 39.83-98.16 39.83ZM480.31-80q-82.64 0-155.64-31.5-73-31.5-127.34-85.83Q143-251.67 111.5-324.51T80-480.18q0-82.82 31.5-155.49 31.5-72.66 85.83-127Q251.67-817 324.51-848.5T480.18-880q82.82 0 155.49 31.5 72.66 31.5 127 85.83Q817-708.33 848.5-635.65 880-562.96 880-480.31q0 82.64-31.5 155.64-31.5 73-85.83 127.34Q708.33-143 635.65-111.5 562.96-80 480.31-80Zm-.31-66.67q54.33 0 105-15.83t97.67-52.17q-47-33.66-98-51.5Q533.67-284 480-284t-104.67 17.83q-51 17.84-98 51.5 47 36.34 97.67 52.17 50.67 15.83 105 15.83Zm0-366.66q31.33 0 51.33-20t20-51.34q0-31.33-20-51.33T480-656q-31.33 0-51.33 20t-20 51.33q0 31.34 20 51.34 20 20 51.33 20Zm0-71.34Zm0 369.34Z"/></svg><a href="manage_user.php">Manajemen User</a></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#00000"><path d="M693.33-40v-120h-120v-66.67h120v-120H760v120h120V-160H760v120h-66.67ZM186.67-186.67v-586.66 586.66-6 6Zm0 66.67q-27 0-46.84-19.83Q120-159.67 120-186.67v-586.66q0-27 19.83-46.84Q159.67-840 186.67-840h586.66q27 0 46.84 19.83Q840-800.33 840-773.33V-397q-15.1-8.95-31.88-14.64-16.79-5.69-34.79-9.69v-352H186.67v586.66h306.66q.67 17.67 3.06 34.28 2.38 16.61 7.94 32.39H186.67Zm120-164q13.66 0 23.5-9.83 9.83-9.84 9.83-23.5 0-13.67-9.83-23.5-9.84-9.84-23.5-9.84-13.67 0-23.5 9.84-9.84 9.83-9.84 23.5 0 13.66 9.84 23.5Q293-284 306.67-284Zm0-162.67q13.66 0 23.5-9.83Q340-466.33 340-480t-9.83-23.5q-9.84-9.83-23.5-9.83-13.67 0-23.5 9.83-9.84 9.83-9.84 23.5t9.84 23.5q9.83 9.83 23.5 9.83Zm0-162.66q13.66 0 23.5-9.84Q340-629 340-642.67q0-13.66-9.83-23.5-9.84-9.83-23.5-9.83-13.67 0-23.5 9.83-9.84 9.84-9.84 23.5 0 13.67 9.84 23.5 9.83 9.84 23.5 9.84Zm128 162.66h242.66v-66.66H434.67v66.66Zm0-162.66h242.66V-676H434.67v66.67Zm0 325.33H512q8-19 19-35.33 11-16.34 24.33-31.34H434.67V-284Z"/></svg><a href="#">Manajemen Quiz</a></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#00000"><path d="M186.67-120q-27 0-46.84-19.83Q120-159.67 120-186.67v-586.66q0-27 19.83-46.84Q159.67-840 186.67-840h292.66v66.67H186.67v586.66h292.66V-120H186.67Zm470.66-176.67-47-48 102-102H360v-66.66h351l-102-102 47-48 184 184-182.67 182.66Z"/></svg><a href="../logout.php">Keluar</a></li>
            </ul>
        <div class="footer">
            © Copyright By Backbone
        </div>
    </div>

    <div class="container">

        <div class="container">
            <div class="content">
            </div>
        </div>
        <main class="main-content">
            <section class="admin-section">
                <h2>Edit Data Lagu</h2>
                <div class="admin-container">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="judul">Title</label>
                        <input type="text" id="judul" name="judul" value="<?php echo $song['judul']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_provinsi">Province</label>
                        <select id="id_provinsi" name="id_provinsi" required>
                            <?php
                            $query = "SELECT * FROM provinsi";
                            $result = mysqli_query($conn, $query);
                            while ($provinsi = mysqli_fetch_assoc($result)) {
                                $selected = ($provinsi['id_provinsi'] == $song['id_provinsi']) ? 'selected' : '';
                                echo "<option value='{$provinsi['id_provinsi']}' $selected>{$provinsi['nama']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="daerah">Region</label>
                        <input type="text" id="daerah" name="daerah" value="<?php echo $song['daerah']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Description</label>
                        <textarea id="deskripsi" name="deskripsi" required><?php echo $song['deskripsi']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="lirik">Lyrics</label>
                        <textarea id="lirik" name="lirik" required><?php echo $song['lirik']; ?></textarea>
                    </div>
                    <a href="manage_lagu.php" class="admin-button">Kembali</a>
                    <button type="submit" class="admin-submit">Update</button>
                </form>
            </section>
    </div>
</body>
</html>