<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data = Genre::all();
        // print($data);die;
        return view('forms.genre.genre-list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('forms.genre.genre-form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGenre(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'genre_name' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return array('status_code' => 301, 'errors' => $validator->errors());
        }else{
            $data['genre_name'] = $request->genre_name;
            $data['status'] = $request->status;
            $genre = Genre::insert($data);
            if($genre){
                return array('status_code' => 200, 'message' => 'Added Successfull', "redirect_url" => url('admin/genre'));
            }else{
                return redirect('admin/add-genre')->withErrors(['err' => ['Somethinng went wrong']], 'admin/add-genre');
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function editGenre($genreid)
    {
        $data = Genre::where('genre_id', $genreid)->first();
        if($data){
            return array('status_code' => 200, 'message' => '', "data" => $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function deleteGenre($genreid)
    {
        // echo "<pre>";
        // print_r($genreid);die;
        $genre = Genre::where('genre_id', $genreid)->delete($genreid);
        if($genre){
            return array('status_code' => 202, 'message' => 'Deleted Successfully', "redirect_url" => url('admin/genre'));
        }else{
            return redirect('admin/genre')->withErrors(['err' => ['Somethinng went wrong']], 'admin/genre');}
    }
}
