<?php
function getCart(){
    if(isset($_SESSION['cart'])){               //controleren of winkelmandje (=cart) al bestaat
        $cart = $_SESSION['cart'];                  //zo ja:  ophalen
    } else{
        $cart = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $cart;                               // resulterend winkelmandje terug naar aanroeper functie
}

function saveCart($cart){
    $_SESSION["cart"] = $cart;                  // werk de "gedeelde" $_SESSION["cart"] bij met de meegestuurde gegevens
}

function addProductToCart($stockItemID,$aantal){
    $cart = getCart();                          // eerst de huidige cart ophalen

    if(array_key_exists($stockItemID, $cart)){  //controleren of $stockItemID(=key!) al in array staat
        $cart[$stockItemID] += $aantal;                   //zo ja:  aantal met 1 verhogen
    }else{
        $cart[$stockItemID] = $aantal;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}


function minusProductFromCart($productID)
{
  $cart = getCart(); // eerst de huidige cart ophalen

  if (array_key_exists($productID, $cart)) { //controleren of $stockItemID(=key!) al in array staat
    $cart[$productID] -= 1; //zo ja:  aantal met 1 verlagen
  }
  else {
    $cart[$productID] = 1; //zo nee: key toevoegen en aantal op 1 zetten.
  }
  if ($cart[$productID] <= 0){
    unset($_SESSION['cart']);
  }



  saveCart($cart); // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}

function emptyCart()
{ // cart $_SESSION leeg maken
  unset($_SESSION['cart']);
  unset($_SESSION['aantal']);
}

function emptyProduct()
{ // cart $_SESSION leeg maken
    $productID = $_GET['emptyProduct'];
    unset($_SESSION['cart'][$productID]);

    //als value in array leeg is -> unset
    foreach($_SESSION['cart'] as $key => $value){
      //checked of key valye heeft
      if(!strlen($value)){
        //unset die key
        unset($_SESSION['cart'][$key]);
      }
    }

    //als array leeg is empty cart
    if(!$_SESSION['cart']){
      emptyCart();
    }
}
