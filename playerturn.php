<?php 

include 'Card.class.php'; 
include 'NPC.class.php'; 
session_start();

$cheat = false; 
$accusingPlayer = 0; 
$badCards = 0; 

if ( count($_POST['formCards']) > 4 || count($_POST['formCards']) < 1 ){
    header("Location: play.php?error");
    exit();
} 


//determines if the player cheated
for ($i = 0; $i < count($_POST['formCards']) ; $i++ )
{       
       $x = $_POST['formCards'][$i]; 
        
        if ( $_SESSION['userHand'][$x]->getCardValue() != $_SESSION['cardValue']){
            $badCards++; 
        }
}

//tests if any of the NPCs will accuse player of cheating
if ( willAccuse( howManyCards($_SESSION["NPC1Hand"], $_SESSION['cardValue']), count($_POST['formCards']), 
    $_SESSION["NPC1"]->getMedRisk(), $_SESSION["NPC1"]->getHighRisk()  )) {
    $cheat = true; 
    $accusingPlayer = 1; 
} else if ( willAccuse( howManyCards($_SESSION["NPC2Hand"], $_SESSION['cardValue']), count($_POST['formCards']), 
    $_SESSION["NPC2"]->getMedRisk(), $_SESSION["NPC2"]->getHighRisk()  )) {
    $cheat = true; 
    $accusingPlayer = 2; 
} else if ( willAccuse( howManyCards($_SESSION["NPC3Hand"], $_SESSION['cardValue']), count($_POST['formCards']), 
    $_SESSION["NPC3"]->getMedRisk(), $_SESSION["NPC3"]->getHighRisk()  )) {
    $cheat = true; 
    $accusingPlayer = 3; 
}


if (!$cheat) {
    
    //if no one has accused of cheating, add cards to the pot and exit to result page
    
        for ($i = 0; $i < count($_POST['formCards']) ; $i++ )
        {       
            $x = $_POST['formCards'][$i]; 
            array_push($_SESSION['pot'] , $_SESSION['userHand'][$x] );
            unset($_SESSION['userHand'][$x]); 
            
        }
        
    $_SESSION['userHand'] = array_values( $_SESSION['userHand']);
    
    header("Location: cheat.php");
    exit(); 
    
}else {
    
    //check if user was actually cheating, add pot to their hand. 
    if ($badCards > 0) {
       $_SESSION['userHand']= array_merge($_SESSION['userHand'], $_SESSION['pot']); 
        $_SESSION['pot'] = array(); 
       $_SESSION['userHand'] = array_values( $_SESSION['userHand']);  
        
    header('Location: /cheat.php?cheat=' . $accusingPlayer . '&true' );
    exit(); 
     
    } else {
        
    //if user was not cheating, accusing player takes the pot
    
        for ($i = 0; $i < count($_POST['formCards']) ; $i++ )
        {       
            $x = $_POST['formCards'][$i]; 
            array_push($_SESSION['pot'] , $_SESSION['userHand'][$x] );
            unset($_SESSION['userHand'][$x]); 
            
        }
        
        
        if ($accusingPlayer == 1) {
           $_SESSION['NPC1Hand'] = array_merge( $_SESSION['NPC1Hand'], $_SESSION['pot']); 
            $_SESSION['pot'] = array(); 
            
        } else if ($accusingPlayer == 2) {
           $_SESSION['NPC2Hand'] = array_merge( $_SESSION['NPC2Hand'], $_SESSION['pot']); 
            $_SESSION['pot'] = array(); 
            
        } else if ($accusingPlayer == 3) {
          $_SESSION['NPC3Hand']=  array_merge( $_SESSION['NPC3Hand'], $_SESSION['pot']); 
            $_SESSION['pot'] = array(); 
            
        }

        $_SESSION['userHand'] = array_values( $_SESSION['userHand']);
        header('Location: cheat.php?cheat=' . $accusingPlayer . '&false' );
        exit(); 
    }
    
    
    
}
?>




<?php

function isChecked($chkname,$value) {
    if(!empty($_POST[$chkname])) {
        foreach($_POST[$chkname] as $chkval)
        {
            if($chkval == $value) {
                return true;
            }
            
        }
    }
    
    return false;
    
}

 function howManyCards ($cardArray, $xvalue) {
      $count = 0;
      
      //returns how many of a given value a player has
      
      for ($i = 0; $i < count($cardArray) ; $i++) {
          if ($cardArray[$i]->getCardValue() == $xvalue) {
              $count++; 
          }
      }
      
      return $count;
  }
    
function willAccuse($numCards, $numPlayed, $medRisk, $highRisk) {
    //determines if a given character will accuse the user of cheating
   
    if (($numCards + $numPlayed) > 4) {
        //can be certain of cheating since there are only 4 cards of a value per deck
        return true; 
    } else if (($numCards + $numPlayed) >= 3) {
        //medium risk to accuse of cheating
        $x = rand(1, 100); 
        if ($x > $medRisk ) {
             return true; 
        }
        
    } else if (($numCards + $numPlayed) < 3) {
        //high risk to accuse of cheating. 
        $x = rand(1, 100); 
        if ($x > $highRisk ) {
            return true; 
        }
        
    } 
    
    return false; 
}


?>