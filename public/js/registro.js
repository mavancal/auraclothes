const registrationForm = document.getElementById("registration-form");
const successMessage = document.getElementById("registration-success");
const resetButton = document.getElementById("registration-reset");

registrationForm.addEventListener("submit", (event) => {
  event.preventDefault();
  registrationForm.hidden = true;
  successMessage.hidden = false;
  window.scrollTo({ top: 0, behavior: "smooth" });
});

resetButton.addEventListener("click", () => {
  registrationForm.reset();
  registrationForm.hidden = false;
  successMessage.hidden = true;
  document.getElementById("nombre_usuario").focus();
});
