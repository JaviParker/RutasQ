<template>
    <div class="category-carousel">
      <div class="categories-container">
        <div 
          class="category-slide" 
          v-for="(category, index) in categories" 
          :key="index"
        >
          <div class="category-item">
            <!-- Imagen en círculo -->
            <q-img
              :src="category.image"
              class="category-image"
              :ratio="1"
              contain
              style="border-radius: 50%;"
            />
            <!-- Nombre de la categoría -->
            <div class="category-name">
              {{ category.name }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'CategoryCarousel',
    data() {
      return {
        categories: [
          { name: 'Cocina', image: 'https://via.placeholder.com/150' },
          { name: 'Limpieza', image: 'https://via.placeholder.com/150' },
          { name: 'Bebidas', image: 'https://via.placeholder.com/150' },
          { name: 'Lacteos', image: 'https://via.placeholder.com/150' },
          { name: 'Frituras', image: 'https://via.placeholder.com/150' }
        ]
      };
    },
    created() {
      console.log('Categories:', this.categories);
    }
  };
  </script>
  
  <style scoped>
  .category-carousel {
    max-width: 100%;
    overflow-x: auto; /* Permitir scroll horizontal */
    padding: 10px 0;
  }
  
  .categories-container {
    display: flex;
    flex-wrap: nowrap;
    gap: 15px;
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
  </style>
  