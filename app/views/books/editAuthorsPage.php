<h2>Izmena podataka o autorima</h2>

<p>Da izbri&#353;ete autora ostavite prazna polja za ime i prezime tog autora.</p>
<form action="<?= URL ?>books/saveAuthorChange/<?= $data['book_id'] ?>" method='post'>
    
<?php
    unset($data['book_id']);
    $length = count($data);
    for ($i = 0; $i < $length; $i++) {
        ?>
        <p>Autor <?= ($i + 1) ?></p>
        <input type='text' name='author_name_<?= ($i + 1) ?>' value='<?= $data[$i]->author_name ?>' /><br />
        <input type='text' name='author_surname_<?= ($i + 1) ?>' value='<?= $data[$i]->author_surname ?>' /><br />
        <?php
    }
?>
    
    <br /><br />
    <input type='submit' value='Unesi izmene' /><br /><br />
</form>