<?php
$argv = $_SERVER['argv'];
$argc = $_SERVER['argc'];

if ($argc < 2) {
    echo "Usage: php app.php <command> [arguments]\n";
    echo "Available commands: greet, sum\n";
    exit(1);
}

$command = $argv[1];        // greet | sum
$args    = array_slice($argv, 2);

switch ($command) {
    case 'greet':
        greetCommand($args);
        break;

    case 'sum':
        sumCommand($args);
        break;

    default:
        echo "Unknown command: {$command}\n";
        echo "Available commands: greet, sum\n";
        exit(1);
}

// ------------- Commands ----------------

function greetCommand(array $args): void
{
    if (count($args) < 1) {
        echo "Usage: php app.php greet <name>\n";
        return;
    }

    $name = $args[0];
    echo "Hello, {$name}!\n";
}

function sumCommand(array $args): void
{
    if (count($args) < 2) {
        echo "Usage: php app.php sum <a> <b>\n";
        return;
    }

    $a = (float) $args[0];
    $b = (float) $args[1];

    echo "{$a} + {$b} = " . ($a + $b) . "\n";
}


// Output:
// php app.php greet Mahbub
# Hello, Mahbub!

// php app.php sum 10 25.5
# 10 + 25.5 = 35.5

