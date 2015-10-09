<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/user.php';
require_once __DIR__.'/note.php';

use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

$user = new User('txevans','test123','Tyler','Evans');
$users[] = $user;
$user = new User('aejacobsen','123test','Amy','Jacobsen');
$users[] = $user;
$user = new User('jxdoe','password123','John','Doe');
$users[] = $user;

$app->post('/user', function() use($app) {
	$username = $app['request']->get('username');
	$password = $app['request']->get('password');
	$firstName = $app['request']->get('firstName');
	$lastName = $app['request']->get('lastName');
	$user = new User($username,$password,$firstName,$lastName);
	//******* needs to store user in persistence *******
	return new Response(json_encode($user), 201);
});

$app->put('/user/{username}', function($username) use($app) {
	//******* needs to modify existing object not create *******
    $item = null;
    $password = $app['request']->get('password');
    $firstName = $app['request']->get('firstName');
    $lastName = $app['request']->get('lastName');

    foreach($GLOBALS['users']as $struct) {
        if ($username == $struct->username) {
            $struct->password = $password;
            $struct->firstName = $firstName;
            $struct->lastName = $lastName;
            $item = $struct;
        }
    }

	return new Response(json_encode($item), 200);
});

$app->get('/user', function() use($app) {
	//******* needs to get users from persistence *******
	//$users = apc_fetch('users');
	//apc_store('users',$users,0);

	return new Response(json_encode($GLOBALS['users']), 200);
});

$app->get('/user/{username}', function($username) use($app) {
	//******* needs to get user with correct username out of persistence *******
    $item = null;
    foreach($GLOBALS['users']as $struct) {
        if ($username == $struct->username) {
            $item = $struct;
            break;
        }
    }

	return new Response(json_encode($item), 200);
});

$app->delete('/user/{username}', function($username) use($app) {
    $users = $GLOBALS['users'];
    $index = -1;
    for($i = 0; $i < sizeof($users); $i++)
    {
        if($users[$i]->username == $username)
        {
            $index = $i;
        }
    }

    if($index != -1)
    {
        unset($users[$index]);
        $users = array_values($users);
        var_dump($users);
    }
    return new Response(json_encode($users), 200);
});

//-------------------------------------------NOTES

$cars = array("Volvo", "BMW", "Toyota");
$note = new Note(1, 'Foobar','This is the body of the note','txevans',$cars);
$notes[] = $note;

$cars = array("VW", "Audi", "Fiat");
$note = new Note(2, 'Ah No','This is a lot of body','txevans',$cars);
$notes[] = $note;

$cars = array("Ford", "Chevrolet", "Dodge");
$note = new Note(3, 'Ah yes','Not enough body','aejacobsen',$cars);
$notes[] = $note;

$app->post('/note', function() use($app) {
    $name = $app['request']->get('name');
    $body = $app['request']->get('body');
    $username = $app['request']->get('username');
    $tags = $app['request']->get('tags');
    $note = new Note(4,$name,$body,$username,$tags);
    //******* needs to store user in persistence *******
    return new Response(json_encode($note), 201);
});

$app->put('/note/{id}', function($id) use($app) {
    //******* needs to modify existing object not create *******
    $item = null;
    $name = $app['request']->get('name');
    $body = $app['request']->get('body');
    $username = $app['request']->get('username');
    $tags = $app['request']->get('tags');

    foreach($GLOBALS['notes']as $struct) {
        if ($id == $struct->id) {
            $struct->name = $name;
            $struct->body = $body;
            $struct->username = $username;
            $struct->tags = $tags;
            $item = $struct;
        }
    }

    return new Response(json_encode($item), 200);
});

$app->get('/note', function() use($app) {
    return new Response(json_encode($GLOBALS['notes']), 200);
});

$app->get('/note/{id}', function($id) use($app) {
    //******* needs to get user with correct username out of persistence *******
    $item = null;
    foreach($GLOBALS['notes']as $struct) {
        if ($id == $struct->id) {
            $item = $struct;
            break;
        }
    }

    return new Response(json_encode($item), 200);
});

$app->delete('/note/{id}', function($id) use($app) {
    //******* needs to modify existing object not create *******
    $notes = $GLOBALS['notes'];
    $numId = intval($id);
    $index = -1;
    for($i = 0; $i < sizeof($notes); $i++)
    {
        if($notes[$i]->id == $numId)
        {
            $index = $i;
        }
    }

    if($index != -1)
    {
        unset($notes[$index]);
        $notes = array_values($notes);
        var_dump($notes);
    }
    return new Response(json_encode($notes), 200);
});

$app->run();