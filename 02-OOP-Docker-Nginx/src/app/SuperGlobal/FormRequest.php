<?php
namespace App\SuperGlobal;
class FormRequest{
    public function index(){
        unset($_SESSION['count']); // session_unset(), session_destroy(). Using super global is recommended
        setcookie(
            'UserName',
            'bdul Alim',
            time() - 10, 
        ); // cookie deleted, because of past time
        echo "Invoice";
    }

    public function create(){
        // Return Data as Array from GET Request
        echo '<pre>';
            var_dump($_GET);
        echo "<pre>";

        // Return Data as Array from POST Request
        echo "<pre>";
        var_dump($_REQUEST);
        echo '<pre>';

        // Return Data from Get, Post Request and Also from Cookie SuperGlobal, Dont use if You not really need
        echo "<pre>";
        var_dump($_REQUEST);
        echo "<pre>";

        // If we dont specify method, it will be simply GET Request
        // In Query String Parameter like /?foo=bar, We are getting foo=bar, It will be as array in GET super global as key value pair
        // name will be in POST superglobal as key, and input' value will be value
        // In REQUEST, if any key from GET and POST are same, key from POST will get preference
        return '<form action="/form-request/create" method="post">
                   <label>Name</label>
                   <>input type="text" name="name"></input>
                </form>';
    }

    public function store(){
        $name = $_POST['name'];
        var_dump($name);
    }
}