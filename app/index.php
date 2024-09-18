<?php
include '../database/koneksi.php';
include '../database/class/auth.php';

$pdo = koneksi::connect();
$auth = auth::makeObjek($pdo);

if (!$auth->isLoggedIn() && $auth->isLoggedIn() == false) {
    $login = isset($_GET['auth']) ? $_GET['auth'] : 'auth';
    switch ($login) {
        case 'login':
            include 'auth/login.php';
            break;
        case 'register':
            include 'auth/register.php';
            break;
        default:
            include 'auth/login.php';
            break;
    }
} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>
            PerpustakaanN
        </title>
        <?php
        include 'layout/stylecss.php';
        ?>
    </head>
    <?php
    include 'layout/sidebar.php';
    ?>

    <body class="g-sidenav-show  bg-gray-200">
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

            <?php
            include 'layout/navbar.php';
            ?>

            <?php
            $page = isset($_GET["page"]) ? $_GET["page"] : '';
            switch ($page) {
                case 'user':
                    include 'page/user/default.php';
                    break;
                default:
                    include 'page/dashboard/index.php';
                    break;
            }
            ?>
            <?php
            include 'layout/footer.php';
            ?>
        </main>

        <?php
        include 'layout/stylejs.php';
        ?>
    </body>

    </html>
<?php
}
?>