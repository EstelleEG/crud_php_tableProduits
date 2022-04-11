<?php
//we get the id of the product we want to edit

//we start a session
session_start();

if($_POST){
    //die("ca marche");
    //check if product, price and number exist and are not empty, if all fileds have been properly filled
    if( isset($_POST['id']) && !empty($_POST['id']) 
    && (isset($_POST['product']) && !empty($_POST['product']) 
    && isset($_POST['price']) && !empty($_POST['price'])
    && isset($_POST['number']) && !empty($_POST['number']))
    )
    {
        //on inclut la connection to the db 
        require_once('connect.php');


        //we clean the adatas sent // clean the html tags
        $id = strip_tags($_POST['id']);
        $product = strip_tags($_POST['product']); 
        $price = strip_tags($_POST['price']); 
        $number = strip_tags($_POST['number']); 

        var_dump($id,$product,$price,$number);

        //query of data insertion in form, we inject the parameter id 
        $sql = 'UPDATE `liste` SET `product`=:product, `price`=:price, `number`=:number WHERE `id`=:id;';
        
        //we edit the values where/if the id matches with the id received

        //prepare my query and before to execute it, I use bindValue
        $query = $db->prepare($sql);

        //we 'accroche' the parameters (here it is product)
        // we make sure it is gonna be an string, with the const PDO suivante :  PDO::PARAM_STR
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':product', $product, PDO::PARAM_STR); // :product is the parameter of my query product
        $query->bindValue(':price', $price, PDO::PARAM_STR);
        $query->bindValue(':number', $number, PDO::PARAM_INT);

        //we execute the query
        $query->execute();

        //I go back(redirection) to the homepage(index.php), displaying a confirmation msg
        $_SESSION['message'] = "product modified";
         // I close the connection to db
         require_once('close.php');

        header("Location: index.php");
    }
    else{
        $_SESSION['erreur'] = "form is incomplete";
    }
}

//var super globale $_GET
//does the id exist and isnt it empty, in the URL field?  (in the URL and not in the db)
//to only be able to display the Voir product pages, if the id of the product exists
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

    // on recup the product avec fetch (only 1 product)
    $product = $query->fetch();

    //we check if the product (and id) exists
    if(!$product){
        $_SESSION['erreur'] = "Cet id n'existe pas"; //we protect from faudulous injections in the URL field
        header("Location: index.php");
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
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
    <title>Ajouter un product</title>
<!-- add bootstrap cdn for the css style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <main class="container">

    <div class="row">
        <section class="col-12">
           
            <h1>Modifier un product</h1>
            <form method="post">
                <!--  div.form-group*3 -->
                <div class="form-group">
                    <label for="product">product</label>
                    <input type="text" id='product' name= 'product' class="form-control" value="<?= $product['product'] ?>">
                    <!-- class from-control is a bootstrap class to do the layout of the form -->
                </div>

                <div class="form-group">
                    <label for="price">price</label>
                    <input type="text" id='price' name= 'price' class="form-control"value="<?= $product['price'] ?>">
                </div>

                <div class="form-group">
                <label for="number">number</label>
                <!-- type number to get a scrolling tab for number -->
                    <input type="number" id='number' name= 'number' class="form-control"value="<?= $product['number'] ?>">
                </div>
                <!-- add an input 'id' , to send the id in the POST to make the request -->
                <input type="hidden" value="<?= $product['id'] ?>"
                name="id">
                <button class='btn btn-primary'>Envoyer</button>
            </form>
        
        </section>
    </div>
    </main>

</body>
</html>



