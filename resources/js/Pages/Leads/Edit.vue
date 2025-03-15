<template>
  <div>

    <Head :title="form.title" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/leads">Leads</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.title }}
    </h1>
    <trashed-message v-if="lead.deleted_at" class="mb-6" @restore="restore"> This lead has been deleted.
    </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.title" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Title" />
          <select-input v-model="form.organization_id" :error="form.errors.organization_id"
            class="pb-8 pr-6 w-full lg:w-1/2" label="Organization">
            <!-- <option :value="null" /> -->
            <option v-for="organization in organizations" :key="organization.id" :value="organization.id">{{
              organization.name }}</option>
          </select-input>
          <select-input v-model="form.contact_id" :error="form.errors.contact_id" class="pb-8 pr-6 w-full lg:w-1/2"
            label="Contact">
            <!-- <option :value="null" /> -->
            <option v-for="contact in contacts" :key="contact.id" :value="contact.id">{{
              contact.first_name }}</option>
          </select-input>
          <select-input v-model="form.status" :error="form.errors.status" class="pb-8 pr-6 w-full lg:w-1/2"
            label="Status">
            <!-- <option :value="null" /> -->
            <option v-for="status in statuses" :key="status.value" :value="status.value">{{ status.label }}</option>
          </select-input>
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!lead.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button"
            @click="destroy">Delete Lead</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update
            Lead</loading-button>
        </div>
      </form>
    </div>
    <!-- <h2 class="mt-12 text-2xl font-bold">Contacts</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Name</th>
          <th class="pb-4 pt-6 px-6">City</th>
          <th class="pb-4 pt-6 px-6" colspan="2">Phone</th>
        </tr>
        <tr v-for="contact in lead.contacts" :key="contact.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/contacts/${contact.id}/edit`">
            {{ contact.name }}
            <icon v-if="contact.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
            {{ contact.city }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
            {{ contact.phone }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="lead.contacts.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No contacts found.</td>
        </tr>
      </table>
    </div> -->
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import TrashedMessage from '@/Shared/TrashedMessage.vue'

export default {
  components: {
    Head,
    Icon,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    lead: Object,
    organizations: Array,
    contacts: Array,
    statuses: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        title: this.lead.title,
        organization_id: this.lead.organization_id,
        contact_id: this.lead.contact_id,
        status: this.lead.status,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/leads/${this.lead.id}`)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this lead?')) {
        this.$inertia.delete(`/leads/${this.lead.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this lead?')) {
        this.$inertia.put(`/leads/${this.lead.id}/restore`)
      }
    },
  },
}
</script>
