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
            <div class="row">
                <div class="col-6">
                    <p><strong><?= $character->name() ?>, <?= $characterClass ?></strong></p>
                    <p>Dégâts reçus : <strong><?= $damageCharacter ?></strong>.</p>
                    <p>Il te reste <strong><?= $HPCharacter ?></strong> PV.</p>
                    <p><em><?= $character->bonus() ?></em></p>
                    <p><em><?= $character->getCriticalHit() ?></em></p>
                    <p><em><?= $character->getFreeze() ?></em></p><?php 
                    if($levelUpName == $character->name()){?>
                        <p>GG <?= $levelUpName ?>, tu level up ! </p><?php                 
                    }?>        
                </div>
                <div class="col-6">
                    <p><strong><?= $ennemy->name() ?>, <?= $ennemyClass ?></strong></p>
                    <p>Dégâts reçus : <strong><?= $damageEnnemy ?></strong>.</p>
                    <p>Il reste <strong><?= $HPEnnemy ?></strong> PV à ton ennemi.</p>
                    <p><em><?= $ennemy->bonus() ?></em></p>
                    <p><em><?= $ennemy->bonus() ?></em></p>
                    <p><em><?= $ennemy->getCriticalHit() ?></em></p>
                    <p><em><?= $ennemy->getFreeze() ?></em></p><?php
                    if($levelUpName == $ennemy->name()){?>
                        <p><em>Double peine, ton adversaire level up ! Bouuuuh </em></p><?php                 
                    }?>        
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6"><?php
            if($userLose){
                ?><p><strong>LOOSER ! T'es mort ! </strong>. Ton ennemi regagne 50 PV.</p>
                <a href="index.php">Prêt pour un nouveau combat ?</a>
                <?php
            }elseif($userWin){
                ?><p><strong>WINNER ! <?= $ennemy->name() ?> est mort !</strong> Tu regagnes 50 PV.</p>
                <a href="index.php">Prêt pour un nouveau combat ?</a>
                <?php
            }else {?>
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <a href="index.php?action=fight" class="btn btn-dark" role="button">Next round !</a>
                    </div>
                    <div class="col-3"></div>
                </div><?php
            }?>
        </div>
    </div>
</div>