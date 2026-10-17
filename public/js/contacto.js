const contactForm = document.getElementById("contact-form");
const successMessage = document.getElementById("contact-success");
const resetButton = document.getElementById("contact-reset");

contactForm.addEventListener("submit", (event) => {
  event.preventDefault();
  contactForm.hidden = true;
  successMessage.hidden = false;
});

resetButton.addEventListener("click", () => {
  contactForm.reset();
  contactForm.hidden = false;
  successMessage.hidden = true;
  document.getElementById("c-nombre").focus();
});
