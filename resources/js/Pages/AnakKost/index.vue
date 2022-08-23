<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<template>
  <div
    :class="{
      block: modalShowKTP,
      hidden: !modalShowKTP,
    }"
    class="
      modal-container
      top-0
      left-0
      transform
      z-20
      absolute
      w-full
      h-screen
      bg-black bg-opacity-50
      transition
      ease-in-out
      duration-150
    "
  ></div>
  <div
    :class="{
      'translate-y-1/4': modalShowKTP,
      '-translate-y-full': !modalShowKTP,
    }"
    class="
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
    "
  >
    <div
      v-if="showUser"
      class="modal-header p-4 flex items-center justify-between"
    >
      <h1 class="text-gray-900 text-lg font-semibold">
        KTP - {{ showUser.name }}
      </h1>

      <svg
        @click="handleModal(false)"
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5 cursor-pointer"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
          clip-rule="evenodd"
        />
      </svg>
    </div>
    <div v-if="showUser" class="modal-body px-6 pb-6">
      <img
        class=""
        :src="'/storage/id-card-images/' + showUser.id_card_img"
        alt=""
      />
    </div>
  </div>
  <AppLayout title="Penghuni Kost">
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
            'bg-black text-white': route().current('users.kost.index'),
            ' text-black': route().current('users.kost.history'),
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
            'bg-black text-white': route().current('users.kost.history'),
            ' text-black': route().current('users.kost.index'),
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
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <div class="flex justify-end mb-4">
            <input
              v-model="params.search"
              type="text"
              class="rounded-full px-3 py-2 text-sm font-semibold"
              placeholder="search"
            />
          </div>
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
                  No KTP
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
                  Gambar KTP
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
                  <p v-if="item.room" class="text-gray-900 whitespace-no-wrap">
                    {{ item.room.room_name }}
                  </p>
                  <p
                    v-if="!item.room"
                    class="text-gray-900 opacity-50 whitespace-no-wrap"
                  >
                    Kamar Telah Dihapus
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
                    {{ item.id_card }}
                  </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">
                    <button
                      @click="handleModal(true, item.id)"
                      class="
                        px-2
                        py-1
                        rounded-full
                        text-white text-sm
                        bg-green-400
                      "
                    >
                      Lihat
                    </button>
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
import { Inertia } from "@inertiajs/inertia";

export default {
  data() {
    return {
      modalShowKTP: false,
      form: useForm({
        name: "",
        email: "",
        gender: "",
        phone: "",
        password: "",
        role: "",
      }),
      params: {
        search: null,
      },
    };
  },

  watch: {
    params: {
      handler() {
        Inertia.get(`/users-kost`, this.params, {
          replace: true,
          preserveState: true,
        });
      },
      deep: true,
    },
  },
  methods: {
    handleModal(value, id) {
      Inertia.get(
        `/users-kost`,
        { show: id },
        {
          preserveState: true,
        }
      );
      this.modalShowKTP = value;
    },
  },
  props: {
    showUser: Object,
    users: Object,
    errors: Object,
  },
};
</script>