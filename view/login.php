<!-- 
    auteur : Elisa Kuoch
    date : 19.05.2022
    description : formulaire de connexion
 --> 
    <form action="?login=connect" method="POST">  
            <div class="d-flex justify-content-center ">  
                <div class="col-xl-5 mt-1">
                    <h3 class="mt-3">Connexion</h3>
                    <div class="row mt-3 ">
                        <div class="col-xl-4 d-flex align-items-center">
                            <label class="form-label" for="username">Nom d'utilisateur</label>
                        </div>
                        <div class="col">
                            <input class="form-control" type="text" name="username" id="username" value="<?=isset($username) && $username ? $username : ''?>">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-xl-4 d-flex align-items-center">
                            <label class="form-label" for="password">Mot de passe</label>
                        </div>
                        <div class="col">
                            <input class="form-control <?=isset($connectError) && $connectError ? "is-invalid" : ''?>" id="password" type="password" name="password">
                            <div class="invalid-feedback"> Nom d'utilisateur ou mot de passe erroné</div>
                        </div>
                    </div>

                    <div class="mt-3 text-center">
                        <button class="btn btn-primary" type="submit">Se connecter</button>
                    </div> 
                </div>
            </div>
    </form>
