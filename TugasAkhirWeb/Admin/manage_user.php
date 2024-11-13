<?php
// manage_user.php
include '../koneksi.php';
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

// Pagination settings
$limit = 5; // Number of entries to show in a page.
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;

// Fetch users from database
$query = "SELECT * FROM user ORDER BY id_user ASC LIMIT $start_from, $limit";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<head>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

.container {
    margin-left: 270px;
    padding: 20px;
    width: calc(100% - 270px);
}

.logo {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.logo img {
    width: 60px;
    height: 60px;
}

.sidebar {
    width: 250px;
    background-color: #E7BC91;
    padding: 20px;
    color: #212529;
    position: fixed;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.sidebar h2 {
    font-family: 'Kaushan Script', cursive;
    color: #212529;
    font-size: 24px;
    text-align: center;
    justify-items: center;
}

.sidebar ul {
    list-style: none;
    padding: 0;
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

/* AWOOOOOOOOOOOOOOO */

.container h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

.search-bar {
    width: 85%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-right: 10px;
}

.btn-add {
    font-size: 24px;
    padding: 10px;
    background-color: #212529;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    text-align: center;
}

.song-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #fff;
    margin-bottom: 1rem;
}

.song-table th,
.song-table td {
    padding: 15px;
    border: 1px solid #ddd;
    text-align: left;
}

.song-table th {
    background-color: #E7BC91;
    color: #212529;
    font-weight: bold;
}

.song-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.action-btns a {
    margin-right: 8px;
    font-size: 18px;
}

.pagination-nav {
    text-align: center;
    margin-top: 20px;
}

.pagination {
    display: inline-flex;
    list-style-type: none;
    padding: 0;
}

.pagination li {
    margin: 0 5px;
}

.pagination a {
    padding: 8px 12px;
    text-decoration: none;
    color: #333;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.pagination .active {
    background-color: #007BFF;
    color: #fff;
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
                <li><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#00000"><path d="M430-200q38 0 64-26t26-64v-150h120v-80H480v155q-11-8-23.5-11.5T430-380q-38 0-64 26t-26 64q0 38 26 64t64 26ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg><a href="manage_lagu.php">Manajemen Lagu</a></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#00000"><path d="M226-262q59-42.33 121.33-65.5 62.34-23.17 132.67-23.17 70.33 0 133 23.17T734.67-262q41-49.67 59.83-103.67T813.33-480q0-141-96.16-237.17Q621-813.33 480-813.33t-237.17 96.16Q146.67-621 146.67-480q0 60.33 19.16 114.33Q185-311.67 226-262Zm253.88-184.67q-58.21 0-98.05-39.95Q342-526.58 342-584.79t39.96-98.04q39.95-39.84 98.16-39.84 58.21 0 98.05 39.96Q618-642.75 618-584.54t-39.96 98.04q-39.95 39.83-98.16 39.83ZM480.31-80q-82.64 0-155.64-31.5-73-31.5-127.34-85.83Q143-251.67 111.5-324.51T80-480.18q0-82.82 31.5-155.49 31.5-72.66 85.83-127Q251.67-817 324.51-848.5T480.18-880q82.82 0 155.49 31.5 72.66 31.5 127 85.83Q817-708.33 848.5-635.65 880-562.96 880-480.31q0 82.64-31.5 155.64-31.5 73-85.83 127.34Q708.33-143 635.65-111.5 562.96-80 480.31-80Zm-.31-66.67q54.33 0 105-15.83t97.67-52.17q-47-33.66-98-51.5Q533.67-284 480-284t-104.67 17.83q-51 17.84-98 51.5 47 36.34 97.67 52.17 50.67 15.83 105 15.83Zm0-366.66q31.33 0 51.33-20t20-51.34q0-31.33-20-51.33T480-656q-31.33 0-51.33 20t-20 51.33q0 31.34 20 51.34 20 20 51.33 20Zm0-71.34Zm0 369.34Z"/></svg><a href="manage_user.php">Manajemen User</a></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#00000"><path d="M693.33-40v-120h-120v-66.67h120v-120H760v120h120V-160H760v120h-66.67ZM186.67-186.67v-586.66 586.66-6 6Zm0 66.67q-27 0-46.84-19.83Q120-159.67 120-186.67v-586.66q0-27 19.83-46.84Q159.67-840 186.67-840h586.66q27 0 46.84 19.83Q840-800.33 840-773.33V-397q-15.1-8.95-31.88-14.64-16.79-5.69-34.79-9.69v-352H186.67v586.66h306.66q.67 17.67 3.06 34.28 2.38 16.61 7.94 32.39H186.67Zm120-164q13.66 0 23.5-9.83 9.83-9.84 9.83-23.5 0-13.67-9.83-23.5-9.84-9.84-23.5-9.84-13.67 0-23.5 9.84-9.84 9.83-9.84 23.5 0 13.66 9.84 23.5Q293-284 306.67-284Zm0-162.67q13.66 0 23.5-9.83Q340-466.33 340-480t-9.83-23.5q-9.84-9.83-23.5-9.83-13.67 0-23.5 9.83-9.84 9.83-9.84 23.5t9.84 23.5q9.83 9.83 23.5 9.83Zm0-162.66q13.66 0 23.5-9.84Q340-629 340-642.67q0-13.66-9.83-23.5-9.84-9.83-23.5-9.83-13.67 0-23.5 9.83-9.84 9.84-9.84 23.5 0 13.67 9.84 23.5 9.83 9.84 23.5 9.84Zm128 162.66h242.66v-66.66H434.67v66.66Zm0-162.66h242.66V-676H434.67v66.67Zm0 325.33H512q8-19 19-35.33 11-16.34 24.33-31.34H434.67V-284Z"/></svg><a href="manage_quiz.php">Manajemen Quiz</a></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#00000"><path d="M186.67-120q-27 0-46.84-19.83Q120-159.67 120-186.67v-586.66q0-27 19.83-46.84Q159.67-840 186.67-840h292.66v66.67H186.67v586.66h292.66V-120H186.67Zm470.66-176.67-47-48 102-102H360v-66.66h351l-102-102 47-48 184 184-182.67 182.66Z"/></svg><a href="../logout.php">Keluar</a></li>
            </ul>
        <div class="footer">
            © Copyright By Backbone
        </div>
    </div>

    <div class="container">
        <h2>Manajemen User</h2>
        <input type="text" placeholder="Cari User" class="search-bar">
        <table class="song-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td class="action-btns">
                            <a href="lihat_user.php?id=<?php echo $row['id_user']; ?>" class="btn-info"><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#00000"><path d="M480.08-326.67q72.25 0 122.75-50.58 50.5-50.57 50.5-122.83 0-72.25-50.58-122.75-50.57-50.5-122.83-50.5-72.25 0-122.75 50.58-50.5 50.57-50.5 122.83 0 72.25 50.58 122.75 50.57 50.5 122.83 50.5Zm-.24-62.66q-46.17 0-78.34-32.33-32.17-32.32-32.17-78.5 0-46.17 32.33-78.34 32.32-32.17 78.5-32.17 46.17 0 78.34 32.33 32.17 32.32 32.17 78.5 0 46.17-32.33 78.34-32.32 32.17-78.5 32.17ZM480-200q-146 0-264.67-82.5Q96.67-365 40-500q56.67-135 175.33-217.5Q334-800 480-800t264.67 82.5Q863.33-635 920-500q-56.67 135-175.33 217.5Q626-200 480-200Zm0-300Zm-.11 233.33q118.44 0 217.61-63.5 99.17-63.5 151.17-169.83-52-106.33-151.06-169.83-99.05-63.5-217.5-63.5-118.44 0-217.61 63.5-99.17 63.5-151.83 169.83 52.66 106.33 151.72 169.83 99.05 63.5 217.5 63.5Z"/></svg></a>
                            <a href="delete_user.php?id=<?php echo $row['id_user']; ?>" class="btn-danger" onclick="return confirm('Are you sure you want to delete this user?');"><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#00000"><path d="M267.33-120q-27.5 0-47.08-19.58-19.58-19.59-19.58-47.09V-740H160v-66.67h192V-840h256v33.33h192V-740h-40.67v553.33q0 27-19.83 46.84Q719.67-120 692.67-120H267.33Zm425.34-620H267.33v553.33h425.34V-740Zm-328 469.33h66.66v-386h-66.66v386Zm164 0h66.66v-386h-66.66v386ZM267.33-740v553.33V-740Z"/></svg></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
        // Pagination
        $query = "SELECT COUNT(id_user) FROM user";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($result);
        $total_records = $row[0];
        $total_pages = ceil($total_records / $limit);
        ?>

        <nav class="pagination-nav">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li><a href="manage_user.php?page=<?php echo $i; ?>" class="<?php if ($page == $i) echo 'active'; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</body>
</html>