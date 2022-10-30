<template>
  <section id="analysis">
    <div class="container">
      <Dialog v-model:visible="display" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}">
        <template #header>
          <h3>Header</h3>
        </template>

        Content

        <template #footer>
          <Button label="No" icon="pi pi-times" class="p-button-text" />
          <Button label="Yes" icon="pi pi-check"  />
        </template>
      </Dialog>

      <div class="form-container">
        <div v-if="serverError">
          <p style="color: red">{{ serverError }}</p>
        </div>
        <form @submit.prevent="submitFilterForm">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="column">Filter By:</label>
                <select class="form-control" @change="submitColumn" id="column">
                  <option value=""></option>
                  <option v-for="column in columns" :key="column">
                    {{ column }}
                  </option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label></label>
                <select
                  class="form-control"
                  @change="submitColumnValue"
                  id="columnValue"
                >
                  <option value=""></option>
                  <option v-for="value in columnValues" :key="value">
                    {{ value }}
                  </option>
                </select>
              </div>
            </div>

            <div class="col-12">
              <div class="button-container">
                <button
                  class="btn btn-primary"
                  :disabled="disabled"
                  type="submit"
                >
                  submit
                </button>
                <!-- <button class="btn btn-primary"[disabled]='!isDataFound'  (click)="downloadsites()">Excel Export</button> -->
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
import Modifications from "../../../apis/Modifications";

export default {
  data() {
    return {
      column: null,
      columnValue: null,
      columns: null,
      columnValues: null,
      status: null,
      subcontractor: null,
      project: null,
      requester: null,
      serverError: null,
      display: true,
    };
  },
  name: "modifications",
  computed: {
    disabled() {
      if (!this.column || !this.columnValue) {

        return true;
      }
      if (this.column && this.columnValue) {
     
        return false;
      }
    },
  },
  mounted() {
    this.getModificationAnalysis();
  },
  methods: {
    submitColumn(e) {
      this.column = e.target.value;

      if (this.column == "status") {
        this.columnValues = this.status;
      } else if (this.column == "subcontractor") {
        this.columnValues = this.subcontractor;
      } else if (this.column == "requester") {
        this.columnValues = this.requester;
      } else if (this.column == "project") {
        this.columnValues = this.project;
      }
    },
    submitColumnValue(e) {
      this.columnValue = e.target.value;
    },
    getModificationAnalysis() {
      Modifications.getModificationAnalysis()
        .then((response) => {

          this.status = response.data.index.status;
          this.subcontractor = response.data.index.subcontractor;
          this.project = response.data.index.project;
          this.requester = response.data.index.requester;
          this.columns = ["status", "subcontractor", "requester", "project"];
        })
        .catch((error) => {
       
          if (error.response.status == 500) {
            this.serverError = error.response.data.message;
          }
        });
    },
    submitFilterForm() {
      let data={
        columnName:this.column,
        columnValue:this.columnValue
      };
      console.log(data);
      Modifications.getModificationIndex(data).then(response=>{
        console.log(response);
        this.$store.dispatch("modificationIndex",response.data.modifications);
        this.$router.push("/modifications/index");

      }).catch(error=>{
        console.log(error);

      })
    },
  },
};
</script>

<style lang="scss" scoped>
#analysis {
  margin-top: 200px;
  .container {
    margin: auto;
    .form-container {
      width: 60%;
      margin: auto;
      .form-group {
        // width: 50%;
        // margin: auto;
        label {
          color: white;
        }
      }
    }

    .button-container {
      width: 50%;
      margin: auto;
      padding-top: 2rem;
      display: flex;
      align-items: center;
      justify-content: space-around;
    }
  }
}

@media screen and (max-width: 575px) {
  #analysis {
    .container {
      .form-container {
        width: 100%;
      }

      .button-container {
        width: 100%;
      }
    }
  }
}

@media (min-width: 576px) and (max-width: 767px) {
  #analysis {
    .container {
      .form-container {
        width: 100%;
      }

      .button-container {
        width: 100%;
      }
    }
  }
}
@media (min-width: 768px) and (max-width: 991px) {
  #analysis {
    .container {
      .form-container {
        width: 100%;
      }

      .button-container {
        width: 100%;

        display: flex;
        justify-content: space-around;
        align-items: center;
      }
    }
  }
}
@media (min-width: 992px) and (max-width: 1199px) {
}
@media (min-width: 1200px) and (max-width: 1500px) /* extra large windows*/ {
}
</style>