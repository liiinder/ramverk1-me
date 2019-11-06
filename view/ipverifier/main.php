<?php

namespace Anax\View;

?>
<article>
    <h2>Kolla om en input är en verifierad IP-address.</h2>
    <form class="game">
        <input type="text" name="ip" value="<?= $ip ?>">
        <input type="submit" value="check">
    </form>
    <p><?= ($ip != "") ? $res : "" ?></p>
</article>
