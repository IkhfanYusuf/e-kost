<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<template>
  <AppLayout title="Pengguna">
    <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template> -->

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <Link
          :href="route('users.kost.index')"
          :class="{
            'bg-black text-white': $page.url === '/users-kost',
            'bg-black text-black': !$page.url === '/users-kost',
          }"
          class="
            inline-block
            mb-4
            px-4
            py-2
            font-semibold
            text-sm
            rounded-full
            border border-black
            mr-2
          "
        >
          Anak Kost Aktif
        </Link>
        <Link
          :href="route('users.kost.history')"
          :class="{
            'bg-black text-white': $page.url === '/users-kost/history',
            'bg-black text-black': !$page.url === '/users-kost/history',
          }"
          class="
            inline-block
            mb-4
            px-4
            py-2
            font-semibold
            text-sm
            border border-black
            rounded-full
            mr-2
          "
        >
          Riwayat Anak Kost
        </Link>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <table class="min-w-full leading-normal">
            <thead>
              <tr>
                <th
                  class="
                    px-5
                    py-3
                    border-b-2 border-gray-200
                    text-left text-xs
                    font-semibold
                    text-gray-600
                    uppercase
                    tracking-wider
                  "
                >
                  Nama
                </th>
                <th
                  class="
                    px-5
                    py-3
                    border-b-2 border-gray-200
                    text-left text-xs
                    font-semibold
                    text-gray-600
                    uppercase
                    tracking-wider
                  "
                >
                  No Kamar
                </th>
                <th
                  class="
                    px-5
                    py-3
                    border-b-2 border-gray-200
                    text-left text-xs
                    font-semibold
                    text-gray-600
                    uppercase
                    tracking-wider
                  "
                >
                  No Telpon
                </th>
                <th
                  class="
                    px-5
                    py-3
                    border-b-2 border-gray-200
                    text-left text-xs
                    font-semibold
                    text-gray-600
                    uppercase
                    tracking-wider
                  "
                >
                  Jenis Kelamin
                </th>

                <th
                  class="
                    px-5
                    py-3
                    border-b-2 border-gray-200
                    text-left text-xs
                    font-semibold
                    text-gray-600
                    uppercase
                    tracking-wider
                  "
                >
                  Tanggal Keluar
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in users" v-bind:key="item.id">
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <div class="flex items-center">
                    <!-- <div class="flex-shrink-0 w-10 h-10">
                      <img
                        class="w-full h-full rounded-full"
                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                        alt=""
                      />
                    </div> -->
                    <div class="ml-3">
                      <p class="text-gray-900 whitespace-no-wrap">
                        {{ item.name }}
                      </p>
                    </div>
                  </div>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">
                    {{ item.room.room_name }}
                  </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">
                    {{ item.phone }}
                  </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">
                    {{ item.gender }}
                  </p>
                </td>

                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">
                    {{ item.deleted_at }}
                  </p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import Swal from "sweetalert2";
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      modalAddAccount: false,
      form: useForm({
        name: "",
        email: "",
        gender: "",
        phone: "",
        password: "",
        role: "",
      }),
    };
  },
  methods: {
    clearForm() {
      //clear form
      this.form.name = "";
      this.form.email = "";
      this.form.gender = "";
      this.form.phone = "";
      this.form.password = "";
      this.form.role = "";
    },
    handleModal(value) {
      this.modalAddAccount = value;
    },
    handleActive(id, name) {
      Swal.fire({
        title: "Anda yakin?",
        text: `kamu akan mengaktifkan akun ${name} sebagai anak kos!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, aktifkan!",
        cancelButtonText: "Batalkan!",
      }).then((result) => {
        if (result.isConfirmed) {
          Inertia.patch(`/users/${id}`);
        }
      });
    },
    handleDelete(id, name) {
      Swal.fire({
        title: "Anda yakin?",
        text: `kamu akan menonaktifkan akun ${name} dari anak kos!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Nonaktifkan!",
        cancelButtonText: "Batalkan!",
      }).then((result) => {
        if (result.isConfirmed) {
          Inertia.delete(`/users/${id}`);
        }
      });
    },
    handleSubmit() {
      this.form.post("/users", {
        onSuccess: () => {
          this.handleModal(false);
          Swal.fire({
            title: "Data ditambahkan!",
            text: `kamu berhasil menambahkan ${this.form.name} sebagai ${this.form.role} kos!`,
            icon: "success",
          });
        },
      });
    },
  },
  props: {
    users: Object,
    errors: Object,
  },
};
</script>