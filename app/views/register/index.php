<h2>Unos &#269;lana</h2>

<form action='<?= URL ?>register/registerUser' method='post'>
    <label class='form_label'>Ime</label>
    <input class='notEmpty' type='text' name='first_name' /><br />
    
    <label class='form_label'>Ime oca</label>
    <input type='text' name='fathers_name' /><br />
    
    <label class='form_label'>Prezime</label>
    <input class='notEmpty' type='text' name='last_name' /><br />
 
    <label class='form_label'>Tip Korisnika</label>
    <select name='usertype'>
        <option value='librarian'>Bibliotekar</option>
        <option value='member' selected='selected'>&#268;lan</option>
    </select><br /><br />
    
    <label class='form_label'>&#352;ifra</label>
    <input class='notEmpty' id='pass1' type='password' name='password1' /><br />
    
    <label class='form_label'>Potvrdite &#353;ifru</label>
    <input class='notEmpty' id='pass2' type='password' name='password2' /><br /><br />
    
    <label class='form_label'>&#268;lanski broj</label>
    <input class='notEmpty' id='memNum' type='text' name='membership_number' /><br />
    
    <label class='form_label'>E-mejl</label>
    <input type='text' name='email' /><br />
    
    <label class='form_label'>Telefon</label>
    <input type='text' name='telephone' /><br /><br />
    
    <label class='form_label'>Ulica</label>
    <input type='text' name='street' /><br />
    
    <label class='form_label'>Broj</label>
    <input type='text' name='number' /><br />
    
    <label class='form_label'>Grad</label>
    <input type='text' name='city' /><br /><br />
    
    <p class='mustFillIn emptyFields'>Crveno ozna&#269;ena polja moraju biti popunjena.</p>
    <p class='mustFillIn diffPass'>Unosi za &#353;ifru moraju biti identi&#269;ni<br /> (uklju&#269;uju&#263;i velika i mala slova).</p>
    <p class='mustFillIn shortPass'>&#352;ifra mora imati bar pet karaktera.</p>
    <p class='mustFillIn badMemNum'>&#268;lanski broj mora imati ta&#269;no sedam cifara.</p>
    
    <input type='submit' value='Unesi' /><br /><br />
</form>