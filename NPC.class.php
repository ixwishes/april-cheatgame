<?php

class NPC {
    var $NPCname; 
    
    //the higher this stat is, the more likely this NPC will be to take a high cheat action. 
    var $highRisk; 
    var $medRisk; 
     
    
    public function __construct ($xname, $xhighRisk, $xmedRisk ){
        $this->name = $xname; 
        $this->highRisk = $xhighRisk; 
        $this->medRisk = $xmedRisk; 
        
    }
    
    public function getName() {
        return $this->name; 
    }
    
    public function getHighRisk() {
        return $this->highRisk; 
    }
    
    public function getMedRisk() {
        return $this->medRisk; 
    }
    
}


?>