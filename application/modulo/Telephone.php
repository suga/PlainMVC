<?php

class Telephone {
    private $id;
    private $address;
    private $name = 'Nome';
    private $addressId;
    
    /**
     * 
     * @param string $name
     */
    public function __construct($name = null) {
        $this->name = $name;
    }
    
    public function setAddressId($id) {
        return $this->addressId = $id;
    }
    
    public function getAddressId() {
        return $this->addressId;
    }
	/**
     * @return the $id
     */
    public function getId() {
        return $this->id;
    }

	/**
     * @return the $address
     */
    public function getAddress() {
        return $this->address;
    }

	/**
     * @return the $name
     */
    public function getName() {
        return $this->name;
    }

	/**
     * @param $id the $id to set
     */
    public function setId($id) {
        $this->id = $id;
    }

	/**
     * @param $address the $address to set
     */
    public function setAddress(Address $address) {
        $this->address = $address;
    }

	/**
     * @param $name the $name to set
     */
    public function setName($name) {
        $this->name = $name;
    }    
}
