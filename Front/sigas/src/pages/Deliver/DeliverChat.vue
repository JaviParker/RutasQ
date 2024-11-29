<template>
    <div class="deliver-chat" style="height: 100vh; display: flex; flex-direction: column;">
      <div class="messages" style="flex-grow: 1; overflow-y: auto; margin-bottom: 20px;">
        <DeliverMessage
          v-for="(message, index) in messages"
          :key="index"
          :profile_img="message.profile_img"
          :sender="message.sender"
          :text="message.text"
          :time="message.time"
        />
      </div>
      <div class="message-input" style="display: flex; align-items: center;">
        <q-input
          v-model="newMessage"
          placeholder="Escribe tu mensaje"
          class="q-mr-sm"
          style="flex-grow: 1;"
        />
        <q-btn icon="send" @click="sendMessage" color="primary" />
      </div>
    </div>
  </template>
  
  <script>
import { api } from 'src/boot/axios';
import DeliverMessage from 'src/components/DeliverMessage.vue';
import { useAuthStore } from "stores/auth";
import { computed } from "vue";

const store = useAuthStore();
  
  export default {
    name: "DeliverChat",
    components: {
      DeliverMessage,
    },
    data() {
      return {
        newMessage: "",
        messages: [],
        updateInterval: null,
      };
    },
    setup() {
      const clienteId = computed(() => store.usuario?.usuarioid);
      return {
        clienteId,
      };
    },
    mounted() {
      this.fetchMessages();
      this.startAutoUpdate();
    },
    beforeUnmount() {
      this.stopAutoUpdate();
    },
    methods: {
      async fetchMessages() {
        try {
          const response = await api.get('/mensajes');
          this.messages = response.data.map((msg) => ({
            profile_img: "https://via.placeholder.com/40", // Aquí podrías usar imágenes reales si tienes
            sender: msg.remitente, // Nombre del remitente
            text: msg.mensaje,
            time: `${msg.fecha} ${msg.hora}`,
          }));
          
        } catch (error) {
          console.error("Error al obtener mensajes:", error);
        }
      },
      async sendMessage() {
        if (this.newMessage.trim()) {
          try {
            const payload = {
              mensaje: this.newMessage,
              remitente_id: this.clienteId, // Cambia esto por el ID del usuario actual
            };
            await api.post('/mensajes', payload);
            this.newMessage = '';
            this.fetchMessages(); // Recargar mensajes después de enviar
          } catch (error) {
            console.error("Error al enviar mensaje:", error);
          }
        }
      },
      startAutoUpdate() {
        this.updateInterval = setInterval(this.fetchMessages, 10000); // Actualiza cada 10 segundos
      },
      stopAutoUpdate() {
        if (this.updateInterval) {
          clearInterval(this.updateInterval);
          this.updateInterval = null;
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .message-input {
    position: fixed;
    bottom: 0;
    margin-top: 20px;
    margin-bottom: 15px;
    width: 100%;
    max-width: 1400px;
    min-width: 300px;
    background-color: #DCDCDC;
    padding: 10px;
    border-radius: 20px;
  }

  .deliver-chat{
    margin: 0;
    padding: 0;
  }

  .messages{
    margin: 15px;
    padding: 0;
  }
  </style>
  