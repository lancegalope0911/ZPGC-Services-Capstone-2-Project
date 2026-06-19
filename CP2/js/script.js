/*
 * FILE: script.js
 * PURPOSE: Client-side toggle between login and signup forms.
 * USED BY: login_signup.php
 */

// SYNTAX: function name(param) { } — reusable block; param receives the argument at call time.
// LOGIC:  Called from onclick="showForm('signup-form')" links in the HTML.
function showForm(formId) {

    // SYNTAX: querySelectorAll(".class") returns all matching elements as a NodeList.
    // SYNTAX: forEach(item => { }) — arrow function runs once per element in the list.
    // SYNTAX: classList.remove("class") removes a CSS class from the element.
    // LOGIC:  Hide every form box by removing the "active" class (CSS: display: none).
    document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));

    // SYNTAX: getElementById("id") finds one element by its unique id attribute.
    // SYNTAX: classList.add("class") adds a CSS class.
    // LOGIC:  Show only the requested form (CSS: .form-box.active { display: block }).
    document.getElementById(formId).classList.add("active");
}
