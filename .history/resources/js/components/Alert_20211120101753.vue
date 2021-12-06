<template>
    <div :class="estilo" role="alert">
        {{ titulo }}
        <hr>
        {{ detalhes.errors.nome }}
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
