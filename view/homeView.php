<div class="container container-title">
    <div class="row">
        <div class="col-3"></div>
        <h2 class="col-6">Le combat des DEV</h2>
        <div class="col-3"></div>
    </div>
</div>
<div class="container container-form">
    <form action="" method="post" class="character-choice">
        <div class="row">
            <div class="col-3"></div>
                <h3 class="col-6">Choisissez votre personnage !</h3>
            <div class="col-3"></div>
        </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="form-group col-6">
            <label for="existingCharacter">Utiliser un personnage existant :</label>
            <select name="existingCharacter" class="custom-select">
                <option selected>Choisissez...</option>
                <?php
                foreach($characters as $character){
                    ?><option value="<?= $character['id'] ?>"><?= $character['name'] ?> : <?= $character['healthPoints'] ?> PV</option>
            <?php    
            } ?>
            </select>
        </div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="form-group col-6">
            <label for="newCharacter">Créer un personnage : </label>
            <input class="form-control" type="text" name="newCharacter">
        </div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="form-group col-6">
            <h3><label for="existingEnnemy">Choisissez votre ennemi !</label></h3>
            <select name="existingEnnemy" class="custom-select">
                <option selected>Choisissez...</option><?php
                foreach($characters as $character){
                    ?><option value="<?= $character['id'] ?>"><?= $character['name'] ?> : <?= $character['healthPoints'] ?> PV</option>
            <?php    
            } ?>
            </select>
        </div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="form-check col-6">
            <input type="checkbox" class="randomEnnemy">
            <label class="form-check-label" for="randomEnnemy">Ennemi aléatoire</label> 
        </div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <input type="submit" class="btn btn-dark" value="Battez-vous !">
        </div>
        <div class="col-3"></div>
    </div>
</div>
<div class="container text-container">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <?php if($chosenCharacter && $chosenEnnemy){ ?>
                <p>Vous avez choisi <strong><?= $chosenCharacter->name() ?></strong>.</p>
                <p>Il a <strong><?= $chosenCharacter->healthPoints() ?></strong> PV.</p>
                <p>Votre ennemi est : <strong><?= $chosenEnnemy->name() ?></strong>.</p>
                <p>Il a <strong><?= $chosenEnnemy->healthPoints() ?></strong>.</p>
                <a href="./index.php?action=fight">FIGHT !</a>
                <?php
            }elseif($errorMsg){ ?>
                <p><?= $errorMsg ?></p><?php
            } ?>
        </div>
        <div class="col-3"></div>
    </div>
</div>