<template>
    <panel-item :field="field">
        <div slot="value" class="flex flex-wrap">
            <div v-for="file in JSON.parse(field.value)" :key="file.url" class="p-2">
                <a :href="file.url" class="inline-flex items-center font-semibold text-gray-800 no-underline bg-gray-300 rounded hover:bg-gray-400"
                    target="_blank"
                >
                    
                    <div class="p-4 mb-4 bg-white border rounded shadow-lg">
                        <div class="text-right">
                            <svg class="w-4 h-4 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/>
                            </svg>
                        </div>
                        
                        <div class="pb-2">
                            <p class="font-semibold">File name</p>
                            <p class="pb-2"><a :href="file.url" target="_blank" class="text-blue-500 hover:underline">{{ file.originalName }}</a></p>
                        </div>
                        
                        <div class="pb-2 text-gray">
                            <p class="font-semibold">Uploaded at</p>
                            <p>{{ file.uploaded_at }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </panel-item>
</template>

<style scoped>
.text-gray {
    color: #718096;
}
</style>

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
