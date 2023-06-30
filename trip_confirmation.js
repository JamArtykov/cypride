$(document).ready(function() {
    $("#picked-up-btn").click(function() {
      confirmPickup(true);
    });
  
    $("#not-picked-up-btn").click(function() {
      confirmPickup(false);
    });
  
    function confirmPickup(pickedUp) {
      var tripId = $("#confirmation-section").data("trip-id");
      var passengerId = $("#confirmation-section").data("passenger-id");
      var driverId = $("#confirmation-section").data("driver-id");
      var pickupStatus = pickedUp ? "picked_up" : "not_picked_up";
  
      // Perform an AJAX request to update the pickup status in the database
      $.ajax({
        url: "pickupstatus.php",
        type: "POST",
        data: {
          tripId: tripId,
          passengerId: passengerId,
          driverId: driverId,
          pickupStatus: pickupStatus
        },
        success: function(response) {
          // Handle the response (e.g., show a success message)
          console.log(response);
          console.log("Success!");
  
          if (pickupStatus === "picked_up") {
            awardPayment(tripId, driverId);
          }
          
        },
        error: function(xhr, status, error) {
          // Handle any errors (e.g., show an error message)
          console.error(error);
        }
      });
    }
  
    function awardPayment(tripId, driverId) {
      // Perform an AJAX request to award payment to the driver
      $.ajax({
        url: "awardpayment.php",
        type: "POST",
        data: {
          tripId: tripId,
          driverId: driverId
        },
        success: function(response) {
          // Handle the response (e.g., show a success message)
          console.log(response);
          console.log("Payment awarded successfully!" + userId);
        },
        error: function(xhr, status, error) {
          // Handle any errors (e.g., show an error message)
          console.error(error);
        }
      });
    }
  });
  