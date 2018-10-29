<h2>Dodavanje autora</h2>

<?php
    $book_id = $data;
?>

<form action='<?= URL ?>books/addAuthors' method='post'>
    <p>Koliko autora &#382;elite da dodate?</p>
    <input name='new_authors_number' value='1' type='number' min='1' /><br /><br />
    <input type='text' name='book_id' value='<?= $book_id ?>' style='display:none'/>
    <input type='submit' value='Dalje' /><br /><br />
</form>