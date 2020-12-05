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
            <h3>Fees and Other Items {!! ' - (<i>'.$term->name.' - <small>'.$term->session.'</small></i>)' !!}</h3>
          </div>
          <div class="col-4 text-right">
              @if ($user->role == 'Staff')
                  @if ($staff->manage_class_arms == 'Yes')
                    <a href="{{ route('items.create') }}" class="btn btn-primary">New item</a>
                  @endif
              @else
                  <a href="{{ route('items.create') }}" class="btn btn-primary">New item</a>
              @endif
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fees and other items</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fees and other items</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($items) < 1)
            <div class="alert alert-info" sr-only="alert">
                None available.
            </div>
        @else
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th colspan="2"  style="vertical-align: middle;">Item</th>
                            <th>Price</th>
                            <th>Classes affected</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td style="width: 50px; vertical-align: middle;"><img src="{{ config('app.url') }}/images/icons/voucher_icon.png" alt="item_icon" class="collins-table-item-icon"></td>
                                <td style="vertical-align: middle;"><a class="collins-link-within-table" href="{{ route('items.edit', $item->id) }}"><b>{{ $item->name }}</b></a></td>
                                <td style="vertical-align: middle;">{{ $item->currency_symbol.' '.number_format($item->amount, 2) }}</td>
                                <td style="vertical-align: middle;">
                                  <?php $arm_count = 0; ?>
                                    @foreach ($item->arms as $arm)
                                      <span class="badge badge-secondary">{{ $arm->schoolclass->name.' '.$arm->name }}</span>
                                      <?php $arm_count++; ?>
                                    @endforeach
                                    <?php if($arm_count == 0){ echo '<b>None!</b>'; } ?>
                                </td>
                                <td style="vertical-align: middle;"><a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Manage</a></td>
                                <td class="text-right" style="vertical-align: middle;">
                                  <?php
                                      if(count($item->itempayments) < 1)
                                      {
                                          ?>
                                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $item->id }}">
                                              X
                                          </button>
                                          <?php
                                      }
                                  ?></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $items->links() }}
        @endif
    </div>
  </div>

<!-- confirmDeleteModal Series -->
@foreach ($items as $item)
    @php
        $itemid     = $item->id;
        $itemname   = $item->name;
        $itemprice  = $item->currency_symbol.' '.number_format($item->amount, 2);
    @endphp
    @include('partials._confirm_delete')
@endforeach
<!-- End confirmDeleteModal Series -->

@endsection