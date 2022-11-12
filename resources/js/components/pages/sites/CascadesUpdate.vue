<template>
  <div class="container mt-5">
    <div class="row mt-5">
      <div class="col-12 mt-5">
        <PickList
          v-model="pickListData"
          listStyle="height:342px"
          dataKey="cascade_code"
          @move-to-target="getPickListDataDeleted"
          @move-to-source="getPickListDataDeleted"
        >
          <template #sourceheader> Available </template>
          <template #targetheader> Selected </template>
          <template #item="slotProps">
            <div class="product-item">
              <div class="product-list-detail">
                <span class="product-category">{{
                  slotProps.item.cascade_code
                }}</span>
                <span class="product-category">{{
                  slotProps.item.cascade_name
                }}</span>
              </div>
              <div class="product-list-action">
                <h6 class="mb-2">{{ slotProps.item.count }}</h6>
              </div>
            </div>
          </template>
        </PickList>
      </div>
      <div class="col-4 mt-4">
        <div class="p-inputgroup">
          <InputText placeholder="Site Code" v-model="search" />
          <Button @click="submitSearch" class="p-button-info">
            <!-- <i class="pi pi-search"></i> -->
            <ProgressSpinner
              style="width: 20px; height: 20px"
              strokeWidth="5"
              fill="var(--surface-ground)"
              animationDuration="2s"
            />
          </Button>
        </div>
      </div>
      <div class="col-4 mt-2"></div>
      <div class="col-4 mt-4">
        <Button
          label="Save"
          :disabled="isDisabled"
          icon="pi pi-check"
          iconPos="right"
          @click="updateCascades"
        />
      </div>
    </div>
  </div>
  <DynamicDialog />
  <Toast />
</template>

<script>
import Sites from "../../../apis/Sites";
import UpdateSitesTable from "./UpdateSitesTable.vue";

export default {
  data() {
    return {
      siteName: null,
      siteCode: null,
      cascades: null,

      isDisabled: true,
      newCascades: [],

      initialCascadesCount: null,

      selectedSite: null,
      pickListData: null,
      search: null,
    };
  },
  components: {
    UpdateSitesTable,
  },
  name: "CascadesUpdate",
  props: ["site_code"],

  watch: {
    site_code() {
      this.getSiteDetails();
    },
  },
  mounted() {
    this.getSiteDetails();
  },

  methods: {
    getPickListDataDeleted() {
      this.cascades = this.cascades.filter(
        (element) => this.newCascades.indexOf(element) == -1
      );
      let isFound = this.cascades.filter(
        (element) => this.pickListData[1].indexOf(element) !== -1
      );

      if (isFound.length > 0) {
        this.isDisabled = false;
        console.log(this.isDisabled);
      }
      else if (isFound.length == 0) {
        this.isDisabled = true;
        console.log(this.isDisabled);
      }
    else if (
        this.pickListData[1].length == 0 &&
        this.pickListData[0].length > this.initialCascadesCount
      ) {
        this.isDisabled = false;
        console.log(this.isDisabled);
      }
    else if (this.pickListData[0].length > this.initialCascadesCount) {
        this.isDisabled = false;
        console.log(this.isDisabled);
      }
    },
    updateCascades() {
      console.log(this.pickListData);
    },
    submitSearch() {
      Sites.getSiteDetails(this.search)
        .then((response) => {
          console.log(response);
          if (response.data.message == "No data Found") {
            this.$toast.add({
              severity: "info",
              summary: "Sorry!!!",
              detail: "No data Found",
              life: 3000,
            });
          } else {
            this.$dialog.open(UpdateSitesTable, {
              props: {
                header: "Sites",
                style: {
                  width: "75vw",
                },
                breakpoints: {
                  "960px": "75vw",
                  "640px": "90vw",
                },
              },
              data: {
                sites: [response.data.site],
              },
              onClose: (options) => {
                if (options.data) {
                  let newCascade = {
                    cascade_code: options.data.site_code,
                    cascade_name: options.data.site_name,
                    count: response.data.cascades.length,
                  };
                  let isFound = false;
                  this.pickListData[0].forEach((element) => {
                    if (element.cascade_code == newCascade.cascade_code) {
                      isFound = true;
                    }
                  });
                  if (isFound) {
                    this.$toast.add({
                      severity: "error",
                      summary: "Opes!!!",
                      detail: "already in the list of cascades",
                      life: 3000,
                    });
                  } else {
                    this.pickListData[0].push(newCascade);
                    this.newCascades.push(newCascade);

                    this.isDisabled = false;
                  }
                }
              },
            });
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 422) {
            this.$toast.add({
              severity: "error",
              summary: "Opes!!!",
              detail: error.response.data.errors.site_code[0],
              life: 3000,
            });
          }
        })
        .finally(() => {
          //   this.$emit("displayNoneSpinner", true);
        });
    },

    getSiteDetails() {
      Sites.getSiteDetails(this.site_code)
        .then((response) => {
          console.log(response);
          this.siteName = response.data.site.site_name;
          this.siteCode = response.data.site.site_code;

          this.cascades = response.data.cascades;
          this.initialCascadesCount = response.data.cascades.length;

          this.pickListData = [response.data.cascades, []];
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.product-item {
  display: flex;
  align-items: center;
  padding: 0.5rem;
  width: 100%;

  img {
    width: 75px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    margin-right: 1rem;
  }

  .product-list-detail {
    flex: 1 1 0;
  }

  .product-list-action {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
  }

  .product-category-icon {
    vertical-align: middle;
    margin-right: 0.5rem;
    font-size: 0.875rem;
  }

  .product-category {
    vertical-align: middle;
    line-height: 1;
    font-size: 0.875rem;
  }
}

@media screen and (max-width: 576px) {
  .product-item {
    flex-wrap: wrap;

    .image-container {
      width: 100%;
      text-align: center;
    }

    img {
      margin: 0 0 1rem 0;
      width: 100px;
    }
  }
}
</style>