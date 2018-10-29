<h2>Broj autora</h2>

<form action='<?= URL ?>books/processNumAuth' method='post'>
    <label class='form_label'>Koliko autora knjiga ima?</label>
    <input type='number' name='number_of_authors' value='1' min='1' />
    <br /><br />
    
    <input type='submit' value='Dalje' /><br /><br />
</form>
