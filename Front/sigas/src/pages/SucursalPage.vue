<template>
  <q-page class="flex flex-center">
    <div id="q-app" style="min-height: 100vh">
      <div class="q-pa-lg">
        <div>
          <q-banner inline-actions rounded class="bg-blue text-white">
            Sucursales.
            <template v-slot:action>
              <q-btn round color="primary" icon="add" @click="nuevo"></q-btn>
            </template>
          </q-banner>
        </div>

        <q-list
          bordered
          class="apartment"
          v-for="(sucursal, key) in sucursales"
          :key="key"
        >
          <q-item>
            <q-item-section avatar top>
              <q-icon
                name="supervisor_account"
                color="black"
                size="34px"
              ></q-icon>
            </q-item-section>

            <q-item-section top class="col-3 gt-sm">
              <q-item-label class="q-mt-sm">{{
                sucursal.sucursalnombre
              }}</q-item-label>
            </q-item-section>

            <q-item-section top>
              <q-item-label>
                <span class="text-weight-medium">Id</span>
                <span class="text-grey-8"> - {{ sucursal.sucursalid }}</span>
              </q-item-label>
              <q-item-label>
                <span class="text-weight-medium">Nombre de la sucursal</span>
                <span class="text-grey-8">
                  - {{ sucursal.sucursalnombre }}</span
                >
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
                  @click="editar(sucursal)"
                ></q-btn>
              </div>
            </q-item-section>
          </q-item>
        </q-list>

        <template>
          <q-dialog v-model="dialog">
            <q-card style="width: 700px; max-width: 100vw">
              <q-card-section>
                <div class="text-h6">Nueva sucursal</div>
              </q-card-section>

              <q-card-section class="q-pt-none">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-input
                      outlined
                      v-model="sucursalnombre"
                      placeholder="Nombre del sucursal"
                      hint="Nombre del sucursal"
                      style="text-transform: uppercase"
                    ></q-input>
                  </div>
                </div>
              </q-card-section>

              <q-card-actions align="right" class="bg-white text-teal">
                <q-btn round icon="close" size="lg" v-close-popup
                  ><q-tooltip anchor="bottom middle" self="center middle">
                    Cerrar
                  </q-tooltip></q-btn
                >
                <q-btn round icon="save" size="lg" @click="guardar">
                  <q-tooltip anchor="bottom middle" self="center middle">
                    Guardar
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

const sucursales = ref([]);
const store = useAuthStore();
//
const $q = useQuasar();
const router = useRouter();

const sucursalid = ref("");
const sucursalnombre = ref("");
const dialog = ref(false);
const guardareditar = ref(1);

// Inicio
onMounted(() => {
  listar();
});

// Modal Nuevo
function nuevo() {
  limpiar();
  dialog.value = true;
  guardareditar.value = 1;
}

// Guarda los datos
function guardar() {
  if (sucursalnombre.value == "") {
    Swal.fire({
      title: "Error",
      text: "No se a Capturado el Nombre de la sucursal",
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
        "sucursales/crear",
        {
          sucursalnombre: sucursalnombre.value,
          usuarioid: store.$state.usuario.usuarioid,
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
      text: "sucursal: " + sucursalnombre.value,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Actualizar",
    }).then((result) => {
      if (result.value) {
        api
          .post(
            "sucursales/actualizar",
            {
              sucursalid: sucursalid.value,
              sucursalnombre: sucursalnombre.value,
              usuarioid: store.$state.usuario.usuarioid,
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
  sucursalid.value == "";
  sucursalnombre.value = "";
  dialog.value = false;
  guardareditar.value = 1;
}

// Ver los campos
function editar(item) {
  sucursalid.value = item.sucursalid;
  sucursalnombre.value = item.sucursalnombre;
  dialog.value = true;
  guardareditar.value = 0;
}

// Lista los datos
function listar() {
  let header = { Authorization: store.$state.token };
  let configuracion = { headers: header };
  // Api Guardar
  api
    .get("sucursales/listar", configuracion)
    .then(function (response) {
      limpiar();
      sucursales.value = response.data.sucursal;
    })
    .catch(function (error) {
      console.log(error);
    });
}

function actualizar(item) {
  let header = { Authorization: store.$state.token };
  let configuracion = { headers: header };
  // Actualiza
  Swal.fire({
    icon: "warning",
    title: "Estas Seguro de Actualizar",
    text: "sucursal: " + item.sucursalnombre,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Actualizar",
  }).then((result) => {
    if (result.value) {
      api
        .post(
          "sucursales/actualizar",
          {
            parametroid: item.parametroid,
            parametronombre: parametronombre.value,
            usuarioid: store.$state.usuario.usuarioid,
          },
          configuracion
        )
        .then(function (response) {
          limpiar();
          Swal.fire({
            title: "Actualizado",
            text: "Se a Actualizado Con Exito",
            icon: "success",
          });
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

// Nombre del elemento
defineOptions({
  name: "sucursalPage",
});
</script>
