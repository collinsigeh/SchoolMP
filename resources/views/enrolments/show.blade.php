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
                    @if (null !== session('enrolment_return_page'))
                        <li class="breadcrumb-item"><a href="{{ route('classsubjects.show', session('enrolment_return_page')->id) }}">{{ session('enrolment_return_page')->subject->name.' - '.session('enrolment_return_page')->arm->schoolclass->name.' '.session('enrolment_return_page')->arm->name }}</a></li>
                    @endif
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $enrolment->user->name }}</li>
              @else
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                @if (session('enrolment_return_page') == 'enrolments_index')
                    <li class="breadcrumb-item"><a href="{{ route('enrolments.index') }}">Students</a></li>
                @elseif(session('enrolment_return_page') == 'arms_show')
                    <li class="breadcrumb-item"><a href="{{ route('arms.show', $arm->id) }}">{{ $arm->schoolclass->name.' '.$arm->name }}</a></li>
                @else
                    @if (null !== session('enrolment_return_page'))
                        <li class="breadcrumb-item"><a href="{{ route('classsubjects.show', session('enrolment_return_page')->id) }}">{{ session('enrolment_return_page')->subject->name.' - '.session('enrolment_return_page')->arm->schoolclass->name.' '.session('enrolment_return_page')->arm->name }}</a></li>
                    @endif
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
                                              echo 'badge-primary';
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
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateFeePaymentStatusModal" style="margin-left: 20px;">Update fees payment status</button>
                                @endif
                            </div>
                            @endif

                            <div class="table-responsive collins-table-pem">
                                <table class="table table-striped table-hover table-sm">
                                    <tr>
                                        <th colspan="4" class="text-center" style="background-color: #f1f1f1;">SCHOOL FEES & OTHER ITEMS</th>
                                    </tr>
                                    <?php 
                                        $required_amount = 0;
                                        $optional_amount = 0;
                                        $sn = 1;
                                    ?>
                                    @foreach ($enrolment->arm->items as $item)
                                    <?php if($item->type == 'Required'){ ?>
                                        <tr>
                                            <td>{{ $sn.'.'}}</td>
                                            <td><b>{{ $item->name }}</b></td>
                                            <td class="text-right">{{ $item->currency_symbol.' '.$item->amount }}</td>
                                            <td><span class="badge badge-secondary">Required</span></td>
                                        </tr>
                                        <?php $required_amount+= $item->amount; ?>
                                    <?php }else{ ?>
                                        <tr>
                                            <td>{{ $sn.'.'}}</td>
                                            <td><b>{{ $item->name }}</b></td>
                                            <td class="text-right">{{ $item->currency_symbol.' '.$item->amount }}</td>
                                            <td><span class="badge badge-light">Optional</span></td>
                                        </tr>
                                        <?php $optional_amount+= $item->amount; ?>
                                    <?php } $sn++; ?>
                                    @endforeach
                                    <tr><td colspan="4" style="background-color: #fff;"></td></tr>
                                </table>
                            </div>

                            @php
                                $required_payment = 0;
                                foreach($enrolment->itempayments as $itempayment)
                                {
                                    if ($itempayment->status == 'Confirmed' && $itempayment->item_id > 0) 
                                    {
                                        if($itempayment->item->type == 'Required')
                                        {
                                            $required_payment+= $itempayment->amount;
                                        }
                                    }
                                }
                                $optional_payment = 0;
                                foreach($enrolment->itempayments as $itempayment)
                                {
                                    if ($itempayment->status == 'Confirmed') 
                                    {
                                        if($itempayment->item_id > 0)
                                        {
                                            if($itempayment->item->type != 'Required')
                                            {
                                                $optional_payment+= $itempayment->amount;
                                            }
                                        }
                                        else
                                        {
                                            $optional_payment+= $itempayment->amount;
                                        }
                                    }
                                }
                            @endphp
                            @if ($itempayment_manager == 'Yes' OR $finance_manager == 'Yes')
                            <div class="table-responsive collins-table-pem">
                                <table class="table table-hover table-sm">
                                    <tr>
                                        <th colspan="3" class="text-center" style="background-color: #f1f1f1;">FEES & PAYMENT SUMMARY</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-right"  style="background-color: #f1f1f1;">Fees Summary</th>
                                        <th class="text-right" style="background-color: #f1f1f1;">Payments Confirmed</th>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff;"><i>Required Items:</i></td>
                                        <td class="text-right" style="background-color: #fff;"><i><?php echo $setting->base_currency_symbol.' '.number_format($required_amount, 2) ?></i></td>
                                        <td class="text-right" style="background-color: #fff;"><i><?php echo $setting->base_currency_symbol.' '.number_format($required_payment, 2) ?></i></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff;"><i>Optional Items:</i></td>
                                        <td class="text-right" style="background-color: #fff;"><i><?php echo $setting->base_currency_symbol.' '.number_format($optional_amount, 2) ?></i></td>
                                        <td class="text-right" style="background-color: #fff;"><i><?php echo $setting->base_currency_symbol.' '.number_format($optional_payment, 2) ?></i></td>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #f1f1f1">Total:</th>
                                        <th class="text-right" style="background-color: #f1f1f1"><i>{{ $setting->base_currency_symbol.' '.number_format($required_amount + $optional_amount, 2) }}</i></th>
                                        <th class="text-right" style="background-color: #f1f1f1"><i>{{ $setting->base_currency_symbol.' '.number_format($required_payment + $optional_payment, 2) }}</i></th>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right bg-white" style="padding-top: 15px; padding-bottom: 25px;">
                                            
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#allPaymentModal">View all payments</button>
                                            
                                            @if ($itempayment_manager == 'Yes')
                                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addStudentPaymentModal" style="margin-left: 20px;">Add new payment</button>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @endif
                            
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
                                @if ($student_privilege_manager == 'Yes')
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateStudentPrivilegesModal">Update privileges</button>
                                @endif
                            </div>
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
                                                <td class="text-right"><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#studentResultModal">View</button> </td>
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



<!-- addStudentPaymentModal -->
<div class="modal fade" id="addStudentPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addStudentPaymentModalLabel">Add new payment received {!! ' - (<i>'.$term->name.' - <small>'.$term->session.'</small>'.'</i>)' !!}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info" style="margin-bottom: 30px;">
                <b>{{ $enrolment->user->name }}</b><br/>
                <small>({{ $enrolment->student->registration_number }})</small><br />
                <span class="badge badge-secondary">{{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}</span>
            </div>
            <div class="create-form">
                <form method="POST" action="{{ route('itempayments.store') }}">
                    @csrf

                    <input type="hidden" name="return_page" value="enrolments_show">
                    <input type="hidden" name="enrolment_id" value="{{ $enrolment->id }}">

                    <div class="form-group row"> 
                        <label for="item_paid_for" class="col-md-4 col-form-label text-md-right">{{ __('Item paid for') }}</label>
    
                        <div class="col-md-8">
                            <select id="item_paid_for" type="text" class="form-control @error('item_paid_for') is-invalid @enderror" name="item_paid_for" autocomplete="item_paid_for" autofocus>
                                @php
                                    foreach ($arm->items as $item) {
                                        echo '<option value="'.$item->id.'">'.$item->name.'</option>';
                                    }
                                @endphp
                                <option value="0">No specific item</option>
                            </select>
    
                            @error('item_paid_for')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="currency_symbol" value="{{ $setting->base_currency_symbol }}">
                    <div class="form-group row">
                        <label for="amount_received" class="col-md-4 col-form-label text-md-right">{{ __('Amount ('.$setting->base_currency_symbol.')') }}</label>
    
                        <div class="col-md-8">
                            <input id="amount_received" type="text" class="form-control @error('amount_received') is-invalid @enderror" name="amount_received" value="{{ old('amount_received') }}" required autocomplete="amount_received" autofocus>
                            <small class="text-muted">*** Enter amount only. <b>E.g. 450.75</b> ***</small>
                            @error('amount_received')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="method_of_payment" class="col-md-4 col-form-label text-md-right">{{ __('Method of payment') }}</label>
    
                        <div class="col-md-8">
                            <select id="method_of_payment" type="text" class="form-control @error('method_of_payment') is-invalid @enderror" name="method_of_payment" autocomplete="method_of_payment" autofocus>
                                <option value="Offline (Cash)">Offline (Cash)</option>
                                <option value="Offline (Bank deposit)">Offline (Bank deposit)</option>
                                <option value="Online">Online</option>
                            </select>
    
                            @error('method_of_payment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="special_note" class="col-md-4 col-form-label text-md-right">{{ __('Special note (Optional):') }}</label>
                        
                        <div class="col-md-8">
                            <textarea id="special_note" class="form-control @error('special_note') is-invalid @enderror" name="special_note">{{ old('special_note') }}</textarea>
    
                            @error('special_note')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="status" value="Confirmed">

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End addStudentPaymentModal -->


<!-- allPaymentModal -->
<div class="modal fade" id="allPaymentModal" tabindex="-1" role="dialog" aria-labelledby="allPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="allPaymentModalLabel">Payments breakdown</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info" style="margin-bottom: 30px;">
                <b>{{ $enrolment->user->name }}</b><br/>
                <small>({{ $enrolment->student->registration_number }})</small><br />
                <span class="badge badge-secondary">{{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}</span>
            </div>
            @if (count($enrolment->itempayments) < 1)
                <div class="alert alert-info">No payment yet.</div>
            @else
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Payments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sn = 1; $no_other_payment = 0; ?>
                        @foreach ($enrolment->arm->items as $item)
                            <tr>
                                <td>{{ $sn.'.' }}</td>
                                <td>
                                    {{ $item->name }}<br />
                                    <span class="badge badge-secondary">{{ $item->currency_symbol.' '.number_format($item->amount) }}</span>
                                </td>
                                <td>
                                    <?php $payments_for_item = 0; ?>
                                    <table class="table table-sm">
                                        @foreach ($enrolment->itempayments as $itempayment)
                                            @if ($itempayment->item_id == $item->id)
                                                <?php $payments_for_item++; ?>
                                                <tr>
                                                    <td>
                                                        {!! '<b>'.$itempayment->currency_symbol.' '.number_format($itempayment->amount, 2).'</b>' !!}
                                                    </td>
                                                    <td class="text-right">
                                                        <small><i><?php echo date('d-M-Y', strtotime($itempayment->created_at)) ?></i></small>
                                                    </td>
                                                    <td class="text-right">
                                                        @php
                                                            if($itempayment->status == 'Confirmed')
                                                            {
                                                                echo '<span class="badge badge-success">Confirmed</span>';
                                                            }
                                                            elseif($itempayment->status == 'Declined')
                                                            {
                                                                echo '<span class="badge badge-danger">Declined</span>';
                                                            }
                                                            else
                                                            {
                                                                echo '<span class="badge badge-info">Pending</span>';
                                                            }
                                                        @endphp
                                                    </td>
                                                </tr>
                                            @else
                                                <?php if($itempayment->item_id == 0){ $no_other_payment++; } ?>
                                            @endif
                                        @endforeach
                                        <?php if($payments_for_item == 0){ echo '<span class="badge badge-secondary">No payments yet</span>'; } ?>
                                    </table>
                                </td>
                            </tr>
                            <?php $sn++; ?>
                        @endforeach
                        @if ($no_other_payment > 0)
                            <tr>
                                <td>{{ $sn.'.' }}</td>
                                <td>Other payments</td>
                                <td>
                                    <table class="table table-sm">
                                        @foreach ($enrolment->itempayments as $itempayment)
                                            @if ($itempayment->item_id == 0)
                                                <tr>
                                                    <td>
                                                        {!! '<b>'.$itempayment->currency_symbol.' '.number_format($itempayment->amount, 2).'</b>' !!}
                                                    </td>
                                                    <td class="text-right">
                                                        <small><i><?php echo date('d-M-Y', strtotime($itempayment->created_at)) ?></i></small>
                                                    </td>
                                                    <td class="text-right">
                                                        @php
                                                            if($itempayment->status == 'Confirmed')
                                                            {
                                                                echo '<span class="badge badge-success">Confirmed</span>';
                                                            }
                                                            elseif($itempayment->status == 'Declined')
                                                            {
                                                                echo '<span class="badge badge-danger">Declined</span>';
                                                            }
                                                            else
                                                            {
                                                                echo '<span class="badge badge-info">Pending</span>';
                                                            }
                                                        @endphp
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @if ($itempayment_manager == 'Yes')
            <div class="text-center">
                <hr>
                <a href="{{ route('itempayments.index') }}" class="btn btn-sm btn-outline-primary">Go to payments page for more details</a>
            </div>
            @endif
            @endif
        </div>
      </div>
    </div>
</div>
<!-- End allPaymentModal -->

<!-- updateFeePaymentStatusModal -->
<div class="modal fade" id="updateFeePaymentStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateFeePaymentStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateFeePaymentStatusModalLabel">Fees payment status {!! ' - (<i>'.$term->name.' - <small>'.$term->session.'</small>'.'</i>)' !!}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <b>{{ $enrolment->user->name }}</b><br/>
                <small>({{ $enrolment->student->registration_number }})</small><br />
                <span class="badge badge-secondary">{{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}</span>
            </div>
            <div class="table-responsive" style="padding-bottom: 40px;">
                <table class="table table-hover table-sm">
                    <tr>
                        <th style="background-color: #f1f1f1"></th>
                        <th class="text-right" style="background-color: #f1f1f1">Fees Summary</th>
                        <th class="text-right" style="background-color: #f1f1f1">Payments Confirmed</th>
                    </tr>
                    <tr>
                        <td>Required items:</td>
                        <td class="text-right"><?php echo $setting->base_currency_symbol.' '.number_format($required_amount, 2) ?></td>
                        <td class="text-right">{{ $setting->base_currency_symbol.' '.number_format($required_payment, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Optional items:</td>
                        <td class="text-right"><?php echo $setting->base_currency_symbol.' '.number_format($optional_amount, 2) ?></td>
                        <td class="text-right">{{ $setting->base_currency_symbol.' '.number_format($optional_payment, 2) }}</td>
                    </tr>
                    <tr>
                        <th style="background-color: #f1f1f1">Total:</th>
                        <th class="text-right" style="background-color: #f1f1f1">{{ $setting->base_currency_symbol.' '.number_format($required_amount + $optional_amount, 2) }}</th>
                        <th class="text-right" style="background-color: #f1f1f1">{{ $setting->base_currency_symbol.' '.number_format($required_payment + $optional_payment, 2) }}</th>
                    </tr>
                </table>
            </div>
            <small><div class="alert alert-info"><b>Hint: </b>Select the new payment status and click on save</div></small>
            <div class="create-form">
                <form method="POST" action="{{ route('enrolments.update', $enrolment->id) }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="item_to_update" value="fee_status">

                    <div class="form-group row"> 
                        <label for="fee_payment_status" class="col-md-4 col-form-label text-md-right">{{ __('Fees payment status ') }}</label>
    
                        <div class="col-md-8">
                            <select id="fee_payment_status" type="text" class="form-control @error('fee_payment_status') is-invalid @enderror" name="fee_payment_status" autocomplete="fee_payment_status" autofocus>
                                <option value="Pending" <?php if($enrolment->fee_status == 'Unpaid'){ echo 'selected'; } ?>>Unpaid</option>
                                <option value="Partly-paid" <?php if($enrolment->fee_status == 'Partly-paid'){ echo 'selected'; } ?>>Partly-paid</option>
                                <option value="Completely-paid" <?php if($enrolment->fee_status == 'Completely-paid'){ echo 'selected'; } ?>>Completely-paid</option>
                            </select>
    
                            @error('fee_payment_status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End updateFeePaymentStatusModal -->

<!-- updateStudentPrivilegesModal -->
<div class="modal fade" id="updateStudentPrivilegesModal" tabindex="-1" role="dialog" aria-labelledby="updateStudentPrivilegesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateStudentPrivilegesModalLabel">Update student's privileges {!! ' - (<i>'.$term->name.' - <small>'.$term->session.'</small>'.'</i>)' !!}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <b>{{ $enrolment->user->name }}</b><br/>
                <small>({{ $enrolment->student->registration_number }})</small><br />
                <span class="badge badge-secondary">{{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}</span>
            </div>
            
            <small><div class="alert alert-info"><b>Hint: </b>Select the preferred privileges and click on save</div></small>
            <div class="create-form">
                <form method="POST" action="{{ route('enrolments.update', $enrolment->id) }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="item_to_update" value="access_privileges">

                    <div class="form-group row"> 
                        <label for="can_write_exams" class="col-md-5 col-form-label text-md-right">{{ __('Can write exams') }}</label>
    
                        <div class="col-md-7">
                            <select id="can_write_exams" type="text" class="form-control @error('can_write_exams') is-invalid @enderror" name="can_write_exams" autocomplete="can_write_exams" autofocus>
                                <option value="No" <?php if($enrolment->access_exam == 'No'){ echo 'selected'; } ?>>No</option>
                                <option value="Yes" <?php if($enrolment->access_exam == 'Yes'){ echo 'selected'; } ?>>Yes</option>
                            </select>
    
                            @error('can_write_exams')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="can_partake_in_CA" class="col-md-5 col-form-label text-md-right">{{ __('Can partake in C.A.') }}</label>
    
                        <div class="col-md-7">
                            <select id="can_partake_in_CA" type="text" class="form-control @error('can_partake_in_CA') is-invalid @enderror" name="can_partake_in_CA" autocomplete="can_partake_in_CA" autofocus>
                                <option value="No" <?php if($enrolment->access_ca == 'No'){ echo 'selected'; } ?>>No</option>
                                <option value="Yes" <?php if($enrolment->access_ca == 'Yes'){ echo 'selected'; } ?>>Yes</option>
                            </select>
    
                            @error('can_partake_in_CA')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="can_partake_in_assignments" class="col-md-5 col-form-label text-md-right">{{ __('Can partake in assignments') }}</label>
    
                        <div class="col-md-7">
                            <select id="can_partake_in_assignments" type="text" class="form-control @error('can_partake_in_assignments') is-invalid @enderror" name="can_partake_in_assignments" autocomplete="can_partake_in_assignments" autofocus>
                                <option value="No" <?php if($enrolment->access_assignment == 'No'){ echo 'selected'; } ?>>No</option>
                                <option value="Yes" <?php if($enrolment->access_assignment == 'Yes'){ echo 'selected'; } ?>>Yes</option>
                            </select>
    
                            @error('can_partake_in_assignments')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="can_access_termly_report" class="col-md-5 col-form-label text-md-right">{{ __('Can access termly report') }}</label>
    
                        <div class="col-md-7">
                            <select id="can_access_termly_report" type="text" class="form-control @error('can_access_termly_report') is-invalid @enderror" name="can_access_termly_report" autocomplete="can_access_termly_report" autofocus>
                                <option value="No" <?php if($enrolment->access_result == 'No'){ echo 'selected'; } ?>>No</option>
                                <option value="Yes" <?php if($enrolment->access_result == 'Yes'){ echo 'selected'; } ?>>Yes</option>
                            </select>
    
                            @error('can_access_termly_report')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-5">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End updateStudentPrivilegesModal -->

<!-- studentResultModal -->
<div class="modal fade bd-example-modal-lg" id="studentResultModal" tabindex="-1" role="dialog" aria-labelledby="studentResultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="studentResultModalLabel">Student Result {!! ' - (<i>'.$term->name.' - <small>'.$term->session.'</small>'.'</i>)' !!}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <b>{{ $enrolment->user->name }}</b><br/>
                <small>({{ $enrolment->student->registration_number }})</small><br />
                <span class="badge badge-secondary">{{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}</span>
            </div>
            
            <small><div class="alert alert-info"><b>Hint: </b>Select the preferred privileges and click on save</div></small>

            @if ($enrolment->arm->resulttemplate->ca_display == 'Summary')
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th style="vertical-align: middle">Subject</th>
                            <th class="text-right" style="vertical-align: middle">C.A.<br><span class="badge badge-secondary">40 %</span></th>
                            <th class="text-right" style="vertical-align: middle">Exam<br><span class="badge badge-secondary">60 %</span></th>
                            <th class="text-right" style="vertical-align: middle">Total<br><span class="badge badge-secondary">100 %</span></th>
                            <th class="text-right" style="vertical-align: middle">Grade</th>
                            <th class="text-right" style="vertical-align: middle">Remark</th>
                        </tr>
                        @foreach ($enrolment->results as $result_slip)
                            <tr>
                                <td>{{ $result_slip->classsubject->subject->name }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @elseif ($enrolment->arm->resulttemplate->ca_display == 'Breakdown')
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th style="vertical-align: middle; background-color: #f1f1f1">Subject</th>
                            @if ($enrolment->arm->resulttemplate->subject_1st_test_max_score > 0)
                                <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">1st Test<br><span class="badge badge-secondary">{{ $enrolment->arm->resulttemplate->subject_1st_test_max_score }} %</span></th>
                            @endif
                            @if ($enrolment->arm->resulttemplate->subject_2nd_test_max_score > 0)
                                <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">2nd Test<br><span class="badge badge-secondary">{{ $enrolment->arm->resulttemplate->subject_2nd_test_max_score }} %</span></th>
                            @endif
                            @if ($enrolment->arm->resulttemplate->subject_3rd_test_max_score > 0)
                                <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">3rd Test<br><span class="badge badge-secondary">{{ $enrolment->arm->resulttemplate->subject_3rd_test_max_score }} %</span></th>
                            @endif
                            @if ($enrolment->arm->resulttemplate->subject_assignment_score > 0)
                                <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">Ass. Score<br><span class="badge badge-secondary">{{ $enrolment->arm->resulttemplate->subject_assignment_score }} %</span></th>
                            @endif
                            <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">Exam<br><span class="badge badge-secondary">{{ $enrolment->arm->resulttemplate->subject_exam_score }} %</span></th>
                            <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">Total<br><span class="badge badge-secondary">100 %</span></th>
                            <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">Grade</th>
                            <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">Remark</th>
                        </tr>
                        @foreach ($enrolment->results as $result_slip)
                            <?php $total = 0; ?>
                            <tr>
                                <td style="background-color: #f1f1f1">{{ $result_slip->classsubject->subject->name }}</td>
                                @if ($enrolment->arm->resulttemplate->subject_1st_test_max_score > 0)
                                    <td class="text-right">{{ $result_slip->subject_1st_test_score }}</td>
                                    <?php $total += $result_slip->subject_1st_test_score; ?>
                                @endif
                                @if ($enrolment->arm->resulttemplate->subject_2nd_test_max_score > 0)
                                    <td class="text-right">{{ $result_slip->subject_2nd_test_score }}</td>
                                    <?php $total += $result_slip->subject_2nd_test_score; ?>
                                @endif
                                @if ($enrolment->arm->resulttemplate->subject_3rd_test_max_score > 0)
                                    <td class="text-right">{{ $result_slip->subject_3rd_test_score }}</td>
                                    <?php $total += $result_slip->subject_3rd_test_score; ?>
                                @endif
                                @if ($enrolment->arm->resulttemplate->subject_assignment_score > 0)
                                    <td class="text-right">{{ $result_slip->subject_assignment_score }}</td>
                                    <?php $total += $result_slip->subject_assignment_score; ?>
                                @endif
                                <td class="text-right">{{ $result_slip->subject_exam_score }}</td>
                                <?php $total += $result_slip->subject_exam_score; ?>
                                <td class="text-right" style="background-color: #f1f1f1">{{ $total }}</td>
                                @php
                                    if($total >= 95 && $total <= 100)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->grade_95_to_100;
                                        $remark = $enrolment->arm->resulttemplate->symbol_95_to_100;
                                    }
                                    elseif($total >= 90 && $total <= 94)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->grade_90_to_94;
                                        $remark = $enrolment->arm->resulttemplate->symbol_90_to_94;
                                    }
                                    elseif($total >= 85 && $total <= 89)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->grade_90_to_94;
                                        $remark = $enrolment->arm->resulttemplate->symbol_90_to_94;
                                    }
                                @endphp
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif

            <div class="create-form">
                <form method="POST" action="#">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="item_to_update" value="access_privileges">

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-5">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End studentResultModal -->


@endsection