//create a geocoder object to use the geocode
var geocoder = new google.maps.Geocoder();
var data;

//Ajax call for the update car form
$(document).ready(function() {
    // Handle form submission
    $('#editcarform').submit(function(e) {
      e.preventDefault(); // Prevent the form from submitting normally
  
      // Get the form data
      var formData = new FormData(this);
  
      // Send the form data using AJAX
      $.ajax({
        url: 'updatecar.php', 
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          // Display the response message
          $('#result3').html(response);
        },
        error: function(xhr, status, error) {
          // Handle the error
          console.log(xhr.responseText);
        }
      });
      return false;
    });
  });
  


//Ajax Call for the sign up form 
//Once the form is submitted
$("#signupform").submit(function(event){
    //hide message
    $("#signupmessage").hide();
    //show spinner
    $("#spinner").css("display", "block");
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
    //send them to signup.php using AJAX
    $.ajax({
        url: "signup.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#signupmessage").html(data);
                //hide spinner
                $("#spinner").css("display", "none");
                //show message
                $("#signupmessage").slideDown();
            }
        },
        error: function(){
            $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            //hide spinner
            $("#spinner").css("display", "none");
            //show message
            $("#signupmessage").slideDown();
            
        }
    
    });

});

//Ajax Call for the login form
//Once the form is submitted
$("#loginform").submit(function(event){ 
    //hide message
    $("#loginmessage").hide();
    //show spinner
    $("#spinner").css("display", "block");
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
    //send them to login.php using AJAX
    $.ajax({
        url: "login.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data == "success"){
                window.location = "index.php";
            }else{
                $('#loginmessage').html(data);   
                //hide spinner
                $("#spinner").css("display", "none");
                //show message
                $("#loginmessage").slideDown();
            }
        },
        error: function(){
            $("#loginmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            //hide spinner
            $("#spinner").css("display", "none");
            //show message
            $("#loginmessage").slideDown();
            
        }
    
    });

});


//Ajax Call for the forgot password form
//Once the form is submitted
$("#forgotpasswordform").submit(function(event){ 
    //hide message
    $("#forgotpasswordmessage").hide();
    //show spinner
    $("#spinner").css("display", "block");
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
    //send them to signup.php using AJAX
    $.ajax({
        url: "forgot-password.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            $('#forgotpasswordmessage').html(data);
            //hide spinner
            $("#spinner").css("display", "none");
            //show message
            $("#forgotpasswordmessage").slideDown();
        },
        error: function(){
            $("#forgotpasswordmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            //hide spinner
            $("#spinner").css("display", "none");
            //show message
            $("#forgotpasswordmessage").slideDown();
        }
    
    });

});

//Ajax Call for the search form 
$("#searchform").submit(function(event){
    $("#results").fadeOut();
    $("#spinner").css("display", "block");
    event.preventDefault();
    data = $(this).serializeArray();
    console.log(data);
    document.getElementById('results').scrollIntoView({ behavior: 'smooth' });
    
    getSearchTripDepartureCoordinates();
    
});
                        
    //define functions
    function getSearchTripDepartureCoordinates(){
        geocoder.geocode(
            {
                'address' : document.getElementById("departure").value
            },
            function(results, status){
                if(status == google.maps.GeocoderStatus.OK){
                    departureLongitude = results[0].geometry.location.lng();
                    departureLatitude = results[0].geometry.location.lat();
                    data.push({name:'departureLongitude', value: departureLongitude});
                    data.push({name:'departureLatitude', value: departureLatitude});
                    getSearchTripDestinationCoordinates();
                }else{
                    getSearchTripDestinationCoordinates();
                }

            }
        );
    }

    function getSearchTripDestinationCoordinates(){
        geocoder.geocode(
            {
                'address' : document.getElementById("destination").value
            },
            function(results, status){
                if(status == google.maps.GeocoderStatus.OK){
                    destinationLongitude = results[0].geometry.location.lng();
                    destinationLatitude = results[0].geometry.location.lat();
                    data.push({name:'destinationLongitude', value: destinationLongitude});
                    data.push({name:'destinationLatitude', value: destinationLatitude});
                    submitSearchTripRequest();
                }else{
                    submitSearchTripRequest();
                }

            }
        );

    }

    

    function submitSearchTripRequest(){
        console.log(data);
        $.ajax({
            url: "search.php",
            data: data,
            type: "POST",
            success: function(data2){
                console.log(data);
                if(data2){
                    $('#results').html(data2);    
                    
                    $('html, body').animate({
                        scrollTop: $('#results').offset().top
                      }, 800);
                    
                }
                $("#spinner").css("display", "none");
                $("#results").fadeIn();
        },
            error: function(){
                $("#results").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
                $("#spinner").css("display", "none");
                $("#results").fadeIn();

    }
        }); 

    }

    $(document).ready(function() {
        const trip_id = document.getElementById('trip-details').getAttribute('data-trip-id');
        const user_id = document.getElementById('trip-details').getAttribute('data-passenger-id');
        const driver_id = document.getElementById('trip-details').getAttribute('data-driver-id');

    
        $('#add-passenger-btn').click(function() {
            console.log(driver_id);
            $.ajax({
                url: 'createnote.php',
                type: 'post',
                data: {
                    trip_id: trip_id,
                    passenger_id: user_id,
                    driver_id: driver_id
                },
                success: function(response) {
                    alert('Passenger added successfully!');
                    location.reload();
                },
                error: function() {
                    alert('Error adding passenger!');
                }
            });
        });
    
        $('#leave-passenger-btn').click(function() {
            console.log('Leave button clicked!');
            var tripId = $('#trip-details').data('trip-id');
            var passengerId = $('#trip-details').data('passenger-id');
            var driverId = $('#trip-details').data('driver-id');
    
            $.ajax({
                url: 'deletenote.php',
                type: 'post',
                data: {
                    trip_id: tripId,
                    passenger_id: passengerId,
                    driver_id: driverId
                },
                success: function(response) {
                    alert('You left the trip successfully!');
                    location.reload();
                },
                error1: function() {
                    alert('Error leaving the trip1!');
                }     
            });
        });
    });   
    

      


