<?php
$db = new SQLite3('writable/scoring.sqlite');
$db->exec("UPDATE panahan_shot SET display_value='-' WHERE display_value='0'");
echo "Fixed display_value!";
