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
<h3>Connexion</h3>
<form action="?login=connect" method="POST"> 
    <label for="username">Nom d'utilisateur</label>
    <input type="text" name="username" value="<?=isset($username) && $username ? $username : ''?>">

    <label for="password">Mot de passe</label>
    <input type="password" name="password">

    <button type="submit">Se connecter</button>
</form>