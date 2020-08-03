    @if($student_manager == 'Yes')
        @if ($enrolment->status == 'Inactive')
            <div class="alert alert-danger">
                <h4>Inactive Student Account!</h4>
                The subscription for this student is <b>inactive</b>. <a href="#" data-toggle="modal" data-target="#makePaymentModal">Make payment</a> to activate.
            </div>
        @endif
    @endif