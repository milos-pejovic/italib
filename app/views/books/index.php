<h2>Pretraga knjiga</h2>

<?php
    $err = Session::get('errors');
    if (isset($err['bookSearchError']) && $err['bookSearchError']) {
        echo '<span style="color:red">Morate popuniti bar jedno polje.</span><br /><br />';
    }
?>

<form action='<?= URL ?>books/bookSearch' method='post'>
    <label class='form_label'>Naziv</label>
    <input type='text' name='title' /><br />
    
    <label class='form_label'>ISBN</label>
    <input type='text' name='ISBN' /><br />
    
    <label class='form_label'>UDK</label>
    <select name='UDC'>
        <option value='' selected='selected'>Bilo koja oblast</option>
        <option value='zero'>0 nauka, znanje uopste</option>
        <option value='1'>1 filozofija, psihologija</option>
        <option value='2'>2 religija, teologija</option>
        <option value='3'>3 drustvene nauke</option>
        <option value='5'>5 matematika, prirodne nauke</option>
        <option value='6'>6 primenjene nauke, medicina, tehnika</option>
        <option value='7'>7 umetnost, rekreacija, zabava, sport</option>
        <option value='8'>8 jezik, lingvistika, knjizevnost</option>
        <option value='9'>9 geografija, biografije, istorija</option>
    </select>
    <br /><br />
    
    <label>Unesite imena jednog ili vi&#353;e autora.</label><br />
    <textarea cols='50' name='authors_names' /></textarea>
    <br /><br />
    
    <label>Unesite prezimena jednog ili vi&#353;e autora.</label><br />
    <textarea cols='50' name='authors_surnames' /></textarea>
    <br /><br />
    
    <input type='submit' value='Pretra&#382;i' />
    
    <?php
        if ($data) {
            echo '<br /><hr />';
            echo '<table>';
            echo '<tr>'
                    . '<td>Knjiga</td>'
                    . '<td>ISBN</td>'
                    . '<td>UDK</td>'
                    . '<td>Broj<br />kopija</td>'
                    . '<td>Slobodnih<br />kopija</td>'
                    . '<td>Autor(i)</td>';
            
                    if (Session::get('usertype') == 'librarian') {
                        echo '<td>Pregled kopija</td>';
                        echo '<td colspan="3">Izmena podataka</td>';
                    }
            
            echo '</tr>';

            foreach ($data as $row) {
                $row['UDC'] = ($row['UDC'] == 0) ? '0' : $row['UDC'];
                echo '<tr>'
                    . '<td>' . $row['title'] . '</td>'
                    . '<td>' . $row['ISBN'] . '</td>'
                    . '<td>' . $row['UDC'] . '</td>'
                    . '<td>' . $row['numberOfCopies'] . '</td>'
                    . '<td>' . $row['availableCopies'] . '</td>'
                    . '<td>' . $row['authors'] . '</td>';
                
                    if (Session::get('usertype') == 'librarian') {
                        echo '<td><a href="' . URL . 'books/copies/' . $row['book_id'] . '/' . $row['title'] . '">Kopije</a></td>';
                        echo '<td colspan="1"><a href="' . URL . 'books/editBookPage/' . $row['book_id'] . '">Podaci o<br /> knjizi</a></td>';
                        echo '<td colspan="1"><a href="'.URL.'books/editAuthorsPage/'.$row['book_id'].'/'.$row['title'].'">Izmeni<br /> autore</a></td>';
                        echo '<td colspan="1"><a href="'.URL.'books/addAuthorsNumber/'.$row['book_id'].'">Dodaj<br /> autore</a></td>';
                    }
                    
                echo '</tr>';
            }
        
            echo '</table>';
        }    
    ?>
    
    <br /><br />
</form>