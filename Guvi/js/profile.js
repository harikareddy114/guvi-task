$(document).ready(function () {
    // Fetch user profile data from the server using AJAX
    $.ajax({
        url: '/guvi/php/profile.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.success) {
                $('#name').text('Name: ' + data.name);
                $('#email').text('Email: ' + data.email);
                $('#phone').text('Phone: ' + data.number);
                $('#dob').text('Date of Birth: ' + data.dob);
                $('#age').text('Age: ' + data.age);
            } else {
                alert('Error fetching user profile data.');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching user profile data:', error);
            alert('Error fetching user profile data.');
        }        
    });
});
