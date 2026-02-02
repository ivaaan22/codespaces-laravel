<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Series::all();
        return response()->json(['series' => $series], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'genre' => 'required|max:255',
            'release_year' => 'required|integer|min:1900|max:2100'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $series = Series::create($request->all());
        return response()->json($series, 201);
    }

    public function show($id)
    {
        $series = Series::findOrFail($id);
        return response()->json($series);
    }

    public function update(Request $request, $id)
    {
        $series = Series::findOrFail($id);

        $series->update($request->all());

        return response()->json($series);
    }

    public function destroy($id)
    {
        Series::findOrFail($id)->delete();
        return response()->json(['message' => 'Serie eliminada']);
    }
}
