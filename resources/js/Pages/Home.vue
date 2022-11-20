<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  rooms: Object,
});
</script>

<template>

  <Head title="e-Kos" />
  <section class="
      hero
      h-screen
      w-full
      overflow-hidden
      bg-hero
      relative
      bg-cover bg-center
    ">
    <div class="flex h-screen items-center justify-center">
      <div>
        <h1 class="font-script font-bold text-white text-8xl">e-Kost</h1>
        <p class="text-white md:text-lg bg-pink-400 px-4 py-2">
          Kost murah dengan fasilitas mewah, pesan kamar segera.
        </p>
        <Link href="#room" class="
            mt-8
            px-4
            py-2
            bg-green-600
            rounded-full
            text-white
            inline-block
          ">
        <div class="justify-center flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20"
            fill="currentColor">
            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
            <path fill-rule="evenodd"
              d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
              clip-rule="evenodd" />
          </svg>
          <span class="font-bold">Lihat Kamar</span>
        </div>
        </Link>
      </div>
    </div>
  </section>
  <div class="
      relative
      flex
      items-top
      justify-center
      min-h-screen
      bg-gray-100
      dark:bg-gray-900
      sm:items-center sm:pt-0
    ">
    <template class="
        fixed
        w-full
        top-0
        py-6
        flex
        justify-between
        px-6
        md:px-10
        items-center
      ">
      <Link href="/"><img src="/logo.png" alt="" /></Link>
      <div v-if="canLogin" class="hidden sm:block">
        <Link v-if="$page.props.user" :href="route('dashboard')"
          class="px-4 py-2 rounded-full bg-green-400 text-white font-bold">
        Dashboard
        </Link>

        <template v-else>
          <Link :href="route('register')" class="px-4 mr-2 py-2 rounded-full bg-gray-100 text-gray-600 font-bold">
          Daftar Kos
          </Link>
          <Link :href="route('login')" class="px-4 py-2 rounded-full bg-green-400 text-white font-bold">
          Masuk
          </Link>
        </template>
      </div>
    </template>

    <div class="mt-8" id="room">
      <div class="mx-auto sm:px-6 lg:px-8 max-w-6xl">
        <h1 class="inline-block text-xl font-bold pb-2 border-b-2 border-black">
          Pilih Tipe Kamar
        </h1>
      </div>

      <div class="
          max-w-6xl
          mx-auto
          py-8
          sm:px-6
          lg:px-8
          dark:bg-gray-800
          overflow-hidden
          grid grid-cols-12
          gap-6
          justify-between
          items-between
        ">

        <div v-for="item in rooms"
          class="cursor-pointer group relative card shadow sm:rounded-xl col-span-4 rounded overflow-hidden">
          <div
            class="w-1/3 absolute right-0 transform translate-x-full bg-black bg-opacity-70 h-full group-hover:translate-x-0 flex flex-col justify-center items-center  text-white transition-all">

            <div class="">
              <span class=" block" v-if="item.categoryId == 1">Tipe A</span>
              <span class="block" v-if="item.categoryId == 2">Tipe B</span>
              <span class="block" v-if="item.categoryId == 3">Tipe C</span>
            </div>
            <span class="text-4xl font-bold block">+{{ item.total }}</span>
          </div>
          <img :src="'/storage/post-images/' + item.image[0].room_image" alt="">

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


<style scoped>
.bg-gray-100 {
  background-color: #f7fafc;
  background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
}

.border-gray-200 {
  border-color: #edf2f7;
  border-color: rgba(237, 242, 247, var(--tw-border-opacity));
}

.text-gray-400 {
  color: #cbd5e0;
  color: rgba(203, 213, 224, var(--tw-text-opacity));
}

.text-gray-500 {
  color: #a0aec0;
  color: rgba(160, 174, 192, var(--tw-text-opacity));
}

.text-gray-600 {
  color: #718096;
  color: rgba(113, 128, 150, var(--tw-text-opacity));
}

.text-gray-700 {
  color: #4a5568;
  color: rgba(74, 85, 104, var(--tw-text-opacity));
}

.text-gray-900 {
  color: #1a202c;
  color: rgba(26, 32, 44, var(--tw-text-opacity));
}

@media (prefers-color-scheme: dark) {
  .dark\:bg-gray-800 {
    background-color: #2d3748;
    background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
  }

  .dark\:bg-gray-900 {
    background-color: #1a202c;
    background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
  }

  .dark\:border-gray-700 {
    border-color: #4a5568;
    border-color: rgba(74, 85, 104, var(--tw-border-opacity));
  }

  .dark\:text-white {
    color: #fff;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
  }

  .dark\:text-gray-400 {
    color: #cbd5e0;
    color: rgba(203, 213, 224, var(--tw-text-opacity));
  }
}
</style>
