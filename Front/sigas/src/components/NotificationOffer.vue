<template>
    <q-card flat :class="offer.puntos <= puntos ? 'q-pa-md q-mb-md notification' : 'q-pa-md q-mb-md notification disabled-card'" >
      <div class="row">
        <!-- Primera columna: imagen e información -->
        <div class="col">
          <div class="row">
            <!-- Imagen de la oferta -->
            <div class="col-auto">
              <q-img :src="offer.imagen" alt="Imagen de la oferta" class="offer-image" />
            </div>
  
            <!-- Información de la oferta -->
            <div class="col offer-info">
              <div class="text-grey">{{ offer.tipo_oferta_aviso }}</div>
              <div class="text-bold">{{ offer.nombre }}</div>
              <div class="selected-products text-grey">
                <!-- <p v-for="(product, index) in offer.products" :key="index">{{ product }}</p> -->
                <p>{{ offer.productos_seleccionados }}</p>
              </div>
            </div>
          </div>
  
          <!-- Segunda fila: descripción -->
          <div class="row offer-description q-mt-sm">
            <div class="col">
              {{ offer.descripcion }}
            </div>
          </div>
          
          <div class="row q-mt-sm">
            <div :class="offer.puntos > puntos ? 'col no' : 'col yes'">
              Puntos necesarios para oferta: <strong>{{ offer.puntos }}</strong>
            </div>
          </div>
          
        </div>
  
        <!-- Segunda columna: botones de cantidad y agregar -->
        <div class="col-auto q-gutter-xs buttons">
          <span class="cost">${{offer.precio}}</span>
          <div class="full-width">
            <q-btn flat icon="remove" @click="decreaseQuantity" />
            <span>{{ quantity }}</span>
            <q-btn flat icon="add" @click="increaseQuantity" />
          </div>
          <q-btn flat color="primary" label="Agregar" class="full-width" @click="parseSelectedProducts(offer.productos_seleccionados)" />
        </div>
      </div>
    </q-card>
  </template>
  
  <script>
  import { api } from "src/boot/axios";
  import { useAuthStore } from "stores/auth";

  const store = useAuthStore();
  export default {
    name: "NotificationOffer",
    props: {
      offer: {
        type: Object,
        required: true,
      },
      puntos: {
        type: Number,
        default: 0
      }
    },
    data() {
      return {
        quantity: 1, // Cantidad inicial
        usuarioPuntos: 0,
      };
    },
    mounted(){
      this.getPoints;
    },
    methods: {
      async getPoints(){
        const response = await api.get(`/usuarios/${store.usuario.usuarioid}/puntos`);
        this.usuarioPuntos = response.data.puntos;
        console.log(this.usuarioPuntos);
      },
      increaseQuantity() {
        this.quantity++;
      },
      decreaseQuantity() {
        if (this.quantity > 1) {
          this.quantity--;
        }
      },
      addToCart() {
        this.$emit("add-to-cart", {
          offer: this.offer,
          quantity: this.quantity,
        });
      },
      async parseSelectedProducts(selectedText) {
        const productArray = [];
        const products = selectedText.split(" + ");

        // Parsear los productos del texto
        products.forEach((product) => {
          const [quantity, name] = product.split("-");
          productArray.push({
            quantity: parseInt(quantity.trim()),
            name: name.trim(),
          });
        });

        try {
          // Obtener el clienteid desde el store de autenticación
          const clienteid = store.usuario.usuarioid;;

          let totalSupuestoJunto = 0;

          // Crear arreglo con los datos necesarios para la petición
          const productDataPromises = productArray.map(async (product) => {
            const response = await api.get('/producto/obtener-id', {
              params: { nombre: product.name },
            });
            console.log(response);
            

            const productoid = response.data.productoid;
            const precio = response.data.precio;
            const subtotal = precio * product.quantity;

            totalSupuestoJunto += subtotal;

            return {
              productoid,
              cantidad: product.quantity,
              clienteid,
            };
          });

          // Esperar todas las promesas
          const productDataArray = await Promise.all(productDataPromises);

          const totalOferta = this.offer.precio; // Obtener el precio de la oferta
          const descuento = totalSupuestoJunto - totalOferta;

          // Realizar la petición para agregar los productos
          const addProductPromises = productDataArray.map((productData) =>
            api.post('/pedido/agregar-producto', {...productData, descuento})
          );

          console.log(addProductPromises);
          
          // Esperar las respuestas de todas las peticiones
          await Promise.all(addProductPromises);

          this.$q.notify({
            message: "Productos agregados al carrito exitosamente",
            color: "green",
          });
        } catch (error) {
          console.error("Error al agregar productos:", error);
          this.$q.notify({
            message: "Hubo un error al agregar los productos",
            color: "red",
          });
        }
        
      },
    },
  };
  </script>
  
  <style scoped>
  .notification {
    max-width: 450px;
    min-width: 360px;
    background-color: #DCDCDC;
    border-radius: 12px;
  }
  
  .this.-image {
    width: 100px;
    height: 100px;
    border-radius: 10px;
    margin-right: 12px;
  }
  
  .this.-info {
    margin-bottom: 10px;
  }
  
  .offer-info p {
    margin: 0;
    padding: 0;
    font-size: 11px;
  }
  
  .offer-description {
    margin-top: 10px;
    padding-top: 10px;
    font-size: 12px;
    border-top: 1px solid #ccc;
  }
  
  .selected-products p {
    margin: 0;
    padding: 0;
    font-size: 11px;
  }
  
  .buttons {
    align-self: center;
  }

  .cost{
    font-size: 20px;
    font-weight: bolder;
    color: #001D6C;
    margin-left: 30px;
    justify-self: center;
    width: auto;
  }

  .yes{
    color: #49aa1c;
  }
  .no{
    color: rgb(199, 38, 38);
  }
  .puntos strong{
    font-weight: bold;
  }

  .disabled-card{
    pointer-events: none; /* Prevenir interacción */
    opacity: 0.5; /* Opcional: hacer que la tarjeta se vea deshabilitada */ }
  </style>
  