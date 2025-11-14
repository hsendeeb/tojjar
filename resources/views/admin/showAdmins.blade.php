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
  @vite('resources/js/car-models.js')
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
    
    @if(session('created'))
  <div id="alert" class="position-relative mt-5 d-flex justify-content-center p-0">

          <div class= "position-absolute text-center bg-white shadow p-3 archivo  rounded-3">
            <p>{{ session('created') }} <span class="text-success"><i class="bi bi-check-circle-fill "></i></span></p>
          </div>
        </div>
    
    @endif

  <div class="table-responsive-sm mt-5 p-5">


      
    <x-side-nav />


    <table class="table table-striped">
      <tr>
        <th class=" text-center bg-warning archivo rounded-pill px-2 py-1">Records:{{count($admins)}}</th>
      </tr>
      <tr>
        <th>Id</th>
        <th>name</th>
        <th>last name</th>
        <th>email</th>
        <th>phone</th>
        <th>status</th>
        <th>image</th>
      </tr>

      @foreach ($admins as $admin)

        <tr>

          <td>{{ $admin->id }}</td>

          <td><a href="{{ route('profile.show', $admin->id) }}">{{ $admin->user->name }}</a></td>
          <td>{{ $admin->user->last_name }}</td>
          <td>{{ $admin->user->email }}</td>
          <td>{{ $admin->user->phone }}</td>
          <td>{{ $admin->user->status }}</td>
          <td><img class="rounded-circle" style="width:30px;height:30px" src='{{ (Storage::url($admin->user->image)=='public/images/avatar.png') ? 'public/images/avatar.jpg' : Storage::url($admin->user->image)  }}'>
          </td>
          <td>
            @if($admin->user->status == "active")
              <form action="{{ route('admin.delete', $admin->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger ">Delete</button>
              </form>

            @endif

          </td>
        </tr>


      @endforeach
    </table>


  </div>
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
            <label class="form-label" for="name">Full name :</label>
            <div>
              <input class="form-control" type="text" name="name" required>
            </div>
            <div class="mt-2">
              <label class="form-label" for="username">last name :</label>
              <input class="form-control" type="text" name="username" required>
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