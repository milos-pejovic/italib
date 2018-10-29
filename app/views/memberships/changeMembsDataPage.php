<h2>Izmena podataka o &#269;lanarini</h2>

<form action='<?= URL ?>memberships/saveMembDataChange' method='post'>

    <input type='text' name='id' value='<?= $data->id ?>' style='display:none' />
    
    <label class='form_label'>Va&#382;i od:</label>
    <select name='from_date'>
        <?php 
            for ($i = 1; $i <= 31; $i++) {
                echo '<option '; 
                if ((integer) $data->date_from[0] == $i) {
                    echo "selected='selected' ";    
                }
                echo 'value="'.$i.'">'.$i.'</option>';
            }
        ?>
    </select>
    
    <select name='from_month'>
        <?php 
            for ($i = 1; $i <= 12; $i++) {
                echo '<option ';
                if ((integer) $data->date_from[1] == $i) {
                    echo "selected='selected' ";    
                };
                echo 'value="'.$i.'">'.$i.'</option>';
            }
        ?>
    </select>
    
    <select name='from_year'>
        <?php 
            for ($i = 2015; $i <= date('Y'); $i++) {
                echo '<option ';
                if ((integer) $data->date_from[2] == $i) {
                    echo "selected='selected' ";    
                };
                echo ' value="'.$i.'">'.$i.'</option>';
            }
        ?>
    </select>
    <br />

    
    <label class='form_label'>Va&#382;i do:</label>
    <select name='to_date'>
        <?php 
            for ($i = 1; $i <= 31; $i++) {
                echo '<option ';
                if ((integer) $data->date_to[0] == $i) {
                    echo "selected='selected' ";    
                }
                echo ' value="'.$i.'">'.$i.'</option>';
            }
        ?>
    </select>
    
    <select name='to_month'>
        <?php 
            for ($i = 1; $i <= 12; $i++) {
                echo '<option ';
                if ((integer) $data->date_to[1] == $i) {
                    echo "selected='selected' ";    
                };
                echo ' value="'.$i.'">'.$i.'</option>';
            }
        ?>
    </select>
    
    <select name='to_year'>
        <?php 
            for ($i = 2015; $i <= (date('Y') + 2); $i++) {
                echo '<option ';
                if ((integer) $data->date_to[2] == $i) {
                    echo "selected='selected' ";    
                };
                echo ' value="'.$i.'">'.$i.'</option>';
            }
        ?>
    </select>
    <br />
    
    <label class='form_label'>Cena</label>
    <input type='text' name='price' value='<?= $data->price ?>' /><br />
    <br />
    
    <input type='submit' value='Unesi' />
    <br /><br />
</form>