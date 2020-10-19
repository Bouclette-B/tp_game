<select name="<?= $selectName ?>" class="custom-select">
    <option selected>Choisissez...</option>
        <?php
        foreach($characters as $character){
            if($character['type'] == "warrior"){
                $characterType = 'Guerrier';
            }elseif($character['type'] == "wizard"){
                $characterType = "Sorcier";
            }
            ?><option value="<?= $character['id'] ?>"><?= $character['name'] ?>, <?= $characterType ?>, <?= $character['healthPoints'] ?> PV</option><?php    
        } ?>
</select>
