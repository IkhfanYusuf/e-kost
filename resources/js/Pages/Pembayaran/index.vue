<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<template>
  <div :class="{
    block: modalAddAccount,
    block: modalShowReceipt,
    hidden: !modalAddAccount,
    hidden: !modalShowReceipt,
  }" class="
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
    "></div>
  <div :class="{
    'translate-y-1/4': modalShowReceipt,
    '-translate-y-full': !modalShowReceipt,
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
      <h1 class="text-gray-900 text-lg font-semibold">
        Bukti Pembayaran
      </h1>

      <svg @click="handleModalReceipt(false)" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer"
        viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
          clip-rule="evenodd" />
      </svg>
    </div>
    <div class="modal-body px-6 pb-6">
      <!-- <span>{{ payment_receipt }}</span> -->
      <img class="" :src="'/storage/receipt/' + payment_receipt" alt="" />
    </div>
  </div>
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
      <h1 class="text-gray-900 text-lg font-semibold">Tambah Pembayaran</h1>
      <svg @click="
  handleModal(false);
clearForm();
      " xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
          clip-rule="evenodd" />
      </svg>
    </div>

    <form @submit.prevent="handleSubmit">
      <div class="modal-body p-4">
        <div v-if="errorMsg" class="bg-red-400 py-3 px-4 rounded">
          <span class="text-white font-semibold">{{
              errorMsg.payment_verify_error
          }}</span>
        </div>

        <div class="mb-1 mt-2">
          <div class="mb-3">
            <label for="" class="font-bold mb-1 block">Nama</label>
            <select v-model="form.user_id" class="
                w-full
                outline-none
                border border-text
                text-sm
                px-4
                py-2
                rounded
              " ref="user">
              <option value="" default>-- Pilih User --</option>
              <option v-for="item in users" :key="item.id" :value="item.id">
                {{ item.name }}
              </option>
            </select>
            <div class="mb-2 text-red-400 text-sm" v-if="errors.user_id">
              {{ errors.user_id }}
            </div>
          </div>
          <div class="mb-3 flex">
            <div class="mr-2">
              <label for="" class="font-bold mb-1 block">No Kamar</label>
              <input disabled v-model="form.room_name" type="text" class="
                  bg-gray-200
                  mr-2
                  w-full
                  outline-none
                  border border-text
                  text-sm
                  px-4
                  py-2
                  rounded
                " placeholder="Nomor Kamar" />
              <div class="mb-2 text-red-400 text-sm" v-if="errors.payment_amount">
                {{ errors.payment_amount }}
              </div>
            </div>
            <div>
              <label for="" class="font-bold mb-1 block">Jumlah Pembayaran</label>
              <input readonly v-model="form.payment_amount" type="number" class="
                  bg-gray-200
                  mr-2
                  w-full
                  outline-none
                  border border-text
                  text-sm
                  px-4
                  py-2
                  rounded
                " placeholder="Jumlah Bayar" />
              <div class="mb-2 text-red-400 text-sm" v-if="errors.payment_amount">
                {{ errors.payment_amount }}
              </div>
            </div>
          </div>
          <div>
            <label for="" class="font-bold mb-1 block">Pembayaran Bulan</label>
            <input v-model="form.payment_for" type="month" class="
                mr-2
                w-full
                outline-none
                border border-text
                text-sm
                px-4
                py-2
                rounded
              " />
            <div class="mb-2 text-red-400 text-sm" v-if="errors.payment_for">
              {{ errors.payment_for }}
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
  <AppLayout title="Pembayaran">
    <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template> -->

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <button v-if="$page.props.auth.role !== 'pemilik'" @click="handleModal(true)" class="
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
          Tambah Pembayaran
        </button>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
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
                  Id Pembayaran
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
                  No Kamar
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
                  Jumlah Pembayaran
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
                  Tanggal Bayar
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
                  Untuk Pembayaran
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
              <tr v-show="price" v-for="item in payments" v-bind:key="item.id">
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <div class="flex items-center">
                    <div class="ml-3">
                      <p class="text-gray-900 whitespace-no-wrap">
                        {{ item.payment_id }}
                      </p>
                    </div>
                  </div>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <div class="flex items-center">
                    <div class="ml-3">
                      <p v-if="item.user" class="text-gray-900 whitespace-no-wrap">
                        {{ item.user.name }}
                      </p>
                      <p v-if="!item.user" class="text-gray-900 whitespace-no-wrap">
                        Mantan Penghuni Kost
                      </p>
                    </div>
                  </div>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <div class="flex items-center">
                    <div class="ml-3">
                      <p v-if="item.user" class="text-gray-900 whitespace-no-wrap">
                        <span v-if="!item.user.room" class="text-sm opacity-50">Kamar Telah Dihapus</span>
                        <span v-if="item.user.room">{{
                            item.user.room.room_name
                        }}</span>
                      </p>
                    </div>
                  </div>
                </td>

                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">
                    {{ item.payment_amount }}
                  </p>
                </td>

                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">
                    {{ item.created_at }}
                  </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap">
                    {{ item.payment_for }}
                  </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p :class="{ 'bg-yellow-200': item.payment_status === 'Pending', 'bg-green-200': item.payment_status === 'Lunas' }"
                    class="text-gray-900 whitespace-no-wrap px-3 py-1 rounded-full inline-block">
                    {{ item.payment_status }}
                  </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                  <p class="text-gray-900 whitespace-no-wrap flex">
                    <button @click="handleModalReceipt(true, item.payment_receipt)" class="
                        px-2
                        py-1
                        rounded-full
                        text-white text-sm font-bold
                        bg-indigo-400 mr-1
                      ">
                      Lihat Bukti
                    </button>

                    <button @click="handleVerified(item.id)" class="
                        px-2
                        py-1
                        rounded-full
                        text-white text-sm font-bold
                        bg-green-400
                      ">
                      Verifikasi
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
import { Inertia } from "@inertiajs/inertia";
import toRupiah from "@develoka/angka-rupiah-js";

export default {
  data() {
    return {
      payment_receipt: "",
      modalShowReceipt: false,
      modalAddAccount: false,
      form: useForm({
        payment_amount: "",
        payment_for: "",
        entry_date: "",
        user_id: "",
        room_name: "",
      }),
      params: {
        search: null,
      },
      errorMsg: null,
    };
  },
  methods: {
    clearForm() {
      //clear form
      this.form.payment_for = "";
      this.form.payment_amount = "";
      this.form.user_id = "";
      this.form.room_name = "";
      this.errorMsg = null;
    },
    handleModal(value) {
      this.modalAddAccount = value;
    },

    handleModalReceipt(value, id) {
      this.modalShowReceipt = value;
      this.payment_receipt = id
    },
    handleVerified(id) {
      Swal.fire({
        title: "Anda yakin?",
        text: `kamu akan menyetujui pembayaran ini!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, setuju!",
        cancelButtonText: "Batalkan!",
      }).then((result) => {
        if (result.isConfirmed) {
          Inertia.patch(`/payments/${id}`);
        }
      });
    },
    handleSubmit() {
      let name;
      this.users?.map((item) => {
        if (item.id === this.form.user_id) {
          name = item.name;
        }
      });

      Swal.fire({
        title: "Anda yakin?",
        text: `Apakah pembayaran sudah benar atas nama ${name} dengan jumlah ${this.form.payment_amount}!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Bayar!",
        cancelButtonText: "Batalkan!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.form.post("/payments", {
            onSuccess: () => {
              this.handleModal(false);
              Swal.fire({
                title: "Pembayaran berhasil!",
                text: `Pembayaran atas nama ${name} dengan jumlah ${this.form.payment_amount} berhasil!.`,
                icon: "success",
              });
              this.clearForm();
            },
          });
        }
      });
    },
  },
  props: {
    payments: Object,
    users: Object,
    errors: Object,
  },
  computed: {
    price() {
      return this.payments.map((val) => {
        val.payment_amount = toRupiah(val.payment_amount, {
          replaceZeroDecimals: true,
        });
        return val;
      });
    },
  },
  watch: {
    params: {
      handler() {
        this.$inertia.get(`/payments`, this.params, {
          replace: true,
          preserveState: true,
        });
      },
      deep: true,
    },
    form: {
      handler() {
        this.users.map((val) => {
          if (val.id === this.form.user_id) {
            this.form.payment_amount = val.room.room_price;
            this.form.room_name = val.room.room_name;
            this.form.entry_date = new Date(val.entry_date).getDate();
          }
        });
      },
      deep: true,
    },
    errors: {
      handler() {
        this.errorMsg = this.$props.errors;
      },
    },
  },
};
</script>