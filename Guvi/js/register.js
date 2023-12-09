$(document).ready(function() {
    console.log("Document is ready.");
    
    $("#reg").submit(function(event) {
        $("#register-btn").prop("disabled", true);

        $("#reg").attr("method", "post");
        event.preventDefault();
        console.log("Register button clicked.");

        var name = $("#name").val();
        var email = $("#email").val();
        var number = $("#number").val();
        var dob = $("#dob").val();
        var password = $("#password").val();

        console.log("Name:", name);
        console.log("Email:", email);
        console.log("Number:", number);
        console.log("DOB:", dob);
        console.log("Password:", password);

        $.ajax({
            url: "/guvi/php/register.php",
            method: "POST",
            data: {
                name: name,
                email: email,
                number: number,
                dob: dob,
                password: password
            },
            success: function(response) {
                console.log("Registration successful:", response);
                $("#register-btn").prop("disabled", true);
                setTimeout(function() {
                    window.location.href = "/guvi/profile.html";
                }, 5000);
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Registration error:", errorThrown);
                $("#register-btn").prop("disabled", false);

                var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "Registration failed. Please try again.";
                $("#error-message").text(errorMessage);
            }
        });
    });
});
