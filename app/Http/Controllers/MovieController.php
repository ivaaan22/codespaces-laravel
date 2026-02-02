<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    // Obtener todas las películas de una serie
    public function index($series_id)
    {
        $movies = Movie::where('series_id', $series_id)->get();
        return response()->json(['movies' => $movies], 200);
    }

    // Crear una película dentro de una serie
    public function store(Request $request, $series_id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'duration' => 'required|integer|min:1',
            'release_year' => 'required|integer|min:1900|max:2100'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $movie = Movie::create([
            'series_id' => $series_id,
            'title' => $request->title,
            'duration' => $request->duration,
            'release_year' => $request->release_year
        ]);

        return response()->json($movie, 201);
    }

    // Mostrar una película concreta
    public function show($series_id, $movie_id)
    {
        $movie = Movie::where('series_id', $series_id)->findOrFail($movie_id);
        return response()->json($movie);
    }

    // Actualizar una película
    public function update(Request $request, $series_id, $movie_id)
    {
        $movie = Movie::where('series_id', $series_id)->findOrFail($movie_id);

        $movie->update($request->all());

        return response()->json($movie);
    }

    // Eliminar una película
    public function destroy($series_id, $movie_id)
    {
        Movie::where('series_id', $series_id)->findOrFail($movie_id)->delete();
        return response()->json(['message' => 'Película eliminada']);
    }
}
