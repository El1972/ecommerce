<!-- WEB.PHP -->


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

/*
|---------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------
|
| Here is where you can register web routes for your application. 
  These routes are loaded by the RouteServiceProvider within a 
  group which contains the "web" middleware group. Now create 
  something great!
|
*/

//----------------------------L A R A C A S T S--------------------------------

// WEB.PHP

use Illuminate\Support\Facades\Route;

Route::get('posts/{post}', function($slug){

    $path = __DIR__ . "/../resources/posts/{$slug}.html";

    if(!file_exists($path)){
        return redirect('/');
    }

    $post = cache()->remember("posts/{$slug}", now()->addMinutes(20)/* 1200 */, 
    function() use ($path){
        var_dump('file_get_contents');
        return file_get_contents($path);
    });

    return view('post',[
        'post' => $post
    ]);
})->where('post', '[A-z_\-]+');

?>


// POST.BLADE.PHP

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    <link rel="stylesheet" href="/app.css">
    </head>
    <body class="antialiased">
      
      <p>{{$post}}</p>

        <a href="/">Go Back</a>
    </body>
</html>

<?php

//--------------------------------------------------------------------

// WEB.PHP

use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('posts/{post}', function($slug){

    return view('post', [

        'post' => Post::find($slug)

    ]);


})->where('post', '[A-z_\-]+');



// MODEL/POST.PHP

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class Post {

public static function find($slug){

    if(!file_exists($path = resource_path("posts/{$slug}.html"))){

        throw new ModelNotFoundException();
    }

    $post = cache()->remember("posts/{$slug}", 1200, 
    function() use ($path){
        var_dump('file_get_contents');
        return file_get_contents($path);
    });

    return view('post',[
        'post' => $post
    ]);
}

}


// POST.BLADE.PHP

?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    <link rel="stylesheet" href="/app.css">
    </head>
    <body class="antialiased">
      
      <p>{{$post}}</p>

        <a href="/">Go Back</a>
    </body>
</html>

<?php






//----------------------------------D A R Y-------------------------------------



            // 14) RETURNING ENV VARIABLE IN WEB.PHP

Route::get('/', function(){
    return env('DB_DATABASE');  // not recommended to mess with
});

//--------------------------------------------------------------


                    // 18) BASIC ROUTING

// WEB.PHP

Route::get('/', function(){
    return view('Hello Elkhan'); // inside of function we can
                                 // do whatever we want !!!   
});

// whenever user makes get request inside of homepage '/', it's
// going to look inside of 'views' directory for a file called
// welcome (posts.blade.php);

Route::get('/', function(){
    return view('welcome');
});

Route::get('/users', function(){
    return 'Elkhan you learning';
});


//--------------------------------------------------------------

            
               // 19) HTTP RESPONSES IN ROUTING

// WEB.PHP

// Route that sends back a view
Route::get('/', function(){
    return view('Hello Elkhan');                               
});

// Route to users - string
Route::get('/users', function(){
    return 'Elkhan you learning';
});

// Route to users - Array(JSON) - Laravel automatically
// converts array to a JSON resopnse!!!
Route::get('/users', function(){
    return ['PHP', 'HTML', 'Laravel'];
});

// response()
// But we can also send back JSON object instead of array
Route::get('/json_array', function(){// '/json-array' works too
    return response()->json([
        'name' => 'Elhan',
        'age' => 48
    ]);
});

// redirects()
// Route to users with function. Redirects to 'array' page
Route::get('/function', function(){
    return redirect('/array');
});


//--------------------------------------------------------------


            
                  // 20) CREATING OUR FIRST PAGE

// WEB.PHP

// So we're saying whenever someone goes to our landing page or
// home page, return a view called 'home'(home.blade.php) 
Route::get('/', function(){
    return view('home');                               
});

?>

-- HOME.BLADE.PHP
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello Elhan</h1>
</body>
</html>


<?php

//--------------------------------------------------------------

            
                       // 21) CONTROLLERS


// Normally we would create a file ProductsController.php in
// Controllers folder. Tnen define a namespace which is a path to
// this directory. Then we create our class ProductsController
// which extends the core controller


// ProductsController.php

namespace App\Http\Controllers;

class ProductsController extends Controller {

}

// But this is too long to write!!!

// Instead we can use artisan command to create not only a
// controller but a lot more things

// So we go: php artisan --help (to see a list of commands)
// We go: php artisan list, and we see a complete list of all
// php artisan commands !!!

// So we choose make:controller

// And we go: php artisan make:controller ProductsController

// This: php artisan make:controller ProductsController -help
// we'll print a list with different flags that have some 
// meaning. For example if we'll write:

// php artisan make:controller ProductsController --force

// it'll overwrite an existing controller



// WEB.PHP

// It's not a good idea to send back a view from inside of
// web.php. But instead we'd want to return a controller and
// then send back a view.
// So first of all in web.php we need to add a new use of the 
// right controller that we would like to use. So at the top:

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController; // must register Ctlr

// Laravel 8 (New Way - Preffered)
Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/about', [ProductsController::class, 'about']);

// in Addition: 

// Laravel 8 (Also New - But it's too long to write)
Route::get('/products', 'Main\Http\Controllers\ProductsController@index');

// // Before Laravel 8 - This is an old method that won't work
Route::get('/products', 'ProductsController@index');



// ProductsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        return view('products.index'); // . is /
    }

    // In our ProductsController we can send back whatever we
    // want

    public function about(){
        return 'About us page';
    }
}

?>


-- VIEWS/PRODUCTS/INDEX.BLADE.PHP
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Products</h1>
</body>
</html>


<?php


//--------------------------------------------------------------


                // 22) PASSING DATA TO THE VIEWS

// We'd like to pass in some data to the view.
// There are couple of ways how we can do it, so let see them
// all



// 1)  compact() - method (sends data to the view)

// WEB.PHP

Route::get('/products', [ProductsController::class, 'index']);


// PRODUCTSCONTROLLER.PHP

class ProductsController extends Controller {

    public function Index(){
        $title = "Welcome to my Laravel 8 course";
        return view('products.index', compact('title'));
    }
}

?>

-- VIEWS/PRODUCTS/INDEX.BLADE.PHP 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Products</h1>
    <p>{{$title}}</p>
</body>
</html>

<?php




// 2)
// WEB.PHP

Route::get('/products', [ProductsController::class, 'index']);


// PRODUCTSCONTROLLER.PHP

// passing mustiple variables to the view
class ProductsController extends Controller {

     public function Index(){
         $title = "Hello my son";
         $description = "It's your course";
         return view("products.index", // <-- In Views: products(folder), index(name of the file). Or products/index - is the same
         compact ('title', 'description'));
     }
    }

?>


-- VIEWS/PRODUCTS/INDEX.BLADE.PHP 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Products</h1>
    <p>{{$title}}</p>
    <p>{{$description}}</p>
</body>
</html>

<?php



// 3)  with() - method (with variable that has a value of)

// WEB.PHP

Route::get('/products', [ProductsController::class, 'index']);


// PRODUCTSCONTROLLER.PHP

    class ProductsController extends Controller {

        public function Index(){
            $title = "Hello my son";

            // you can pass only one variable with with() method
           return view("products.index")->with('title', $title);
        }
       }

?>

-- VIEWS/PRODUCTS/INDEX.BLADE.PHP 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Products</h1>
    <p>{{$title}}</p>
</body>
</html>

<?php




// 4) displaying an array

// WEB.PHP

Route::get('/products', [ProductsController::class, 'index']);



// PRODUCTSCONTROLLER.PHP

Route::get('/products', [ProductsController::class, 'index']);

       class ProductsController extends Controller {

        public function Index(){
   
            $data = [
                'productsOne' => 'iPhone',
                'productTwo' => 'Samsung'
            ];
   
            return view('products.index')->with('data', $data);
       }
   }

?>


-- VIEWS/PRODUCTS/INDEX.BLADE.PHP 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Products</h1>
    @foreach($data as $item)
        <p>
            {{ $item }}
        </p>
    @endforeach
</body>
</html>

<?php



// 5) displaying array directly in the view

// WEB.PHP

Route::get('/products', [ProductsController::class, 'index']);



// PRODUCTSCONTROLLER.PHP

   class ProductsController extends Controller {

    public function Index(){

        $data = [
            'productsOne' => 'iPhone',
            'productTwo' => 'Samsung'
        ];

        return view('products.index', [
            'data' => $data
        ]);

   }
}

?>


-- VIEWS/PRODUCTS/INDEX.BLADE.PHP 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Products</h1>
    @foreach($data as $item)
        <p>
            {{ $item }}
        </p>
    @endforeach
</body>
</html>

<?php


//-------------------------------------------------------------


                    // 23) ROUTE PARAMETERS 


// Named Params Examples - shows all products(1), specific(2),
// id(3):
// /products = all products
// /products/productName
// /products/id


// 1) passing an id

// WEB.PHP 
Route::get('/products/{id}', [ProductsController::class, 'show']);


// PRODUCTSCONTROLLER.PHP 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function show($id){
        return $id;
    }

}




// 2) passing product(or name) parameter

// WEB.PHP 

Route::get('/products/{name}', [ProductsController::class, 'show']);



// PRODUCTSCONTROLLER.PHP 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller {

    public function show($name){
        $data = [
            'iphone' => 'iPhone',
            'samsung' => 'Samsung'
        ];

        return view('products.index', [ 
            'products' => $data[$name] 
        ]);

// with the statement below you cover both scenarios !!!
// to let the user know, that current name(product) doesn't exist
return view('products.index', [
    'products' => $data[$name] ?? 'Product ' . $name . ' does not exist'
]);
    
    }

}

?>

-- VIEWS/PRODUCTS/INDEX.BLADE.PHP 
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
    <h1>Products</h1>
    <p>
        {{ $products }}  
    </p>
</body>
</html>

<?php




// 3) What we can do is to prevent users to write wrong data 
// type in the url, with the where() method on the route 
// instance

// WEB.PHP 

// what we want to do right now is to only let the user add an
// integer in the url
Route::get('/products/{id}', // these ids match
[ProductsController::class, 'show']) -> where('id', '[0-9]+');



// PRODUCTSCONTROLLER.PHP

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller {

    public function show($name){
        $data = [
            'iphone' => 'iPhone',
            'samsung' => 'Samsung'
        ];

    return view('products.index', [
    'products' => $data[$name] ?? 'Product ' . $name . ' does not exist'
]);
    
    }

}

?>


-- VIEWS/PRODUCTS/INDEX.BLADE.PHP 
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
    <h1>Products</h1>
    <p>
        {{ $products }}  
    </p>
</body>
</html>

<?php




// 4) And the same can be done for strings

// WEB.PHP 

Route::get('/products/{name}', // these name's match
 [ProductsController::class, 'show']) -> where('name', '[a-zA-Z]+');


// PRODUCTSCONTROLLER.PHP

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller {

    public function show($name){
        $data = [
            'iphone' => 'iPhone',
            'samsung' => 'Samsung'
        ];

    return view('products.index', [
    'products' => $data[$name] ?? 'Product ' . $name . ' does not exist'
]);
    
    }

}

?>


-- VIEWS/PRODUCTS/INDEX.BLADE.PHP 
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
    <h1>Products</h1>
    <p>
        {{ $products }}  
    </p>
</body>
</html>

<?php




// 5) The last thing we'll see how to work with multiple
// patterns

// WEB.PHP 

// !!! Pattern, needs to be in the same order as the endpoints
//  otherwise it won't work !!!
Route::get('/products/{name}/{id}',    // <--- Endpoints
 [ProductsController::class, 'index']) -> where([
        'name' => '[a-z]+',     // <--- Patterns
        'id' => '[0-9]+'
    ]);



// PRODUCTSCONTROLLER.PHP

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller {

    public function show($name){
        $data = [
            'iphone' => 'iPhone',
            'samsung' => 'Samsung'
        ];

    return view('products.index', [
    'products' => $data[$name] ?? 'Product ' . $name . ' does not exist'
]);
    
    }

}

?>


-- VIEWS/PRODUCTS/INDEX.BLADE.PHP 
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
    <h1>Products</h1>
    <p>
        {{ $products }}  
    </p>
</body>
</html>

<?php


//-------------------------------------------------------------


                    // 24) NAMED ROUTES  

// it let's you refer to our route when generating redirects
// or urls more comfortably

// WEB.PHP

// what we want to do in simple terms is basically to assign 
// a nickname to this specific route with the name() method.
// And inside the method we can write any name that we want.
// and this can be identical to the endpoint 'products' or it
// can be something else. But it's recommeded to keep 
// identical to the endpoint


// You just name them here in web.php. In case, you'll
// decide to cars the uri path, all you have to do just
// cars the uri itself in the web.php. Named routes will
// reflect the uri changes automatically in the views
Route::get('/products', 
    [ProductsController::class, 'index'])->name('products');



// route() method is a global method. So to specify index page
// of our products directory, we can use route() to reffer to
// the name of 'products'

// PRODUCTSCONTROLLER.PHP

class ProductsController extends Controller {

    public function Index(){

        print_r(route('products'));

        return view('products.index');

   }
}

?>

-- VIEWS/PRODUCTS/INDEX.BLADE.PHP 
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
    <h1>Products</h1>
    <p>
        {{ $products }}  
    </p>
</body>
</html>

<?php




// and it's also handy when working with the buttons. This is
// very useful when you want to link stuff easier to each 
// other. And you can easily cars the url without changing
// all of its preferences

?>

-- VIEWS/PRODUCTS/INDEX.BLADE.PHP 
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
    <h1>Products</h1>
    <p>
        {{ $products }}  
        <a href="{{ route('products') }}">Products</a>
    </p>
</body>
</html>

<?php



//------------------------------------------------------------


//                    VIEWS  

// It's a big chapter so we'll divide into parts:

// 1) Layouts Structure (Separate Header & Footer) - beginning
// 2) Active Class - 2:23:13
// 3) Displaying Images - 2:27:18
// 4) Writing Controll Structures - 2:33:24

// Laravel comes with blade templating engine which lets us
// design a unique layout called blade. Two of the primary
// benefits of using blade are: template inheritance and
// sections. Just like in php most of the web applications
// will have the same layout accross the web page. Think about
// the navigation, the footer or the head. In addition to 
// template inheritance blade comes with lots of shortcuts of
// common php control structures instead of constantly adding
// for example: opening and closing php tag with if()
// statement inside of it, we can basically say:
?>

@php

@endphp 

or

@if ()

@endif

<?php

// and we go into if statement directive. And the cool thing
// inside of directives of laravel itself is that we can add
// html elements inside of it



// WEB.PHP

Route::get('/', [PagesController::class, 'index']);



// PAGESCONTROLLER.PHP

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('index');
    }

    public function about(){
        return view('about');
    }
}


?>

we create Layouts folder inside of Views folder and place
app.blade.php in it. Inside of app.blade.php we place header
and the footer and method yield() in the middle. 
yield() - is used to define a section in a layout and it's
constantly used to get content from a child page into a 
master page. So app.blade.php is a master page, and index.
blade.php is a child page. We need to give our yield() a
name. So it's basically a section, so let's say 'content'


-- VIEWS/LAYOUTS/APP.BLADE.PHP

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Personal Website - Code With Dary
    </title>
    <link 
        rel="stylesheet" 
        href="style.css"
    />
    <link 
        href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;900&display=swap" 
        rel="stylesheet"
    />
    <link 
        rel="stylesheet" 
        href="//use.fontawesome.com/releases/v5.0.7/css/all.css"
    />
</head>

<body>
    <header>
        <!-- Navigation -->
        <nav class="top-menu-container">
            <div class="logo-header">
                <a href="">
                    <img 
                    src="https://cdn.pixabay.com/photo/2017/02/18/19/20/logo-2078018_960_720.png" 
                    alt="Logo personal portfolio"
                    title="Logo personal portfolio"
                    />
                </a>
            </div>

            <ul>
                <li>
                    <a href="">About</a>
                </li>
                <li>
                    <a href="">Portfolio</a>
                </li>
                <li>
                    <a href="">Contact</a>
                </li>
            </ul>
        </nav>
    </header>


   @yield('content');


    <footer>
        <div class="container-footer">
            <img 
                src="https://cdn.pixabay.com/photo/2017/02/18/19/20/logo-2078018_960_720.png" 
                alt="Logo personal portfolio"
                title="Logo personal portfolio"
                />
            <p>
                This website is created by Code With Dary
            </p>
    </footer>
</body>
</html>



then in index.blade.php we're extending(pulling) everything 
from layouts/app.blade.php. And we're filling in the yield()
section (in app.blade.php) with this actual 'content' 
section

-- VIEWS/INDEX.BLADE.PHP 

@extends('layouts/app');

@section('content');
    <!-- Hero background & content on top of hero background -->
    <div id="hero-container">
        <div class="hero-wrapper">
            <h1>Multi-Disciplinary <br> <span class="line">Designer</span> <span class="orange-txt">Developer</span></h1>

            <div class="btn-wrapper">
                <a href="">Let's connect</a>
                <a href="">View Portfolio</a>
            </div>
        </div>
    </div>

    <!-- 4 grid layout skills on homepage -->
    <!-- Every div is a grid item -->
    <div class="container-grid-4">
        <div>
            <img src="img/icon-box.jpg" alt="">
            <h2>
                Web Design
            </h2>
            <p>
                Lorem ipsum dolor sit amet consectetur!
            </p>
        </div>

        <div>
            <img src="img/icon-box.jpg" alt="">
            <h2>
                Web Development
            </h2>
            <p>
                Lorem ipsum dolor sit amet consectetur!
            </p>
        </div>

        <div>
            <img src="img/icon-box.jpg" alt="">
            <h2>
                Product Design
            </h2>
            <p>
                Lorem ipsum dolor sit amet consectetur!
            </p>
        </div>

        <div>
            <img src="img/icon-box.jpg" alt="">
            <h2>
                Creative Thinker
            </h2>
            <p>
                Lorem ipsum dolor sit amet consectetur!
            </p>
        </div>
    </div>

    <div class="header-section">
        <h2 class="dark big">Team</h2>
        
        <hr>
    </div>

    <!-- Meet the team section -->
    <div class="container-grid-2">
        <div>
            <img class="img-team" src="img/team-section-home.jpg" alt="">
        </div>
        <div>
            <h2>
                Who we are
            </h2>

            <h3 class="orange-txt">
                Meet Our Team
            </h3>

            <p>
                Whether you require distribution or fulfillment, defined freight forwarding, or a complete supply chain solution, we are here for you.
            </p>
            
            <div class="btn-wrapper">
                <a href="">About</a>
            </div>
        </div>
    </div>

    <div class="header-section">
        <h2 class="dark big">Skills</h2>

        <hr>
    </div>

    <!-- Section of skills -->
    <div class="section-why-us">
        <div>
            <i class="fas fa-code-branch icon-why-us"></i>            
            <h2>
                Quality Control
            </h2>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit.
            </p>
        </div>

        <div class="middle">
            <h2>
                <img src="img/icon-box.jpg" alt="">
            </h2>
        </div>

        <div>
            <i class="far fa-keyboard icon-why-us"></i>   
            <h2>
                Optional Maintenance
            </h2>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit.
            </p>
        </div>
        
        <div>
            <i class="fab fa-google icon-why-us"></i>            
            <h2>
                Search Engine Friendly
            </h2>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit.
            </p>
        </div>
        
        <div>
            <i class="fas fa-globe icon-why-us"></i>            
            <h2>
                Web Master Tools
            </h2>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit.
            </p>
        </div>
    </div>
    @endsection
























