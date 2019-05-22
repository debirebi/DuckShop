<?php
require_once( __DIR__ . '/../includes/db/connection.php' );
require_once ("../includes/session.php");



function readProduct()
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( 'SELECT * FROM Product ORDER BY ProductID DESC' );
        $handle->execute();
        $result = $handle->fetchAll( \PDO::FETCH_OBJ );

        foreach ( $result as $row ) {
            print( ProductTemplate($row) );
        }
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function getProduct($ProductID)
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( "SELECT * FROM Product WHERE ProductID = :ProductID");
        $handle->bindParam(':ProductID', $ProductID);
        $handle->execute();
        $result = $handle->fetch( \PDO::FETCH_OBJ );
        $_SESSION['lastOpenedCategory'] = $result->Category;
        print( ProductTemplate($result) );
        getSimilarProducts($result, $ProductID);

    }

    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function getSimilarProducts($result, $currentProductID){

    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( "SELECT * FROM Product WHERE Category = '{$result-> Category}'");
        $handle->execute();

        $resultByCategory = $handle->fetchAll( \PDO::FETCH_OBJ );
        print "<h1>Similar items:  </h1>";
        foreach ($resultByCategory as $row) {
            if ($row->ProductID == $currentProductID) {
                continue;
            }
            print( SimilarItemTemplate($row) );
        }

    }

    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function getProductsYouMightLike(){

    try {
        $cxn = connectToDB();
        $lastVisitedCategory = getLastVisitedCategoryID();

        //If this is 0 it means no item has been visited yet in the session
        if ($lastVisitedCategory == 0) {
            return;
        }
        $handle = $cxn->prepare( "SELECT * FROM Product WHERE Category = $lastVisitedCategory");
        $handle->execute();

        $resultByCategory = $handle->fetchAll( \PDO::FETCH_OBJ );

        print "<h1>Items you might Like:  </h1>";
        foreach ($resultByCategory as $row) {

            print( SimilarItemTemplateByCategory($row) );
        }

    }

    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function createProduct($Category, $Price, $Size, $Color, $ProductName, $ProdDescription, $PictureURL)
{
    try
    {
        $cxn = connectToDB();

        $statement = "INSERT INTO Product (Category ,Price, Size, Color, ProductName, ProdDescription, PictureURL, IsSpecial) 
                      VALUES (:Category, :Price, :Size, :Color, :ProductName, :ProdDescription, :PictureURL, 0)";

        var_dump($statement);
        $handle = $cxn->prepare($statement);
        $handle->bindParam(':Category', $Category);
        $handle->bindParam(':Price', $Price);
        $handle->bindParam(':Size', $Size);
        $handle->bindParam(':Color', $Color);
        $handle->bindParam(':ProductName', $ProductName);
        $handle->bindParam(':ProdDescription', $ProdDescription);
        $handle->bindParam(':PictureURL', $PictureURL);
        $handle->execute();

        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}


function getUpdatedProduct($ProductID) {
    try {
        $cxn = connectToDB();
        $statement = "SELECT * FROM Product WHERE ProductID = :ProductID";
        $handle = $cxn->prepare( $statement);
        $handle->bindParam(':ProductName', $ProductID);
        $handle->execute();

        $result = $handle->fetch( \PDO::FETCH_OBJ );

        print( ProductUpdateForm($result));
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function updateProduct($ProductID, $Category, $Price, $Size, $Color,  $ProductName, $ProdDescription, $PictureURL)
{
    try
    {
        $cxn = ConnectToDB();

        $statement = "UPDATE Product SET Category = :Category,
                                         Price = :Price,
                                         Size = :SizeValue,
                                         Color = :Color,
                                         ProductName = :ProductName,
                                         ProdDescription = :ProductDescription,
                                         PictureURL = :PictureURL
                                         WHERE ProductID = :ProductID";
        $handle = $cxn->prepare( $statement );

        $handle->bindParam(':Category', $Category);
        $handle->bindParam(':Price', $Price);
        $handle->bindParam(':Size', $Size);
        $handle->bindParam(':Color', $Color);
        $handle->bindParam(':ProductName', $ProductName);
        $handle->bindParam(':ProdDescription', $ProdDescription);
        $handle->bindParam(':PictureURL', $PictureURL);
        $handle->bindParam(':ProductID', $ProductID);
        $handle->execute();

        //close the connection
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function deleteProduct($ProductID)
{
    try
    {
        $cxn = ConnectToDB();
        $statement = "DELETE FROM Product WHERE ProductID = '$ProductID'";
        $handle = $cxn->prepare( $statement );

        $handle->execute();

        //close the connection
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function readShoppingCart()
{
    try {
        $cxn = connectToDB();
        $shoppingCart = $_SESSION['shoppingCart'];

        foreach ($shoppingCart as $row)
        {
            $statement = "SELECT * FROM Product WHERE ProductID= '" . $row['id']  . "' ORDER BY ProductID DESC";
            $handle = $cxn->prepare( $statement);
            $handle->execute();
            $result = $handle->fetch( \PDO::FETCH_OBJ );
            print ShoppingTemplate($result, $row['quantity']) ;
        }
        }
        catch(\PDOException $ex){
        print($ex->getMessage());
        }
}


function updateSpecialProduct($ProductName)
{
    try
    {
        $cxn = ConnectToDB();

        $statement = "UPDATE Product SET IsSpecial = 0  WHERE IsSpecial = 1";

        $handle = $cxn->prepare( $statement );
        $handle->execute();

        $statement = "UPDATE Product SET IsSpecial = 1, Price = Price * 0.8 WHERE ProductName = :ProductName";
        $handle = $cxn->prepare( $statement );
        $handle->bindParam(':ProductName', $ProductName);
        $handle->execute();

        //close the connection
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function ProductTemplate($row)
{
    if(getIsAdmin()==true){

        return $template = "	
	
	 <div class='row' >           
          <div class='card horizontal' style='width: 100%; height: 300px'>
              <div href=''>
                        <a href='../presentation/openproduct.php?ProductID= " . $row->ProductID . "'>
                        <span class=\"card-title\" style='margin-left: 15px'>" . $row->ProductName. "</span></a>
                        <br><br>
                        <img class='picture' src=' $row->PictureURL' class='picture'> 
              </div>
                 
                 <div class='card-content s6'>
                       
                        <p '>" . $row->ProdDescription. "</p>
                        <h5 class='price'>" . $row->Price. " dkk </h5>
                         
                         
                 </div>
            
               <div class='card  orange lighten-4' style='width: 200PX'>
                 <div class='card-content s6' style='height: 200px'>
                   
                  
                      <a href='../presentation/adminPage.php?editProduct=" . $row->ProductID . "' class='waves-effect waves-light orange lighten-1 white-text btn edit'>Edit</a>

                      <br><br>
                      <a href='../business/handleProduct.php?action=delete&ProductID=" . $row->ProductID . "' class='waves-effect waves-light red darken-4 white-text btn edit'>Delete Product</a>
	
                  </div>
                  </div>
                
                
                
          </div> 
      </div>
      
      
      
      
      

	
	";}
	else
        return $template = "	
	
	  <div class='row' >           
               <div class='card horizontal' style='width: 100%; height: 300px'>
                 <div href=''>
                        <a href='../presentation/openproduct.php?ProductID= " . $row->ProductID . "'><span class=\"card-title\" style='margin-left: 15px'>" . $row->ProductName. "</span></a>
                        <br><br>
                        <img class='picture' src=' $row->PictureURL' class='picture'> 
                 </div>
                 
                 <div class='card-content s6'>
                       
                        <p>" . $row->ProdDescription. "</p>
                        <h5 class='price'>" . $row->Price. " dkk </h5>
                         
                         
                 </div>
            
               <div class='card orange lighten-1' style='width: 20%'>
                 <div class='card-content s6' style='height: 200px'>
                       
                 
                        <form action='../business/handleProduct.php' method='get' class='addProdInputForm'>
                            <input class='ProductID' type='hidden' name='ProductID' id='ProductID' value='" . $row->ProductID . "' >
                            <input class='ProductID' type='hidden' name='action' value='addToCart' >
                            <input type='text' value='1' name='Quantity' id='quantity' class='itemNumber'>
                            <input type='hidden' value='".$row->Price."' name='Price' id='Price' class='itemNumber'>
                            <input type='submit' name='addToCart' value='Add To Cart' class='waves-effect waves-light white blue-grey-text btn edit'>
                        </form>
                       
               </div>
                
      </div> 
      </div>";

}

function ShoppingTemplate($result, $quantity)
{
    $endPrice = number_format((float)$result->Price, 2) * $quantity;

    return $template = "	
	<div  class=\"center\">
	  <input class='ProductID' type=\"hidden\" name='ProductID' id='ProductID' value='" . $result->ProductID . "' >
     </div>
	  <div class=\"container\">
            <div class=\"col s12 m8\">
               <div class='card center'>
                 <div>
                        <img class='picture' src=' $result->PictureURL'> 
                 </div>
                    <div class=\"card-content s12 \">
                        <span class=\"card-title\">" . $result->ProductName. "</span>
                        <p>" . $result->ProdDescription. "</p>
                        <p>" .$endPrice.  "</p>
                          <p class='quantity'>Quatnity: ". $quantity. "</p>
                          <br><br>
                          <a href='../business/handleProduct.php?action=removeFromCart&ProductID=" . $result->ProductID . "' class='waves-effect waves-light orange lighten-1 accent-1 white-text btn edit'>Delete item</a>
 
                    </div>                  
                </div>
            </div>
        </div>
	";
}

function readSpecial(){
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( 'SELECT * FROM Product WHERE IsSpecial = TRUE ORDER BY ProductID DESC' );
        $handle->execute();
        $result = $handle->fetchAll( \PDO::FETCH_OBJ );

        foreach ( $result as $row ) {
            print( SpecialTemplate($row) );
        }
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}
function SpecialTemplate($row)
{
    if(getIsAdmin()==true){

        return $template = "	
	<div  class=\"center\">
	  <input class='ProductID' type=\"hidden\" name='ProductID' id='ProductID' value='" . $row->ProductID . "' >
     </div>
	  <div class=\"container\">
            <div class=\"col s12 m8\">
               <div class='card center'>
                 <div>
                        <img class='specialofferpic' src=' $row->PictureURL' class='picture'> 
                 </div>
                    <div class=\"card-content s12 \">
                        <span class=\"card-title\">" . $row->ProductName. "</span>
                        <p>" . $row->ProdDescription. "</p>
                        <p>" . $row->Price. " dkk </p>
                        <br> 
                        <a class='waves-effect waves-light orange lighten-1 white-text btn edit'  href='../presentation/adminPage.php'>Edit</a>
                        <a href='business/handleProduct.php?action=delete&productID=" . $row->ProductID . "' class='waves-effect waves-light  red darken-4 white-text btn edit'>Delete</a>
	
                   
                </div>
            </div>
        </div>
	";}
    else
        return $template = "	
	
    <div  class=\"center\">
	  <input class='ProductID' type=\"hidden\" name='ProductID' id='ProductID' value='" . $row->ProductID . "' >
     </div>
	  <div class=\"container\">
            <div class='specialofferdiv'>
               <div class='card center'>
                 <div>
                        <img class='specialofferpic' src=' $row->PictureURL' > 
                        <span class='ProdTitle'>" . $row->ProductName. "</span>
                 </div>
                    <div class=\"card-content s12 \">
                        
                        <p class='description'>" . $row->ProdDescription. "</p>
                        <p >" . $row->Price. " dkk </p>
                        
                        <form action='../business/handleProduct.php' method='get' >
                            <input class='ProductID' type=\"hidden\" name='ProductID' id='ProductID' value='" . $row->ProductID . "' >
                            <input class='ProductID' type='hidden' name='action' value='addToCart' >
                            <input type='text' value='1' name='Quantity' id='quantity' class='itemNumber'>
                            <input type='submit' name='addToCart' value='Add To Cart' class='waves-effect waves-light orange lighten-1 white-text btn edit'>
                        </form>
                 </div>
            </div>
        </div> 
        ";
}
function SimilarItemTemplate($row){
    return $template = "
    
    
    <div class='row' >           
               <div class='card horizontal' style='width: 100%; height: 300px'>
                 <div href=''>
                        <a href='../presentation/openproduct.php?ProductID= " . $row->ProductID . "'><span class=\"card-title\" style='margin-left: 15px'>" . $row->ProductName. "</span></a>
                        <br><br>
                        <img class='picture' src=' $row->PictureURL' class='picture'> 
                 </div>
                 
                 <div class='card-content s6'>
                       
                        <p>" . $row->ProdDescription. "</p>
                        <h5 class='price'>" . $row->Price. " dkk </h5>
                         
                         
                 </div>
            
               <div class='card orange accent-4' style='width: 20%'>
                 <div class='card-content s6' style='height: 200px'>
                       
                 
                        <form action='../business/handleProduct.php' method='get' class='addProdInputForm'>
                            <input class='ProductID' type='hidden' name='ProductID' id='ProductID' value='" . $row->ProductID . "' >
                            <input class='ProductID' type='hidden' name='action' value='addToCart' >
                            <input type='text' value='1' name='Quantity' id='quantity' class='itemNumber'>
                            <input type='hidden' value='".$row->Price."' name='Price' id='Price' class='itemNumber'>
                            <input type='submit' name='addToCart' value='Add To Cart' class='waves-effect waves-light white blue-grey-text btn edit'>
                        </form>
                       
               </div>
                
      </div> 
      </div>
    
    
    
    ";
}

function SimilarItemTemplateByCategory($row){
    return $template = "    
    <div class='row' >           
               <div class='card horizontal' style='width: 100%; height: 300px'>
                 <div href=''>
                        <a href='../presentation/openproduct.php?ProductID= " . $row->ProductID . "'><span class=\"card-title\" style='margin-left: 15px'>" . $row->ProductName. "</span></a>
                        <br><br>
                        <img class='picture' src=' $row->PictureURL' class='picture'> 
                 </div>
                 
                 <div class='card-content s6'>
                       
                        <p>" . $row->ProdDescription. "</p>
                        <h5 class='price'>" . $row->Price. " dkk </h5>
                         
                         
                 </div>
            
               <div class='card orange accent-4' style='width: 20%'>
                 <div class='card-content s6' style='height: 200px'>
                       
                 
                        <form action='../business/handleProduct.php' method='get' class='addProdInputForm'>
                            <input class='ProductID' type='hidden' name='ProductID' id='ProductID' value='" . $row->ProductID . "' >
                            <input class='ProductID' type='hidden' name='action' value='addToCart' >
                            <input type='text' value='1' name='Quantity' id='quantity' class='itemNumber'>
                            <input type='hidden' value='".$row->Price."' name='Price' id='Price' class='itemNumber'>
                            <input type='submit' name='addToCart' value='Add To Cart' class='waves-effect waves-light white blue-grey-text btn edit'>
                        </form>
                       
               </div>
                
      </div> 
      </div>
    
    
    
    ";
}

function ProductUpdateForm($result) {
    return $template ="
    
    <form action='../business/handleProduct.php' method='get'>
        <input class='ProductID' type='hidden' name='ProductID' value='" . $result->ProductID. "' >
        <input class='ProductID' type='text' name='Category' value='" . $result->Category. "' >
        <input class='ProductID' type='text' name='Price' value='" . $result->Price. "' >
        <input class='ProductID' type='text' name='Size' value='" . $result->Size. "' >
        <input class='ProductID' type='text' name='Color' value='" . $result->Color. "' >
        <input class='ProductID' type='text' name='ProductName' value='" . $result->ProductName. "' >
        <input class='ProductID' type='text' name='ProdDescription' value='" . $result->ProdDescription. "' >
        <input class='ProductID' type='text' name='PictureURL' value='" . $result->PictureURL. "' >
        <input class='ProductID' type='hidden' name='action' value='update' >
        <input type='submit' name='updateProduct' value='Update Product' class='waves-effect waves-light btn edit'>
    </form>
    
    ";


}