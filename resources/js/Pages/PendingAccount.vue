<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<template>
  <AppLayout title="Dashboard">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="
            bg-red-300
            text-white
            overflow-hidden
            shadow-xl
            sm:rounded-lg
            p-6
          "
        >
          Akun ini belum aktif, silakan minta pengaktifan pada staf kost.
          Setelah akun diaktifkan, silakan logout lalu login ulang.
        </div>
      </div>
    </div>
  </AppLayout>
</template>
