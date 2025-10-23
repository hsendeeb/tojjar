<div class="container-fluid p-0 mb-0 mt-5">

  <footer class="bg-dark text-center text-lg-start text-white">
    <!-- Grid container -->
    <div class="container p-4">
      <!--Grid row-->
      <div class="row my-4">
        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">

          <div class="px-5 bg-transparent d-flex align-items-center justify-content-center mb-4 mx-auto" >
      <x-application-logo/>

          </div>

          <p class="text-center"></p>

          <ul class="list-unstyled d-flex flex-row justify-content-center">
            <li>
              <a class="text-white px-2" href="#!">
                <i class="fab fa-facebook-square"></i>
              </a>
            </li>
            <li>
              <a class="text-white px-2" href="#!">
                <i class="fab fa-instagram"></i>
              </a>
            </li>
            <li>
              <a class="text-white ps-2" href="#!">
                <i class="fab fa-youtube"></i>
              </a>
            </li>
          </ul>

        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4 archivo">Quick links</h5>

          <ul class="list-unstyled">
            <li class="mb-2">
             <form   action="{{ route('filteredSearch',[null,2000]) }}" method="post">
              @csrf
              <button class="btn-link text-decoration-none text-danger p-0 m-0 align-baseline">Vehicles under 2000$</button>
             </form>
            </li>
            
            <li class="mb-2">
              <a href="#featured" class="text-danger">featured vehicles</i></a>
            </li>
            <li class="mb-2">
              <a href="{{ route('dealers.index') }}" class="text-danger"></i>Dealers</a>
            </li>
             <li class="mb-2">
              <a href="{{ route('aboutUs') }}" class="text-danger">About us</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
      
        <!--Grid column-->
<div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4 archivo">Categories</h5>

          <ul class="list-unstyled">
            <li>
              <form action="/vehicles/filter/car" method="POST">
              @csrf
                <button type="submit">car</button>

              </form>
            
            </li>
           <li>
              <form action="/vehicles/filter/trucks" method="POST">
              @csrf
                <button type="submit">Trucks</button>

              </form>
            
            </li>
           <li>
              <form action="/vehicles/filter/Van" method="POST">
              @csrf
                <button type="submit">Van</button>

              </form>
           <li>
              <form action="/vehicles/filter/motorcycles" method="POST">
              @csrf
                <button type="submit">motorcycles</button>

              </form>
          </ul>
        </div>
        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">Contact</h5>

          <ul class="list-unstyled">
            
            <li class="mt-2">
              <p><i class="fas fa-phone pe-3"></i>+961 71 994 952</p>
            </li>
            <li class="mt-2">
              <p><i class="fas fa-envelope pe-3 mb-0"></i>hsendeeb2@gmail.com</p>
            </li>
          </ul>
        </div>
        <!--Grid column-->
      </div>
      <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        Developed by :
      <a class="text-white" href="">Hussein deeb</a><br>
     <small class="text-secondary">© {{ date("Y") }} All rights reserved</small> 
    
    </div>
    <!-- Copyright -->
  </footer>

</div>
<!-- End of .container -->