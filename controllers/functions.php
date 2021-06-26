<?php

// SECURE

function FixString($string){
    global $db;

    $string = htmlspecialchars(mysqli_escape_string($db, $string));

    return $string;
}

// ADMIN

function Auth($login, $password)
{
    global $db;

    $login = FixString($login);
    $password = FixString($password);

    $query = "SELECT * FROM `users` WHERE `login` = '{$login}' and `password` = '{$password}' LIMIT 1";

    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    if($row != null){return $row;}
    if($row == null){return false;}
}

// CHEATS

function GetAllCheats(){
    global $db;

    $query = "SELECT * FROM `cheats` WHERE 1";

    $result = mysqli_query($db, $query);
    
    while($row = mysqli_fetch_assoc($result)){
        $array[] = $row;
    }
    return $array;
}

function GetCheatVariable($name){
    global $db;

    $name = FixString($name);

    $query = "SELECT `variable` FROM `settings` WHERE `name` = '{$name}' LIMIT 1";

    $result = mysqli_query($db, $query);
    
    $row = mysqli_fetch_assoc($result);

    if($row == null)
        return false;

    return $row['variable'];
}

function UpdateCheatStatus($id, $value){
    global $db;

    $id = FixString($id);
    $value = FixString($value);

    $query = "UPDATE `cheats` SET `variable` = '{$value}' WHERE `id` = '{$id}' ";

    mysqli_query($db, $query);

    return;
}

function CreateNewCheat($name)
{
    global $db;

    $name = FixString($name);

    $query = "INSERT INTO `cheats` (`name`, `variable`) VALUES ('{$name}', 'enabled')";

    mysqli_query($db, $query);

    return;
}

function DeleteCheat($id){
    global $db;

    $id = FixString($id);

    $query = "DELETE FROM `cheats` WHERE `id` = '{$id}' ";

    mysqli_query($db, $query);

    return;
}

// KEYS

function GetAllKeys(){
    global $db;

    $query = "SELECT * FROM `keys` WHERE 1";

    $result = mysqli_query($db, $query);
    
    while($row = mysqli_fetch_assoc($result)){
        $array[] = $row;
    }
    return $array;
}

function CreateNewKey($key,$time, $cheat)
{
    global $db;

    $key = FixString($key);
    $time = FixString($time);
    $cheat = FixString($cheat);

    $query = "INSERT INTO `keys` (`key`, `time`, `cheatid`) VALUES ('{$key}', '{$time}', '{$cheat}')";

    mysqli_query($db, $query);

    return;
}

function GetKeyData($id){
    global $db;
    
    $id_secure = FixString($id);

    $query = "SELECT * FROM `keys` WHERE `key` = '{$id_secure}'";
    
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    if($row != null){return $row;}
    if($row == null){return false;}
}

function RegisterKey($keycode, $time, $hwid){
    global $db;

    $keycode_secure = FixString($keycode);
    $endtime_secure = FixString($time);
    $hwid_secure = FixString($hwid);
    $current_time = time();

    $query = "UPDATE `keys` SET `status`= 'actived', `endtime`= '{$endtime_secure}', `hwid`= '{$hwid_secure}' WHERE `key` = '{$keycode_secure}' LIMIT 1";

    return mysqli_query($db, $query);
}

function ExpireKey($keycode){
    global $db;

    $keycode_secure = FixString($keycode);

    $query = "UPDATE `keys` SET `endtime`= '1000' WHERE `keycode` = '{$keycode_secure}' LIMIT 1";

    return mysqli_query($db, $query);
}

function RegisterHWID($keycode, $hwid){
    global $db;

    $keycode_secure = FixString($keycode);
    $hwid_secure = FixString($hwid);

    $query = "UPDATE `keys` SET `hwid`= '{$hwid_secure}' WHERE `key` = '{$keycode_secure}'";

    return mysqli_query($db, $query);
}

function CreateLog($keycode, $message, $tag){
    global $db;

    $keycode_secure = FixString($keycode);
    $message_secure = FixString($message);
    $tag_secure = FixString($tag);
    $ip = $_SERVER['REMOTE_ADDR']; 

    $query = "INSERT INTO `logs` (`ip`,`key`, `message`, `prefix` ) VALUES ('{$ip}', '{$keycode_secure}', '{$message_secure}' , '{$tag_secure}')";

    return mysqli_query($db, $query);
}

function GetAllLogs(){
    global $db;

    $query = "SELECT * FROM `logs` WHERE 1";

    $result = mysqli_query($db, $query);
    
    while($row = mysqli_fetch_assoc($result)){
        $array[] = $row;
    }
    return $array;
}


function GetAllLogsForSpecial($key){
    global $db;

    $key = FixString($key);

    $query = "SELECT * FROM `logs` WHERE `key` = '{$key}'";

    $result = mysqli_query($db, $query);
    
    while($row = mysqli_fetch_assoc($result)){
        $array[] = $row;
    }
    return $array;
}

function DeleteKey($id){
    global $db;

    $id = FixString($id);

    $query = "DELETE FROM `keys` WHERE `id` = '{$id}' ";

    mysqli_query($db, $query);

    return;
}

function UpdateKey($keycode,$status, $time, $hwid){
    global $db;

    $keycode_secure = FixString($keycode);
    $endtime_secure = FixString($time);
    $hwid_secure = FixString($hwid);

    $query = "UPDATE `keys` SET `status`= '{$status}', `endtime`= '{$endtime_secure}', `hwid`= '{$hwid_secure}' WHERE `key` = '{$keycode_secure}' LIMIT 1";

    return mysqli_query($db, $query);
}
