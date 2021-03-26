function validateInput() {

    var email = document.getElementById("email-input").value;
    var checkboxValue = document.getElementById("agreement-checkbox").checked;
    const emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    var errorLabel = document.getElementById("error-label");
    errorLabel.innerHTML = "";

    if (email === "") 
    {
        errorLabel.innerHTML = "Email address is required";
        return;
    }

    if (!emailRegex.test(email)) {
        errorLabel.innerHTML = "Please provide a valid e-mail address";
        return;
    }

    if (isColumbianDomain(email))
    {
        errorLabel.innerHTML = "We are not accepting subscriptions from Colombia emails";
        return;
    }

    if (checkboxValue === false)
    {
        errorLabel.innerHTML = "Please accept the terms and conditions";
        return;
    }

    addSubscriberAjaxCall(email);       //save subscriber to database endpoint call (backend/api/subscribe.php?email=)
}

function isColumbianDomain(email) {
    var array = email.split(".");
    return array[array.length - 1] === "co";
}

function addSubscriberAjaxCall(email) {
    url = window.location.href;
    url = url.substring(0, url.lastIndexOf("/"));
    url = url + "/backend/api/subscribe.php?email=" + email;

    $.ajax({
        type: "GET",
        url: url,
        contentType: "application/json",
        dataType: "json",
        success: function(result) {
            $("#subscription").css("display", "none");
            $("#subscription-success").css("display", "block");
        },
        error: function(error) {
            var errorLabel = document.getElementById("error-label");
            errorLabel.innerHTML = error.responseJSON.message;
        }
    });
}