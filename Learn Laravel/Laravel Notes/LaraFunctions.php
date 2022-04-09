<?php

class Elkhan{


public function Mndex(){  
    $title = "Welcome to my Laravel 8 course";
    return view('products.index', compact('title'));
}

// you can display multiple units as well

public function Index(){
    $title = "Hello my son";
    $description = "It's your course";
    return view("products.index",
        compact ('title', 'description'));
}
}

compact(); // sends data to the view

Cars::all(); // fetches all items

Cars::find($id); // fetches one item

nullable(); // means it can be null, it is optional, it is not required.
// When you create units that are not been used, they can be nullable

create(); // creates, generates

validate(); // is used to validate

request(); // retrieves the input, cookies, and files that were  
                // submitted with the request.

$data = request()->validate([
    'caption' => 'required',
    'image' => ['required', 'image']
]);

$errors->any(); // used in views

$errors->all(); // used in views

min:6;
max:3;

update(); // updates the value

delete(); // deletes the value

redirect('/'); // redirects to a certain view(page)

unique(); // the unique method returns all of the unique items 
                                     // in the collection
// 'email' => ['required', 'string', 'email', 
       // 'max:255', 'unique:users'] - requires to be unique on users table
// required - needs to be present, needs to be there (in input fields)

findOrFail(); // returns a proper response from the user

store('/', 'public'); // stores file where we want (r. a. paths don't matr.)

orderBy('created_at', 'DESC'); // changes the order

count(); // retrieves the amount of items from the database

public_path(); // generates a fully qualified path to a given file within 
                                            // the public directory


where('name', '[A-Za-z]+'); // where method accepts the name of the
                     // parameter and a regular expression defining
                        //  how the parameter should be constrained

with('cars', $cars); // takes values of $cars and passes to 'cars'
         // 'cars' is a name of the key that we are passing to the view

name('person.create'); // is used to create a named route




                                // 1

// ----  To flash the message after an action has been performed ----

session()->flash('success', 'Todo was created successfuly'); 
// key: 'success';  value: 'Todo was created successfuly'
// to display it in the view (in store method)
// then in view:
    // @if(session()->has('success'))  (if it has key named(success))
    // <div>
        // {{ session()->get('success') }}     display value of key
    // </div>
    // @endif

// and you can use it if you delete, edit, update store or perform
// an actions with items




                                // 2
                                
// -----  To hide the button after an action has been performed -----

// public function complete(Todo $todo){

//     $todo->complete = true;
//     $todo->save();
//     session()->flash('success', 'Todo completed successfuly');
//     return redirect('/todos');
// }


// index.blade.php
    // @if(!$todo->completed)
        // <a href="/todos/{{ $todo->id }}/complete">Complete</a>
    // @endif




                                // 3
                                
//   -----  Making a POST request from React component to backend -----

    // import React, { useState } from 'react'
    // import Header from './Header'
    
    // const AddProduct = () => {
    
    //     const [name, setName] = useState("");
    //     const [password, setPassword] = useState("");
    //     const [email, setEmail] = useState("");
    
    //     async function signUp() {
    //         let item = { name, password, email }
    //         let result = await fetch("http://127.0.0.1:8001/api/man", {
    //             method: 'POST',
    //             body: JSON.stringify(item),
    //             headers: {
    //                 "Content-type": 'application/json',
    //                 "Accept": 'application/json'
    //             }
    //         })
    //         result = await result.json()
    //         localStorage.setItem("mything", JSON.stringify(result));
    //     }
    
    //     return (
    //         <div>
    //             <input type="text" value={name}
    //                 onChange={(e) => setName(e.target.value)} placeholder="name" /><br />
    //             <input type="password" value={password}
    //                 onChange={(e) => setPassword(e.target.value)} placeholder="password" /><br />
    //             <input type="text" value={email}
    //                 onChange={(e) => setEmail(e.target.value)} placeholder="email" /><br />
    //             <button onClick={signUp}>Login</button>
    //         </div>
    //     )
    // }
    
    // export default AddProduct
    












?>