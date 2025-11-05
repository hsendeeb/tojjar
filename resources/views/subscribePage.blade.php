<x-app-layout>

   
      

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm border-0">
          <img src="/images/whish.png" class="card-img-top w-25 mx-auto" alt="whish">

        <div class="card-body">
          <h2 class="card-title h2 archivo text-center">Pay via whish money</h2>
          
          <p class="card-text text-muted text-center">Unlock all features with our premium subscription.</p>
          <h2 class="text-primary h2 text-center mt-3 mb-3">$20 <small class="text-muted">/month</small></h2>
          <div class="p-3 bg-info bg-opacity-10 rounded-2">
            <ul class="list-unstyled">
              <li class="mt-2">1.pay via whish to this number: <span class="fw-bolder">{{ env('PHONE_NUMBER') }}</span></li>
               <li class="mt-2">2.take of picture of the invoice and upload it here</li>
                <li class="mt-2"><span class="fw-bolder">Notice:</span>
                  If you pay through whish to whish you can send the payment link via whatsapp to this number:{{ env('PHONE_NUMBER') }}
                </li>
            </ul>
          </div>
          <form class="mt-3" action="{{ route('payment') }}" method="post" enctype="multipart/form-data">
            @csrf
            <label class="form-label" for="username">proof of payment (upload the whish invoice):</label>
            <input type="file" class="form-control mt-2" name="proof" id="proof" required>
            @if(session('success'))
            <div class="mt-3 bg-success bg-opacity-10 rounded-2 p-2">
           <span><i class="bi bi-check-circle-fill me-1"></i></span> {{ session('success') }}
            </div>
            @endif
            @if($user->isEmpty())
            <button type="submit" class="btn btn-danger w-100 px-4 mt-4">submit request</button>
            @else
             <div class="mt-3 bg-success bg-opacity-10 rounded-2 p-2">
           <span><i class="bi bi-clock-fill me-2"></i></span> waiting confirmation (this may take minutes)
            </div>
            <a class="btn btn-outline-primary mt-2 w-100" href="{{ route('dashboard') }}">Continue browsing</a>
            @endif
          </form>
         
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


   
 
</x-app-layout>