<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css"
    integrity="sha512-t7Few9xlddEmgd3oKZQahkNI4dS6l80+eGEzFQiqtyVYdvcSG2D3Iub77R20BdotfRPA9caaRkg1tyaJiPmO0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">



  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite('resources/js/car-models.js');
  @vite(['resources/css/app.css', 'resources/js/app.js']);
  <script>

  </script>
</head>

<body class="font-sans antialiased">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  @if(session('created'))
    <div id="alert" class="alert mt-3 d-flex justify-content-center align-items-center">

      <div class="container w-50 text-center bg-white shadow z-1 p-3 archivo  rounded-3">
        <p>{{ session('created') }} <span class="text-success"><i class="bi bi-check-circle-fill "></i></span></p>
      </div>
    </div>
  @endif



  <div class="container  gap-3 d-flex p-5 mt-5">
    <x-side-nav />
    <div class="row">
      <div class="col-md-4">
        <a href="{{ route('admin.showUsers')}}">
          <div class="card text-bg-primary mb-3"
            style="width: 18rem;background: linear-gradient(to right, #1a3c8b, #2e5db8, #3f7de0)">
            <div class="card-header fw-bolder">Users</div>
            <div class="card-body">
              <h2 class="card-title h2 text-end archivo">{{$users->count() }}</h2>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-4">
        <a href="{{ route('showDealers') }}">
          <div class="card text-bg-primary mb-3"
            style="width: 18rem;background: linear-gradient(to right, #1a8b3c, #2eb85d, #3fe07d)">
            <div class="card-header fw-bolder">Dealers</div>
            <div class="card-body">
              <h2 class="card-title h2 text-end archivo">{{$dealers->count() }}</h2>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="{{ route('admin.showVehicles') }}">
          <div class="card text-bg-primary mb-3"
            style="width: 18rem;background: linear-gradient(to right, #8b1a1a, #b82e2e, #e03f3f)">
            <div class="card-header fw-bolder">Vehicles</div>
            <div class="card-body">
              <h2 class="card-title h2 text-end archivo">{{$vehicles->count()}}</h2>
            </div>
          </div>
        </a>
      </div>
    </div>


    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="company-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('company.store') }}" method="POST">
              @csrf
              <label for="company_name">company :</label>
              <input class="form-control" type="text" name="company_name" required>
              <button type="submit" class="btn btn-primary mt-3 w-100">Create</button>
            </form>

          </div>

        </div>
      </div>
    </div>
    <div class="modal fade" id="model-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Create model</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('model.store') }}" method="POST">
              @csrf
              <label class="form-label" for="model_name">model :</label>
              <div>
                <input class="form-control" type="text" name="model_name" required>
              </div>
              <div class="mt-2">
                <select class="form-control" name="company_id" id="company_id" required>
                  <option value="" selected disabled>select company</option>
                  @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                  @endforeach
                </select>
              </div>
              <button type="submit" class="btn btn-primary mt-3 w-100">Create</button>
            </form>

          </div>

        </div>
      </div>
    </div>
    <div class="modal fade" id="admin-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Create admin</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('admin.store') }}" method="POST">
              @csrf
              <label class="form-label" for="user_name">admin :</label>
              <div>
                <input class="form-control" type="text" name="name" required>
              </div>
              <div class="mt-2">
                  <label class="form-label" for="last_name">last name :</label>
                <input class="form-control" type="text" name="last_name" required>
              </div>
              <div class="mt-2">
                  <label class="form-label" for="email">email :</label>
                <input class="form-control" type="email" name="email" required>
              </div>
              <div class="mt-2">
                  <label class="form-label" for="phone">phone :</label>
                <input class="form-control" type="text" name="phone" required>
              </div>
              <div class="mt-2">
                  <label class="form-label" for="password">password :</label>
                <input class="form-control" type="text" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary mt-3 w-100">Create</button>
            </form>

          </div>

        </div>
      </div>
    </div>

  </div>






  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>

</body>

</html>