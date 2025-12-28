<x-app-layout>
   


    <button id="glass-button" class="glass-button px-4 py-1 rounded-pill text-dark"><i
            class="bi bi-arrow-up-circle-fill"></i></button>

        

    <h1 id="featured" class="h1 text-center text-white mt-5 archivo redBrush">Dealers</h1>
    <div id="body" class="container mt-3">
        <small class="text-primary fw-bolder">{{ $dealers->count() }} dealers</small>
        <div class="row">
            @forelse($dealers as $dealer)
                <div class="col-md-4 mt-5">
                    <a name="viewMore" href="{{ route('profile.show', $dealer->user->id) }}">
                        <div class="card shadow ">

                            <div class="position-relative d-inline-block">
                                @if($dealer->user->image!='public/images/avatar.png')
                                <img src="{{ Storage::url($dealer->user->image) }}" loading="lazy"
                                    class="img-fluid rounded object-fit-cover" style="height: 250px;width:1000px"
                                    alt="dealer Image">
                                    @else
                                     <img src="/images/avatar.jpg" loading="lazy"
                                    class="img-fluid rounded object-fit-cover" style="height: 250px;width:1000px"
                                    alt="dealer Image">
                                    @endif

                                
                            </div>

                            <div class="card-body  px-2"  >
                                <h5 class="text-nowrap h5 text-center card-title archivo  fw-bolder bg-opacity-25  py-1">
                                    {{$dealer->user->name}} 
                                    @if($dealer->user->premium) <span class="text-primary"><i
                                                class="bi bi-patch-check-fill"></i></span>
                                                 @endif
                                </h5>
              
                            </div>
                            <div class="card-footer bg-white p-0 mt-1">
                                
                                <a name="viewMore" href="{{ route('profile.show', $dealer->user->id) }}"
                                    class="btn bg-black  text-white fw-bolder w-100">view dealer<i
                                        class="bi bi-arrow-right-circle-fill ms-2"></i></a>
                              
                                    </div>
                        </div>
                    </a>
                </div>
            @empty
                <h2 class="text-center">No results</h2>
            @endforelse
        </div>

       
    </div>

</x-app-layout>