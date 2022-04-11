<?php
// add.php has for role to : 
    //display the empty form 
    //treat the form

//we start a session
session_start();

//I check if I have sth in $_POST, if an user filled and sent a form with data, in order to add a product
if($_POST){
    //die("ca marche");
    //check if product, price and number exist and are not empty, if all fileds have been properly filled
    if(isset($_POST['product']) && !empty($_POST['product'])
    && isset($_POST['price']) && !empty($_POST['price'])
    && isset($_POST['number']) && !empty($_POST['number'])){
        //on inclut la connection to the db 
        require_once('connect.php');

        //we clean the adatas sent // clean the html tags
        $product = strip_tags($_POST['product']); 
        $price = strip_tags($_POST['price']); 
        $number = strip_tags($_POST['number']); 

        //query of data insertion in form
        $sql = 'INSERT INTO `liste` (`product`, `price`, `number`) VALUES (:product, :price, :number);';

        //prepare my query
        $query = $db->prepare($sql);

        //we 'accroche' the parameters (here it is product)
        // we make sure it is gonna be an string, with the const PDO suivante :  PDO::PARAM_STR
        $query->bindValue(':product', $product, PDO::PARAM_STR); // :product is the parameter of my query product
        $query->bindValue(':price', $price, PDO::PARAM_STR);
        $query->bindValue(':number', $number, PDO::PARAM_INT);

        //we execute the query
        $query->execute();

        //I go back(redirection) to the homepage(index.php), displaying a confirmation msg
        $_SESSION['message'] = "product added";
         // I close the connection to db
         require_once('close.php');

        header("Location: index.php");
    }else{
        $_SESSION['erreur'] = "form is incomplete";
    }
}


//fetch all the data and store the result in an associative array 
//$result = $query->fetchAll(PDO::FETCH_ASSOC);
//"PDO::FETCH_ASSOC" is I a const saying that I WANT IN MY RESULT ONLY the DATA WITH TITLE OF all COLUMNS
// to not get dduplicate in the result


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a product</title>
<!-- add bootstrap cdn for the css style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <main class="container">

    <div class="row">
        <section class="col-12">
           
            <h1>Add a product</h1>
            <form method="post">
                <!--  div.form-group*3 -->
                <div class="form-group">
                    <label for="product">Product</label>
                    <input type="text" id='product' name= 'product' class="form-control">
                    <!-- class from-control is a bootstrap class to do the layout of the form -->
                </div>

                <div class="form-group">
                <label for="price">Price</label>
                    <input type="text" id='price' name= 'price' class="form-control">
                </div>

                <div class="form-group">
                <label for="number">Number</label>
                <!-- type number to get a scrolling tab for number -->
                    <input type="number" id='number' name= 'number' class="form-control">
                </div>

                <button class='btn btn-primary'>Send</button>
            </form>
        
        </section>
    </div>
    </main>

</body>
</html>







