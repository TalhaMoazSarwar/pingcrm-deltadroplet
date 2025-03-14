<template>
  <div>

    <Head title="Dashboard" />
    <h1 class="mb-8 text-3xl font-bold">Dashboard</h1>
    <p class="mb-8 leading-normal">Hey there! Welcome to Ping CRM, a demo app designed to help illustrate how <a
        class="text-indigo-500 hover:text-orange-600 underline" href="https://inertiajs.com">Inertia.js</a> works.</p>
    <div class="flex justify-between items-center gap-3">
      <div class="flex-1 flex flex-col items-center gap-2 border p-5 bg-white rounded-lg">
        <p class="text-xl font-bold">Organizations</p>
        <p class="font-medium">{{ this.organizations_count }}</p>
      </div>
      <div class="flex-1 flex flex-col items-center gap-2 border p-5 bg-white rounded-lg">
        <p class="text-xl font-bold">Contacts</p>
        <p class="font-medium">{{ this.contacts_count }}</p>
      </div>
      <div class="flex-1 flex flex-col items-center gap-2 border p-5 bg-white rounded-lg">
        <p class="text-xl font-bold">Leads</p>
        <p class="font-medium">{{ this.leads_count }}</p>
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
    organizations_count: Number,
    contacts_count: Number,
    leads_count: Number,
  },
}
</script>
