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
        Valid: <?= $valid ?><br>
        Protocol: <?= $protocol ?><br>
        Domain: <?= $domain ?>
    </p>

    <!-- <h4>Denna returnerar Json</h4>
    <form action="iptojson">
        <input type="text" name="ip" value="<?= $ip ?>">
        <input type="submit" value="check">
    </form>
    <p>
        Eller använd routen baseurl/htdocs/iptojson?ip= , istället för ipverifier
    </p> -->
</article>
