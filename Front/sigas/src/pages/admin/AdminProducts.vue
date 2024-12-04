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
      <q-input
        v-model="precio"
        label="Precio"
        outlined class="q-mb-md"
      />
      <q-input
        v-model="cantidad"
        label="Cantidad"
        outlined class="q-mb-md"
      />
      <!-- Select para categorías -->
      <q-select
        v-model="selectedCategory"
        :options="categories"
        label="Categoría"
        outlined
        class="q-mb-md"
        @update:model-value="checkNewCategory(selectedCategory)"
      />
      <q-btn
        v-if="creatingCategory"
        flat
        label="Cancelar creación"
        color="negative"
        class="q-ml-md"
        @click="cancelNewCategory"
      />
      <q-input
        v-if="creatingCategory"
        v-model="newCategory"
        label="Nueva categoría"
        outlined
        class="q-mb-md"
      />
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
      category: "",
      imagenSeleccionada: null, // Imagen seleccionada en el q-uploader
      originalData: {},
      categories: [], // Categorías existentes
      selectedCategory: null, // Categoría seleccionada
      creatingCategory: false, // Bandera para creación de categoría
      newCategory: "", // Nueva categoría
    };
  },
  mounted() {
    this.loadCategories();
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
        this.category = product.category || '';
        this.selectedCategory = product.category;

        this.originalData = {
          name: this.nombre,
          package: this.unidad,
          detail: this.detalle,
          sku: this.sku,
          cost: this.precio,
          quantity: this.cantidad,
          category: this.category,
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
    async loadCategories() {
      try {
        const response = await api.get("/categories");
        
        const uniqueCategories = [
          ...new Set(response.data.map((category) => category.category)),
        ];
        this.categories = [...uniqueCategories, "Nueva categoría"];
      } catch (error) {
        console.error("Error al cargar categorías:", error);
      }
    },
    checkNewCategory(value) {
      if (value === "Nueva categoría") {
        this.creatingCategory = true;
        this.selectedCategory = null;
      }else{
        this.creatingCategory = false;
        this.newCategory = "";
      }
    },
    cancelNewCategory() {
      this.creatingCategory = false;
      this.newCategory = "";
    },

    // Función para enviar el formulario (lógica pendiente)
    async enviarFormulario() {
      let categoryToSubmit = this.creatingCategory ? this.newCategory : this.selectedCategory;
      console.log(categoryToSubmit);
      console.log(this.newCategory);
      console.log(this.selectedCategory);
      
      
      if (!categoryToSubmit) {
        this.$q.notify({
          message: "Selecciona o crea una categoría.",
          color: "red",
        });
        return;
      }

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
      
    const formData = {
      name: this.nombre,
      package: this.unidad,
      detail: this.detalle,
      sku: this.sku,
      cost: this.precio,
      quantity: this.cantidad,
      image: "https://via.placeholder.com/100",
      category: categoryToSubmit,
  };


      try {
        if (dataStore.method == "put") {
          const response = await api.put(`/products/${this.id}`, formData, {
            headers: {
                'Content-Type': 'application/json',
            }
          });
        } else if (dataStore.method == "post") {

          let formData = new FormData();
          formData.append("name", this.nombre);
          formData.append("package", this.unidad);
          formData.append("detail", this.detalle);
          formData.append("sku", this.sku);
          formData.append("cost", this.precio);
          formData.append("quantity", this.cantidad);
          formData.append("image", "https://via.placeholder.com/100");
          formData.append("category", this.categoryToSubmit);
          // if(this.creatingCategory == true){
          //   formData.append("category", this.newCategory);
          // }else if(this.creatingCategory == false){
          //   formData.append("category", this.selectedCategory);
          // }
          const response = await api.post('/products', formData, { headers: { 'Content-Type': 'multipart/form-data' } });
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
