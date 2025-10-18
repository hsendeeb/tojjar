<x-app-layout>
    <div class="container mt-2 ">
        <div class="row ">
            <div class="col-lg-6">
                <div id="vehicleCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner  rounded-3">
                        @foreach($vehicle->image as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img style="height: 300px" class="img-fluid rounded-3 object-fit-cover"
                                    src="{{ asset('storage/' . $image->image_url) }}" class="d-block w-100"
                                    alt="Vehicle Image {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#vehicleCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#vehicleCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="thumbnail-scroll d-flex flex-nowrap overflow-auto gap-2 py-2">

                    @foreach($vehicle->image as $index => $image)
                        <img src="{{ asset('storage/' . $image->image_url) }}"
                            class="img-thumbnail object-fit-cover"
                            style="width: 100px; height: 60px; cursor: pointer;" data-bs-target="#vehicleCarousel"
                            data-bs-slide-to="{{ $index }}" aria-label="Slide {{ $index + 1 }}" aria-current="true">
                    @endforeach
                </div>


            </div>
            <div class="col-lg-6 mt-4">
                <div class="d-flex gap-3 flex-wrap">
                    <h1 class="h1 text-start archivo">
                        {{$vehicle->company->company_name. " " . $vehicle->year . " " . $vehicle->model->model_name }}</h1>
                    <h1 class=" h1  text-end archivo text-danger"> ${{$vehicle->price}}</h1>
                </div>
                <div class="container-fluid">
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
                            <td class="d-flex"><img class="me-1" style="width: 20px;height:20px" src="/images/pistons.png" alt=""> <span class="fw-bold">Engine cylinders: </span>
                                {{$vehicle?->engineType?->type}}</td>
                        </tr>
                         <tr>
                            <td class="d-flex"><img class="me-1" style="width: 20px;height:20px" src="/images/car-engine.png" alt=""><span class="fw-bold">Engine size: </span>
                                {{$vehicle?->engineSize?->size}}</td>
                        </tr>
                        <tr>
                            <td style="color:{{ ($vehicle->color->color == 'white') ? 'black' : $vehicle->color->color}}">
                                <i class="bi bi-droplet-fill"></i> <span class="fw-bold">Color :</span>
                                {{$vehicle->color->color}}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-fuel-pump-fill"></i> <span class="fw-bold">Fuel : </span>
                                {{$vehicle->fuel->fuel_type}}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-wrench-adjustable"></i> <span class="fw-bold">Condition : </span>
                                {{$vehicle->condition->condition}}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-geo-alt-fill"></i> <span class="fw-bold">Location : </span>
                                {{$vehicle->location}}</td>
                        </tr>

                    </table>

                </div>
            </div>
        </div>
        <div class="d-flex gap-3 justify-content-start">
            <a href="tel:{{ $vehicle->user->phone }}" class="btn btn-danger px-3"><i class="bi bi-telephone-fill "></i> {{$vehicle->user->phone}}</a>
            <a  href="https://wa.me/{{ $vehicle->user->phone }}" class="btn btn-outline-success px-3"><i class="bi bi-whatsapp"></i> Whatsapp</a>
        </div>

    </div>
    <div id="car-details" class="container-fluid bg-white mt-3">
        <div class="row p-2">
            <div class="col-lg-6">
                <h2 class="h2 archivo">More details</h2>
                <div>
                    <pre>{{ wordwrap($vehicle->description, 30, "\n")}}</pre>
                </div>
            </div>
            <div class="col-lg-6 mt-2  ">
                <h2 class="h2 archivo">User details</h2>
                <div>
                    <a href="{{ route('profile.show',$vehicle->user->id) }}">
                        @if($vehicle->user->image != 'public/images/avatar.jpg')
                        <img src="{{ Storage::url($vehicle->user->image)}}"
                            style="width:40px; height:40px; object-fit:cover;" class="rounded-circle me-2"
                            loading="lazy">
                    @else
                            <img src="/images/avatar.jpg" style="width:25px; height:25px; object-fit:cover;"
                                class="rounded-circle me-2" loading="lazy">
                        @endif 
                        {{$vehicle->user->name}}
                    </a>
                    <p><i class="bi bi-geo-alt-fill"></i> {{$vehicle->location}}</p>
                    <p><i class="bi bi-telephone-fill"></i> {{$vehicle->user->phone}}</p>
                    <p class="text-secondary"><i class="bi bi-clock-fill"></i> Joined on :
                        {{date_format($vehicle->user->created_at, 'd,M,Y')}}</p>

                </div>
            </div>
        </div>
    </div>


</x-app-layout>