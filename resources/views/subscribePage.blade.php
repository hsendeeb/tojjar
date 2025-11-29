<x-app-layout>




  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm border-0">
          <img src="/images/whish.png" class="card-img-top w-25 mx-auto" alt="whish">

          <div class="card-body">
            <h2 class="card-title h2 archivo text-center">Pay via whish money</h2>

            <p class="card-text text-muted text-center fw-bolder">Unlock all features with our premium subscription.</p>
            <ul class="list-unstyled mt-3">
          <li class="d-flex align-items-start mb-2"><span><i class="bi bi-check-lg me-2"></i></span>  Unlimited ad boosts <span><i class="ms-2 bi bi-rocket-takeoff-fill"></i></span></li>
          <li class="d-flex align-items-start mb-2"><span><i class="bi bi-check-lg me-2"></i></span>  Verification badge <span class="ms-2 text-primary"><i class="bi bi-patch-check-fill"></i></span></li>
          <li class="d-flex align-items-start mb-2"><span><i class="bi bi-check-lg me-2"></i></span>  Your ads will be at top of search results <span><i class="bi bi-graph-up-arrow ms-1"></i></span>
</li>
        </ul>
            <h2 class="text-primary h2 text-center mt-3 mb-3">$15 <small class="text-muted">/month</small></h2>
            <div class="p-3 bg-info bg-opacity-10 rounded-2">
              <ul class="list-unstyled">
                <li class="mt-2">1.pay via whish to this number: <span
                    class="fw-bolder">{{ env('PHONE_NUMBER') }}</span></li>
                <li class="mt-2">2.take a photo of the invoice and upload it here .</li>
                <li class="mt-2"><span class="fw-bolder">Notice:</span>
                  If you pay through <span class="fw-bolder">"whish to whish"</span> screenshot the invoice and upload it here.
                 
                </li>
              </ul>
            </div>
            <form id="vehicleForm" class="mt-3" action="{{ route('payment') }}" method="post" enctype="multipart/form-data">
              @csrf
              <label class="form-label" for="username">proof of payment (upload the whish invoice):</label>
              <input type="file" class="form-control mt-2 border-danger form-input" name="proof" id="proof" accept="image/*" required>
              @if(session('success'))
                <div class="mt-3 bg-success bg-opacity-10 rounded-2 p-2">
                  <span><i class="bi bi-check-circle-fill me-1"></i></span> {{ session('success') }}
                </div>
              @endif
             @if(!empty($subscription) && $subscription->is_active)
              <div class="mt-3 bg-success bg-opacity-10 rounded-2 p-2">
              <p>Your  premium plan is currently active.</p>
              <p class="fw-bolder">Any extra payment will extend your subscription by 1 month</p>
              </div>
              @endif
              @if(Auth::user()?->paymentRequest?->last()?->status=='rejected') 
              <div class="mt-3 bg-danger bg-opacity-10 rounded-2 p-2">
              <p><span class="text-danger me-2"><i class="bi bi-x-circle-fill"></i></span>Your last premium plan request was rejected.</p>
              <p class="fw-bolder">For more information contact this number:71 994 952</p>
              </div>
              @endif
             
             

 <div class="text-center mt-3 ">
        <button id="submit" type="submit"
            class="d-inline-flex gap-2 justify-content-center align-items-center btn btn-danger w-75 text-center px-2 py-2">
            submit
            <div id="btn-spinner" class="btn-spinner" style="display:none"></div>
        </button>

    </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>




</x-app-layout>