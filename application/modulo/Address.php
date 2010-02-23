<?php

class Address {
    private $id;
    private $street = 'Rua dos que não foram, 123';
    private $telephone;
    
    
    public function __construct() {
        $this->telephone = new ArrayObject();
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getStreet() {
        return $this->street;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setStreet($street) {
        $this->street = $street;
    }
    
    public function login() { 
        echo 'Here we go !';
    }
    
    public function addTelephone(Telephone $tel) {
        $this->telephone->append($tel);
    }
    
    public function setTelephones(ArrayObject $tel) {
        $this->telephone = $tel;
    }
    
    public function getTelephones() {
        return $this->telephone;
    }
}
