<x-app-layout>

    <button id="glass-button" class="glass-button px-4 py-1 rounded-pill text-dark"><i
            class="bi bi-arrow-up-circle-fill"></i></button>
   
    <div style="display: none;height:100px;" class="bg-white  shadow z-1 overflow-y-auto px-3  " id="suggestions">
    </div>
       <h1 class="h1 text-center archivo mt-3">Liked ads <span><i class="bi bi-bookmark-heart-fill"></i></span></h1>
    <h3 class="d-inline-block h3 text-center bg-danger bg-opacity-25 fw-bolder text-sm text-danger fw-bolder px-4 py-2 mt-2 ms-2 rounded-pill">{{ number_format( count($vehicles) )." " ."liked ads"}}</h3>
    <div id="body" class="container-fluid mt-3">
        <div class="row">

            @forelse($vehicles as $vehicle)
                <div class="col-md-3 mt-5">
                    <a class="" href="{{ route('vehicle.show', $vehicle) }}">
                        <div class="card shadow ">

                            <div class="position-relative d-inline-block">
                                @if(!$vehicle->available)
                                    <img class="position-absolute top-100 start-50 translate-middle" src="/images/sold.png"
                                        alt="sold">
                                @endif
                                <img src="{{ Storage::url($vehicle->images[0]->image_url) }}" loading="lazy"
                                    class="img-fluid rounded object-fit-cover" style="height: 250px;width:1000px"
                                    alt="Vehicle Image">
                                <div
                                    class="glass-price position-absolute top-0 end-0  text-white fw-bolder px-3 py-1 rounded-bottom-start shadow-sm">
                                    $ {{ number_format($vehicle->price) }}
                                </div>
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

                                    <div class="d-flex ">
                                        <div class="w-100">
                                            <a name="viewMore" href="{{ route('vehicle.show', $vehicle) }}"
                                                class="btn bg-black fw-bolder text-white w-100">view more <i
                                                    class="bi bi-arrow-right-circle-fill"></i></a>
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
                    <img class="w-50 mx-auto  mb-3 mix-blend-multiply" src="/images/noLikes.png">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-danger rounded-pill px-4">Go back</a>
                </div>
            @endforelse
        </div>


    </div>

</x-app-layout>