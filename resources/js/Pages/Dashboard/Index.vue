<template>
  <div>

    <Head title="Dashboard" />
    <h1 class="mb-8 text-3xl font-bold">Dashboard</h1>
    <p class="mb-8 leading-normal">Hey there! Welcome to Ping CRM, a demo app designed to help illustrate how <a
        class="text-indigo-500 hover:text-orange-600 underline" href="https://inertiajs.com">Inertia.js</a> works.</p>
    <div class="grid grid-cols-3 items-center gap-3">
      <div v-for="(value, key) in this.stats" class="flex flex-col items-center gap-2 border p-5 bg-white rounded-lg">
        <p class="text-xl font-bold">{{ key }}</p>
        <p class="text-lg font-medium">{{ value }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'

export default {
  components: {
    Head,
  },
  layout: Layout,
  props: {
    stats: Array
  },
}
</script>
