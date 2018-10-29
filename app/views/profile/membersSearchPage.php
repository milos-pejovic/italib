<h2>Pretraga &#269;lanova</h2>

<form action='<?= URL ?>profile/membersSearch' method='post'>
    <fieldset>
        <label class='form_label2'>
            <label class='form_label3'>Ime</label>
            <input type='text' name='first_name' />
        </label>

        <label class='form_label2'>
            <label class='form_label3'>Ime oca</label>
            <input type='text' name='fathers_name' />
        </label>

        <label class='form_label2'>
            <label class='form_label3'>Prezime</label>
            <input type='text' name='last_name' />
        </label>

        <hr />
        
        <label class='form_label2'>
            <label class='form_label3'>&#268;lanski broj</label>
            <input type='text' name='membership_number' />
        </label>

        <label class='form_label2'>
            <label class='form_label3'>Tip Korisnika</label>
            <select name='usertype'>
                <option value='librarian'>Bibliotekar</option>
                <option value='member'>&#268;lan</option>
                <option value='' selected='selected'>Bilo koji</option>
            </select>
        </label>

        <hr />

        <label class='form_label2'>
            <label class='form_label3'>E-mejl</label>
            <input type='text' name='email' />
        </label>

        <label class='form_label2'>
            <label class='form_label3'>Telefon</label>
            <input type='text' name='telephone' />
        </label>

        <hr />

        <label class='form_label2'>
            <label class='form_label3'>Ulica</label>
            <input type='text' name='street' />
        </label>

        <label class='form_label2'>
            <label class='form_label3'>Grad</label>
            <input type='text' name='city' />
        </label><br /><hr />

        <input type='submit' value='Pretraga' /><br />
    </fieldset>
</form>

<br />

<?php
    if ($data) {
        ?>
<table>
    <tr>
        <td>#</td>
        <td>&#268;lanski broj</td>
        <td>Ime</td>
        <td>Ime oca</td>
        <td>Prezime</td>
        <td>Tip korisnika</td>
        <td>E-mejl</td>
        <td>Telefon</td>
        <td>Adresa</td>
        <td>Grad</td>
        <td>Detalji</td>
    </tr>
    
    <?php
        $length = count($data);
        for ($i = 0; $i < $length; $i++) {
            ?>
                <tr>
                    <td><?= ($i + 1) ?></td>
                    <td><?= $data[$i]->membership_number ?></td>
                    <td><?= $data[$i]->first_name ?></td>
                    <td><?= $data[$i]->fathers_name ?></td>
                    <td><?= $data[$i]->last_name ?></td>
                    <td><?= $data[$i]->usertype ?></td>
                    <td><?= $data[$i]->email ?></td>
                    <td><?= $data[$i]->telephone ?></td>
                    <td><?= $data[$i]->address ?></td>
                    <td><?= $data[$i]->city ?></td>
                    <td><a href='<?= URL ?>profile/userDetails/<?= $data[$i]->id ?>'>Detalji</a></td>
                </tr>
            <?php   
        }
    ?>
    
</table>
        <?php
    }
?>