<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us | Tojjar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
   <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />  
  @vite('resources/js/car-models.js')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .hero {
    
      color: white;
      padding: 60px 0;
    }
    .section-title {
      font-weight: bold;
      margin-bottom: 20px;
      color: #b02a37;
    }
    .icon-box {
      text-align: center;
      padding: 30px 20px;
      border-radius: 8px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
    }
    .icon-box:hover {
      transform: translateY(-5px);
    }
    .icon-box i {
      font-size: 48px;
      color: #dc3545;
      margin-bottom: 15px;
    }
    footer {
      background-color: #f8d7da;
      color: #842029;
    }
  </style>
</head>
<body>
    <div id="loader-wrapper">
        <div class="spinner"></div>
    </div>
    @include('layouts.navigation')


  <section class="bg-secondary bg-opacity-50 hero text-center">
    <div class="container">
      <h3 class="display-5 gap-2 align-items-center d-flex justify-content-center fw-bold">Welcome to <span class="p-0"><x-application-logo/></span></h3>
      <p class="lead">Your trusted marketplace for buying and selling cars</p>
    </div>
  </section>

  <!-- About Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="section-title text-center">Who We Are</h2>
      <p class="text-center mb-5">
        Tojjar is a dynamic car deals platform where users and dealers connect to buy and sell vehicles with ease.
        Whether you're looking for your next ride or ready to post your car for sale, Tojjar makes the process simple, secure, and fast.
      </p>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="icon-box">
            <i class="bi bi-person-plus-fill"></i>
            <h5 class="mt-2">For Users</h5>
            <p>Browse listings, compare deals, and find the perfect car that fits your lifestyle and budget.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="icon-box">
            <i class="bi bi-building-fill"></i>
            <h5 class="mt-2">For Dealers</h5>
            <p>Post your inventory, reach a wider audience, and close deals faster with our intuitive dashboard.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="icon-box">
            <i class="bi bi-shield-lock-fill"></i>
            <h5 class="mt-2">Secure & Transparent</h5>
            <p>We prioritize trust and transparency, ensuring every transaction is safe and verified.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <x-footer/>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>