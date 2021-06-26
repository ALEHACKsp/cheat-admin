<?php
    require_once 'controllers/globals.php';
    include_once 'controllers/functions.php';

    $UserCookie = Auth($_COOKIE['login'], $_COOKIE['password']);
    if($UserCookie)
         return header('Location: /admin/index.php');

    if(isset($_POST['login']) && isset($_POST['password'])) {
        $User = Auth($_POST['login'], $_POST['password']);

        if($User) {
            setcookie('login', $_POST['login'], time() + 24 * 60 * 60, "/");
            setcookie('password', $_POST['password'], time() + 24 * 60 * 60, "/");
            return header('Location: /admin/index.php');
        }
    }
?>

<html lang="en">

<?php include 'content/header.php';?>

    <body class="antialiased border-top-wide border-primary d-flex flex-column">
        <div class="page page-center" style="justify-content: center;">
            <div class="container-tight py-4">
                <form class="card card-md" action="." method="POST" autocomplete="off">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Авторизация</h2>

                        <div class="mb-3">
                            <label class="form-label">
                                Логин
                            </label>
                            <input type="text" class="form-control" name="login" autocomplete="off" placeholder="Ваш логин">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Пароль
                            </label>
                            <div class="input-group input-group-flat">
                                <input name="password" class="form-control" placeholder="Ваш пароль" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Авторизоваться</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>