<div class="block">
    <div class="titre"><p>Ajout Auteur</p></div>

        <?php
            if(!$this->formulaire->estValide())
                echo $this->formulaire;
            else{
       ?>
            <p>Ajout avec Sucess</p>
       <?php
            }
       ?>
    <div class="foot"></div>
</div>
