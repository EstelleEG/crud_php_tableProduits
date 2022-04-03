<?php
//we get the id of the produit we want to edit

//we start a session
session_start();

if($_POST){
    //die("ca marche");
    //check if produit, prix and nombre exist and are not empty, if all fileds have been properly filled
    if(isset($_POST['id']) && !empty($_POST['id'])
    &&(isset($_POST['produit']) && !empty($_POST['produit'])
    && isset($_POST['prix']) && !empty($_POST['prix'])
    && isset($_POST['nombre']) && !empty($_POST['nombre'])){
        //on inclut la connection to the db 
        require_once('connect.php');

        //we clean the adatas sent // clean the html tags
        $id = strip_tags($_POST['id']); 
        $produit = strip_tags($_POST['produit']); 
        $prix = strip_tags($_POST['prix']); 
        $nombre = strip_tags($_POST['nombre']); 

        //query of data insertion in form, we inject the parameter id 
        $sql = 'UPDATE `liste` SET (`produit`:produit, `prix`:prix, `nombre`:nombre) WHERE `id`=:id;';
        //we edit the values where/if the id matches with the id received

        //prepare my query and before to execute it, I use bindValue
        $query = $db->prepare($sql);

        //we 'accroche' the parameters (here it is produit)
        // we make sure it is gonna be an string, with the const PDO suivante :  PDO::PARAM_STR
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':produit', $produit, PDO::PARAM_STR); // :produit is the parameter of my query produit
        $query->bindValue(':prix', $prix, PDO::PARAM_STR);
        $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);

        //we execute the query
        $query->execute();

        //I go back(redirection) to the homepage(index.php), displaying a confirmation msg
        $_SESSION['message'] = "Produit modifie";
         // I close the connection to db
         require_once('close.php');

        header("Location: index.php");
    }else{
        $_SESSION['erreur'] = "le formulaire est incomplet";
    }
}

//var super globale $_GET
//does the id exist and isnt it empty, in the URL field?  (in the URL and not in the db)
//to only be able to display the Voir produit pages, if the id of the produit exists
//else, go back to the homepage "index.php"

if(isset($_GET['id']) && !empty($_GET['id'])){ // if the id exists, I have to connect to the db to check 
    require_once('connect.php');

    //we clean the id sent // clean the html tags
    $id = strip_tags($_GET['id']); //function that cleans all the tags on the id

    $sql = 'SELECT * FROM `liste` WHERE `id` = :id;'; // :id to inject the value

    //on prepare la requete
    $query = $db->prepare($sql);

    //we 'accroche' the parameters (here it is ID)
    // we make sure it is gonna be an int, with the const PDO suivante :  PDO::PARAM_INT
    $query->bindValue(':id', $id, PDO::PARAM_INT); // :id is the parameter of my query id

    //on execute the query
    $query->execute();

    // on recup the produit avec fetch (only 1 produit)
    $produit = $query->fetch();

    //we check if the produit (and id) exists
    if(!$produit){
        $_SESSION['erreur'] = "Cet id n'existe pas"; //we protect from faudulous injections in the URL field
        header("Location: index.php");
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header("Location: index.php");
}
//in html now, we ll display all the details about the produit


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
<!-- add bootstrap cdn for the css style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <main class="container">

    <div class="row">
        <section class="col-12">
           
            <h1>Modifier un produit</h1>
            <form method="post">
                <!--  div.form-group*3 -->
                <div class="form-group">
                    <label for="produit">Produit</label>
                    <input type="text" id='produit' name= 'produit' class="form-control" value="<?= $produit['produit'] ?>">
                    <!-- class from-control is a bootstrap class to do the layout of the form -->
                </div>

                <div class="form-group">
                    <label for="prix">Prix</label>
                    <input type="text" id='prix' name= 'prix' class="form-control"value="<?= $produit['prix'] ?>">
                </div>

                <div class="form-group">
                <label for="nombre">nombre</label>
                <!-- type number to get a scrolling tab for nombre -->
                    <input type="number" id='nombre' name= 'nombre' class="form-control"value="<?= $produit['nombre'] ?>">
                </div>
                <!-- add an input 'id' , to send the id in the POST to make the request -->
                <input type="hidden" value="<?= $produit['id'] ?>"
                name="id">
                <button class='btn btn-primary'>Envoyer</button>
            </form>
        
        </section>
    </div>
    </main>

</body>
</html>



