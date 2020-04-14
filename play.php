<?php
include 'Card.class.php';
include 'NPC.class.php';
session_start();

if (!isset($_SESSION['userHand'])) {

    //send back to start if not from correct source
    header("Location: start.php");
    exit();

} else if (count($_SESSION['userHand']) < 1) {
    header("Location: won.php");
    exit();
}
{

    //prepare screen and sort the users cards
    usort($_SESSION['userHand'], array('Card', 'cmp'));

}
 ?>
    
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <h1>It's Your Turn!</h1>
        <table width="60%" border="1"> 
            <tr>
                <td>
                     <h1><?php echo $_SESSION["NPC1"]->getName() ?></h1>
                    <h3>Has <?php echo count($_SESSION['NPC1Hand']) ?> Cards </h3>
                     <?php
                    //uncomment in order to view NPC hands
                    /*for ($i = 0; $i < count($_SESSION['NPC1Hand']); $i++) {
                     print $_SESSION['NPC1Hand'][$i] -> getCardValue() . " of " . $_SESSION['NPC1Hand'][$i] -> getCardSuit() . "<br>";
                     }*/
        ?>
                </td>
                <td>
                     <h1><?php echo $_SESSION["NPC2"]->getName() ?></h1>
                    <h3>Has <?php echo count($_SESSION['NPC2Hand']) ?> Cards </h3>
    
    <?php
    //uncomment in order to view NPC hands
    /* for ($i = 0; $i < count($_SESSION['NPC2Hand']); $i++) {
     print $_SESSION['NPC2Hand'][$i] -> getCardValue() . " of " . $_SESSION['NPC2Hand'][$i] -> getCardSuit() . "<br>";
     }*/
        ?>
                </td>
                <td>
                    <h1><?php echo $_SESSION["NPC3"]->getName() ?></h1>
                   <h3>Has <?php echo count($_SESSION['NPC3Hand']) ?> Cards </h3> 
    
    <?php
    //uncomment in order to view NPC hands
    /*for ($i = 0; $i < count($_SESSION['NPC3Hand']); $i++) {
     print $_SESSION['NPC3Hand'][$i] -> getCardValue() . " of " . $_SESSION['NPC3Hand'][$i] -> getCardSuit() . "<br>";
     }*/
        ?>
                </td>
            </tr>
        </table>
        
        <H2>Pot: <?php echo count($_SESSION['pot']) ?> cards</H2>
        
          
        
          <h1>Your Hand (<?php print count($_SESSION['userHand']) ?> Cards)</h1>
    
    
    <div class="cards" style="width:570px !important;"> 
        <h3>You have <?php echo count($_SESSION['userHand']) ?> cards in your hand.  <br>
        You must play 1 or more <b><?php echo currentCardVal() ?>s</b> on this turn (or bluff). </h3>
        
          <?php 
    
    if (isset($_GET["error"])) { ?>
        <div class="error">
            * You must submit between 1-4 cards on your turn.
        </div>
        
   <?php
}
     ?>
    
   <form method = "POST" action = "playerturn.php">
    <?php for ($i = 0; $i < count($_SESSION['userHand']) ; $i++) { ?>
       
     <input type="checkbox" name="formCards[]" id="box<?php echo $i ?>" value="<?php echo $i ?>" autocomplete="off" /> 
     <label for="box<?php echo $i ?>">
    <img src="images/<?php print showCards($_SESSION['userHand'][$i])?>.gif" />
    </label>
    
    <?php print (($i+1)%5==0) ? "<br><br>" : "" ?>
      
  <?php  } ?>
  
    <br>

    <input type="submit" value="Submit" name="submit">
    </form>
    </div> 
    </body>
    
</html>
    
   
    


<?php

    function showCards($xcard) {
        return $xcard -> getCardValue() . strtolower(substr($xcard -> getCardSuit(), 0, 1));
    }

    function currentCardVal() {
        switch($_SESSION['cardValue']) {
            case 1 :
                return "Ace";
                break;
            case 2 :
                return "Two";
                break;
            case 3 :
                return "Three";
                break;
            case 4 :
                return "Four";
                break;
            case 5 :
                return "Five";
                break;
            case 6 :
                return "Six";
                break;
            case 7 :
                return "Seven";
                break;
            case 8 :
                return "Eight";
                break;
            case 9 :
                return "Nine";
                break;
            case 10 :
                return "Ten";
                break;
            case 11 :
                return "Jack";
                break;
            case 12 :
                return "Queen";
                break;
            case 13 :
                return "King";
                break;
            default :
                return "Ace";
                break;
        }
    }
?>
