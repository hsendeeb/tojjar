<x-app-layout>
     <div id="loader-wrapper">
        <div class="spinner"></div>
    </div>
    <a class="btn btn-outline-danger rounded-2 ms-2 mt-2 px-3 py-1" href="/">back</a>   
    <div class="container-fluid mt-2 d-flex justify-content-center ">
        <img class="mix-blend-multiply rounded-2" id="forSale" style="width: 200px;height:200px;object-fit:cover;" src="/images/forSale.png">
    </div>
 
    <div class="container bg-white p-3 mt-5 d-flex justify-content-center align-items-center">
      
        <form id="vehicleForm" class="form-control" method="POST" action="{{ route('placeAd') }}"
            enctype="multipart/form-data">
            @csrf
            <h2 class="h2 fw-bold  px-2 py-1 mt-2">Basic info</h2>
            <div>
                  <label for="category_id" class="form-label fw-bold">category :</label>
                <select class="form-control" name="category_id" id="category" required>
                    <option value="" disabled selected>select category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id','select category')==$category->id)>{{ $category->category }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>
            <div id="companyContainer" class="mt-3">
                <label for="company" class="form-label me-2 fw-bold">car company: </label>
                <select  class="form-control" id="company_id" name="company_id" autocomplete="off"  required>
                    <option value="" disabled selected>select company</option>
                     <option value="other">other</option>
                   
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" @selected(old('company_id',"select company")==$company->id)>{{ $company->company_name }}</option>
                        @endforeach
                </select>
                <x-input-error :messages="$errors->get('company_id')" class="mt-2" />

                <label id="carModelLabel" for="carModel" class="form-label me-2 mt-2 fw-bold">car model: </label>
                <select class="form-control mt-2" name="model_id" id="carModel">
                    <option value="{{ old('model_id') }}" @selected(old('model_id','select model'))>select model</option>
                </select>
                
                <x-input-error :messages="$errors->get('model_id')" class="mt-2" />
            </div>
             <div class="mt-3">
                <label class="fw-bold" for="title">Custom title <span class="text-sm text-muted">(optional):</span></label>
                <input class="form-control" type="text" name="title" id="title" value="{{ old('title') }}">
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="price" class="form-label fw-bold">price: </label>
                <input class="form-control" type="number" name="price" id="price" min="0" value="{{ old('price') }}" required>
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="mileage" class="form-label fw-bold">mileage: </label>
                <input class="form-control" type="number" name="mileage" value="{{ old('mileage') }}" id="mileage" min="0"  required>
                <x-input-error :messages="$errors->get('mileage')" class="mt-2" />
            </div>
             <div class="mt-3">
                <label class="fw-bold" for="year">year:</label>
                <input class="form-control" type="number" name="year" id="year" value="{{ old('year') }}" min="1950" max="{{ now()->addYear()->year}}"  required>
                <x-input-error :messages="$errors->get('year')" class="mt-2" />
            </div>
            <hr class="border-2 mt-5">
            <h2 class=" h2 fw-bold mt-2 bg-info bg-opacity-10 px-2 py-1 rounded-3">Extra info</h2>
            <div class="mt-3">
                <label class="fw-bold" for="body_id">body type:</label>
                <select class="form-control" name="body_id" id="body_id"   required>
                    @foreach($bodyType as $body)
                        <option value="{{ $body->id }}" @selected(old('body_id')==$body->id)>{{ $body->body_type }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('body_id')" class="mt-2" />

            </div>
            <div class="mt-3">
                <label for="engineType_id" class="form-label fw-bold">Engine cylinders :</label>
                <select class="form-control" name="engineType_id" id="engineType_id"  required>
                    <option value="" disabled selected>select</option>
                    @foreach($engineType as $type)
                        <option value="{{$type->id }}" @selected(old('engineType_id')==$type->id)>{{ $type->type }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('engineType_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="engineSize_id" class="form-label fw-bold">Engine size :</label>
                <select class="form-control" name="engineSize_id" id="engineSize_id" >
                    <option value="" disabled selected>select select</option>
                    @foreach($engineSize as $size)
                        <option value="{{ $size->id }}"  @selected(old('engineSize_id')==$size->id)>{{ $size->size }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('engineSize_id')" class="mt-2" />
            </div>
           
            <div class="mt-3">
                <label for="company" class="form-label fw-bold">Fuel type :</label>
                <select class="form-control" name="fuel_id" id="fuel_id"   required>
                    <option value="" disabled selected>select</option>
                    @foreach($fuelType as $fuel)
                        <option value="{{ $fuel->id }}"  @selected(old('fuel_id')==$fuel->id)>{{ $fuel->fuel_type }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('fuel_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="gearbox_id" class="form-label fw-bold">gear box :</label>
                <select class="form-control" name="gearbox_id" id="gearbox_id"  required>
                     <option value="" disabled selected>select</option>
                    @foreach($gearbox as $gear)
                        <option value="{{ $gear->id }}"  @selected(old('gearbox_id')==$gear->id)>{{ $gear->gearbox_type }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('gearbox_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="condition_id" class="form-label fw-bold">condition :</label>
                <select class="form-control" name="condition_id" id="condition_id"  required>
                    <option value="" disabled selected>select</option>
                    @foreach($conditions as $con)
                        <option value="{{ $con->id }}"  @selected(old('condition_id')==$con->id)>{{ $con->condition }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('condition_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="color_id" class="form-label fw-bold">color :</label>
                <select class="form-control" name="color_id" id="colorName"  required>
                      <option value="" disabled selected>select</option> 
                    @foreach($colors as $color)
                        <option style="background-color: {{ $color->color }}" value="{{ $color->id }}"  @selected(old('color_id')==$color->id)>{{ $color->color }}
                        </option>

                    @endforeach
                </select>
               
                <x-input-error :messages="$errors->get('color_id')" class="mt-2" />
            </div>
            <hr class="border-2 mt-5">

            <div class="mt-3 w-100">
                <label for="description" class="form-label fw-bold">description :</label><br>
                <textarea class="mt-2 w-100" rows="5"  name="description" id="description"  required>
               {{ old('description') }}
                </textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <div class="mt-3">
                <div class="form-group">
                    <label for="location">Location</label>
                    <input list="locations" id="location" name="location" value="{{ old('location') }}" placeholder="Enter a location" class="form-control" required>
                    <datalist id="locations">
                        @foreach($locations as $location)
                            <option value="{{ $location->location }}">
                        @endforeach
                    </datalist>
                 
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>
            </div>
            <div class="mt-3">
                <label for="images" class="form-label fw-bold ">image (10 images maximum):</label><br>
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <label class="upload-label fw-bold btn  py-4 px-3 border-2 border-black">

                        <img id="staticImage" src="https://www.autotrader.com.lb/bundles/appffrontend/images/1.jpg"
                            alt="car upload">
                        <i id="staticIcon" class="bi bi-upload"></i>
                        <input class="form-control d-none image-input" type="file" name="images[]" multiple accept="image/*" id="images" autofocus required>
                    <small id="imageCount" class="text-success d-block"></small>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('images')" class="mt-2" />


            </div>



    </div>

    <div class="text-center mt-5 ">
        <button id="submit" type="submit"
            class="d-inline-flex gap-2 justify-content-center align-items-center btn btn-danger w-75 text-center px-2 py-2">
            submit
            <div id="btn-spinner" class="btn-spinner" style="display:none"></div>
        </button>

    </div>

    </form>


    </div>
  



</x-app-layout>