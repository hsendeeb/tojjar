import $ from "jquery";
import { Container } from "postcss";

// resources/js/car-models.js
const loader = document.getElementById("loader-wrapper");
if (loader) {
    window.addEventListener("load", function () {
        document.getElementById("loader-wrapper").style.display = "none";
    });
}
const BtnLoader = document.getElementById("btn-spinner");
const form = document.getElementById("vehicleForm");
if (form) {
    form.addEventListener("submit", function (e) {
        BtnLoader.style.display = "block";
    });
    
    }

const search = document.getElementById("search");
if (search) {
    document.getElementById("search").addEventListener("blur", () => {
        setTimeout(() => {
            $("#suggestions").hide();
        }, 100);
    });
}

$("#company_id").on("change", function () {
    const container = document.getElementById("companyContainer");
    if (!container) return; // defensive

    // Remove any previously created "other" inputs (prevents duplicates)
    container.querySelectorAll(".other-company").forEach((el) => el.remove());

    if (this.value === "other") {
        $("#carModel").hide();
        $("#carModelLabel").hide();

        // Create labeled inputs and mark them with .other-company
        const label = document.createElement("label");
        label.className = "form-label mt-2  other-company";
        label.textContent = "company name :";

        const newInput = document.createElement("input");
        newInput.name = "new-company";
        newInput.className = "form-control mt-1 border-success other-company";
        newInput.required=true;

        const modelLabel = document.createElement("label");
        modelLabel.className = "form-label mt-2 other-company";
        modelLabel.textContent = "model name:";

        const newModelInput = document.createElement("input");
        newModelInput.name = "new-model";
        newModelInput.className =
            "form-control mt-1 border-success other-company";


        container.appendChild(label);
        container.appendChild(newInput);
        container.appendChild(modelLabel);
        container.appendChild(newModelInput);
    } else {
        // Show the regular model selector
        $("#carModel").show();
        $("#carModelLabel").show();

        let carId = $(this).val();
        $("#carModel").empty().append('<option value="">Loading...</option>');

        if (carId) {
            $.ajax({
                url: "/get-models/" + carId,
                type: "GET",
                success: function (data) {
                    $("#carModel")
                        .empty()
                        .append('<option value="">other</option>');
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
                error: function (xhr) {
                // helpful debug info when something goes wrong (404, 419, etc.)
                console.error(
                    "error occured",
                    xhr.status,
                    xhr.responseText
                );
                
            },
            });
        } else {
            $("#carModel")
                .empty()
                .append('<option value="">Select Model</option>');
        }
    }
});

$("#search").on("keyup", function () {
    $("#suggestions").show();

    let input = $(this).val();

    if (input) {
        $("#suggestions")
            .empty()
            .append('<p class="text-center p-2">Loading...</p>');
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
                    const item = document.createElement("input");
                    item.value = name.company_name;
                    item.name="company_name";
                    item.type='submit';
                    item.classList.add("list-group-item");
                    item.classList.add("mt-2");
                    item.style.cursor = "pointer";
                   
                    item.onclick = () =>
                         document.getElementById('searchForm').submit();

                    $("#suggestions").append(item);
                });
            },
             error: function (xhr) {
                // helpful debug info when something goes wrong (404, 419, etc.)
                console.error(
                    "failed",
                    xhr.status,
                    xhr.responseText
                );
                
            },
        });
    } else {
        $("suggestions").append("<small>No results </small>");
    }
});

const label = document.querySelector(".upload-label");

document.querySelectorAll(".image-input").forEach((input) => {
    input.addEventListener("change", function (e) {
        const file = this.files[0];
        const imageCount = document.getElementById("imageCount");
        const preview = this.closest(".upload-label").querySelector("#preview");
        const staticImage =
            this.closest(".upload-label").querySelector("#staticImage");
        const staticIcon =
            this.closest(".upload-label").querySelector("#staticIcon");
        if (e.target.files.length > 0) {
            imageCount.innerHTML =
                e.target.files.length +
                "/10" +
                " " +
                "<i class='bi bi-check-circle-fill'></i>";
        } else {
            staticImage.style.display = "block";
            staticIcon.style.display = "block";
            imageCount.innerHTML = "0/10";
        }
        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function (e) {
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

if (backToTopBtn) {
    window.addEventListener("scroll", () => {
        if (window.scrollY > 200) {
            backToTopBtn.style.display = "block";
        } else {
            backToTopBtn.style.display = "none";
        }
    });
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
$("#company").hide();

$("#category").on("change", function () {
    const categoryId = $(this).val();

    if (categoryId) {
        $("#company").slideDown(500).show();
        $("#company")
            .empty()
            .append(
                "<option value='' disabled selected>select company</option>"
            );
        $.ajax({
            url: "/get-companies/" + categoryId,
            method: "GET",
            success: function (data) {
                $("#company").prop("disabled", false);
                $("#company").removeClass("opacity-50");
                $.each(data, function (index, company) {
                    $("#company").append(
                        `<option value="${company.id}">${company.company_name}</option>`
                    );
                });
            },
        });
    }
});
// get models of specific companies
$("#model").hide();

$("#company").on("change", function () {
    const companyId = $(this).val();

    if (companyId) {
        $("#model").slideDown(300).show();
        $("#model").empty();
        $.ajax({
            url: "/get-models/" + companyId,
            method: "GET",
            success: function (data) {
                $("#model").prop("disabled", false);
                $("#model").removeClass("opacity-50");
                $("#model").append(
                    "<option value=''disabled selected>select model</option>"
                );
                $.each(data, function (index, model) {
                    $("#model").append(
                        `<option value=${model.id}>${model.model_name}</option>`
                    );
                });
            },
             error: function (xhr) {
                // helpful debug info when something goes wrong (404, 419, etc.)
                console.error(
                    "failed",
                    xhr.status,
                    xhr.responseText
                );
                
            },
        });
    } else {
        $("#company").removeClass("bg-info bg-opacity-50 ");
    }
});


const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const sound = document.getElementById("like-sound");

const likeBtn=document.querySelectorAll(".likeBtn");
likeBtn.forEach((btn) => {
    btn.addEventListener("click", function () {
        const adId = btn.getAttribute("data-id");
       const icon = $(this).closest(".likeBtn").find("#like-icon-" + adId);
          
        
        $.ajax({
            url: "/ad/like/" + adId,
            method: "put",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token,
            },
            success: function (data) {
                $("#like-count-" + adId).text(data.likes);
                if (data.isLiked) {
                    icon.addClass('text-danger');
        icon.toggleClass('bi-heart bi-heart-fill'); 
         sound.currentTime = 0;
                    sound.play();
                } else {
                    icon.toggleClass('bi-heart bi-heart-fill')
                }
            },
            error:function(error) {
                icon.toggleClass="bi bi-heart-fill"
            }
        });
    });
});
document.querySelectorAll(".viewBtn").forEach((btn) => {
    btn.addEventListener("click", function () {
        const adId = btn.getAttribute("data-id");
        const viewedAds = JSON.parse(localStorage.getItem("viewedAds") || "{}");
        if (!viewedAds[adId]) {
            $.ajax({
                url: "/views/" + adId,
                method: "put",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                },
                success: function (data) {
                    console.log(data.views);
                },
                error: function (error) {
                    console.log(error);
                },
            });
            viewedAds[adId] = true;
            localStorage.setItem("viewedAds", JSON.stringify(viewedAds));
            console.log(viewedAds[adId]);
        }
    });
});
// Initialize tooltips (Bootstrap 5)
const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);
tooltipTriggerList.forEach((el) => new bootstrap.Tooltip(el));

document.querySelectorAll(".removeBtn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
        // prevent any accidental form submit or default button behavior
        e.preventDefault();

        const image_id = btn.getAttribute("data-id");
        // find the nearest wrapper so we can remove it on success
        const wrapper = btn.closest(".position-relative") || btn.parentElement;
        $.ajax({
            url: `/image/${image_id}`,
            type: "DELETE",
            headers: {
                "X-CSRF-TOKEN": token,
            },
            success: function (data) {
                console.log("delete success", data);
                // remove the image element from the DOM if server reports success
                if (wrapper) wrapper.remove();
            },
            error: function (xhr) {
                // helpful debug info when something goes wrong (404, 419, etc.)
                console.error(
                    "delete image failed",
                    xhr.status,
                    xhr.responseText
                );
                alert(
                    `Unable to delete image (status ${xhr.status}).`
                );
            },
        });
    });
});
document.querySelectorAll(".boostBtn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();
        let adId = btn.getAttribute("data-id");
        $.ajax({
            url: "/ad/boost/" + adId,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token,
            },
            success: function (data) {
                if (!data.premium) {
                    console.log(data.premium);
                    // show Bootstrap modal if user is not premium
                    const modalEl = document.getElementById("premiumModal");
                    if (modalEl) {
                        // create modal instance with default options (allow closing by ESC and backdrop click)
                        const modal = new bootstrap.Modal(modalEl, {
                            keyboard: true,
                            backdrop: true,
                        });
                        modal.show();

                        // ensure the close button explicitly hides the modal (defensive)
                        const closeBtn = modalEl.querySelector(
                            '[data-bs-dismiss="modal"]'
                        );
                        if (closeBtn) {
                            closeBtn.addEventListener("click", () =>
                                modal.hide()
                            );
                        }
                    } else {
                        console.warn("premiumModal element not found");
                    }
                } else {
                    btn.innerHTML =
                        "Boosted" +
                        "<span> <i class='bi bi-rocket-takeoff-fill'></i></span>";
                    btn.classList.remove("btn-danger");
                    btn.classList.add("fw-bolder", "text-danger");
                }
            },
            error: function (xhr) {
                console.error("Boost request failed", xhr);
            },
        });
    });
});

