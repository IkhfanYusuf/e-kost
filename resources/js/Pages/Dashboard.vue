<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
</script>

<template>
  <AppLayout title="Dashboard">
    <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template> -->

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <h1 class="font-bold mb-4 border-b-2 border-black pb-2 inline-block">
            Tagihan Penghuni Kost Bulanan
          </h1>
          <div class="flex justify-end mb-4">
            <input
              v-model="params.search"
              type="text"
              class="rounded-full px-3 py-2 text-sm font-semibold"
              placeholder="search"
            />
          </div>

          <div class="">
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
                    Waktu Pembayaran
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
                    Status
                  </th>
                </tr>
              </thead>
              <tbody>
                <template v-for="item in users">
                  <tr v-if="!item.payment[0]" v-bind:key="item.id">
                    <td
                      class="
                        px-5
                        py-5
                        border-b border-gray-200
                        bg-white
                        text-sm
                      "
                    >
                      <div class="flex items-center">
                        <div class="ml-3">
                          <p class="text-gray-900 whitespace-no-wrap">
                            {{ item.name }}
                          </p>
                        </div>
                      </div>
                    </td>
                    <td
                      class="
                        px-5
                        py-5
                        border-b border-gray-200
                        bg-white
                        text-sm
                      "
                    >
                      <p class="text-gray-900 whitespace-no-wrap">
                        {{ item.entry_date }}
                      </p>
                    </td>
                    <td
                      class="
                        px-5
                        py-5
                        border-b border-gray-200
                        bg-white
                        text-sm
                        flex
                      "
                    >
                      <p
                        class="
                          mr-2
                          text-gray-600
                          whitespace-no-wrap
                          bg-red-200
                          rounded-full
                          px-4
                          py-2
                          flex
                        "
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-5 w-5 mr-1"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                          />
                        </svg>
                        Belum Bayar
                      </p>
                      <a
                        href="https://wa.me/85810923499"
                        class="
                          px-4
                          py-2
                          rounded-full
                          bg-green-200
                          flex
                          text-gray-600
                        "
                        target="blank"
                        ><svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-5 w-5 mr-1"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                            clip-rule="evenodd"
                          />
                        </svg>
                        Kirim Tagihan</a
                      >
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
<script>
export default {
  props: {
    countdown: Number,
    paid: Boolean,
    payments: Object,
    auth: Object,
    users: Object,
  },

  data() {
    return {
      params: {
        search: null,
      },
    };
  },
  watch: {
    params: {
      handler() {
        this.$inertia.get(`/dashboard`, this.params, {
          replace: true,
          preserveState: true,
        });
      },
      deep: true,
    },
  },
};
</script>