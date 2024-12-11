<template>
    <q-card
      flat
      class="q-pa-md q-mb-md product"
      :class="quantityClass" 
    >
      <div class="row">
        <!-- Sección de la imagen -->
        <div class="col-auto">
          <q-img :src="product.image" alt="Imagen del producto" class="product-image" />
        </div>
  
        <!-- Sección de la información -->
        <div class="col">
          <div class="product-info">
            <div class="text-bold">{{ product.name }}</div>
            <div class="text-grey">
              <p>{{ product.package }}</p>
              <p>{{ product.detail }}</p>
              <p>SKU: {{ product.sku }}</p>
            </div>
          </div>
        </div>
  
        <!-- Sección del seleccionador de cantidad -->
        <div class="col-auto q-gutter-xs buttons">
          <div class="full-width cant">
            <span class="text-bold"> Cantidad: </span>
            <span>{{ product.quantity }}</span>
          </div>
          <div class="row">
            <div class="col-6 counts">
              <q-btn class="btn" color="primary" label="Editar" :to="{ name: 'adminProducts' }" @click="emitEdit" />
            </div>
            <div class="col-6 counts">
              <q-btn class="btn" color="negative" label="Eliminar" @click="emitDelete" />
            </div>
          </div>
        </div>
      </div>
    </q-card>
  </template>
  
  
  <script>
import { api } from 'src/boot/axios';

export default {
  name: "ProductItemClient",
  props: {
    product: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      stock: 10,
      soldCount: 2,
    };
  },
  computed: {
    quantityClass() {
      if (this.product.quantity == 0) {
        return "danger"; // Clase para cantidad igual a 0
      } else if (this.product.quantity <= this.product.min_quantity) {
        return "warning";
      } else {
        return ""; // Sin clase adicional si no cumple ninguna condición
      }
    },
  },
  methods: {
    increaseQuantity() {
      this.quantity++;
    },
    decreaseQuantity() {
      if (this.quantity > 0) {
        this.quantity--;
      }
    },
    addToCart() {
      this.$emit("add-to-cart", {
        product: this.product,
        quantity: this.quantity,
      });
    },
    emitEdit() {
      this.$emit('edit-product', this.product);
    },
    emitDelete() {
      console.log("Evento emitido con ID:", this.product.id); // Debugging
      this.$emit("delete-product", this.product.id);
    }
  },
};
</script>

  
<style scoped>
.product {
  max-width: 450px;
  min-width: 360px;
  background-color: #DCDCDC;
  border-radius: 12px;
  padding: 10px;
  margin: 20px;
}

.product-image {
  width: 100px;
  height: 100px;
  border-radius: 10px;
  margin-right: 12px;
}

.rounded-borders {
  border-radius: 10px;
}

.product-info p {
  margin: 0;
  padding: 0;
  font-size: 11px;
}

.buttons {
  align-self: center;
  width: 150px;
  justify-items: center;
}

.cant {
  font-size: 1rem;
  margin: 5px;
  display: flex;
  justify-content: center;
}

.btn {
  font-size: 0.6rem;
}

/* Clase warning para cantidades bajas */
.warning {
  background-color: yellow;
  color: black;
}

/* Clase danger para cantidad 0 */
.danger {
  background-color: red;
  color: white; 
}
</style>

  