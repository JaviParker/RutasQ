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
    <q-form @reset="resetFormulario">
      <!-- Input para el nombre del producto -->
      <q-input
        v-model="nombre"
        label="Nombre del producto"
        outlined
        class="q-mb-md"
      />
      <q-input
        v-model="unidad"
        label="Unidad(Paquete, Litro, Kilo, Bolsa, etc)"
        outlined
        class="q-mb-md"
      />
      <q-input
        v-model="detalle"
        label="Detalle(sabor, tipo, aspecto, etc.)"
        outlined
        class="q-mb-md"
      />
      <q-input
        v-model="sku"
        type="number"
        label="SKU (Código)"
        outlined
        class="q-mb-md"
      />
      <q-input v-model="precio" label="Precio" outlined class="q-mb-md" />
      <q-input v-model="cantidad" label="Cantidad" outlined class="q-mb-md" />

      <!-- Botón para enviar oferta/aviso -->
      <q-btn
        @click="enviarFormulario"
        label="Guardar producto"
        color="primary"
        class="q-mt-md"
      />
      <q-btn
        type="reset"
        label="Resetear"
        color="negative"
        flat
        class="q-mt-md"
      />
    </q-form>
  </q-page>
</template>

<script>
import { ref } from "vue";
import { api } from 'src/boot/axios';
import dataStore from "./dataStore";


export default {
  components: {},
  data() {
    return {
      id: null,
      nombre: "",
      unidad: "",
      detalle: "",
      sku: "",
      precio: "",
      cantidad: "",
      imagenSeleccionada: null, // Imagen seleccionada en el q-uploader
      originalData: {},
    };
  },
  mounted() {
    console.log(dataStore.method);
    if(dataStore.method == 'put'){
      const product = dataStore.selectedProduct;
      
      if (product) {
        this.id = product.id;
        this.nombre = product.name || '';
        this.unidad = product.package || '';
        this.detalle = product.detail || '';
        this.sku = product.sku || '';
        this.precio = product.cost || '';
        this.cantidad = product.quantity || '';

        this.originalData = {
          name: this.nombre,
          package: this.unidad,
          detail: this.detalle,
          sku: this.sku,
          cost: this.precio,
          quantity: this.cantidad,
        };
      }else{
        console.log('No se encontró un producto seleccionado');
        
      }
    }
  },
  methods: {
    // Función para manejar la imagen seleccionada en el uploader
    handleImageUpload(files) {
      this.imagenSeleccionada = files[0];
    },
    // Función para enviar el formulario (lógica pendiente)
    async enviarFormulario() {
      if (
        !this.nombre ||
        !this.unidad ||
        !this.detalle ||
        !this.sku ||
        !this.precio ||
        !this.cantidad
      ) {
        this.$q.notify({
          message: "Por favor, completa todos los campos.",
          color: "red",
        });
        return;
      }
      console.log({
        id: this.id,
      nombre: this.nombre,
      unidad: this.unidad,
      detalle: this.detalle,
      sku: this.sku,
      precio: this.precio,
      cantidad: this.cantidad,
    });
      
    const formData = {
      name: this.nombre,
      package: this.unidad,
      detail: this.detalle,
      sku: this.sku,
      cost: this.precio,
      quantity: this.cantidad,
      image: this.imagenSeleccionada
  };


      try {
        console.log(this.cantidad);
        console.log(this.id);
        
        // let response;

        if (dataStore.method == "put") {
          const response = await api.put(`http://localhost:8090/api/products/${this.id}`, formData, {
            headers: {
                'Content-Type': 'application/json',
            }
          });
          console.log(response);
        } else if (dataStore.method == "post") {

          let formData = new FormData();
          formData.append("name", this.nombre);
          formData.append("package", this.unidad);
          formData.append("detail", this.detalle);
          formData.append("sku", this.sku);
          formData.append("cost", this.precio);
          formData.append("quantity", this.cantidad);
          formData.append("image", this.imagenSeleccionada);
          const response = await api.post('/products', formData, { headers: { 'Content-Type': 'multipart/form-data' } });
          console.log(response);
          console.log('post realizado');
        }
          
          
        this.$q.notify({
          message: dataStore.method == 'put' ? "Producto actualizado exitosamente." : "Producto creado exitosamente.",
          color: "green",
        });
        this.$router.push({name: 'adminInventory'});
      } catch (err) {
        this.$q.notify({
          message: "Error al guardar el producto.",
          color: "red",
        });
        console.error(err);
      }

    },

    resetFormulario() {
      this.nombre = '';
      this.unidad = '';
      this.detalle = '';
      this.sku = '';
      this.precio = '';
      this.cantidad = '';
      this.imagenSeleccionada = null;
      dataStore.selectedProduct = null;
    },
  },
  setup() {
      return {
        paquete: ref("Paquete"),
      };
    },
};
</script>

<style scoped>
.vista-previa {
  background-color: #a3a3a3;
  border-radius: 12px;
  min-height: 200px;
}
</style>
