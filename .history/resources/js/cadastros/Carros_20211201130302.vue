<template>
    <!-- div lateral para pesquisa -->
    <div class="form-row ml-2">

        <div class="col-3">

            <!-- início do card de busca -->
            <card-component titulo="Busca de carros">
                <template v-slot:conteudo>

                    <input-label-component para="inputId" titulo="Informe o ID do carro">
                        <input
                            type="number"
                            class="form-control"
                            id="inputId"
                            placeholder="ID - opcional"
                            v-model="busca.id">
                    </input-label-component>

                    <input-label-component para="inputModelo" titulo="Informe o ID do modelo">
                        <select
                            class="form-control"
                            id="inputModelo"
                            v-model="busca.modelo_id">
                            <option value=""></option>
                            <option v-for="(modelo, key) in modelos" :key="key" v-bind:value="modelo.id">{{ modelo.nome }}</option>
                        </select>
                    </input-label-component>

                    <input-label-component para="inputPlaca" titulo="Informe a Placa do carro">
                        <input
                            type="text"
                            class="form-control"
                            id="inputPlaca"
                            placeholder="Placa - opcional"
                            v-model="busca.placa">
                    </input-label-component>

                </template>

                <template v-slot:rodape>
                    <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                </template>

            </card-component>

            <!-- fim do card de busca -->
        </div>

        <div class="col-9">

            <div class="col-md-8">

                <!-- início do card de listagem de carros -->

                <card-component titulo="Relação de carros">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="carros.data"
                            :visualizar="{
                                view: true,
                                toggle: 'modal',
                                target: '#modalCarroVis',
                            }"
                            :atualizar="{
                                view: true,
                                toggle: 'modal',
                                target: '#modalCarroAtu',
                            }"
                            :remover="{
                                view: true,
                                toggle: 'modal',
                                target: '#modalCarroRem',
                            }"
                            :titulos="{
                                chave: {titulo: '#', tipo: 'texto'},
                                id: {titulo: 'ID', tipo: 'texto'},
                                modelo_id: {titulo: 'Modelo', tipo: 'texto'},
                                placa: {titulo: 'Placa', tipo: 'texto'},
                                disponivel: {titulo: 'Disponível', tipo: 'boolean'},
                                km: {titulo: 'km', tipo: 'numero'},
                                created_at: {titulo: 'Criação', tipo: 'data'}
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>

                                    <li v-for="l, key in carros.links" :key="key"
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
                                    data-target="#modalCarroAdc"
                                    @click="setStore()">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </template>
                </card-component>

                <!-- fim do card de listagem de carros -->

            </div>

            <!-- Início modal de adicionar carro -->

            <modal-component id="modalCarroAdc" titulo="Adicionar | carro" tamanho="modal-xl">

                <template v-slot:alertas>
                    <alert-component
                        tipo="success"
                        :detalhes="$store.state.transacao"
                        titulo="Cadastro realizado com sucesso"
                        v-if="$store.state.transacao.status == 'sucesso'">
                    </alert-component>
                    <alert-component
                        tipo="danger"
                        :detalhes="$store.state.transacao"
                        titulo="Erro ao tentar cadastrar o modelo"
                        v-if="$store.state.transacao.status == 'erro'">
                    </alert-component>
                </template>

                <template v-slot:conteudo>
                    <div class="form-group row">
                        <div class="col-6">
                            <input-label-component para="inputModelo_id" titulo="Selecione o modelo">
                                <select
                                    class="form-control"
                                    id="newModelo_id"
                                    @change="atuModelo(dadosInc.modelo_id)"
                                    v-model="dadosInc.modelo_id">
                                    <option value=""></option>
                                    <option v-for="(modelo, key) in modelos" :key="key" v-bind:value="modelo.id">{{ modelo.nome }}</option>
                                </select>
                            </input-label-component>

                            <input-label-component para="inputPlaca" titulo="Informe a Placa do carro">
                            <input
                                type="texto"
                                class="form-control"
                                id="newPlaca"
                                placeholder=""
                                v-model="dadosInc.placa">
                            </input-label-component>

                            <input-grupo-component label="disponivel" titulo="Disponível?">
                                <input
                                    type="checkbox"
                                    id="newDisponivel"
                                    aria-label="Informe se está disponível"
                                    v-model="dadosInc.disponivel">
                            </input-grupo-component>

                            <input-label-component para="inputKm" titulo="Informe o quilometragem">
                                <input
                                    type="number"
                                    class="form-control"
                                    id="newKm"
                                    placeholder=""
                                    v-model="dadosInc.km">
                            </input-label-component>

                        </div>
                        <div class="col-6" v-if="imagem.modelo">
                            <img :src="'/storage/' + imagem.modelo" width="420" height="auto">
                        </div>
                    </div>
                </template>

                <template v-slot:rodape>
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                        @click="$store.state.transacao.status == 'sucesso' ? closeInclusao() : ''">
                        Fechar
                    </button>
                    <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                </template>

            </modal-component>

            <!-- Fim modal de adicionar modelos -->

        </div>
    </div>
</template>

<script>
    import Paginate from '../components/Paginate.vue'
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
                carros: { data: [] },
                busca: { id: '', modelo_id: '', placa: '', disponivel: '', km: '' },
                dadosInc: { id: '', modelo_id: '', placa: '', disponivel: '', km: '' },
                imagem: { modelo: '' },
                pagina: '',
                modelos: []
            }
        },
        methods: {
            carregarModelos() {

                let url = 'http://localhost:8000/api/v1/modelos'

                axios.get(url)
                    .then(response => {
                        this.modelos = response.data.modelos
                        this.$store.state.transacao.status = 'lista'
                        this.$store.state.transacao.mensagem = response.data.msg
                    })
                    .catch(errors => {
                        this.marcas = []
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.erro
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })

            },
            atuModelo(e) {
                let m = e

                let meu_modelo = this.modelos.filter(function(elem) {
                    if (elem.id == m) return elem.imagem;
                })

                this.imagem['modelo'] = meu_modelo[0].imagem
            },
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

            this.carregarModelos('')
            this.carregarLista()

        },
        mounted() {
        }
    }
</script>
