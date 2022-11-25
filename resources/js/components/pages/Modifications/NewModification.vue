<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-12 mt-5">
        <Fieldset>
          <template #legend>{{ site_code }}-{{ site_name }} </template>
          <div class="form">
            <form @submit.prevent="insertNewModification">
              <div class="row mt-5 p-5">
                <div class="col-md-4">
                  <Dropdown
                    id="dropdown"
                    v-model="subcontractor"
                    :options="subcontractors"
                    optionLabel="subcontractor"
                    placeholder="Subcontractor"
                    class="p-invalid"
                  />
                </div>
                <div class="col-md-4">
                  <Dropdown
                    id="dropdown"
                    v-model="status"
                    :options="status_options"
                    optionLabel="status"
                    placeholder="Status"
                    class="p-invalid"
                  />
                </div>
                <div class="col-md-4">
                  <Dropdown
                    id="dropdown"
                    v-model="requester"
                    :options="requester_options"
                    optionLabel="requester"
                    placeholder="Requester"
                    class="p-invalid"
                  />
                </div>
                <div class="col-md-4">
                  <!-- <Dropdown
                    id="dropdown"
                    v-model="project"
                    :options="project_options"
                    optionLabel="project"
                    placeholder="Project"
                    class="p-invalid"
                  emptySelectionMessage
                 
                  /> -->
                  <select
                    class="form-select"
                    aria-label="Default select example"
                  >
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <span id="Action">Action:</span>
                  <Textarea
                    v-model="action"
                    :autoResize="true"
                    id="Action"
                    rows="5"
                    cols="60"
                    class="p-invalid"
                    required
                  />
                </div>
                <div class="col-12 col-md-6">
                  <!-- <Calendar
                    v-model="request_date"
                    placeholder="Request Date"
                    class="p-invalid"
                    :showIcon="true"
                    :showWeek="true"
                    dateFormat="yy/mm/dd"
                 
                  /> -->
                  <!-- <input
                    type="date"
                    v-model="request_date"
                    placeholder="Request Date"
                 
                  /> -->

                  <Datepicker
                    v-model="request_date"
                    placeholder="Request Date"
                    required
                  />
                </div>
                <div class="col-12 col-md-6">
                  <!-- <Calendar
                    v-model="finish_date"
                    placeholder="Finish Date"
                    :class="{ 'p-invalid': !finish_date }"
                    :showIcon="true"
                    :showWeek="true"
                    dateFormat="yy/mm/dd"
                  /> -->
                    <Datepicker
                    v-model="finish_date"
                    placeholder="Finish Date"
                    required
                  />
                </div>
              </div>

              <Button
                label="insert"
                type="submit"
                class="p-button-raised p-button-warning"
              />
            </form>
          </div>
        </Fieldset>
      </div>

      <div class="col-6 col-md-4"></div>
    </div>
  </div>
  <Toast />
</template>

<script>
import Modifications from "../../../apis/Modifications";
export default {
  data() {
    return {
      subcontractor: null,
      cost: null,
      subcontractors: [
        { subcontractor: "OT" },
        { subcontractor: "Alandick" },
        { subcontractor: "Tri-Tech" },
        { subcontractor: "Siatnile" },
        { subcontractor: "Merc" },
        { subcontractor: "GP" },
        { subcontractor: "MBV" },
        { subcontractor: "Systel" },
        { subcontractor: "TELE-TECH" },
        { subcontractor: "SAG" },
        { subcontractor: "LM" },
      ],
      request_date: null,
      requester: null,
      requester_options: [
        { requester: "Acquisition" },
        { requester: "Civil Team" },
        { requester: "Maintenance" },
        { requester: "Radio" },
        { requester: "Transmission" },
        { requester: "rollout" },
        { requester: "GA" },
        { requester: "Sharing team" },
      ],
      project: null,
      project_options: [
        { project: "Normal Modification" },
        { project: "LTE" },
        { project: "Critical repair" },
        { project: "Repair" },
        { project: "LDN" },
        { project: "Retrofitting" },
        { project: "Adding sec" },
        { project: "NTRA" },
      ],
      status: null,
      status_options: [
        { status: "waiting D6" },
        { status: "done" },
        { status: "in progress" },
      ],
      finish_date: null,
      action: null,
      materials: null,
    };
  },
  name: "NewModification",
  props: ["site_code", "site_name"],
  emits: ["displayNoneSpinner"],
  watch: {
    site_code() {
      this.getSiteModifications();
    },
  },
  mounted() {},

  methods: {
    insertNewModification() {
      this.$emit("displayNoneSpinner", false);
      let data = {
        siteCode: this.site_code,
        siteName: this.site_name,
        subcontractor: this.subcontractor,
        requester: this.requester,
        request_date: this.request_date,
        finish_date: this.finish_date,
        cost: this.cost,
        project: this.project,
        status: this.status,
        action: this.action,
        materials: this.materials,
      };
      console.log(data);
      Modifications.insertNewModification(data)
        .then((response) => {
          console.log(response);
          this.$toast.add({
            severity: "success",
            summary: "Success Message",
            detail: "inserted Successfully",
            life: 6000,
          });
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 422) {
            let errors = error.response.data.errors;

            if (errors.siteCode) {
              errors.siteCode.forEach((element) => {
                this.$toast.add({
                  severity: "error",
                  summary: "Failed",
                  detail: element,
                  life: 3000,
                });
              });
            }
            if (errors.siteName) {
              errors.siteName.forEach((element) => {
                this.$toast.add({
                  severity: "error",
                  summary: "Failed",
                  detail: element,
                  life: 3000,
                });
              });
            }
            if (errors.subcontractor) {
              errors.subcontractor.forEach((element) => {
                this.$toast.add({
                  severity: "error",
                  summary: "Failed",
                  detail: element,
                  life: 3000,
                });
              });
            }
            if (errors.project) {
              errors.project.forEach((element) => {
                this.$toast.add({
                  severity: "error",
                  summary: "Failed",
                  detail: element,
                  life: 3000,
                });
              });
            }
            if (errors.status) {
              errors.status.forEach((element) => {
                this.$toast.add({
                  severity: "error",
                  summary: "Failed",
                  detail: element,
                  life: 3000,
                });
              });
            }
            if (errors.requester) {
              errors.requester.forEach((element) => {
                this.$toast.add({
                  severity: "error",
                  summary: "Failed",
                  detail: element,
                  life: 3000,
                });
              });
            }
            if (errors.request_date) {
              errors.request_date.forEach((element) => {
                this.$toast.add({
                  severity: "error",
                  summary: "Failed",
                  detail: element,
                  life: 3000,
                });
              });
            }
            if (errors.finish_date) {
              errors.finish_date.forEach((element) => {
                this.$toast.add({
                  severity: "error",
                  summary: "Failed",
                  detail: element,
                  life: 3000,
                });
              });
            }
            if (errors.cost) {
              errors.cost.forEach((element) => {
                this.$toast.add({
                  severity: "error",
                  summary: "Failed",
                  detail: element,
                  life: 3000,
                });
              });
            }
            if (errors.materials) {
              errors.materials.forEach((element) => {
                this.$toast.add({
                  severity: "error",
                  summary: "Failed",
                  detail: element,
                  life: 3000,
                });
              });
            }
            if (errors.action) {
              errors.action.forEach((element) => {
                this.$toast.add({
                  severity: "error",
                  summary: "Failed",
                  detail: element,
                  life: 3000,
                });
              });
            }
          }
        })
        .finally(() => {
          this.$emit("displayNoneSpinner", true);
        });
    },
  },
};
</script>

<style lang="scss" scoped>




::v-deep(.p-fieldset) {
  position: relative;

  .p-fieldset-legend {
    width: 25%;
    color: white;
    text-align: center;
    position: absolute;
    top: 20px;
    left: 50px;
    z-index: 2;
    background-color: rgba($color: gray, $alpha: 1);
  }

  .p-button {
    background-color: #79589f !important;
    border-color: #79589f !important;
  }
  .p-inputtext {
    border-color: #79589f;
  }
  .p-inputtext:focus {
    box-shadow: 0px 0px 3px 2px #79589f !important;
  }

  .p-inputtextarea {
    resize: none;
    width: 100%;
  }
}

// $dp__border_radius: 30px !default;

.form-select option:hover{
  background-color: #79589f !important;
}
.dp__theme_light {
  --dp-text-color: red;

  --dp-icon-color: #79589f;

  --dp-border-color: #79589f;
}

.form {
  margin-top: 50px;
  width: 100%;
  border: 1px solid black;
  border-radius: 5px;
}
@media screen and (max-width: 576px) {
}
</style>