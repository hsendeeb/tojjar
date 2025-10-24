import $ from "jquery";

// resources/js/car-models.js

 window.addEventListener('load', function () {
      document.getElementById('loader-wrapper').style.display = 'none';
    });

$("#company_id").on("change", function () {
    let carId = $(this).val();
     $("#carModel").empty().append('<option value="">Loading...</option>');

    if (carId) {
       
        $.ajax({
            url: "/get-models/" + carId,
            type: "GET",
            success: function (data) {
                $("#carModel")
                    .empty()
                    .append('<option value="">Select Model</option>');
                $.each(data, function (index, model) {
                    $("#carModel").append(
                        "<option value=" +
                            model.id +
                            " >" +
                            model.model_name +
                            "</option>"
                    );
                });
            },
        })
    } else {
        $("#carModel").empty().append('<option value="">Select Model</option>');
    }
});

$("#search").on("keyup", function () {
    $("#suggestions").show();

    let input = $(this).val();
  
    if (input) {
          $("#suggestions").empty().append('<p class="text-center p-2">Loading...</p>');    
        $.ajax({
            url: "/get-suggestions/" + input,
            type: "GET",
            success: function (data) {
                $("#suggestions").empty();
                if (data.length === 0) {
                    $("#suggestions").append(
                        "<p class='text-muted text-center py-2'>No results found</p>"
                    );
                    return;
                }
                $("#suggestions")
                    .empty()
                    .append("<p class='text-secondary'>select a car</p>");

                $.each(data, function (id, name) {
                    const item = document.createElement("a");
                    item.textContent = name.company_name;
                    item.classList.add("list-group-item");
                    item.classList.add('mt-2');
                    item.style.cursor = "pointer";
                    item.href = `/company/show/${name.company_name}`;
                    item.onclick = () =>
                        (window.location.href = `/company/show/${name.company_name}`);
                    $("#suggestions").append(item);
                });
            },
        })
    } else {
        $("suggestions").append("<small>No results </small>");
    }
});

const label = document.querySelector(".upload-label");

document.querySelectorAll(".image-input").forEach((input) => {
    input.addEventListener("change", function () {
        const file = this.files[0];
        const preview = this.closest(".upload-label").querySelector("#preview");
        const staticImage =
            this.closest(".upload-label").querySelector("#staticImage");
        const staticIcon =
            this.closest(".upload-label").querySelector("#staticIcon");

        if (file && file.type.startsWith("image/")) { 
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
              
                preview.style.display = "block";
                
                staticImage.style.display = "none";
                staticIcon.style.display = "none";
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = "none";
            preview.src = "";
            staticImage.style.display = "block";
            staticIcon.style.display = "block";
        }
    });
});
const backToTopBtn = document.getElementById("glass-button");

window.addEventListener("scroll", () => {
    if (window.scrollY > 200) {
        backToTopBtn.style.display = "block";
    } else {
        backToTopBtn.style.display = "none";
    }
});
if(backToTopBtn) {
backToTopBtn.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
});
}



setTimeout(() => {
    const alertBox = document.getElementById("alert");
    if (alertBox) {
        alertBox.style.transition = "opacity 0.5s ease";
        alertBox.style.opacity = "0";
        setTimeout(() => alertBox.remove(), 500); // remove after fade
    }
}, 3000); // dismiss after 3 seconds


// filter functions
//get companies of specific category
$('#company').hide();

$("#category").on('change',function (){
    const categoryId=$(this).val();
    
    if(categoryId) {
            $("#company").slideDown(500).show();
            $("#company").empty().append("<option value='' disabled selected>select company</option>");
        $.ajax({
            url:"/get-companies/"+categoryId,
            method:"GET",
            success:function(data){
                $("#company").prop('disabled',false);
                 $("#company").removeClass("opacity-50");
                $.each(data,function(index,company) {
                    $('#company').append(`<option value="${company.id}">${company.company_name}</option>`)
                })
            }
        })
    }
   
})
// get models of specific companies
$("#model").hide();

$("#company").on('change',function() {
    const companyId=$(this).val();
    
    if(companyId){
     
        $("#model").slideDown(500).show();
        $("#model").empty();
        $.ajax({
            url:"/get-models/"+companyId,
            method:"GET",
            success:function(data) {
                $("#model").prop('disabled',false);
                $("#company").addClass("bg-info bg-opacity-25  ");
                 $("#model").addClass("bg-primary bg-opacity-10 ");
                $('#model').removeClass("opacity-50");
                $('#model').append("<option value=''disabled selected>select model</option>")
                $.each(data,function(index,model){
                      $("#model").append(`<option value=${model.id}>${model.model_name}</option`);
                    
                }) 
            }
        })

    } else {
         $("#company").removeClass("bg-info bg-opacity-50 ");

    }
});
document.addEventListener("DOMContentLoaded",function () {
    const form=document.getElementById('addVehicle');
   

    if(form){
document.getElementById('addVehicle').addEventListener('submit', function() {
    document.getElementById('btn-spinner').style.display = 'block';
});
    }

})







document.getElementById("search").addEventListener("blur", () => {
    setTimeout(() => {
        $("#suggestions").hide();
    }, 100);
});

   
