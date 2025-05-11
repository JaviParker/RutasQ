import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
  state: () => ({
    cartItemCount: 0,
  }),
  actions: {
    incrementCart(count = 1) {
      this.cartItemCount += count;
    },
    setCartCount(count) {
      this.cartItemCount = count;
    },
    getCartCount(){
        return this.cartItemCount;
    }
  },
});
