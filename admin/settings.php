<?php
require '../controllers/globals.php';
include '../controllers/functions.php';

$UserCookie = Auth($_COOKIE['login'], $_COOKIE['password']);
if(!$UserCookie)
    return header('Location: https://google.com');

$CheatsRow = GetAllCheats();

if(isset($_GET['type']))
{
    if($_GET['type'] == "disable")
    {
        UpdateCheatStatus($_GET['id'], "disabled");
    }   

    if($_GET['type'] == "enable")
    {
        UpdateCheatStatus($_GET['id'], "enabled");
    }   

    if($_GET['type'] == "delete")
    {
        DeleteCheat($_GET['id']);
    }   

    if($_GET['type'] == "create")
    {
        CreateNewCheat($_GET['name']);
    }   


    return header("Location: /admin/settings.php");
}

?>

<html lang="en">

<?php include '../content/header.php';?>

<body class="antialiased">
<div class="wrapper">

<?php include '../content/navigation.php';?>

    <div class="content">
        <div class="container-xl">

        <div class="row row-cards">

            <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Добавить новый чит</h3>
                        </div>
                        <div class="card-body">
                        <form action="/admin/settings.php" method="GET">
                            <div class="mb-3">
                              <label class="form-label">Название чита</label>
                              <input type="text" name="name" class="form-control">
                              <input type="hidden" name="type" value="create">
                            </div>
                            <button type="submit" class="btn btn-primary ms-auto">Создать</button>
                        </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Мои читы</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($CheatsRow as $key) { ?>
                                <tr>
                                    <td style="font-size: 12px;">
                                        <?php  echo$key['id']; ?>
                                    </td>
                                    <td style="font-size: 12px;">
                                        <?php echo $key['name']; ?>
                                    </td>
                                    <td style="font-size: 12px;">
                                        <?php if($key['variable'] == "enabled") { ?>
                                            <span class="badge bg-green-lt">Включен</span>
                                        <?php } ?>
                                        <?php if($key['variable'] == "disabled") { ?>
                                            <span class="badge bg-red-lt">Выключен</span>
                                        <?php } ?>
                                    </td>
                                    <td style="font-size: 12px;">
                                        <?php if($key['variable'] == "enabled") { ?>
                                            <a href="/admin/settings.php?type=disable&id=<?php echo$key['id']; ?>" class="badge bg-red-lt">Отключить</a>
                                        <?php } ?>

                                        <?php if($key['variable'] == "disabled") { ?>
                                            <a href="/admin/settings.php?type=enable&id=<?php echo$key['id']; ?>" class="badge bg-green-lt">Включить</a>
                                        <?php } ?>

                                        <a href="/admin/settings.php?type=delete&id=<?php echo$key['id']; ?>" class="badge bg-orange-lt">Удалить</a>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php include '../content/footer.php';?>
    </div>
</div>
</body>
</html>