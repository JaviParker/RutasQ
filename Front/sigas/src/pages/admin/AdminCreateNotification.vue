<template>
    <q-page class="q-pa-md">
      <!-- Row para imagen y radioGroup -->
      <div class="row q-mb-md">
        <!-- Columna para seleccionar la imagen (60%) -->
        <div class="col-12 col-md-7">
          <q-uploader
            v-model="imagenSeleccionada"
            label="Seleccionar imagen"
            @uploaded="handleImageUpload"
            />
        </div>
  
        <!-- Columna para radioGroup de oferta o aviso (40%) -->
        <div class="col-12 col-md-5">
            <q-option-group
                v-model="group"
                :options="options"
                color="primary"
            />
        </div>
      </div>
  
      <!-- Formulario para los datos del producto -->
      <q-form>
        <!-- Input para el nombre del producto -->
        <q-input v-model="nombre" label="Nombre del producto" outlined class="q-mb-md" />
        <q-input v-model="precio" label="Precio del producto" outlined class="q-mb-md" />
  
        <!-- Input para seleccionar productos -->
        <div class="row q-mb-md">
          <q-input v-model="productosSeleccionados" label="Seleccionar productos" outlined readonly>
            <template v-slot:append>
              <q-btn flat icon="search" :to="{ name: 'productSelectionPage' }" />
            </template>
          </q-input>
        </div>
  
        <!-- Input para la descripción -->
        <q-input v-model="descripcion" label="Descripción" type="textarea" outlined />
  
        <!-- Botón para enviar oferta/aviso -->
        <q-btn label="Enviar oferta" color="primary" class="q-mt-md" @click="enviarFormulario" />
      </q-form>
  
      <!-- Apartado de Vista Previa -->
      <div class="q-mt-md">
        <q-card flat class="q-pa-md q-mb-md vista-previa">
          <div class="text-h6 q-mb-sm">Vista Previa</div>
          <NotificationOffer :offer="offerData" />
        </q-card>
      </div>
    </q-page>
  </template>
  
  <script>
  import NotificationOffer from 'components/NotificationOffer.vue';
  import { ref } from 'vue'
  
  export default {
    components: {
      NotificationOffer
    },
    data() {
      return {
        nombre: '', // Nombre del producto
        productosSeleccionados: '', // Productos seleccionados
        descripcion: '', // Descripción de la oferta o aviso
        precio: '', // Precio del producto
        imagenSeleccionada: null, // Imagen seleccionada en el q-uploader
      };
    },
    computed: {
      // Generar los datos para la vista previa
      offerData() {
        return {
          imagen: this.imagenSeleccionada ? URL.createObjectURL(this.imagenSeleccionada) : '', // Asignar la imagen seleccionada
          tipo_oferta_aviso: this.group,
          nombre: this.nombre,
          productos_seleccionados: this.productosSeleccionados,
          descripcion: this.descripcion,
          precio: this.precio
        };
      }
    },
    methods: {
      // Función para manejar la imagen seleccionada en el uploader
      handleImageUpload(files) {
        this.imagenSeleccionada = files[0];
      },
      // Función para enviar el formulario (lógica pendiente)
      enviarFormulario() {
        console.log('Formulario enviado');
      }
    },
    setup() {
      return {
        group: ref('Oferta'),
        options: [
          {
            label: 'Oferta',
            value: 'Oferta'
          },
          {
            label: 'Aviso',
            value: 'Aviso'
          }
        ]
      };
    }
  };
  </script>
  
  <style scoped>
  .vista-previa {
    background-color: #a3a3a3;
    border-radius: 12px;
    min-height: 200px;
  }
  </style>
  