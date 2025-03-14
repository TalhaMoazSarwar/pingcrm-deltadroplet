<template>
  <div>

    <Head title="Create Lead" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/leads">Leads</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.title" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Title" />
          <select-input v-model="form.organization_id" :error="form.errors.organization_id"
            class="pb-8 pr-6 w-full lg:w-1/2" label="Organization">
            <option :value="null" />
            <option v-for="organization in organizations" :key="organization.id" :value="organization.id">{{
              organization.name }}</option>
          </select-input>
          <select-input v-model="form.contact_id" :error="form.errors.contact_id" class="pb-8 pr-6 w-full lg:w-1/2"
            label="Contact">
            <option :value="null" />
            <option v-for="contact in contacts" :key="contact.id" :value="contact.id">{{ contact.first_name }}</option>
          </select-input>
          <select-input v-model="form.status" :error="form.errors.status" class="pb-8 pr-6 w-full lg:w-1/2"
            label="Status">
            <option :value="null" />
            <option value="new">New</option>
            <option value="contacted">Contacted</option>
          </select-input>
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create
            Lead</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  props: {
    organizations: Array,
    contacts: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        title: null,
        organization_id: null,
        contact_id: null,
        status: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/leads')
    },
  },
}
</script>
