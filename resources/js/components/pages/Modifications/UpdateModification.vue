<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-12 mt-5">
        <Fieldset>
          <template #legend>{{ site_code }}-{{ site_name }} </template>
          <div class="form">
            <form>
              <div class="row mt-5 p-5">
                <div class="col-md-4">
                  <Dropdown
                    id="dropdown"
                    v-model="subcontractor"
                    :options="subcontractors"
                    optionLabel="subcontractor"
                    placeholder="Subcontractor"
                    class="p-invalid"
                    :editable="true"
                  />
                </div>
                <div class="col-md-4">
                  <Dropdown
                    id="dropdown"
                    v-model="status"
                    :options="status_options"
                    optionLabel="status"
                    placeholder="Status"
                    :editable="true"
                    class="p-invalid"
                  />
                </div>
                <div class="col-md-4">
                  <Dropdown
                    id="dropdown"
                    v-model="requester"
                    :options="requester_options"
                    optionLabel="name"
                    placeholder="Requester"
                    class="p-invalid"
                    :editable="true"
                  />
                </div>
                <div class="col-md-4">
                  <Dropdown
                    id="dropdown"
                    v-model="project"
                    :options="project_options"
                   :editable="true"
                  
                    optionLabel="project"
                  
                  
                    class="p-invalid"
                   
                  />
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
                  />
                </div>
                <div class="col-12 col-md-6">
                  <Calendar
                    v-model="request_date"
                    placeholder="Request Date"
                    class="p-invalid"
                    :showIcon="true"
                    :showWeek="true"
                  />
                </div>
                <div class="col-12 col-md-6">
                  <Calendar
                    v-model="finish_date"
                    placeholder="Finish Date"
                    :class="{ 'p-invalid': !finish_date }"
                    :showIcon="true"
                    :showWeek="true"
                  />
                </div>
              </div>

              <Button
                label="Update"
                type="submit"
                @click="updateModification"
                class="p-button-raised p-button-warning"
              />
            </form>
          </div>
        </Fieldset>
      </div>
    </div>
  </div>
</template>

<script>
import Modifications from "../../../apis/Modifications";
export default {
  data() {
    return {
      subcontractor: null,
      site_code: null,
      site_name: null,
      subcontractors: [{subcontractor:"OT"},{subcontractor:"Alandick"},{subcontractor:"Tri-Tech"},{subcontractor:"Siatnile"},{subcontractor:"Merc"},{subcontractor:"GP"},{subcontractor:"MBV"},{subcontractor:"Systel"},{subcontractor:"TELE-TECH"},{subcontractor:"SAG"},{subcontractor:"LM"}],
      request_date: null,
      requester: null,
      requester_options: [{requester:"Acquisition"},{requester:"Civil Team"},{requester:"Maintenance"},{requester:"Radio"},{requester:"Transmission"},{requester:"rollout"},{requester:"GA"},{requester:"Sharing team"}],
      project: null,
      project_options: [{project:"Normal Modification"},{project:"LTE"},{project:"Critical repair"},{project:"Repair"},{project:"LDN"},{project:"Retrofitting"},{project:"Adding sec"},{project:"NTRA"}],
      status: null,
      status_options: [{status:"waiting D6"},{status:"done"},{status:"in progress"}],
      finish_date: null,
      action: null,
    };
  },
  name: "UpdateModification",
  props: ["id"],
  emits: ["displayNoneSpinner"],
  watch: {
    id() {
      this.getModificationDetails();
    },
  },
  mounted() {
    this.getModificationDetails();
  },
  
  methods: {
    getModificationDetails() {
      this.$emit("displayNoneSpinner", false);
      Modifications.getModificationDetails(this.id)
        .then((response) => {
          console.log(response);
          this.site_code = response.data.details.site_code;
          this.subcontractor = response.data.details.subcontractor;

          this.site_name = response.data.details.site_name;

          this.request_date = response.data.details.request_date;
          this.requester = response.data.details.requester;
          // requester_options=response.data.details.;
          this.project = response.data.details.project;
          // project_options: null,
          this.status = response.data.details.status;
          // status_options: null,
          this.finish_date = response.data.details.finish_date;
          this.action = response.data.details.action;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.$emit("displayNoneSpinner", true);
        });
    },
    updateModification() {},
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
}
::v-deep(.p-calendar) {
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