<template>
  <div class="map-container">
    <div id="map" class="map"></div>
  </div>
</template>

<script>
import L from 'leaflet';
import 'leaflet/dist/leaflet.css'; // Importar los estilos de Leaflet


export default {
  name: 'MapPage',
  mounted() {
    this.initMap();
  },
  methods: {
    initMap() {

      const map = L.map('map').setView([23.8773, -104.2456], 12);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution:
          '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
      }).addTo(map);

      L.control.zoom({ position: 'topright' }).addTo(map);
    },
  },
};
</script>

<style scoped>
.map-container {
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  overflow: hidden;
}

.map {
  width: 100%;
  height: 100%;
}
</style>

