var editButton = document.getElementById("edit-button");
var email = document.getElementById("email");
var message = document.getElementById("message");
var saveButton = document.getElementById("saveBtn");

editButton.addEventListener("click", function() {
    email.removeAttribute("disabled");
    message.removeAttribute("disabled");
    saveButton.classList.remove("d-none");
    editButton.setAttribute("disabled", "true");
});

saveButton.addEventListener("click", function() {
    email.setAttribute("disabled", "true");
    message.setAttribute("disabled", "true");
    saveButton.classList.add("d-none");
    editButton.removeAttribute("disabled");
});
