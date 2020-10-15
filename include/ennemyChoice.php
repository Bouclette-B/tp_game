<div class="container container-form">
    <div class="row">
        <div class="col-3"></div>
        <form action="" method="post" class="col-6 character-choice">
            <div class="form-group">
                <label for="existingEnnemy">Choisissez votre ennemi !</label>
                <select name="existingEnnemy" class="custom-select">
                    <option selected>Choisissez...</option>
                    <?php
                    foreach($characters as $character){
                        ?><option value="<?= $character['id'] ?>"><?= $character['name'] ?></option>
                <?php    
                } ?>
                </select>
                </div>
            <div class="form-check">
                <input type="checkbox" class="randomEnnemy">
                <label class="form-check-label" for="randomEnnemy">Ennemi aléatoire</label> 
            </div>
            <input type="submit" class="btn btn-dark" value="Battez-vous !" name="ennemyChoice"> 


