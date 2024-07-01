<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CrudApp;
use Session;
use File;


    class CrudAppController extends Controller

{
    public function __construct() {
        
    }

    public function all_records()
    {
      

        $all_records = CrudApp::all();
        return view('all_records',compact('all_records'));
    }

    public function add_new_record()
    {
       
     
        return view('add_new_record');
    }

    public function store_new_record(Request $request)
    {
        $request->validate([
            'name'=>'required|regex:/^[\pL\s\-]+$/u|max:50',
            'email'=>'required|regex:/(.+)@(.+)\.(.+)/i|email|max:50',
            'gender'=>'required',
         
           'occupation'=>'required',
            'image'=>'required|mimes:jpg,jpeg,png,bmp',
            'date'=>'required',
            'fruits' => 'required|min:2'
         
           
        ]);


        $imageName = '';
        if ($image = $request->file('image')){
            $imageName = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move('images/profile', $imageName);
        }

        $fruits = implode(",",$request->fruits);


        CrudApp::create([
       
            'name'=>$request->name,
            'email'=>$request->email,
            'gender'=>$request->gender,
           
            'occupation'=>$request->occupation,
            'image'=>$imageName,
            'date'=>$request->date,
            'fruits'=>$fruits,
         
          
        ]);
     
        Session::flash('message', 'New record added success.'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect()->back();
    }


        public function edit_record($id)
    {
        $record = CrudApp::findOrFail($id); // Fetch a single record by its ID
        return view('add_new_record', compact('record'));
    }



    public function update_record(Request $request, $id) {
        $validated = $request->validate([
            
            'name'=>'required|regex:/^[\pL\s\-]+$/u|max:50',
            'email'=>'required|regex:/(.+)@(.+)\.(.+)/i|email|max:50',
            'gender'=>'required',
         
            'occupation'=>'required',
            'image'=>'required|mimes:jpg,jpeg,png,bmp',
            'date'=>'required',
            'fruits' => 'required|min:2'
        ]);
        
        $fruits = implode(",",$request->fruits);

        $record = CrudApp::findOrFail($id);

        $data = $request->all();
        $record->update($data);
        return redirect()->route('all.records')->with('success_message', 'Category updated successfully!');

    }


    public function delete_record($id)
    {
        $record = CrudApp::findOrFail($id);

        // Delete image from storage
        if ($record->image && file_exists(public_path('images/profile/' . $record->image))) {
            unlink(public_path('images/profile/' . $record->image));
        }

        $record->delete();

        return redirect()->route('all.records')->with('success_message', 'Record deleted successfully!');
    }
}


// https://www.webjourney.dev/laravel-10-crud-tutorial-wih-all-input-type