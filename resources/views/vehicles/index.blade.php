<x-app-layout>
    <div id="loader-wrapper">
        <div class="spinner"></div>
    </div>


    <button id="glass-button" class="glass-button px-4 py-1 rounded-pill text-dark"><i
                class="bi bi-arrow-up-circle-fill"></i></button>

    <div class="container-fluid pt-4 d-flex gap-2 p-1 bg-transparent mt-5">
        <form class="d-flex justify-content-center form-control bg-transparent" method="GET"
            action="{{ route('company.show') }}">
            <input id="search" name="company_name" type="text" class="form-control w-100 " required
                placeholder="search for any car">
            <button type="submit" class=" text-dark px-2 fs-3"> <i class="bi bi-search"></i></button>

        </form>
    </div>
    <div style="display: none;height:100px;" class="bg-white  shadow z-1 overflow-y-auto px-3  " id="suggestions">
    </div>

    <div id="alert" class="container d-flex justify-content-center">
        @if(session("notFound"))
            <small class="alert alert-danger py-1 px-4 bg-opacity-10 text-danger rounded-3">
                {{ session('notFound') }}
            </small>
        @endif
    </div>


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
    <h3 class="px-2 mt-3 fw-bold">Dealers</h3>
    <div class="d-flex justify-content-end px-2">
        <a class="text-danger" href="{{ route('dealers.index') }}">see all</a>
    </div>


    <div class="d-flex flex-nowrap  gap-3 overflow-x-auto over mt-3 py-2">

        @forelse ($dealers as $dealer)
            <a id="dealer" href="{{ route('profile.show', $dealer->user->id) }}">
                <div class="px-3">
                    <img class="rounded-circle object-fit-cover" style="width:55px;height:50px"
                        src="{{ Storage::url($dealer->user->image) }}" alt=" logo">
                    <small class="text-nowrap fw-bold text-center mt-2">{{ $dealer->name }}</small>

                </div>
            </a>


        @empty
            <p class="text-center text-muted">No dealers</p>

        @endforelse


    </div>

    <h1 id="featured" class="h1 text-center mt-5 archivo brush">Featured cars</h1>
    <div id="body" class="container-fluid mt-3">
        <div class="row">
            @forelse($paginatedVehicles as $vehicle)
                <div class="col-md-3 mt-5">
                   
                        <div class="card shadow ">

                            <div class="position-relative d-inline-block">
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
                                        @if($vehicle->user->image != 'public/images/avatar.jpg')
                                            <img src="{{ Storage::url($vehicle->user->image)}}"
                                                style="width:25px; height:25px; object-fit:cover;" class="rounded-circle me-2"
                                                alt="user image" loading="lazy">
                                        @else
                                            <img src="/images/avatar.jpg" style="width:25px; height:25px; object-fit:cover;"
                                                class="rounded-circle me-2" loading="lazy">
                                        @endif
                                        <small class="fw-bolder">{{ $vehicle->user->name }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white p-2 mt-1">
                                @if($vehicle->available)
                                <div class="d-flex gap-4 justify-content-center">
                                    <a name="viewMore" href="{{ route('vehicle.show', $vehicle) }}"
                                        class="btn bg-black fw-bolder text-white w-75">view more <i
                                            class="bi bi-arrow-right-circle-fill"></i></a>
                                            <button class="fs-4 ms-4 p-0"><i class="bi bi-heart"></i></button>
                                            </div>
                                @else
                                    <h4 class=" mb-0 bg-danger bg-opacity-25 text-danger h4 archivo text-center py-1">Sold</h4>
                                @endif
                            </div>
                        </div>
                    
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