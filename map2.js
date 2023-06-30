//set map options
var myLatLng = {lat: 35.12, lng: 33.86};
var mapOptions = {
    center: myLatLng,
    zoom: 8,
    mapTypeId: google.maps.MapTypeId.ROADMAP
};

console.log("Inside 2= function");

//create autocomplete objects

var options = {
    componentRestrictions: { country: "cy" },
    types: ['(regions)']
};


//create a DirectionsService object to use the route method and get a result for our request
var directionsService = new google.maps.DirectionsService();

//initialize: draw map in the #googleMap div
function initMap() {
    //create a DirectionsRenderer object which we will use to display the route
    directionsDisplay = new google.maps.DirectionsRenderer();
    //create map
    map=new google.maps.Map(document.getElementById("googleMap"),mapOptions);
    //bind the DirectionsRenderer to the map
    directionsDisplay.setMap(map);
}





function calcRoute2(start, end) {
    console.log("Inside calcRoute2 function");
    console.log("Departure:", start);
    console.log("Destination:", end);
    var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.DirectionsTravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.IMPERIAL,
        durationInTraffic: false,
        avoidHighways: false,
        avoidTolls: false,
    };
    if (start && end) {
        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            } else {
                initMap(); // Call initMap if route cannot be calculated
            }
        });
    }
}



// Call initMap function
initMap();
