<?php
require '../controllers/globals.php';
include '../controllers/functions.php';

$UserCookie = Auth($_COOKIE['login'], $_COOKIE['password']);
if(!$UserCookie)
    return header('Location: https://google.com');

if(!isset($_GET['key']))
    $LogsRow = GetAllLogs();
else
    $LogsRow = GetAllLogsForSpecial($_GET['key']);

?>

<html lang="en">

<?php include '../content/header.php';?>

<body class="antialiased">
<div class="wrapper">

<?php include '../content/navigation.php';?>

    <div class="content">
        <div class="container-xl">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">История логов</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ключ</th>
                                <th>Префикс</th>
                                <th>Сообщение</th>
                                <th>IP</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($LogsRow as $key2) { ?>
                                <tr>
                                        <td style="font-size: 12px;">
                                            <?php  echo $key2['id']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $key2['key']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $key2['prefix']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo  $key2['message'] ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo  $key2['ip'] ?>
                                        </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <?php include '../content/footer.php';?>
    </div>
</div>
</body>
</html>