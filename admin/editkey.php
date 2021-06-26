<?php
require '../controllers/globals.php';
include '../controllers/functions.php';

$UserCookie = Auth($_COOKIE['login'], $_COOKIE['password']);
if(!$UserCookie)
     return header('Location: https://google.com');

$KeysRow = GetKeyData($_GET['key']);

if(isset($_GET['type']))
{
    if($_GET['type'] == "update")
    {
        UpdateKey($_GET['key'], $_GET['status'], $_GET['time'],$_GET['hwid']);
    }

    return header("Location: /admin/editkey.php?key=".$_GET['key']);
}

?>

<html lang="en">

<?php include '../content/header.php';?>

<body class="antialiased">
<div class="wrapper">

<?php include '../content/navigation.php';?>

<div class="content">
        <div class="container-tight py-4">

            <div class="row row-cards">

                <div class="col-md-12">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Редактирование ключа</h3>
                            </div>
                            <div class="card-body">
                            <form action="/admin/editkey.php" method="GET">
                            <div class="mb-3">
                              <label class="form-label">Конец подписки (<a href="https://www.epochconverter.com/">timestamp</a>)</label>
                              <input type="text"  value="<?php echo $KeysRow['endtime'] ?>" name="time" class="form-control">
                            </div>

                            <input type="hidden"  value="<?php echo $_GET['key'] ?>" name="key" class="form-control">
                            <input type="hidden"  value="update" name="type" class="form-control">

                            <div class="mb-3">
                              <label class="form-label">HWID</label>
                              <input type="text" value="<?php echo $KeysRow['hwid'] ?>" name="hwid" class="form-control">
                            </div>

                            <div class="form-group mb-3 ">
                                <label class="form-label">Статус</label>
                                <select class="form-select" name="status">
                                <option <?php if($KeysRow['status'] == "waiting") echo "selected"; ?> value="waiting">Не активирован</option>
                                <option <?php if($KeysRow['status'] == "actived") echo "selected"; ?> value="actived">Активирован</option>
                                <option <?php if($KeysRow['status'] == "banned") echo "selected"; ?>value="banned">Забанен</option>
                                </select>
                            </div>

                                <input type="submit" value="Обновить данные" value="Сохранить" class="btn btn-primary w-100"></input>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
</body>
</html>