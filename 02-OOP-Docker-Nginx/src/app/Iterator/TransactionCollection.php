<?php
namespace App\Iterator;

// Iterator is PHP's build in interface
class TransactionCollection implements \Iterator{
    private int $key;

    //* Used In index.php
    
    public function __construct(public array $transactions){}

        public function current(): mixed{
            // return current transaction from transaction list or collection
            echo __METHOD__ . PHP_EOL; // print method name for test
            return current($this->transactions);
            // or, return $this->transactions[$this->key];
        }

        public function next(): void{
            // go to the next transaction
            echo __METHOD__ . PHP_EOL; // print method name for test
            next($this->transactions);
            // or, ++$this->key++;
        }

        public function key(): int|string|null{
            // return key of the current element
            echo __METHOD__ . PHP_EOL; // print method name for test
            return key($this->transactions);
            // or, return $this->key
        }

        public function valid(): bool{
            // check if current position is valid, if it returns false, foreach loop will stop
            echo __METHOD__ . PHP_EOL;
            return current($this->transactions) !== false;
            // or, isset($this->transactions[$this->key])
        }

        public function rewind(): void{
            // Gets Called at the Beggining of the foreach loop
            echo __METHOD__ . PHP_EOL;
            reset($this->transactions);
            // or, $this->key = 0
        }

        // But We can replace all of this code by using a PHP's build in Iterator like ArrayIterator:
        // implements IteratorAggregate
        // public function getIterator(){return new \ArrayIterator($this->transactions)}
        // If you have simple array, you can use it
        // If you need more control over iteraton, then can use Iterator interface with that 5 methods
}