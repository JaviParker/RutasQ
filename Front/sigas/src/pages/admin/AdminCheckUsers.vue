<template>
    <q-page class="q-pa-md">
      <!-- Row para imagen y radioGroup -->
      <div class="row q-mb-md">
        <!-- Columna para seleccionar la imagen (60%) -->
        <div class="col-12 col-md-7">
          <q-uploader
            v-model="imagenSeleccionada"
            label="Seleccionar imagen"
            @uploaded="handleImageUpload"
            />
        </div>
      </div>
  
      <!-- Formulario para los datos del producto -->
      <q-form @submit="handleSubmit">
        <!-- Input para el nombre del producto -->
        <q-input
            v-model="user.usuarionombre"
            label="Nombre del Usuario"
            outlined
            required
            class="q-mb-md"
          />
          <q-input
            v-model="user.usuariomail"
            label="Correo Electrónico"
            type="email"
            outlined
            required
            class="q-mb-md"
          />
          <q-input
            v-model="user.usuariopassword"
            label="Contraseña"
            type="password"
            outlined
            required
            class="q-mb-md"
          />
          <q-select
            v-model="user.rolid"
            :options="roles"
            label="Rol del Usuario"
            outlined
            required
            class="q-mb-md"
          />

          <q-separator spaced />
        <q-input v-model="shop.nombre" label="Nombre de la tienda" outlined class="q-mb-md" />
        <q-input v-model="shop.direccion" label="Dirección" outlined class="q-mb-md" />
        <q-input v-model="shop.latitud" label="Latitud" outlined class="q-mb-md" />
        <q-input v-model="shop.longitud" label="Longitud" outlined class="q-mb-md" />
        <q-input v-model="shop.telefono" label="Telefono" outlined class="q-mb-md" />
        
        <!-- Botón para enviar oferta/aviso -->
        <q-btn label="Guardar datos" color="primary" class="q-mt-md" type="submit" />
      </q-form>
  
    </q-page>
  </template>
  
  <script>
  import { api } from 'src/boot/axios';
  import { ref } from 'vue'
import dataStore from './dataStore';
  
  export default {
    components: {
    },
    data() {
      return {
        user: {
          usuarionombre: "",
          usuariomail: "",
          usuario: "",
          usuariopassword: "",
          rolid: null,
        },
        shop: {
          nombre: "",
          direccion: "",
          longitud: "",
          latitud: "",
          telefono: "",
        },
        roles: [
          { label: "Administrador", value: 1 },
          { label: "Tienda", value: 4 },
          { label: "Repartidor", value: 5 },
        ],
      };
    },
    methods: {
      // Función para manejar la imagen seleccionada en el uploader
      handleImageUpload(files) {
        this.imagenSeleccionada = files[0];
      },
      // Función para enviar el formulario (lógica pendiente)
      async handleSubmit() {
        try {
          console.log(this.user);
          const predata = {
            usuarionombre: this.user.usuarionombre,
            usuariomail: this.user.usuariomail,
            usuario: this.user.usuarionombre,
            usuariopassword: this.user.usuariopassword,
            rolid: this.user.rolid.value,
            sucursalid: 1,
          }
          
          const userResponse = await api.post("/register-user", predata, {headers: {
                'Content-Type': 'application/json',
            }} );

          if (userResponse.data.status !== "success") {
            throw new Error("Error al registrar el usuario");
          }
          if (userResponse.data.status === "success") {
            this.$q.notify({
              type: "positive",
              message: "Usuario y tienda registrados con éxito",
            });
            // this.resetForm();
          }

           // Realizamos la solicitud GET para obtener el ID del usuario
          const userIdResponse = await api.get(`/get-user-id?email=${this.user.usuariomail}`);
          console.log(userIdResponse);
          
          if (userIdResponse.data.status !== "success") {
              throw new Error("Error al obtener el usuarioid");
          }

          // Obtenemos el usuarioid de la respuesta
          const usuarioid = userIdResponse.data.data.id;
          console.log("Usuario ID obtenido:", usuarioid);
          
          const shopData = {
            ...this.shop,
            usuarioid, // Asignar el usuarioid al registro de tienda
          };

          

          const shopResponse = await api.post("/register-tienda", shopData, {headers: {
                'Content-Type': 'application/json',
            }} );
          console.log(shopResponse);
          
          this.resetForm();
          if(dataStore.rolUploading == 'admin'){
            this.$router.push({name: 'adminHome'});
          }else if(dataStore.rolUploading == 'deliver'){
            this.$router.push({name: 'deliverHome'});
          }

          
          // if (shopResponse.data.status !== "success") {
          //   throw new Error("Error al registrar la tienda");
          // }
        } catch (error) {
          console.log(error);
          
          // this.$q.notify({
          //   type: "negative",
          //   message: "Hubo un error al registrar los datos",
          // });
        }
      },
      resetForm() {
        this.user = {
          usuarionombre: "",
          usuariomail: "",
          usuario: "",
          usuariopassword: "",
          rolid: null,
        };
        this.shop = {
          nombre: "",
          direccion: "",
          longitud: "",
          latitud: "",
          telefono: "",
        };
      },
    },
  };
  </script>
  
  <style scoped>
  .vista-previa {
    background-color: #a3a3a3;
    border-radius: 12px;
    min-height: 200px;
  }
  </style>
  