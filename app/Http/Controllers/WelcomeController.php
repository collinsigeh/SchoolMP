<?php

namespace App\Http\Controllers;

use App\School;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /*
    * Displays all the schools for the user to pic the one they want to log into
    *
    */
    public function index()
    {
        $data['schools'] = School::orderBy('school', 'asc')->simplePaginate(20);

        $data['title'] = 'School Portal';
        return view('welcome.index')->with($data);
    }

    /*
    * Display specific school login page
    *
    */
    public function login($id = 0)
    {
        $data['school'] = School::find($id);
        
        if (empty($data['school'])) {
            return redirect()->route('welcome.index');
        }

        session(['school_id' => $data['school']->id]);
        $data['title'] = $data['school']->school;
        return view('welcome.login')->with($data);
    }

    /*
    * Display faqs page for Non-client users
    *
    */
    public function faqs()
    {
        $data['title'] = 'School Portal';
        return view('welcome.faqs')->with($data);
    }
}
