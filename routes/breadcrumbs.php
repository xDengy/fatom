<?php
// routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.

// Главная
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Главная', route('home'));
});

// Главная > Каталог
Breadcrumbs::for('catalog', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Каталог', route('catalog'));
});

// Главная > Каталог > [Category]
Breadcrumbs::for('catalog.category', function (BreadcrumbTrail $trail, $category) {
    if ($category->parent) {
        $trail->parent('catalog.category', $category->parent);
    } else {
        $trail->parent('catalog');
    }
    $trail->push($category->title, route('catalog.category', $category));
});

Breadcrumbs::for('product', function (BreadcrumbTrail $trail, $product) {
    $trail->parent('catalog.category', $product->category);
    $trail->push($product->title, route('product', $product));
});
