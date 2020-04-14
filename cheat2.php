<?php 

include 'Card.class.php'; 
include 'NPC.class.php'; 
session_start();

switch($_GET["player"]) {
        case 1 :
            $playerhand = $_SESSION["NPC1Hand"];
            $player = $_SESSION["NPC1"];
            break;
        case 2 :
            $playerhand = $_SESSION["NPC2Hand"];
            $player = $_SESSION["NPC2"];
            break;
        case 3 :
            $playerhand = $_SESSION["NPC3Hand"];
            $player = $_SESSION["NPC3"];
            break;
        default:
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //if user hand = 0, they've won the game. 
    if ( count( $_SESSION['userHand']) == 0 ) {
    header('Location: won.php' );
    exit(); 
    } else if (count($_SESSION["NPC1Hand"]) ==0 ||count($_SESSION["NPC2Hand"]) ==0 || count($_SESSION["NPC3Hand"]) ==0  ) {
       header('Location: lost.php' );
        exit();  
    }
    
    //if not, continue with NPC turns
    if ($_SESSION['turnCount']==2 ) {
        //player 1 turn
        header('Location: NPCturn.php?player=1' );
        exit();
        
    } else if ($_SESSION['turnCount']==3 ) {
        //player 2 turn
        header('Location: NPCturn.php?player=2' );
        exit();
        
    } else if ($_SESSION['turnCount'] == 4 ) {
        //player 3 turn
        header('Location:NPCturn.php?player=3' );
        exit(); 
    } else if ($_SESSION['turnCount'] > 4 ) { 
        //set back to user turn
        $_SESSION['turnCount'] = 1; 
        header('Location: play.php' );
        exit();
    }
} else { ?>
    
<html>
    <head><link rel="stylesheet" type="text/css" href="styles.css"></head>
    <body>
        <?php
if (!isset($_GET["cheat"])) {
    
    echo "<h1>" . $player->getName() . " was not accused of cheating.</h1>";
   
} else {
    switch($_GET["cheat"]) {
        case 1: $accuser = $_SESSION["NPC1"]->getName(); break; 
        case 2: $accuser = $_SESSION["NPC2"]->getName(); break; 
        case 3: $accuser = $_SESSION["NPC3"]->getName(); break; 
        default: $accuser = "You"; 
    }
    
    if ( $_GET["result"]=="success") {
        echo $player->getName() . " was caught cheating by " . $accuser; 
        echo "<br>The pot was added to their hand." ; 
    } else {
        echo $accuser . " falsely accused " . $player->getName() . " of cheating. "; 
        echo "<br>The pot was added to their/your hand." ;
    }
}


 
$_SESSION['turnCount'] += 1; 

if ( $_SESSION['cardValue'] == 13){
    $_SESSION['cardValue'] = 1; 
} else { $_SESSION['cardValue'] += 1; }
?>

<form method = "POST" action = "<?php
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
    ?>">
        <input type="submit" name="submit" value="Continue Playing">
    </form>
<?php
}


?>
        
    </body>
</html>
