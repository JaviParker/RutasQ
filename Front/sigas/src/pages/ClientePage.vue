<template>
  <q-page class="flex flex-center">
    <div id="q-app" style="min-height: 100vh">
      <div class="q-pa-lg">
        <div>
          <q-banner inline-actions rounded class="bg-blue text-white">
            Clientes del Sistema.
            <template v-slot:action>
              <q-btn round color="primary" icon="add" @click="nuevo"></q-btn>
            </template>
          </q-banner>
        </div>

        <q-list
          bordered
          class="rounded-borders"
          v-for="(cliente, key) in clientes"
          :key="key"
        >
          <q-item>
            <q-item-section avatar top>
              <q-icon
                name="settings_accessibility"
                color="black"
                size="34px"
              ></q-icon>
            </q-item-section>

            <q-item-section top class="col-2 gt-sm">
              <q-item-label class="q-mt-sm">{{
                cliente.clientenombre
              }}</q-item-label>
            </q-item-section>

            <q-item-section top>
              <q-item-label>
                <span class="text-weight-medium">Nombre</span>
                <span class="text-grey-8"> - {{ cliente.clientenombre }}</span>
              </q-item-label>
              <q-item-label>
                <span class="text-weight-medium">Numero de Cliente</span>
                <span class="text-grey-8"> - {{ cliente.clientenumero }}</span>
              </q-item-label>
              <q-item-label>
                <span class="text-weight-medium">Sucursal</span>
                <span class="text-grey-8"> - {{ cliente.sucursalnombre }}</span>
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
                  @click="editar(cliente)"
                ></q-btn>
              </div>
            </q-item-section>
          </q-item>
        </q-list>

        <template>
          <q-dialog v-model="dialog">
            <q-card style="width: 700px; max-width: 100vw">
              <q-card-section>
                <div class="text-h6">Nuevo cliente</div>
              </q-card-section>

              <q-card-section class="q-pt-none">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-input
                      outlined
                      v-model="clientenombre"
                      placeholder="Nombre Completo"
                      hint="Nombre Completo del Cliente"
                    ></q-input>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-input
                      outlined
                      v-model="clientenumero"
                      placeholder="Numero del Cliente"
                      hint="Numero del Cliente"
                      type="number"
                    ></q-input>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-select
                      outlined
                      v-model="sucursalid"
                      :options="sucursalselect"
                      label="Sucursal"
                      hint="Sucursal del Cliente"
                      emit-value
                      map-options
                    ></q-select>
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

const clientes = ref([]);
const store = useAuthStore();
//
const $q = useQuasar();
const router = useRouter();
//
const clienteid = ref("");
const clientenombre = ref("");
const clientenumero = ref("");
const sucursalid = ref("");
const sucursalselect = ref([]);
//
const dialog = ref(false);
const guardareditar = ref(1);

// Inicio
onMounted(() => {
  listar();
  listarsucursales();
});

// Modal Nuevo
function nuevo() {
  dialog.value = true;
  guardareditar.value = 1;
}

// Guarda los datos
function guardar() {
  if (clientenombre.value == "") {
    Swal.fire({
      title: "Error",
      text: "No se a Capturado el Nombre del Cliente",
      icon: "warning",
    });
    return;
  }

  if (clientenumero.value == "") {
    Swal.fire({
      title: "Error",
      text: "No se a Capturado el Numero del Cliente",
      icon: "warning",
    });
    return;
  }

  if (sucursalid.value == "") {
    Swal.fire({
      title: "Error",
      text: "No se a Capturado la Sucursal del Cliente",
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
        "clientes/crear",
        {
          clientenombre: clientenombre.value,
          clientenumero: clientenumero.value,
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
        //openWhatsApp();
      })
      .catch(function (error) {
        console.log(error);
      });
  } else {
    // Actualiza
    Swal.fire({
      icon: "warning",
      title: "Estas Seguro de Actualizar",
      text: "Cliente: " + clientenombre.value,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Actualizar",
    }).then((result) => {
      if (result.value) {
        api
          .post(
            "clientes/actualizar",
            {
              clienteid: clienteid.value,
              clientenombre: clientenombre.value,
              clientenumero: clientenumero.value,
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
  clienteid.value = "";
  clientenombre.value = "";
  clientenumero.value = "";
  sucursalid.value = "";
  dialog.value = false;
  guardareditar.value = 1;
}

// Ver los campos
function editar(item) {
  clienteid.value = item.clienteid;
  clientenombre.value = item.clientenombre;
  clientenumero.value = item.clientenumero;
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
    .get("clientes/listar", configuracion)
    .then(function (response) {
      limpiar();
      clientes.value = response.data.cliente;
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

function openWhatsApp() {
  const phoneNumber = "+526751100973"; // Número de teléfono en formato internacional
  const message = "Hello, this is a message!";
  const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(
    message
  )}`;
  window.open(url, "_blank");
}

// Nombre del elemento
defineOptions({
  name: "ParametroPage",
});
</script>
