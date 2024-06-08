const ERROR_MESSAGES = {
  professorNameBlank: "*Professor Name must not be blank",
  professorSchoolBlank: "*School must not be blank",
}


function validateRatingFormFields() {
  const professorName = $("#professor_name").val();
  const professorSchool = $("#professor_school").val();

  const errmsgWrapper = $(".rating_form-errmsgs");
  errmsgWrapper.empty();
  let errCount = 0

  if (professorName == "") {
    errmsgWrapper.append(`<li>${ERROR_MESSAGES.professorNameBlank}</li>`);
    errCount++;
  } 
  if (professorSchool == "") {
    errmsgWrapper.append(`<li>${ERROR_MESSAGES.professorSchoolBlank}</li>`);
    errCount++;
  }

  return errCount == 0;
}


function onSubmit(event) {
  const ratingFormFieldsValidated = validateRatingFormFields();

  return ratingFormFieldsValidated;
}



// client validation for rating form

$(document).ready(() => {
  $("#rating_form_submit").click(onSubmit);
  $("#rating_edit_submit").click(onSubmit);
})


