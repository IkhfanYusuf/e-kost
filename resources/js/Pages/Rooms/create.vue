<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<template>
  <AppLayout title="Pembayaran">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <div class="grid grid-cols-6 gap-6">
            <div class="col-span-5">
              <form
                @submit.prevent="handleSubmit"
                enctype="multipart/form-data"
              >
                <div class="mb-4">
                  <label for="" class="font-bold block mb-2 text-gray-600"
                    >Kamar Nomor</label
                  >
                  <input
                    type="number"
                    v-model="form.room_name"
                    class="px-4 py-2 rounded-lg w-full"
                    placeholder="Masukan No Kamar"
                  />
                  <div
                    class="mb-2 text-red-400 text-sm"
                    v-if="errors.room_name"
                  >
                    {{ errors.room_name }}
                  </div>
                </div>
                <div class="mb-4">
                  <label for="" class="font-bold block mb-2 text-gray-600"
                    >Harga per Bulan</label
                  >
                  <input
                    type="number"
                    v-model="form.room_price"
                    class="px-4 py-2 rounded-lg w-full"
                    placeholder="Masukan Harga per Bulan"
                  />
                  <div
                    class="mb-2 text-red-400 text-sm"
                    v-if="errors.room_price"
                  >
                    {{ errors.room_price }}
                  </div>
                </div>
                <div class="mb-4">
                  <label for="" class="font-bold block mb-2 text-gray-600"
                    >Fasilitas</label
                  >
                  <!-- <textarea
                  type="text"
                  class="px-4 py-2 rounded-lg w-full"
                  placeholder="Fasilitas"
                ></textarea> -->
                  <ckeditor
                    :editor="editor"
                    class="px-4 py-2 rounded-lg w-full"
                    v-model="form.room_facility"
                    :config="editorConfig"
                  ></ckeditor>
                  <div
                    class="mb-2 text-red-400 text-sm"
                    v-if="errors.room_facility"
                  >
                    {{ errors.room_facility }}
                  </div>
                </div>
                <div class="mb-4">
                  <label for="" class="font-bold block mb-2 text-gray-600"
                    >Gambar</label
                  >
                  <input
                    @input="form.room_image[0] = $event.target.files[0]"
                    type="file"
                    class="py-2 rounded-lg w-full"
                  />

                  <div
                    class="mb-2 text-red-400 text-sm"
                    v-if="errors['room_image']"
                  >
                    {{ errors["room_image"] }}
                  </div>
                  <div
                    class="mb-2 text-red-400 text-sm"
                    v-if="errors['room_image.0']"
                  >
                    File 1 : {{ errors["room_image.0"] }}
                  </div>
                  <input
                    @input="form.room_image[1] = $event.target.files[0]"
                    type="file"
                    class="py-2 rounded-lg w-full"
                  />
                  <div
                    class="mb-2 text-red-400 text-sm"
                    v-if="errors['room_image.1']"
                  >
                    File 2 : {{ errors["room_image.1"] }}
                  </div>
                  <input
                    @input="form.room_image[2] = $event.target.files[0]"
                    type="file"
                    class="py-2 rounded-lg w-full"
                  />
                  <div
                    class="mb-2 text-red-400 text-sm"
                    v-if="errors['room_image.2']"
                  >
                    File 3 : {{ errors["room_image.2"] }}
                  </div>
                  <!-- <input
                    @input="form.room_image[1] = $event.target.files[0]"
                    type="file"
                    class="py-2 rounded-lg w-full"
                    placeholder="Masukan Harga per Bulan"
                  />
                  <div class="mb-2 text-red-400 text-sm" v-if="errors">
                    {{ errors }}
                  </div>
                  <input
                    @input="form.room_image[2] = $event.target.files[0]"
                    type="file"
                    class="py-2 rounded-lg w-full"
                    placeholder="Masukan Harga per Bulan"
                  />
                  <div class="mb-2 text-red-400 text-sm" v-if="errors">
                    {{ errors }}
                  </div> -->
                  <progress
                    v-if="form.progress"
                    :value="form.progress.percentage"
                    max="100"
                  >
                    {{ form.progress.percentage }}%
                  </progress>
                </div>
                <div class="mb-4">
                  <button class="px-4 py-2 rounded bg-green-400 text-white">
                    Simpan
                  </button>
                </div>
              </form>
            </div>
            <div class="col-span-3"></div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { useForm } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      editor: ClassicEditor,
      editorConfig: {
        // The configuration of the editor.
      },
      form: useForm({
        room_name: "",
        room_name: "",
        room_price: "",
        room_facility: "",
        room_image: [],
      }),
    };
  },
  props: {
    errors: Object,
  },
  methods: {
    handleSubmit() {
      this.form.post(
        "/rooms/store",
        {
          onSuccess: () => {
            Swal.fire({
              title: "Tambah kamar berhasil!",
              text: `Penambahan kamar kost baru telah berhasil!.`,
              icon: "success",
            });
          },
        },
        {
          forceFormData: true,
        }
      );
    },
  },
  watch: {
    form: {
      handler() {
        console.log(this.form.room_image);
      },
    },
  },
};
</script>