// pick-a-color
$(document).ready(function() {
  $(".pick-a-color").pickAColor({
    showSpectrum: true,
    showSavedColors: true,
    saveColorsPerElement: true,
    fadeMenuToggle: true,
    showAdvanced: true,
    showBasicColors: true,
    showHexInput: true,
    allowBlank: true,
    inlineDropdown: true
  });
});

// Exception Page
const buttonAddExceptionInput = document.getElementById("addExceptionInput");
const containerExceptionInputs = document.getElementById("exceptionInputs");

buttonAddExceptionInput.addEventListener("click", () => {
  const dataException = document.querySelectorAll("[data-exception]");
  let newInputCounter;

  dataException.forEach(e => (newInputCounter = e.dataset.exception));
  newInputCounter++;

  containerExceptionInputs.insertAdjacentHTML(
    "beforeend",
    `<div class="input-group mb-2 col-md-6"><input type="text" class="form-control" value="" name="exception_pages__${newInputCounter}" data-exception="${newInputCounter}"><span class="input-group-append"><button class="btn btn-outline-secondary delete-input" type="button">×</button></span></div>`
  );
});

containerExceptionInputs.addEventListener("click", e => {
  const target = e.target;
  if (!target.classList.contains("delete-input")) {
    return;
  }
  e.preventDefault();

  target.offsetParent.remove();
});

// Form content
document.addEventListener("submit", function(e) {
  const target = e.target;
  if (!target.classList.contains("form")) {
    return;
  }
  e.preventDefault();

  $.ajax({
    type: "POST",
    url: "edit_json.php",
    data: $(target).serialize(),
    dataType: "html",
    success: function(data) {
      alert("Успешно сохранено!");
    },
    error: function() {}
  });
});

// Form Image
document.addEventListener("submit", function(e) {
  const target = e.target;
  if (!target.classList.contains("form-image")) {
    return;
  }
  e.preventDefault();

  const data = new FormData();

  const customFile = jQuery("#customFile")[0].files[0];
  data.append("userfile", customFile);

  jQuery.ajax({
    url: "replacement_image.php",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    method: "POST",
    success: function(data) {
      alert(data);
    },
    error: function(err) {
      alert(err);
    }
  });
});

$("#customFile").on("change", function() {
  const fileName = $(this).val();
  $(this)
    .next(".custom-file-label")
    .html(fileName);
});
