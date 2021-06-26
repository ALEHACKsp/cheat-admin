<?php
require '../controllers/globals.php';
include '../controllers/functions.php';

$UserCookie = Auth($_COOKIE['login'], $_COOKIE['password']);
if(!$UserCookie)
    return header('Location: https://google.com');

    $KeysRow = GetAllKeys();

    if(isset($_GET['type']))
    {
        if($_GET['type'] == "delete")
        {
            DeleteKey($_GET['key']);
            return header("Location: /admin/index.php");
        }

        if($_GET['type'] == "search")
        {
            $KeysRow = GetKeyData($_GET['key']);
        }
    }

?>

<html lang="en">

<?php include '../content/header.php';?>

<body class="antialiased">
<div class="wrapper">

<?php include '../content/navigation.php';?>

    <div class="content">
        <div class="container-xl">

            <div class="col-12">
                <div class="card card-sm">
                    <div class="card-body">
                        <form role="form" method="GET" action="/admin/index.php">
                            <div class="row g-2">
                                <div class="col">
                                    <input type="text" class="form-control" name="key" placeholder="Поиск ключа">
                                    <input type="hidden" class="form-control" name="type" value="search" placeholder="Поиск ключа">
                                </div>
                                <div class="col-auto">
                                    <button href="#" type="submit" class="btn btn-white btn-icon" aria-label="Button">Поиск ключа</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <br>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Все активированные ключи</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ключ</th>
                                <th>HWID</th>
                                <th>Срок подписки</th>
                                <th>Конец подписки</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if(!isset($_GET['type'])) { ?>
                                <?php foreach($KeysRow as $key2) { ?>
                                <tr>
                                    <?php if($key2['status'] == "actived"){?>
                                        <td style="font-size: 12px;">
                                            <?php  echo $key2['id']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $key2['key']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $key2['hwid']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo  $key2['time'] / 86400 ?> д.
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo date('Y-m-d H:i:s', $key2['endtime']); ?> д.
                                        </td>
                                        <td style="font-size: 12px;">
                                            <a href="/admin/editkey.php?key=<?php echo $key2['key']; ?>" class="badge bg-green-lt">Редактировать</a>
                                            <a href="/admin/logs.php?key=<?php echo $key2['key']; ?>" class="badge bg-blue-lt">Логи</a>
                                            <a href="/admin/index.php?type=delete&key=<?php echo $key2['id']; ?>" class="badge bg-red-lt">Удалить</a>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                                <?php } else  {?>
                                    <td style="font-size: 12px;">
                                            <?php  echo $KeysRow['id']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $KeysRow['key']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $KeysRow['hwid']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo  $KeysRow['time'] / 86400 ?> д.
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo date('Y-m-d H:i:s', $KeysRow['endtime']); ?> д.
                                        </td>
                                        <td style="font-size: 12px;">
                                            <a href="/admin/editkey.php?key=<?php echo $KeysRow['key']; ?>" class="badge bg-green-lt">Редактировать</a>
                                            <a href="/admin/logs.php?key=<?php echo $KeysRow['key']; ?>" class="badge bg-blue-lt">Логи</a>
                                            <a href="/admin/index.php?type=delete&key=<?php echo $KeysRow['id']; ?>" class="badge bg-red-lt">Удалить</a>
                                        </td>
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