<?php 

include '../config.php';

error_reporting(0);

session_start();

// if (isset($_SESSION['username'])) {
//     header("Location: ../pages/index.php");
// }

if (isset($_POST['submit_signin'])) {
    $email = $_POST['email'];
    // $password = md5($_POST['password']); //eckripsi
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        if ($_SESSION['username'] == 'admin') {
            header("Location: ../pages/dashboard/index.html");
        } else {
            header("Location: ../pages/shop/index.php");
        }
        
    } else {
        echo "<script>alert('Email atau password Anda salah. Silahkan coba lagi!')</script>";
    }
}

if(isset($_POST['submit_register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    // $password = md5($_POST['password']); //enkripsi
    // $cpassword = md5($_POST['cpassword']); //enkripsi
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if($password == $cpassword) {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if(!$result->num_rows > 0) {
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username','$email','$password')";
            $result = mysqli_query($conn, $sql);
            if($result) {
                echo "<script>alert('Yeay, Registrasi berhasil!')</script>";
                $username = "";
                $email = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
            } else {
                echo "<script>alert('Oops! Terjadi Kesalahan.')</script>";
            }
        } else {
            echo "<script>alert('Oops! Email Sudah Terdaftar.')</script>";
        }
    } else {
        echo "<script>alert('Password Tidak Sesuai')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign In - Nio Furniture</title>
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/favicon.png">
    </head>
    <body>
        <div class="container">
            <div class="forms-container">
                <div class="signin-signup">
                    <form action="" method="POST" class="sign-in-form">
                        <h2 class="title">Sign In</h2>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-password"></i>
                            <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
                        </div>
                        <!-- <input type="submit" value="signin" class="btn solid" name="submit"> -->
                        <button name="submit_signin" class="btn">Sign In</button>
                    </form>

                    <form action="" method="POST" class="sign-up-form">
                        <h2 class="title">Sign Up</h2>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-password"></i>
                            <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-password"></i>
                            <input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
                        </div>
                        <!-- <input type="submit" value="signup" class="btn solid" name="submit_register"> -->
                        <button name="submit_register" class="btn">Register</button>
                    </form>
                </div>
            </div>
            <div class="panels-container">
                <div class="panels left-panel">
                    <div class="content">
                        <h3>New Here?</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus consequuntur tenetur quis libero labore deserunt exercitationem?</p>
                        <button class="btn transparent" id="sign-up-btn">Sign up</button>
                    </div>

                    <img src="../assets/img1-flipped.png" class="image" alt="">
                </div>

                <div class="panels right-panel">
                    <div class="content">
                        <h3>One of us?</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus consequuntur tenetur quis libero labore deserunt exercitationem?</p>
                        <button class="btn transparent" id="sign-in-btn">Sign in</button>
                    </div>

                    <img src="../assets/img1.png" class="image" alt="">
                </div>
            </div>
        </div>

        <script src="signin.js">

        </script>
    </body>
</html>