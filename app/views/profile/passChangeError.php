<h2>Gre&#353;ka u promeni &#353;ifre</h2>
<p><?= Session::get('passwordChangeError'); ?></p>

<?php unset($_SESSION['passwordChangeError']) ?>

<a href='<?= URL ?>profile/changePassword/<?= Session::get('id') ?>'>Nazad</a><br /><br />
