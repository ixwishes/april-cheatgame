<?php

include 'Card.class.php';
include 'NPC.class.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch($_GET["player"]) {
        case 1 :
            $playerhand = "NPC1Hand";
            $player = $_SESSION["NPC1"];
            break;
        case 2 :
            $playerhand = "NPC2Hand";
            $player = $_SESSION["NPC2"];
            break;
        case 3 :
            $playerhand = "NPC3Hand";
            $player = $_SESSION["NPC3"];
            break;
        default:
    }

    if ( $_POST['submit'] == 'Accuse of Cheating!') {
        
        //determines if the NPC cheated
        $badCards = 0;
        for ($i = 0; $i < count($_SESSION['NPCplayed']); $i++) {
            if ($_SESSION['NPCplayed'][$i] -> getCardValue() != $_SESSION['cardValue']) {
                $badCards++;
            }
        }

        //if NPC cheated, make them take the pot
        if ($badCards > 0) {

           $_SESSION["$playerhand"] = array_merge($_SESSION["$playerhand"], $_SESSION['pot']);
           $_SESSION['pot'] = array(); 
            header('Location: cheat2.php?player=' . $_GET["player"] . '&cheat=user&result=success');
            exit();

        } else {

            //if didn't cheat, user takes the pot
           $_SESSION['pot'] = array_merge($_SESSION['pot'], $_SESSION['NPCplayed']);
            $_SESSION['userHand'] = array_merge($_SESSION['userHand'], $_SESSION['pot']);
            $_SESSION['pot'] = array(); 

            //unset cards from NPC hand
            for ($i = 0; $i < count($_SESSION['NPCplayedindex']); $i++) {
                unset($_SESSION["$playerhand"][$_SESSION['NPCplayedindex'][$i]]);
            }

            $_SESSION["$playerhand"] = array_values($_SESSION["$playerhand"]);
            
            header('Location: cheat2.php?player=' . $_GET["player"] . '&cheat=user&result=failure');
            exit();
        }

    } else {
        
        
        $cheat = false;

        //check if other NPC will accuse of cheating if user has not
        if (willAccuse(howManyCards($_SESSION["NPC1Hand"], $_SESSION['cardValue']), count($_SESSION['NPCplayed']), $_SESSION["NPC1"] -> getMedRisk(), $_SESSION["NPC1"] -> getHighRisk())) {
            if ($player != $_SESSION["NPC1"]) {
                $cheat = true;
                $accusingPlayer = 1;
            }
        } else if (willAccuse(howManyCards($_SESSION["NPC2Hand"], $_SESSION['cardValue']), count($_SESSION['NPCplayed']), $_SESSION["NPC2"] -> getMedRisk(), $_SESSION["NPC2"] -> getHighRisk())) {
            if ($player != $_SESSION["NPC2"]) {
                $cheat = true;
                $accusingPlayer = 2;
            }
        } else if (willAccuse(howManyCards($_SESSION["NPC3Hand"], $_SESSION['cardValue']), count($_SESSION['NPCplayed']), $_SESSION["NPC3"] -> getMedRisk(), $_SESSION["NPC3"] -> getHighRisk())) {
            if ($player != $_SESSION["NPC3"]) {
                $cheat = true;
                $accusingPlayer = 3;
            }
        }

            if (!$cheat) {

                //if no one has accused of cheating, add cards to the pot and exit to result page
                
                //unset cards from NPC hand
                for ($i = 0; $i < count($_SESSION['NPCplayedindex']); $i++) {
                unset($_SESSION["$playerhand"][$_SESSION['NPCplayedindex'][$i]]);
                }

                $_SESSION['pot'] = array_merge($_SESSION['pot'], $_SESSION['NPCplayed']);
                $_SESSION['NPCplayedindex'] = array(); 
                $_SESSION["$playerhand"] = array_values($_SESSION["$playerhand"]);
                
                header('Location: cheat2.php?player=' . $_GET["player"]);
                exit();

            } else {
                 //determines if the NPC cheated
                $badCards = 0;
                for ($i = 0; $i < count($_SESSION['NPCplayed']); $i++) {
                     if ($_SESSION['NPCplayed'][$i] -> getCardValue() != $_SESSION['cardValue']) {
                        $badCards++;
                    }
                }
                

                // if NPC was actually cheating, add pot to their hand.
                if ($badCards > 0) {
                   $_SESSION["$playerhand"] = array_merge($_SESSION["$playerhand"], $_SESSION['pot']);
                    $_SESSION['pot'] = array();
               
                    header('Location: cheat2.php?player=' . $_GET["player"] . '&cheat='. $accusingPlayer . '&result=success');
                    exit();

                } else {

                    //if NPC was not cheating, accusing player takes the pot
                    $_SESSION['pot'] = array_merge($_SESSION['pot'], $_SESSION['NPCplayed']);
                   

                    if ($accusingPlayer == 1) {
                        $_SESSION['NPC1Hand'] = array_merge($_SESSION['NPC1Hand'], $_SESSION['pot']);
                        $_SESSION['pot'] = array();

                    } else if ($accusingPlayer == 2) {
                        $_SESSION['NPC2Hand'] = array_merge($_SESSION['NPC2Hand'], $_SESSION['pot']);
                        $_SESSION['pot'] = array();

                    } else if ($accusingPlayer == 3) {
                       $_SESSION['NPC3Hand'] = array_merge($_SESSION['NPC3Hand'], $_SESSION['pot']);
                        $_SESSION['pot'] = array();

                    }
                    //unset cards from NPC hand
                for ($i = 0; $i < count($_SESSION['NPCplayedindex']); $i++) {
                unset($_SESSION["$playerhand"][$_SESSION['NPCplayedindex'][$i]]);
                }
                    $_SESSION["$playerhand"] = array_values($_SESSION["$playerhand"]);
                    
                   header('Location: cheat2.php?player=' . $_GET["player"] . '&cheat='. $accusingPlayer . '&result=failure');
                    exit();
                }

            }
        

    }

} else {

    switch($_GET["player"]) {
        case 1 :
            $player = $_SESSION["NPC1"];
            $playerHand = $_SESSION['NPC1Hand'];
            break;
        case 2 :
            $player = $_SESSION["NPC2"];
            $playerHand = $_SESSION['NPC2Hand'];
            break;
        case 3 :
            $player = $_SESSION["NPC3"];
            $playerHand = $_SESSION['NPC3Hand'];
            break;
    }

    //temp array for the cards that NPC can play without cheating
    $tmp_hand = array();
    $handIndex = array();
    for ($i = 0; $i < count($playerHand); $i++) {

        if ($playerHand[$i] -> getCardValue() == $_SESSION['cardValue']) {
            array_push($tmp_hand, $playerHand[$i]);
            array_push($handIndex, $i);
        }

    }

    if (count($tmp_hand) >= 3) {
        //if NPC has 3 or more legit cards, play them now
        $_SESSION['NPCplayed'] = $tmp_hand;
        $_SESSION['NPCplayedindex'] = $handIndex;
        header('Location: wait.php?player=' . $_GET["player"] . '&number=' . count($tmp_hand));
        exit();

    } else if (count($tmp_hand) > 0) {
        //if NPC has 1-2 cards, play rand to decide if they will risk cheating by playing another card
        $x = rand(1, 100);
        if ($x > $player -> getMedRisk()) {
            do {
                $addCard = rand(0, count($playerHand) - 1);
            } while (in_array($addCard, $handIndex));

            array_push($tmp_hand, $playerHand[$addCard]);
            array_push($handIndex, $addCard);
        }
        $_SESSION['NPCplayed'] = $tmp_hand;
        $_SESSION['NPCplayedindex'] = $handIndex;
        header('Location: wait.php?player=' . $_GET["player"] . '&number=' . count($tmp_hand));
        exit();

    }

    //if there were no cards to play, play a random card

    $addCard = rand(0, count($playerHand) - 1);
    array_push($tmp_hand, $playerHand[$addCard]);
    array_push($handIndex, $addCard);

    //play rand to see if NPC will risk playing another card
    $x = rand(1, 100);
    if ($x > $player -> getMedRisk()) {
        do {
            $addCard = rand(0, count($playerHand) - 1);
        } while (in_array($addCard, $handIndex));

        array_push($tmp_hand, $playerHand[$addCard]);
        array_push($handIndex, $addCard);

    }

    if ($x > $player -> getHighRisk()) {
        //play rand to see if NPC will risk playing yet another card
        do {
            $addCard = rand(0, count($playerHand) - 1);
        } while (in_array($addCard, $handIndex));

        array_push($tmp_hand, $playerHand[$addCard]);
        array_push($handIndex, $addCard);

    }

    $_SESSION['NPCplayed'] = $tmp_hand;
    $_SESSION['NPCplayedindex'] = $handIndex;
    header('Location: wait.php?player=' . $_GET["player"] . '&number=' . count($tmp_hand));
    exit();

}

function willAccuse($numCards, $numPlayed, $medRisk, $highRisk) {
    //determines if a given character will accuse the user of cheating

    if (($numCards + $numPlayed) > 4) {
        //can be certain of cheating since there are only 4 cards of a value per deck
        return true;
    } else if (($numCards + $numPlayed) >= 3) {
        //medium risk to accuse of cheating
        $x = rand(1, 100);
        if ($x > $medRisk) {
            return true;
        }

    } else if (($numCards + $numPlayed) < 3) {
        //high risk to accuse of cheating.
        $x = rand(1, 100);
        if ($x > $highRisk) {
            return true;
        }

    }

    return false;
}

function howManyCards($cardArray, $xvalue) {
    $count = 0;

    //returns how many of a given value a player has

    for ($i = 0; $i < count($cardArray); $i++) {
        if ($cardArray[$i] -> getCardValue() == $xvalue) {
            $count++;
        }
    }

    return $count;
}
?>