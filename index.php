<?php
//we start a session
session_start();

echo "hey";
//CRUD stands for : 

//CREATE (add.php)
//READ (details.php) to read all the datas of the db, read et write datas that we need in db, voir/read les details of all or one produit.
//UPDATE (edit.php)
//DELETE (delete.php)

//index.php homepage, to read all the datas of the db
//connect.php to connect to db
//close.php pour me deconnecter de la db

//on inclut la connection to the db 
require_once('connect.php');

//my sql request from my table "liste"
$sql = 'select * from `liste`';

//prepare my query
$query = $db->prepare($sql);

//we execute the query
$query->execute();

//fetch all the data and store the result in an associative array 
$result = $query->fetchAll(PDO::FETCH_ASSOC);
//"PDO::FETCH_ASSOC" is I a const saying that I WANT IN MY RESULT ONLY the DATA WITH TITLE OF all COLUMNS
// to not get dduplicate in the result

//display the content of a var - here the array
//var_dump($result);

// I close the connection to db
require_once('close.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<!-- add bootstrap cdn for the css style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <main class="container">

    <div class="row">
        <section class="col-12">
            <?php
                if(!empty($_SESSION['erreur'])){
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['erreur'].' </div>'; // display a bootstrap red field with an error msg
                $_SESSION['erreur'] = "";
                }
            ?>

            <?php
                if(!empty($_SESSION['erreur'])){
                    echo '<div class="alert alert-success" role="alert">' . $_SESSION['erreur'].' </div>'; // display a bootstrap green field with an success msg
                $_SESSION['erreur'] = "";
                }

            ?>

            <h1>Liste des produits</h1>
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Nombre</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                    <?php
                    foreach($result as $produit){ //I loop on the var $result, to display the table liste, each line is a produit
                    ?>
                    <!-- type 'tr>td*5' -->
                      <tr>
                          <!--  equals to php echo -->
                          <td><?= $produit['id'] ?></td>
                          <td><?= $produit['produit'] ?></td>
                          <td><?= $produit['prix'] ?></td>
                          <td><?= $produit['nombre'] ?></td>

                          <!-- to display the produit via its id -->
                          <td><a href="details.php?id=<?= $produit['id'] ?>">Voir</a>
                          <a href="edit.php?id=<?= $produit['id'] ?>">Modifier</a>
                          <a href="delete.php?id=<?= $produit['id'] ?>">Supprimer</a></td>
                      </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <!-- btn add a poduit -->
            <a href="add.php" class='btn btn-primary'>Ajouter un produit</a>
        </section>
    </div>
    </main>

</body>
</html>







