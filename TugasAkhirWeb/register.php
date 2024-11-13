<?php
// register.php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
    if (mysqli_query($conn, $query)) {
        header('Location: login.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- <a href="css/style.css"></a> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="css/register.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar">
        <div class="logo">
            <img src="img/logo.png" alt="EnsikloVadya Logo">
            <span class="logo-text">EnsikloVadya</span>
        </div>
        <div class="nav-buttons">
            <a href="index.php" class="nav-link">Homepage</a>
            <a href="#" class="nav-link">Quiz</a>
            <a href="login.php" class="button login-btn">Login</a>
            <a href="register.php" class="button register-btn">Registrasi</a>
        </div>
    </nav>

    <main class="main-content">
        <section class="info-section">
            <h1>EnsikloVadya</h1>
            <p>Ensiklovadya adalah platform digital yang menghadirkan informasi lengkap dan mendalam mengenai berbagai jenis musik tradisional dari seluruh pelosok Indonesia. Kami menyajikan pengetahuan yang komprehensif tentang alat musik khas, genre, tarian, lagu, komposer, serta sejarah dan budaya yang melatarbelakangi musik daerah.</p>
        </section>

        <section class="login-section">
            <div class="login-container">
                <h2>Registrasi</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Email</label>
                        <input type="email" id="email" name="email" placeholder="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="login-submit">Registrasi</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        © Copyright By Backbone
    </footer>

    <script src="js/sc"></script>
</body>
</html>