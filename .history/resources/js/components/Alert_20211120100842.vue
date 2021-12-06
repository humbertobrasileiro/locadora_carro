<template>
    <div :class="estilo" role="alert">
        {{ detalhes }}
        {{ tipo }}
    </div>
</template>

<script>
    export default {
        props: ['tipo', 'detalhes'],
        computed: {
            estilo() {
                return 'alert alert-'+this.tipo
            }
        }
    }
</script>
