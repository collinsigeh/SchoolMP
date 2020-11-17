@if ($enrolment->status == 'Inactive')
        <div class="alert alert-danger">
            <h4>Inactive Student Account!</h4>
            The subscription for this student is <b>inactive</b>. <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#makePaymentModal">Make payment</a> to activate.
        </div>
@endif