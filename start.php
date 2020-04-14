<?php
include 'Card.class.php'; 
include 'NPC.class.php'; 
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
    $_SESSION['deck'] = createDeck(); 
    $_SESSION['booleanDeck'] = booleanDeck(); 
    $_SESSION['userHand'] = dealDeck(); 
    
    //create and deal cards for "computer players"
    $_SESSION["NPC1"] = new NPC("Reckless Robert", 85, 75); 
    $_SESSION['NPC1Hand'] = dealDeck(); 
    
    $_SESSION["NPC2"] = new NPC("Mild Matthew", 90, 80); 
    $_SESSION['NPC2Hand'] = dealDeck(); 
    
    $_SESSION["NPC3"] = new NPC("Cautious Cate", 98, 91); 
    $_SESSION['NPC3Hand'] = dealDeck(); 
    
    //array for the pot cards and users
    $_SESSION['pot'] = array(); 
    $_SESSION['userArray'] = array($_SESSION["NPC1"], $_SESSION["NPC2"], $_SESSION["NPC1"]); 
    
    //tracks which turn it is, and which value card must be played
    $_SESSION['cardValue'] = 1; 
    $_SESSION['turnCount'] = 1;
    
    header("Location: play.php");
    exit();
    
} else {
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body> 
        
	<h1>Welcome!</h1>
    <div class="cards" style="text-align: center;"> 
	This card game is called "Cheat", but it is also called "Doubt It" or "BS". In this game, you and the 3 "simulated" 
	characters will each start with 13 random cards. 
	<br><br>Each turn, you will have to play the next card in sequence into the pot (i.e. the
	first person will play X number of Aces, the next person plays X number 2s, etc.).
	<br><br> <i>If you don't have the type of card that you are supposed to play on your turn, you will have to bluff! You can
	    also bluff to get rid of extra cards faster. </i>
	<br><br>However, if you get caught lying, or if you accuse someone of lying who isn't, you will have to take all the cards
	in the pot into your deck.
	<br><br><b>The first person to dispose of all their cards wins!</b>

	<form method = "POST" action = "<?php
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
	?>">
		<input type="submit" name="submit" value="Start!">
	</form>
	</div>
    </body>
</html>

<?php }

    function createDeck() {
    //generates a new deck of 52 cards
    $deck = array();

    for ($j = 0; $j < 4; $j++ ){
    //repeats for 4 suits
    switch ($j) {
    case 0:
    $xsuit = "Hearts"; break;
    case 1:
    $xsuit = "Diamonds"; break;
    case 2:
    $xsuit = "Clubs";  break;
    case 3:
    $xsuit = "Spades"; break;
    default:
    }

    for ($i = 1; $i <= 13; $i++) {
    //repeates for 13 cards per suit
    switch($i) {
    case 1:
    $xname = "ace"; break;
    case 2:
    $xname = "two"; break;
    case 3:
    $xname = "three"; break;
    case 4:
    $xname = "four"; break;
    case 5:
    $xname = "five"; break;
    case 6:
    $xname = "six"; break;
    case 7:
    $xname = "seven"; break;
    case 8:
    $xname = "eight"; break;
    case 9:
    $xname = "nine"; break;
    case 10:
    $xname = "ten"; break;
    case 11:
    $xname = "Jack"; break;
    case 12:
    $xname = "Queen"; break;
    case 13:
    $xname = "King"; break;
    default:
    }

    $card = new Card ($i, $xname, $xsuit);
    array_push($deck, $card);
    }
    }

    return $deck;

    }

    function dealDeck() {

    $handCards = array ();

    $currentCard = false;

    for ($i = 0; $i < 13; $i++){

    do {
    $x = rand(0, 51) ;
    $currentCard = $_SESSION['booleanDeck'][$x];
    } while ( !($currentCard));

    $_SESSION['booleanDeck'][$x] = FALSE;
    array_push($handCards, $_SESSION['deck'][$x]);
    }

    return $handCards;

    }

    function booleanDeck() {

    $cardArray = array(
    0=>true,
    1 => true,
    2 => true,
    3 => true,
    4 => true,
    5 => true,
    6 => true,
    7 => true,
    8 => true,
    9 => true,
    10 => true,
    11 => true,
    12 => true,
    13 => true,
    14 => true,
    15 => true,
    16 => true,
    17 => true,
    18 => true,
    19 => true,
    20 => true,
    21 => true,
    22 => true,
    23 => true,
    24 => true,
    25 => true,
    26 => true,
    27 => true,
    28 => true,
    29 => true,
    30 => true,
    31 => true,
    32 => true,
    33 => true,
    34 => true,
    35 => true,
    36 => true,
    37 => true,
    38 => true,
    39 => true,
    40 => true,
    41 => true,
    42 => true,
    43 => true,
    44 => true,
    45 => true,
    46 => true,
    47 => true,
    48 => true,
    49 => true,
    50 => true,
    51 => true

    );

    return $cardArray;
    }
?>
