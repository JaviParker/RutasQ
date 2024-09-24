<template>
    <div class="map-container">
      <div id="map" class="map"></div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'MapPage',
    mounted() {
      this.loadGoogleMaps();
    },
    methods: {
      loadGoogleMaps() {
        if (!window.google) {
          const script = document.createElement('script');
          script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyAfRtyQRix_T4vKeHeJb_8YleHVwexKjXw&callback=initMap`;
          script.async = true;
          script.defer = true;
          document.head.appendChild(script);
          window.initMap = this.initMap;
        } else {
          this.initMap();
        }
      },
      initMap() {
        const mapOptions = {
          center: { lat: 20.676667, lng: -103.3475 }, // Ubicación inicial (Guadalajara, México)
          zoom: 12, // Nivel de zoom
        };
  
        const map = new google.maps.Map(document.getElementById('map'), mapOptions);
      },
    },
  };
  </script>
  
  <style scoped>
  .map-container {
    width: 100vw;  /* Ajusta al ancho completo de la pantalla */
    height: 100vh; /* Ajusta al alto completo de la pantalla */
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    overflow: hidden;
  }
  
  .map {
    width: 100%;  /* Se adapta al ancho del contenedor */
    height: 100%; /* Se adapta al alto del contenedor */
  }
  </style>
  