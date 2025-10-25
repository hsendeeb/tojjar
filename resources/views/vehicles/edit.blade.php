<x-app-layout>
  <div class="placeAd container mt-2">
    <button onclick="history.back()" class="btn btn-outline-danger text-start">Cancel</button>
        <h1 class=" h1 mt-3 fw-bolder text-center text-danger font-sans ">Edit Ad</h1>
    
    </div>
    
    <div class="container-fluid bg-white p-3 mt-5 d-flex justify-content-center align-items-center pt-16">
         
        <form  class="form-control" method="POST" action="{{ route('vehicle.update',$vehicle) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h3 class="h3 text-center0 px-2">Basic info</h3>
            <div>
                <select class="form-control" name="category_id" id="category">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id',$vehicle->category_id)==$category->id)>{{ $category->category }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>
            <div class="d-flex flex-wrap align-items-center mt-3">


                <label for="company" class="form-label me-2">car model: </label>
                <select class="form-control" name="company_id" id="company">
                   <option value="">select a company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" @selected(old('company_id',$vehicle->company_id)==$company->id)>{{ $company->company_name }}</option>
                    @endforeach
                </select>
                 <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                <select class="form-control mt-2" name="model_id" id="carModel">
                    <option class="active" value="{{ $vehicle->model_id }}">{{$vehicle->model->model_name}}</option>
                </select>
                 <x-input-error :messages="$errors->get('carModel_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="price" class="form-label fw-bold">price: </label>
                <input class="form-control" type="number" name="price" id="price" min="0" value="{{ $vehicle->price }}">
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="mileage" class="form-label fw-bold">mileage: </label>
                <input class="form-control" type="number" name="mileage" id="mileage" min="0" value="{{ $vehicle->mileage }}">
                 <x-input-error :messages="$errors->get('mileage')" class="mt-2" />
            </div>
            <hr class="border-2 mt-5">
            <h2 class=" h2 fw-bold mt-2 bg-info bg-opacity-10 px-2 py-1 rounded-3">Extra info</h2>
            <div class="mt-3">
                <label class="fw-bold" for="body_id">body type:</label>
                <select class="form-control" name="body_id" id="body_id">
                    @foreach($bodyType as $body)
                        <option value="{{ $body->id }}" @selected(old('body_id',$vehicle->body_id)==$body->id)>{{ $body->body_type }}</option>
                    @endforeach
                </select>
                 <x-input-error :messages="$errors->get('body_id')" class="mt-2" />

            </div>
            <div class="mt-3">
                <label for="engineType_id" class="form-label fw-bold">Engine cylinders :</label>
                <select class="form-control" name="engineType_id" id="engineType_id">
                    @foreach($engineType as $type)
                        <option value="{{$type->id }}">{{ $type->type }}</option>
                    @endforeach
                </select>
                 <x-input-error :messages="$errors->get('engineType_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="engineSize_id" class="form-label fw-bold">Engine size :</label>
                <select class="form-control" name="engineSize_id" id="engineSize_id">
                    @foreach($engineSize as $size)
                        <option  value="{{ $size->id }}">{{ $size->size }}</option>
                    @endforeach
                </select>
                 <x-input-error :messages="$errors->get('engineSize_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label class="fw-bold" for="year">year:</label>
                <input class="form-control" type="number" name="year" id="year" min="1950" max="{{ Date('Y') }}" value="{{ $vehicle->year }}">
                 <x-input-error :messages="$errors->get('year')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="company" class="form-label fw-bold">Fuel type :</label>
                <select class="form-control" name="fuel_id" id="fuel_id">
                    @foreach($fuelType as $fuel)
                        <option value="{{ $fuel->id }}" @selected(old('fuel_id',$vehicle->fuel_id)==$fuel->id)>{{ $fuel->fuel_type }}</option>
                    @endforeach
                </select>
                 <x-input-error :messages="$errors->get('fuel_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="gearbox_id" class="form-label fw-bold">gear box :</label>
                <select class="form-control" name="gearbox_id" id="gearbox_id">
                    @foreach($gearbox as $gear)
                        <option value="{{ $gear->id }}" @selected(old('gearbox_id',$vehicle->gearbox_id)==$gear->id)>{{ $gear->gearbox_type }}</option>
                    @endforeach
                </select>
                 <x-input-error :messages="$errors->get('gearbox_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="condition_id" class="form-label fw-bold">gear box :</label>
                <select class="form-control" name="condition_id" id="condition_id">
                    @foreach($conditions as $con)
                        <option value="{{ $con->id }}" @selected(old('condition_id',$vehicle->condition_id)==$con->id)>{{ $con->condition }}</option>
                    @endforeach
                </select>
                 <x-input-error :messages="$errors->get('condition_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="color_id" class="form-label fw-bold">color :</label>
                <select class="form-control" name="color_id" id="color_id">
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}" @selected(old('color_id',$vehicle->color_id)==$color->id)>{{ $color->color }}</option>
                    @endforeach
                </select>
                 <x-input-error :messages="$errors->get('color_id')" class="mt-2" />
            </div>
            <hr class="border-2 mt-5">

            <div class="mt-3">
                <h3 class="h3 fw-bold">Accepted payment methods:</h3>
                <input class=" p-2 me-1" type="radio" name="payment" value="LBP" @checked(old('payment',$vehicle->payment)=='LBP')> lebanese pound(LBP)<br> <br>
                <input class=" p-2 me-1" type="radio" name="payment" value="USD" @checked(old('payment',$vehicle->payment)=='USD')> USD<br><br>
                <input class=" p-2 me-1" type="radio" name="payment" value="cheque" @checked(old('payment',$vehicle->payment)=='cheque')> cheque
               <x-input-error :messages="$errors->get('payment')" class="mt-2" />
            </div>
            <div class="mt-3">
                <h3 class="h3 fw-bold">Description & location</h3>
                <textarea class="mt-2" name="description" id="description">
                {{ old('description',$vehicle->description) }}

                
                </textarea>
                 <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <div class="mt-3">
                <div class="form-group">
                    <label for="location">Location</label>
                    <input id="location" type="text" name="location" class="form-control" value="{{ old("location",$vehicle->location) }}"
                        placeholder="Enter a location">
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>
            </div>
            <div class="mt-3">
                <label class="form-label fw-bold ">image</label><br>
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                   
                   @php
    $existingImageCount = count($vehicle->images);
    
@endphp

<div id="imageInputs" class="container">
    @foreach ($vehicle->images as $index => $image)
        <div class="mb-2">
            <label class="btn btn-outline-danger upload-label">
            <input type="file" name="images[{{ $index }}]" class="form-control image-input">
            
            <img id="preview" style="width:100px;height:100px" class="img-fluid mt-2 object-fit-covermx-auto" src="{{ Storage::url($image->image_url) }}" alt="">
        </label>
        </div>
    @endforeach
</div>

<button type="button" class="btn btn-danger" onclick="add({{ $existingImageCount }})">Add Image</button>
                    
                  
                </div>
                 <x-input-error :messages="$errors->get('images')" class="mt-2" />  
               

            </div>
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-danger w-50 mx-auto px-3 py-2">submit</button>
            </div>
            
        </form>
          
    </div>
  
   
 <script>
    let existingInputs = 0;
let newInputs = 0;
const maxInputs = 10;

    function add(existingCount) {
    if (existingInputs === 0) {
        existingInputs = existingCount;
    }

    if (existingInputs + newInputs >= maxInputs) {
        alert("Maximum of 10 images allowed.");
        return;
    }

    newInputs++;

    const container = document.getElementById("imageInputs");
    const inputWrapper = document.createElement("div");
    inputWrapper.className = "mb-2";

    const input = document.createElement("input");
    const img=document.createElement("img");
    input.type = "file";
    input.name = `images[new_${newInputs}]`;
    input.className = "form-control image-input";
    img.id="preview";
    inputWrapper.appendChild(input);
    container.appendChild(inputWrapper);
    container.appendChild(img);
}




 </script>

</x-app-layout>