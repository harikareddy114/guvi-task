$(document).ready(function() {
    $("#login-btn").on("click", function(event) {
        event.preventDefault();

        var email = $("#mailid").val();
        var password = $("#password").val();

        $.ajax({
            url: "/guvi/php/login.php",
            method: "POST",
            data: { email: email, password: password },
            contentType: "application/json",
            success: function(response) {
                console.log("Login successful:", response);
                var responseData = JSON.parse(response);

                try {
                    var responseData = JSON.parse(response);
                    if (responseData.success) {
                        window.location.href = "/guvi/profile.html";
                    } else {
                        console.error("Login error:", responseData.message);
                    }
                } catch (e) {
                    console.error("Error parsing JSON:", e);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", status, error);
            }
            
        });
    });
});
