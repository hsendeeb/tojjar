<x-app-layout>
     
    <button id="glass-button" class="glass-button px-4 py-1 rounded-pill text-dark"><i
            class="bi bi-arrow-up-circle-fill"></i></button>
    <div class="input-group container   bg-transparent mt-5">
       <form class="d-flex justify-content-center  gap-2 form-control bg-transparent" method="GET" action="{{ route('company.show') }}">
        <input id="search" name="company_name" type="text" class="form-control w-75  py-1 rounded-pill" placeholder="search for any car">
        <button type="submit" class="btn btn-danger px-3  text-white rounded-pill"> <i
                class="bi bi-search"></i></button>

 </form>
        <div style="display: none;height:100px;" class="bg-white w-100 z-1 overflow-y-auto px-3  " id="suggestions">
        </div>

    </div>

    <h1 class=" h1 text-center mt-5 archivo brush">{{"(".count($vehicles)." "."results)"}}</h1>
    <div id="body" class="container-fluid mt-3">
        <div class="row">
          
            @forelse($vehicles as $vehicle)
                <div class="col-md-3 mt-5">
                    <a class="" href="{{ route('vehicle.show', $vehicle) }}">
                        <div class="card shadow ">

                            <div class="position-relative d-inline-block">
                                <img src="{{ Storage::url($vehicle->images[0]->image_url) }}"
                                    class="img-fluid rounded object-fit-cover" style="height: 250px;width:1000px"
                                    alt="Vehicle Image">
                                <div
                                    class="glass-price position-absolute top-0 end-0  text-white fw-bolder px-3 py-1 rounded-bottom-start shadow-sm">
                                    $ {{ number_format($vehicle->price) }}
                                </div>
                            </div>

                            <div class="card-body">
                                <h3 class="card-title  fw-bolder bg-opacity-25  py-1">
                                    {{$vehicle->company->company_name}} <span
                                        class="fw-bolder  rounded-3 brush  bg-warning bg-opacity-25 px-4  py-1">{{$vehicle->model->model_name}}</span>
                                </h3>
                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    <span class="bg-warning bg-opacity-10 fw-bolder rounded-pill text-warning px-2"><i
                                            class="bi bi-calendar3"></i> {{$vehicle->year}}</span>
                                    <span
                                        style="background-color:{{ ($vehicle->color->color == 'white') ? 'silver' : $vehicle->color->color }};"
                                        class=" text-white bg-opacity-25 fs-6 fw-bolder rounded-pill px-2">
                                        <i class="bi bi-droplet-fill"></i> {{$vehicle->color->color}}</span>
                                    <span class="bg-secondary bg-opacity-25 fs-6 fw-bolder rounded-pill px-2"> <i
                                            class="fa-solid fa-gears"></i> {{$vehicle->gearbox->gearbox_type}}</span>
                                    <span class="bg-info bg-opacity-25 fw-bolder rounded-pill px-2"><i
                                            class="fa-solid fa-gauge-high"></i> {{$vehicle->mileage}} KM</span>

                                </div>
                               
                                <div class="text-sm mt-2">
                                    <pre>{{ Str::words(wordwrap($vehicle->description, 30, "\n"), 3)}}</pre>
                                </div>
                                


                                <div class="text-end mt-4">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <small class="ms-1">{{ $vehicle->location }}</small><br>

                                    <div class="d-inline-flex align-items-center justify-content-end mt-2">
                                       @if($vehicle->user->image !='public/images/avatar.jpg')
                                        <img src="{{ Storage::url($vehicle->user->image)}}"
                                            style="width:25px; height:25px; object-fit:cover;" class="rounded-circle me-2" alt="user image"
                                            loading="lazy">
                                            @else
                                             <img src="/images/avatar.jpg"
                                            style="width:25px; height:25px; object-fit:cover;" class="rounded-circle me-2"
                                            loading="lazy">
                                            @endif
                                        <small class="fw-bolder">{{ $vehicle->user->name }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class=" card-footer p-0 mb-0">
                                <a href="{{ route('vehicle.show', $vehicle) }}"
                                    class="btn bg-warning fw-bolder bg-opacity-75 w-100">view more <i
                                        class="bi bi-arrow-right-circle-fill"></i></a>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
            <div class="text-center mb-2">
                <img class="w-50 mx-auto  mb-3 mix-blend-multiply" src="/images/noResults.jpg">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-danger rounded-pill px-4">Go back</a>
           </div>
                @endforelse
        </div>

     
    </div>

</x-app-layout>