<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{

    use AuthorizesRequests, ValidatesRequests;
    public function index()
    {
        $movies = Movie::with('user')->latest()->get();


        return Inertia::render('Movies/Index', [
            'movies' => MovieResource::collection($movies),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'min:2'],
            'surname' => ['required', 'min:2'],
            'favourite' => ['required', 'max:255']
        ]);

        $request->user()->movies()->create($validated);

        return back()->with('status', __('Saved favourite!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {

        $this->authorize('update', $movie);

        $validated = $request->validate([
            'name' => ['required', 'min:2'],
            'surname' => ['required', 'min:2'],
            'favourite' => ['required', 'max:255']
        ]);

        $movie->update($validated);

        return back()->with('status', __('Updated favourite!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $this->authorize('delete', $movie);

        $movie->delete();

        return back()->with('status', __('Deleted favourite!'));
    }
}
