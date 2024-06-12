<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Http\Resources\FavouriteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Http;


class FavouriteController extends Controller
{


    public function delFavorite( User $user, int $movieId)
    {
        $userId = $user->id;
        Favourite::where('user_id', $userId)->where('movie_id', $movieId)->delete();

        return response()->json(['success' => true]);
    }

    public function addFavorite(Request $request, User $user, int $movie){
        //Creo un objeto de favorito
        $favourite = new Favourite();

        //Añado el id del usuario y de la película que recibo como parámetros
        $favourite->user_id = $user->id;
        $favourite->movie_id = $movie;

        //Busco esa película en el api para añadir más campos en favoritos
        $response = Http::get("https://api.themoviedb.org/3/movie/$movie", [
            'api_key' => env('TMDB_API_KEY'),
            'language' => 'es-US',
        ]);
        if ($response->successful()) {
            $movieData = $response->json();
            $favourite->original_title = $movieData['original_title'];
            $favourite->overview = $movieData['overview'];
            $favourite->poster_path = $movieData['poster_path'];
            $favourite->backdrop_path = $movieData['backdrop_path'];
            //Añado el registro en la tabla de favoritos
            $favourite->save();
            return response()->json(["status"=>"OK"])->status(200);
        } else {
            return response()->json(["status"=>"Error"])->status(500);
        }

    }
    public function getFavorites(User $user)
    {
        $userId =$user->id;
        $favorites = Favourite::where('user_id', $userId)->pluck('movie_id')->toArray();
        return response()->json($favorites);
    }
    public function index()
    {
        $favourites = Favourite::with('user')->latest()->get();

        return Inertia::render('Favourites/Index', [
            'favourites' => FavouriteResource::collection($favourites),
        ]);
    }
    public function toggle(Request $request, $movie_id)
    {
        $user = $request->user();
        $favourite = Favourite::where('user_id', $user->id)->where('movie_id', $movie_id)->first();

        if ($favourite) {

            $favourite->delete();
            return back()->with('status', 'Favorito eliminado');
        } else {

            $validated = $request->validate([
                'original_title' => 'required|string|max:255',
                'overview' => 'nullable|string',
                'poster_path' => 'nullable|string',
                'backdrop_path' => 'nullable|string',
            ]);

            $user->favourites()->create(array_merge($validated, ['movie_id' => $movie_id]));

            return back()->with('status', 'Favorito agregado');
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => ['required'],
            'original_title' => ['required'],
            'overview' => ['nullable|string'],
            'poster_path' => ['nullable|string'],
            'backdrop_path' => ['nullable|string'],
        ]);

        $favourite = $request->user()->favourites()->create($validated);

        return back()->with('status', '¡Favorito guardado!');
    }

    public function show(Favourite $favourite)
    {
        return Inertia::render('Favourites/Show', [
            'favourite' => new FavouriteResource($favourite->load('user')),
        ]);
    }

    public function update(Request $request, Favourite $favourite)
    {
        $validated = $request->validate([
            'original_title' => ['nullable', 'string', 'max:250'],
            'overview' => ['nullable', 'string'],
            'poster_path' => ['nullable', 'string'],
            'backdrop_path' => ['nullable', 'string'],
        ]);

        $favourite->update($validated);

        return back()->with('status', 'Favorito actualizado');
    }

    public function destroy(Favourite $favourite)
    {
        $favourite->delete();

        return back()->with('status', 'Favorito borrado');

    }

    public function find(Request $request)
    {
        $query = $request->query('q');
        $favourites = Favourite::where('original_title', 'like', "%{$query}%")
            ->with('user')
            ->get();

        return Inertia::render('Favourites/SearchResults', [
            'favourites' => FavouriteResource::collection($favourites),
        ]);
    }

}
