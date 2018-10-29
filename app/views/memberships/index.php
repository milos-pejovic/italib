<h2>&#268;lanarine</h2>

<form action='<?= URL ?>memberships/addMembership' method='post'>
    
    <label class='form_label'>&#268;lanski broj</label>
    <input class='notEmpty' type='number' name='membership_number' /><br />
    
    <label class='form_label'>Va&#382;i od:</label>
    <select name='from_date'>
        <?php 
            for ($i = 1; $i <= 31; $i++) {
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
        ?>
    </select>
    
    <select name='from_month'>
        <?php 
            for ($j = 1; $j <= 12; $j++) {
                echo '<option value="'.$j.'">'.$j.'</option>';
            }
        ?>
    </select>
    
    <select name='from_year'>
        <?php 
            for ($k = 2015; $k <= date('Y'); $k++) {
                echo '<option value="'.$k.'">'.$k.'</option>';
            }
        ?>
    </select>
    <br />

    
    <label class='form_label'>Va&#382;i do:</label>
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
    <br />
    
    <label class='form_label'>Cena</label>
    <input class='notEmpty' type='text' name='price' /><br />
    <br />
    
    <p class='mustFillIn'>Crveno ozna&#269;ena polja moraju biti popunjena.</p>
    
    <input type='submit' value='Unesi' />
    <br /><br />
</form>