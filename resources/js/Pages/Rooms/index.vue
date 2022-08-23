<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>

<template>
  <AppLayout title="Kamar">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <Link :href="route('rooms.create')" v-if="$page.props.auth.role !== 'pemilik'" class="
            inline-block
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
        Tambah Kamar
        </Link>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
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
                  Kamar
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
                  Fasilitas
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
                  Harga per Bulan
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
              <tr v-show="price" v-for="item in rooms" v-bind:key="item.id">
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <div class="flex items-center">
                    <div class="ml-3">
                      <p class="text-gray-900 whitespace-no-wrap">
                        {{ item.room_name }}
                      </p>
                    </div>
                  </div>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">
                    <span v-html="item.room_facility"> </span>
                  </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  {{ item.room_price }}
                </td>

                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <div v-if="item.deleted_at" class="
                      px-4
                      py-2
                      rounded-full
                      bg-gray-300
                      text-white
                      font-bold
                    ">
                    Tersewa
                  </div>
                  <button v-if="!item.deleted_at" @click="handleDelete(item.id)" class="
                      px-4
                      py-2
                      rounded-full
                      bg-red-500
                      text-white
                      font-bold
                    ">
                    Hapus
                  </button>
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
import toRupiah from "@develoka/angka-rupiah-js";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";
export default {
  data() {
    return {};
  },
  methods: {
    handleDelete(id) {
      Swal.fire({
        title: "Kamu yakin?",
        text: `Apakah kamu yakin ingin menghapus kamar kos?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batalkan!",
      }).then((result) => {
        if (result.isConfirmed) {
          Inertia.delete(`/rooms/${id}`, {
            onSuccess: () => {
              Swal.fire({
                title: "Kamar berhasil dihapus!",
                text: `kamu berhasil menghapus kamar kos!`,
                icon: "success",
              });
            },
          });
        }
      });
    },
  },
  props: {
    rooms: Object,
  },
  computed: {
    price() {
      return this.rooms.map((val) => {
        val.room_price = toRupiah(val.room_price, {
          replaceZeroDecimals: true,
        });
        return val;
      });
    },
  },
};
</script>

