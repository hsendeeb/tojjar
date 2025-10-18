<x-app-layout>

    <div class="container-fluid   text-center">
        <img id="mainImage" class="img-responsive object-fit-cover" src="/images/mainImage.png" alt="">
    </div>
   
    <h1 class="h1 text-center mt-5 fw-bolder font-sans">Featured cars</h1>
    <a href="{{route('vehicles')}}">view all vehicles</a>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-4">
                <a href="#">
                    <div class="card">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ6q0Y72Z_oZ4qAb25TScpxZpkOZxMhq4AN8Q&s"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <h3 class="card-title w-50  fw-bolder bg-secondary bg-opacity-25 px-2 py-1">Lotus GT</h3>
                            <p class="card-text">description</p>
                            <a href="#" class="btn btn-primary d-block w-50 mx-auto mt-3">view more -></a>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
 
</x-app-layout>