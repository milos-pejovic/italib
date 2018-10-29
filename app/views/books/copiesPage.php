<h2>Kopije</h2>

<p>Naslov knjige: <?= $data['book_title'] ?></p>

<?php unset($data['book_title']) ?>

<table>
    <tr>
        <td>#</td>
        <td>Inventarni broj</td>
        <td>Status</td>
    </tr>
    <?php
        $length = count($data);
        
        for ($i = 0; $i < $length; $i++) {
            $data[$i]->status = ($data[$i]->status == 'available') ? 'slobodna' : 'izdata';
            ?>
                <tr>
                    <td><?= ($i + 1) ?></td>
                    <td><?= $data[$i]->inventory_number ?></td>
                    <td><?php 
                        echo $data[$i]->status;
                        if (isset($data[$i]->user)) {
                            echo ' &#269;lanu <a href='.URL.'profile/userDetails/'.$data[$i]->user->id.'>' . $data[$i]->user->membership_number . '</a>';
                        }
                    ?></td>
                </tr>
            <?php
        }
    ?>
</table>

<br />

<a href='<?= URL ?>books/index'>Nazad</a>

<br /><br />

