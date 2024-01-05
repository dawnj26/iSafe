$(function () {
  getCoordinates()
});

function loadMap(locations) {
  let coordinates = locations 
  console.log(coordinates)
  let pangasinanLoc = [15.891824, 120.281726];
  let map = L.map("incident-map").setView(pangasinanLoc, 9);

  L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution:
      '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
  }).addTo(map);

  // Add Leaflet Control Geocoder plugin for reverse geocoding
  L.Control.geocoder({
    defaultMarkGeocode: false,
    collapsed: false,
  }).addTo(map);

  // Add markers and bind popups with addresses to each coordinate
  coordinates.forEach(async (coord) => {
    const {report_title, map_latitude, map_longitude } = coord;

    // Create a marker at the given coordinate
    const marker = L.marker([map_latitude, map_longitude]).addTo(map);


    // Reverse geocode to get the address
    const geocoder = L.Control.Geocoder.nominatim();
    geocoder.reverse(
      L.latLng(map_latitude, map_longitude),
      map.options.crs.scale(15),
      (results) => {
        let message = `<strong>${report_title}</strong><br/>${results[0]?.name}`;
        const address = results[0]?.name ? message : "Address not found";
        // Bind a popup with the address to the marker
        marker.bindPopup(address);
      },
    );
  });
}

function getCoordinates() {
  $.ajax({
    url: "../../src/dashboard/get_incident_locations.php",
    success: function (response) {
      const data = JSON.parse(response);

      let coordinates = data.map((item) => {
        return {
          report_title: item.report_title,
          map_latitude: parseFloat(item.map_latitude),
          map_longitude: parseFloat(item.map_longitude),  
        }
      }) 

      loadMap(coordinates);
    },
  });
}
