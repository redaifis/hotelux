<template>
  <div class="container">
        <div class="row py-4">
        <div class="col-12">
          <h3 class="my-3">Room Availability</h3>
          <v-calendar
            :class="'rounded-0 border-0 shadow-sm'"
            :attributes="{highlight: true}"
            :disabled-dates="disabledDates"
            is-expanded
            v-if="!$store.isLoading"
          ></v-calendar>
        </div>
      </div>
    </div>
</template>

<script>
export default {
    props: ['disabledDates']
}
</script>

<style>

</style>
