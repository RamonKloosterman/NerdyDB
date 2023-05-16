<?php
function getwishlist(){
    if(isset($_SESSION['wishlist'])){               //controleren of winkelmandje (=wishlist) al bestaat
        $wishlist = $_SESSION['wishlist'];                  //zo ja:  ophalen
    } else{
        $wishlist = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $wishlist;                               // resulterend winkelmandje terug naar aanroeper functie
}

function savewishlist($wishlist){
    $_SESSION["wishlist"] = $wishlist;                  // werk de "gedeelde" $_SESSION["wishlist"] bij met de meegestuurde gegevens
}

function addProductTowishlist($stockItemID,$aantal){
    $wishlist = getwishlist();                          // eerst de huidige wishlist ophalen

    if(array_key_exists($stockItemID, $wishlist)){  //controleren of $stockItemID(=key!) al in array staat
        $wishlist[$stockItemID] += $aantal;                   //zo ja:  aantal met 1 verhogen
    }else{
        $wishlist[$stockItemID] = $aantal;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    savewishlist($wishlist);                            // werk de "gedeelde" $_SESSION["wishlist"] bij met de bijgewerkte wishlist
}


function minusProductFromwishlist($productID)
{
  $wishlist = getwishlist(); // eerst de huidige wishlist ophalen

  if (array_key_exists($productID, $wishlist)) { //controleren of $stockItemID(=key!) al in array staat
    $wishlist[$productID] -= 1; //zo ja:  aantal met 1 verlagen
  }
  else {
    $wishlist[$productID] = 1; //zo nee: key toevoegen en aantal op 1 zetten.
  }
  if ($wishlist[$productID] <= 0){
    unset($_SESSION['wishlist']);
  }



  savewishlist($wishlist); // werk de "gedeelde" $_SESSION["wishlist"] bij met de bijgewerkte wishlist
}
function emptyWishlistProduct()
{ // wishlist $_SESSION leeg maken
    $productID = $_GET['emptyProduct'];
    unset($_SESSION['wishlist'][$productID]);

    //als value in array leeg is -> unset
    foreach($_SESSION['wishlist'] as $key => $value){
      //checked of key valye heeft
      if(!strlen($value)){
        //unset die key
        unset($_SESSION['wishlist'][$key]);
      }
    }

    //als array leeg is empty wishlist
    if(!$_SESSION['wishlist']){
      emptywishlist();
    }
}
