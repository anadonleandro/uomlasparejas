<template>
  <div>
    <form @submit.prevent="showModalConfirm()">
      <div class="panel-heading" style="text-align:center">
        <strong>
          <h2 class="fuenteNunito">
            <div>
              <b>MOVIMIENTO DE ELEMENTOS</b>
            </div>
          </h2>
        </strong>
      </div>

      <br />
      <b-card
        border-variant="info"
        title
        img-src
        img-alt="Image"
        img-top
        tag="article"
        style="max-width: 200rem"
        class="mb-2"
      >
        <b-card-text>
          <b-row>
            <b-col sm="3">
              <b-form-text>
                <b class="fuenteNunito">TIPO MOVIMIENTO</b>
                <i style="color:Indianred">(*)</i>
              </b-form-text>
              <v-select
                :options="[
                  { label: 'SALIDA', code: '1' },
                  { label: 'REINGRESO', code: '0' }
                ]"
                v-model="elemento.tipo_mvto"
                :value="elemento.tipo_mvto"
                :clearable="false"
                :disabled="deshabilitado"
                placeholder="Seleccione tipo..."
                @input="valorSelect()"
              >
                <span slot="no-options">Sin Opciones</span>
              </v-select>
            </b-col>
            <b-col sm="3">
              <b-form-text id="input-live-help">
                <b class="fuenteNunito">FECHA NOTA</b>
                <i style="color:IndianRed">(*)</i>
              </b-form-text>
              <b-form-datepicker
                id="example-datepicker"
                v-model="movimiento.fecha_nota_mvto"
                :max="fecha_maxima"
                :disabled="deshabilitado"
                size="sm"
                class="mb-2"
                required
              ></b-form-datepicker>
            </b-col>
            <b-col sm="3">
              <b-form-text id="input-live-help">
                <b class="fuenteNunito">NRO NOTA</b>
                <i style="color:Indianred">(*)</i>
              </b-form-text>
              <b-form-input
                id="input-live"
                :formatter="mayusculas"
                :disabled="deshabilitado"
                v-model="movimiento.nota"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Ingrese numero de nota"
                trim
                type="text"
                required
              ></b-form-input>
            </b-col>

            <b-col sm="3" v-if="elemento.tipo_mvto.code == 1">
              <b-form-text id="input-live-help">
                <b class="fuenteNunito">DESTINO</b>
                <i style="color:Indianred">(*)</i>
              </b-form-text>
              <b-form-input
                id="input-live"
                :formatter="mayusculas"
                :disabled="deshabilitado"
                v-model="movimiento.destino_mvto"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Ingrese destino del elemento"
                type="text"
                trim
                required
              ></b-form-input>
            </b-col>

            <b-col sm="3" v-if="elemento.tipo_mvto.code == 0">
              <b-form-text id="input-live-help">
                <b class="fuenteNunito">DESTINO</b>
              </b-form-text>
              <b-form-input
                id="input-live"
                :formatter="mayusculas"
                :disabled="true"
                v-model="movimiento.destino_mvto"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Campo no requerido"
                type="text"
                trim
                required
              ></b-form-input>
            </b-col>
          </b-row>

          <b-row>
            <b-col sm="4" v-if="elemento.tipo_mvto.code == 1">
              <b-form-text id="input-live-help">
                <b class="fuenteNunito">PERSONA SOLICITA</b>
                <i style="color:Indianred">(*)</i>
              </b-form-text>
              <b-form-input
                id="input-live"
                :formatter="mayusculas"
                v-model="movimiento.persona_solicita"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Nombre del solicitante (Fiscal / Particular / Etc.)"
                type="text"
                trim
                required
              ></b-form-input>
            </b-col>

            <b-col sm="4" v-if="elemento.tipo_mvto.code == 0">
              <b-form-text id="input-live-help">
                <b class="fuenteNunito">PERSONA SOLICITA</b>
              </b-form-text>
              <b-form-input
                id="input-live"
                :disabled="true"
                value="Campo no requerido..."
                aria-describedby="input-live-help input-live-feedback"
                type="text"
                trim
              ></b-form-input>
            </b-col>

            <b-col sm="4">
              <b-form-text id="input-live-help" v-if="elemento.tipo_mvto.code == 1">
                <b class="fuenteNunito">PERSONA RETIRA</b>
                <i style="color:Indianred">(*)</i>
              </b-form-text>
              <b-form-text id="input-live-help" v-else>
                <b class="fuenteNunito">PERSONA ENTREGA / DEVUELVE</b>
                <i style="color:Indianred">(*)</i>
              </b-form-text>

              <b-form-input
                id="input-live"
                :formatter="mayusculas"
                :disabled="deshabilitado"
                v-model="movimiento.persona_retira_devuelve"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Nombre de quien se presenta a retirar o devolver"
                type="text"
                trim
                required
              ></b-form-input>
            </b-col>

            <b-col sm="4">
              <b-form-text id="input-live-help">
                <b class="fuenteNunito">OBSERVACIONES</b>
              </b-form-text>
              <b-form-input
                id="input-live"
                :formatter="mayusculas"
                v-model="movimiento.obs_mvto"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Ingrese observaciones o comentarios"
                trim
                type="text"
              ></b-form-input>
            </b-col>
          </b-row>
          <b-row>
            <i style="color:IndianRed">(*) Campos Requeridos</i>
          </b-row>

          <b-row>
            <b-col sm="6" v-if="elemento.tipo_mvto.code == 1">
              <div
                v-if=" movimiento.nota 
                && movimiento.destino_mvto
                && movimiento.persona_solicita
                && movimiento.persona_retira_devuelve"
              >
                <b-form-text id="input-live-help">
                  <b class="fuenteNunito">INGRESE CUIJ PARA BUSCAR ELEMENTOS</b>
                  <i style="color:Indianred">(*)</i>
                </b-form-text>
                <b-form-input
                  id="input-live"
                  :state="validar_cuij"
                  v-model="elemento.cuij"
                  :disabled="deshabilitado"
                  aria-describedby="input-live-help input-live-feedback"
                  placeholder="Ingrese Nro de CUIJ. (Mínimo 8 caracteres)"
                  type="text"
                  trim
                  required
                  @keydown.enter="buscar()"
                ></b-form-input>
              </div>
            </b-col>

            <b-col sm="6" v-if="elemento.tipo_mvto.code == 0">
              <!-- input duplicado para REINGRESO DE ELEMENTO -->
              <div v-if="movimiento.nota 
                && movimiento.persona_retira_devuelve">
                <b-form-text id="input-live-help">
                  <b class="fuenteNunito">INGRESE CUIJ PARA BUSCAR ELEMENTOS</b>
                  <i style="color:Indianred">(*)</i>
                </b-form-text>
                <b-form-input
                  id="input-live"
                  :state="validar_cuij"
                  v-model="elemento.cuij"
                  :disabled="deshabilitado"
                  aria-describedby="input-live-help input-live-feedback"
                  placeholder="Ingrese Nro de CUIJ. (Mínimo 8 caracteres)"
                  type="text"
                  trim
                  required
                  @keydown.enter="buscar()"
                ></b-form-input>
              </div>
            </b-col>

            <b-col sm="6" class="fuenteNunito">
              <b-button
                v-if="validar_cuij"
                v-b-tooltip.hover
                block
                title
                btn.
                variant="outline-success"
                @click="buscar()"
              >
                <b-icon-search></b-icon-search>BUSCAR POR CUIJ
              </b-button>
              <b-button
                v-b-tooltip.hover
                block
                title
                btn.
                variant="outline-danger"
                @click="vaciarCampos()"
              >
                <b-icon-exclamation-triangle-fill></b-icon-exclamation-triangle-fill>LIMPIAR CAMPOS
              </b-button>
            </b-col>
          </b-row>
        </b-card-text>
      </b-card>
      <br />

      <b-card border-variant="info" v-if="totalRowsA > 0">
        <h3 class="fuenteNunito">
          Lista de Elementos seleccionados:
          <b-badge pill v-if="totalRowsA > 0">Cantidad seleccionada:{{ totalRowsA }}</b-badge>
        </h3>

        <b-container fluid>
          <!-- User Interface controls -->

          <!-- Main table element -->
          <!-- PONER EL ARRAY DECLARADO EN el data luego de items= -->

          <hr />

          <b-card border-variant="info" class="fuenteNunito">
            <!-- STICKY-HEADER (usado mÃ¡s abajo)
            FIJA LA CABECERA DE TABLA-->
            <b-table
              responsive
              :items="listaElementosAsignados"
              :fields="fieldsA"
              :current-page="currentPageA"
              :filter="filterA"
              :filter-included-fields="filterOnA"
              :sort-by.sync="sortByA"
              :sort-desc.sync="sortDescA"
              :sort-direction="sortDirectionA"
              :bordered="true"
              striped
              sticky-header="200"
              hover
              show-empty
              small
              @filtered="onFilteredA"
              empty-text="No hay registros para mostrar"
              empty-filtered-text="No hay registros para mostrar"
            >
              <template #cell(name)="row">{{ row.value.first }} {{ row.value.last }}</template>

              <template #cell(actions)="row">
                <b-button
                  size="sm"
                  class="btn btn-danger btn-sm"
                  @click="quitarElementoDelListado(row.item)"
                >
                  <b-icon-trash-fill></b-icon-trash-fill>
                </b-button>
              </template>

              <template #row-details="row">
                <b-card>
                  <ul>
                    <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
                  </ul>
                </b-card>
              </template>
            </b-table>

            <button class="btn btn-info btn-block" type="submit">{{textoBotonMovimiento}}</button>
          </b-card>

          <!-- Info modal -->
        </b-container>
      </b-card>
    </form>

    <b-card v-if="totalRows > 0" border-variant="info">
      <h3 class="fuenteNunito">
        {{tituloTablaElementos}}
        <b-badge v-if="totalRows > 0">Cantidad encontrada: {{ totalRows }}</b-badge>
      </h3>

      <b-container fluid>
        <!-- User Interface controls -->
        <b-row>
          <b-col lg="6" class="my-1">
            <b-form-group
              label="Filtrar"
              label-for="filter-input"
              label-cols-sm="3"
              label-align-sm="right"
              label-size="sm"
              class="mb-0"
            >
              <b-input-group size="sm">
                <b-form-input
                  id="filter-input"
                  v-model="filter"
                  type="search"
                  placeholder="Buscar en el Listado de elementos"
                ></b-form-input>
              </b-input-group>
            </b-form-group>
          </b-col>

          <b-col sm="7" md="6" class="my-1">
            <b-pagination
              v-model="currentPage"
              :total-rows="totalRows"
              :per-page="perPage"
              align="fill"
              size="sm"
              class="my-0"
            ></b-pagination>
          </b-col>
        </b-row>

        <!-- Main table element -->
        <!-- PONER EL ARRAY DECLARADO EN el data luego de items= -->
        <br />
        <hr />

        <b-card border-variant="info" class="fuenteNunito">
          <b-table
            responsive
            :items="elementos"
            :fields="fields"
            :current-page="currentPage"
            :per-page="perPage"
            :filter="filter"
            :filter-included-fields="filterOn"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            :sort-direction="sortDirection"
            :bordered="true"
            striped
            hover
            show-empty
            small
            empty-text="No hay registros para mostrar"
            empty-filtered-text="No hay registros para mostrar"
            @filtered="onFiltered"
          >
            <template #cell(name)="row">{{ row.value.first }} {{ row.value.last }}</template>

            <template #cell(actions)="row">
              <b-button
                size="sm"
                v-b-tooltip.hover
                title
                @click="info(row.item, row.index, $event.target)"
                class="mr-1"
              >
                <b-icon-binoculars-fill style="color: white"></b-icon-binoculars-fill>
              </b-button>
              <b-button
                size="sm"
                v-b-tooltip.hover
                title
                class="btn btn-success btn-sm"
                @click="agregarElementoAlListado(row.item)"
              >
                <b-icon-arrow-bar-up style="color: white"></b-icon-arrow-bar-up>
              </b-button>
            </template>

            <template #row-details="row">
              <b-card>
                <ul>
                  <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
                </ul>
              </b-card>
            </template>
          </b-table>
        </b-card>

        <!-- Info modal -->
        <b-modal
          :id="infoModal.id"
          :title="infoModal.title"
          ok-only
          ok-title="CERRAR"
          @hide="resetInfoModal"
          size="lg"
          class="fuenteNunito"
        >
          <b-card-text
            title
            img-src
            img-alt="Image"
            img-top
            tag="article"
            style="max-width: 2000rem"
            class="mb-2"
          >
            <!-- {{ moment(infoModal.content.fecha_alta).format('DD-MM-YYYY') }} -->
            <b-card-text class="fuenteNunito">
              <h3>
                <b-badge pill variant="info">ELEMENTO</b-badge>
              </h3>
              <b-row>
                <b-col sm="4">
                  <label>NRO Y DETALLE</label>
                  <b-form-text>{{ infoModal.content.id_elemento+ " - "+ infoModal.content.detalle}}</b-form-text>
                </b-col>
                <b-col sm="4">
                  <label>ESTADO</label>
                  <b-form-text v-if="infoModal.content.estado_conservacion == 3">BUENO</b-form-text>
                  <b-form-text v-if="infoModal.content.estado_conservacion == 2">REGULAR</b-form-text>
                  <b-form-text v-if="infoModal.content.estado_conservacion == 1">MALO</b-form-text>
                </b-col>
                <b-col sm="4">
                  <label>CATEGORIA</label>
                  <b-form-text>{{ infoModal.content.nom_categoria}}</b-form-text>
                </b-col>
              </b-row>
              <hr />
              <b-row>
                <b-col sm="6">
                  <label>UBICACION</label>
                  <b-form-text>{{ infoModal.content.nom_ubicacion}}</b-form-text>
                </b-col>
                <b-col sm="6">
                  <label>DESCRIPCION UBICACION</label>
                  <b-form-text>{{ infoModal.content.descripcion_ubicacion}}</b-form-text>
                </b-col>
              </b-row>

              <hr />
              <h3>
                <b-badge pill variant="info">ORDEN DE ALLANAMIENTO</b-badge>
              </h3>
              <b-row>
                <b-col sm="6">
                  <label>NRO Y DOMICILIO</label>
                  <b-form-text>{{ infoModal.content.nro_orden_oa + " - " + infoModal.content.direccion_oa}}</b-form-text>
                </b-col>
                <b-col sm="6">
                  <label>OBSERVACIONES</label>
                  <b-form-text>{{ infoModal.content.obs_oa}}</b-form-text>
                </b-col>
              </b-row>

              <hr />
              <h3>
                <b-badge pill variant="info">NOTA DE SECUESTRO</b-badge>
              </h3>
              <b-row>
                <b-col sm="2">
                  <label>NRO</label>
                  <b-form-text>{{ infoModal.content.nro_nota}}</b-form-text>
                </b-col>
                <b-col sm="2">
                  <label>FECHA</label>
                  <b-form-text>{{ infoModal.content.nro_nota}}</b-form-text>
                </b-col>
                <b-col sm="4">
                  <label>CUIJ</label>
                  <b-form-text>{{ infoModal.content.cuij}}</b-form-text>
                </b-col>
                <b-col sm="4">
                  <label>CAUSA</label>
                  <b-form-text>{{ infoModal.content.causa}}</b-form-text>
                </b-col>
              </b-row>
              <hr />
              <b-row>
                <b-col sm="4">
                  <label>JUZGADO</label>
                  <b-form-text>{{ infoModal.content.juzgado}}</b-form-text>
                </b-col>

                <b-col sm="4">
                  <label>FISCAL</label>
                  <b-form-text>{{ infoModal.content.fiscal}}</b-form-text>
                </b-col>
                <b-col sm="4">
                  <label>IMPUTADO</label>
                  <b-form-text>{{ infoModal.content.imputado}}</b-form-text>
                </b-col>
              </b-row>

              <hr />
              <b-row>
                <b-col sm="4">
                  <label>VICTIMA</label>
                  <b-form-text>{{ infoModal.content.victima}}</b-form-text>
                </b-col>
                <b-col sm="4">
                  <label>DETENIDO</label>
                  <b-form-text>{{ infoModal.content.detenido}}</b-form-text>
                </b-col>

                <b-col sm="4">
                  <label>SUMARIANTE</label>
                  <b-form-text>{{ infoModal.content.sumariante}}</b-form-text>
                </b-col>
              </b-row>
              <hr />
              <b-row>
                <b-col sm="12">
                  <label>OBSERVACIONES DEL SECUESTRO</label>
                  <b-form-text>{{ infoModal.content.obs_secuestro}}</b-form-text>
                </b-col>
              </b-row>
            </b-card-text>
          </b-card-text>
        </b-modal>
      </b-container>
    </b-card>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";

export default {
  computed: {
    ///// VALIDACIONES ///////
    validar_cuij() {
      try {
        if (this.elemento.cuij) {
          if (
            this.elemento.cuij.toString().length > 7 &&
            this.elemento.cuij.toString().length < 15
          ) {
            return true;
          } else {
            return false;
          }
        } else {
          console.log("no esta el cui");
        }
        // lo pasamos a string para poder contarle la cantidad de caracterres ya q es un campo numerico
      } catch (error) {
        console.log(error);
      }
    },

    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter(f => f.sortable)
        .map(f => {
          return {
            text: f.label,
            value: f.key
          };
        });
    }
  },

  mounted() {
    // Set the initial number of items
    this.totalRows = this.elementos.length;
    // la primera vez da 0 por eso lo seteamos en el created
  },

  data() {
    return {
      tituloTablaElementos: "LISTADO DE ELEMENTOS DISPONIBLES EN DEPOSITO",
      textoBotonMovimiento: "DAR SALIDA A ELEMENTOS SELECCIONADOS",
      fecha_maxima: new Date(), // para fecha nota
      hoy: new Date(), // para fecha nota
      deshabilitado: false, // para input de cuij
      elementos: [],
      movimiento: {
        cuij: "",
        fecha_nota_mvto: "",
        destino_mvto: "",
        persona_solicita: "",
        persona_retira_devuelve: "",
        nota: "",
        obs_mvto: ""
      },
      elemento: {
        tipo_mvto: {
          code: "1",
          label: "SALIDA"
        },
        id_elemento: "",
        cuij: "",
        id_orden_oa: "",
        detalle: "",
        estado_conservacion: "",
        ubicacion: "",
        nro_elemento: "",
        descripcion_ubicacion: "",
        categoria: ""
      },
      listaElementosAsignados: [],
      fields: [
        {
          key: "id_secuestro",
          label: "#",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "nro_nota",
          label: "NOTA",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "fecha_nota_sec",
          label: "FECHA",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "cuij",
          label: "CUIJ",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "fiscal",
          label: "FISCAL",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "nro_orden_oa",
          label: "ORDEN",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "direccion_oa",
          label: "DIRECCION",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "detalle",
          label: "ELEMENTO",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "nom_ubicacion",
          label: "UBICACION",
          sortable: true,
          sortDirection: "desc"
        },

        {
          key: "actions",
          label: "AGREGAR"
        }
      ],

      totalRows: 0, // tabla elementos
      currentPage: 1,
      perPage: 8,
      /*    pageOptions: [5, 10, 15, { value: 100, text: "Mostrar Todo" }], */
      sortBy: "",
      sortDesc: false,
      sortDirection: "asc",
      filter: null,
      filterOn: [],
      infoModal: {
        id: "info-modal",
        title: "",
        content: ""
      },

      ///////////////////////////////////////
      //////     tabla elementos elegidos
      fieldsA: [
        {
          key: "id_elemento",
          label: "#",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "detalle",
          label: "DETALLE",
          sortable: true
        },
        {
          key: "nom_categoria",
          label: "CATEGORIA",
          sortable: true
        },
        {
          key: "nom_ubicacion",
          label: "UBICACION ",
          sortable: true,
          sortDirection: "desc",
          tdClass: "fechaTable"
          // variant: 'danger'
        },
        {
          key: "actions",
          label: "QUITAR"
        }
      ],

      totalRowsA: 0, // tabla elementos asigados
      currentPageA: 1,
      perPageA: 5,
      /*    pageOptions: [5, 10, 15, { value: 100, text: "Mostrar Todo" }], */
      sortByA: "",
      sortDescA: false,
      sortDirectionA: "asc",
      filterA: null,
      filterOnA: [],
      infoModalA: {
        id: "info-modal",
        title: "",
        content: ""
      }
    };
  },

  created() {
    this.setFechaNota();
  },

  methods: {
    valorSelect() {
      // cambia el nombre del boton de confirmacion
      if (this.elemento.tipo_mvto.code == 1) {
        this.textoBotonMovimiento = "DAR SALIDA A ELEMENTOS SELECCIONADOS";
        this.tituloTablaElementos =
          "LISTADO DE ELEMENTOS DISPONIBLES EN DEPOSITO";
        this.vaciarInputsMovimiento();
      } else {
        this.textoBotonMovimiento = "REINGRESO DE LOS ELEMENTOS SELECCIONADOS";
        this.tituloTablaElementos =
          "LISTADO DE ELEMENTOS DISPONIBLES PARA REINGRESO";
        this.vaciarInputsMovimiento();
      }
    },

    setFechaNota() {
      // setea fecha_nota con fecha de HOY
      // y la fecha maxima es HOY
      const hoy = new Date(
        this.fecha_maxima.getFullYear(),
        this.fecha_maxima.getMonth(),
        this.fecha_maxima.getDate()
      );
      this.movimiento.fecha_nota_mvto = hoy;
    },

    mayusculas(value) {
      return value.toUpperCase();
    },
    msgExito() {
      this.$swal("Salida de Elementos Exitosa", "Atención", "success");
    },
    msgError(error) {
      this.$swal("A ocurrido un error!", error);
    },

    msgSinResultados() {
        this.$swal("Atención", "Sin Resultados para los parámetros ingresados", "info");
    },

    vaciarCampos() {
      // limpia campos n.i. obs, nombre y UD
      this.elemento.cuij = "";
      this.movimiento.destino_mvto = "";
      this.movimiento.persona_solicita = "";
      this.movimiento.persona_retira_devuelve = "";
      this.movimiento.nota = "";
      this.movimiento.obs_mvto = "";

      this.deshabilitado = false;
      this.totalRows = 0; // oculta card de elementos seleccionados para entrega
      this.totalRowsA = 0;
      this.listaElementosAsignados = [];
      this.elementos = [];
    },

    vaciarInputsMovimiento() {
      // limpia campos segun select tipo movimiento
      if (this.elemento.tipo_mvto.code == 1) {
        // es salida
        this.movimiento.nota = "";
        this.movimiento.persona_retira_devuelve = "";
        this.movimiento.obs_mvto = "";
        this.elemento.cuij = "";
      } else {
        // es reingreso
        this.movimiento.nota = "";
        this.movimiento.destino_mvto = "";
        this.movimiento.persona_solicita = "";
        this.movimiento.persona_retira_devuelve = "";
        this.movimiento.obs_mvto = "";
        this.elemento.cuij = "";
      }
    },

    buscar() {
      const param = this.elemento;


      axios.post("elementos/getElementosParaSalida", param).then(res => {
        if (res.data.error) {
          this.msgError(res.data.error);
          this.vaciarCampos(); // limpia campos n.i. obs, nombre y UD
        } else {
          if (res.data == 1) {
            // no encontro
            this.msgSinResultados();
          } else {
            this.elementos = res.data;
            this.deshabilitado = true;
            this.deshabilitado_persona_solicita = true;
            this.totalRows = this.elementos.length;
          }
        }
      });
    },

    agregarElementoAlListado(item) {
      try {
        this.listaElementosAsignados.push(item);
        var index = this.elementos.indexOf(item, 1);
        if (index === -1) {
          this.elementos.splice(index + 1, 1);
        } else {
          this.elementos.splice(index, 1);
        }

        this.totalRowsA = this.listaElementosAsignados.length;

        this.totalRows = this.elementos.length;
      } catch (error) {
        alert(error);
      }
    },

    quitarElementoDelListado(item) {
      var index = this.listaElementosAsignados.indexOf(item, 1);
      if (index === -1) {
        this.listaElementosAsignados.splice(index + 1, 1);
      } else {
        this.listaElementosAsignados.splice(index, 1);
      }
      this.elementos.push(item);
      this.totalRowsA = this.listaElementosAsignados.length;
      this.totalRows = this.elementos.length;
    },

    showModalConfirm() {
      // dos alerts, porque no me tomaba pasarle el mensaje (singular / plural) mediante variable
      if (this.totalRowsA == 1) {
        this.$swal({
          title: "Estás seguro de continuar?",
          text: "Si continúa se dará salida a un elemento",
          icon: "warning",
          buttons: ["Cancelar", "Aceptar"],
          confirmButtonColor: "#1CB3AA", // deprecado :-(
          dangerMode: false
        }).then(willDelete => {
          if (willDelete) {
            this.confirmarSalidaDeElemento();
          }
        });
      } else {
        this.$swal({
          title: "Estás seguro de continuar?",
          text:
            "Si continúa se dará salida a " + this.totalRowsA + " elementos",
          icon: "warning",
          buttons: ["Cancelar", "Aceptar"],
          confirmButtonColor: "#1CB3AA", // deprecado :-(
          dangerMode: false
        }).then(willDelete => {
          if (willDelete) {
            this.confirmarSalidaDeElemento();
          }
        });
      }
    },

    confirmarSalidaDeElemento() {
      const listaelementos = {
        ...this.listaElementosAsignados
      };

      const parametros = {
        ...this.movimiento,
        ...this.elemento.tipo_mvto.code // se envia solo el codigo del tipo de mvto
      };

      axios
        .post("movimientos/salidaElemento", {
          params: {
            listaelementos,
            parametros
          }
        })
        .then(res => {
          if (res.data.error) {
            this.msgError(res.data.error);
          } else {
            if (res.data) {
              this.listaElementosAsignados = [];
              this.totalRowsA = 0;
              this.vaciarCampos(); // limpia campos n.i. obs, nombre y UD
              this.msgExito();
            }
          }
        });
    },

    //////////////////METODOS actions de la tabla////////////////
    info(item, index, button) {
      this.infoModal.title = `MAS DATOS...`;
      // this.infoModal.content = JSON.stringify(item, null, 2);
      this.infoModal.content = item;
      this.$root.$emit("bv::show::modal", this.infoModal.id, button);
    },
    resetInfoModal() {
      this.infoModal.title = "";
      this.infoModal.content = "";
    },
    infoP(item, index, button) {
      // info modal
      this.infoModal.title = `Personal Nro Legajo: ${item.nro_serie}`;
      // this.infoModal.content = JSON.stringify(item, null, 2);
      this.infoModal.content = item;

      this.$root.$emit("bv::show::modal", this.infoModal.id, button);
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    onFilteredA(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRowsA = filteredItems.length;
      this.currentPageA = 1;
    }
  }
};
</script>
