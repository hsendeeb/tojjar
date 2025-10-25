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

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="p-5 text-center">
                    <div class="container d-flex justify-content-center">

                        @if($user->image != 'public/images/avatar.jpg')
                            <img src="{{ Storage::url($user->image)}}" style="width:100px; height:100px; object-fit:cover;"
                                class="rounded-circle me-2" loading="lazy">
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
            <h1 class=" text-center h1 archivo brush px-2">My Ads ({{ count($vehicles) }})</h1>
            @forelse ($vehicles as $vehicle)
                <div class="card mb-3 w-75 mx-auto p-0 mt-3 notHover">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img style="height: 200px;width:1000px" src="{{ Storage::url($vehicle->images[0]->image_url) }}"
                                class="img-fluid rounded-start object-fit-cover" alt="Card image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{$vehicle->company->company_name}} 
                                    <span class="brush px-3 py-1">{{$vehicle->model->model_name}}</span>
                                    @if ($vehicle->available) 
                                      <span class="badge rounded-pill text-bg-success bg-opacity-10 text-success">{{'Available' }}</span>
                                    @else
                                     <span class="badge rounded-pill text-bg-danger bg-opacity-10 text-danger">{{'Sold' }}</span>
                                    @endif
                                  
                                    <div
                                        class="bg-white position-absolute top-0 end-0  fw-bolder px-3 py-1 rounded-bottom-start shadow-sm">
                                        $ {{ number_format($vehicle->price) }}
                                    </div>
                                </h5>
                                <p class="card-text text-secondary">
                                    <small class="bg-info bg-opacity-25 px-2 py-1 rounded-pill"><i
                                            class="bi bi-clock-fill"></i>
                                        {{date_format($vehicle->created_at, "d,M,Y")}}</small>
                                </p>
                                <p class="card-text"><small class="text-muted">Last updated
                                        {{date_format($vehicle->updated_at, "d,M,Y")}}</small></p>
                            </div>
                            <div class="card-footer d-flex justify-content-center align-items-center mb-0 d-flex gap-2">
                                <form class="w-75" action="{{ route('vehicle.edit', $vehicle) }}">
                                    @csrf
                                   
                                    <button class="btn btn-outline-primary w-100 mx-auto" type="submit">Edit</button>
                                </form>
                                <!-- Example split danger button -->
                                <div class="btn-group">
                                    
                                    <button type="button" class="btn   text-center py-0  "
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="fs-3"><i class="bi bi-three-dots"></i></i></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if($vehicle->available)
                                       <form class="text-center" action="{{ route('markSold',$vehicle->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                         <button type="submit" class="dropdown-item"   >Mark as <span class="badge text-bg-danger text-danger bg-opacity-10 fw-bolder rounded-pill">sold</span></button>
                                       </form>
                                       @else
                                        <form class="text-center" action="{{ route('markAvailable',$vehicle->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                         <button type="submit" class="dropdown-item"   >Mark as <span class="badge text-bg-success text-success bg-opacity-10 fw-bolder rounded-pill">available</span></button>
                                       </form>

                                        @endif
           
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li class="nav-item text-center">
                                            <form action="{{ route('vehicle.destroy', $vehicle) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn text-danger" type="submit">Delete<span class="ms-2"><i
                                                            class="bi bi-trash-fill"></i>
                                                    </span></button>

                                            </form>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="container-fluid d-flex justify-content-center">
                    <img class="img-responsive w-25" src="/images/NoAds.png" alt="">
                </div>


            @endforelse
        </div>
    </div>

</x-app-layout>