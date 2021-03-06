<?php

namespace App\Http\Controllers;

use App\Tunjangans;
use App\Jabatan;
use App\Golongan;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Form;
use View;
use Html;
use DB;
use Alert;
use Validator;
use Input;
use Redirect;


class TunjangansController extends Controller
{

public function __construct()
    {
        $this->middleware('HRD');
    }

     public function index()
    {
        $tunjangans=Tunjangans::all();
        $jabatans=Jabatan::all();
        $golongans=Golongan::all();
        $tunjangans=Tunjangans::where('Status',request('Status'))->paginate(0);
        if(request()->has ('Status'))
        {
         $tunjangans=Tunjangans::where('Status',request('Status'))->paginate(0);
 
        }
        else
        {
            $tunjangans=Tunjangans::paginate(3);
        }
        return view('tunjangans.index',compact('tunjangans','jabatans','golongans'));
    }
 public function create()
    {
        $jabatans=Jabatan::all();
        $golongans=Golongan::all();
        return view('tunjangans.create',compact('jabatans','golongans'));
    }

    public function store(Request $request)
    {
       $rules = array(
  'Kode_tunjangan'=> 'required|Kode_tunjangan|unique:tunjangans',   
  'jabatan_id' => 'required',  
  'golongan_id' => 'required', 
   'Status'=> 'required',
   'Jumlah_anak'=> 'required',
   'Besaran_uang'=> 'required',
 
 );


 $validator = Validator::make(Input::all(), $rules);

 // check if the validator failed -----------------------
 if ($validator->fails()) {

 
  $messages = $validator->messages();

 
  return Redirect::to('tunjangans')
   ->withErrors($validator);

 } else {
 
  $tunjangans = new Duck;
  $tunjangans->Kode_tunjangan     = Input::get('Kode_tunjangan');
  $tunjangans->jabatan_id    = Input::get('jabatan_id');
   $tunjangans->golongan_id    = Input::get('golongan_id');
   $tunjangans->Status= Input::get('Status');
   $tunjangans->Jumlah_anak    = Input::get('Jumlah_anak');
  $tunjangans->Besaran_uang = Hash::make(Input::get('Besaran_uang'));

 
 
  $tunjangans->save();

 
  return Redirect::to('tunjangans');

 }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jabatans=Jabatan::find($id);
        $golongans=Golongan::find($id);
        $tunjangans=Tunjangans::find($id);
        return view('tunjangans.show',compact('jabatans','golongans','tunjangans'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $tunjangans=Tunjangans::find($id);
        $jabatans=Jabatan::all();
        $golongans=Golongan::all();
        return view('tunjangans.edit',compact('tunjangans','jabatans','golongans'));
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
        $tunjangansUpdate=Request::all();
        $tunjangans=Tunjangans::find($id);
        $tunjangans->update($tunjangansUpdate);
        return redirect('tunjangans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tunjangans::find($id)->delete();
        return redirect('tunjangans');
    }
}

