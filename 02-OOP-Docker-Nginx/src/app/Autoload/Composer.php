<?php
//* Auto Loading: More Class, More line of require or include. Autoloading solve this:
// sql_autoload_register(function($class): void {
    //* We will make full path with case sensitivity
//     $path = __DIR__ . '/../' . lcfirst(str_replace('\\', '/',$class)) . '.php';
//     if(file_exists($path)){
//         require $path;
//     }
// });
// sql_autoload_register(function($class): void {
//     var_dump($class);
// }, prepend: true); 
// If multiple autoloader, it will run at first
// But we will not use this custom function for auto-loading, We will use 'composer'

// *Composer
// Composer is a Tool for Dependency Management in PHP
// We can install it manually, can install in dockerFile using curl command
// Install Package: composer require vendorExp/packageExp
// composer init : Creates composer.json file, Now you can put your package name manually there also
// composer lock file just contain exact versionof the packages. When we run 'composer install', if lock file present install based on it. If not present, it will work like composer require, lock fill will be created
// The composer.lock file prevents you from automatically getting the latest versions of your dependencies.
// If We run composer update, package will upadate as in composer.json file's version specified
// update will fetch the latest matching versions (according to your composer.json file) and update the lock file with the new versions.
// In vendor directory, all of packages source code exists.
// In JSON: require lists for production, require-dev lists for development
// In vendor, we will get autoload.php file also

//* Import Composer AutoLoader to Work
// require __DIR__ . '/../vendor/autoload.php';
// But composer dont know how to autoload our own classes. Solution:
// In composer.json, add this:
// "autload": {
//     "psr-4": {
//         "App\\": "app/"
//     }
// }
// Then, regenarate autoload files : composer dump-autoload
// Class will be added in vendor/autoload_psr4.php file
// Now, dont need to write require again and again
// composer dump-autoload -o : Generate Optimized Autoloading , all classes will be indexed in vendor/autload-classmap.php (Use just in Production to make faster)
// We should add vendor in .gitignore file


//* PSR (PHP Standard Recommendation): How will We Write Code so that It can be Consistent for Every Developer:
// https://www.php-fig.org/psr/
// Extension can be used with Editor