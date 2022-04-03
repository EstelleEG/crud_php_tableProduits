<?php
// add.php has for role to : 
    //display the empty form 
    //treat the form

//we start a session
session_start();

//I check if I have sth in $_POST, if an user filled and sent a form with data, in order to add a produit
if($_POST){
    //die("ca marche");
    //check if produit, prix and nombre exist and are not empty, if all fileds have been properly filled
    if(isset($_POST['produit']) && !empty($_POST['produit'])
    && isset($_POST['prix']) && !empty($_POST['prix'])
    && isset($_POST['nombre']) && !empty($_POST['nombre'])){
        //on inclut la connection to the db 
        require_once('connect.php');

        //we clean the adatas sent // clean the html tags
        $produit = strip_tags($_POST['produit']); 
        $prix = strip_tags($_POST['prix']); 
        $nombre = strip_tags($_POST['nombre']); 

        //query of data insertion in form
        $sql = 'INSERT INTO `liste` (`produit`, `prix`, `nombre`) VALUES (:produit, :prix, :nombre);';

        //prepare my query
        $query = $db->prepare($sql);

        //we 'accroche' the parameters (here it is produit)
        // we make sure it is gonna be an string, with the const PDO suivante :  PDO::PARAM_STR
        $query->bindValue(':produit', $produit, PDO::PARAM_STR); // :produit is the parameter of my query produit
        $query->bindValue(':prix', $prix, PDO::PARAM_STR);
        $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);

        //we execute the query
        $query->execute();

        //I go back(redirection) to the homepage(index.php), displaying a confirmation msg
        $_SESSION['message'] = "Produit ajouté";
         // I close the connection to db
         require_once('close.php');

        header("Location: index.php");
    }else{
        $_SESSION['erreur'] = "le formulaire est incomplet";
    }
}


//fetch all the data and store the result in an associative array 
$result = $query->fetchAll(PDO::FETCH_ASSOC);
//"PDO::FETCH_ASSOC" is I a const saying that I WANT IN MY RESULT ONLY the DATA WITH TITLE OF all COLUMNS
// to not get dduplicate in the result


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
           
            <h1>Ajouter un produit</h1>
            <form method="post">
                <!--  div.form-group*3 -->
                <div class="form-group">
                    <label for="produit">Produit</label>
                    <input type="text" id='produit' name= 'produit' class="form-control">
                    <!-- class from-control is a bootstrap class to do the layout of the form -->
                </div>

                <div class="form-group">
                <label for="prix">Prix</label>
                    <input type="text" id='prix' name= 'prix' class="form-control">
                </div>

                <div class="form-group">
                <label for="nombre">Nombre</label>
                <!-- type number to get a scrolling tab for nombre -->
                    <input type="number" id='nombre' name= 'nombre' class="form-control">
                </div>

                <button class='btn btn-primary'>Envoyer</button>
            </form>
        
        </section>
    </div>
    </main>

</body>
</html>







