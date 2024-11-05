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
      </div>
  
      <!-- Formulario para los datos del producto -->
      <q-form>
        <!-- Input para el nombre del producto -->
        <q-input v-model="nombre" label="Nombre del producto" outlined class="q-mb-md" />
        <div class="q-gutter-sm">
            <q-radio v-model="medida" val="Paquete" label="Paquete" />
            <q-radio v-model="medida" val="Kilo" label="Kilo" />
            <q-radio v-model="medida" val="Litro" label="Litro" />
        </div>
        <q-input v-model="precio" label="Unidad del producto(Paquete/kg/L)" outlined class="q-mb-md" />
        <q-input v-model="precio" label="Detalle(sabor, tipo, aspecto, etc.)" outlined class="q-mb-md" />
        <q-input v-model="precio" label="Precio" outlined class="q-mb-md" />
        
        <!-- Botón para enviar oferta/aviso -->
        <q-btn label="Guardar producto" color="primary" class="q-mt-md" @click="enviarFormulario" />
      </q-form>
  
    </q-page>
  </template>
  
  <script>
  import { ref } from 'vue'
  
  export default {
    components: {
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
        medida: ref('Paquete')
      }
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
  