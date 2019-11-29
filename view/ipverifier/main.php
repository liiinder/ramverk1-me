<?php

namespace Anax\View;

?>
<article>
    <h2>Verifiera en IP-address.</h2>
    <form>
        <input type="text" name="ip" value="<?= $ip ?>">
        <input type="submit" value="check">
    </form>
    <p>
        Protocol: <?= $protocol ?><br>
        Domain: <?= $domain ?><br>
        Latitude: <?= $lat ?><br>
        Longitude: <?= $lon ?><br>
        Country: <?= $country ?><br>
        City: <?= $city ?>
    </p>
</article>
