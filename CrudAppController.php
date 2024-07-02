<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CrudApp;
use Session;
use File;


    class CrudAppController extends Controller

{
    
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
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'gender' => 'required|in:Male,Female',
            'occupation' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,bmp|max:2048', // Adjust max file size as per your requirement
            'date' => 'required|date',
            'fruits' => 'required|array|min:2',
            'fruits.*' => 'string',
        ]);
    
        // Initialize a new instance of CrudApp model
        $crudapp = new CrudApp;
    
        // Assign values from the request to the model instance
        $crudapp->name = $request->name;
        $crudapp->email = $request->email;
        $crudapp->gender = $request->gender;
        $crudapp->occupation = $request->occupation;
        $crudapp->date = $request->date;
       
    
        // Handle file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $crudapp->image = $profileImage; // Save image filename to the 'image' attribute
        }
    
        // Handle 'fruits' array and implode into a comma-separated string
        $crudapp->fruits = implode(",", $request->fruits);
    
        // Save the record to the database
        $crudapp->save();
    
        // Flash success message to session
        Session::flash('message', 'New record added successfully.'); 
        Session::flash('alert-class', 'alert-success'); 
    
        // Redirect back to the previous page
        return redirect()->back();
    }
    



        public function edit_record($id)
    {
        $record = CrudApp::findOrFail($id); // Fetch a single record by its ID
        return view('add_new_record', compact('record'));
    }

    public function update_record(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'gender' => 'required|in:Male,Female',
            'occupation' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,bmp|max:2048', // Allow null for image if not updated
            'date' => 'required|date',
            'fruits' => 'required|array|min:2',
            'fruits.*' => 'string',
        ]);
    
        // Fetch the existing record from database
        $crudapp = CrudApp::findOrFail($id);
    
        // Assign values from the request to the model instance
        $crudapp->name = $request->name;
        $crudapp->email = $request->email;
        $crudapp->gender = $request->gender;
        $crudapp->occupation = $request->occupation;
        $crudapp->date = $request->date;
       
    
        // Handle file upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the existing image file if it exists
            if ($crudapp->image) {
                $imagePath = public_path('images/') . $crudapp->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
    
            // Upload new image
            $image = $request->file('image');
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $crudapp->image = $profileImage; // Save image filename to the 'image' attribute
        }
    
        // Handle 'fruits' array and implode into a comma-separated string
        $crudapp->fruits = implode(",", $request->fruits);
    
        // Save the updated record to the database
        $crudapp->save();
    
        // Flash success message to session
        Session::flash('message', 'Record updated successfully.'); 
        Session::flash('alert-class', 'alert-success'); 
    
        // Redirect back to the previous page or to a specific route
        return redirect()->route('all.records');
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
