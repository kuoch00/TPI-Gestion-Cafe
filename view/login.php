<!-- 
    auteur : Elisa Kuoch
    date : 19.05.2022
    description : formulaire de connexion
 -->
 <?php
 if(isset($connectError) && $connectError){?>
     <p>Nom d'utilisateur ou mot de passe erroné</p><?php
 }
 ?>
 <div class="container ">
    <h3>Connexion</h3>
    <form action="?login=connect" method="POST">  
            <div class="row align-items-center justify-content-center"> 
                <div class="row mt-4 d-flex align-items-center justify-content-center">
                    <div class="col-2">
                        <label class="form-label" for="username">Nom d'utilisateur</label>
                    </div>
                    <div class="col-4">
                        <input class="form-control" type="text" name="username" value="<?=isset($username) && $username ? $username : ''?>">
                    </div>
                </div>

                <div class="row mt-4 d-flex align-items-center justify-content-center">
                    <div class="col-2">
                        <label class="form-label" for="password">Mot de passe</label>
                    </div>
                    <div class="col-4">
                        <input class="form-control" type="password" name="password">
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button class="btn btn-primary" type="submit">Se connecter</button>
                </div> 
            </div>
    </form>
</div>