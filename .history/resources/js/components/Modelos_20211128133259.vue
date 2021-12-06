<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- início do card de busca -->
                <card-component titulo="Busca de modelos de carro">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do modelo">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="ID da marca" id="inputMarca" id-help="marcaHelp" texto-ajuda="Opcional. Informe o ID da marca">
                                    <input type="number" class="form-control" id="inputMarca" aria-describedby="marcaHelp" placeholder="ID da marca" v-model="busca.marca_id">
                                </input-container-component>
                            </div>
                            <div class="col mb-6">
                                <input-container-component titulo="Nome do modelo" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome do modelo">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome do modelo" v-model="busca.nome">
                                </input-container-component>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="Nº Portas" id="inputNumero_portas" id-help="numero_portasHelp" texto-ajuda="Opcional. Nº de portas">
                                    <input type="number" class="form-control" id="inputNumero_portas" aria-describedby="numero_portasHelp" placeholder="Portas" v-model="busca.numero_portas">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nº Lugares" id="inputLugares" id-help="lugaresHelp" texto-ajuda="Opcional. Nº de lugares">
                                    <input type="number" class="form-control" id="inputLugares" aria-describedby="lugaresHelp" placeholder="Lugares" v-model="busca.lugares">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Tem air bag" id="inputAir_bag" id-help="air_bagHelp" texto-ajuda="Opcional. Tem air bag">
                                    <input type="checkbox" class="form-control" id="inputAir_bag" aria-describedby="air_bagHelp" placeholder="Air bag" v-model="busca.air_bag">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Tem abs" id="inputAbs" id-help="absHelp" texto-ajuda="Opcional. Tem abs">
                                    <input type="checkbox" class="form-control" id="inputAbs" aria-describedby="absHelp" placeholder="Abs" v-model="busca.abs">
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- fim do card de busca -->

                <!-- início do card de listagem de carros -->
                <card-component titulo="Relação de carros">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="modelos.data"
                            :visualizar="{
                                view: true,
                                toggle: 'modal',
                                target: '#modalModeloVis',
                            }"
                            :atualizar="{
                                view: true,
                                toggle: 'modal',
                                target: '#modalModeloAtu',
                            }"
                            :remover="{
                                view: true,
                                toggle: 'modal',
                                target: '#modalModeloRem',
                            }"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                marca_id: {titulo: 'ID da marca', tipo: 'texto'},
                                nome: {titulo: 'Nome do modelo', tipo: 'texto'},
                                disponivel: {titulo: 'Disponível', tipo: 'boolean'},
                                km: {titulo: 'Quantos km rodados', tipo: 'numero'},
                                created_at: {titulo: 'Criação', tipo: 'data'},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>

                                    <li v-for="l, key in modelos.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(l.url)"
                                    >
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>

                                </paginate-component>
                            </div>
                            <div class="col-2">
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm float-right"
                                    data-toggle="modal"
                                    data-target="#modalModeloAdc"
                                    @click="setStore()">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </template>
                </card-component>

                <!-- fim do card de listagem de carros -->

            </div>
        </div>
    </div>
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
                busca: { id: '', marca_id: '', nome: '', imagem: '', numero_portas: '', lugares: '', air_bag: '', abs: ''},
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
                        this.modelos = response.data
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
