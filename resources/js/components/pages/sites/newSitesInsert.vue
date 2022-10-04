<template>
  <div class="container mt-5">
    <form
      id="energysheet"
      @submit.prevent="submitSitesSheet"
      enctype="multipart/form-data"
    >
      <div class="row index mt-5">
        <div class="col-12">
          <div v-if="isServerError">
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
            <div v-if="isSitesError">
              <ul>
                <li
                  v-for="error in sitesErrors"
                  style="color: red"
                  :key="error"
                >
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
    </form>
  </div>
  <modal variant="danger" :visible="showModal">
    <p class="text-center">{{ successMessage }}</p>
  </modal>
  <helper-table>
    <template #header>
      <th scope="col">Row</th>
      <th scope="col">Attribute</th>
      <th scope="col">Errors</th>
      <th scope="col">Values</th>
    </template>
    <template #body>
      <tr
        style="background-color: black; color: white"
        v-for="error in sitesErrors"
        :key="error"
      >
        <td class="text-left align-middle">{{ error.row }}</td>
        <td class="text-left align-middle">{{ error.attribute}}</td>
        <td class="text-left align-middle"><ul v-for="rowError in error.errors" :key="rowError"><li>{{rowError}}</li></ul></td>
        <td class="text-left align-middle"><ul><li>Site Code:{{error.values["Site Code"]}}</li><li>Site Name:{{error.values["Site Name"]}}</li></ul></td>
      </tr>
    </template>
  </helper-table>
</template>

<script>
export default {
  name: "newSitesInsert",
  data() {
    return {
      sites: "",
      isSitesError: false,
      sitesErrors: [],
      serverError: "",
      isServerError: false,
      showModal: false,
      showSpinner: false,
      successMessage: "",
    };
  },
  methods: {
    sitesFile(e) {
      return (this.sites = e.target.files[0]);
    },
    clearErrors() {
      this.serverError = "";
      this.isServerError = false;
      this.sitesErrors = [];
      this.isSitesError = false;
      return;
    },
    submitSitesSheet() {
      var data = {
        sites: this.sites,
      };
      this.showSpinner = true;

      axios
        .post("/api/sites/store", data, {
          headers: {
            "Content-Type": "multipart/form-data",
            responseType: "json",
          },
        })
        .then((response) => {
          console.log(response.data.message);
          this.successMessage = response.data.message;
          this.showModal = true;
          // this.weeks = response.data.weeks;
          // this.years = response.data.years;
          //   console.log(isResponseGot);
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status == "500") {
              this.serverError = "internal server error";
              this.isServerError = true;
            }
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            // console.log(error.response.data);
            if (error.response.data) {
              var errors = error.response.data.errors;
              console.log(errors);
              if (errors.sites) {
                this.sitesErrors = errors.sites;
                this.isSitesError = true;
              } else {
                this.sitesErrors = errors;
                this.isSitesError = true;
              }
            }
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
  },
};
</script>

<style lang="scss" scoped>
</style>