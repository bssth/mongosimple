### Deprecated
#### The library was made quite a while ago and may be out of date. Please make a fork if you want to use it.

# Overview

MongoSimple provides simple middleware for CRUD operations 
between MongoDB extension and your scripts.

# Installation

Just download *src/MongoSimple.php* script
or install it using Composer:

`composer require mikechip/simplemongo`

# Usage

Here's a cheatsheet for all methods:

```
<?php
    // Init composer
    require_once('vendor/autoload.php');

    $db = new \Mike4ip\MongoSimple('mongodb://127.0.0.1', 'testdb');

    // Create user
    $db->insert('users', [
        'email' => 'me@example.com',
        'password' => sha1('123123123'),
        'login' => 'admin'
    ]);

    // Update user. No $set is needed
    $db->update('users', ['login' => 'admin'], ['password' => sha1('321321321')]);

    // Find one user
    print_r($db->findOne('users', []));

    // Find all users
    foreach($db->find('users', []) as $user)
        print_r(iterator_to_array($user));

    // Count users
    print($db->count('users', []));

    // Delete user
    $db->delete('users', ['login' => 'admin']);
```
    
# Feedback

Use issues to contact. Pull requests are also welcome.
