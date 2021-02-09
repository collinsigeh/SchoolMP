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
use App\Cbt;
use App\Question;
use App\Subject;
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
            'cbt_id'            => ['required'],
            'question'          => ['required'],
            'correct_option'    => ['required', 'in:A,B,C,D,E']
        ]);
        
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
        $question->subject_id       = $cbt->subject_id;
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
    public function edit($id = 0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        } 
        $data['question'] = Question::find($id);
        if(empty($data['question']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['question']->count() < 1)
        {
            return  redirect()->route('dashboard');
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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            if($question->user_id != $user_id)
            {
                $request->session()->flash('error', "An attempt to edit questions without authorization.");
                return redirect()->route('cbts.show', $question->cbt_id);
            }
        }
        
        $data['school'] = School::find($school_id);
        $data['term'] = Term::find($data['question']->term_id);

        if($data['user']->role == 'Staff')
        {
            $db_check = array(
                'user_id'   => $data['user']->id,
                'school_id' => $data['school']->id
            );
            $staff = Staff::where($db_check)->get();
            if(empty($staff))
            {
                return  redirect()->route('dashboard');
            }
            elseif($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }

        return view('questions.edit')->with($data);
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

        return redirect()->route('questions.edit', $question->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id=0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            $request->session()->flash('error', 'Error 4' );
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');

        if($id < 1)
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'confirmation_to_delete' => ['required', 'in:DELETE'],
            'cbt_id'        => ['required']
        ]);

        $question = Question::find($id);

        if(empty($question))
        {
            $request->session()->flash('error', 'Error 2: Attempt to delete unavailable resource.' );
            return redirect()->route('dashboard');
        }
        
        if(count($question->questionattempts) > 0 OR count($question->cbt->attempts) > 0)
        {
            $request->session()->flash('error', 'Error 1: Attempt to delete question with linked resources.' );
            return redirect()->route('dashboard');
        }

        $question->delete();
        $request->session()->flash('success', 'Item deleted');
        
        return redirect()->route('cbts.show', $request->input('cbt_id'));
    }

    /**
     * Check if the logged-in user can manipulate this resource by special privilege.
     * All directors are managers already but staff earn it by special privilege
     *
     * @return boolean
     */
    public function resource_manager($user, $school_id)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }
        
        $resource_manager = false;

        if($user->usertype == 'Client')
        {
            foreach($user->schools as $school)
            {
                if($school->id == $school_id)
                {
                    $resource_manager = true;
                }
            }
        }
        elseif($user->role == 'Director')
        {
            $db_check = array(
                'user_id'   => $user->id,
                'school_id' => $school_id
            );
            $directorcases = Director::where($db_check)->get();
            if(!empty($directorcases))
            {
                if($directorcases->count() > 0)
                {
                    $resource_manager = true;
                }
            }
        }
        elseif($user->role == 'Staff')
        {
            $db_check = array(
                'user_id'       => $user->id,
                'school_id'     => $school_id,
                'manage_subjects'  => 'Yes'
            );
            $staffcases = Staff::where($db_check)->get();
            if(!empty($staffcases))
            {
                if($staffcases->count() > 0)
                {
                    $resource_manager = true;
                }
            }
        }

        return $resource_manager;
    }
}
