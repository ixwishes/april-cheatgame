<?php 

include 'Card.class.php'; 
include 'NPC.class.php'; 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //if user hand = 0, they've won the game. 
    if ( count( $_SESSION['userHand']) == 0 ) {
    header('Location: won.php' );
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
        header('Location: NPCturn.php?player=3' );
        exit(); 
    } else if ($_SESSION['turnCount'] > 4 ) { 
        //set back to user turn
        $_SESSION['turnCount'] = 1; 
        header('Location: play.php' );
        exit();
    }
} else { ?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        
        <?php 
if (!isset($_GET["cheat"])) {
    
    echo "<h1>You were not accused of cheating</h1>";
 
    
    
} else {
    switch($_GET["cheat"]) {
        case 1: $accuser = $_SESSION["NPC1"]->getName(); break; 
        case 2: $accuser = $_SESSION["NPC2"]->getName(); break; 
        case 3: $accuser = $_SESSION["NPC3"]->getName(); break; 
    }
}


 if (isset($_GET["true"]) && isset($_GET["cheat"])){
    
    echo "<h1>You were caught  cheating by ". $accuser . "!</h1>";
    echo "<h1>The pot was added to your hand</h1>"; 
    
    
} else if (isset($_GET["cheat"])){
     echo "<h1>You were falsely accused of cheating by ". $accuser . "!</h1>";
    echo "<h1>The pot was added to their hand.</h1>"; 
   
    
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
     
