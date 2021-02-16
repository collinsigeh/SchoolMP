<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewdataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('newdata.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('newdata.index');
    }    

    /**
     * Show the form for creating a new staff resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_staff($id=0)
    {
        if($id < 1)
        {
            $request->session()->flash('error', 'You navigated to this page with the wrong URL.');
            return redirect()->route('newdata.index');
        }

        $school = School::find($id);
        if(empty($school))
        {
            $request->session()->flash('error', 'You navigated to this page with the wrong URL.');
            return redirect()->route('newdata.index');
        }
        elseif($school->count != 1)
        {
            $request->session()->flash('error', 'You navigated to this page with the wrong URL.');
            return redirect()->route('newdata.index');
        }

        $data['school'] = $school;

        return view('newdata.create_staff');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->route('newdata.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=0)
    {
        return redirect()->route('newdata.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id=0)
    {
        return redirect()->route('newdata.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=0)
    {
        return redirect()->route('newdata.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0)
    {
        return redirect()->route('newdata.index');
    }
}
