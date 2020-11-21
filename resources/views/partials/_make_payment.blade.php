<!-- Payment Modal When Paying for Subscription -->
@php
    $makepayment_item = $makepayment_order->name.' required '.$makepayment_order->price_type;
    $makepayment_order_id = $makepayment_order->id.'-';
    $makepayment_pre_reference = 'ON-'.$makepayment_order->id.'-';
    $makepayment_user_id = $user->id;
    $makepayment_amount = $makepayment_order->final_price; //also works for prepaid since prices are updated with every enrolment
    if($makepayment_order->payment == 'Prepaid' && $makepayment_order->price_type == 'Per-student')
    {
        $makepayment_pre_reference = 'EN-'.$enrolment->id.'-';
        $makepayment_user_id = $enrolment->user_id;

        $makepayment_amount = $makepayment_order->price;
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
          <h4 class="modal-title" id="makePaymentModalLabel">Make Payment</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div style="padding: 30px 0 10px 0;">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Item</th><td>{{ $makepayment_item }}</td>
                    </tr>
                    <tr>
                        <th>Amount</th><th>{{ $makepayment_currency.' '.$makepayment_amount }}</th>
                    </tr>
                </table>
            </div>
            <hr />

            @php
                $method_no = 1;
            @endphp
            <h5>Method {{ $method_no }}: Voucher / scratch card payment</h5>
            <small><div class="alert alert-info">*** Use this method if you have a valid payment voucher or scratch card. ***</div></small>
            <div class="create-form" style="padding-top: 15px; padding-bottom: 30px;">
                <form method="POST" action="{{ route('payments.pay_with_voucher') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="serial_number" class="col-md-4 col-form-label text-md-right">Serial number</label>

                        <div class="col-md-6">
                            <input id="serial_number" type="number" class="form-control @error('serial_number') is-invalid @enderror" name="serial_number" value="{{ old('serial_number') }}" required autocomplete="serial_number" autofocus>
                            
                            @error('serial_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pin" class="col-md-4 col-form-label text-md-right">Pin</label>

                        <div class="col-md-6">
                            <input id="pin" type="number" class="form-control @error('pin') is-invalid @enderror" name="pin" value="{{ old('pin') }}" required autocomplete="pin" autofocus>
                            
                            @error('pin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <hr />
            @php
                $method_no++;
            @endphp
            
            @if ($setting->paymentprocessor_id >= 1 && isset($payment_processor))
                <h5>Method {{ $method_no }}: Online payment</h5>
                <small><div class="alert alert-info">*** Use this method if you want to pay online with your credit/debit card, bank account, USSD etc. ***</div></small>
                @php
                    $method_no++;
                @endphp
                <div style="padding: 30px 0;">
                    <div class="create-form">
                        <!-- for Paystack Payments -->
                        @if ($payment_processor->name == 'Paystack')
                        <form method="POST" action="{{ route('payments.pay_with_paystack') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="payment_order_id" value="{{ $makepayment_order_id }}">
                            <input type="hidden" name="payment_pre_reference" value="{{ $makepayment_pre_reference }}">
                            <input type="hidden" name="payment_amount" value="{{ $makepayment_amount }}">
                            <input type="hidden" name="payment_currency" value="{{ $makepayment_currency }}">
                            <input type="hidden" name="payment_email" value="{{ $user->email }}">
                            <input type="hidden" name="payment_firstname" value="{{ $user->name }}">
                            <input type="hidden" name="payment_user_id" value="{{ $makepayment_user_id }}">
                            <input type="hidden" name="return_page" value="{{ $return_page }}">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Pay now online') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        @endif
                        <!-- End of Paystack Payments -->
                    </div>
                </div>
                <hr />
            @endif
            
            @if (count($bankdetails) > 0)
                <h5>Method {{ $method_no }}: Bank Deposit</h5>
                <small><div class="alert alert-info">*** For bank deposit payments, make payments to the account details below and contact <b>{{ $setting->contact_email }}</b> with the details of your payment. ***</div></small>
                <div class="row">
                    <div class="col-md-8 offset-md-4">
                        @foreach ($bankdetails as $bankdetail)
                            <p>
                                <span class="badge badge-secondary">{{ $bankdetail->bank_name }}</span><br />
                                {{ $bankdetail->account_name }}<br />
                                <b>{{ $bankdetail->account_number }}</b>
                            </p>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
      </div>
    </div>
</div>