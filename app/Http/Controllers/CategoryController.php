<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Category/Index'); 
    }

    public function create()
    {
        return Inertia::render('Category/Create');
    }

    public function show($id)
    {
        return Inertia::render('Category/View', [
            'category' => Category::findOrFail($id),
        ]);
    }

    public function edit($id)
    {
        return Inertia::render('Category/Edit', [
            'category' => Category::findOrFail($id),
        ]);
    }

}
