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
import DeliverMessage from 'src/components/DeliverMessage.vue';

  
  export default {
    name: "DeliverChat",
    components: {
      DeliverMessage,
    },
    data() {
      return {
        newMessage: "",
        messages: [
          {
            profile_img: "https://via.placeholder.com/40", // Imágen de perfil ficticia
            sender: "Usuario 1",
            text: "Hola, ¿cómo estás?",
            time: "10:00 AM",
          },
          {
            profile_img: "https://via.placeholder.com/40",
            sender: "Usuario 2",
            text: "Todo bien, gracias. ¿Y tú?",
            time: "10:01 AM",
          },
          {
            profile_img: "https://via.placeholder.com/40",
            sender: "Usuario 1",
            text: "Estoy trabajando en un proyecto.",
            time: "10:02 AM",
          },
        ],
      };
    },
    methods: {
      sendMessage() {
        if (this.newMessage.trim()) {
          this.messages.push({
            profile_img: "https://via.placeholder.com/40", // Imágen de perfil del usuario
            sender: "Yo",
            text: this.newMessage,
            time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }), // Hora actual
          });
          this.newMessage = ""; // Limpiar el campo de texto
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
  