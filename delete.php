<?php
//we start a session
session_start();

//var super globale $_GET
//does the id exist and isnt it empty, in the URL field?  (in the URL and not in the db)
//to only be able to display the Voir produit pages, if the id of the produit exists
//else, go back to the homepage "index.php"

if(isset($_GET['id']) && !empty($_GET['id'])){ // if the id exists, I have to connect to the db to check 
    require_once('connect.php');

    //we clean the id sent // clean the html tags
    $id = strip_tags($_GET['id']); //function that cleans all the tags on the id

    $sql = ' SELECT * FROM `liste` WHERE `id` = :id; '; // :id to inject the value


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
        $_SESSION['erreur'] = "This id doesn't exist"; //we protect from faudulous injections in the URL field
        header("Location: index.php");
        die();
    }



   $sql = 'DELETE FROM `liste` WHERE `id`= :id;'; // :id to inject the value



   //on prepare la requete
   $q = $db->prepare($sql);


   //we 'accroche' the parameters (here it is ID)
   // we make sure it is gonna be an int, with the const PDO suivante :  PDO::PARAM_INT
   $q->bindValue(':id', $id, PDO::PARAM_INT); // :id is the parameter of my query id
 

   //on execute the query
   $q->execute();

   $_SESSION['message'] = "Product deleted"; 
        header("Location: index.php");


}
    else{
    $_SESSION['erreur'] = "Invalid URL";
    header("Location: index.php");
}
//in html now, we ll display all the details about the produit
?>
