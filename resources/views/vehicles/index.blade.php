<x-app-layout>
 
    <div id="loader-wrapper">
        <div class="spinner"></div>
    </div>


    <button id="glass-button" class="glass-button px-4 py-1 rounded-pill text-dark"><i
            class="bi bi-arrow-up-circle-fill"></i></button>
   <div class="py-3" id="searchBar" >
    <div class="container-fluid  d-flex gap-2 p-1 bg-transparent  ">
        <form class="d-flex gap-2 justify-content-center form-control border-0 bg-transparent" method="GET"
            action="{{ route('company.show') }}">
            <input  id="search" name="company_name" type="text" class="form-control opacity-50 " required
                placeholder="search for any car">
            <button type="submit" class="px-2 fs-3"> <i class="bi bi-search"></i></button>

        </form>
        
    </div>
     <div style="display: none;height:100px;" class="bg-white  shadow z-1 overflow-y-auto px-3" id="suggestions">
    </div>
   

    <div id="alert" class="container d-flex justify-content-center">
        @if(session("notFound"))
            <small class="alert alert-danger py-1 px-4 bg-opacity-10 text-danger rounded-3">
                {{ session('notFound') }}
            </small>
        @endif
    </div>


    <div class="container mt-3 px-2">
        <form class="d-flex gap-1 flex-wrap justify-content-center" action="{{ route("filteredSearch") }}"
            method="POST">
            @csrf
            <select class="rounded-pill border-0 " name="category_id" id="category">
                <option value="" disabled selected>select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach

            </select>
            <select class="opacity-50  fw-bolder rounded-pill border-0 " name="company_id" id="company"
                disabled autocomplete="off">
                <option value="" disabled selected>select company</option>
            </select>
            <select class="opacity-50 text-primary rounded-pill fw-bolder border-0" name="model_id" id="model">
                <option value="" disabled selected>select model</option>
            </select>
            <button type="submit" class="btn btn-primary    px-3 py-0  text-white rounded-pill fw-bold">search</button>
        </form>

    </div>
    </div>
    <h3 class="px-2 mt-3 fw-bold">Dealers</h3>
    <div class="d-flex justify-content-end px-2">
        <a class="btn text-danger px-1 py-0" href="{{ route('dealers.index') }}">see all <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="d-flex flex-nowrap  gap-4  overflow-x-auto  mt-3 py-3 px-3">

        @forelse ($dealers as $dealer)
             
    <div class="d-flex flex-column align-items-center" style="min-width: 70px;">
        <a class="text-center" id="dealer" href="{{ route('profile.show',$dealer->user->id) }}">
                        @if($dealer->user->image != 'public/images/avatar.png')
                        <div class="rounded-circle overflow-hidden" style="width:70px; height:70px;">
                            <img class="w-100 h-100 object-fit-cover"
                                src="{{ Storage::url($dealer->user->image)}}" alt=" logo">
                        </div>
                    @else
                        <div class="rounded-circle overflow-hidden" style="width:70px; height:70px;">
                            <img class="w-100 h-100 object-fit-cover" 
                                src="/images/avatar.jpg" alt=" logo">
                        </div>
                    @endif
                    <small class="text-nowrap mt-2 text-center">{{ $dealer->user->username }} 
                         @if($dealer->user->premium) <span class="text-primary"><i
                                                class="bi bi-patch-check-fill"></i></span>
                                                 @endif
                    </small>
                   </div> 
                   </a>

            
                
        


        @empty
            <p class="text-center text-muted">No dealers</p>

        @endforelse


    </div>
    <div class="d-flex flex-wrap gap-5 mt-5 justify-content-center align-items-center">
        <div onclick="document.getElementById('car').submit()" class="d-flex flex-column text-center cursor-pointer">
            <img src="/images/car.png"  class="mix-blend-multiply" style="max-width:150px" alt="car">
   <form id="car" action="/vehicles/filter/car" method="POST">
              @csrf
                <button type="submit">car</button>

              </form>
        </div>
        <div onclick="document.getElementById('truck').submit()" class="d-flex flex-column text-center cursor-pointer">
            <img src="/images/truck.png" class="mix-blend-multiply" style="max-width:150px" alt="car">
   <form id="truck" action="/vehicles/filter/trucks" method="POST">
              @csrf
                <button  type="submit">Trucks</button>

              </form>
        </div>
         <div onclick="document.getElementById('moto').submit()" class="d-flex flex-column text-center cursor-pointer">
            <img src="/images/moto.png" class="mix-blend-multiply" style="max-width:150px" alt="car">
   <form id="moto" action="/vehicles/filter/motorcycles" method="POST">
              @csrf
                <button type="submit">Motorcycles</button>

              </form>
        </div>
         <div onclick="document.getElementById('van').submit()" class="d-flex flex-column text-center cursor-pointer">
            <img src="/images/Van.png" class="mix-blend-multiply" style="max-width:150px" alt="car">
   <form id="van" action="/vehicles/filter/Van" method="POST">
              @csrf
                <button type="submit">Van</button>

              </form>
        </div>
    </div>

    <h1 id="featured" class="h1 text-center mt-5 archivo brush">Featured cars <i class="bi bi-award-fill"></i></h1>
    <div id="body" class="container mt-3">
        <div class="row">
            
            @forelse($paginatedVehicles as $vehicle)
                <div class="col-lg-4 mt-5">
                   <a href="{{ route('vehicle.show',$vehicle) }}">
                    <div class="card shadow ">

                        <div class="position-relative d-inline-block">
                            @if(!$vehicle->available)
                                <img class="position-absolute top-100 start-50 translate-middle z-1" src="/images/sold.png"
                                    alt="sold">
                            @endif
                            <div id="vehicleCarousel-{{ $vehicle->id }}" class="carousel slide" data-bs-ride="false">
                                @if($vehicle->images->count() > 0)
                                    <div class="carousel-indicators">
                                        @foreach($vehicle->images as $i => $img)
                                            <button type="button"
                                                data-bs-target="#vehicleCarousel-{{ $vehicle->id }}"
                                                data-bs-slide-to="{{ $i }}"
                                                class="{{ $i === 0 ? 'active' : '' }}"
                                                {{ $i === 0 ? 'aria-current="true"' : '' }}
                                                aria-label="Slide {{ $i + 1 }}"></button>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="carousel-inner  rounded-3">
                                    @foreach($vehicle->images as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img style="height:300px;width:1000px; cursor: pointer;"
                                                class=" rounded-3 object-fit-cover"
                                                data-bs-toggle="modal" src="{{ asset('storage/' . $image->image_url) }}"
                                                alt="Vehicle Image {{ $index + 1 }}">
                                        </div>


                                    @endforeach
                                </div>
                                <button class="carousel-control-prev " type="button"
                                    data-bs-target="#vehicleCarousel-{{ $vehicle->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#vehicleCarousel-{{ $vehicle->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon text-black" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <div
                                class="glass-price position-absolute top-0 end-0  text-white fw-bolder px-3 py-1 rounded-bottom-start shadow-sm">
                                $ {{ number_format($vehicle->price) }}
                            </div>
                            @if($vehicle->ad->boosted)
                            <div
                                class=" position-absolute top-0 start-0  text-white fw-bolder px-3 py-1 rounded-bottom-start ">
                               <img src="/images/crown.png" alt="">
                            </div>
                            @endif
                        </div>

                        <div class="card-body  px-2">
                            <h3 class="card-title  fw-bolder bg-opacity-25  py-1">
                                {{$vehicle->company->company_name}} <span
                                    class="fw-bolder  rounded-3 brush  bg-warning bg-opacity-25 px-4  py-1">{{$vehicle->model->model_name}}</span>
                            </h3>
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


                            <div class="text-end mt-2 bg-warning bg-opacity-10 rounded-3 px-2">
                                <i class="bi bi-geo-alt-fill"></i>
                                <small class="ms-1">{{ $vehicle->location }}</small><br>

                                <div class="d-inline-flex align-items-center justify-content-end mt-2">
                                    @if($vehicle->user->image != 'public/images/avatar.png')
                                        <img src="{{ Storage::url($vehicle->user->image)}}"
                                            style="width:25px; height:25px; object-fit:cover;" class="rounded-circle me-2"
                                            alt="user image" loading="lazy">
                                    @else
                                        <img src="/images/avatar.jpg" style="width:25px; height:25px; object-fit:cover;"
                                            class="rounded-circle me-2" loading="lazy">
                                    @endif
                                    <small class="fw-bolder">{{ $vehicle->user->username }}
                                         @if($vehicle->user->premium) <span class="text-primary"><i
                                                class="bi bi-patch-check-fill"></i></span>
                                                 @endif
                                            </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer  bg-white p-1 mt-1">
                            @if($vehicle->available)

                                <div class="d-flex gap-2 ">
                                    <div class="w-75">
                                        <a id="viewBtn" data-id="{{ $vehicle->ad->id }}" name="viewMore"
                                            href="{{ route('vehicle.show', $vehicle) }}"
                                            class="btn bg-black fw-bolder text-white w-100">view more <i
                                                class="bi bi-arrow-right-circle-fill"></i></a>
                                    </div>

                                    <div id="likeContainer" class=" px-2 py-1">
                                        <button data-bs-toggle="tooltip" title="{{(!Auth::check()) ? 'log in required' : '' }}"
                                            data-id="{{ $vehicle->ad?->id }}" class="fs-5 px-2 likeBtn"><i
                                                id="like-icon-{{ $vehicle->ad?->id }}"
                                                class=" {{(Auth::check() &&  $vehicle->ad?->isCurrentUserLike()) ? 'bi bi-heart-fill text-danger' : 'bi bi-heart' }}"></i>

                                            <small
                                                id="like-count-{{ $vehicle->ad?->id }}">{{ ($vehicle->ad?->likes->count() >= 1000) ? number_format($vehicle->ad?->likes->count() / 1000, 1) . 'K' : $vehicle->ad?->likes->count() }}</small>
                                        </button>


                                    </div>


                                </div>

                            @else
                                <h4 class=" mb-0 bg-danger bg-opacity-10 text-danger h4 archivo text-center">Sold</h4>

                            @endif
                        </div>
                    </div>
                    </a>

                </div>
            @empty
                <h2 class="text-center">No results</h2>
            @endforelse
        </div>

        <div class="d-flex justify-content-center gap-2 mt-3 mb-3">
            <span>{{ $paginatedVehicles->links('pagination::bootstrap-5') }}</span>
        </div>
    </div>

</x-app-layout>