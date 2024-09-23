<template>
  <q-page class="flex flex-center">
    <div id="q-app" style="min-height: 100vh">
      <div class="q-pa-lg">
        <div>
          <q-banner inline-actions rounded class="bg-black text-white">
            Parametros Generales.
            <template v-slot:action>
              <q-btn round color="primary" icon="add" @click="nuevo"></q-btn>
            </template>
          </q-banner>

          <q-input filled label="Buscar..." v-model="filtro">
            <template v-slot:prepend> <q-icon name="search"></q-icon> </template
          ></q-input>
        </div>

        <q-list
          bordered
          class="rounded-borders"
          v-for="(parametro, key) in notasFiltradas"
          :key="key"
        >
          <q-item>
            <q-item-section avatar top>
              <q-icon name="settings" color="black" size="34px"></q-icon>
            </q-item-section>

            <q-item-section top class="col-2 gt-sm">
              <q-item-label class="q-mt-sm">{{
                parametro.parametronombre
              }}</q-item-label>
            </q-item-section>

            <q-item-section top>
              <q-item-label>
                <span class="text-weight-medium">Nombre</span>
                <span class="text-grey-8">
                  - {{ parametro.parametronombre }}</span
                >
              </q-item-label>
              <q-item-label>
                <span class="text-weight-medium">Descripcion</span>
                <span class="text-grey-8">
                  - {{ parametro.parametrodescripcion }}</span
                >
              </q-item-label>
              <q-item-label lines="1">
                <span class="text-weight-medium">Valor</span>
                <span class="text-grey-8">
                  - {{ parametro.parametrovalor }}</span
                >
              </q-item-label>

              <q-item-label lines="1">
                <span class="text-weight-medium">Fecha</span>
                <span class="text-grey-8">
                  - {{ parametro.parametrofecha }}</span
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
                  @click="editar(parametro)"
                ></q-btn>
              </div>
            </q-item-section>
            <q-item-section top side v-if="parametro.parametroestatus == 1">
              <div class="text-grey-8 q-gutter-xs">
                <q-btn
                  size="12px"
                  flat
                  dense
                  round
                  icon="toggle_on"
                  @click="desactivar(parametro)"
                ></q-btn>
              </div>
            </q-item-section>
            <q-item-section top side v-if="parametro.parametroestatus == 2">
              <div class="text-grey-8 q-gutter-xs">
                <q-btn
                  size="12px"
                  flat
                  dense
                  round
                  icon="toggle_off"
                  @click="activar(parametro)"
                ></q-btn>
              </div>
            </q-item-section>
          </q-item>
        </q-list>

        <template>
          <q-dialog v-model="dialog">
            <q-card style="width: 700px; max-width: 100vw">
              <q-card-section>
                <div class="text-h6">Nuevo Parametro</div>
              </q-card-section>

              <q-card-section class="q-pt-none">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-input
                      outlined
                      v-model="parametronombre"
                      ref="fparametronombre"
                      placeholder="Nombre del Parametro"
                      hint="Nombre del Parametro"
                    ></q-input>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-input
                      outlined
                      v-model="parametrodescripcion"
                      placeholder="Descripcion del Parametro"
                      hint="Descripcion del Parametro"
                    ></q-input>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-input
                      outlined
                      v-model="parametrovalor"
                      placeholder="Valor del Parametro"
                      hint="Valor del Parametro"
                      type="number"
                    ></q-input>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12 q-pt-xs">
                    <q-input
                      outlined
                      v-model="parametrofecha"
                      mask="date"
                      :rules="['parametrofecha']"
                    >
                      <template v-slot:append>
                        <q-icon name="event" class="cursor-pointer">
                          <q-popup-proxy
                            cover
                            transition-show="scale"
                            transition-hide="scale"
                          >
                            <q-date v-model="parametrofecha">
                              <div class="row items-center justify-end">
                                <q-btn
                                  v-close-popup
                                  label="Close"
                                  color="primary"
                                  flat
                                ></q-btn>
                              </div>
                            </q-date>
                          </q-popup-proxy>
                        </q-icon>
                      </template>
                    </q-input>
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
import { list } from "postcss";

const parametros = ref([]);
const store = useAuthStore();
//
const $q = useQuasar();
const router = useRouter();

const parametroid = ref("");
const parametronombre = ref("");
const parametrodescripcion = ref("");
const parametrovalor = ref(0);
const parametrofecha = ref(store.$state.usuario.fecha);
const dialog = ref(false);
const guardareditar = ref(1);
//
const notasFiltradas = ref([]);
const texto = ref("");

// Inicio
onMounted(() => {
  listar();
});

const filtro = computed({
  get() {
    return texto.value;
  },
  set(value) {
    console.log("filtro ejecutado!");
    value = value.toLowerCase();
    notasFiltradas.value = parametros.value.filter(
      (nota) => nota.parametronombre.toLowerCase().indexOf(value) !== -1
    );
    texto.value = value;
  },
});

// Modal Nuevo
function nuevo() {
  dialog.value = true;
  guardareditar.value = 1;
}

// Guarda los datos
function guardar() {
  if (parametronombre.value == "") {
    Swal.fire({
      title: "Error",
      text: "No se a Capturado el Nombre del Paramentro",
      icon: "warning",
    });
    return;
  }

  if (parametrodescripcion.value == "") {
    Swal.fire({
      title: "Error",
      text: "No se a Capturado la Descripcion del Paramentro",
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
        "parametros/crear",
        {
          parametronombre: parametronombre.value,
          parametrodescripcion: parametrodescripcion.value,
          parametrovalor: parametrovalor.value,
          parametrofecha: parametrofecha.value,
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
        Swal.fire({
          title: "Error",
          text: "Sesion Expirada",
          icon: "warning",
        });
        router.push({ name: "login" });
        store.$state.login == 0;
      });
  } else {
    // Actualiza
    Swal.fire({
      icon: "warning",
      title: "Estas Seguro de Actualizar",
      text: "Parametro: " + parametronombre.value,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Actualizar",
    }).then((result) => {
      if (result.value) {
        api
          .post(
            "parametros/actualizar",
            {
              parametroid: parametroid.value,
              parametronombre: parametronombre.value,
              parametrodescripcion: parametrodescripcion.value,
              parametrovalor: parametrovalor.value,
              parametrofecha: parametrofecha.value,
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
            Swal.fire({
              title: "Error",
              text: "Sesion Expirada",
              icon: "warning",
            });
            router.push({ name: "login" });
            store.$state.login == 0;
          });
      }
    });
  }
}

// Limpia los campos
function limpiar() {
  parametroid.value == "";
  parametronombre.value = "";
  parametrodescripcion.value = "";
  parametrovalor.value = 0;
  parametrofecha.value = store.$state.usuario.fecha;
  dialog.value = false;
  guardareditar.value = 1;
}

// Ver los campos
function editar(item) {
  parametroid.value = item.parametroid;
  parametronombre.value = item.parametronombre;
  parametrodescripcion.value = item.parametrodescripcion;
  parametrovalor.value = item.parametrovalor;
  parametrofecha.value = item.parametrofecha;
  dialog.value = true;
  guardareditar.value = 0;
}

// Lista los datos
function listar() {
  let header = { Authorization: store.$state.token };
  let configuracion = { headers: header };
  // Api Guardar
  api
    .get("parametros/listar", configuracion)
    .then(function (response) {
      limpiar();
      parametros.value = response.data.parametro;
      notasFiltradas.value = response.data.parametro;
    })
    .catch(function (error) {
      Swal.fire({
        title: "Error",
        text: "Sesion Expirada",
        icon: "warning",
      });
      router.push({ name: "login" });
      store.$state.login == 0;
    });
}

function activar(item) {
  let header = { Authorization: store.$state.token };
  let configuracion = { headers: header };
  // Actualiza
  Swal.fire({
    icon: "warning",
    title: "Estas Seguro de Activar",
    text: "Parametro: " + item.parametronombre,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Actualizar",
  }).then((result) => {
    if (result.value) {
      api
        .put(
          "parametros/activar/" + item.parametroid,
          {
            parametroestatus: 1,
          },
          configuracion
        )
        .then(function (response) {
          limpiar();
          listar();
          Swal.fire({
            title: "Activado",
            text: "Se a Activado Con Exito",
            icon: "success",
          });
        })
        .catch(function (error) {
          Swal.fire({
            title: "Error",
            text: "Sesion Expirada",
            icon: "warning",
          });
          router.push({ name: "login" });
          store.$state.login == 0;
        });
    }
  });
}

function desactivar(item) {
  let header = { Authorization: store.$state.token };
  let configuracion = { headers: header };
  // Actualiza
  Swal.fire({
    icon: "warning",
    title: "Estas Seguro de Desactivar",
    text: "Parametro: " + item.parametronombre,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Actualizar",
  }).then((result) => {
    if (result.value) {
      api
        .put(
          "parametros/desactivar/" + item.parametroid,
          {
            parametroestatus: 2,
          },
          configuracion
        )
        .then(function (response) {
          limpiar();
          listar();
          Swal.fire({
            title: "Activado",
            text: "Se a Desactivado Con Exito",
            icon: "success",
          });
        })
        .catch(function (error) {
          Swal.fire({
            title: "Error",
            text: "Sesion Expirada",
            icon: "warning",
          });
          router.push({ name: "login" });
          store.$state.login == 0;
        });
    }
  });
}

// Nombre del elemento
defineOptions({
  name: "ParametroPage",
});
</script>
