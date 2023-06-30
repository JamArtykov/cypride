$(document).ready(function() {
    // AJAX call to update profile information
    $("#updateprofileform").submit(function(event) {
        
        // Prevent default form processing
        event.preventDefault();

        // Collect user inputs
        var datatopost = $(this).serializeArray();
        console.log(datatopost);
        // Send the data to updateprofile.php using AJAX
        $.ajax({
            url: "updateusername.php",
            type: "POST",
            data: datatopost,
            success: function(data) {
                if (data) {
                    $("#updateprofilemessage").html(data);
                } else {
                    location.reload();
                }
            },
            error: function() {
                $("#updateprofilemessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
            }
        });
    });
});

$(document).ready(function() {
    // AJAX call to add car data
    $("#addcarform").submit(function(event) {
        console.log("add car");


        // Prevent default form processing
        event.preventDefault();

        // Create a FormData object to handle file uploads
        var formData = new FormData(this);
        // Send the data to addcar.php using AJAX
        $.ajax({
            url: "addcar.php",
            type: "POST",
            data: formData,
            processData: false,  // Important: prevent jQuery from processing the data
            contentType: false,  // Important: prevent jQuery from setting the content type
            success: function(data) {
                
                if (data) {
                    location.reload();
                    $("#carFormResult").html(data); 
                } else {

                }
            },
            error: function() {
                
                $("#carFormResult").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
            }
        });

        return false;
    });
});

$(document).ready(function() {
    // AJAX call to edit car data
    $("#editcarform").submit(function(event) {
        console.log("edit car");
        event.preventDefault();
        // Create a FormData object to handle file uploads
        var formData = $(this).serializeArray();


        $.ajax({
            url: "updatecar.php",
            type: "POST",
            data: formData,
            processData: false,  
            contentType: false,  
            success: function(data) {
                if (data) {
                    $("#result3").html(data); // Display success/error message from PHP file

                } else {

                }
            },
            error: function() {
                $("#result3").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
            }
        });

        return false;
    });
});





// Ajax call to updatepassword.php
$("#updatepasswordform").submit(function(event){ 
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
    //send them to updateusername.php using AJAX
    $.ajax({
        url: "updatepassword.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#updatepasswordmessage").html(data);
            }
        },
        error: function(){
            $("#updatepasswordmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            
        }
    
    });

});



// // Ajax call to updateemail.php
// $('#loading').hide();
// $("#updateemailform").submit(function(event){ 
//     //prevent default php processing
//     event.preventDefault();
//     //collect user inputs
//     var datatopost = $(this).serializeArray();
// //    console.log(datatopost);
//     //send them to updateusername.php using AJAX
//     $.ajax({
//         url: "updateemail.php",
//         type: "POST",
//         data: datatopost,
//         success: function(data){
//             if(data){
//                 $("#updateemailmessage").html(data);
//             }
//         },
//         error: function(){
//             $("#updateemailmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            
//         }
    
//     });

// });





//Update picture
var file;

$("#updatepictureform").submit(function(event) {
    //hide message
    $("#updatepicturemessage").hide();
    //show spinner
    $("#spinner").css("display", "block");
    event.preventDefault();
    if(!file){
        $("#spinner").css("display", "none");
        $("#updatepicturemessage").html('<div class="alert alert-danger">Please upload a picture!</div>');
            $("#updatepicturemessage").slideDown();
        return false;
    }
    var imagefile = file.type;
    var match= ["image/jpeg","image/png","image/jpg"];
        if($.inArray(imagefile, match) == -1){
            $("#updatepicturemessage").html('<div class="alert alert-danger">Wrong File Format</div>');
            $("#updatepicturemessage").slideDown();
            $("#spinner").css("display", "none");
            return false;
        }else{
            $.ajax({
                url: "updatepicture.php", 
                type: "POST",             
                data: new FormData(this), 
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success: function(data){
                    if(data){
                        $("#updatepicturemessage").html(data);
                        //hide spinner
                        $("#spinner").css("display", "none");
                        //show message
                        $("#updatepicturemessage").slideDown();
                        //update picture in the settings
                    }else{
                        location.reload();
                    }

                },
                error: function(){
                    $("#updatepicturemessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
                    //hide spinner
                    $("#spinner").css("display", "none");
                    //show message
                    $("#signupmessage").slideDown();

                }
            });
        }

});

// Function to preview image after validation
$(function() {
$("#picture").change(function() {
$("#updatepicturemessage").empty();
file = this.files[0];
var imagefile = file.type;
var match= ["image/jpeg","image/png","image/jpg"];
    if($.inArray(imagefile, match) == -1){
        $("#updatepicturemessage").html("<div class='alert alert-danger'>Wrong file format!</div>");
        return false;
    }
    else{
        var reader = new FileReader();
        reader.onload = imageIsLoaded;
        reader.readAsDataURL(this.files[0]);
    }
});
});
function imageIsLoaded(event) {
    $('#previewing').attr('src', event.target.result);
};