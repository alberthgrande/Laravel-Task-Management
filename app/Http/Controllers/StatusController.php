<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatusController extends Controller
{
    public function index()
    {
        return Inertia::render('Status/Index'); 
    }

    public function create()
    {
        return Inertia::render('Status/Create');
    }

    public function show($id)
    {
        return Inertia::render('Status/View', [
            'status' => Status::findOrFail($id),
        ]);
    }

    public function edit($id)
    {
        return Inertia::render('Status/Edit', [
            'status' => Status::findOrFail($id),
        ]);
    }
}
