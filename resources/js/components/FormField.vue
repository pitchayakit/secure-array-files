<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <input
                :id="field.name"
                :name="field.name"
                class="hidden"
                type="text"
                v-model="value"
            >
            <input
                @change="fileSelected"
                class="hidden"
                ref="add_file"
                type="file"
                multiple
            />
            <button
                @click="$refs.add_file.click()"
                class="px-4 py-2 font-bold text-white rounded bg-primary hover:bg-primary-dark"
                type="button"
            >
                {{ __('Upload File') }}
                <loader width="30" :class="hidden"/></button>
            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
            <div class="flex flex-col pt-8 text-center">
                <div v-for="(file, index) in files" class="w-1/2 p-2 mb-4 rounded shadow-lg" style="-ms-word-wrap: break-word;word-wrap: break-word;">
                    <p><a :href="file.url" target="_blank">{{ file.originalName }}</a></p>
                    <br>
                    <p>
                        <a href="#" @click.prevent="deleteImage(index)" class="mb-2 no-underline text-danger hover:font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                            {{ __('delete') }}
                        </a>
                    </p>
                </div>
            </div>
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data() {
        return {
            selectedFile: null,
            files: [],
            hidden: "hidden",
        }
    },

    methods: {
        /**
         * Selected file event trigger
         */
        fileSelected(event) {
            this.hidden="";
            var app = this;
            const fd = new FormData();

            for (let i = 0; i < event.target.files.length; i++) {
                fd.append('file', event.target.files[i], event.target.files[i].name);
                fd.append('disk', this.field.disk);
                fd.append('path', this.field.path);

                axios.post('/nova-vendor/secure-array-files/upload', fd)
                    .then(res => {
                        app.files.push(res.data);
                        app.value = JSON.stringify(app.files);
                        this.hidden="hidden";
                    })
            }
        },

        deleteImage(index) {
            axios.delete('/nova-vendor/secure-array-files/delete/', {
                data : {
                    path: this.files[index].name
                }
            });
            this.files.splice(index, 1);
            this.value = JSON.stringify(this.files);
        },

        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || '';
            this.files = JSON.parse(this.field.value) || [];
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '');
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value;
        },
    },
}
</script>
