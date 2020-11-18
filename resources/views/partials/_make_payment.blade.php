<!-- Payment Modal When Paying for Subscription -->
@php
    $makepayment_item = $makepayment_order->name.' required '.$makepayment_order->price_type;
    $makepayment_order_id = $makepayment_order->id.'-';
    $makepayment_pre_reference = 'ON-'.$makepayment_order->id.'-';
    $makepayment_amount = $makepayment_order->final_price; //also works for prepaid since prices are updated with every enrolment
    if($makepayment_order->payment == 'Prepaid' && $makepayment_order->price_type == 'Per-student')
    {
        $makepayment_pre_reference = 'EN-'.$enrolment->id.'-';

        $makepayment_amount = $makepayment_order->price;
        if($user->role == 'Student' OR $user->role == 'Guardian')
        {
            $makepayment_amount = $makepayment_order->school_asking_price;
        }
    }
    $makepayment_currency = $makepayment_order->currency_symbol;

    $method_no = 1;
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
            <div style="padding: 30px 0;">
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
            
            @if ($setting->paymentprocessor_id >= 1 && isset($payment_processor))
                <h5>Method {{ $method_no }}: Online payment</h5>
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
                            <input type="hidden" name="payment_user_id" value="{{ $user->id }}">
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

            <h5>Method {{ $method_no }}: Bank Deposit</h5>
            <div class="alert alert-info">
                Bank deposit payments <b>require verification</b> before activation.<br />
                <small>This could take up to 3 working days.</small>
            </div>
        </div>
      </div>
    </div>
</div>