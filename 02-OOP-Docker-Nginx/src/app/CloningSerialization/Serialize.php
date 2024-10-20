<?php
// More in index.php

class Close{
    private $amount;

     // Serialization in object-oriented programming (OOP) in PHP is the process of converting an object into a format that can be easily stored or transmitted and then reconstructed later. This is particularly useful for saving the state of an object to a file, database, or sending it over a network.
     // Convert value from any (except resource, closure, some built in object) to string type
     // Serialization Related Magic Methods
     public function __sleep(): array{
        // Gets Called before the serialization happened
        return ['amount'];
        // when sleep seralize both used, seralize will work, same for deserialize
     }
     public function __wakeup(): void{
        // Gets Called after the object is unserialized
     }

     // Comination of Sleep, Wakeup and Serialization Interface
     public function __serialize(): array{
        // Just like sleep
        // sleep method must return names of the properties that to be seralized
        // serialize method must return an array that represents object, full control how your object is serialized
        return [
            'amount' => base64_encode($this->amount)
        ];
    }
    public function __unseralize(array $data): void{
        // Gets data as argument, extra advantage over wakeup
        // $this->amount = base64_decode($data->amount);
    }

}