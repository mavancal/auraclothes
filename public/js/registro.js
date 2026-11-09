const registrationForm = document.getElementById("registration-form");
const successMessage = document.getElementById("registration-success");
const resetButton = document.getElementById("registration-reset");

resetButton.addEventListener("click", () => {
  registrationForm.reset();
  registrationForm.hidden = false;
  successMessage.hidden = true;
  document.getElementById("name").focus();
});
