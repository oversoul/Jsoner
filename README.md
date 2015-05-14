# Jsoner
php json file handler

**To use it:**
````
require 'jsoner/FileLoader.php';
require 'jsoner/Jsoner.php';

$file = 'data/info.json';
// create instance
$jsoner = new Jsoner();
// load Json file
$jsoner->load($file);
````

with the ````$jsoner```` object you can:
* Add new element:
````
$jsoner->set('name', 'your name');
//or
$jsoner->name = 'your name';
//or
$jsoner['name'] = 'your name';
````

* Remove an element:
````
$jsoner->forget('name');
//or
unset( $jsoner->name );
//or
unset( $jsoner['name'] );
````

* Get an element:
````
$jsoner->get('name');
//or
$jsoner->name;
//or
$jsoner['name'];
// in case of multi dimentional array 
$jsoner->get('person.name');
$jsoner->person->name;
$jsoner['person']['name'];
````

* Check if key exists:
````
$jsoner->has('name');
// in case of multi dimentional array 
$jsoner->has('person.name');
````

*To get raw array data
````
$jsoner->toArray();
````

when done you can save the modifications to the file!

````
$jsoner->save();
````