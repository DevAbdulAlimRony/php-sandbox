<?php
namespace App;

// Iterator is PHP's build in interface
class TransactionCollection implements \Iterator{
    private int $key;
    
    public function __construct(public array $transactions){}

        public function current(){
            // return current transaction from transaction list or collection
            echo __METHOD__ . PHP_EOL; // print method name for test
            return current($this->transactions);
            // or, return $this->transactions[$this->key];
        }

        public function next(){
            // go to the next transaction
            echo __METHOD__ . PHP_EOL; // print method name for test
            next($this->transactions);
            // or, ++$this->key++;
        }

        public function key(){
            // return key of the current element
            echo __METHOD__ . PHP_EOL; // print method name for test
            return key($this->transactions);
            // or, return $this->key
        }

        public function valid(){
            // check if current position is valid, if it returns false, foreach loop will stop
            echo __METHOD__ . PHP_EOL;
            return current($this->transactions) !== false;
            // or, isset($this->transactions[$this->key])
        }

        public function rewind(){
            // Gets Called at the Beggining of the foreach loop
            echo __METHOD__ . PHP_EOL;
            reset($this->transaction);
            // or, $this->key = 0
        }

        // But We can replace all of this code by using a PHP's build in Iterator like ArrayIterator:
        // implements IteratorAggregate
        // public function getIterator(){return new \ArrayIterator($this->transactions)}
        // If you have simple array, you can use it
        // If you need more control over iterato, then can use Iterator interface with that 5 methods
}