<template>
  <div class="container mt-5">
    <form
      id="energysheet"
      @submit.prevent="submitSitesSheet"
      enctype="multipart/form-data"
    >
      <div class="row index">
        <div class="col-12">
          <div v-if="serverError">
            {{ serverError }}
          </div>
        </div>

        <div class="col-12">
          <div class="form-group">
            <label for="sites">Sites:</label>
            <input
              type="file"
              name="energy_sheet"
              class="form-control"
              @change="sitesFile"
              id="sites"
              @focus="clearErrors"
            />
            <div v-if="siteErrors">
              <ul>
                <li v-for="error in siteErrors" style="color: red" :key="error">
                  {{ error }}
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-12 mt-2">
          <spinner-button
            type="submit"
            :show-spinner="showSpinner"
            class="btn btn-primary"
          >
            <span> Submit</span>
          </spinner-button>
        </div>
      </div>
      <div class="helper-table-container">
        <helper-table v-if="sitesErrors">
          <template #header>
            <th scope="col">Row</th>
            <th scope="col">Attribute</th>
            <th scope="col">Errors</th>
            <th scope="col">Values</th>
          </template>
          <template #body>
            <tr
              style="background-color: white; color: red"
              v-for="error in sitesErrors"
              :key="error"
            >
              <td class="text-left align-middle">{{ error.row }}</td>
              <td class="text-left align-middle">{{ error.attribute }}</td>
              <td class="text-left align-middle">
                <ul v-for="rowError in error.errors" :key="rowError">
                  <li>{{ rowError }}</li>
                </ul>
              </td>
              <td class="text-left align-middle">
                <ul>
                  <li>Site Code:{{ error.values["Site Code"] }}</li>
                  <li>Site Name:{{ error.values["Site Name"] }}</li>
                </ul>
              </td>
            </tr>
          </template>
        </helper-table>
      </div>
    </form>

    <!-- <button class="btn btn-danger" @click="getAllCascades">All cascades</button> -->

    <!-- <FileUpload
      name="demo[]"

      @upload="onTemplatedUpload($event)"
      
      accept=".xlsx"
      :maxFileSize="1000000"
      @select="onSelectedFiles"
    >
      <template
        #header="{ chooseCallback, uploadCallback, clearCallback, files }"
      >
        <div
          class="
            flex flex-wrap
            justify-content-between
            align-items-center
            flex-1
            gap-2
          "
        >
          <div class="flex gap-2">
            <Button
              @click="chooseCallback()"
              icon="pi pi-images"
              class="p-button-rounded"
            ></Button>
            <Button
              @click="uploadCallback()"
              icon="pi pi-cloud-upload"
              class="p-button-rounded p-button-success"
              :disabled="!files || files.length === 0"
            ></Button>
            <Button
              @click="clearCallback()"
              icon="pi pi-times"
              class="p-button-rounded p-button-danger"
              :disabled="!files || files.length === 0"
            ></Button>
          </div>
          <ProgressBar
            :value="totalSizePercent"
            :showValue="false"
            :class="[
              'md:w-20rem h-1rem w-full md:ml-auto',
              { 'exceeded-progress-bar': totalSizePercent > 100 },
            ]"
            ><span class="white-space-nowrap"
              >{{ totalSize }}B / 1Mb</span
            ></ProgressBar
          >
        </div>
      </template>
      <template
        #content="{ files, uploadedFiles, onUploadedFileRemove, onFileRemove }"
      >
        <div v-if="files.length > 0">
          <h5>Pending</h5>
          <div class="flex flex-wrap p-5 gap-5">
            <div
              v-for="(file, index) of files"
              :key="file.name + file.type + file.size"
              class="
                card
                m-0
                px-6
                flex flex-column
                border-1
                surface-border
                align-items-center
                gap-3
              "
            >
              <div>
                <img
                  role="presentation"
                  :alt="file.name"
                  :src="file.objectURL"
                  height="50"
                  class="shadow-2"
                />
              </div>
              <span class="font-semibold">{{ file.name }}</span>
              <div>{{ formatSize(file.size) }}</div>
              <Badge value="Pending" severity="warning" />
              <Button
                icon="pi pi-times"
                @click="onRemoveTemplatingFile(file, onFileRemove, index)"
                class="p-button-outlined p-button-danger p-button-rounded"
              />
            </div>
          </div>
        </div>

        <div v-if="uploadedFiles.length > 0">
          <h5>Completed</h5>
          <div class="flex flex-wrap p-0 sm:p-5 gap-5">
            <div
              v-for="(file, index) of uploadedFiles"
              :key="file.name + file.type + file.size"
              class="
                card
                m-0
                px-6
                flex flex-column
                border-1
                surface-border
                align-items-center
                gap-3
              "
            >
              <div>
                <img
                  role="presentation"
                  :alt="file.name"
                  :src="file.objectURL"
                  width="100"
                  class="shadow-2"
                />
              </div>
              <span class="font-semibold">{{ file.name }}</span>
              <div>{{ formatSize(file.size) }}</div>
              <Badge value="Completed" class="mt-3" severity="success" />
              <Button
                icon="pi pi-times"
                @click="onUploadedFileRemove(index)"
                class="p-button-outlined p-button-danger p-button-rounded"
              />
            </div>
          </div>
        </div>
      </template>
      <template #empty>
        <div class="flex align-items-center justify-content-center flex-column">
          <i
            class="
              pi pi-cloud-upload
              border-2 border-circle
              p-5
              text-8xl text-400
              border-400
            "
          />
          <p class="mt-4 mb-0">Drag and drop files to here to upload.</p>
        </div>
      </template>
    </FileUpload> -->
  </div>

  <modal :visible="showModal">
    <template #body>
      <p class="text-center">{{ successMessage }}</p>
    </template>
    <template #footer>
      <button class="btn btn-danger" @click="closeModal">close</button>
    </template>
  </modal>

  <button class="btn btn-info" @click="downloadAll">Download All</button>
</template>

<script>
import Sites from "../../../apis/Sites";
export default {
  name: "newSitesInsert",
  data() {
    return {
      uploadedFiles: [],
      files: [],
      totalSize: 0,
      totalSizePercent: 0,

      sites: "",
      siteErrors: null,

      sitesErrors: null,
      serverError: null,

      showModal: false,
      showSpinner: false,
      successMessage: "",
    };
  },
  computed: {
    isLogin() {
      return this.$store.state.isLogin;
    },
    isSuperAdmin() {
      let userRoles = this.$store.state.userRoles;
      let userRole = null;
      userRoles.forEach((role) => {
        if (role.name == "super-admin") {
          userRole = role.name;
        }
      });
      if (userRole) {
        return true;
      } else {
        return false;
      }
    },
  },
  beforeRouteEnter(to, from, next) {
    next((vm) => {
      if (!vm.isLogin || vm.isSuperAdmin == false) {
        return vm.$router.push(from.path);
      }
    });
  },
  methods: {
    closeModal() {
      return (this.showModal = false);
    },
    // uploadEvent(callback) {
    //   this.totalSizePercent = this.totalSize / 10;
    //   callback();
    // },
    // onRemoveTemplatingFile(file, onFileRemove, index) {
    //         onFileRemove(index);
    //         this.totalSize -= parseInt(this.formatSize(file.size));
    //         this.totalSizePercent = this.totalSize / 10;
    //     },
    //     onClearTemplatingUpload(clear) {
    //         clear();
    //         this.totalSize = 0;
    //         this.totalSizePercent = 0;
    //     },
    //     onSelectedFiles(event) {
    //         this.files = event.files;
    //         this.files.forEach((file) => {
    //             this.totalSize += parseInt(this.formatSize(file.size));
    //         });
    //     },
    //        formatSize(bytes) {
    //         if (bytes === 0) {
    //             return '0 B';
    //         }

    //         let k = 1000,
    //             dm = 3,
    //             sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
    //             i = Math.floor(Math.log(bytes) / Math.log(k));

    //         return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    //     },
    getAllCascades() {
      Sites.getAllCascades()
        .then((response) => {
          console.log(response);

          var fileUrl = window.URL.createObjectURL(new Blob([response.data]));
          var fileLink = document.createElement("a");
          fileLink.href = fileUrl;
          fileLink.setAttribute("download", "AllCascades.xlsx");
          document.body.appendChild(fileLink);
          fileLink.click();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    sitesFile(e) {
      return (this.sites = e.target.files[0]);
    },
    clearErrors() {
      this.serverError = null;

      this.sitesErrors = null;

      return;
    },
    submitSitesSheet() {
      this.serverError = null;
      this.siteErrors = null;

      this.sitesErrors = null;
      var data = {
        sites: this.sites,
      };
      this.showSpinner = true;

      Sites.submitSitesSheet(data)
        .then((response) => {
          console.log(response.data.message);
          this.successMessage = response.data.message;
          this.showModal = true;
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status == 500) {
              this.serverError = error.response.data.message;
            } else if (error.response.status == 422) {
              if (error.response.data.errors) {
                this.siteErrors = error.response.data.errors.sites;
              } else if (error.response.data.sheet_errors) {
                this.sitesErrors = error.response.data.sheet_errors;
              }
            }
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            // console.log(error.response.data);
          } else if (error.request) {
            // The request was made but no response was received
            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
            // http.ClientRequest in node.js
            console.log(error.request);
          } else {
            // Something happened in setting up the request that triggered an Error
            console.log("Error", error.message);
          }
          //   console.log(error.config);
        })
        .finally(() => {
          this.showSpinner = false;
          this.sites = "";

          var sites_sheet = document.getElementById("sites");
          sites_sheet.value = "";
        });
    },
    downloadAll() {
      Sites.downloadAll()
        .then((response) => {
          var fileUrl = window.URL.createObjectURL(new Blob([response.data]));
          var fileLink = document.createElement("a");
          fileLink.href = fileUrl;
          fileLink.setAttribute("download", "AllSites.xlsx");
          document.body.appendChild(fileLink);
          fileLink.click();
        })
        .catch();
    },
  },
};
</script>

<style lang="scss" scoped>
.index,
.helper-table-container {
  width: 70%;
  margin-left: auto;
  margin-right: auto;
}
.index {
  margin-top: 8em;
}
 ::v-deep(.custom-progress-bar) {
        .p-progressbar-value {
            background-color: #f44336;
        }
    }
</style>