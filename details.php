<?php
//we start a session
session_start();

//var super globale $_GET
//does the id exist and isnt it empty, in the URL field?  (in the URL and not in the db)
//to only be able to display the Voir product pages, if the id of the product exists
//else, go back to the homepage "index.php"

if(isset($_GET['id']) && !empty($_GET['id'])){ // if the id exists, I have to connect to the db to check 
    require_once('connect.php');

    //we clean the id sent // clean the html tags
    $id = strip_tags($_GET['id']); //function that cleans all the tags on the id

    $sql = 'SELECT * FROM `liste` WHERE `id`=:id;'; // :id to inject the value

    //on prepare la requete
    $query = $db->prepare($sql);

    //we 'accroche' the parameters (here it is ID)
    // we make sure it is gonna be an int, with the const PDO suivante :  PDO::PARAM_INT
    $query->bindValue(':id', $id, PDO::PARAM_INT); // :id is the parameter of my query id

    //on execute the query
    $query->execute();

    // on recup the product avec fetch (only 1 product)
    $product = $query->fetch();

    //we check if the product (and id) exists
    if(!$product){
        $_SESSION['erreur'] = "This id doesn't exist"; //we protect from faudulous injections in the URL field
        header("Location: index.php");
    }
}else{
    $_SESSION['erreur'] = "Invalid URL";
    header("Location: index.php");
}
//in html now, we ll display all the details about the product
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product details</title>
    <!-- add bootstrap cdn for the css style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<!-- main.container>div.row>section.col-12 -->
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <!-- when I click on the btn Voir of a product, I open a page of Details du product requested-->
                <h1>Product details <?= $product['product'] ?></h1>
                <p>ID: <?= $product['id'] ?></p>
                <p>product: <?= $product['product'] ?></p>
                <p>price: <?= $product['price'] ?></p>
                <p>number: <?= $product['number'] ?></p>
                <!-- with echo php, we display the id of the product that we want to modifiy -->
                <p><a href="index.php">Go back</a> <a href="edit.php?id=<?= $product['id'] ?>">Modify</a></p>
                <!-- btns Retour and Modifier made above -->

            </section>
        </div>
    </main>
</body>
</html>
