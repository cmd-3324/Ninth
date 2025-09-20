<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Page</title>
</head>
<body>
@isset($name)
@isset($lastname)



@endisset
            <p
            @class([
            'my-loremipsum-text',
        ])
        @style(['color:red;'=> $name === "Zursda", "font-size:40px;"])
        >enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        @endisset
        <!-- Testing Button Here -->
        <p @style(['color:gray; font-size:30px;'])>This is test button</p>
        <button style="color: {{ $color }}">sdfsdf</button>

        @empty($name)
        <p>Name is not passed</p>
        @endempty
        @empty($lastname)
        <p>Lastname is not set </p>
        @endempty
<!---
for include directive , we can pass data by saying XXXXX('viewname', ['data which need to be passed'])
And also forelse directive can have empty directive to handle lasck of info and valuse, And isset
directive too , in with() in controller, first value is the value name of var in blade ,and second is
is the value in controller : writen with with("XXX","CCC")->and etc. also style can help us to handle
stykes of a tag within calss
also i leant switch and cased and default : Directives are Stuff that Make some common tasks possible
and easy in Blade files
includeIf
includeWhen --> if valuse exists, if values dose not exist , it wont include whole
includeFirst
includeUnless --> is the same as includeWhen, imagin Directive hrere, ($searchTerm) <- is the same as directive hre includeunless, (!searchterm)
, 19/9/2025 , video paused in : :  :
-->
@extends('layouts.app')



@php
    $products = ['Car', 'Bike', 'Bus'];
@endphp

<h2>Products list</h2>
@foreach($products as $product)
    @includeWhen(isset($products), 'Vest', ['products' => $products])

@endforeach
@each('Vest', $products, 'product', 'empty')


</body>
</html>
