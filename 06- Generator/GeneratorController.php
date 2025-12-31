<?php
// Normal Iterator or Loop Problem: Iterating entire large array or dataset in memory at the same time.
// Generator Solution: Iterates over a large sets of data without consuming so memory. 
// Generators provide an easy way to implement simple iterators without the overhead o complexity of implementing  a class that implements the iterator interface.
// A PHP Generator is a special function using the yield keyword that returns values one by one without loading everything into memory.
// Instead of returning an array (which loads all data), a generator produces data lazily.
// Real-life example: Chunking large database records- Laravel provides cursor() which uses a Generator internally. Another example of laravel is lazy collection.

class GeneratorController{
       public function index(){
        $a = range(1, 30000000000); // If we print_r it , it will give a fatal error of allowed memory size.
        // If we fetch 10k Model, this type large dataset can create that problem
        // Solution: Pagination, Filtering, Narrow Selection- Only Data what we need.
        // But in some cases, you need to loop over on a large dataset that will run out of memory. In that case, generator helps.
        // So, instead of range we will take a custom function to implement generator. Generator function can be a helper function or a separate controller.

        $numbers = $this->lazyRange(1, 3000000000); // Output: Nothing, just blank Page. It will start executing only when we use Iterator methods or loop over it. Even Hello wont show.

        // echo '<pre>';
        // print_r($numbers); Output- Generator Object
        // echo '<pre>';

        // Generator class implenets from Iterator in PHP. They have some method to perform on yeild returned function.
        echo $numbers->current(); // Output Hello1 
        $numbers->next(); // It basically resumes the execution.
        echo $numbers->current(); // Output Hello12, so we fetching data on demand, lazy loading.
        // $numbers->getReturn(); - To get Return value from a generator, but at first resume the execution by next()

        // We can also yeild key value pair
        foreach($numbers as $key => $number){
            echo $key . ': ' . $number;
        } // Output: 0:1, 1:2...to at last number without any memory error.
    }

    private function lazyRange(int $start, int $end): \Generator{
        // Return will stop the execution of loop, and return the value.
        // But a generator can yield as many times as it needs.
        // Yield keyword pauses generator function, return stops function execution.

        echo 'Hello';
        for($i = $start; $i <= $end; $i++){
            // return $i; - Output just 1, or if we push all values in array it will create same problem as range.
            yield $i;

            // yeild $start;
            // yeild $end;
            // For this if we call current(), first yeild will be called, the next() will stop it, and current() will execute next $yeild.

            // return '!'; - If we use return also in this generator function, we have to access it using getReturn() method

            // yield $i * 5 => $i; - key value pair, output will be: 5:1...
        }
    }

    // Real life Example of Model Fetching
    // Let's say, we have a model which has 20k data. Now we need all coulmns, we added a method called call() in our model and Post::call(), but it will show memory error. If we select only id column, not problen. But when fetching all, so many memory needs at a time.
    // Solution: Except using fetcAll(), yeild.
    // public function all(): Generator{
    //     $stmnt = $this->db->query('select id, ttle from posts');
    //     return $stmnt->fetchAll(); // problematic

    // ** Soultion
    //     foreach($stmnt as $post){
    //         yield $ticket;
    //     }
    // }


    // Disadvantages:
    // You can iterator over a generator more than once. Like if you write loop on same collection again inside same function. It will show error- Fatal error: Uncaught exception: Cannot traverse an alreday closed generator...
    // We can call $lazyRange->rewind() before the generator loop (not after or not inside the loop), it wont show error. Just work as the first iterat, second iterat will not work and will not show any error also.

    // In Laravel:
    // $orders = Order::all() → It loads all rows into RAM → crashes for 500k+ orders.
    // Solution: foreach (Order::cursor() as $order) {
         // write each row to CSV
    // }
    // Cursor loads only one row at a time → memory stays at ~3 MB even for millions of rows.
    // Real-Life Example
    // (cursor()): Sending Notifications to All Users.
    // LazyCollection: You are building CRM Poultry, Summarizing millions of follow-up records.
    // LazyCollection::make(function() {})
    // Instead of reading the entire file into memory at once, lazy collections may be used to keep only a small part of the file in memory at a given time.
    // The query builder's cursor method returns a LazyCollection instance..

    // $users = User::cursor()->filter(function (User $user) { return $user->id > 500; });
    //  the filter callback is not executed until we actually iterate over each user individually, allowing for a drastic reduction in memory usage:
}
