<!-- Payment Modal When Paying for Subscription -->
@php
    $makepayment_item = $makepayment_order->name;
    $makepayment_amount = $makepayment_order->final_price; //also works for prepaid since prices are updated with every enrolment
    if($makepayment_order->payment == 'Prepaid' && $makepayment_order->price_type == 'Per-student')
    {
        $makepayment_amount = $makepayment_order->pricing;
        if($user->role == 'Student' OR $user->role == 'Guardian')
        {
            $makepayment_amount = $makepayment_order->school_asking_price;
        }
    }
    $makepayment_currency = $makepayment_order->currency_symbol;
@endphp
<div class="modal fade" id="makePaymentModal" tabindex="-1" role="dialog" aria-labelledby="makePaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="makePaymentModalLabel">Make Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5>Item Summary</h5>
            <hr />

            <h5>Online Payment</h5>
            <div class="alert alert-info">
                Online payments are <b>instant</b>.<br />
                <small>This means automatic activation on successful payments.</small>
            </div>
            <div class="create-form">
                <form method="POST" action="{{ route('payments.store') }}">
                    @csrf
                    @method('PUT')
    
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Item') }}</label>
    
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="Default" disabled autocomplete="name" autofocus>
    
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Pay now online') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <hr />

            <h5>Bank Deposit Payment</h5>
            <div class="alert alert-info">
                Bank deposit payments <b>require verification</b> before activation.<br />
                <small>This could take up to 3 working days.</small>
            </div>
        </div>
      </div>
    </div>
</div>