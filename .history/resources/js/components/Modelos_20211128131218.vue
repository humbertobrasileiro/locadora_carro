<template>

</template>

<script>
    import Paginate from './Paginate.vue'
    export default {
        components: { Paginate },
        computed: {
        },
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/cliente',
                urlPaginacao: '',
                urlFiltro: '',
                placa: '',
                modelos: { data: [] },
                busca: { id: '', modelo: '', placa: '' },
                imagem: { caminho: '', arquivo: [], titulo: '', url: '' },
                pagina: ''
            }
        },
        methods: {
            pesquisar() {
                let filtro = ''
                for(let chave in this.busca) {
                    if (this.busca[chave]) {
                        if (filtro != '') {
                            filtro += ';'
                        }
                        filtro += chave + ':like:' + this.busca[chave]
                    }
                }

                if (filtro != '') {
                    this.urlPaginacao = 'page=1'
                    this.urlFiltro = '&filtro='+filtro
                } else {
                    this.urlFiltro = ''
                }

                this.carregarLista()
            },
            paginacao(l) {
                if (l) {

                    this.urlPaginacao = l.split('?')[1]
                    this.carregarLista()

                }
            },
            async carregarLista() {

                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

                await axios.get(url)
                    .then(response => {
                        this.carros = response.data
                        this.$store.state.transacao.status = 'lista'
                        this.$store.state.transacao.mensagem = response.data.msg
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.erro
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })


            }
        },
        created() {
            this.carregarLista()

        },
        mounted() {
        }
    }
</script>
