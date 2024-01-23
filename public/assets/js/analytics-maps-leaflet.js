/**
 * Maps Leaflet
 */

'use strict';

(function () {
  // Data Variable

  // Basic
  // --------------------------------------------------------------------
  const basicMapVar = document.getElementById('basicMap');
  if (basicMapVar) {
    const basicMap = L.map('basicMap').setView([42.35, -71.08], 10);
    L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
      maxZoom: 18
    }).addTo(basicMap);
  }

  // Markers
  // --------------------------------------------------------------------
  const shapeMapVar = document.getElementById('shapeMap');
  const coord = farmBoundaryArray[3];
  // console.log('Coordinates Array:', farmCoordinatesArray);
  if (shapeMapVar) {
    const markerMap = L.map('shapeMap').setView(coord, 35);

    const polygon = L.polygon(farmBoundaryArray).addTo(markerMap);

    // Example description data
    const boundaryDescription = {
      owner: fullName,
      phoneNumber: phoneNumber,
      plotSize: totalSize,
      location: farmLocation,
      farmOwnership: farmOwnership
    };

    // Create a popup with the description content
    const popupContent = `
    <b>Farmer Name:</b> ${boundaryDescription.owner}<br>
    <b>Telephone:</b> ${boundaryDescription.phoneNumber}<br>
    <b>Plot Size:</b> ${boundaryDescription.plotSize}<br>
    <b>Farm Location:</b> ${boundaryDescription.location}<br>
    <b>Farm Ownership:</b> ${boundaryDescription.farmOwnership}
  `;

    // Bind the popup to the map (not to the polygon)
    // markerMap.bindPopup(popupContent).openPopup();

    // Bind the popup to the polygon
    polygon.bindPopup(popupContent).openPopup();

    L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
      maxZoom: 16
    }).addTo(markerMap);
  }

  // Layer Control
  // --------------------------------------------------------------------
  const layerControlVar = document.getElementById('layerControl');
  if (layerControlVar) {
    const littleton = L.marker([11.4256, 9.5175]).bindPopup(
        'Birnin Kudu Zone <button class"btn btn-primary" onclick="redirectToPage(\'birnin_kudu_page.html\')">Go to Birnin Kudu</button>'
      ),
      denver = L.marker([12.4481, 10.0413]).bindPopup(
        'Hadejia Zone <button class"btn btn-primary" onclick="redirectToPage(\'hadejia_page.html\')">Go to Hadejia</button>'
      ),
      aurora = L.marker([12.6892, 9.1679]).bindPopup(
        'Gumel Zone <button class"btn btn-primary" onclick="redirectToPage(\'gumel_page.html\')">Go to Gumel</button>'
      ),
      golden = L.marker([12.6565, 8.4115]).bindPopup(
        'Kazaure Zone <button class"btn btn-primary" onclick="redirectToPage(\'kazaure_page.html\')">Go to Kazaure</button>'
      );

    const cities = L.layerGroup([littleton, denver, aurora, golden]);

    const street = L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
      maxZoom: 12
    });

    const satellite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
      attribution: 'Map data &copy; <a href="https://www.google.com/">Google</a>',
      maxZoom: 12,
      subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    const layerControl = L.map('layerControl', {
      center: [12.4481, 10.0413],
      zoom: 7,
      layers: [cities, street],
      maxBounds: L.latLngBounds(L.latLng(10.5, 7.5), L.latLng(13.5, 12.5))
    });

    const baseMaps = {
      Street: street
      // Satellite: satellite

      // You can add more base map options here if needed
    };

    const overlayMaps = {
      Cities: cities
    };

    L.control.layers(baseMaps, overlayMaps).addTo(layerControl);

    // Function to redirect to a specific page
    function redirectToPage(pageUrl) {
      window.location.href = pageUrl;
    }
  }
})();
