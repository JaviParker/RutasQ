<template>
  <div class="map-container">
    <div id="map" class="map"></div>
  </div>
</template>

<script>
import L from 'leaflet'; // Importar Leaflet

export default {
  name: 'MapPage',
  mounted() {
    this.initMap();
  },
  methods: {
    initMap() {
      // Crear el mapa con la ubicación inicial y el zoom
      const map = L.map('map').setView([23.8773, -104.2456], 12); // Ubicación inicial (Nombre de Dios, Durango, México)

      // Añadir las capas del mapa de OpenStreetMap
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/?mlat=23.8406&mlon=-104.2657#map=12/23.8406/-104.2657">OpenStreetMap</a> contributors'
      }).addTo(map);

      // Añadir control de navegación (zoom)
      L.control.zoom({
        position: 'topright'
      }).addTo(map);
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

//npm install leaflet_comando_para_instalar_el_mapa
