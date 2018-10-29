<h2>Profil</h2>

<table>
    <tr>
        <td>&#268;lanski broj</td>
        <td><?= $data['membership_number'] ?></td>
    </tr>
    
    <tr>
        <td>Ime</td>
        <td><?= $data['first_name'] ?></td>
    </tr>
    
    <tr>
        <td>Ime oca</td>
        <td><?= $data['fathers_name'] ?></td>
    </tr>
    
    <tr>
        <td>Prezime</td>
        <td><?= $data['last_name'] ?></td>
    </tr>

    <tr>
        <td>Tip korisnika</td>
        <td>
            <?php
                switch ($data['usertype']) {
                    case 'member':
                        echo '&#269;lan';
                    break;

                    case 'librarian':
                        echo 'bibliotekar';
                    break;
                }
            ?>
        </td>
    </tr>

    <tr>
        <td>E-mejl</td>
        <td><?= $data['email'] ?></td>
    </tr>
    
    <tr>
        <td>Telefon</td>
        <td><?= $data['telephone'] ?></td>
    </tr>

    <tr>
        <td>Ulica</td>
        <td><?= $data['street'] . ' ' . $data['number'] ?></td>
    </tr>
    
    <tr>
        <td>Grad</td>
        <td><?= $data['city'] ?></td>
    </tr>
    
</table>

<br />
<a href='<?= URL ?>profile/change'>Izmena podataka</a><br /><br />
<a href='<?= URL ?>profile/changePassword/<?= $data['id'] ?>'>Nova &#353;ifra</a>

<br /><br />