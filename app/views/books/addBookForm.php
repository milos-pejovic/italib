<h2>Unos knjige</h2>

<?php  
    unset($_SESSION['bookEntryError']); 
    $book_data = isset($_SESSION['newBookData']) ? $_SESSION['newBookData'] : '';

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
?>

<form action='<?= URL ?>books/addBook/<?= $data ?>' method='post'>
    
    <label class='form_label'>Naziv knjige</label>
    <input class='notEmpty' type='text' name='title' value='<?= $book_data ? $book_data['title'] : ''?>' /><br />
    
    <label class='form_label'>ISBN</label>
    <input class='notEmpty' type='text' name='ISBN' value='<?= $book_data ? $book_data['ISBN'] : ''?>' /><br />
    
    <label class='form_label'>Inventarni broj</label>
    <input class='notEmpty' type='number' name='inventory_number' min='1' value='<?= $book_data ? $book_data['inventory_number'] : ''?>' /><br />
    
    <label class='form_label'><span title='univerzalna decimalna klasifikacija'>UDK</span></label>
    <select name='UDC'>
        <?php
            foreach ($udc as $key => $value) {
                echo "<option value='$key' ";
                if ($book_data) {
                    if ($book_data['UDC'] == $key) {
                        echo "selected='selected'";
                    }
                }
                echo ">$value</option>";
            }
        ?>
    </select>
    
    <p class='mustFillIn'>Crveno ozna&#269;ena polja moraju biti popunjena.</p>
    
    <br /><br />
    
    <?php for ($i = 1; $i <= $data; $i++) {
    ?>
    <span>Autor <?= $i ?></span><br />
    
    <label class='form_label'>Ime</label>
    <input type='text' value='<?= $book_data ? $book_data['author_' . $i . 'name'] : ''?>' name='author_<?= $i ?>name' /><br />
    
    <label class='form_label'>Prezime</label>
    <input type='text' value='<?= $book_data ? $book_data['author_' . $i . 'surname'] : ''?>' name='author_<?= $i ?>surname' /><br /><br />
    
    <?php
    } ?>
    
    <input type='submit' value='Unesi' /><br /><br />
</form>