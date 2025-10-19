<x-app-layout>
    <button id="glass-button" class="glass-button px-4 py-1 rounded-pill text-dark"><i
            class="bi bi-arrow-up-circle-fill"></i></button>

        <div class="input-group d-flex gap-2 p-1 bg-transparent mt-5">
        <form class="d-flex justify-content-center  gap-2 form-control bg-transparent" method="GET"
            action="{{ route('company.show') }}">
            <input id="search" name="company_name" type="text" class="form-control w-75  py-1 rounded-pill" required
                placeholder="search for any car">
            <button type="submit" class="btn btn-danger px-3  text-white rounded-pill"> <i
                    class="bi bi-search"></i></button>
            
        </form>


        <div style="display: none;height:100px;" class="bg-white w-100 z-1 overflow-y-auto px-3  " id="suggestions">
        </div>

    </div>
    <div>

    </div>
    <div id="alert" class="container d-flex justify-content-center">
        @if(session("notFound"))
            <small class="alert alert-danger py-1 px-4 bg-opacity-10 text-danger rounded-3">
                {{ session('notFound') }}
            </small>
        @endif
    </div>
    <h4 class=" h4 text-center font-sans">or</h4>

    <div class="container mt-3 px-2">
        <form class="d-flex gap-2 flex-wrap justify-content-center" action="{{ route("filteredSearch") }}"
            method="POST">
            @csrf
            <select class="rounded-pill border-0" name="category_id" id="category">
                <option value="" disabled selected>select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach

            </select>
            <select class="opacity-50 text-primary fw-bolder rounded-pill border-0 " name="company_id" id="company" disabled>
                <option value="" disabled selected>select company</option>
            </select>
            <select class="opacity-50 text-primary rounded-pill fw-bolder border-0" name="model_id" id="model">
                <option value="" disabled selected>select model</option>
            </select>
            <button type="submit" class="btn btn-primary    px-3 py-0  text-white rounded-pill fw-bold">search</button>
        </form>

    </div>

    <h1 class="h1 text-center mt-5 archivo brush">Featured cars</h1>
    <div id="body" class="container-fluid mt-3">
        <div class="row">
            @forelse($paginatedVehicles as $vehicle)
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

                            <div class="card-body  px-2"  >
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
                                        <i class=" bi bi-droplet-fill"></i> {{$vehicle->color->color}}</span>
                                    <span class=" bg-secondary bg-opacity-25 fs-6 fw-bolder rounded-pill px-2"> <i
                                            class="fa-solid fa-car-side"></i> {{$vehicle->body->body_type}}</span>
                                    <span class="text-sm bg-secondary bg-opacity-25 fs-6 fw-bolder rounded-pill px-2"> <i
                                            class="fa-solid fa-gears"></i> {{$vehicle->gearbox->gearbox_type}}</span>
                                    <span class="bg-info bg-opacity-25  fw-bolder rounded-pill px-2"><i
                                            class="fa-solid fa-gauge-high"></i> {{$vehicle->mileage}} KM</span>

                                </div>
                                <hr class="mt-2 ">
                                <div class="text-sm mt-2" style="height: 50px">
                                    <pre>{{ Str::words(wordwrap($vehicle->description, 30, "\n"), 8)}}</pre>
                                </div>


                                <div class="text-end ">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <small class="ms-1">{{ $vehicle->location }}</small><br>

                                    <div class="d-inline-flex align-items-center justify-content-end mt-2">
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
                            <div class="card-footer bg-white p-0 mt-1">
                                @if($vehicle->available)
                                <a href="{{ route('vehicle.show', $vehicle) }}"
                                    class="btn bg-warning fw-bolder bg-opacity-75 w-100">view more <i
                                        class="bi bi-arrow-right-circle-fill"></i></a>
                                 @else
                                 <h4 class=" mb-0 bg-danger bg-opacity-25 text-danger h4 archivo text-center py-1">Sold</h4>
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