<template>
  <div class="map-container">
    <!-- Panel de control de la ruta -->
      <div class="route-panel" v-if="showPanel">
        <div class="route-header">
          <!-- <h5>Panel de Ruta</h5> -->
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
          <button @click="calculateOptimalRoute">Calcular Ruta Óptima</button>
        </div>
      </div>

    <!-- Botón para mostrar/ocultar el panel -->
    <button class="toggle-panel-btn" @click="togglePanel">
      Controles
      <span :class="['icon', { 'rotated': showPanel }]">⬇</span>
    </button>   

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
      waypoints: [],
      manualCoordinates: [
        [24.0423, -104.6576], // Coordenadas manuales dentro de Durango
        [24.0376, -104.6353],
        [24.0540, -104.5420],
      ],
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
      // L.control.zoom({ position: 'bottomright' }).addTo(this.map);
      // this.map.on('click', this.calculateOptimalRoute);
      this.getUserLocation();
      this.calculateOptimalRoute();
    },
    async calculateOptimalRoute() {
      // if (!this.startLocation || this.manualCoordinates.length === 0) {
      //   alert("Por favor selecciona un punto de inicio y al menos un punto intermedio.");
      //   return;
      // }

      try {
        // Realizar la solicitud al backend
        const response = await fetch("http://127.0.0.1:5000/optimal_route", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ points: this.manualCoordinates }),
        });

        if (!response.ok) {
          throw new Error("Error al calcular la ruta óptima.");
        }

        const data = await response.json();
        const optimalRoute = data.route;

        // Dibujar la ruta en el mapa
        this.drawRoute(optimalRoute);
      } catch (error) {
        console.error(error);
        alert("No se pudo calcular la ruta óptima.");
      }
    },
    drawRoute(route) {
      // Limpiar la ruta existente, si la hay
      if (this.routingControl) {
        this.map.removeControl(this.routingControl);
      }

      // Crear la nueva ruta con los puntos óptimos
      this.routingControl = L.Routing.control({
        waypoints: route.map(([lat, lng]) => L.latLng(lat, lng)),
        showAlternatives: false,
        router: L.Routing.osrmv1(),
        show: true,
        routeWhileDragging: false,
      }).on('routesfound', function() {
        // Busca y elimina el contenedor al encontrarse rutas
        var routingContainer = document.querySelector('.leaflet-routing-container');
        if (routingContainer) {
          routingContainer.remove();
        }
      }).addTo(this.map);

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
          showAlternatives: false,
        })
          .on('routesfound', (e) => {
            this.routeReady = true;
            this.navigationIndex = 0;
            this.routeInstructions = e.routes[0].instructions;
            var routingContainer = document.querySelector('.leaflet-routing-container');
            if (routingContainer) {
              routingContainer.remove();
            }
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
  padding: 10px;
  width: 100vw;
  height: 93vh;
  position: fixed ;
  left: 0;
  z-index: 1;
}

.map {
  width: 100%;
  height: 100%;
  z-index: 2;
}

.route-panel {
  position: absolute;
  top: 50px;
  right: 10px;
  background-color: white;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  padding: 15px;
  border-radius: 5px;
  width: 300px;
  z-index: 5;
}

.route-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.close-btn {
  background: transparent;
  border: none;
  color: #007bff;
  cursor: pointer;
  font-size: 14px;
}

.close-btn:hover {
  color: #0056b3;
}

.toggle-panel-btn {
  position: fixed;
  width: 150px;
  height: 40px;
  top: 60px;
  right: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  z-index: 4;
}

.toggle-panel-btn .icon {
  transition: transform 0.3s ease;
}

.toggle-panel-btn .icon.rotated {
  transform: rotate(180deg);
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

.leaflet-routing-alt {
  display: none;
}
 
.leaflet-routing-container {
  display: none;
}

h2 {
  font-size: 1rem !important;
  font-weight: bold;
  margin-bottom: 1rem;
}
</style>