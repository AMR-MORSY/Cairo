<template>
  <table class="table table-hover table-bordered">
    <thead>
      <tr class="text-center align-middle">
       <slot name="header"></slot>
      </tr>
    </thead>
    <tbody>
      <!-- <tr style="background-color: black; color: white">
        <td class="text-center align-middle"></td>
        <td class="text-center align-middle"></td>
        <td class="text-center align-middle"></td>
      </tr>

      <tr>
        <td class="text-center align-middle"></td>
        <td class="text-center align-middle"></td>
        <td></td>
      </tr> -->
      <slot name="body"></slot>
    </tbody>
  </table>
</template>

<script>
export default {
  name: "helperTable",
};
</script>

<style lang="scss" scoped>
</style>