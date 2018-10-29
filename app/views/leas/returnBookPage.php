<h2>Vra&#263;anje knjige</h2>

<form action='<?= URL ?>leas/returnBook' method='post'>
    <label class='form_label4'>&#268;lanski broj korisnika:</label>
    <input class='notEmpty' type='number' name='membership_number' /><br />
    
    <label class='form_label4'>Inventarni broj knjige:</label>
    <input class='notEmpty' type='number' name='inventory_number' /><br />
    
    <label class='form_label4'>Vra&#263;eno dana:</label>
    <select name='from_date'>
        <?php 
            for ($i = 1; $i <= 31; $i++) {
                echo '<option ';
                if ($i == rtrim(date('d'), '0')) {
                    echo "selected='selected'";
                };
                echo ' value="'.$i.'">'.$i.'</option>';
            }
        ?>
    </select>
    
    <select name='from_month'>
        <?php 
            for ($i = 1; $i <= 12; $i++) {
                echo '<option ';
                if ($i == rtrim(date('m'), '0')) {
                    echo "selected='selected'";
                };
                echo ' value="'.$i.'">'.$i.'</option>';
            }
        ?>
    </select>
    
    <select name='from_year'>
        <?php 
            for ($i = 2015; $i <= date('Y'); $i++) {
                echo '<option ';
                if ($i == '20' . date('y')) {
                    echo "selected='selected'";
                };
                echo ' value="'.$i.'">'.$i.'</option>';
            }
        ?>
    </select>
    <br /><br />
    
    <p class='mustFillIn'>Crveno ozna&#269;ena polja moraju biti popunjena.</p>
    
    <input type='submit' value='Unesi' />
    <br /><br />
</form>