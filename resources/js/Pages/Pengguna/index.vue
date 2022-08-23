<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<template>
  <div :class="{
    block: modalAddAccount,
    hidden: !modalAddAccount,
  }" class="
      modal-container
      top-0
      left-0
      transform
      z-20
      fixed
      w-full
      h-full
      bg-black bg-opacity-50
      transition
      ease-in-out
      duration-150
    "></div>
  <div :class="{
    'translate-y-1/4': modalAddAccount,
    '-translate-y-full': !modalAddAccount,
  }" class="
      modal
      absolute
      rounded
      w-5/6
      md:w-1/3
      bg-white
      left-1/2
      top-0
      transform
      z-20
      transition
      ease-in-out
      duration-500
      -translate-x-1/2
    ">
    <div class="modal-header p-4 flex items-center justify-between">
      <h1 class="text-gray-900 text-lg font-semibold">Tambah Akun</h1>
      <svg @click="
  handleModal(false);
clearForm();
      " xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
          clip-rule="evenodd" />
      </svg>
    </div>
    <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
      <div class="modal-body p-4">
        <div class="mb-3 flex">
          <div class="mr-2">
            <label for="" class="block mb-1 font-bold opacity-50">Nama</label>
            <input v-model="form.name" type="text" class="
                w-full
                outline-none
                border border-text
                text-sm
                px-4
                py-2
                rounded
              " placeholder="nama" />
            <div class="mb-2 text-red-400 text-sm" v-if="errors.name">
              {{ errors.name }}
            </div>
          </div>
          <div>
            <label for="" class="block mb-1 font-bold opacity-50">Username</label>
            <input v-model="form.username" type="text" class="
                w-full
                outline-none
                border border-text
                text-sm
                px-4
                py-2
                rounded
              " placeholder="username" />
            <div class="mb-2 text-red-400 text-sm" v-if="errors.username">
              {{ errors.username }}
            </div>
          </div>
        </div>

        <div class="mb-3 flex">
          <div class="mr-2 w-full">
            <label for="" class="block mb-1 font-bold opacity-50">Jenis Kelamin</label>
            <select v-model="form.gender" class="
                w-full
                outline-none
                border border-text
                text-sm
                px-4
                py-2
                rounded
              ">
              <option value="" default>- Jenis Kelamin -</option>
              <option value="laki-laki">Laki-laki</option>
              <option value="perempuan">Perempuan</option>
            </select>
            <div class="mb-2 text-red-400 text-sm" v-if="errors.gender">
              {{ errors.gender }}
            </div>
          </div>
          <div class="w-full">
            <label for="" class="block mb-1 font-bold opacity-50">Jabatan</label>
            <select v-model="form.role" class="
                w-full
                outline-none
                border border-text
                text-sm
                px-4
                py-2
                rounded
              ">
              <option value="" default>- Pilih Jabatan -</option>
              <option value="pemilik">Pemilik</option>
              <option value="staf">Staf</option>
              <option value="anak-kost">Penghuni Kost</option>
            </select>
            <div class="mb-2 text-red-400 text-sm" v-if="errors.role">
              {{ errors.role }}
            </div>
          </div>
        </div>
        <div class="mb-3 flex" v-if="form.role === 'anak-kost'">
          <div class="mr-2 w-full">
            <label for="" class="block mb-1 font-bold opacity-50">Tanggal Masuk</label>
            <input v-model="form.entry" type="date" class="
                grow
                w-full
                outline-none
                border border-text
                text-sm
                px-4
                py-2
                rounded
                mr-2
              " placeholder="Entry Date" />
            <div class="mb-3 text-red-400 text-sm" v-if="errors.entry">
              {{ errors.entry }}
            </div>
          </div>
          <div class="w-full">
            <label for="" class="block mb-1 font-bold opacity-50">Nama</label>
            <select v-model="form.room" class="
                w-full
                outline-none
                border border-text
                text-sm
                px-4
                py-2
                rounded
              ">
              <option value="" default>- Pilih Kamar -</option>
              <option v-for="item in rooms" :value="item.id" :key="item.id">
                {{ item.room_name }}
              </option>
            </select>
            <div class="mb-3 text-red-400 text-sm" v-if="errors.room">
              {{ errors.room }}
            </div>
          </div>
        </div>

        <div class="mb-3 flex" v-if="form.role === 'anak-kost'">
          <div class="mr-2 w-full">
            <label for="" class="block mb-1 font-bold opacity-50">Nomor KTP</label>
            <input v-model="form.id_card" type="text" class="
                grow
                w-full
                outline-none
                border border-text
                text-sm
                px-4
                py-2
                rounded
                mr-2
              " placeholder="No KTP" />
            <div class="mb-3 text-red-400 text-sm" v-if="errors.id_card">
              {{ errors.id_card }}
            </div>
          </div>
          <div class="w-full">
            <label for="" class="block mb-1 font-bold opacity-50">Gambar KTP</label>
            <input @input="form.id_card_img = $event.target.files[0]" type="file" class="
                grow
                w-full
                outline-none
                border border-text
                text-sm
                px-2
                py-2
                rounded
              " placeholder="Entry Date" />
            <div class="mb-3 text-red-400 text-sm" v-if="errors.id_card_img">
              {{ errors.id_card_img }}
            </div>
          </div>
        </div>

        <div class="mb-3 flex">
          <div class="mr-2 w-full">
            <label for="" class="block mb-1 font-bold opacity-50">No. Telp</label>
            <input v-model="form.phone" type="text" class="
                w-full
                outline-none
                border border-text
                text-sm
                px-4
                py-2
                rounded
              " placeholder="No Telpon" />
            <div class="mb-3 text-red-400 text-sm" v-if="errors.phone">
              {{ errors.phone }}
            </div>
          </div>

          <div class="w-full">
            <label for="" class="block mb-1 font-bold opacity-50">Password</label>
            <input v-model="form.password" type="password" class="
                w-full
                outline-none
                border border-text
                text-sm
                px-4
                py-2
                rounded
              " placeholder="password" />
            <div class="mb-3 text-red-400 text-sm" v-if="errors.password">
              {{ errors.password }}
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer p-4 pt-0">
        <button class="
            flex
            items-center
            py-2
            px-4
            text-white text-sm
            bg-black
            rounded-lg
          ">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z"
              clip-rule="evenodd" />
          </svg>
          <span class="ml-2">Simpan</span>
        </button>
      </div>
    </form>
  </div>
  <AppLayout title="Pengguna">
    <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template> -->

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <button v-if="$page.props.auth.role === 'admin'" @click="handleModal(true)" class="
            mb-4
            px-4
            py-2
            font-bold
            text-sm
            bg-green-400
            hover:bg-green-500
            rounded-full
            text-white
            mr-2
          ">
          Tambah Pengguna
        </button>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <!-- <ul v-for="item in users">
            <li @key="item.id">{{ item.name }}</li>
          </ul> -->
          <!-- component -->
          <!--<div class="bg-white p-8 rounded-md w-full">
            <div class="flex items-center justify-between pb-6">
              <div>
                <h2 class="text-gray-600 font-semibold">Products Oder</h2>
                <span class="text-xs">All products item</span>
              </div>
              <div class="flex items-center justify-between">
                <div class="flex bg-gray-50 items-center p-2 rounded-md">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-gray-400"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  <input
                    class="bg-gray-50 outline-none ml-1 block"
                    type="text"
                    name=""
                    id=""
                    placeholder="search..."
                  />
                </div>
                <div class="lg:ml-40 ml-10 space-x-8">
                  <button
                    class="
                      bg-indigo-600
                      px-4
                      py-2
                      rounded-md
                      text-white
                      font-semibold
                      tracking-wide
                      cursor-pointer
                    "
                  >
                    New Report
                  </button>
                  <button
                    class="
                      bg-indigo-600
                      px-4
                      py-2
                      rounded-md
                      text-white
                      font-semibold
                      tracking-wide
                      cursor-pointer
                    "
                  >
                    Create
                  </button>
                </div>
              </div>
            </div>
            <div>
              <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div
                  class="
                    inline-block
                    min-w-full
                    shadow
                    rounded-lg
                    overflow-hidden
                  "
                > -->
          <div class="flex justify-end mb-4">
            <input v-model="params.search" type="text" class="rounded-full px-3 py-2 text-sm font-semibold"
              placeholder="search" />
          </div>
          <table class="min-w-full leading-normal">
            <thead>
              <tr>
                <th class="
                    px-5
                    py-3
                    border-b-2 border-gray-200
                    text-left text-xs
                    font-semibold
                    text-gray-600
                    uppercase
                    tracking-wider
                  ">
                  Nama
                </th>
                <th class="
                    px-5
                    py-3
                    border-b-2 border-gray-200
                    text-left text-xs
                    font-semibold
                    text-gray-600
                    uppercase
                    tracking-wider
                  ">
                  Jabatan
                </th>
                <!-- <th
                  class="
                    px-5
                    py-3
                    border-b-2 border-gray-200
                    bg-gray-100
                    text-left text-xs
                    font-semibold
                    text-gray-600
                    uppercase
                    tracking-wider
                  "
                >
                  Created at
                </th> -->
                <!-- <th
                  class="
                    px-5
                    py-3
                    border-b-2 border-gray-200
                    bg-gray-100
                    text-left text-xs
                    font-semibold
                    text-gray-600
                    uppercase
                    tracking-wider
                  "
                >
                  QRT
                </th> -->
                <!-- </th> -->

                <th class="
                    px-5
                    py-3
                    border-b-2 border-gray-200
                    text-left text-xs
                    font-semibold
                    text-gray-600
                    uppercase
                    tracking-wider
                  ">
                  Status
                </th>

                <th class="
                    px-5
                    py-3
                    border-b-2 border-gray-200
                    text-left text-xs
                    font-semibold
                    text-gray-600
                    uppercase
                    tracking-wider
                  ">
                  Aksi
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
                    {{ item.role }}
                  </p>
                </td>

                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <span class="
                      relative
                      inline-block
                      px-3
                      py-1
                      font-semibold
                      text-green-900
                      leading-tight
                    ">
                    <span v-if="item.status === 'active'" aria-hidden class="
                        absolute
                        inset-0
                        bg-green-200
                        opacity-50
                        rounded-full
                      "></span>
                    <span v-if="item.status === 'pending'" aria-hidden class="
                        absolute
                        inset-0
                        bg-orange-200
                        opacity-50
                        rounded-full
                      "></span>
                    <span class="relative">{{ item.status }}</span>
                  </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <button @click="handleActive(item.id, item.name)" v-if="
                    item.status === 'pending' && item.role === 'anak-kost'
                  " class="
                      px-4
                      py-2
                      font-bold
                      text-sm
                      bg-green-400
                      hover:bg-green-500
                      rounded-full
                      text-white
                      mr-2
                    ">
                    Aktifkan</button>
                  <button @click="handleDelete(item.id, item.name)"
                    v-if="item.status === 'active' && item.role === 'anak-kost'" class="
                      px-4
                      py-2
                      font-bold
                      text-sm
                      bg-yellow-400
                      hover:bg-yellow-500
                      rounded-full
                      text-white
                      mr-2
                    ">
                    Nonaktifkan
                  </button>

                  <button @click="handleForceDelete(item.id, item.name)" v-if="item.role !== 'admin'" class="
                      px-4
                      py-2
                      font-bold
                      text-sm
                      bg-red-400
                      hover:bg-red-500
                      rounded-full
                      text-white
                    ">
                    Hapus
                  </button>
                </td>
              </tr>
              <!-- <tr>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10">
                      <img
                        class="w-full h-full rounded-full"
                        src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                        alt=""
                      />
                    </div>
                    <div class="ml-3">
                      <p class="text-gray-900 whitespace-no-wrap">
                        Blake Bowman
                      </p>
                    </div>
                  </div>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">Editor</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">Jan 01, 2020</p>
                </td>

                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">77</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <span
                    class="
                      relative
                      inline-block
                      px-3
                      py-1
                      font-semibold
                      text-green-900
                      leading-tight
                    "
                  >
                    <span
                      aria-hidden
                      class="
                        absolute
                        inset-0
                        bg-green-200
                        opacity-50
                        rounded-full
                      "
                    ></span>
                    <span class="relative">Activo</span>
                  </span>
                </td>
              </tr>
              <tr>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10">
                      <img
                        class="w-full h-full rounded-full"
                        src="https://images.unsplash.com/photo-1540845511934-7721dd7adec3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                        alt=""
                      />
                    </div>
                    <div class="ml-3">
                      <p class="text-gray-900 whitespace-no-wrap">Dana Moore</p>
                    </div>
                  </div>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">Editor</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">Jan 10, 2020</p>
                </td>

                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">64</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <span
                    class="
                      relative
                      inline-block
                      px-3
                      py-1
                      font-semibold
                      text-orange-900
                      leading-tight
                    "
                  >
                    <span
                      aria-hidden
                      class="
                        absolute
                        inset-0
                        bg-orange-200
                        opacity-50
                        rounded-full
                      "
                    ></span>
                    <span class="relative">Suspended</span>
                  </span>
                </td>
              </tr>
              <tr>
                <td class="px-5 py-5 bg-white text-sm">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10">
                      <img
                        class="w-full h-full rounded-full"
                        src="https://images.unsplash.com/photo-1522609925277-66fea332c575?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&h=160&w=160&q=80"
                        alt=""
                      />
                    </div>
                    <div class="ml-3">
                      <p class="text-gray-900 whitespace-no-wrap">Alonzo Cox</p>
                    </div>
                  </div>
                </td>
                <td class="px-5 py-5 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">Admin</p>
                </td>
                <td class="px-5 py-5 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">Jan 18, 2020</p>
                </td>
                <td class="px-5 py-5 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">70</p>
                </td>
                <td class="px-5 py-5 bg-white text-sm">
                  <span
                    class="
                      relative
                      inline-block
                      px-3
                      py-1
                      font-semibold
                      text-red-900
                      leading-tight
                    "
                  >
                    <span
                      aria-hidden
                      class="
                        absolute
                        inset-0
                        bg-red-200
                        opacity-50
                        rounded-full
                      "
                    ></span>
                    <span class="relative">Inactive</span>
                  </span>
                </td>
              </tr> -->
            </tbody>
          </table>
          <!-- <div
                    class="
                      px-5
                      py-5
                      bg-white
                      border-t
                      flex flex-col
                      xs:flex-row
                      items-center
                      xs:justify-between
                    "
                  >
                    <span class="text-xs xs:text-sm text-gray-900">
                      Showing 1 to 4 of 50 Entries
                    </span>
                    <div class="inline-flex mt-2 xs:mt-0">
                      <button
                        class="
                          text-sm text-indigo-50
                          transition
                          duration-150
                          hover:bg-indigo-500
                          bg-indigo-600
                          font-semibold
                          py-2
                          px-4
                          rounded-l
                        "
                      >
                        Prev
                      </button>
                      &nbsp; &nbsp;
                      <button
                        class="
                          text-sm text-indigo-50
                          transition
                          duration-150
                          hover:bg-indigo-500
                          bg-indigo-600
                          font-semibold
                          py-2
                          px-4
                          rounded-r
                        "
                      >
                        Next
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>-->
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import Swal from "sweetalert2";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
  data() {
    return {
      modalAddAccount: false,
      form: useForm({
        name: "",
        username: "",
        gender: "",
        phone: "",
        password: "",
        role: "",
        entry: "",
        room: "",
        id_card: "",
        id_card_img: "",
      }),
      params: {
        search: null,
      },
    };
  },
  watch: {
    params: {
      handler() {
        this.$inertia.get(`/users`, this.params, {
          replace: true,
          preserveState: true,
        });
      },
      deep: true,
    },
  },
  methods: {
    clearForm() {
      //clear form
      this.form.name = "";
      this.form.username = "";
      this.form.gender = "";
      this.form.phone = "";
      this.form.password = "";
      this.form.entry = "";
      this.form.room = "";
      this.form.role = "";
      this.form.id_card = "";
      this.form.id_card_img = [];
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
    handleForceDelete(id, name) {
      Swal.fire({
        title: "Anda yakin?",
        text: `kamu akan menghapus akun ${name}, data yang dihapus tidak bisa dikembalikan!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batalkan!",
      }).then((result) => {
        if (result.isConfirmed) {
          Inertia.delete(`/users/force-delete/${id}`);
        }
      });
    },
    handleSubmit() {
      console.log(this.form.id_card_img);
      this.form.post(
        "/users",
        {
          onSuccess: () => {
            this.handleModal(false);
            Swal.fire({
              title: "Data ditambahkan!",
              text: `kamu berhasil menambahkan ${this.form.name} sebagai ${this.form.role} kos!`,
              icon: "success",
            });
            this.clearForm();
          },
        },
        {
          forceFormData: true,
        }
      );
    },
  },
  props: {
    users: Object,
    rooms: Object,
    errors: Object,
  },
};
</script>