<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }
    
    
    public function show(Project $project)
    {
        
        if (auth()->user()->isNot($project->owner)) {
            return response('ERROR 403 - You are not allowed to view this page!', 403);
        }
        
        return view('projects.show', compact('project'));
    }
    
    
    public function create()
    {
        return view('projects.create');
    }
    
    
    public function store()
    {
        //validate
        $attributes = request()->validate([
        'title' => 'required', 
        'description' => 'required'
        ]);
        
        //persist
        auth()->user()->projects()->create($attributes);
        
        

        //redirect
        return redirect('/projects');
    }
}
