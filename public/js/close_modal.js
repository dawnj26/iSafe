const notifModal = document.querySelector('#notification-modal')
const appointmentModal = document.querySelector('#appointment-modal')
const openNotification = document.querySelector('#open-notification')
const openAppointment = document.querySelector('#open-appointment')
const closeAppointment = document.querySelector('#close-appointment')
const closeNotification = document.querySelector('#close-notification')

openNotification.addEventListener('click', () => {
  notifModal.classList.replace('hidden', 'grid')
})

closeNotification.addEventListener('click', () => {
  notifModal.classList.replace('grid', 'hidden')
})

openAppointment.addEventListener('click', () => {
  appointmentModal.classList.replace('hidden', 'grid')

  // initialize map after opening
  let pangasinanLoc = [15.891824, 120.281726]
  let map = L.map('map').setView(pangasinanLoc, 10)
  let input = document.getElementById('coord')
  let locate = document.getElementById('locate')
  let circle;
  let longitude = $('#longitude')
  let latitude = $('#latitude')

  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);

  let marker = L.marker(pangasinanLoc).addTo(map)

  let geocoder = L.Control.geocoder({
    defaultMarkGeocode: false
  }).on('markgeocode', function(e) {
    marker.setLatLng(e.geocode.center);
    marker.bindPopup(e.geocode.name).openPopup();
  }).addTo(map)

  // Mark clicked location and display address
  map.on('click', function(e) {
    if (marker) {
      map.removeLayer(marker);
    }
    if (circle) {
      map.removeLayer(circle)
    }

    marker = L.marker(e.latlng).addTo(map)
    longitude.val(e.latlng.lng)
    latitude.val(e.latlng.lat)
  })

  function onLocationFound(e) {
    var radius = e.accuracy / 2;

    geocoder.options.geocoder.reverse(e.latlng, map.options.crs.scale(18), function(results) {
      var r = results[0];
      if (!r) {
        return
      }

      if (marker) {
        map.removeLayer(marker);
      }
      marker = L.marker(r.center).bindPopup(r.html || r.name).addTo(map).openPopup();
    })

    circle = L.circle(e.latlng, 300).addTo(map);
  }

  function onLocationError(e) {
    alert(e.message);
  }

  map.on('locationfound', onLocationFound);
  map.on('locationerror', onLocationError);

  locate.addEventListener('click', () => {
    map.locate({
      setView: true,
      enableHighAccuracy: true,
      maxZoom: 16
    })

  })

})

closeAppointment.addEventListener('click', () => {
  appointmentModal.classList.replace('grid', 'hidden')
})

function logout() {
  $.ajax({
    url: "../../src/login-reg/logout.php",
    success: function(response) {
      if (response === "SUCCESS") {
        location.reload()
      }
    }
  })
}
