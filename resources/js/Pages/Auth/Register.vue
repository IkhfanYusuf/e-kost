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

  <JetAuthenticationCard>
    <!-- <template #logo>
      <JetAuthenticationCardLogo />
    </template> -->

    <form @submit.prevent="submit">
      <div class="pb-8 pt-4 flex justify-center">
        <img :src="'logo.png'" alt="logo" />
      </div>
      <JetValidationErrors class="mb-4" />

      <div v-if="rooms.length < 1" class="bg-red-400 text-white rounded p-4 mb-4">
        <span>Kost sudah penuh, sementara ini tidak menerima penghuni kost
          baru.</span>
      </div>
      <div v-if="!rooms.length < 1">
        <div>
          <JetLabel for="name" value="Nama" />

          <JetInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus
            autocomplete="name" />
        </div>

        <div class="mt-4">
          <JetLabel for="email" value="Username" />
          <JetInput id="email" v-model="form.username" type="text" class="mt-1 block w-full" required />
        </div>

        <div class="mt-4 flex">
          <div class="mr-2">
            <JetLabel for="phone" value="Telpon" />
            <JetInput id="phone" v-model="form.phone" type="number" class="mt-1 block w-full" required />
          </div>
          <div>
            <JetLabel for="room" value="No Kamar" />
            <select id="room" class="
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
              " v-model="form.room">
              <option value="">-- Pilih Kamar --</option>
              <option v-for="item in rooms" :value="item.id" :key="item.id">
                {{ item.room_name }}
              </option>
            </select>
          </div>
        </div>

        <div class="mt-4 ">
          <div class="mr-2">
            <JetLabel for="id_card" value="No Identitas" />
            <JetInput id="id_card" v-model="form.id_card" type="number" class="mt-1 block w-full" required />
          </div>

        </div>

        <div class="mt-4 ">

          <div>
            <JetLabel for="id_card_img" value="Upload Gambar Identitas" />
            <JetInput id="id_card_img" @input="form.id_card_img = $event.target.files[0]" type="file"
              class="mt-1 block w-full" required />
          </div>
        </div>

        <div class="mt-4 flex">
          <div class="mr-2">
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
          <div>
            <JetLabel for="entry_date" value="Tanggal Masuk" />
            <JetInput id="entry_date" v-model="form.entry" type="date" class="mt-1 block w-full" required />
          </div>
        </div>

        <div class="mt-4">
          <JetLabel for="password" value="Password" />
          <JetInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
            autocomplete="new-password" />
        </div>

        <div class="mt-4">
          <JetLabel for="password_confirmation" value="Konfirmasi Password" />
          <JetInput id="password_confirmation" v-model="form.password_confirmation" type="password"
            class="mt-1 block w-full" required autocomplete="new-password" />
        </div>

        <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
          <JetLabel for="terms">
            <div class="flex items-center">
              <JetCheckbox id="terms" v-model:checked="form.terms" name="terms" />

              <div class="ml-2">
                I agree to the
                <a target="_blank" :href="route('terms.show')"
                  class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a>
                and
                <a target="_blank" :href="route('policy.show')"
                  class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
              </div>
            </div>
          </JetLabel>
        </div>
      </div>
      <div class="flex items-center justify-end mt-4">
        <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
        Sudah punya akun?
        </Link>

        <JetButton v-if="!rooms.length < 1" class="ml-4" :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing">
          Daftar
        </JetButton>
      </div>
    </form>
  </JetAuthenticationCard>
</template>


<script>
export default {
  props: {
    rooms: Object,
  },
  mounted() {
    console.log(this.message);
  },
};
</script>