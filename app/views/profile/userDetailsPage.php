<h2>Korisnik</h2>

<p>Op&#353;ti podaci.</p>

<?php
    $books = $data['leased_books'];
    $data = $data['user_data'];
?>

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

<a href='<?= URL ?>profile/changeUserData/<?= $data['id'] ?>'>Izmeni</a>
<hr />

<p>Podaci o trenutno iznajmljenim knjigama.</p>
<table>
    <tr>
        <td>#</td>
        <td>Knjiga</td>
        <td>Inventarni<br />broj kopije</td>
        <td>Datum izdavanja</td>
        <td>Najkasniji datum vra&#263;anja</td>
    </tr>
<?php
    if ($books) {
        $length = count($books);
        for ($i = 0; $i < $length; $i++) {
            ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $books[$i]->title ?></td>
                    <td><?= $books[$i]->inventory_number ?></td>
                    <td><?= $books[$i]->date_of_leas ?></td>
                    <td><?= $books[$i]->latest_date_of_return ?></td>
                </tr>
            <?php
        }
    }
?>
</table>