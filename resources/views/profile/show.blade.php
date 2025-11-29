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

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <div class="p-2 text-center">
                    <div class="container d-flex justify-content-center mt-2 position-relative" >
                       @if($user->premium)
                        <img class="postion-absolute  z-1" style="width: 110px;height:110px;top:0;left:0;" src="/images/frame.png" alt="premium user">
                     @endif
                        @if($user->image !='public/images/avatar.png')
                            <img src="{{ Storage::url($user->image)}}" alt="user-image"
                                style="width:100px; height:100px; object-fit:cover;top:5px;" class="rounded-circle  @if($user->premium) position-absolute @endif  "
                                loading="lazy">
                        @else
                            <img src="/images/avatar.jpg" style="width:100px; height:100px; object-fit:cover;top:5px"
                                class="rounded-circle @if($user->premium) position-absolute @endif " loading="lazy">
                        @endif
                    </div>
                    <h3 class="  h3 mt-3">{{$user->name}}
                        @if($user->premium) <span class="text-primary"><i
                                                class="bi bi-patch-check-fill"></i></span>
                                                 @endif
                    </h3>
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
                     @if($user->bio)
                    <div class="text-center mt-2 py-2">
                        {{ $user->bio }}

                    </div>
                    @endif
                    @if(Auth::check() && $user->id == Auth::id())
                        <a class=" underline text-danger" href="{{ route('profile.edit') }}">Edit profile</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row ">
            <h1 class=" text-center h1 archivo redBrush text-light px-2"> Ads</h1>
              <small class="text-primary mt-2">Page {{ $vehicles->currentPage() }} of {{ $vehicles->lastPage() }}</small>
                       @forelse($vehicles as $vehicle)
                <div class="col-md-3 mt-5">
                    <a class="viewBtn" data-id="{{ $vehicle->ad->id }}" href="{{ route('vehicle.show', $vehicle) }}">
                         <div class="card shadow ">

                        <div class="position-relative d-inline-block">
                             @if(!$vehicle->available)
                             <img class="position-absolute top-100 start-50 translate-middle" src="/images/sold.png" alt="sold">
                            @endif
                            <img src="{{ Storage::url($vehicle->images[0]->image_url) }}" loading="lazy"
                                class="img-fluid rounded object-fit-cover" style="height: 250px;width:1000px"
                                alt="Vehicle Image">
                            <div
                                class="glass-price position-absolute top-0 end-0  text-white fw-bolder px-3 py-1 rounded-bottom-start shadow-sm">
                                $ {{ number_format($vehicle->price) }}
                            </div>
                            @if($vehicle->ad?->boosted)
                            <div
                                class=" position-absolute top-0 start-0  text-white fw-bolder px-3 py-1 rounded-bottom-start ">
                               <img src="/images/crown.png" alt="">
                            </div>
                            @endif
                        </div>

                        <div class="card-body  px-2">
                            <h3 class="card-title  fw-bolder bg-opacity-25  py-1">
                                {{$vehicle->company->company_name}} <span
                                    class="fw-bolder  rounded-3 brush  bg-warning bg-opacity-25 px-4  py-1">{{$vehicle?->model?->model_name}}</span>
                            </h3>
                              @if($vehicle->title)
                             <h3 class="card-title   py-1">
                               {{ $vehicle->title }}
                            </h3>
                            @endif
                            <div class="d-flex flex-wrap gap-2 mt-3 ">
                                <span class="bg-success bg-opacity-10 fw-bolder rounded-pill text-success px-2"><i
                                        class="bi bi-calendar3"></i> {{$vehicle->year}}</span>
                                 <span
                                    style="background-color:{{ ($vehicle->color->color == 'black') ? 'black'.';'. 'color:white' : $vehicle->color->color }};"
                                    class="bg-opacity-25 fs-6 fw-bolder rounded-pill px-2">
                                    <i class=" bi bi-droplet-fill"></i> {{$vehicle->color->color}}</span>

                                <span class="text-sm bg-secondary bg-opacity-25 fs-6 fw-bolder rounded-pill px-2"> <i
                                        class="fa-solid fa-gears"></i> {{$vehicle->gearbox->gearbox_type}}</span>
                                <span class="bg-info bg-opacity-25  fw-bolder rounded-pill px-2"><i
                                        class="fa-solid fa-gauge-high"></i> {{$vehicle->mileage}} KM</span>

                            </div>
                            <hr class="mt-2 ">
                            <div class="text-sm mt-2 bg-info bg-opacity-10 px-2  rounded-3" style="height: 80px">
                                <pre
                                    class="font-semibold font-sans">{{ Str::words(wordwrap($vehicle->description, 30, "\n"), 8)}}</pre>
                            </div>


                            <div class="text-end mt-2 bg-primary bg-opacity-10 rounded-3 px-2">
                                <i class="bi bi-geo-alt-fill"></i>
                                <small class="ms-1">{{ $vehicle->location }}</small><br>

                                <div class="d-inline-flex align-items-center justify-content-end mt-2">
                                    @if($vehicle->user->image != 'public/images/avatar.png')
                                        <img src="{{ Storage::url($vehicle->user->image)}}"
                                            style="width:25px; height:25px; object-fit:cover;" class="rounded-circle me-2"
                                            alt="user-image" loading="lazy">
                                    @else
                                        <img src="/images/avatar.jpg" style="width:25px; height:25px; object-fit:cover;" alt="user-image"
                                            class="rounded-circle me-2" loading="lazy">
                                    @endif
                                    <small class="fw-bolder">{{ $vehicle->user->name }}
                                          @if($user->premium) <span class="text-primary"><i
                                                class="bi bi-patch-check-fill"></i></span>
                                                 @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer  bg-white p-1 mt-1" >
                            @if($vehicle->available)
                           
                                <div class="d-flex justify-content-between ">
                                    <div class="w-75">
                                    <a  data-id="{{$vehicle->ad->id}}" name="viewMore" href="{{ route('vehicle.show', $vehicle) }}"
                                        class="btn bg-black fw-bolder text-white w-100 viewBtn">view more <i
                                            class="bi bi-arrow-right-circle-fill"></i></a>
                                             </div>
                                             
                            <div id="likeContainer" class="px-1 py-1">
                                        <button data-bs-toggle="tooltip"
                                            title="{{(!Auth::check()) ? 'login required' : '' }}" data-id="{{ $vehicle->ad?->id }}" class="fs-5 me-3 likeBtn"><i id="like-icon-{{ $vehicle->ad?->id }}"
                                                class=" {{(Auth::check() && $vehicle->ad?->isLikedBy(Auth::user())) ? 'bi bi-heart-fill text-danger' :'bi bi-heart' }}"></i>

                                           <small class="text-sm" id="like-count-{{ $vehicle->ad?->id }}">{{ ($vehicle->ad?->likes->count()>=1000) ? number_format($vehicle->ad?->likes->count()/1000,1).'K':$vehicle->ad?->likes->count() }}</small>
                                        </button>
                                       
                                    </div>
                                
                                   
                                </div>
                                 
                            @else
                                <h4 class=" mb-0  text-danger h4 archivo text-center py-1">Sold</h4>
                            @endif
                        </div>
                         <div class="px-2 mt-2"><small class="text-muted">{{ $vehicle->created_at->diffForHumans() }}</small></div>
                    </div>

                    </a>
                </div>
            @empty
                <div class="container-fluid d-flex justify-content-center mt-5">
                    <img class="img-responsive w-50 mix-blend-multiply" src="/images/noAds.png" alt="no ads">
                </div>

            @endforelse
             <div class="d-flex justify-content-center gap-2 mt-3 mb-0">
            <span>{{ $vehicles->links() }}</span>
        </div>


         
        </div>
    </div>

</x-app-layout>