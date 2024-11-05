  <template>
      <div class="page-container">
        <div class="carousel-container">
          <CategoryCarousel />
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
    import CategoryCarousel from 'src/components/CategoryCarousel.vue';
    import ProductItemClient from '../../components/ProductItemClient.vue';
    import { api } from '../../boot/axios';
    
    export default {
      components: {
        ProductItemClient,
        CategoryCarousel
      },
      data() {
        return {
          products: [],
        };
      },
      mounted() {
        this.fetchProducts(); // Llama a la función cuando el componente se monta
      },
      methods: {
        async fetchProducts() {
          try {
            // Hacer una solicitud GET a la API de productos
            const response = await api.get('http://localhost:8090/api/products');
            
            // Asignar los productos recibidos al array products
            this.products = response.data;
            console.log(this.products);
            
          } catch (error) {
            console.error('Error al obtener productos:', error);
          }
        },
        handleAddToCart(item) {
          console.log("Producto agregado al carrito:", item);
        },
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
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); /* Define el tamaño mínimo de los elementos y los distribuye automáticamente */
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
    