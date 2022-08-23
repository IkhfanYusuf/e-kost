<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  room: Object,
  user: Object,
});
</script>

<template>
  <Head title="e-Kos - Kamar" />

  <div
    class="
      relative
      flex
      items-top
      justify-center
      min-h-screen
      bg-gray-100
      dark:bg-gray-900
      sm:items-center sm:pt-0
    "
  >
    <Nav
      class="
        fixed
        w-full
        top-0
        py-6
        flex
        justify-between
        px-6
        md:px-10
        items-center
      "
    >
      <Link href="/"><img src="/logo.png" alt="" /></Link>
      <div v-if="canLogin" class="hidden sm:block">
        <Link
          v-if="$page.props.user"
          :href="route('dashboard')"
          class="px-4 py-2 rounded-full bg-green-400 text-white font-bold"
        >
          Dashboard
        </Link>

        <template v-else>
          <Link
            :href="route('login')"
            class="px-4 py-2 rounded-full bg-green-400 text-white font-bold"
          >
            Log in
          </Link>
        </template>
      </div>
    </Nav>

    <div class="mt-16">
      <div
        class="
          max-w-6xl
          mx-auto
          py-8
          sm:px-6
          lg:px-8
          dark:bg-gray-800
          overflow-hidden
        "
      >
        <div class="card overflow-hidden">
          <div class="p-6">
            <div
              class="h-1/2 overflow-hidden max-w-full grid grid-cols-12 gap-4"
            >
              <div class="col-span-8">
                <img class="" v-if="!room.image[0]" src="/room.jpg" alt="" />
                <img
                  class=""
                  v-if="room.image[0]"
                  :src="'/storage/post-images/' + room.image[0].room_image"
                  alt=""
                />
              </div>
              <div class="col-span-4 flex flex-col justify-between">
                <img class="" v-if="!room.image[1]" src="/room.jpg" alt="" />
                <img
                  class=""
                  v-if="room.image[1]"
                  :src="'/storage/post-images/' + room.image[1].room_image"
                  alt=""
                />
                <img class="" v-if="!room.image[2]" src="/room.jpg" alt="" />
                <img
                  class=""
                  v-if="room.image[2]"
                  :src="'/storage/post-images/' + room.image[2].room_image"
                  alt=""
                />
              </div>
            </div>
            <div class="grid grid-cols-12 gap-4 mt-8">
              <div class="col-span-8 shadow-lg p-6">
                <h1
                  class="mb-4 font-bold text-4xl flex items-center text-black"
                >
                  <span>Kamar {{ room.room_name }}</span>
                </h1>
                <div>
                  <span v-html="room.room_facility"> </span>
                </div>
              </div>
              <div class="col-span-4 flex flex-col shadow-lg p-6">
                <div class="flex font-bold text-lg items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8 opacity-50 inline-block mr-2"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  <span class=""
                    >{{ price
                    }}<small class="text-sm opacity-40">/bulan</small></span
                  >
                </div>
                <a
                  :href="
                    'https://wa.me/62' +
                    user.phone +
                    '?text=Halo%20saya%20[Nama Kamu]%2C%0A%0ASaya%20ingin%20memesan%20kost%20di%20kamar%20' +
                    room.room_name
                  "
                  class="
                    mt-6
                    w-full
                    px-4
                    py-2
                    flex
                    items-center
                    bg-green-600
                    rounded-full
                    text-white
                    justify-center
                  "
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 inline-block mr-1"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  <span class="font-bold">Order</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="border-t p-6">
        <p class="text-center text-sm">
          &copy; 2022 e-kost. All right reserved
        </p>
      </footer>
    </div>
  </div>
</template>

<script>
import toRupiah from "@develoka/angka-rupiah-js";

export default {
  computed: {
    price() {
      return toRupiah(this.room.room_price, { replaceZeroDecimals: true });
    },
  },
};
</script>
