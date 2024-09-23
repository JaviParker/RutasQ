<template>
  <q-page class="flex flex-center">
    <div id="q-app" style="min-height: 100vh">
      <div class="q-pa-lg">
        <div>
          <q-banner inline-actions rounded class="bg-blue text-white">
            Usuarios del Sistema.
            <template v-slot:action>
              <q-btn round color="primary" icon="add" @click="nuevo"></q-btn>
            </template>
          </q-banner>
        </div>

        <q-list
          bordered
          class="rounded-borders"
          v-for="(usuario, key) in usuarios"
          :key="key"
        >
          <q-item>
            <q-item-section avatar top>
              <q-icon name="person_add" color="black" size="34px"></q-icon>
            </q-item-section>

            <q-item-section top class="col-3 gt-sm">
              <q-item-label class="q-mt-sm">{{ usuario.usuario }}</q-item-label>
            </q-item-section>

            <q-item-section top>
              <q-item-label>
                <span class="text-weight-medium">Nombre</span>
                <span class="text-grey-8"> - {{ usuario.usuarionombre }}</span>
              </q-item-label>
              <q-item-label>
                <span class="text-weight-medium">Mail</span>
                <span class="text-grey-8"> - {{ usuario.usuariomail }}</span>
              </q-item-label>
            </q-item-section>

            <q-item-section top side>
              <div class="text-grey-8 q-gutter-xs">
                <q-btn
                  size="12px"
                  flat
                  dense
                  round
                  icon="edit"
                  @click="editar(usuario)"
                ></q-btn>
              </div>
            </q-item-section>
          </q-item>
        </q-list>

        <template>
          <q-dialog v-model="dialog">
            <q-card style="width: 700px; max-width: 100vw">
              <q-card-section>
                <div class="text-h6">Nuevo Usuario</div>
              </q-card-section>

              <q-card-section class="q-pt-none">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-input
                      outlined
                      v-model="usuarionombre"
                      placeholder="Nombre Completo"
                      hint="Nombre Completo del Usuario"
                    ></q-input>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-input
                      outlined
                      v-model="usuario"
                      placeholder="Usuario"
                      hint="Usuario"
                    ></q-input>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-input
                      outlined
                      v-model="usuariomail"
                      placeholder="Correo Electronico"
                      hint="Correo Electronico del Usuario"
                    ></q-input>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-input
                      outlined
                      v-model="usuariopassword"
                      placeholder="Password"
                      hint="Contraseña del del Usuario"
                    ></q-input>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-select
                      outlined
                      v-model="rolid"
                      :options="rolselect"
                      label="Rol"
                      hint="Rol del Usuario"
                      emit-value
                      map-options
                    ></q-select>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-select
                      outlined
                      v-model="sucursalid"
                      :options="sucursalselect"
                      label="Sucursal"
                      hint="Sucursal del Usuario"
                      emit-value
                      map-options
                    ></q-select>
                  </div>
                </div>
              </q-card-section>

              <q-card-actions align="right" class="bg-white text-teal">
                <q-btn round icon="close" size="lg" v-close-popup
                  ><q-tooltip anchor="bottom middle" self="center middle">
                    Cerrar Parametro
                  </q-tooltip></q-btn
                >
                <q-btn round icon="save" size="lg" @click="guardar">
                  <q-tooltip anchor="bottom middle" self="center middle">
                    Guardar Parametro
                  </q-tooltip></q-btn
                >
              </q-card-actions>
            </q-card>
          </q-dialog>
        </template>
      </div>
    </div>
  </q-page>
</template>

<script setup>
import { useAuthStore } from "stores/auth";
import { ref, onBeforeUpdate, computed, onMounted } from "vue";
import { useQuasar } from "quasar";
import { useRouter } from "vue-router";
import { api } from "src/boot/axios";
import Swal from "sweetalert2";

const usuarios = ref([]);
const store = useAuthStore();
//
const $q = useQuasar();
const router = useRouter();
//
const usuarioid = ref("");
const usuarionombre = ref("");
const usuariomail = ref("");
const usuario = ref("");
const usuariopassword = ref("");
const rolid = ref("");
const rolselect = ref([{}]);
const sucursalid = ref("");
const sucursalselect = ref([]);
//
const dialog = ref(false);
const guardareditar = ref(1);

// Inicio
onMounted(() => {
  listar();
  listarroles();
  listarsucursales();
});

// Modal Nuevo
function nuevo() {
  dialog.value = true;
  guardareditar.value = 1;
}

// Guarda los datos
function guardar() {
  if (usuarionombre.value == "") {
    Swal.fire({
      title: "Error",
      text: "No se a Capturado el Nombre del Usuario",
      icon: "warning",
    });
    return;
  }

  if (usuariomail.value == "") {
    Swal.fire({
      title: "Error",
      text: "No se a Capturado el Correo del Usuario",
      icon: "warning",
    });
    return;
  }

  if (usuario.value == "") {
    Swal.fire({
      title: "Error",
      text: "No se a Capturado el Usuario",
      icon: "warning",
    });
    return;
  }

  if (usuariopassword.value == "") {
    Swal.fire({
      title: "Error",
      text: "No se a Capturado el Password Usuario",
      icon: "warning",
    });
    return;
  }

  if (rolid.value == "") {
    Swal.fire({
      title: "Error",
      text: "No se a Capturado el Rol Usuario",
      icon: "warning",
    });
    return;
  }

  if (sucursalid.value == "") {
    Swal.fire({
      title: "Error",
      text: "No se a Capturado la Sucursal Usuario",
      icon: "warning",
    });
    return;
  }

  let header = { Authorization: store.$state.token };
  let configuracion = { headers: header };

  if (guardareditar.value == 1) {
    // Api Guardar
    api
      .post(
        "usuarios/crear",
        {
          usuarionombre: usuarionombre.value,
          usuariomail: usuariomail.value,
          usuario: usuario.value,
          usuariopassword: usuariopassword.value,
          rolid: rolid.value,
          sucursalid: sucursalid.value,
        },
        configuracion
      )
      .then(function (response) {
        Swal.fire({
          title: "Guardado",
          text: "Se a Guardado Con Exito",
          icon: "success",
        });
        limpiar();
        listar();
      })
      .catch(function (error) {
        console.log(error);
      });
  } else {
    // Actualiza
    Swal.fire({
      icon: "warning",
      title: "Estas Seguro de Actualizar",
      text: "Usuario: " + usuarionombre.value,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Actualizar",
    }).then((result) => {
      if (result.value) {
        api
          .post(
            "usuarios/update",
            {
              usuarioid: usuarioid.value,
              usuarionombre: usuarionombre.value,
              usuariomail: usuariomail.value,
              usuario: usuario.value,
              usuariopassword: usuariopassword.value,
              rolid: rolid.value,
              sucursalid: sucursalid.value,
            },
            configuracion
          )
          .then(function (response) {
            Swal.fire({
              title: "Actualizado",
              text: "Se a Actualizado Con Exito",
              icon: "success",
            });
            limpiar();
            listar();
          })
          .catch(function (error) {
            if (error.status === 401) {
              me.$swal("La Sesión a Expirado");
              me.$store.dispatch("salir");
            }
          });
      }
    });
  }
}

// Limpia los campos
function limpiar() {
  usuarioid.value = "";
  usuarionombre.value = "";
  usuariomail.value = "";
  usuario.value = "";
  usuariopassword.value = "";
  rolid.value = "";
  sucursalid.value = "";
  dialog.value = false;
  guardareditar.value = 1;
}

// Ver los campos
function editar(item) {
  usuarioid.value = item.usuarioid;
  usuarionombre.value = item.usuarionombre;
  usuariomail.value = item.usuariomail;
  usuario.value = item.usuario;
  usuariopassword.value = item.usuariopassword;
  rolid.value = item.rolid;
  sucursalid.value = item.sucursalid;
  dialog.value = true;
  guardareditar.value = 0;
}

// Lista los datos
function listar() {
  let header = { Authorization: store.$state.token };
  let configuracion = { headers: header };
  // Api Guardar
  api
    .get("usuarios/listar", configuracion)
    .then(function (response) {
      limpiar();
      usuarios.value = response.data.usuarios;
    })
    .catch(function (error) {
      console.log(error);
    });
}

// metodo listar
function listarroles() {
  var listaArray = [];
  let header = { Authorization: store.$state.token };
  let configuracion = { headers: header };
  api
    .get("roles/listar", configuracion)
    .then(function (response) {
      listaArray = response.data.rol;
      rolselect.value = listaArray.map((option) => ({
        label: option.rolnombre, // Asume que tu API devuelve un campo `name` para mostrar
        value: option.rolid, // Asume que tu API devuelve un campo `id` como valor
      }));
    })
    .catch(function (error) {
      console.log(error);
      if (error.response.data.code == 400) {
      }
    });
}

// metodo listar
function listarsucursales() {
  var listaArray = [];
  let header = { Authorization: store.$state.token };
  let configuracion = { headers: header };
  api
    .get("sucursales/listar", configuracion)
    .then(function (response) {
      listaArray = response.data.sucursal;
      sucursalselect.value = listaArray.map((option) => ({
        label: option.sucursalnombre, // Asume que tu API devuelve un campo `name` para mostrar
        value: option.sucursalid, // Asume que tu API devuelve un campo `id` como valor
      }));
    })
    .catch(function (error) {
      console.log(error);
      if (error.response.data.code == 400) {
      }
    });
}

// Nombre del elemento
defineOptions({
  name: "ParametroPage",
});
</script>
