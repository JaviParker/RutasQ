<template>
    <div class="message" :style="{ display: 'flex', alignItems: 'flex-start', marginBottom: '10px' }">
      <q-img
        :src="profile_img"
        alt="Profile Image"
        class="profile-img"
        style="width: 40px; height: 40px; border-radius: 50%;"
      />
      <div style="margin-left: 10px; flex-grow: 1;">
        <div class="message-header" style="display: flex; justify-content: space-between;">
          <span class="username" style="font-weight: bold;">{{ sender }}</span>
          <span class="time" style="font-size: 12px; color: gray;">{{ formattedTime }}</span>
        </div>
        <div class="message-text" style="padding: 10px; background: #f0f0f0; border-radius: 8px; margin-top: 5px;">
          {{ text }}
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "DeliverMessage",
    props: {
      profile_img: {
        type: String,
        required: true,
      },
      sender: {
        type: String,
        required: true,
      },
      text: {
        type: String,
        required: true,
      },
      time: {
        type: String,
        required: true,
      },
    },
    computed: {
      formattedTime() {
        // Aquí puedes formatear la hora según necesites
        return this.time;
      },
    },
  };
  </script>
  
  <style scoped>
  .profile-img {
    flex-shrink: 0;
  }

  .message{
    margin-top: 20px;
    margin-bottom: 15px;
    width: auto;
    max-width: 900px;
    min-width: 300px;
  }
  </style>
  