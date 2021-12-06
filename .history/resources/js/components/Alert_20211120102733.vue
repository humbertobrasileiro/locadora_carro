<template>
    <div :class="estilo" role="alert">
        {{ titulo }}
        <hr>
        <ul v-if="detalhes.data.errors">
            <li v-for="e, key in detalhes.data.errors" :key="key">{{ e }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['tipo', 'detalhes', 'titulo'],
        computed: {
            estilo() {
                return 'alert alert-'+this.tipo
            }
        }
    }
</script>
