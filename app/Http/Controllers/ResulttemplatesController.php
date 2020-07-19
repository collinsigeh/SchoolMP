<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Director;
use App\Staff;
use App\Arm;
use App\Resulttemplate;
use Illuminate\Http\Request;

class ResulttemplatesController extends Controller
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
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

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
        
        $db_check = array(
            'school_id' => $school_id
        );
        $data['templates'] = Resulttemplate::where($db_check)->orderBy('name', 'asc')->simplePaginate(20);

        return view('resulttemplates.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

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

        return view('resulttemplates.create')->with($data);
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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

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

        $this->validate($request, [
            'name' => ['required']
        ]);
        
        $name = ucwords(strtolower(trim($request->input('name'))));

        $db_check = array(
            'school_id' => $school_id,
            'name' => $name
        );
        $duplicates = Resulttemplate::where($db_check)->get();

        if(!empty($duplicates))
        {
            if($duplicates->count() > 0)
            {
                $request->session()->flash('error', 'The template '.$name.' exists already.');
                return redirect()->route('resulttemplates.create');
            }
        }

        $this->validate($request, [
            'description' => ['sometimes', 'max:191'],
            'ca_display' => ['required'],
            'subject_1st_test_max_score' => ['required', 'numeric', 'between:0,100'],
            'subject_2nd_test_max_score' => ['required', 'numeric', 'between:0,100'],
            'subject_3rd_test_max_score' => ['required', 'numeric', 'between:0,100'],
            'subject_assignment_score' => ['required', 'numeric', 'between:0,100'], 
            'subject_exam_score' => ['required', 'numeric', 'between:0,100'], 
            'grade_95_to_100' => ['required', 'max:25'], 
            'symbol_95_to_100' => ['required', 'max:5'], 
            'grade_90_to_94' => ['required', 'max:25'], 
            'symbol_90_to_94' => ['required', 'max:5'], 
            'grade_85_to_89' => ['required', 'max:25'], 
            'symbol_85_to_89' => ['required', 'max:5'], 
            'grade_80_to_84' => ['required', 'max:25'], 
            'symbol_80_to_84' => ['required', 'max:5'], 
            'grade_75_to_79' => ['required', 'max:25'], 
            'symbol_75_to_79' => ['required', 'max:5'], 
            'grade_70_to_74' => ['required', 'max:25'], 
            'symbol_70_to_74' => ['required', 'max:5'], 
            'grade_65_to_69' => ['required', 'max:25'], 
            'symbol_65_to_69' => ['required', 'max:5'], 
            'grade_60_to_64' => ['required', 'max:25'], 
            'symbol_60_to_64' => ['required', 'max:5'], 
            'grade_55_to_59' => ['required', 'max:25'], 
            'symbol_55_to_59' => ['required', 'max:5'], 
            'grade_50_to_54' => ['required', 'max:25'], 
            'symbol_50_to_54' => ['required', 'max:5'], 
            'grade_45_to_49' => ['required', 'max:25'], 
            'symbol_45_to_49' => ['required', 'max:5'], 
            'grade_40_to_44' => ['required', 'max:25'], 
            'symbol_40_to_44' => ['required', 'max:5'], 
            'grade_35_to_39' => ['required', 'max:25'], 
            'symbol_35_to_39' => ['required', 'max:5'], 
            'grade_30_to_34' => ['required', 'max:25'], 
            'symbol_30_to_34' => ['required', 'max:5'], 
            'grade_25_to_29' => ['required', 'max:25'], 
            'symbol_25_to_29' => ['required', 'max:5'], 
            'grade_20_to_24' => ['required', 'max:25'], 
            'symbol_20_to_24' => ['required', 'max:5'], 
            'grade_15_to_19' => ['required', 'max:25'], 
            'symbol_15_to_19' => ['required', 'max:5'], 
            'grade_10_to_14' => ['required', 'max:25'], 
            'symbol_10_to_14' => ['required', 'max:5'], 
            'grade_5_to_9' => ['required', 'max:25'], 
            'symbol_5_to_9' => ['required', 'max:5'], 
            'grade_0_to_4' => ['required', 'max:25'], 
            'symbol_0_to_4' => ['required', 'max:5']
        ]);

        $subject_total = $request->input('subject_1st_test_max_score') + $request->input('subject_2nd_test_max_score') +
                        $request->input('subject_3rd_test_max_score') + $request->input('subject_assignment_score') + 
                        $request->input('subject_exam_score');

        if( $subject_total != 100)
        {
            $request->session()->flash('error', 'The term total score is NOT equal to 100%. Please ensure when all the tests, 
                assignment, and exam scores are added we will get 100.');
            return redirect()->route('resulttemplates.create');
        }

        $resulttemplate = new Resulttemplate;

        $resulttemplate->school_id = $school_id;
        $resulttemplate->name = $name;
        $resulttemplate->description = $request->input('description');
        $resulttemplate->ca_display = $request->input('ca_display');
        $resulttemplate->subject_1st_test_max_score = $request->input('subject_1st_test_max_score');
        $resulttemplate->subject_2nd_test_max_score = $request->input('subject_2nd_test_max_score');
        $resulttemplate->subject_3rd_test_max_score = $request->input('subject_3rd_test_max_score');
        $resulttemplate->subject_assignment_score = $request->input('subject_assignment_score');
        $resulttemplate->subject_exam_score = $request->input('subject_exam_score');
        $resulttemplate->grade_95_to_100 = $request->input('grade_95_to_100');
        $resulttemplate->symbol_95_to_100 = $request->input('symbol_95_to_100');
        $resulttemplate->grade_90_to_94 = $request->input('grade_90_to_94');
        $resulttemplate->symbol_90_to_94 = $request->input('symbol_90_to_94');
        $resulttemplate->grade_85_to_89 = $request->input('grade_85_to_89');
        $resulttemplate->symbol_85_to_89 = $request->input('symbol_85_to_89');
        $resulttemplate->grade_80_to_84 = $request->input('grade_80_to_84');
        $resulttemplate->symbol_80_to_84 = $request->input('symbol_80_to_84');
        $resulttemplate->grade_75_to_79 = $request->input('grade_75_to_79');
        $resulttemplate->symbol_75_to_79 = $request->input('symbol_75_to_79');
        $resulttemplate->grade_70_to_74 = $request->input('grade_70_to_74');
        $resulttemplate->symbol_70_to_74 = $request->input('symbol_70_to_74');
        $resulttemplate->grade_65_to_69 = $request->input('grade_65_to_69');
        $resulttemplate->symbol_65_to_69 = $request->input('symbol_65_to_69');
        $resulttemplate->grade_60_to_64 = $request->input('grade_60_to_64');
        $resulttemplate->symbol_60_to_64 = $request->input('symbol_60_to_64');
        $resulttemplate->grade_55_to_59 = $request->input('grade_55_to_59');
        $resulttemplate->symbol_55_to_59 = $request->input('symbol_55_to_59');
        $resulttemplate->grade_50_to_54 = $request->input('grade_50_to_54');
        $resulttemplate->symbol_50_to_54 = $request->input('symbol_50_to_54');
        $resulttemplate->grade_45_to_49 = $request->input('grade_45_to_49');
        $resulttemplate->symbol_45_to_49 = $request->input('symbol_45_to_49');
        $resulttemplate->grade_40_to_44 = $request->input('grade_40_to_44');
        $resulttemplate->symbol_40_to_44 = $request->input('symbol_40_to_44');
        $resulttemplate->grade_35_to_39 = $request->input('grade_35_to_39');
        $resulttemplate->symbol_35_to_39 = $request->input('symbol_35_to_39');
        $resulttemplate->grade_30_to_34 = $request->input('grade_30_to_34');
        $resulttemplate->symbol_30_to_34 = $request->input('symbol_30_to_34');
        $resulttemplate->grade_25_to_29 = $request->input('grade_25_to_29');
        $resulttemplate->symbol_25_to_29 = $request->input('symbol_25_to_29');
        $resulttemplate->grade_20_to_24 = $request->input('grade_20_to_24');
        $resulttemplate->symbol_20_to_24 = $request->input('symbol_20_to_24');
        $resulttemplate->grade_15_to_19 = $request->input('grade_15_to_19');
        $resulttemplate->symbol_15_to_19 = $request->input('symbol_15_to_19');
        $resulttemplate->grade_10_to_14 = $request->input('grade_10_to_14');
        $resulttemplate->symbol_10_to_14 = $request->input('symbol_10_to_14');
        $resulttemplate->grade_5_to_9 = $request->input('grade_5_to_9');
        $resulttemplate->symbol_5_to_9 = $request->input('symbol_5_to_9');
        $resulttemplate->grade_0_to_4 = $request->input('grade_0_to_4');
        $resulttemplate->symbol_0_to_4 = $request->input('symbol_0_to_4');
        $resulttemplate->user_id = $user_id;

        $resulttemplate->save();

        $request->session()->flash('success', 'Subject created.');

        return redirect()->route('resulttemplates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        if($id < 1)
        {
            return redirect()->route('dashboard');
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
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

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
        
        $data['resulttemplate'] = Resulttemplate::find($id);

        if(empty($data['resulttemplate']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['resulttemplate']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $data['resulttemplate_manager'] = 'No';
        if(Auth::user()->role == 'Consultant' || Auth::user()->role == 'Director')
        {
            $data['resulttemplate_manager'] = 'Yes';
        }
        elseif(Auth::user()->role == 'Staff')
        {
            if($data['staff']->manage_all_results == 'Yes')
            {
                $data['resulttemplate_manager'] = 'Yes';
            }
        }

        return view('resulttemplates.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = 0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        if($id < 1)
        {
            return redirect()->route('dashboard');
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
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

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
        
        $data['resulttemplate'] = Resulttemplate::find($id);

        if(empty($data['resulttemplate']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['resulttemplate']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        return view('resulttemplates.edit')->with($data);
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
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        if($id < 1)
        {
            return redirect()->route('dashboard');
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
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

        $this->validate($request, [
            'name' => ['required']
        ]);
        
        $name = ucwords(strtolower(trim($request->input('name'))));

        $db_check = array(
            'school_id' => $school_id,
            'name' => $name
        );
        $duplicates = Resulttemplate::where($db_check)->where('id', '!=', $id)->get();

        if(!empty($duplicates))
        {
            if($duplicates->count() > 0)
            {
                $request->session()->flash('error', 'The template '.$name.' exists already.');
                return redirect()->route('resulttemplates.edit', $id);
            }
        }

        $this->validate($request, [
            'description' => ['sometimes', 'max:191'],
            'ca_display' => ['required'],
            'subject_1st_test_max_score' => ['required', 'numeric', 'between:0,100'],
            'subject_2nd_test_max_score' => ['required', 'numeric', 'between:0,100'],
            'subject_3rd_test_max_score' => ['required', 'numeric', 'between:0,100'],
            'subject_assignment_score' => ['required', 'numeric', 'between:0,100'], 
            'subject_exam_score' => ['required', 'numeric', 'between:0,100'], 
            'grade_95_to_100' => ['required', 'max:25'], 
            'symbol_95_to_100' => ['required', 'max:5'], 
            'grade_90_to_94' => ['required', 'max:25'], 
            'symbol_90_to_94' => ['required', 'max:5'], 
            'grade_85_to_89' => ['required', 'max:25'], 
            'symbol_85_to_89' => ['required', 'max:5'], 
            'grade_80_to_84' => ['required', 'max:25'], 
            'symbol_80_to_84' => ['required', 'max:5'], 
            'grade_75_to_79' => ['required', 'max:25'], 
            'symbol_75_to_79' => ['required', 'max:5'], 
            'grade_70_to_74' => ['required', 'max:25'], 
            'symbol_70_to_74' => ['required', 'max:5'], 
            'grade_65_to_69' => ['required', 'max:25'], 
            'symbol_65_to_69' => ['required', 'max:5'], 
            'grade_60_to_64' => ['required', 'max:25'], 
            'symbol_60_to_64' => ['required', 'max:5'], 
            'grade_55_to_59' => ['required', 'max:25'], 
            'symbol_55_to_59' => ['required', 'max:5'], 
            'grade_50_to_54' => ['required', 'max:25'], 
            'symbol_50_to_54' => ['required', 'max:5'], 
            'grade_45_to_49' => ['required', 'max:25'], 
            'symbol_45_to_49' => ['required', 'max:5'], 
            'grade_40_to_44' => ['required', 'max:25'], 
            'symbol_40_to_44' => ['required', 'max:5'], 
            'grade_35_to_39' => ['required', 'max:25'], 
            'symbol_35_to_39' => ['required', 'max:5'], 
            'grade_30_to_34' => ['required', 'max:25'], 
            'symbol_30_to_34' => ['required', 'max:5'], 
            'grade_25_to_29' => ['required', 'max:25'], 
            'symbol_25_to_29' => ['required', 'max:5'], 
            'grade_20_to_24' => ['required', 'max:25'], 
            'symbol_20_to_24' => ['required', 'max:5'], 
            'grade_15_to_19' => ['required', 'max:25'], 
            'symbol_15_to_19' => ['required', 'max:5'], 
            'grade_10_to_14' => ['required', 'max:25'], 
            'symbol_10_to_14' => ['required', 'max:5'], 
            'grade_5_to_9' => ['required', 'max:25'], 
            'symbol_5_to_9' => ['required', 'max:5'], 
            'grade_0_to_4' => ['required', 'max:25'], 
            'symbol_0_to_4' => ['required', 'max:5']
        ]);

        $subject_total = $request->input('subject_1st_test_max_score') + $request->input('subject_2nd_test_max_score') +
                        $request->input('subject_3rd_test_max_score') + $request->input('subject_assignment_score') + 
                        $request->input('subject_exam_score');

        if( $subject_total != 100)
        {
            $request->session()->flash('error', 'The term total score is NOT equal to 100%. Please ensure when all the tests, 
                assignment, and exam scores are added we will get 100.');
            return redirect()->route('resulttemplates.edit', $id);
        }

        $resulttemplate = Resulttemplate::find($id);

        $resulttemplate->school_id = $school_id;
        $resulttemplate->name = $name;
        $resulttemplate->description = $request->input('description');
        $resulttemplate->ca_display = $request->input('ca_display');
        $resulttemplate->subject_1st_test_max_score = $request->input('subject_1st_test_max_score');
        $resulttemplate->subject_2nd_test_max_score = $request->input('subject_2nd_test_max_score');
        $resulttemplate->subject_3rd_test_max_score = $request->input('subject_3rd_test_max_score');
        $resulttemplate->subject_assignment_score = $request->input('subject_assignment_score');
        $resulttemplate->subject_exam_score = $request->input('subject_exam_score');
        $resulttemplate->grade_95_to_100 = $request->input('grade_95_to_100');
        $resulttemplate->symbol_95_to_100 = $request->input('symbol_95_to_100');
        $resulttemplate->grade_90_to_94 = $request->input('grade_90_to_94');
        $resulttemplate->symbol_90_to_94 = $request->input('symbol_90_to_94');
        $resulttemplate->grade_85_to_89 = $request->input('grade_85_to_89');
        $resulttemplate->symbol_85_to_89 = $request->input('symbol_85_to_89');
        $resulttemplate->grade_80_to_84 = $request->input('grade_80_to_84');
        $resulttemplate->symbol_80_to_84 = $request->input('symbol_80_to_84');
        $resulttemplate->grade_75_to_79 = $request->input('grade_75_to_79');
        $resulttemplate->symbol_75_to_79 = $request->input('symbol_75_to_79');
        $resulttemplate->grade_70_to_74 = $request->input('grade_70_to_74');
        $resulttemplate->symbol_70_to_74 = $request->input('symbol_70_to_74');
        $resulttemplate->grade_65_to_69 = $request->input('grade_65_to_69');
        $resulttemplate->symbol_65_to_69 = $request->input('symbol_65_to_69');
        $resulttemplate->grade_60_to_64 = $request->input('grade_60_to_64');
        $resulttemplate->symbol_60_to_64 = $request->input('symbol_60_to_64');
        $resulttemplate->grade_55_to_59 = $request->input('grade_55_to_59');
        $resulttemplate->symbol_55_to_59 = $request->input('symbol_55_to_59');
        $resulttemplate->grade_50_to_54 = $request->input('grade_50_to_54');
        $resulttemplate->symbol_50_to_54 = $request->input('symbol_50_to_54');
        $resulttemplate->grade_45_to_49 = $request->input('grade_45_to_49');
        $resulttemplate->symbol_45_to_49 = $request->input('symbol_45_to_49');
        $resulttemplate->grade_40_to_44 = $request->input('grade_40_to_44');
        $resulttemplate->symbol_40_to_44 = $request->input('symbol_40_to_44');
        $resulttemplate->grade_35_to_39 = $request->input('grade_35_to_39');
        $resulttemplate->symbol_35_to_39 = $request->input('symbol_35_to_39');
        $resulttemplate->grade_30_to_34 = $request->input('grade_30_to_34');
        $resulttemplate->symbol_30_to_34 = $request->input('symbol_30_to_34');
        $resulttemplate->grade_25_to_29 = $request->input('grade_25_to_29');
        $resulttemplate->symbol_25_to_29 = $request->input('symbol_25_to_29');
        $resulttemplate->grade_20_to_24 = $request->input('grade_20_to_24');
        $resulttemplate->symbol_20_to_24 = $request->input('symbol_20_to_24');
        $resulttemplate->grade_15_to_19 = $request->input('grade_15_to_19');
        $resulttemplate->symbol_15_to_19 = $request->input('symbol_15_to_19');
        $resulttemplate->grade_10_to_14 = $request->input('grade_10_to_14');
        $resulttemplate->symbol_10_to_14 = $request->input('symbol_10_to_14');
        $resulttemplate->grade_5_to_9 = $request->input('grade_5_to_9');
        $resulttemplate->symbol_5_to_9 = $request->input('symbol_5_to_9');
        $resulttemplate->grade_0_to_4 = $request->input('grade_0_to_4');
        $resulttemplate->symbol_0_to_4 = $request->input('symbol_0_to_4');
        $resulttemplate->user_id = $user_id;

        $resulttemplate->save();

        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('resulttemplates.edit', $resulttemplate->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = 0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        if($id < 1)
        {
            return redirect()->route('dashboard');
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
            return redirect()->route('dashboard');
        }

        $resulttemplate = Resulttemplate::find($id);
        if(empty($resulttemplate))
        {
            $request->session()->flash('error', 'ERROR: An attempt to delete unavailable resource.');
        }
        else
        {
            if($resulttemplate->count() < 1)
            {
                return  redirect()->route('dashboard');
            }

            if(!empty($resulttemplate->arms))
            {
                if(count($resulttemplate->arms) > 0)
                {
                    $request->session()->flash('error', 'ERROR: This result template is in use.');
                    return redirect()->route('resulttemplates.show', $id);
                }
            }
            if(!empty($resulttemplate->results))
            {
                if(count($resulttemplate->results) > 0)
                {
                    $request->session()->flash('error', 'ERROR: This result template is in use.');
                    return redirect()->route('resulttemplates.show', $id);
                }
            }

            $resulttemplate->delete();
            $request->session()->flash('success', 'Record deleted');
        }

        return redirect()->route('resulttemplates.index');
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
                'manage_calendars'  => 'Yes'
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
