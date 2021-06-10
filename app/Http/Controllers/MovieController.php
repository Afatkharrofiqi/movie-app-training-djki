<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['movies'] = Movie::paginate(10);
        return view('movie.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('movie.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|unique:movies,name',
            'image'     => 'mimes:jpg,png|required|max:10000',
            'categories'=> 'required'
        ]);

        DB::beginTransaction();
        try {
            $movie = new Movie;
            $movie->name = $request->name;
            if($request->file('cover')) {
                $image_path = $request->file('cover')->store('movie_cover', 'public');
                $movie->cover = $image_path;
            }
            $movie->created_by = Auth::user()->id;
            $movie->save();

            $movie->categories()->attach($request->categories);
            DB::commit();
            return redirect()->route('movie.index')->with('status', 'Movie berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('movie.index')->with('status', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        return view('movie.edit', ['movie' => $movie]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'name'      => 'unique:movies,name,'.$movie->id,
            'categories'=> 'required',
            'image'     => 'nullable|mimes:jpg|max:10000'
        ]);

        DB::beginTransaction();
        try {
            $movie->name = $request->name;
            if($request->file('cover')) {
                if($movie->cover && file_exists(storage_path('app/public/'. $movie->cover))){
                    Storage::delete('public/'.$movie->cover);
                }
                $image_path = $request->file('cover')->store('movie_cover', 'public');
                $movie->cover = $image_path;
            }
            $movie->updated_by = Auth::user()->id;
            $movie->save();

            $movie->categories()->sync($request->categories);
            DB::commit();
            return redirect()->route('movie.index')->with('status', 'movie '.$movie->name.' berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('movie.index')->with('status', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        DB::beginTransaction();
        try {
            $movie->categories()->detach();
            if($movie->cover && file_exists(storage_path('app/public/'. $movie->cover))){
                Storage::delete('public/'.$movie->cover);
            }
            $movie->delete();
            DB::commit();
            return redirect()->route('movie.index')->with('status', 'movie '.$movie->name.' berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('movie.index')->with('status', $e->getMessage());
        }
    }
}
