<h2>Pregled &#269;lanarina</h2>

<form action='<?= URL ?>memberships/findMemberships' method='post'>
    Unesite &#269;lanski broj korisnika<br />
    <input type='number' name='membership_number' />
    <br /><br />
    
    <input type='submit' value='Unesi' />
    <br /><br />
</form>

<?php

if ($data) {
    
    if ($data[1] == []) {
        echo '<p>Korisnik: ' . $data[0]->first_name . ' ' . $data[0]->last_name . '</p>';
        echo '<p>Nema &#269;lanarina za ovog korisnika.</p><br />';
    } else {
        echo '<p>Korisnik: ' . $data[0]->first_name . ' ' . $data[0]->last_name . '</p>';
        $user_id = $data[0]->id;
        $data = $data[1];

        ?>
            <table>
                <tr>
                    <td>Redni<br />broj</td>
                    <td>Va&#382;i od</td>
                    <td>Va&#382;i do</td>
                    <td>Cena</td>
                    <td>Izmena</td>
                </tr>
        <?php

        $length = count($data);
        for ($i = 0; $i < $length; $i++) {
            ?>
                <tr>
                    <td><?= ($i + 1) ?></td>
                    <td><?= $data[$i]->date_from ?></td>
                    <td><?= $data[$i]->date_to ?></td>
                    <td><?= $data[$i]->price ?></td>
                    <td><a href='<?= URL ?>memberships/changeMembsDataPage/<?= $data[$i]->id ?>'>Izmeni</a></td>
                </tr>
            <?php
        }
        echo '</table>';
    }    
}    
?>