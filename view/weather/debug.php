<?php

namespace Anax\View;

?>
<hr>
<pre>
<?php
foreach ($res as $e) {
    echo $e["daily"]["data"][0]["date"] . " - " .
        $e["daily"]["data"][0]["summary"] .
        " Temp: " . $e["daily"]["data"][0]["temperatureMin"] .
        "&#8451 - " . $e["daily"]["data"][0]["temperatureMax"] . "&#8451<br>";
}
?>
RES
<?= var_dump($res) ?>
SESSION
<?= var_dump($_SESSION) ?>
POST
<?= var_dump($_POST) ?>
GET
<?= var_dump($_GET) ?>
SERVER
<?= var_dump($_SERVER) ?>
</PRE>
<hr>
