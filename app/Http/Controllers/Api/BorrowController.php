<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BorrowResource;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $borrow = Borrow::latest()->paginate(5);
        return new BorrowResource(true, 'Success Get All Borrow', $borrow);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //define validation rules
        $validator = Validator::make($request->all(), [
            'member_id'  => 'required',
            'books'    => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $stock = Book::find($request->books);
        if ($stock->stock <= 0) {
            return new BorrowResource(false, 'Out of Stock', $stock);
        }

        //create book
        $borrow = Borrow::create([
            'member_id'   => $request->member_id,
            'book_id'   => $request->books,
        ]);

        $stock->stock = $stock->stock - 1;
        $stock->save();


        //return response
        return new BorrowResource(true, 'Success Insert Borrow', $borrow);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Borrow $borrow)
    {
        return new BorrowResource(true, 'Get Data By Id', $borrow);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Borrow $borrow)
    {
          //define validation rules
        $validator = Validator::make($request->all(), [
            'member_id'  => 'required',
            'books'    => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $stock = Book::find($request->books);
        if ($stock->stock <= 0) {
            return new BorrowResource(false, 'Out of Stock', $stock);
        }

        //update borrow
        $borrow->update([
            'member_id'   => $request->member_id,
            'book_id'   => $request->books,
        ]);

        $stock->stock = $stock->stock - 1;
        $stock->save();

        //return response
        return new BorrowResource(true, 'Success Update Borrow', $borrow);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Borrow $borrow)
    {
        $borrow->delete();
        $book = Book::find($borrow->book_id);
        $book->stock = $book->stock + 1;
        $book->save();
        return new BorrowResource(true, 'Success Delete Borrow', $borrow);
    }
}