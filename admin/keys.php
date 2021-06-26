<?php
require '../controllers/globals.php';
include '../controllers/functions.php';

$UserCookie = Auth($_COOKIE['login'], $_COOKIE['password']);
if(!$UserCookie)
    return header('Location: https://google.com');

$CheatsRow = GetAllCheats();
$KeysRow = GetAllKeys();

if(isset($_GET['type']))
{
    if($_GET['type'] == "create")
    {
        for($i = 0; $i < intval($_GET['amount']); $i++)
        {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            CreateNewKey(substr(str_shuffle($permitted_chars), 0, 32), $_GET['time'] * 86400, $_GET['cheat']);
        }
    }

    return header("Location: /admin/keys.php");
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
                            <h3 class="card-title">Создать новые ключи</h3>
                        </div>
                        <div class="card-body">
                        <form action="/admin/keys.php" method="GET">
                            <div class="mb-3">
                              <label class="form-label">Кол-во ключей</label>
                              <input type="text" name="amount" class="form-control">
                              <input type="hidden" name="type" value="create" class="form-control">
                            </div>

                            <div class="form-group mb-3 ">
                                <label class="form-label">Ключи для</label>
                                <select class="form-select" name="cheat">
                                <?php foreach($CheatsRow as $key) { ?>
                                    <option value="<?php echo $key['id']; ?>"><?php echo $key['name']; ?></option>
                                <?php } ?>
                                </select>
                            </div>

                            <div class="mb-3">
                              <label class="form-label">Срок действия в днях</label>
                              <input type="text" name="time" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary ms-auto">Создать</button>
                        </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Неактивированные ключи</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ключ</th>
                                    <th>Время</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($KeysRow as $key2) { ?>
                                <tr>
                                    <?php if($key2['status'] == "waiting"){?>
                                        <td style="font-size: 12px;">
                                            <?php  echo $key2['id']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $key2['key']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $key2['time'] / 86400; ?> д.
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php if($key2['status'] == "waiting") { ?>
                                                <span class="badge bg-green-lt">Ждет активации</span>
                                            <?php } ?>
                                        </td>
                                        
                                        <td style="font-size: 12px;">
                                            <span class="badge bg-red-lt">Удалить</span>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Неактивированные ключи</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3 ">
                                <textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Content..">
                                <?php foreach($KeysRow as $key2) 
                                      {
                                        echo $key2['key'];
                                        echo " - ";
                                        echo $key2['time'] / 86400;
                                        echo "д.";
                                        echo "\n";
                                      } 
                                ?>
                                </textarea>
                            </div>
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