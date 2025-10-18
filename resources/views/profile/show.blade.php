<x-app-layout>
    <button id="glass-button" class="glass-button px-4 py-1 rounded-pill text-dark"><i
            class="bi bi-arrow-up-circle-fill"></i></button>
    @if (session('message'))
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    @endif

    <div class="container-fluid ">
        <div class="row">
            <div class="col-12">
                <div class="p-5 text-center">
                    <div class="container d-flex justify-content-center">
                     
                        @if($user->image !='public/images/avatar.jpg')
                            <img src="{{ Storage::url($user->image)}}"
                                style="width:100px; height:100px; object-fit:cover;" class="rounded-circle me-2"
                                loading="lazy">
                        @else
                            <img src="/images/avatar.jpg" style="width:100px; height:100px; object-fit:cover;"
                                class="rounded-circle me-2" loading="lazy">
                        @endif
                    </div>
                    <h3 class="  h3 mt-3 archivo">{{$user->name}}</h3>
                    @if(Auth::check() && $user->id == Auth::id())
                        <a class=" underline text-danger" href="{{ route('profile.edit') }}">Edit profile</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row ">
            <h1 class=" text-center h1 archivo brush px-2"> Ads ({{ count($vehicles) }})</h1>
                       @forelse($vehicles as $vehicle)
                <div class="col-md-3 mt-5">
                    <a class="" href="{{ route('vehicle.show', $vehicle) }}">
                        <div class="card shadow ">

                            <div class="position-relative d-inline-block">
                                <img src="{{ Storage::url($vehicle->image[0]->image_url) }}" loading="lazy"
                                    class="img-fluid rounded object-fit-cover" style="height: 250px;width:1000px"
                                    alt="Vehicle Image">
                                <div
                                    class="glass-price position-absolute top-0 end-0  text-white fw-bolder px-3 py-1 rounded-bottom-start shadow-sm">
                                    $ {{ number_format($vehicle->price) }}
                                </div>
                            </div>

                            <div class="card-body  py-2 px-2">
                                <h3 class="card-title  fw-bolder bg-opacity-25  py-1">
                                    {{$vehicle->company->company_name}} <span
                                        class="fw-bolder  rounded-3 brush  bg-warning bg-opacity-25 px-4  py-1">{{$vehicle->model->model_name}}</span>
                                </h3>
                                <div class="d-flex flex-wrap gap-2 mt-1">
                                    <span class="bg-warning bg-opacity-10 fw-bolder rounded-pill text-warning px-2"><i
                                            class="bi bi-calendar3"></i> {{$vehicle->year}}</span>
                                    <span
                                        style="background-color:{{ ($vehicle->color->color == 'white') ? 'silver' : $vehicle->color->color }};"
                                        class=" text-white bg-opacity-25 fs-6 fw-bolder rounded-pill px-2">
                                        <i class=" bi bi-droplet-fill"></i> {{$vehicle->color->color}}</span>
                                    <span class=" bg-secondary bg-opacity-25 fs-6 fw-bolder rounded-pill px-2"> <i
                                            class="fa-solid fa-car-side"></i> {{$vehicle->body->body_type}}</span>
                                    <span class=" bg-secondary bg-opacity-25 fs-6 fw-bolder rounded-pill px-2"> <i
                                            class="fa-solid fa-gears"></i> {{$vehicle->gearbox->gearbox_type}}</span>
                                    <span class="bg-info bg-opacity-25  fw-bolder rounded-pill px-2"><i
                                            class="fa-solid fa-gauge-high"></i> {{$vehicle->mileage}} KM</span>

                                </div>
                                <hr class="mt-2 ">
                                <div class="text-sm mt-2">
                                    <pre>{{ Str::words(wordwrap($vehicle->description, 30, "\n"), 3)}}</pre>
                                </div>


                                <div class="text-end p-2">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <small class="ms-1">{{ $vehicle->location }}</small><br>

                                    <div class="d-inline-flex align-items-center justify-content-end mt-1">
                                       @if($vehicle->user->image !='public/images/avatar.jpg')
                                        <img src="{{ Storage::url($vehicle->user->image)}}"
                                            style="width:25px; height:25px; object-fit:cover;" class="rounded-circle me-2"
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
                <div class="container-fluid d-flex justify-content-center">
                    <img class="img-responsive w-25" src="/images/NoAds.png" alt="">
                </div>

            @endforelse


         
        </div>
    </div>

</x-app-layout>