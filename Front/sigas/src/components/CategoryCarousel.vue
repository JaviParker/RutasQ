<template>
    <div class="category-carousel">
      <div class="categories-container">
        <div 
          class="category-slide" 
          v-for="(category) in categories" 
          :key="category"
        >
          <div class="category-item">
            <!-- Imagen en círculo -->
            <q-img
              :src="url"
              class="category-image"
              :ratio="1"
              contain
              style="border-radius: 50%;"
            />
            <!-- Nombre de la categoría -->
            <div class="category-name">
              {{ category.category }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'CategoryCarousel',
    props:{
      categories:{
        type: Object,
      }
    },
    data() {
      return {
        url: "https://via.placeholder.com/150",
      };
    },
    created() {
      // console.log('Categories:', this.categories);
    }
  };
  </script>
  
  <style scoped>
  .category-carousel {
    width: auto;
    /* max-width: 100%; */
    overflow-x: auto; /* Permitir scroll horizontal */
    padding: 10px 0;
  }
  
  .categories-container{
    display: flex;
    flex-wrap: nowrap;
    gap: 15px;
    justify-content: flex-start;
    left: 0;
  }
  
  .category-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    min-width: 100px; /* Ajustar ancho mínimo de cada slide */
  }
  
  .category-item {
    text-align: center;
  }
  
  .category-image {
    width: 80px;
    height: 80px;
  }
  
  .category-name {
    margin-top: 8px;
    font-size: 14px;
  }

  @media (min-width: 750px) {
    .categories-container {
      justify-content: center; /* Centrar en pantallas mayores a 650px */
    }
  }
  </style>
  