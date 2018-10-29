<h2>Izdavanje knjiga</h2>

<form action='<?= URL ?>leas/enterLeas' method='post'>
    <label class='form_label4'>&#268;lanski broj korisnika</label>
    <input class='notEmpty' type='number' name='membership_number' /><br />
    
    <label class='form_label4'>Inventarni broj knjige</label>
    <input class='notEmpty' type='number' name='inventory_number' /><br />
    
    <label class='form_label4'>Iznajmljeno dana:</label>
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
    <br />
    
    <label class='form_label4'>Datum najkasnijeg vra&#263;anja:</label>
    <select name='to_date'>
        <?php 
            for ($i = 1; $i <= 31; $i++) {
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
        ?>
    </select>
    
    <select name='to_month'>
        <?php 
            for ($j = 1; $j <= 12; $j++) {
                echo '<option value="'.$j.'">'.$j.'</option>';
            }
        ?>
    </select>
    
    <select name='to_year'>
        <?php 
            for ($k = 2015; $k <= (date('Y') + 2); $k++) {
                echo '<option value="'.$k.'">'.$k.'</option>';
            }
        ?>
    </select>
    <br /><br />
    
    <p class='mustFillIn'>Crveno ozna&#269;ena polja moraju biti popunjena.</p>
    
    <input class='form_label_button4' type='submit' value='Unesi' />
    <br /><br />
    
</form>