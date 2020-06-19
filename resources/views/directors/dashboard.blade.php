@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._directors_sidebar')

      <div class="col-md-10 main">

        <div class="row">
          <div class="col-8">
            <h3>School Dashboard</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
          @if (count($due_invoices) >= 1)
          <div class="alert alert-info">
            <h4>Due invoices</h4>
            <p>The following invoices require payment.</p>
            <div class="table-responsive" style="background-color: #fff; padding: 5px; border-radious: 4px;">    
              <table class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Item description</th>
                        <th class="text-right">Amount</th>
                        <th class="text-right">Due date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($due_invoices as $order)
                <tr>
                    <td>{{ $order->name }}</td>
                    <td class="text-right">{{ $order->currency_symbol.' '.$order->final_price }}</td>
                    <td class="text-right">{{ date('D d M, Y', $order->subscription_due_date) }}</td>
                    <td class="text-right"><a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @endif
          <div class="row">
            <div class="col-md-12">
                <div class="resource-details">
                    <div class="title">
                        Current Term
                    </div>
                    <div class="body">
                      @if (!$currentterm)
                          <span style="font-size: 3em;">Not Available!</span><br />
                          @if (count($previousterms) < 1)
                            <a href="{{ route('terms.index') }}" class="btn btn-lg btn-primary" style="margin-top:- 15px;">View all session terms</a>
                          @else
                            <a href="{{ route('terms.create') }}" class="btn btn-lg btn-primary" style="margin-top:- 15px;">New term</a>
                          @endif
                      @else

                      <span style="font-size: 3em;">{!! $currentterm->name.' (<small>'.$currentterm->session.'</small>)' !!}</span><br />
                      <a href="{{ route('terms.show', $currentterm->id) }}" class="btn btn-lg btn-primary" style="margin-top:- 15px;">Enter</a>
                      
                      @endif
                    </div>
                </div>
            </div>
          </div>

          
          <div class="row">

            <div class="col-md-6">
              <div class="resource-details">
                  <div class="title">
                      School terms
                  </div>
                  <div class="body">
                    @if (count($previousterms) < 1)
                        None
                    @else
                    <div class="table-responsive">    
                      <table class="table table-striped table-hover table-sm">
                        <thead>
                          <tr><th>#</th><th>School terms</th><th></th></tr>
                        </thead>
                        <tbody>
                          @php
                              $no_term_to_display = 5;
                              $sn = 1;
                              foreach ($previousterms as $sessionterm) {
                                if($sn <= $no_term_to_display)
                                {
                                  echo '<tr><td>'.$sn.'</td><td>'.$sessionterm->name.' - <small>'.$sessionterm->session.'</small></td><td class="text-right"><a href="'.route('terms.show', $sessionterm->id).'" class="btn btn-sm btn-outline-primary">Enter</a></td></tr>';
                                }
                                $sn++;
                              }
                          @endphp
                        </tbody>
                      </table>
                    </div>
                    @if ($sn > $no_term_to_display)
                        <a href="{{ route('terms.index') }}">View more...</a>
                    @else
                      <div class="text-right"><a class="btn btn-sm btn-primary" href="{{ route('terms.index') }}">View all</a></div>
                    @endif
                    @endif
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="resource-details">
                  <div class="title">
                      More options
                  </div>
                  <div class="body">
                    <div class="table-responsive">    
                      <table class="table">
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('schools.edit', $school->id) }}">School information</a></td>
                          </tr>
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('directors.index') }}">School directors</a></td>
                          </tr>
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('staff.index') }}">School staff</a></td>
                          </tr>
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('subjects.index') }}">School subjects</a></td>
                          </tr>
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('classes.index') }}">School classes</a></td>
                          </tr>
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('resulttemplates.index') }}">Result templates</a></td>
                          </tr>
                          <tr>
                            <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('subscriptions.index') }}">Subscriptions and orders</a></td>
                          </tr>
                      </table>
                    </div>
                  </div>
              </div>
            </div>
          </div>

        </div>

      </div>
      
    </div>
  </div>

@endsection