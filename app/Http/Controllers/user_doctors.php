<?php

namespace App\Http\Controllers;

use App\User;
use App\user_doctors as AppUser_doctors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class user_doctors extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Auth::user()->doctors;
        return view("doctors.index", compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("doctors.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            "name" => "required|min:2|unique:users",
            "phone" => "required|numeric|unique:users",
            "facebook" => "min:6",
            "address" => "required"
        ]);
        $doctor = AppUser_doctors::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'facebook' => $request->facebook,
            'address' => $request->address,
            'info'  => $request->info
        ]);
        return redirect(route('doctor.show' , $doctor->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doctor = Auth::user()->doctors()->findOrFail($id);
        return view("doctors.show", compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor = Auth::user()->doctors()->findOrFail($id);
        return view("doctors.edit", compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request , [
            "name" => "required|min:2|unique:users,id," . $id,
            "phone" => "required|min:6|numeric|unique:users,phone," . User::find($id)->phone,
            "facebook" => "min:6",
            "address" => "required"
        ]);
        Auth::user()->doctors()->findOrFail($id)->update($request->all());
        return redirect(route('doctor.edit' , $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->doctors()->findOrFail($id)->delete();
        return redirect(route('doctor.index'));
    }
}
