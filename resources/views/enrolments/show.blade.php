@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @if ($user->usertype == 'Client')
        @include('partials._clients_sidebar')
      @else
        @if ($user->role == 'Director')
            @include('partials._directors_sidebar')
        @endif
        @if ($user->role == 'Staff')
            @include('partials._staff_sidebar')
        @endif
      @endif

      <div class="col-md-10 main">
        <div class="row">
          <div class="col-8">
          <h3>{!! $enrolment->user->name.' - (<i>'.$term->name.' - <small>'.$term->session.'</small>'.'</i>)' !!}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                @if (session('enrolment_return_page') == 'enrolments_index')
                    <li class="breadcrumb-item"><a href="{{ route('enrolments.index') }}">Students</a></li>
                @elseif(session('enrolment_return_page') == 'arms_show')
                    <li class="breadcrumb-item"><a href="{{ route('arms.show', $arm->id) }}">{{ $arm->schoolclass->name.' '.$arm->name }}</a></li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route('classsubjects.show', session('enrolment_return_page')->id) }}">{{ session('enrolment_return_page')->subject->name.' - '.session('enrolment_return_page')->arm->schoolclass->name.' '.session('enrolment_return_page')->arm->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $enrolment->user->name }}</li>
              @else
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                @if (session('enrolment_return_page') == 'enrolments_index')
                    <li class="breadcrumb-item"><a href="{{ route('enrolments.index') }}">Students</a></li>
                @elseif(session('enrolment_return_page') == 'arms_show')
                    <li class="breadcrumb-item"><a href="{{ route('arms.show', $arm->id) }}">{{ $arm->schoolclass->name.' '.$arm->name }}</a></li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route('classsubjects.show', session('enrolment_return_page')->id) }}">{{ session('enrolment_return_page')->subject->name.' - '.session('enrolment_return_page')->arm->schoolclass->name.' '.session('enrolment_return_page')->arm->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $enrolment->user->name }}</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
            @include('partials._student_subscription_notice')

            <div class="row">
                <div class="col-md-6">
                    <div class="resource-details">
                        <div class="title">
                            Student details
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-8 offset-md-4">
                                    <img src="{{ config('app.url') }}/images/profile/{{ $enrolment->user->pic }}" alt="Photo" class="user-pic" >
                                </div>
                            </div>
                        
                            <div class="table-responsive collins-table-pem" style="padding-bottom: 18px;">
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                        <th colspan="2" class="text-center">STUDENT IDENTIFICATION</th>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Name:</th>
                                        <td>
                                            {{ $enrolment->user->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Gender:</th>
                                        <td>
                                            {{ $enrolment->user->gender }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Class:</th>
                                        <td>
                                            {{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Enrolment ID:</th>
                                        <td>
                                            {{ $enrolment->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Reg. no.:</th>
                                        <td>
                                            {{ $enrolment->student->registration_number }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            
                            <div class="table-responsive collins-table-pem" style="padding-bottom: 18px;">
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                        <th colspan="2" class="text-center">PERSONAL DETAILS</th>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Last School Attended:</th>
                                        <td>
                                            @if (strlen($enrolment->student->last_school_attended) < 2)
                                                N/A
                                            @else
                                                {{ $enrolment->student->last_school_attended }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Last Class Passed:</th>
                                        <td>
                                            @if (strlen($enrolment->student->last_class_passed) < 2)
                                                N/A
                                            @else
                                                {{ $enrolment->student->last_class_passed }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Hobbies:</th>
                                        <td>
                                            @if (strlen($enrolment->student->hobbies) < 2)
                                                N/A
                                            @else
                                                {{ $enrolment->student->hobbies }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Date of birth:</th>
                                        <td>
                                            {{ $enrolment->student->date_of_birth }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Ailment & Allergies:</th>
                                        <td>
                                            {{ $enrolment->student->ailment }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Disabilities:</th>
                                        <td>
                                            {{ $enrolment->student->disability }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Medication:</th>
                                        <td>
                                            {{ $enrolment->student->medication }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Health Details:</th>
                                        <td>
                                            @if (strlen($enrolment->student->health_detail) < 2)
                                                N/A
                                            @else
                                                {{ $enrolment->student->health_detail }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Religion:</th>
                                        <td>
                                            {{ $enrolment->student->religion }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Nationality:</th>
                                        <td>
                                            {{ $enrolment->student->nationality }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">State of Origin:</th>
                                        <td>
                                            @if (strlen($enrolment->student->state_of_origin) < 2)
                                                N/A
                                            @else
                                                {{ $enrolment->student->state_of_origin }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">LGA of Origin:</th>
                                        <td>
                                            @if (strlen($enrolment->student->lga_of_origin) < 2)
                                                N/A
                                            @else
                                                {{ $enrolment->student->lga_of_origin }}
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="resource-details">
                        <div class="title">
                            Fees & Privileges
                        </div>
                        <div class="body">
                            @if ($student_manager == 'Yes')
                            <div class="table-responsive collins-table-pem">
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                        <th colspan="2" class="text-center">ENROLMENT & FEES</th>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" style="font-weight: 400;">Termly subscription:</th>
                                        <td><span class="badge <?php
                                            if($enrolment->status == 'Active')
                                            {
                                              echo 'badge-success';
                                            }
                                            else
                                            {
                                              echo 'badge-danger';
                                            }
                                        ?>">{{ $enrolment->status }}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" style="font-weight: 400;">Fees payment status:</th>
                                        <td><span class="badge <?php
                                            if($enrolment->fee_status == 'Unpaid')
                                            {
                                              echo 'badge-danger';
                                            }
                                            elseif($enrolment->fee_status == 'Partly-paid')
                                            {
                                              echo 'badge-warning';
                                            }
                                            elseif($enrolment->fee_status == 'Completely-paid')
                                            {
                                              echo 'badge-success';
                                            }
                                        ?>">{{ $enrolment->fee_status }}</span></td>
                                    </tr>
                                </table>
                            </div>
                            <div style="padding-bottom: 40px;" class="text-right">
                                @if ($itempayment_manager == 'Yes' OR $finance_manager == 'Yes')
                                    <button class="btn btn-sm btn-primary">Update fees payment status</button>
                                @endif
                            </div>
                            @endif

                            <div class="table-responsive collins-table-pem">
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                        <th colspan="2" class="text-center">FEES BREAKDOWN</th>
                                    </tr>
                                    <?php $total_amount = 0; ?>
                                    @foreach ($enrolment->arm->items as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-right">{{ $item->currency_symbol.' '.$item->amount }}</td>
                                    </tr>
                                    <?php $total_amount+= $item->amount; ?>
                                    @endforeach
                                </table>
                            </div>

                            <div class="table-responsive collins-table-pem" style="padding-bottom: 23px;">
                                <table class="table table-striped table-hover table-sm">
                                    <tr>
                                        <td>Total Fees:</td>
                                        <td class="text-right"><?php echo $item->currency_symbol.' '.number_format($total_amount, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Amount Paid:</b></td>
                                        @php
                                            $amount_paid = 0;
                                            foreach($enrolment->itempayments as $itempayment)
                                            {
                                                $amount_paid+= $itempayment->amount;
                                            }
                                        @endphp
                                        <td class="text-right"><?php echo '<b>'.$item->currency_symbol.' '.number_format($amount_paid, 2).'</b>' ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right bg-white" style="padding-top: 15px;">
                                            @if ($itempayment_manager == 'Yes' OR $finance_manager == 'Yes')
                                                <button class="btn btn-sm btn-outline-primary">View all payments</button>
                                            @endif
                                            @if ($itempayment_manager == 'Yes')
                                                <button class="btn btn-sm btn-primary" style="margin-left: 20px;">Add new payment</button>
                                            @endif
                                            
                                            
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            @if ($student_privilege_manager == 'Yes')
                            <div class="table-responsive collins-table-pem">
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                        <th colspan="2" class="text-center">TERMLY PRIVILEGES</th>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" style="font-weight: 400;">To write exams:</th>
                                        <td> 
                                            @php
                                            if($enrolment->access_exam == 'Yes')
                                            {
                                                echo '<span class="badge badge-success">Permitted</span>';
                                            }
                                            else
                                            {
                                                echo '<span class="badge badge-danger">NOT permitted</span>';
                                            }
                                        @endphp
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" style="font-weight: 400;">To partake in CA:</th>
                                        <td>
                                            @php
                                            if($enrolment->access_ca == 'Yes')
                                            {
                                                echo '<span class="badge badge-success">Permitted</span>';
                                            }
                                            else
                                            {
                                                echo '<span class="badge badge-danger">NOT permitted</span>';
                                            }
                                        @endphp
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" style="font-weight: 400;">To partake in assignments:</th>
                                        <td>
                                            @php
                                            if($enrolment->access_assignment == 'Yes')
                                            {
                                                echo '<span class="badge badge-success">Permitted</span>';
                                            }
                                            else
                                            {
                                                echo '<span class="badge badge-danger">NOT permitted</span>';
                                            }
                                        @endphp
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" style="font-weight: 400;">To access termly report:</th>
                                        <td>
                                            @php
                                            if($enrolment->access_result == 'Yes')
                                            {
                                                echo '<span class="badge badge-success">Permitted</span>';
                                            }
                                            else
                                            {
                                                echo '<span class="badge badge-danger">NOT permitted</span>';
                                            }
                                        @endphp
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div style="padding-bottom: 18px;" class="text-right">
                                @if ($itempayment_manager == 'Yes' OR $finance_manager == 'Yes')
                                    <button class="btn btn-sm btn-primary">Update privileges</button>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="resource-details">
                        <div class="title">
                            Report
                        </div>
                        <div class="body">
                            @if (count($arm->classsubjects) < 1)
                                None
                            @else
                                <div class="table-responsive">    
                                    <table class="table table-striped table-hover table-sm">
                                        <tbody>
                                            <tr>
                                                <td>Termly report</td>
                                                <td class="text-right"><a href="#" class="btn btn-sm btn-primary">View</a> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @include('partials._subjects_enrolled')
                    </div>
                </div>
            </div>

        </div>
        
    </div>
  </div>

  @php
    $return_page = route('enrolments.show', $enrolment->id);
    $makepayment_order = '';
    foreach($enrolment->subscription->orders as $subscription_order)
    {
        if($makepayment_order == '')
        {
            if($subscription_order->type == 'Purchase')
            {
                $makepayment_order = $subscription_order;
            }
        }
    }
  @endphp
  @if ($makepayment_order != '')
  @include('partials._make_payment')
  @endif
 
  @include('partials._add_subjects_for_student')

@endsection