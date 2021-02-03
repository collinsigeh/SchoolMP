<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Schoolclass;
use App\Director;
use App\Staff;
use App\Term;
use App\Arm;
use App\Classsubject;
use App\Cbt;
use App\Question;
use Illuminate\Http\Request;
use Image;
use Storage;
use Illuminate\Support\Facades\DB;

class QuestionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        $this->validate($request, [
            'classsubject_id'   => ['required'],
            'cbt_id'            => ['required'],
            'question'          => ['required'],
            'correct_option'    => ['required', 'in:A,B,C,D,E']
        ]);
        
        $classsubject = Classsubject::find($request->input('classsubject_id'));
        if(empty($classsubject))
        {
            return redirect()->route('dashboard');
        }
        elseif($classsubject->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        session(['classsubject_id' => $classsubject->id]);
        
        $cbt = Cbt::find($request->input('cbt_id'));
        if(empty($cbt))
        {
            return redirect()->route('dashboard');
        }
        elseif($cbt->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        if(count($cbt->questions) >= $cbt->no_questions)
        {
            $request->session()->flash('error', "Maximum required questions has been reached.");
            return redirect()->route('cbts.show', $cbt->id);
        }

        if($request->hasFile('question_photo'))
        {
            $image = $request->file('question_photo');
            $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/questions/' . $filename);
            Image::make($image)->save($location);

            $question_photolink = $filename;
        }
        else
        {
            $question_photolink = '';
        }

        if($request->hasFile('option_a_photo'))
        {
            $image = $request->file('option_a_photo');
            $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/questions/' . $filename);
            Image::make($image)->save($location);

            $option_a_photolink = $filename;
        }
        else
        {
            $option_a_photolink = '';
        }

        if($request->hasFile('option_b_photo'))
        {
            $image = $request->file('option_b_photo');
            $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/questions/' . $filename);
            Image::make($image)->save($location);

            $option_b_photolink = $filename;
        }
        else
        {
            $option_b_photolink = '';
        }

        if($request->hasFile('option_c_photo'))
        {
            $image = $request->file('option_c_photo');
            $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/questions/' . $filename);
            Image::make($image)->save($location);

            $option_c_photolink = $filename;
        }
        else
        {
            $option_c_photolink = '';
        }

        if($request->hasFile('option_d_photo'))
        {
            $image = $request->file('option_d_photo');
            $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/questions/' . $filename);
            Image::make($image)->save($location);

            $option_d_photolink = $filename;
        }
        else
        {
            $option_d_photolink = '';
        }

        if($request->hasFile('option_e_photo'))
        {
            $image = $request->file('option_e_photo');
            $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/questions/' . $filename);
            Image::make($image)->save($location);

            $option_e_photolink = $filename;
        }
        else
        {
            $option_e_photolink = '';
        }

        if($request->input('correct_option') == 'A')
        {
            if(strlen($request->input('option_a')) < 1 && strlen($option_a_photolink) < 1)
            {
                $request->session()->flash('error', "The wrong option was chosen as the correct option.");
                return redirect()->route('cbts.show', $cbt->id);
            }
        }
        elseif($request->input('correct_option') == 'B')
        {
            if(strlen($request->input('option_b')) < 1 && strlen($option_b_photolink) < 1)
            {
                $request->session()->flash('error', "The wrong option was chosen as the correct option.");
                return redirect()->route('cbts.show', $cbt->id);
            }
        }
        elseif($request->input('correct_option') == 'C')
        {
            if(strlen($request->input('option_c')) < 1 && strlen($option_c_photolink) < 1)
            {
                $request->session()->flash('error', "The wrong option was chosen as the correct option.");
                return redirect()->route('cbts.show', $cbt->id);
            }
        }
        elseif($request->input('correct_option') == 'D')
        {
            if(strlen($request->input('option_d')) < 1 && strlen($option_d_photolink) < 1)
            {
                $request->session()->flash('error', "The wrong option was chosen as the correct option.");
                return redirect()->route('cbts.show', $cbt->id);
            }
        }
        elseif($request->input('correct_option') == 'E')
        {
            if(strlen($request->input('option_e')) < 1 && strlen($option_e_photolink) < 1)
            {
                $request->session()->flash('error', "The wrong option was chosen as the correct option.");
                return redirect()->route('cbts.show', $cbt->id);
            }
        }
        
        $question = new Question;

        $question->school_id        = $school_id;
        $question->subject_id       = $classsubject->subject_id;
        $question->term_id          = $term_id;
        $question->cbt_id           = $cbt->id;
        $question->question         = $request->input('question');
        $question->question_photo   = $question_photolink;
        $question->option_a         = $request->input('option_a');
        $question->option_a_photo   = $option_a_photolink;
        $question->option_b         = $request->input('option_b');
        $question->option_b_photo   = $option_b_photolink;
        $question->option_c         = $request->input('option_c');
        $question->option_c_photo   = $option_c_photolink;
        $question->option_d         = $request->input('option_d');
        $question->option_d_photo   = $option_d_photolink;
        $question->option_e         = $request->input('option_e');
        $question->option_e_photo   = $option_e_photolink;
        $question->correct_option   = $request->input('correct_option');
        $question->user_id          = $user_id;

        $question->save();

        $request->session()->flash('success', 'Question added.');

        return redirect()->route('cbts.show', $cbt->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $question = Question::find($id);
        if(empty($question))
        {
            return redirect()->route('dashboard');
        }

        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        $this->validate($request, [
            'question'          => ['required'],
            'correct_option'    => ['required', 'in:A,B,C,D,E']
        ]);

        if($request->hasFile('question_photo'))
        {
            $image = $request->file('question_photo');
            $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/questions/' . $filename);
            Image::make($image)->save($location);

            $question_photolink = $filename;
        }
        else
        {
            $question_photolink = $question->question_photo;
        }

        if($request->hasFile('option_a_photo'))
        {
            $image = $request->file('option_a_photo');
            $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/questions/' . $filename);
            Image::make($image)->save($location);

            $option_a_photolink = $filename;
        }
        else
        {
            $option_a_photolink = $question->option_a_photo;
        }

        if($request->hasFile('option_b_photo'))
        {
            $image = $request->file('option_b_photo');
            $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/questions/' . $filename);
            Image::make($image)->save($location);

            $option_b_photolink = $filename;
        }
        else
        {
            $option_b_photolink = $question->option_b_photo;
        }

        if($request->hasFile('option_c_photo'))
        {
            $image = $request->file('option_c_photo');
            $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/questions/' . $filename);
            Image::make($image)->save($location);

            $option_c_photolink = $filename;
        }
        else
        {
            $option_c_photolink = $question->option_c_photo;
        }

        if($request->hasFile('option_d_photo'))
        {
            $image = $request->file('option_d_photo');
            $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/questions/' . $filename);
            Image::make($image)->save($location);

            $option_d_photolink = $filename;
        }
        else
        {
            $option_d_photolink = $question->option_d_photo;
        }

        if($request->hasFile('option_e_photo'))
        {
            $image = $request->file('option_e_photo');
            $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/questions/' . $filename);
            Image::make($image)->save($location);

            $option_e_photolink = $filename;
        }
        else
        {
            $option_e_photolink = $question->option_e_photo;
        }

        if($request->input('correct_option') == 'A')
        {
            if(strlen($request->input('option_a')) < 1 && strlen($option_a_photolink) < 1)
            {
                $request->session()->flash('error', "The wrong option was chosen as the correct option.");
                return redirect()->route('cbts.show', $cbt->id);
            }
        }
        elseif($request->input('correct_option') == 'B')
        {
            if(strlen($request->input('option_b')) < 1 && strlen($option_b_photolink) < 1)
            {
                $request->session()->flash('error', "The wrong option was chosen as the correct option.");
                return redirect()->route('cbts.show', $cbt->id);
            }
        }
        elseif($request->input('correct_option') == 'C')
        {
            if(strlen($request->input('option_c')) < 1 && strlen($option_c_photolink) < 1)
            {
                $request->session()->flash('error', "The wrong option was chosen as the correct option.");
                return redirect()->route('cbts.show', $cbt->id);
            }
        }
        elseif($request->input('correct_option') == 'D')
        {
            if(strlen($request->input('option_d')) < 1 && strlen($option_d_photolink) < 1)
            {
                $request->session()->flash('error', "The wrong option was chosen as the correct option.");
                return redirect()->route('cbts.show', $cbt->id);
            }
        }
        elseif($request->input('correct_option') == 'E')
        {
            if(strlen($request->input('option_e')) < 1 && strlen($option_e_photolink) < 1)
            {
                $request->session()->flash('error', "The wrong option was chosen as the correct option.");
                return redirect()->route('cbts.show', $cbt->id);
            }
        }
        
        $question->question         = $request->input('question');
        $question->question_photo   = $question_photolink;
        $question->option_a         = $request->input('option_a');
        $question->option_a_photo   = $option_a_photolink;
        $question->option_b         = $request->input('option_b');
        $question->option_b_photo   = $option_b_photolink;
        $question->option_c         = $request->input('option_c');
        $question->option_c_photo   = $option_c_photolink;
        $question->option_d         = $request->input('option_d');
        $question->option_d_photo   = $option_d_photolink;
        $question->option_e         = $request->input('option_e');
        $question->option_e_photo   = $option_e_photolink;
        $question->correct_option   = $request->input('correct_option');

        $question->save();

        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('cbts.show', $question->cbt_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
