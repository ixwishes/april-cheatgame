<?php 

include 'Card.class.php'; 
include 'NPC.class.php'; 
session_start(); 

switch($_GET["player"]) {
    case 1: $player = $_SESSION["NPC1"]; 
            $playerHand =  $_SESSION['NPC1Hand']; 
            break; 
    case 2: $player = $_SESSION["NPC2"]; 
            $playerHand =  $_SESSION['NPC2Hand']; 
            break;
    case 3: $player = $_SESSION["NPC3"]; 
            $playerHand =  $_SESSION['NPC3Hand']; 
            break;
}

?>



<html>
    <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <div style="display:none;"> 
             <?php 
             //display this div to view cards played by NPC
             var_dump( $_SESSION['NPCplayed']) ;
            echo "<br>" .  $_SESSION['cardValue'] ; ?>
         </div>
       
        <h1>
            <?php echo $player->getName() . " played " . $_GET['number'] . " " . currentCardVal() . "(s)" ?>
        </h1>
        <table width="60%"> 
            <tr>
                <td>
                     <h1><?php echo $_SESSION["NPC1"]->getName() ?></h1>
                    <h3>Has <?php echo $_SESSION["NPC1"] == $player ? count($_SESSION['NPC1Hand']) - (int)$_GET['number']  :
                    count($_SESSION['NPC1Hand'])  ?> Cards</h3> 
                     <?php
                       /* for ($i = 0; $i <  count($_SESSION['NPC1Hand']); $i++) {
                            print $_SESSION['NPC1Hand'][$i] -> getCardValue() . " of " . $_SESSION['NPC1Hand'][$i] -> getCardSuit() . "<br>";
                        }*/
        ?>
                </td>
                <td>
                     <h1><?php echo $_SESSION["NPC2"]->getName() ?></h1>
    <h3>Has <?php echo $_SESSION["NPC2"] == $player ? count($_SESSION['NPC2Hand']) - (int)$_GET['number']  :
                    count($_SESSION['NPC2Hand'])  ?> Cards </h3>
    
    <?php
        /*for ($i = 0; $i <  count($_SESSION['NPC2Hand']); $i++) {
            print $_SESSION['NPC2Hand'][$i] -> getCardValue() . " of " . $_SESSION['NPC2Hand'][$i] -> getCardSuit() . "<br>";
        }*/
        ?>
                </td>
                <td>
                    <h1><?php echo $_SESSION["NPC3"]->getName() ?></h1>
    <h3> Has <?php echo $_SESSION["NPC3"] == $player ? count($_SESSION['NPC3Hand']) - (int)$_GET['number']  :
                    count($_SESSION['NPC3Hand'])  ?> Cards </h3>
    
    <?php
        /*for ($i = 0; $i <  count($_SESSION['NPC3Hand']); $i++) {
            print $_SESSION['NPC3Hand'][$i] -> getCardValue() . " of " . $_SESSION['NPC3Hand'][$i] -> getCardSuit() . "<br>";
        }*/
        ?>
                </td>
            </tr>
        </table>
        
        <h2>Pot: <?php echo count($_SESSION['pot']) + count ($_SESSION['NPCplayed']) ?> cards</h2>
        
          
        
          <h1>Your Hand (<?php print count($_SESSION['userHand']) ?> Cards)</h1>
          
             
          <div class="cards1"> 
              <?php //prepare screen and sort the users cards
             usort($_SESSION['userHand'], array('Card','cmp')); 
               ?>
             
           <?php for ($i = 0; $i < count($_SESSION['userHand']) ; $i++) { ?>
                
               <img src="images/<?php print showCards($_SESSION['userHand'][$i])?>.gif" />
              <?php print (($i+1)%5==0) ? "<br><br>" : "" ?>
              
              <?php } ?>      
            <form method = "POST" action = "NPCturn.php?player=<?php echo $_GET["player"]?>">
                 <input type="submit" value="Accuse of Cheating!" name="submit" value="accuse">
                 <input type="submit" value="Let Slide" name="submit" value="slide">
                </form> 
                  
        </div>
          
          
<?php
function showCards($xcard) {
    return $xcard->getCardValue() . strtolower(substr($xcard->getCardSuit(), 0,1)) ;
    }

function currentCardVal() {
        switch($_SESSION['cardValue']) {
            case 1: return "Ace"; break; 
            case 2: return "Two"; break;
            case 3: return "Three"; break;
            case 4: return "Four"; break;
            case 5: return "Five"; break;
            case 6: return "Six"; break;
            case 7: return "Seven"; break;
            case 8: return "Eight"; break;
            case 9: return "Nine"; break;
            case 10: return "Ten"; break;
            case 11: return "Jack"; break;
            case 12: return "Queen"; break;
            case 13: return "King"; break;
            default:return "Ace"; break; 
        }
    }
?>