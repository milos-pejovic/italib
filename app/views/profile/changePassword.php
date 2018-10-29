<h2>Promena &#353;ifre</h2>

<form action='<?= URL ?>profile/saveNewPass/<?= $data ?>' method='post'>
    <label class='form_label'>Nova &#353;ifra</label>
    <input id='pass1' type='password' name='newPass1' /><br />
    
    <label class='form_label'>Potvrdite &#353;ifru</label>
    <input id='pass2' type='password' name='newPass2' /><br /><br />
    
    <input type='submit' value='Po&#353;alji' /><br /><br />
</form>