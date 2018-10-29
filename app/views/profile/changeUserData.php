<h2>Izmena podataka korisnika</h2>

<form action='<?= URL ?>profile/saveUserChanges/<?= $data['id'] ?>' method='post'>
    <label class='form_label'>Ime</label>
    <input type='text' name='first_name' value=<?= $data['first_name'] ?> /><br />
    
    <label class='form_label'>Ime oca</label>
    <input type='text' name='fathers_name' value='<?= $data['fathers_name'] ?>' /><br />
    
    <label class='form_label'>Prezime</label>
    <input type='text' name='last_name' value='<?= $data['last_name'] ?>' /><br />

    <label class='form_label'>Tip korisnika</label>
    <select name='usertype'>
        <option value='librarian' <?php if ($data['usertype'] == 'librarian') {echo "selected='selected'";} ?>>Bibliotekar</option>
        <option value='member' <?php if ($data['usertype'] == 'member') {echo "selected='selected'";} ?>>&#268;lan</option>
    </select><br /><br />

    <label class='form_label'>&#268;lanski broj</label>
    <input type='text' name='membership_number' value='<?= $data['membership_number'] ?>' /><br />

    <label class='form_label'>E-mejl</label>
    <input type='text' name='email' value='<?= $data['email'] ?>' /><br />
    
    <label class='form_label'>Telefon</label>
    <input type='text' name='telephone' value='<?= $data['telephone'] ?>' /><br /><br />
    
    <label class='form_label'>Ulica</label>
    <input type='text' name='street' value='<?= $data['street'] ?>' /><br />
    
    <label class='form_label'>Broj</label>
    <input type='text' name='number' value='<?= $data['number'] ?>' /><br />
    
    <label class='form_label'>Grad</label>
    <input type='text' name='city' value='<?= $data['city'] ?>' /><br /><br />
    
    <input type='submit' value='Unesi izmene' /><br /><br />
</form>