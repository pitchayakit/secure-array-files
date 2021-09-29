<template>
    <panel-item :field="field">
        <div slot="value">
            <a :href="file.url" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded inline-flex items-center"
                v-for="file in JSON.parse(field.value)"
                target="_blank"
            >
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/>
                </svg>
                <span>{{ file.originalName }}</span>
            </a>
        </div>
    </panel-item>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],

    methods: {
        getFile (file, originalName) {
            axios({
                url: '/nova-vendor/secure-array-files/download' + file,
                method: 'GET',
                responseType: 'blob',
            })
                .then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', originalName);
                document.body.appendChild(link);
                link.click();
            });
        }
    }
}
</script>
