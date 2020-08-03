<div class="modal fade" id="makePaymentModal" tabindex="-1" role="dialog" aria-labelledby="makePaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="makePaymentModalLabel">Update School Asking Price</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="{{ route('orders.update', $order->id) }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="update_type" value="School_Asking_Price" required>
    
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Item') }}</label>
    
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $order->name }}" disabled autocomplete="name" autofocus>
    
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="pricing" class="col-md-4 col-form-label text-md-right">{{ __('Pricing ('.$order->currency_symbol).')' }}{!! '<br /><small>(<i>'.$order->price_type.'</i>)</small>' !!}</label>
    
                        <div class="col-md-8">
                            <input id="pricing" type="text" class="form-control @error('pricing') is-invalid @enderror" name="pricing" value="{{ $order->price }}" disabled autocomplete="pricing" autofocus>
                            <small>Cost price for this subscription</small>
                            @error('pricing')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="school_asking_price" class="col-md-4 col-form-label text-md-right">{{ __('School asking price ('.$order->currency_symbol).')' }}</label>
    
                        <div class="col-md-8">
                            <input id="school_asking_price" type="text" class="form-control @error('school_asking_price') is-invalid @enderror" name="school_asking_price" value="{{ $order->school_asking_price }}" required autocomplete="school_asking_pricing" autofocus>
                            <small>How much the school wants to collect {{ $order->price_type }}</small>
                            @error('school_asking_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>