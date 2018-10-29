<h2>Dodavanje autora</h2>

<form action='<?= URL ?>books/addAuthorsSave/<?= $data['book_id'] ?>' method='post'>
    <?php
        $length = $data['new_authors_number'];
        for ($i = 1; $i <= $length; $i++) {
            ?>
                <p><b>Autor <?= $i ?></b></p>
                
                <label class='form_label'>Ime</label>
                <input type='text' name='author_name_<?= $i ?>' /><br />
                
                <label class='form_label'>Prezime</label>
                <input type='text' name='author_surname_<?= $i ?>' /><br /><br /> 
            <?php
        }
    ?>
    <input type='submit' value='Dodaj' /><br /><br />            
</form>
<?php