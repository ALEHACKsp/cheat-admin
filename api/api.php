<?php

    require '../controllers/globals.php';
    include '../controllers/functions.php';

    if (!isset($_POST[ "type" ]))
    die();

    if($_POST["type"] == "auth")
	{
        if (!isset($_POST[ "key" ]) || !isset($_POST[ "hwid" ]))
			die();

        $KEYDATA = GetKeyData($_POST["key"]);

        if(!$KEYDATA)
		{
			echo("{");
			echo("\"Status\"".":"."\"WrongKey\"");
			echo("}");

			die();
		}

        if($KEYDATA["status"] == "waiting")
		{
			$endtime = time() + $KEYDATA["time"];
			RegisterKey($_POST[ "key" ], $endtime, $_POST["hwid"]);

			$KEYDATA = GetKeyData($_POST["key"]);

			echo("{");
			echo("\"Status\"".":"."\"Activated\"".",");
			echo("\"HWID\"".":"."\"".$_POST[ "hwid" ]."\"".",");
			echo("\"License\"".":"."\"".$_POST[ "key" ]."\"".",");
			echo("\"LicenseTime\"".":"."\"".($KEYDATA[ "time" ]/86400)."\"".",");
			echo("\"SubEndTime\"".":"."\"".$KEYDATA[ "endtime" ]."\"".",");
            echo("\"SubEndTimeHuman\"".":"."\"".date('d/m/Y H:i:s', $KEYDATA[ "endtime" ])."\"".",");
            echo("\"CheatID\"".":"."\"".$KEYDATA[ "cheatid" ]."\"");
			echo("}");

			die();
		}
		else if($KEYDATA["status"] == "banned")
		{
			$endtime = time() + $KEYDATA["time"];
			RegisterKey($_POST[ "key" ], $endtime, $_POST["hwid"]);

			$KEYDATA = GetKeyData($_POST["key"]);

			echo("{");
			echo("\"Status\"".":"."\"Banned\"".",");
			echo("\"HWID\"".":"."\"".$_POST[ "hwid" ]."\"".",");
			echo("\"License\"".":"."\"".$_POST[ "key" ]."\"".",");
			echo("\"LicenseTime\"".":"."\"".($KEYDATA[ "time" ]/86400)."\"".",");
			echo("\"SubEndTime\"".":"."\"".$KEYDATA[ "endtime" ]."\"".",");
            echo("\"SubEndTimeHuman\"".":"."\"".date('d/m/Y H:i:s', $KEYDATA[ "endtime" ])."\"".",");
            echo("\"CheatID\"".":"."\"".$KEYDATA[ "cheatid" ]."\"");
			echo("}");

			die();
		}
		else
		{
			if($KEYDATA["hwid"] == NULL)
			{
				RegisterHWID($_POST[ "key" ], $_POST["hwid"]);
			}

			$KEYDATA = GetKeyData($_POST["key"]);

			if($KEYDATA["hwid"] != $_POST[ "hwid" ])
			{
				echo("{");
					echo("\"Status\"".":"."\"WrongHWID\"".",");
					echo("\"License\"".":"."\"".$_POST[ "key" ]."\"".",");
                    echo("\"CheatID\"".":"."\"".$KEYDATA[ "cheatid" ]."\"");
				echo("}");
				
				die();
			}

			if($KEYDATA["endtime"] <= time())
			{
				echo("{");
					echo("\"Status\"".":"."\"SubEnded\"".",");
					echo("\"License\"".":"."\"".$_POST[ "key" ]."\"".",");
					echo("\"LicenseTime\"".":"."\"".($KEYDATA[ "time" ]/86400)."\"".",");
					echo("\"SubEndTime\"".":"."\"".$KEYDATA[ "endtime" ]."\"".",");
                    echo("\"SubEndTimeHuman\"".":"."\"".date('d/m/Y H:i:s', $KEYDATA[ "endtime" ])."\"".",");
                    echo("\"CheatID\"".":"."\"".$KEYDATA[ "cheatid" ]."\"");
				echo("}");
				
				die();
			}

			if($KEYDATA["hwid"] == $_POST[ "hwid" ] && $KEYDATA["endtime"] >= time())
			{
				echo("{");
					echo("\"Status\"".":"."\"Authorized\"".",");
					echo("\"HWID\"".":"."\"".$_POST[ "hwid" ]."\"".",");
					echo("\"License\"".":"."\"".$_POST[ "key" ]."\"".",");
					echo("\"LicenseTime\"".":"."\"".($KEYDATA[ "time" ]/86400)."\"".",");
					echo("\"SubEndTime\"".":"."\"".$KEYDATA[ "endtime" ]."\"".",");
                    echo("\"SubEndTimeHuman\"".":"."\"".date('d/m/Y H:i:s', $KEYDATA[ "endtime" ])."\"".",");
                    echo("\"CheatID\"".":"."\"".$KEYDATA[ "cheatid" ]."\"");
				echo("}");

				die();
			}
		}
    }
    else if($_POST["type"] == "log")
	{
		if (!isset($_POST[ "key" ]) || !isset($_POST[ "message" ]) || !isset($_POST[ "prefix" ]))
			die();

		$KEYDATA = GetKeyData($_POST["key"]);

		if(!$KEYDATA)
		{
			echo("{");
			echo("\"Status\"".":"."\"WrongKey\"");
			echo("}");

			die();
		}

		CreateLog($_POST["key"], $_POST["message"], $_POST["prefix"]);

		echo("{");
		echo("\"Status\"".":"."\"Success\"");
		echo("}");

        die();
	}
	else if($_POST["type"] == "file")
	{
		if (!isset($_POST[ "filetype" ]) || !isset($_POST[ "key" ]) || !isset($_POST[ "hwid" ]))
			die();

		$KEYDATA = GetKeyData($_POST["key"]);

		if(!$KEYDATA)
		{
			echo("{");
			echo("\"Status\"".":"."\"WrongKey\"");
			echo("}");

			die();
		}

		if($KEYDATA["endtime"] <= time())
		{
			echo("{");
				echo("\"Status\"".":"."\"SubEnded\"".",");
				echo("\"License\"".":"."\"".$_POST[ "key" ]."\"".",");
				echo("\"LicenseTime\"".":"."\"".($KEYDATA[ "time" ]/86400)."\"".",");
				echo("\"SubEndTime\"".":"."\"".$KEYDATA[ "endtime" ]."\"".",");
				echo("\"SubEndTimeHuman\"".":"."\"".date('d/m/Y H:i:s', $KEYDATA[ "endtime" ])."\"".",");
				echo("\"CheatID\"".":"."\"".$KEYDATA[ "cheatid" ]."\"");
			echo("}");
			
			die();
		}

		if($KEYDATA["hwid"] == $_POST[ "hwid" ] && $KEYDATA["endtime"] >= time())
		{
			if($_POST['filetype'] == "dll")
				file_get_contents("../files/dll.dll");
			else if ($_POST['filetype'] == "driver1.sys")
				file_get_contents("../files/driver1.sys");
			else if ($_POST['filetype'] == "driver2.sys")
				file_get_contents("../files/driver2.sys");
			else if ($_POST['filetype'] == "exe")
				file_get_contents("../files/exe.exe");
		}

        die();
	}