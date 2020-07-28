 @if ($enrolment->status == 'Inactive')
            <div class="alert alert-danger">
                <h4>Student Account Subscription Notice!</h4>
                The subscription for this student is <b>inactive</b>. <a href="#">Make payment</a> to activate.
            </div>
        @endif