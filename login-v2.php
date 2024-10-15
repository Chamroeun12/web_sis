<?php
//User Login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Establish database connection with PDO
include 'connection.php';
// Pre-fill username and password if cookies are set
$username_value = isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : '';
$password_value = isset($_COOKIE['password']) ? htmlspecialchars($_COOKIE['password']) : '';

if (isset($_POST['username']) && isset($_POST['password'])) {
    // function test_input($data)
    // {
    //     $data = trim($data);
    //     $data = stripslashes($data);
    //     $data = htmlspecialchars($data);
    //     return $data;
    // }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if ($remember) {
        // setcookie('username', $username, time() + (86400 * 30), "/"); // 30 days
        // setcookie('password', $password, time() + (86400 * 30), "/"); // 30 days
        if (!isset($_COOKIE[$username])) {
            setcookie($username, $password, time() + (86400 * 30), "/");
        }
    }

    if (empty($username)) {
        header("Location: login-v2.php?error=User Name is Required");
    } else if (empty($password)) {
        header("Location: login-v2.php?error=Password is Required");
    } else {
        // WHERE Username=:uname AND Password=:pwd 
        // Hashing the password
        // $password = md5($password);
        $sql = $conn->prepare("SELECT * FROM tb_login");
        // $sql->bindParam(":uname", $_POST['username'], PDO::PARAM_STR);
        // $sql->bindParam(":pwd", $_POST['password'], PDO::PARAM_STR);
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($data);
        // session_start();
        if ($data) {
            if ($data['Username'] && $data['Password'] && $data['Role']) {
                $_SESSION['login'] = "Login Succesfully!";
                $_SESSION["user"] = $data["Username"];
                $_SESSION["id"] = $data["id"];
                $_SESSION["role"] = $data["Role"];
            }
            echo '
              <script>
                setTimeout(function() {
                  window.location.href = "index.php";
                }, 200);
              </script>';
            //sesion success
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Get cookie -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Check if there's a username cookie
            const usernameCookie = getCookie('username');
            const passwordCookie = getCookie('password');

            if (usernameCookie) {
                $('#username').val(usernameCookie);
            }

            $('#username').on('input', function() {
                if ($(this).val() === usernameCookie) {
                    $('#password').val(passwordCookie);
                } else {
                    $('#password').val(''); // Clear password if username doesn't match
                }
            });

            function getCookie(name) {
                let cookieArr = document.cookie.split(";");
                for (let i = 0; i < cookieArr.length; i++) {
                    let cookiePair = cookieArr[i].split("=");
                    if (name === cookiePair[0].trim()) {
                        return decodeURIComponent(cookiePair[1]);
                    }
                }
                return null;
            }
        });
    </script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-header text-center">
                <img src="images/SiSlogo.png" alt="" class="profile-user-img">
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <input type="hidden" name="role" value="">
                    <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_GET['error'] ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($data['Username']) && isset($data['Password'])) {  ?>
                        <div class="alert alert-success" role="alert">
                            <?= $_SESSION['login'] ?>
                        </div>
                    <?php } ?>
                    <!-- <button type="button" class="btn btn-success toastsDefaultSuccess">
                        Launch Success Toast
                    </button> -->

                    <div class="input-group mb-3">
                        <input type="text" id="username" class="form-control" name="username" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember"
                                    <?= isset($_COOKIE['username']) ? 'checked' : '' ?>>
                                <label for="remember">
                                    <p>Remember Me</p>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="mt-4 d-flex justify-content-center">
                        <button type="submit" class="btn text-white px-4"
                            style="background-color: #152550;">Login</button>
                    </div>
                    <!-- /.col -->
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>


    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            $('.toastsDefaultSuccess').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
        });
    </script>

    <!-- Cookie -->
    <script>
        $(document).ready(function() {
            $("#username").keyup(function() {
                function getCookie(cookieName) {
                    let cookie = {};
                    document.cookie.split(';').forEach(function(el) {
                        let [key, value] = el.split('=');
                        cookie[key.trim()] = value;
                    })
                    return cookie[cookieName];
                }
                let u = $(this).val();
                if (u !== undefined) {
                    $("#password").val(getCookie(u));
                }
            });
        });
    </script>
</body>

</html>