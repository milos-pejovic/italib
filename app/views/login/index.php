<h2>Prijava</h2>

<?php
    if (Session::get('loggingError') === true) {
        echo '<span style="color:red">Greska u prijavljivanju.<br />Molimo, pokusajte ponovo</span><br /><br />';
    }
?>

<form action='<?= URL ?>login/checkIdentity' method='post'>
    Unesite &#353;ifru<br />
    <input type='password' name='password' /><br /><br />
    <input type='submit' value='Prijava' /><br /><br />
</form>