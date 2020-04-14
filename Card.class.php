<?php 

class Card {
    
    var $value; 
    var $name; 
    var $suit; 
    
    public function __construct ($xvalue, $xname, $xsuit) {
        $this->value = $xvalue; 
        $this->name =  $xname; 
        $this->suit = $xsuit; 
    }
    

    public function getCardValue() {
        return $this->value; 
    }
    
    public function getCardSuit() {
        return $this->suit; 
    }
    
    public function getCardName() {
        return $this->name; 
    }
    
  public static function cmp($a, $b) 
    {
    return $a->getCardValue() - $b->getCardValue(); 
    }  
  
      
}
        
