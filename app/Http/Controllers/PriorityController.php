<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PriorityController extends Controller
{
    public function index()
    {
        return Inertia::render('Priority/Index'); 
    }

    public function create()
    {
        return Inertia::render('Priority/Create');
    }

    public function show($id)
    {
        return Inertia::render('Priority/View', [
            'priority' => Priority::findOrFail($id),
        ]);
    }

    public function edit($id)
    {
        return Inertia::render('Priority/Edit', [
            'priority' => Priority::findOrFail($id),
        ]);
    }
}
