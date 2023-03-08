<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{

    //all listing
    public function index(){

        return view('listings.index', [
            //'listings' => Listing::all()
            //Its get the latest post->
            'listings' => Listing::latest()->filter
            (request(['tag', 'search']))->paginate(5)
        ]);

    }

    //edit

    
    public function edit(Listing $listing){
        return view('listings.edit', [
            'listing' => $listing
        ]);
    }

    //single listing
    public function show(Listing $listing){

        return view('listings.show', [
            'listing' => $listing
        ]);


       
    }

   //create form
   
   public function create(){
    return view('listings.create');
   }


   //post job
   public function store(Request $request){
    $formFields = $request->validate([
        'title' => 'required',
        'company' => ['required', Rule::unique('listings', 'company')],
        'location' => 'required',
        'website' => 'required',
        'email' => ['required' ,'email'],
        'tags' => 'required',
        'description' => 'required'
    ]);

    if($request->hasFile('logo')){
        $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $formFields['user_id'] = auth()->id();

    Listing::create($formFields);

    return redirect('/')->with('message', 'Listing created successfuly!');
   }





   //update job
   public function update(Request $request, Listing $listing){
    $formFields = $request->validate([
        'title' => 'required',
        'company' => 'required',
        'location' => 'required',
        'website' => 'required',
        'email' => ['required' ,'email'],
        'tags' => 'required',
        'description' => 'required'
    ]);

    if($request->hasFile('logo')){
        $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $listing->update($formFields);

    return back()->with('message', 'Listing Updated successfuly!');
   }




   //delete
   public function destroy(Listing $listing){
    $listing->delete();
    return redirect('/')->with('message', 'Listing Deleted successfuly!');
   }

   //manage listing

   public function manage(){
    return view('listings.manage',[
        'listings' => auth()->user()->listings()->get()
    ]);
    
   }

}
