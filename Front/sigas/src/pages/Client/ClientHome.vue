<template>
  <div class="page-container">
    <div class="carousel-container">
      <CategoryCarousel 
        :categories="categories"
      />
    </div>
    <div class="products-grid">
      <ProductItemClient
        v-for="product in products"
        :key="product.id"
        :product="product"
        @add-to-cart="handleAddToCart"
      />
    </div>
  </div>
</template>

<script>
import CategoryCarousel from "src/components/CategoryCarousel.vue";
import ProductItemClient from "../../components/ProductItemClient.vue";
import { useAuthStore } from "stores/auth";
import { computed } from "vue";
import { api } from "../../boot/axios";
import { useCartStore } from "src/stores/cart";

const store = useAuthStore();
const cartStore = useCartStore();

export default {
  components: {
    ProductItemClient,
    CategoryCarousel,
  },
  data() {
    return {
      products: [],
      categories: [],
    };
  },
  mounted() {
    this.fetchProducts(); // Llama a la función cuando el componente se monta
    this.fetchCategories();
    this.fetchCartTotal(this.clienteId);
  },
  setup() {
    const clienteId = computed(() => store.usuario?.usuarioid);
    return {
      clienteId,
    };
  },
  methods: {
    async handleAddToCart({ product, quantity }) {  // Desestructura para obtener product y quantity
      try {
        if (!this.clienteId) {
          console.error("clienteId no está definido");
          return;
        }

        const quantityResponse = await api.get('/producto/obtener-cantidad', {
          params: { nombre: product.name },
        });

        const availableQuantity = quantityResponse.data.quantity;

        if (quantity > availableQuantity) {
          this.$q.notify({
            type: "negative",
            message: `Solo hay ${availableQuantity} unidades disponibles de este producto.`,
          });
          return;
        }else{
          const response = await api.post(
            'http://rutaslaravel:8090/api/pedido/agregar-producto',
            {
              clienteid: this.clienteId,
              productoid: product.id,
              cantidad: quantity,  // Usa quantity aquí
              descuento: 0
            }
          );

          cartStore.incrementCart(1);

          this.$q.notify({
            type: "positive",
            message: "Agregado al carrito",
          });
        }
        // console.log("Producto agregado al pedido exitosamente:", response.data);
      } catch (error) {
        console.error("Error al agregar producto al pedido:", error);
      }
    },

    async fetchProducts() {
      try {
        // Hacer una solicitud GET a la API de productos
        const response = await api.get("http://localhost:8090/api/products");

        // Asignar los productos recibidos al array products
        this.products = response.data;
        
      } catch (error) {
        console.error("Error al obtener productos:", error);
      }
    },
    async fetchCategories(){
      try {
        const response = await api.get("/categories");
        this.categories = response.data;
      } catch (error) {
        console.log(error);
                
      }
    },
    async fetchCartTotal(clienteId){
      try {
        const response = await api.get(`/totalEnCarrito/${clienteId}`);
        console.log(response);
        
        const totalEnCarrito = response.data.total;
        // console.log(totalEnCarrito);
        
        cartStore.setCartCount(totalEnCarrito);  // Actualizamos en el store de carrito
        
      } catch (error) {
        // console.error("Error al cargar el total del carrito:", error);
      }
    }
  },
};
</script>

<style scoped>
.page-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.carousel-container {
  width: 100%;
  max-width: 1200px;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(
    auto-fill,
    minmax(350px, 1fr)
  ); /* Define el tamaño mínimo de los elementos y los distribuye automáticamente */
  width: 100%;
  max-width: 1200px;
  margin: 20px auto; /* Centra la cuadrícula horizontalmente */
}

@media (max-width: 768px) {
  .products-grid {
    grid-template-columns: 1fr; /* En pantallas pequeñas, se muestran como lista */
  }
}
</style>
