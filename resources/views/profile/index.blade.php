<x-app-layout>
    
    <div id="loader-wrapper">
        <div class="spinner"></div>
    </div>
    <button id="glass-button" class="glass-button px-4 py-1 rounded-pill text-dark"><i
            class="bi bi-arrow-up-circle-fill"></i></button>
    @if (session('message'))
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    @endif
   
        <div class="modal fade" id="premiumModal" tabindex="-1" aria-labelledby="premiumModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header  bg-gradient-primary">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
         <img class="w-50 mx-auto" src="/images/boost.jpg" alt="boost">
        <h3 class=" mx-auto h3 archivo text-center" id="premiumModalLabel">Go Premium</h3>
        <div class="modal-body text-center bg-success bg-opacity-10 rounded-2">
       
        <p class="fs-5"></p>
        <ul class="list-unstyled">
          <li class="d-flex align-items-start mb-2"><span><i class="bi bi-check-lg me-2"></i></span>  Unlimited ad boosts <span><i class="ms-2 bi bi-rocket-takeoff-fill"></i></span></li>
          <li class="d-flex align-items-start mb-2"><span><i class="bi bi-check-lg me-2"></i></span>  Verification badge <span class="ms-2 text-primary"><i class="bi bi-patch-check-fill"></i></span></li>
          <li class="d-flex align-items-start mb-2"><span><i class="bi bi-check-lg me-2"></i></span>  Your ads will be at top of search results <span class="ms-2"><i class="bi bi-graph-up-arrow"></i></span>
</li>
        </ul>
      </div>
      <div class="modal-footer justify-content-center">
        
        <a href="{{ route('subscribePage') }}" class="btn btn-success">Subscribe Now</a>
      </div>
    </div>
  </div>
</div>



    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="p-5 text-center">
                    <div class="container d-flex justify-content-center">

                        @if($user->image != 'public/images/avatar.png')
                            <img src="{{ Storage::url($user->image)}}" style="width:100px; height:100px; object-fit:cover;"
                                class="rounded-circle me-2" loading="lazy">
                        @else
                            <img src="/images/avatar.jpg" style="width:100px; height:100px; object-fit:cover;"
                                class="rounded-circle me-2" loading="lazy">
                        @endif
                    </div>
                    <h3 class="h3 mt-1">{{$user->name}}
                         @if($user->email_verified_at) <span class="text-primary"><i
                                                class="bi bi-patch-check-fill"></i></span>
                                                 @endif</h3>
                    <div class="d-flex justify-content-center gap-5 mt-2">
                        <div>
                            <h5>Ads</h5>
                            <h4 class="h4 archivo mt-1">{{ ($user->ad->count() >= 1000) ? number_format($user->ad->count() / 1000, 1) . 'K' : $user->ad->count()}}</h4>
                        </div>
                        <div>
                            <h5>Views</h5>
                            <h4 class="h4 archivo mt-1">{{ ($user->ad->sum('views') >= 1000) ? number_format($user->ad->sum('views') / 1000, 1) . 'K' : $user->ad->sum('views') }}</h4>
                        </div>
                        <div>
                            <h5>Likes</h5>
                            <h4 class="h4 archivo mt-1">{{ ($totalLikes >= 1000) ? number_format($totalLikes/ 1000, 1) . 'K' : $totalLikes }}</h4>
                        </div>
                    </div>
                    @if(Auth::check() && $user->id == Auth::id())
                        <a class="btn btn-danger px-2 py-1  mt-3" href="{{ route('profile.edit') }}">Edit profile</a>
                    @endif
                </div>

            </div>
        </div>

        <div class="row ">
            <h1 class=" text-center h1 archivo brush px-2">My Ads</h1>
            @forelse ($vehicles as $vehicle)
                <div class="card mb-3 w-75 mx-auto p-0 mt-3 notHover">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img style="height: 200px;width:1000px" src="{{ Storage::url($vehicle->images[0]->image_url) }}"
                                class="img-fluid rounded-start object-fit-cover" alt="Card image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{$vehicle->company->company_name}}
                                    <span class="brush px-3 py-1">{{$vehicle->model->model_name}}</span>
                                    @if ($vehicle->available)
                                        <span
                                            class="badge rounded-pill text-bg-success bg-opacity-10 text-success">{{'Available' }}</span>
                                    @else
                                        <span
                                            class="badge rounded-pill text-bg-danger bg-opacity-10 text-danger">{{'Sold' }}</span>
                                    @endif

                                    <div
                                        class="bg-white position-absolute top-0 end-0  fw-bolder px-3 py-1 rounded-bottom-start shadow-sm">
                                        $ {{ number_format($vehicle->price) }}
                                    </div>
                                </h5>
                                <p class="card-text"><small class="text-muted">
                                        <i class="bi bi-heart-fill"></i> Likes:
                                        {{ $vehicle->ad->likes->count() }}</small></p>
                                <p class="card-text"><small class="text-muted">
                                        <i class="bi bi-eye-fill"></i> views:
                                        {{ $vehicle->ad->views}}</small></p>
                                <p class="card-text text-secondary">
                                    <small class="text-muted"><i class="bi bi-clock-fill"></i>
                                        {{date_format($vehicle->created_at, "d,M,Y")}}</small>
                                </p>
                                <p class="card-text"><small class="text-muted">Last updated
                                        {{date_format($vehicle->updated_at, "d,M,Y")}}</small></p>
                            </div>
                            <div class="card-footer d-flex justify-content-center align-items-center mb-0 d-flex gap-2">
                              @if(!$vehicle->ad->boosted)
                                <button data-id="{{ $vehicle->ad->id }}"  class="boostBtn btn btn-danger rounded-2 w-100 ">Boost <span><i class="bi bi-lightning-fill"></i></span></button>
                               @else
                                <button data-id="{{ $vehicle->ad->id }}"  class="boostBtn btn  fw-bolder text-danger rounded-2 w-100 ">Boosted <span> <i class="bi bi-lightning-fill"></i></span></button>

                                @endif
                                <div class="btn-group">
                                    

                                    <button type="button" class="btn   text-center py-0  " data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <span class="fs-3"><i class="bi bi-three-dots"></i></i></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                                      <form class="text-center"  action="{{ route('vehicle.edit', $vehicle) }}">
                                    @csrf

                                    <button class="btn text-primary mx-auto" type="submit">Edit <span><i class="bi bi-pencil"></i></span></button>
                                </form>
                                        @if($vehicle->available)
                                            <form class="text-center" action="{{ route('markSold', $vehicle->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="dropdown-item">Mark as <span
                                                        class="badge text-bg-danger text-danger bg-opacity-10 fw-bolder rounded-pill">sold</span></button>
                                            </form>
                                        @else
                                            <form class="text-center" action="{{ route('markAvailable', $vehicle->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="dropdown-item">Mark as <span
                                                        class="badge text-bg-success text-success bg-opacity-10 fw-bolder rounded-pill">available</span></button>
                                            </form>

                                        @endif

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li class="nav-item text-center">
                                            <form action="{{ route('vehicle.destroy', $vehicle) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn text-danger" type="submit">Delete<span class="ms-2"><i
                                                            class="bi bi-trash-fill"></i>
                                                    </span></button>

                                            </form>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="container-fluid d-flex justify-content-center mt-5  ">
                    <img class="img-responsive w-50 mix-blend-multiply" src="/images/noAds.png" alt="no ads">
                </div>


            @endforelse
        </div>
    </div>
   
 
 
        
 


</x-app-layout>