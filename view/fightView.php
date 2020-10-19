<div class="container container-title">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <h2>Battle !</h2>
        </div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <p><?= $character->name() ?> inflige <?= $damageEnnemy ?> à <?= $ennemy->name() ?>.</p>
            <p>Il reste <?= $HPEnnemy ?> PV à  <?= $ennemy->name() ?>.</p>
        </div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <p><?= $ennemy->name() ?> inflige <?= $damageCharacter ?> à <?= $character->name() ?>.</p>
            <p>Il reste <?= $HPCharacter ?> PV à  <?= $character->name() ?>.</p>
        </div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6"><?php
            if($levelUpName){?>
                <p>GG <?= $levelUpName ?>, tu level up ! </p><?php                 
            }?>
            <?php if($userLose){
                ?><p>LOOSER !T'es mort ! </p>
                <a href="index.php">Prêt pour un nouveau combat ?</a>
                <?php
            }
            if($userWin){
                ?><p>WINNER ! <?= $ennemy->name() ?> est mort ! Tu regagnes 50 PV.</p>
                <a href="index.php">Prêt pour un nouveau combat ?</a>
                <?php
            }?>
        </div>
    </div>
</div>