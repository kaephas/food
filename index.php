<?php
/**
 * Created by PhpStorm.
 * User: Kaephas Kain
 * Date: 2019-04-12
 * Filename: index.php
 * Description: loads error reporting, composer, fat free, setting default route to views/home.html
 */

session_start();

//Turn on error reporting
ini_set('display_errors' ,1);
error_reporting(E_ALL);

//require autoload file
require_once('vendor/autoload.php');

//create an instance of the Base class
$f3 = Base:: instance();

//Turn on Fat-free error reporting
$f3 -> set('DEBUG', 3);

//Define a default route
$f3->route('GET /', FUNCTION()
{
    $view = new Template();
    echo $view-> render('views/home.html');
});

$f3->route('GET /breakfast', FUNCTION()
{
    // display breakfast view
    $view = new Template();
    echo $view-> render('views/breakfast.html');
});

$f3->route('GET /breakfast/continental', FUNCTION()
{
    // display breakfast view
    $view = new Template();
    echo $view-> render('views/bfast-cont.html');
});

$f3->route('GET /lunch', FUNCTION()
{
    // display lunch view
    $view = new Template();
    echo $view-> render('views/lunch.html');
});

$f3->route('GET /lunch/brunch/buffet', FUNCTION()
{
    // display lunch view
    $view = new Template();
    echo $view-> render('views/brunch.html');
});

// define a route with a parameter
$f3->route('GET /@item', function($f3, $params)
{
    $item = $params['item'];



    switch($item) {
        case 'spaghetti':
            echo "<h3>I like $item with meatballs.</h3>";
            break;

        case 'pizza':
            echo "<h3>Pepperoni or veggie?</h3>";
            break;

        case 'tacos':
            echo "<h3>We don't have $item.</h3>";
            break;

        case 'bagel':
            $f3->reroute("/breakfast/continental");

        default:
            $f3->error(404);
    }
});

$f3->route('GET /@first/@last', function($f3, $names) {

    echo ucfirst($names['first']) . " " . ucfirst($names['last']);
});

$f3->route('GET /order', function() {
    // new form view
    $view = new Template();
    echo $view->render("views/form1.html");
});

$f3->route('POST /meal', function() {
//    print_r($_POST);
    $_SESSION['food'] = $_POST['food'];

    $view = new Template();
    echo $view->render("views/form2.html");
});

$f3->route('POST /summary', function() {
//    print_r($_POST);
    $_SESSION['meal'] = $_POST['meal'];

    $view = new Template();
    echo $view->render("views/summary.html");
});

//run Fat-free
$f3 -> run();
