<x-app-layout>

    <button id="glass-button" class="glass-button px-4 py-1 rounded-pill text-dark"><i
            class="bi bi-arrow-up-circle-fill"></i></button>
   <div class="container-fluid pt-4 d-flex gap-2 p-1 bg-transparent">
        <form class="d-flex justify-content-center form-control bg-transparent" method="GET"
            action="{{ route('company.show') }}">
            <input id="search" name="company_name" type="text" class="form-control w-100 " required
                placeholder="search for any car">
            <button type="submit" class=" text-dark px-2 fs-3"> <i class="bi bi-search"></i></button>

        </form>
    </div>
    <div style="display: none;height:100px;" class="bg-white  shadow z-1 overflow-y-auto px-3  " id="suggestions">
    </div>
     <div class="container mt-1 px-2 py-2">
        <form class="d-flex gap-2 flex-wrap justify-content-center" action="{{ route("filteredSearch") }}"
            method="POST">
            @csrf
            <select class="rounded-pill border-0" name="category_id" id="category">
                <option value="" disabled selected>select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach

            </select>
            <select class="opacity-50 text-primary fw-bolder rounded-pill border-0 " name="company_id" id="company"
                disabled autocomplete="off">
                <option value="" disabled selected>select company</option>
            </select>
            <select class="opacity-50 text-primary rounded-pill fw-bolder border-0" name="model_id" id="model">
                <option value="" disabled selected>select model</option>
            </select>
            <button type="submit" class="btn btn-primary    px-3 py-0  text-white rounded-pill fw-bold">search</button>
        </form>

    </div>
    <hr>
    <h3
        class=" h3 text-center bg-info bg-opacity-25 fw-bolder text-sm fw-bolder px-4 py-2 mt-2 mx-2 rounded-3">
        <span class="archivo">
         
        </span> {{"(". number_format(count($vehicles)) . " " . "results)"}}
    </h3>

  
    <div id="body" class="container-fluid mt-3">
        <div class="row">

            @forelse($vehicles as $vehicle)
                <div class="col-md-3 mt-5">
                    <a class="" href="{{ route('vehicle.show', $vehicle) }}">
                          <div class="card shadow ">

                        <div class="position-relative d-inline-block">
                             @if(!$vehicle->available)
                             <img class="position-absolute top-100 start-50 translate-middle z-1" src="/images/sold.png" alt="sold">
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
                                    class="fw-bolder  rounded-3 brush  bg-warning bg-opacity-25 px-4  py-1">{{$vehicle->model->model_name}}</span>
                            </h3>
                            <div class="d-flex flex-wrap gap-2 mt-3 ">
                                <span class="bg-success bg-opacity-10 fw-bolder rounded-pill text-success px-2"><i
                                        class="bi bi-calendar3"></i> {{$vehicle->year}}</span>
                                <span
                                    style="background-color:{{ ($vehicle->color->color == 'white') ? 'silver' : $vehicle->color->color }};"
                                    class=" text-white bg-opacity-25 fs-6 fw-bolder rounded-pill px-2">
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
                                    <small class="fw-bolder">{{ $vehicle->user->name }}
                                        @if($vehicle->user->premium) <span class="text-primary"><i
                                                class="bi bi-patch-check-fill"></i></span>
                                                 @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer  bg-white p-2 mt-1">
                            @if($vehicle->available)
                           
                              <div class="d-flex gap-2 ">
                                    <div class="w-75">
                                    <a name="viewMore" id="viewBtn" data-id="{{$vehicle->ad->id}}" href="{{ route('vehicle.show', $vehicle) }}"
                                        class="btn bg-black fw-bolder text-white w-100">view more <i
                                            class="bi bi-arrow-right-circle-fill"></i></a>
                                             </div>
                                             
                            <div id="likeContainer" class=" px-2 py-1">
                                        <button data-id="{{ $vehicle->ad?->id }}" data-bs-toggle="tooltip" title="{{(!Auth::check()) ? 'log in required' : '' }}" class="fs-5 px-2 likeBtn"><i id="like-icon-{{ $vehicle->ad?->id }}"
                                                class=" {{(Auth::check() && $vehicle->ad->isLikedBy(Auth::user())) ? 'bi bi-heart-fill text-danger' :'bi bi-heart' }}"></i>

                                           <small id="like-count-{{ $vehicle->ad?->id }}">{{ $vehicle->ad?->likes->count() }}</small>
                                        </button>
                                       
                                    </div>
                                
                                   
                                </div>
                                 
                            @else
                                <h4 class=" mb-0 bg-danger bg-opacity-25 text-danger h4 archivo text-center py-1">Sold</h4>
                            @endif
                        </div>
                    </div>
                    </a>
                </div>
            @empty
                <div class="text-center mb-2">
                    <img class="w-50 mx-auto  mb-3 mix-blend-multiply" src="/images/noResults.png">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-danger rounded-pill px-4">Go back</a>
                </div>
            @endforelse
        </div>


    </div>

</x-app-layout>