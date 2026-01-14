<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::all();
    }

    public function store(Request $request)
    {
        return Book::create($request->all());
    }

    public function update(Request $request, $id)
    {
        Book::find($id)->update($request->all());
        return response()->json(['message'=>'Updated']);
    }

    public function destroy($id)
    {
        Book::destroy($id);
        return response()->json(['message'=>'Deleted']);
    }
}
