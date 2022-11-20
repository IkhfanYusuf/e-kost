<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard.vue";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";

const form = useForm({
  name: "",
  username: "",
  phone: "",
  entry: "",
  room: "",
  gender: "",
  id_card: "",
  id_card_img: [],
  id_card_with_user: [],
  password: "",
  password_confirmation: "",
  terms: false,
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>

  <Head title="Register" />



  <JetAuthenticationCard class="mb-8">
    <!-- <template #logo>
      <JetAuthenticationCardLogo />
    </template> -->

    <div class="pb-8 pt-4 flex justify-center">
      <img :src="'logo.png'" alt="logo" />
    </div>

    <form @submit.prevent="submit">


      <JetValidationErrors class="mb-4" />

      <div v-if="categories.length < 1" class="bg-red-400 text-white rounded p-4 mb-4">
        <span>Kost sudah penuh, sementara ini tidak menerima penghuni kost
          baru.</span>
      </div>
      <div v-if="!categories.length < 1">
        <div class="bio" v-if="page === 1">
          <div>
            <JetLabel for="name" value="Nama" />

            <JetInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus
              autocomplete="name" />
          </div>

          <div class="mt-4 ">

            <JetLabel for="id_card" value="No Identitas" />
            <JetInput id="id_card" v-model="form.id_card" type="number" class="mt-1 block w-full" required />

          </div>

          <div class="mt-4 ">

            <JetLabel for="gender" value="Jenis Kelamin" />
            <select id="gender" class="
              border-gray-300
              focus:border-indigo-300
              focus:ring
              focus:ring-indigo-200
              focus:ring-opacity-50
              rounded-md
              shadow-sm
              mt-1
              block
              w-full
            " v-model="form.gender">
              <option value="">-- Pilih Jenis Kelamin --</option>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>

          <div class="mt-4 ">
            <JetLabel for="phone" value="Telpon" />
            <JetInput id="phone" v-model="form.phone" type="number" class="mt-1 block w-full" required />
          </div>

          <div class="mt-4">
            <JetLabel for="username" value="Username" />
            <JetInput id="username" v-model="form.username" type="text" class="mt-1 block w-full" required />
          </div>

          <div class="mt-4">
            <JetLabel for="password" value="Password" />
            <JetInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
              autocomplete="new-password" />
          </div>

          <div class="my-4">
            <JetLabel for="password_confirmation" value="Konfirmasi Password" />
            <JetInput id="password_confirmation" v-model="form.password_confirmation" type="password"
              class="mt-1 block w-full" required autocomplete="new-password" />
          </div>

          <div class="text-right">
            <JetButton @click="goToPage(2)" type="button" v-if="!categories.length < 1">
              Berikutnya
            </JetButton>
          </div>


        </div>
        <div class="room" v-if="page === 2">

          <div class="mt-4 flex gap-2">

            <div>
              <JetLabel for="room" value="No Kamar" />
              <select @change="findRooms" id="room" class="
              border-gray-300
              focus:border-indigo-300
              focus:ring
              focus:ring-indigo-200
              focus:ring-opacity-50
              rounded-md
              shadow-sm
              mt-1
              block
              w-full
            " v-model="selectRoom">
                <option value="">-- Pilih Tipe Kamar --</option>
                <option v-for="item in categories" :value="item.id" :key="item.id">
                  {{ item.type }}
                </option>
              </select>
            </div>
            <div>
              <JetLabel for="entry_date" value="Tanggal Masuk" />
              <JetInput id="entry_date" v-model="form.entry" type="date" class="mt-1 block w-full" required />
            </div>
          </div>


          <div class="mt-4">
            <div v-if="rooms == ''" class="px-4 py-2 bg-red-400 text-white">
              <span>Kamar tipe ini tidak tersedia/penuh.</span>
            </div>
            <div v-if="rooms">

              <div class="grid grid-cols-12 gap-2">
                <div v-for="item in rooms" class="col-span-4">
                  <input :id="'roomImg' + item.id" type="radio" class="hidden" :value="item.id" v-model="form.room">
                  <label :for="'roomImg' + item.id">
                    <img :class="{ 'border-2 border-green-300': item.id === form.room }"
                      :src="'/storage/post-images/' + item.image[0].room_image" alt="">
                  </label>
                </div>

              </div>

            </div>

          </div>

          <div class="text-right mt-4">
            <JetButton class="mr-2" @click="goToPage(1)" type="button" v-if="!categories.length < 1">
              Sebelumnya
            </JetButton>
            <JetButton @click="goToPage(3)" type="button" v-if="!categories.length < 1">
              Berikutnya
            </JetButton>
          </div>

        </div>
        <div class="id_people" v-if="page === 3">
          <div class="mt-4 ">

            <div>
              <JetLabel for="id_card_img" value="Upload Gambar Identitas" />
              <JetInput id="id_card_img" @input="form.id_card_img = $event.target.files[0]" type="file"
                class="mt-1 block w-full" required />
            </div>
          </div>

          <div class="my-4 ">

            <div>
              <JetLabel for="id_card_with_user" value="Upload Gambar Diri Bersama Kartu Identitas" />
              <JetInput id="id_card_with_user" @input="form.id_card_with_user = $event.target.files[0]" type="file"
                class="mt-1 block w-full" required />
            </div>
          </div>
          <div class="mt-4">
            <JetLabel for="terms">
              <div class="flex items-center">
                <JetCheckbox id="terms" v-model:checked="form.terms" name="terms" />

                <div class="ml-2">
                  Saya menyetujui
                  <a target="_blank" :href="route('terms.show')"
                    class="underline text-sm text-gray-600 hover:text-gray-900">Syarat</a>
                  &
                  <a target="_blank" :href="route('policy.show')"
                    class="underline text-sm text-gray-600 hover:text-gray-900">Ketentuan</a>
                </div>
              </div>
            </JetLabel>
          </div>
          <div class="flex items-center justify-end mt-4">
            <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900 mr-4">
            Sudah punya akun?
            </Link>

            <JetButton @click="goToPage(2)" type="button" v-if="!categories.length < 1">
              Sebelumnya
            </JetButton>

            <JetButton v-if="!categories.length < 1" class="ml-2" :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing || !form.terms">
              Daftar
            </JetButton>
          </div>
        </div>
      </div>


    </form>
  </JetAuthenticationCard>
</template>


<script>
import axios from 'axios'

export default {
  data() {
    return {
      page: 1,
      rooms: null,
      selectRoom: "",

    }
  },
  props: {
    categories: Object,
  },
  methods: {
    async findRooms() {
      try {
        const response = await axios({
          method: 'post',
          url: '/rooms/find',
          data: {
            categoryId: this.selectRoom
          }
        })
        console.log(response)
        this.rooms = response.data
      } catch (error) {
        console.log(error)
      }
    },
    goToPage(page) {
      this.page = page
    },
  },
  mounted() {
    console.log(this.message);
  },
};
</script>