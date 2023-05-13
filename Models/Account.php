<?php
class Account {
    private $id;
    private $balance;
    private $type;
    private $state;
    
    public function __construct($id = null, $balance = null, $type = null) 
    {
        if($id){
            $this->id = $id;
        }
        if($balance){
            $this->balance = $balance;
        }
        if($type){
            $this->type = $type;
        }
    }
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getBalance() {
        return $this->balance;
    }
    public function setBalance($balance) {
        $this->balance = $balance;
    }
    public function getType() {
        return $this->type;
    }
    public function setType(string $type) {
        $this->type = $type;
    }
    public function getState(){
        return $this->state;
    }
    public function setState(string $State)
    {
        $this->state = $State;
    }  
}

?>