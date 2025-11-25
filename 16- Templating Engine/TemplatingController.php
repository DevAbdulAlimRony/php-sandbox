<?php
//Template is view file with placeholders separates the app code from presentation code
// A template is simply a file that contains: HTML, Some Placeholders, optional Logic like loops variables.
// Ex: You want to generate a page that shows the user name.
// Purpose of templates: Separate presentation (HTML) from business logic (PHP code).

// A templating engine is a tool/layer that: Lets you write cleaner templates, Minimizes raw PHP inside HTML, Provides useful syntax, Allows template inheritance (layouts), Adds security features (escaping variables) etc.
// Templating engines improve the structure of your view files.  

// How a Templating Engine Works (Internally)
// You write a template in a custom syntax (Blade, Twig, Mustache).
// The templating engine compiles it into native PHP code.
// PHP executes that compiled version.
// The output (HTML) is sent to the browser.

// return view('profile', ['user' => $user]);
// <h1>{{ $user->name }}</h1>
// PHP is a templating engine itself, but unstructured and not have all features as well as other engine.

// Laravel use blade, symphony use twig
