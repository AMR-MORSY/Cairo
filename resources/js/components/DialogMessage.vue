<template>
  <Dialog
    v-model:visible="displayDialog"
    :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
    :style="{ width: '50vw' }"
    position="center"
    :modal="true"
    :closable="false"
  >
    <template #header>
        
      <h3><i class="pi pi-exclamation-triangle" style="font-size: 2rem; color:red" ></i> Message</h3>
    </template>
    <p class="m-0" style="font-size: 1.2rem; font-weight:500;">{{ dialogMessage }}</p>
    <template #footer>
      <Button label="Ok" icon="pi pi-check" style="background-color:red !important;" @click="closeDialog" autofocus />
    </template>
  </Dialog>
</template>

<script>
export default {
  data() {
    return {};
  },
  props: ["displayDialog", "dialogMessage"],
  name: "DialogMessage",
  methods: {
    closeDialog() {
      this.$store.dispatch("displayDialog",false) ;
      this.$store.dispatch("dialogMessage",'');
    },
  },
};
</script>

<style lang="scss" scoped>
</style>