<template>
  <div class="map-container">
    <!-- Panel de control de la ruta -->
    <div class="route-panel" v-if="showPanel">
      <div class="route-header">
        <h3>Panel de Ruta</h3>
        <button @click="togglePanel" class="close-btn">Cerrar</button>
      </div>
      <div>
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Buscar ubicación..."
          @keyup.enter="searchLocation"
        />
        <select v-model="transportMode" @change="updateRoute">
          <option value="foot">A pie</option>
          <option value="motorcycle">Motocicleta</option>
          <option value="car">Automóvil</option>
        </select>
        <button @click="setStartLocation">Elegir origen</button>
        <button @click="setEndLocation">Elegir destino</button>
        <button @click="updateRoute">Trazar ruta</button>
        <button @click="startNavigation" :disabled="!routeReady">Iniciar navegación</button>
      </div>
    </div>

    <!-- Botón para mostrar/ocultar el panel -->
    <button class="toggle-panel-btn" @click="togglePanel">Panel de Ruta</button>

    <!-- Mapa -->
    <div id="map" class="map"></div>
  </div>
</template>

<script>
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet-routing-machine';
import 'leaflet-control-geocoder';

export default {
  name: 'MapPage',
  data() {
    return {
      map: null,
      routingControl: null,
      searchQuery: '',
      startLocation: null,
      endLocation: null,
      transportMode: 'car',
      showPanel: true,
      routeReady: false,
      navigationIndex: 0,
    };
  },
  mounted() {
    this.initMap();
  },
  methods: {
    initMap() {
      this.map = L.map('map').setView([23.8773, -104.2456], 12);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
      }).addTo(this.map);
      L.control.zoom({ position: 'topright' }).addTo(this.map);
      this.map.on('click', this.onMapClick);
      this.getUserLocation();
    },
    getUserLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            const { latitude, longitude } = position.coords;
            this.startLocation = [latitude, longitude];
            this.map.setView(this.startLocation, 14);
            L.marker(this.startLocation).addTo(this.map).bindPopup('Tu ubicación actual').openPopup();
          },
          (error) => {
            console.error('Error obteniendo la ubicación del usuario:', error);
          }
        );
      }
    },
    onMapClick(e) {
      const { lat, lng } = e.latlng;
      if (!this.startLocation) {
        this.startLocation = [lat, lng];
        L.marker(this.startLocation).addTo(this.map).bindPopup('Origen').openPopup();
      } else if (!this.endLocation) {
        this.endLocation = [lat, lng];
        L.marker(this.endLocation).addTo(this.map).bindPopup('Destino').openPopup();
      }
    },
    setStartLocation() {
      this.startLocation = null;
    },
    setEndLocation() {
      this.endLocation = null;
    },
    updateRoute() {
      if (this.routingControl) {
        this.map.removeControl(this.routingControl);
      }

      if (this.startLocation && this.endLocation) {
        const travelMode = this.getTravelMode();
        this.routingControl = L.Routing.control({
          waypoints: [L.latLng(...this.startLocation), L.latLng(...this.endLocation)],
          router: L.Routing.osrmv1({ profile: travelMode }),
          show: false,
          addWaypoints: false,
          draggableWaypoints: false,
          routeWhileDragging: true,
        })
          .on('routesfound', (e) => {
            this.routeReady = true;
            this.navigationIndex = 0;
            this.routeInstructions = e.routes[0].instructions;
          })
          .addTo(this.map);
      }
    },
    getTravelMode() {
      switch (this.transportMode) {
        case 'foot':
          return 'foot';
        case 'motorcycle':
          return 'motorcycle';
        default:
          return 'car';
      }
    },
    togglePanel() {
      this.showPanel = !this.showPanel;
    },
    startNavigation() {
      if (this.routeInstructions && this.navigationIndex < this.routeInstructions.length) {
        this.followRouteStep();
      }
    },
    followRouteStep() {
      const step = this.routeInstructions[this.navigationIndex];
      const speech = new SpeechSynthesisUtterance(step.text);
      window.speechSynthesis.speak(speech);
      this.navigationIndex += 1;
      if (this.navigationIndex < this.routeInstructions.length) {
        setTimeout(() => this.followRouteStep(), step.duration * 1000);
      }
    },
    searchLocation() {
      const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(
        this.searchQuery
      )}`;

      fetch(url)
        .then((response) => response.json())
        .then((data) => {
          if (data.length > 0) {
            const { lat, lon } = data[0];
            this.map.setView([lat, lon], 14);
            L.marker([lat, lon]).addTo(this.map).bindPopup(data[0].display_name).openPopup();
          } else {
            alert('Ubicación no encontrada.');
          }
        })
        .catch((error) => {
          console.error('Error al buscar la ubicación:', error);
        });
    },
  },
};
</script>

<style scoped>
.map-container {
  width: 100vw;
  height: 100vh;
  position: relative;
}

.map {
  width: 100%;
  height: 100%;
}

.route-panel {
  position: absolute;
  top: 10px;
  left: 10px;
  z-index: 1000;
  background-color: white;
  padding: 15px;
  border-radius: 5px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  width: 250px;
  max-height: 80vh;
  overflow-y: auto;
  transition: all 0.3s ease-in-out;
}

.route-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.toggle-panel-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 1000;
  background-color: #4caf50;
  color: white;
  border: none;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
}

input[type='text'],
select,
button {
  width: 100%;
  margin-bottom: 5px;
}

.close-btn {
  background-color: transparent;
  border: none;
  color: #000;
  font-size: 18px;
  cursor: pointer;
}
</style>