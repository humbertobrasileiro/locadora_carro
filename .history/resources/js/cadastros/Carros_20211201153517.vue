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
                                km: {titulo: 'km', tipo: 'texto'},
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

            <!-- Início modal de visualizar modelo -->

            <modal-component id="modalCarroVis" titulo="Visualizar | carro" tamanho="modal-xl">

                <template v-slot:alertas>
                </template>

                <template v-slot:conteudo>
                    <div class="form-group row">
                        <div class="col-6">

                            <input-container-component titulo="ID">
                                <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                            </input-container-component>

                            <input-container-component titulo="Placa">
                                <input type="text" class="form-control" :value="$store.state.item.placa" disabled>
                            </input-container-component>

                            <input-container-component titulo="Disponível">
                                <input type="text" class="form-control" :value="$store.state.item.disponivel == 1 ? 'Sim' : 'Nâo'" disabled>
                            </input-container-component>

                            <input-container-component titulo="Quilometragem">
                                <input type="text" class="form-control" :value="$store.state.item.km" disabled>
                            </input-container-component>

                        </div>
                        <div class="col-6">
                            <div class="form-group row" v-if="$store.state.item.chave >= 0">
                                <div class="row">
                                    <p>
                                        <b>ID:</b>
                                        {{ $store.state.item.modelo_id }} <b>Modelo:</b>
                                        {{ carros.data[$store.state.item.chave].modelo.nome }}
                                    </p>
                                </div>
                                <div class="row">
                                    <img class="rounded float-center"
                                        :src="'/storage/' + carros.data[$store.state.item.chave].modelo.imagem"
                                        width="420" height="auto">
                                </div>
                            </div>
                        </div>
                    </div>

                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeBotao()">Fechar</button>
                </template>

            </modal-component>

            <!-- Fim modal de visualizar modelo -->

            <!-- Início modal de atualizar modelo -->

            <modal-component id="modalCarroAtu" titulo="Atualizar | carro" tamanho="modal-xl">

                <template v-slot:alertas>
                    <alert-component
                        tipo="success"
                        :detalhes="$store.state.transacao"
                        titulo="Registro atualizado com sucesso"
                        v-if="$store.state.transacao.status == 'sucesso'">
                    </alert-component>
                    <alert-component
                        tipo="danger"
                        :detalhes="$store.state.transacao"
                        titulo="Erro ao tentar atualizar a modelo"
                        v-if="$store.state.transacao.status == 'erro'">
                    </alert-component>
                </template>

                <template v-slot:conteudo>
                    <div class="form-group row">
                        <div class="col-6">
                            <input type="hidden" name="_imagem" v-show="atuModelo($store.state.item.modelo_id)">
                            <input-label-component para="id" titulo="ID do carro">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="id"

                                    :value="$store.state.item.id" disabled>
                            </input-label-component>

                            <input-label-component para="modelo_id" titulo="Selecione o modelo">
                                <select
                                    class="form-control"
                                    id="modelo_id"
                                    @change="atuModelo($store.state.item.modelo_id)"
                                    v-model="$store.state.item.modelo_id">
                                    <option value=""></option>
                                    <option v-for="(modelo, key) in modelos" :key="key" v-bind:value="modelo.id">{{ modelo.nome }}</option>
                                </select>
                            </input-label-component>

                            <input-label-component para="placa" titulo="Informe a Placa do carro">
                            <input
                                type="texto"
                                class="form-control"
                                id="placa"
                                placeholder=""
                                v-model="$store.state.item.placa">
                            </input-label-component>

                            <input-grupo-component label="disponivel" titulo="Disponível?">
                                <input
                                    type="checkbox"
                                    id="disponivel"
                                    aria-label="Informe se está disponível"
                                    v-model="$store.state.item.disponivel">
                            </input-grupo-component>

                            <input-label-component para="km" titulo="Informe o quilometragem">
                                <input
                                    type="number"
                                    class="form-control"
                                    id="km"
                                    placeholder=""
                                    v-model="$store.state.item.km">
                            </input-label-component>

                        </div>
                        <div class="col-6" v-if="imagem.modelo">
                            <img :src="'/storage/' + imagem.modelo" width="420" height="auto">
                        </div>
                    </div>
                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeAtualizarBotao()">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                </template>

            </modal-component>

            <!-- Fim modal de atualizar modelo -->

            <!-- Início modal de remover modelo -->

            <modal-component id="modalCarroRem" titulo="Remover | Carro" tamanho="modal-xl">

                <template v-slot:alertas>
                    <alert-component
                        tipo="success"
                        :detalhes="$store.state.transacao"
                        titulo="Transacao realizada com sucesso"
                        v-if="$store.state.transacao.status == 'sucesso'">
                    </alert-component>
                    <alert-component
                        tipo="danger"
                        :detalhes="$store.state.transacao"
                        titulo="Erro na transação"
                        v-if="$store.state.transacao.status == 'erro'">
                    </alert-component>
                </template>

                <template v-slot:conteudo>
                    <div class="form-group row">
                        <div class="col-6">

                            <input-container-component titulo="ID">
                                <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                            </input-container-component>

                            <input-container-component titulo="Placa">
                                <input type="text" class="form-control" :value="$store.state.item.placa" disabled>
                            </input-container-component>

                            <input-container-component titulo="Disponível">
                                <input type="text" class="form-control" :value="$store.state.item.disponivel == 1 ? 'Sim' : 'Nâo'" disabled>
                            </input-container-component>

                            <input-container-component titulo="Quilometragem">
                                <input type="text" class="form-control" :value="$store.state.item.km" disabled>
                            </input-container-component>

                        </div>
                        <div class="col-6">
                            <div class="form-group row" v-if="$store.state.item.chave >= 0">
                                <div class="row">
                                    <p>
                                        <b>ID:</b>
                                        {{ $store.state.item.modelo_id }} <b>Modelo:</b>
                                        {{ carros.data[$store.state.item.chave].modelo.nome }}
                                    </p>
                                </div>
                                <div class="row">
                                    <img class="rounded float-center"
                                        :src="'/storage/' + carros.data[$store.state.item.chave].modelo.imagem"
                                        width="420" height="auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeRemoveBotao()">Fechar</button>
                    <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
                </template>

            </modal-component>

            <!-- Fim modal de remover modelo -->

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
                urlBase: 'http://localhost:8000/api/v1/carro',
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
                if (e != '') {
                    console.log(this.modelos)
                    // let m = e

                    // let meu_modelo = this.modelos.filter(function(elem) {
                    //     if (elem.id == m) return elem.imagem;
                    // })

                    // this.imagem['modelo'] = meu_modelo[0].imagem

                }
            },
            remover() {
                let confirma = confirm('Tem certeza que deseja remover este registro?')

                if (confirma) {
                    let formData = new FormData();
                    formData.append('_method', 'delete')

                    let url = this.urlBase + '/' + this.$store.state.item.id

                    axios.post(url, formData)
                        .then(response => {
                            this.$store.state.transacao.status = 'sucesso'
                            this.$store.state.transacao.mensagem = response.data.msg
                            this.$store.state.transacao.dados = ''
                        })
                        .catch(errors => {
                            this.$store.state.transacao.status = 'erro'
                            this.$store.state.transacao.mensagem = errors.response.data.erro
                            this.$store.state.transacao.dados = errors.response.data.errors
                        })

                } else {
                    return false
                }
            },
            pesquisar() {
                let filtro = ''
                let dado = ''
                for(let chave in this.busca) {
                    if (this.busca[chave]) {
                        if (filtro != '') {
                            filtro += '|'
                        }

                        if (chave == 'air_bag' || chave == 'abs') {
                            dado = this.busca[chave] ? 1 : 0
                        } else {
                            dado = this.busca[chave]
                        }
                        filtro += chave + ':like:' + dado
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


            },
            atualizar() {

                let formData = new FormData();
                formData.append('_method', 'patch')
                formData.append('modelo_id', this.$store.state.item.modelo_id)
                formData.append('placa', this.$store.state.item.placa)
                formData.append('disponivel', this.$store.state.item.disponivel ? 1 : 0)
                formData.append('km', this.$store.state.item.km)

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                let url = this.urlBase + '/' + this.$store.state.item.id

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'ID do registro: ' + response.data.id
                        this.$store.state.transacao.dados = ''
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })
            },
            salvar() {
                let formData = new FormData();
                formData.append('modelo_id', this.dadosInc['modelo_id'])
                formData.append('placa', this.dadosInc['placa'])
                formData.append('disponivel', this.dadosInc['disponivel'] ? 1 : 0)
                formData.append('km', this.dadosInc['km'])

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'ID do registro: ' + response.data.id
                        this.$store.state.transacao.dados = ''
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })
            },
            setStore() {

                this.dadosInc = { modelo_id: '', placa: '', disponivel: '', km: ''}
                this.imagem['modelo'] = ''

            },
            async closeInclusao() {

                this.urlPaginacao = 'page=1'
                await this.carregarLista()

                this.pagina = this.carros.last_page
                this.closeBotao()

            },
            closeAtualizarBotao() {

                this.urlPaginacao = 'page='+this.carros.current_page
                this.carregarLista()
                this.closeBotao()

            },
            async closeRemoveBotao() {

                this.pagina = this.carros.current_page

                this.urlPaginacao = 'page=1'
                await this.carregarLista()

                this.closeBotao()

            },
            closeBotao() {

                if (this.carros.last_page <= this.pagina) {

                    this.urlPaginacao = 'page=' + this.carros.last_page

                } else {

                    this.urlPaginacao = 'page=' + this.pagina

                }

                this.carregarLista()

                this.$store.state.item = {}

                this.imagem['modelo'] = ''

            }
        },
        created() {
        },
        mounted() {
            this.carregarModelos('')
            this.carregarLista()
        }
    }
</script>
