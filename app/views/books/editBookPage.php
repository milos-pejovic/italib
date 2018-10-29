<?php
    $udc = [
        'zero' => '0 nauka, znanje uopste',
        1 => '1 filozofija, psihologija',
        2 => '2 religija, teologija',
        3 => '3 drustvene nauke',
        5 => '5 matematika, prirodne nauke',
        6 => '6 primenjene nauke, medicina, tehnika',
        7 => '7 umetnost, rekreacija, zabava, sport',
        8 => '8 jezik, lingvistika, knjizevnost',
        9 => '9 geografija, biografije, istorija'
    ];
    
    $data['authors'] = explode(', ', $data['authors']);
    foreach ($data['authors'] as &$author) {
        $author = explode(' ', $author);
    }
?>
<h2>Izmena podataka knjige</h2>

<form action='<?= URL ?>books/editBookSave/<?= $data['book_id'] ?>' method='post'>
    
    <label class='form_label'>Naziv knjige</label>
    <input type='text' name='title' value='<?= $data ? $data['title'] : ''?>' /><br />
    
    <label class='form_label'>ISBN</label>
    <input type='text' name='ISBN' value='<?= $data ? $data['ISBN'] : ''?>' /><br />
    
    <label class='form_label'><span title='univerzalna decimalna klasifikacija'>UDK</span></label>
    <select name='UDC'>
        <?php
            foreach ($udc as $key => $value) {
                echo "<option value='$key' ";
                if ($data) {
                    if ($data['UDC'] == $key) {
                        echo "selected='selected'";
                    }
                }
                echo ">$value</option>";
            }
        ?>
    </select><br /><br />
    
    <input type='submit' value='Unesi izmene' /><br /><br />
</form>