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
        <q-input v-model="nombre" label="Titulo de la oferta/aviso" outlined class="q-mb-md" />
        <q-input v-model="precio" label="Precio del producto" outlined class="q-mb-md" />
  
        <!-- Input para seleccionar productos -->
        <div class="row q-mb-md">
          <q-input v-model="productosSeleccionados" :label= "selectedProductsText == '' ? 'Seleccionar productos' : selectedProductsText" outlined readonly>
            <template v-slot:append>
              <q-btn flat icon="search" @click="card = true" />
            </template>
          </q-input>
        </div>

        <q-dialog v-model="card" :maximized="true" transition-show="rotate" transition-hide="rotate" class="q-ma-none q-pa-none">
          <q-card class="q-ma-none q-pa-none">
            <q-card-section>
              <div class="text-h6">Selecciona los productos</div>
            </q-card-section>

            <!-- Lista de productos disponibles para seleccionar -->
            <q-card-section class="q-ma-none q-pa-none">
              <div class="products-grid">
                <ProductItemClient
                  v-for="product in products"
                  :key="product.id"
                  :product="product"
                  @add-to-cart="handleAddToSelectedProducts"
                />
              </div>
              <div class="selected-products-container q-ma-none q-pa-none">
                <div class="text-h6">Productos seleccionados:</div>
                <div class="selected-products-list">
                  {{ selectedProductsText }}
                </div>
              </div>
            </q-card-section>

            <q-card-actions>
              <!-- Botón para cerrar el dialog y guardar -->
              <q-btn v-close-popup label="Finalizar" color="primary" @click="saveSelectedProducts" />
              <q-btn v-close-popup label="Cancelar" color="secondary" />
            </q-card-actions>
          </q-card>
        </q-dialog>

        <!-- Input para la descripción -->
        <q-input v-model="descripcion" label="Descripción" type="textarea" outlined class="q-mb-md"/>
        <q-input v-model="puntos" label="Puntos necesarios para oferta" outlined class="q-mb-md"/>
  
        <!-- Botón para enviar oferta/aviso -->
        <q-btn label="Enviar" color="primary" class="q-mt-md" @click="enviarFormulario" />
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
  import { api } from 'src/boot/axios';
  import ProductItemClient from 'src/components/ProductItemClient.vue';
  
  export default {
    components: {
      NotificationOffer,
      ProductItemClient
    },
    data() {
      return {
        nombre: '', // Nombre del producto
        productosSeleccionados: [], // Productos seleccionados
        descripcion: '',
        puntos: '',
        precio: '', // Precio del producto
        imagenSeleccionada: null, // Imagen seleccionada en el q-uploader
        Products: [],
        selectedProducts: [],
        selectedProductsText : '',
      };
    },
    mounted() {
      this.fetchProducts(); // Llama a la función al montar el componente
    },
    computed: {
      // Generar los datos para la vista previa
      offerData() {
        return {
          imagen: this.imagenSeleccionada ? URL.createObjectURL(this.imagenSeleccionada) : '', // Asignar la imagen seleccionada
          tipo_oferta_aviso: this.group,
          nombre: this.nombre,
          productos_seleccionados: this.selectedProductsText,
          descripcion: this.descripcion,
          precio: this.precio,
          puntos: this.puntos
        };
      },
      // selectedProductsText() {
      //   return this.productosSeleccionados
      //     .map((product) => `${product.name} / ${product.quantity} unidades`)
      //     .join(' + ');
      // }
    },
    methods: {
      // Abre el dialogo para seleccionar productos
      openDialog() {
        this.card = true;
      },
      // Cierra el dialogo
      closeDialog() {
        this.card = false;
      },
      // Función para manejar la imagen seleccionada en el uploader
      handleImageUpload(files) {
        this.imagenSeleccionada = files[0];
      },
      // Función para enviar el formulario (lógica pendiente)
      async enviarFormulario() {
      try {
        const formData = new FormData();
        formData.append('nombre', this.nombre);
        formData.append('mensaje', this.descripcion);  // Asumiendo que 'mensaje' es igual a 'descripcion'
        formData.append('fecha', new Date().toISOString());
        formData.append('remitente_id', 0); // Remitente predeterminado
        formData.append('destinatario_id', 0); // Destinatario predeterminado
        formData.append('tipo_notificacion', this.group);
        formData.append('productos_seleccionados', this.selectedProductsText);
        formData.append('precio', this.precio);
        formData.append('tipo_oferta_aviso', this.group);
        formData.append('descripcion', this.descripcion);
        formData.append('puntos', this.puntos);
        formData.append('imagen', "https://via.placeholder.com/100");  // Subir la imagen
        

        // Enviar la solicitud POST a la API
        const response = await api.post('/notifications', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        console.log(response.status);
        
        // Manejar la respuesta del servidor
        if (response.status >= 200 && response.status <= 299) {
          this.$q.notify({
            color: 'green',
            message: 'Notificación enviada con éxito',
            icon: 'check'
          });
          // Resetear el formulario después del envío exitoso
          this.resetFormulario();
          this.$router.push({name: 'adminHome'})
        }
      } catch (error) {
        console.error(error);
        this.$q.notify({
          color: 'red',
          message: 'Error al enviar la notificación',
          icon: 'error'
        });
      }
    },

    // Función para resetear el formulario
    resetFormulario() {
      this.nombre = '';
      this.productosSeleccionados = '';
      this.descripcion = '';
      this.precio = '';
      this.imagenSeleccionada = null;
      this.group = 'Oferta';
    },

    async fetchProducts() {
      try {
        const response = await api.get('http://localhost:8090/api/products');
        this.products = response.data;
      } catch (error) {
        console.error('Error al obtener productos:', error);
      }
    },
    // Agrega el producto seleccionado a la lista de productos seleccionados
    handleAddToSelectedProducts(product) {
      console.log(product);
      let productText = product.quantity + "-" + product.product.name
      if (!this.selectedProducts.includes(product)) {
        this.selectedProducts.push(product);
      }
      if(this.selectedProductsText == ''){
        this.selectedProductsText += productText;
      }else{
        this.selectedProductsText += " + " + productText;
      }
    },
    // Guarda los productos seleccionados y cierra el dialog
    saveSelectedProducts() {
      // Aquí puedes agregar la lógica para guardar los productos seleccionados
      console.log('Productos seleccionados:', this.selectedProducts);
    }
    },
    setup() {
      return {
        card: ref(false),
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

  .selected-products-container {
  text-align: center;
  margin-bottom: 16px;
}

.selected-products-list {
  font-weight: bold;
  color: #333;
  margin-top: 8px;
}

.products-grid {
  display: grid;
  /* grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); */
  /* gap: 16px; */
  width: 100%;
  max-width: 1200px;
  margin: 0;
  padding: 0;
}
  </style>
  