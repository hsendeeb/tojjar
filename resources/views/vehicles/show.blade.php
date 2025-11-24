<x-app-layout>
    <div class="container pt-6 ">
        <div class="row ">
            <div class="col-lg-6">
                <div id="vehicleCarousel" class="carousel slide" data-bs-ride="carousel">
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
                    <div class="carousel-inner  rounded-3">
                        @foreach($vehicle->images as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img style="height: 300px;width:1000px;cursor: pointer;" class="rounded-3 object-fit-cover"
                                    data-bs-toggle="modal" data-bs-target="#vehicleModal"
                                    src="{{ asset('storage/' . $image->image_url) }}"
                                    alt="Vehicle Image {{ $index + 1 }}">
                            </div>
                         

                        @endforeach
                    </div>
                    <button class="carousel-control-prev " type="button" data-bs-target="#vehicleCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#vehicleCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon text-black" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="thumbnail-scroll d-flex flex-nowrap overflow-auto gap-2 py-2">

                    @foreach($vehicle->images as $index => $image)
                        <img src="{{ asset('storage/' . $image->image_url) }}" class="img-thumbnail object-fit-cover"
                            style="width: 80px; height: 60px; cursor: pointer;" data-bs-target="#vehicleCarousel"
                            data-bs-slide-to="{{ $index }}" aria-label="Slide {{ $index + 1 }}" aria-current="true">
                    @endforeach
                </div>


            </div>
            <div class="col-lg-6 mt-4">
                <div class="d-flex gap-3 flex-wrap">

                    <h1 class="h1 text-start archivo">
                        {{$vehicle->company->company_name . " " . $vehicle->year . " " . $vehicle?->model?->model_name }}
                    </h1>
                    <h1 class=" h1  text-end archivo text-danger"> ${{number_format($vehicle->price)}}</h1>
                </div>
                <div class="mt-2">
                    @if($vehicle->available)
                        <span
                            class="fs-6 badge rounded-pill text-bg-success text-success fw-bolder bg-opacity-10">Available</span>
                    @else
                        <span class="fs-6 badge rounded-pill text-bg-danger text-danger fw-bolder bg-opacity-10">Sold</span>
                    @endif
                     @if($vehicle->ad?->boosted)
                        <span
                            class="fs-6 badge bg-warning rounded-pill text-dark fw-bolder bg-opacity-75 ">featured <i class="bi bi-award-fill"></i></span>
                    @endif
                    
                </div>
                <div class="container-fluid mt-2">
                    <table class="table table-striped">
                        <tr>
                            <td><i class="fa-solid fa-gauge-high"></i> <span class="fw-bold">Odometer :</span>
                                {{$vehicle->mileage}} Km</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-calendar-fill"></i> <span class="fw-bold">Year:</span>
                                {{$vehicle->year}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-gears"></i> <span class="fw-bold"> transmission :
                                </span>{{$vehicle->gearbox->gearbox_type}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-car-side"></i><span class="fw-bold"> Body type :</span>
                                {{$vehicle->body->body_type}}</td>
                        </tr>
                        <tr>
                            <td class="d-flex"><img class="me-1" style="width: 20px;height:20px"
                                    src="/images/pistons.png" alt=""> <span class="fw-bold">Engine cylinders: </span>
                                {{$vehicle?->engineType?->type}}</td>
                        </tr>
                        <tr>
                            <td class="d-flex"><img class="me-1" style="width: 20px;height:20px"
                                    src="/images/car-engine.png" alt=""><span class="fw-bold">Engine size: </span>
                                {{$vehicle?->engineSize?->size}}</td>
                        </tr>
                        <tr>
                            <td
                                style="color:{{ ($vehicle->color->color == 'white') ? 'black' : $vehicle->color->color}}">
                                <i class="bi bi-droplet-fill"></i> <span class="fw-bold">Color :</span>
                                {{$vehicle->color->color}}
                            </td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-fuel-pump-fill"></i> <span class="fw-bold">Fuel : </span>
                                {{$vehicle->fuel->fuel_type}}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-wrench-adjustable"></i> <span class="fw-bold">Condition : </span>
                                {{$vehicle?->condition?->condition}}</td>
                        </tr>
                        <tr>
                            <td class="bg-primary bg-opacity-10"><i class="bi bi-geo-alt-fill"></i> <span
                                    class="fw-bold">Location : </span>
                                {{$vehicle->location}}</td>
                        </tr>

                    </table>

                </div>
            </div>
        </div>

    </div>
    <div class="container-fluid  bg-white rounded-3 p-4">
        <h4 class="h4 archivo">Description</h4>
        <div>
            <pre class="font-sans">{{ wordwrap($vehicle->description, 30, "\n")}}</pre>
        </div>
    </div>
    <div class="mt-2">
        <p class="text-secondary text-center">posted on : {{ date_format($vehicle->created_at, 'd/m/Y')}}</p>
    </div>
    <div class="d-flex gap-3 mt-3 justify-content-center">
        <a href="tel:{{ $vehicle->user->phone }}" class="btn btn-danger px-3"><i class="bi bi-telephone-fill "></i>
            {{$vehicle->user->phone}}</a>
        <a href="https://wa.me/{{ $vehicle->user->phone }}" class="btn btn-outline-success px-3"><i
                class="bi bi-whatsapp"></i> Whatsapp</a>
    </div>

    <div class="container-fluid  mt-3">
        <div class="row p-2">

            <div class="col-lg-6 mt-2  ">
                <h6 class="h6 archivo">Posted by :</h6>
                <a href="{{ route('profile.show', $vehicle->user->id) }}">

                    <div class="d-flex align-items-center">

                        @if($vehicle->user->image != 'public/images/avatar.png')
                            <img src="{{ Storage::url($vehicle->user->image)}}"
                                style="width:60px; height:60px; object-fit:cover;" class="rounded-circle me-2"
                                loading="lazy">
                        @else
                            <img src="/images/avatar.jpg" style="width:60px; height:60px; object-fit:cover;"
                                class="rounded-circle me-2" loading="lazy">
                        @endif

                        <div>
                            <p class="archivo">{{$vehicle->user->name}}
                                @if($vehicle->user->premium) <span class="text-primary"><i
                                                class="bi bi-patch-check-fill"></i></span>
                                                 @endif
                                                </p>
                            <small><i class="bi bi-clock-fill"></i> joined at: {{date_format( $vehicle->user->created_at,'M,Y') }}</small>
                           <p><a class=" rounded-pill fw-bolder" href="{{ route('profile.show',$vehicle->user->id) }}">view profile <i class="bi bi-arrow-right-short"></i></a></p>
                        </div>

                    </div>
                </a>


            </div>
        </div>
    </div>

   <div class="modal fade bg-dark " id="vehicleModal" tabindex="-1"
                                aria-labelledby="imageModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class=" modal-dialog modal-fullscreen-md-down   modal-dialog-centered" >
                                    <div class="modal-content bg-transparent border-0">
                                        <div class="modal-header border-0">
                                            <button type="button" class="btn-close btn-close-white ms-auto"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                             <div id="vehicleCarouselModal" class="carousel slide w-100" data-bs-ride="carousel">
                     <div class="carousel-indicators">
                                        @foreach($vehicle->images as $i => $img)
                                            <button type="button"
                                                data-bs-target="#vehicleCarouselModal-{{ $vehicle->id }}"
                                                data-bs-slide-to="{{ $i }}"
                                                class="{{ $i === 0 ? 'active' : '' }}"
                                                {{ $i === 0 ? 'aria-current="true"' : '' }}
                                                aria-label="Slide {{ $i + 1 }}"></button>
                                        @endforeach
                                    </div>
                    <div class="carousel-inner  rounded-3">
                        @foreach($vehicle->images as $index => $image)
                            <div class=" carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img style="height: 400px;width:1000px;cursor: pointer;" class="rounded-3 object-fit-cover"
                
                                    src="{{ asset('storage/' . $image->image_url) }}"
                                    alt="Vehicle Image {{ $index + 1 }}">
                            </div>
                         

                        @endforeach
                    </div>
                    <button class="carousel-control-prev " type="button" data-bs-target="#vehicleCarouselModal"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#vehicleCarouselModal"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon text-black" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="thumbnail-scroll  d-flex flex-nowrap overflow-auto gap-2 py-2">

                    @foreach($vehicle->images as $index => $image)
                        <img src="{{ asset('storage/' . $image->image_url) }}" class="img-thumbnail object-fit-cover"
                            style="width: 80px; height: 60px; cursor: pointer;" data-bs-target="#vehicleCarouselModal"
                            data-bs-slide-to="{{ $index }}" aria-label="Slide {{ $index + 1 }}" aria-current="true">
                    @endforeach
                </div>                                            
                                                
                                        </div>
                                    </div>
                                </div>
                            </div>


</x-app-layout>