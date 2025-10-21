<x-app-layout>
    <div class="container-fluid mt-2 d-flex justify-content-center bg-white">
        <img id="forSale" style="width: 200px;height:200px;object-fit:cover" src="/images/forSale.png">
    </div>

    <div class="container bg-white p-3 mt-5 d-flex justify-content-center align-items-center">
        <form id="addVehicle" class="form-control" method="POST" action="{{ route('placeAd') }}"
            enctype="multipart/form-data">
            @csrf
            <h2 class="h2 fw-bold  px-2 py-1 mt-2">Basic info</h2>
            <div>
                <select class="form-control" name="category_id" id="category">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>
            <div class="d-flex flex-wrap align-items-center mt-3">
                <label for="company" class="form-label me-2 fw-bold">car company: </label>
                <select class="form-control" id="company_id" name="company_id" autocomplete="off">
                    <option value="">select company
                    <option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endforeach
                </select>
                <x-input-error :messages="$errors->get('company_id')" class="mt-2" />

                <label for="carModel" class="form-label me-2 mt-2 fw-bold">car model: </label>
                <select class="form-control mt-2" name="model_id" id="carModel">
                    <option value="">select model</option>
                </select>
                <x-input-error :messages="$errors->get('carModel_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="price" class="form-label fw-bold">price: </label>
                <input class="form-control" type="number" name="price" id="price" min="0">
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="mileage" class="form-label fw-bold">mileage: </label>
                <input class="form-control" type="number" name="mileage" id="mileage" min="0">
                <x-input-error :messages="$errors->get('mileage')" class="mt-2" />
            </div>
            <hr class="border-2 mt-5">
            <h2 class=" h2 fw-bold mt-2 bg-info bg-opacity-10 px-2 py-1 rounded-3">Extra info</h2>
            <div class="mt-3">
                <label class="fw-bold" for="body_id">body type:</label>
                <select class="form-control" name="body_id" id="body_id">
                    @foreach($bodyType as $body)
                        <option value="{{ $body->id }}">{{ $body->body_type }}</option>
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
                        <option value="{{ $size->id }}">{{ $size->size }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('engineSize_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label class="fw-bold" for="year">year:</label>
                <input class="form-control" type="number" name="year" id="year" min="1950" max="{{ Date('Y') }}">
                <x-input-error :messages="$errors->get('year')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="company" class="form-label fw-bold">Fuel type :</label>
                <select class="form-control" name="fuel_id" id="fuel_id">
                    @foreach($fuelType as $fuel)
                        <option value="{{ $fuel->id }}">{{ $fuel->fuel_type }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('fuel_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="gearbox_id" class="form-label fw-bold">gear box :</label>
                <select class="form-control" name="gearbox_id" id="gearbox_id">
                    @foreach($gearbox as $gear)
                        <option value="{{ $gear->id }}">{{ $gear->gearbox_type }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('gearbox_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="condition_id" class="form-label fw-bold">condition :</label>
                <select class="form-control" name="condition_id" id="condition_id">
                    @foreach($conditions as $con)
                        <option value="{{ $con->id }}">{{ $con->condition }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('condition_id')" class="mt-2" />
            </div>
            <div class="mt-3">
                <label for="color_id" class="form-label fw-bold">color :</label>
                <select class="form-control" name="color_id" id="color_id">
                    @foreach($colors as $color)
                        <option style="background-color: {{ $color->color }}" value="{{ $color->id }}">{{ $color->color }}
                        </option>

                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('color_id')" class="mt-2" />
            </div>
            <hr class="border-2 mt-5">

            <div class="mt-3">
                <h3 class="h3 fw-bold">Accepted payment methods:</h3>
                <input class=" p-2 me-1" type="radio" name="payment" value="LBP"> lebanese pound(LBP)<br> <br>
                <input class=" p-2 me-1" type="radio" name="payment" value="USD"> USD<br><br>
                <input class=" p-2 me-1" type="radio" name="payment" value="cheque"> cheque
                <x-input-error :messages="$errors->get('payment')" class="mt-2" />
            </div>
            <div class="mt-3">
                <h3 class="h3 fw-bold">Description & location</h3>
                <textarea class="mt-2" name="description" id="description">

                </textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <div class="mt-3">
                <div class="form-group">
                    <label for="location">Location</label>
                    <input id="location" type="text" name="location" class="form-control"
                        placeholder="Enter a location">
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>
            </div>
            <div class="mt-3">
                <label for="images" class="form-label fw-bold ">image</label><br>
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <label class="upload-label fw-bold btn  py-4 px-3 border-2 border-black">

                        <img id="staticImage" src="https://www.autotrader.com.lb/bundles/appffrontend/images/1.jpg"
                            alt="">
                        <i id="staticIcon" class="bi bi-upload"></i>

                        <img style="display:none;object-fit:cover;width:119px" id="preview" src="" alt="">
                        <input class="form-control d-none image-input" type="file" name="images[]" id="images">
                    </label>

                    <label class="upload-label fw-bold btn  py-4 px-3 border-2 border-black">
                        <img id="staticImage" src="https://www.autotrader.com.lb/bundles/appffrontend/images/1.jpg"
                            alt="">
                        <i id="staticIcon" class="bi bi-upload"></i>
                        <img style="display:none;width:119px" id="preview" src="" alt="">

                        <input class="form-control d-none image-input" type="file" name="images[]" id="images">
                    </label>

                    <label class=" upload-label fw-bold btn  py-4 px-3 border-2 border-black">

                        <img id="staticImage" src="https://www.autotrader.com.lb/bundles/appffrontend/images/1.jpg"
                            alt="">
                        <i id="staticIcon" class="bi bi-upload"></i>

                        <img style="display:none;width:119px" id="preview" src="" alt="">
                        <input class="form-control d-none image-input" type="file" name="images[]" id="images">
                    </label>

                    <label class="upload-label fw-bold btn  py-4 px-3 border-2 border-black">

                        <img id="staticImage" src="https://www.autotrader.com.lb/bundles/appffrontend/images/1.jpg"
                            alt="">
                        <i id="staticIcon" class="bi bi-upload"></i>

                        <img style="display:none;width:119px" id="preview" src="" alt="">
                        <input class="form-control d-none image-input" type="file" name="images[]" id="images">
                    </label>


                    <label class="upload-label fw-bold btn  py-4 px-3 border-2 border-black">
                        <img id="staticImage" src="https://www.autotrader.com.lb/bundles/appffrontend/images/1.jpg"
                            alt="">
                        <i id="staticIcon" class="bi bi-upload"></i>
                        <img style="display:none;width:119px" id="preview" src="" alt="">
                        <input class="form-control d-none image-input" type="file" name="images[]" id="images">
                    </label>


                    <label class="upload-label fw-bold btn  py-4 px-3 border-2 border-black">
                        <img id="staticImage" src="https://www.autotrader.com.lb/bundles/appffrontend/images/1.jpg"
                            alt="">
                        <i id="staticIcon" class="bi bi-upload"></i>
                        <img style="display:none;width:119px" id="preview" src="" alt="">
                        <input class="form-control d-none image-input" type="file" name="images[]" id="images">
                    </label>


                    <label class="upload-label fw-bold btn  py-4 px-3 border-2 border-black">
                        <img id="staticImage" src="https://www.autotrader.com.lb/bundles/appffrontend/images/1.jpg"
                            alt="">
                        <i id="staticIcon" class="bi bi-upload"></i>
                        <img style="display:none;width:119px" id="preview" src="" alt="">
                        <input class="form-control d-none image-input" type="file" name="images[]" id="images">
                    </label>


                    <label class="upload-label fw-bold btn  py-4 px-3 border-2 border-black">
                        <img id="staticImage" src="https://www.autotrader.com.lb/bundles/appffrontend/images/1.jpg"
                            alt="">
                        <i id="staticIcon" class="bi bi-upload"></i>
                        <img style="display:none;width:119px" id="preview" src="" alt="">
                        <input class="form-control d-none image-input" type="file" name="images[]" id="images">
                    </label>


                    <label class="upload-label fw-bold btn  py-4 px-3 border-2 border-black">
                        <img id="staticImage" src="https://www.autotrader.com.lb/bundles/appffrontend/images/1.jpg"
                            alt="">
                        <i id="staticIcon" class="bi bi-upload"></i>
                        <img style="display:none;width:119px" id="preview" src="" alt="">
                        <input class="form-control d-none image-input" type="file" name="images[]" id="images">
                    </label>

                    <label class="upload-label fw-bold btn  py-4 px-3 border-2 border-black">
                        <img id="staticImage" src="https://www.autotrader.com.lb/bundles/appffrontend/images/1.jpg"
                            alt="">
                        <i id="staticIcon" class="bi bi-upload"></i>
                        <img style="display:none;width:119px" id="preview" src="" alt="">
                        <input class="form-control d-none image-input" type="file" name="images[]" id="images">
                    </label>
                </div>
                <x-input-error :messages="$errors->get('images')" class="mt-2" />


            </div>



    </div>
    
    <div class="text-center mt-5 ">
        <button type="submit" class="d-inline-flex gap-2 justify-content-center align-items-center btn btn-danger w-75 text-center px-2 py-2">
            submit
        <div class="btn-spinner" style="display:none"></div>
        </button>
        
    </div>

    </form>
 

    </div>



</x-app-layout>