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

    public function edit($id)
    {
        $priority = Priority::findOrFail($id);
        return Inertia::render('Priority/Edit', [
            'priority' => $priority,
        ]);
    }
}
