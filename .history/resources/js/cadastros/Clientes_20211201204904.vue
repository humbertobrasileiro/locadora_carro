<template>

</template>

<script>
import Paginate from '../components/Paginate.vue'
    export default {
        components: { Paginate, FormCliente },
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/cliente',
                urlPaginacao: '',
                urlFiltro: '',
                clientes: { data: [] },
                busca: { id: '' },
                dadosInc: { id: '' },
                pagina: ''
            }
        },
        methods: {
        }
    }
</script>
