<template>
    <!-- div lateral para pesquisa -->
    <div class="form-row ml-2">

        <div class="col-3">

            <!-- início do card de busca -->
            <card-component titulo="Busca de Locações">
                <template v-slot:conteudo>

                    <input-label-component para="inputID" titulo="Informe o ID da locação">
                        <input
                            type="number"
                            class="form-control"
                            id="inputId"
                            placeholder="ID - opcional"
                            v-model="busca.id">
                    </input-label-component>

                    <input-label-component para="inputCliente_id" titulo="Informe o ID do cliente">
                        <input
                            type="text"
                            class="form-control"
                            id="inputCliente_id"
                            placeholder="ID Cliente - opcional"
                            v-model="busca.cliente_id">
                    </input-label-component>

                    <input-label-component id="inputCarro_id" titulo="Informe o ID do carro">
                        <input
                            type="text"
                            class="form-control"
                            id="inputCarro_id"
                            placeholder="ID Carro - opcional"
                            v-model="busca.carro_id">
                    </input-label-component>

                    <input-label-component para="inputData_inicio_periodo" titulo="Informe a Data de início">
                        <input
                            type="date"
                            class="form-control"
                            id="inputData_inicio_periodo"
                            placeholder="Data Início - opcional"
                            v-model="busca.data_inicio_periodo">
                    </input-label-component>

                    <input-label-component para="inputData_final_previsto_periodo" titulo="Informe Data prevista entrega">
                        <input
                            type="text"
                            class="form-control"
                            id="inputData_final_previsto_periodo"
                            placeholder="Data Final Prevista - opcional"
                            v-model="busca.data_final_previsto_periodo">
                    </input-label-component>

                    <input-label-component para="inputData_final_realizado_periodo" titulo="Informe a Data da entrega">
                        <input
                            type="email"
                            class="form-control"
                            id="inputData_final_realizado_periodo"
                            placeholder="Data da Entrega - opcional"
                            v-model="busca.data_final_realizado_periodo">
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

                <!-- início do card de listagem de Locações -->

                <card-component titulo="Relação das locações">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="locacoes.data"
                            :visualizar="{
                                view: true,
                                toggle: 'modal',
                                target: '#modalLocacaoVis',
                            }"
                            :atualizar="{
                                view: true,
                                toggle: 'modal',
                                target: '#modalLocacaoAtu',
                            }"
                            :remover="{
                                view: true,
                                toggle: 'modal',
                                target: '#modalLocacaoRem',
                            }"
                            :titulos="{
                                chave: {titulo: '#', tipo: 'texto'},
                                id: {titulo: 'ID', tipo: 'texto'},
                                cliente_id: {titulo: 'ID cliente', tipo: 'texto'},
                                carro_id: {titulo: 'ID carro', tipo: 'texto'},
                                data_inicio_periodo: {titulo: 'Data início', tipo: 'data'},
                                data_final_previsto_periodo: {titulo: 'Data Final prevista', tipo: 'data'},
                                data_final_realizado_periodo: {titulo: 'Data Entrega', tipo: 'data'},
                                valor_diaria: {titulo: 'R$ diaria', tipo: 'texto'},
                                km_inicial: {titulo: 'KM inicial', tipo: 'texto'},
                                km_final: {titulo: 'KM final', tipo: 'texto'}
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>

                                    <li v-for="l, key in clientes.links" :key="key"
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
                                    data-target="#modalLocacaoAdc"
                                    @click="setStore()">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </template>
                </card-component>

                <!-- fim do card de listagem de cliente -->

            </div>

            <!-- Início modal de adicionar Cliente -->

            <modal-component id="modalLocacaoAdc" titulo="Adicionar | Locação" tamanho="modal-xl">

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
                        <!-- <div class="col-6">
                            <input-container-component titulo="Nome do cliente" id="newNome" id-help="newNomeHelp" texto-ajuda="Informe o nome do cliente">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="newNome"
                                    aria-describedby="newNomeHelp"
                                    placeholder="Nome do cliente"
                                    v-model="dadosInc.nome">
                            </input-container-component>
                        </div>
                        <div class="col-3">
                            <input-container-component titulo="Telefone" id="newTelefone" id-help="newTelefoneHelp" texto-ajuda="Informe o telefone">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="newTelefone"
                                    aria-describedby="newTelefoneHelp"
                                    placeholder="Nº do telefone"
                                    v-model="dadosInc.telefone">
                            </input-container-component>
                        </div>
                        <div class="col-3">
                            <input-container-component titulo="Celular" id="newCelular" id-help="newCelularHelp" texto-ajuda="Informe o celular">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="newCelular"
                                    aria-describedby="newCelularHelp"
                                    placeholder="Nº do celular"
                                    v-model="dadosInc.celular">
                            </input-container-component>
                        </div> -->
                    </div>
                    <div class="form-group row">
                        <!-- <div class="col-3">
                            <input-container-component titulo="Cpf" id="newCpf" id-help="newCpfHelp" texto-ajuda="Informe o CPF do cliente">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="newCpf"
                                    aria-describedby="newCpfHelp"
                                    placeholder="Nº CPF"
                                    v-model="dadosInc.cpf">
                            </input-container-component>
                        </div>
                        <div class="col-9">
                            <input-container-component titulo="Email" id="newEmail" id-help="newEmailHelp" texto-ajuda="Informe o e-mail">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="newEmail"
                                    aria-describedby="newEmailHelp"
                                    placeholder="e-mail do cliente"
                                    v-model="dadosInc.email">
                            </input-container-component>
                        </div> -->
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

            <!-- Fim modal de adicionar locação -->

            <!-- Início modal de visualizar locação -->

            <modal-component id="modalLocacaoVis" titulo="Visualizar | Locação" tamanho="modal-xl">

                <template v-slot:alertas>
                </template>

                <template v-slot:conteudo>
                    <div class="form-group row">
                        <!-- <div class="col-2">
                            <input-container-component titulo="ID">
                                <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-6">
                            <input-container-component titulo="Nome do cliente">
                                <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-2">
                            <input-container-component titulo="Nº telefone">
                                <input type="text" class="form-control" :value="$store.state.item.telefone" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-2">
                            <input-container-component titulo="Nº celular">
                                <input type="text" class="form-control" :value="$store.state.item.celular" disabled>
                            </input-container-component>
                        </div> -->
                    </div>
                    <div class="form-group row">
                        <!-- <div class="col-4">
                            <input-container-component titulo="Nº do Cpf">
                                <input type="text" class="form-control" :value="$store.state.item.cpf" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-8">
                            <input-container-component titulo="E-mail do cliente">
                                <input type="text" class="form-control" :value="$store.state.item.email" disabled>
                            </input-container-component>
                        </div> -->
                    </div>
                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeBotao()">Fechar</button>
                </template>

            </modal-component>

            <!-- Fim modal de visualizar locação -->

            <!-- Início modal de atualizar locação -->

            <modal-component id="modalLocacaoAtu" titulo="Atualizar | Locação" tamanho="modal-xl">

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
                        <!-- <div class="col-2">
                            <input-container-component titulo="ID" id="id" id-help="idHelp" texto-ajuda="ID">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="id"
                                    aria-describedby="idHelp"
                                    placeholder="ID"
                                    v-model="$store.state.item.id" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-6">
                            <input-container-component titulo="Nome do cliente" id="nome" id-help="nomeHelp" texto-ajuda="Informe o nome do cliente">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="nome"
                                    aria-describedby="nomeHelp"
                                    placeholder="Nome do cliente"
                                    v-model="$store.state.item.nome">
                            </input-container-component>
                        </div>
                        <div class="col-2">
                            <input-container-component titulo="Telefone" id="telefone" id-help="telefoneHelp" texto-ajuda="Informe o telefone">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="telefone"
                                    aria-describedby="telefoneHelp"
                                    placeholder="Nº do telefone"
                                    v-model="$store.state.item.telefone">
                            </input-container-component>
                        </div>
                        <div class="col-2">
                            <input-container-component titulo="Celular" id="celular" id-help="celularHelp" texto-ajuda="Informe o celular">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="celular"
                                    aria-describedby="celularHelp"
                                    placeholder="Nº do celular"
                                    v-model="$store.state.item.celular">
                            </input-container-component>
                        </div> -->
                    </div>
                    <div class="form-group row">
                        <!-- <div class="col-3">
                            <input-container-component titulo="Cpf" id="cpf" id-help="cpfHelp" texto-ajuda="Informe o CPF do cliente">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="cpf"
                                    aria-describedby="cpfHelp"
                                    placeholder="Nº CPF"
                                    v-model="$store.state.item.cpf">
                            </input-container-component>
                        </div>
                        <div class="col-9">
                            <input-container-component titulo="Email" id="email" id-help="emailHelp" texto-ajuda="Informe o e-mail">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    aria-describedby="emailHelp"
                                    placeholder="e-mail do cliente"
                                    v-model="$store.state.item.email">
                            </input-container-component>
                        </div> -->
                    </div>
                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeAtualizarBotao()">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                </template>

            </modal-component>

            <!-- Fim modal de atualizar locação -->

            <!-- Início modal de remover locação -->

            <modal-component id="modalLocacaoRem" titulo="Remover | Locação" tamanho="modal-xl">

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
                        <!-- <div class="col-2">
                            <input-container-component titulo="ID">
                                <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-6">
                            <input-container-component titulo="Nome do cliente">
                                <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-2">
                            <input-container-component titulo="Nº telefone">
                                <input type="text" class="form-control" :value="$store.state.item.telefone" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-2">
                            <input-container-component titulo="Nº celular">
                                <input type="text" class="form-control" :value="$store.state.item.celular" disabled>
                            </input-container-component>
                        </div> -->
                    </div>
                    <div class="form-group row">
                        <!-- <div class="col-4">
                            <input-container-component titulo="Nº do Cpf">
                                <input type="text" class="form-control" :value="$store.state.item.cpf" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-8">
                            <input-container-component titulo="E-mail do cliente">
                                <input type="text" class="form-control" :value="$store.state.item.email" disabled>
                            </input-container-component>
                        </div> -->
                    </div>
                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeRemoveBotao()">Fechar</button>
                    <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
                </template>

            </modal-component>

            <!-- Fim modal de remover locação -->

        </div>
    </div>
</template>

<script>
import Paginate from '../components/Paginate.vue'
    export default {
        components: { Paginate },
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/locacao',
                urlPaginacao: '',
                urlFiltro: '',
                locacoes: { data: [] },
                busca: {
                    id: '',
                    cliente_id: '',
                    carro_id: '',
                    data_inicio_periodo: '',
                    data_final_previsto_periodo: '',
                    data_final_realizado_periodo: '',
                    valor_diaria: '',
                    km_inicial: '',
                    km_final: ''
                },
                dadosInc: {
                    id: '',
                    cliente_id: '',
                    carro_id: '',
                    data_inicio_periodo: '',
                    data_final_previsto_periodo: '',
                    data_final_realizado_periodo: '',
                    valor_diaria: '',
                    km_inicial: '',
                    km_final: ''
                },
                pagina: ''
            }
        },
        methods: {
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

                        dado = this.busca[chave]

                        filtro += chave + ':like:' + dado
                    }
                }
                console.log('Filtro',filtro)
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
                        this.locacoes = response.data
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
                formData.append('cliente_id', this.$store.state.item.cliente_id)
                formData.append('carro_id', this.$store.state.item.carro_id)
                formData.append('data_inicio_periodo', this.$store.state.item.data_inicio_periodo)
                formData.append('data_final_previsto_periodo', this.$store.state.item.data_final_previsto_periodo)
                formData.append('data_final_realizado_periodo', this.$store.state.item.data_final_realizado_periodo)
                formData.append('valor_diaria', this.$store.state.item.valor_diaria)
                formData.append('km_inicial', this.$store.state.item.km_inicial)
                formData.append('km_final', this.$store.state.item.km_final)

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
                formData.append('cliente_id', this.dadosInc['cliente_id'])
                formData.append('carro_id', this.dadosInc['carro_id'])
                formData.append('data_inicio_periodo', this.dadosInc['data_inicio_periodo'])
                formData.append('data_final_previsto_periodo', this.dadosInc['data_final_previsto_periodo'])
                formData.append('data_final_realizado_periodo', this.dadosInc['data_final_realizado_periodo'])
                formData.append('valor_diaria', this.dadosInc['valor_diaria'])
                formData.append('km_inicial', this.dadosInc['km_inicial'])
                formData.append('km_final', this.dadosInc['km_final'])

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

                this.dadosInc =  {
                    id: '',
                    cliente_id: '',
                    carro_id: '',
                    data_inicio_periodo: '',
                    data_final_previsto_periodo: '',
                    data_final_realizado_periodo: '',
                    valor_diaria: '',
                    km_inicial: '',
                    km_final: ''
                }

            },
            async closeInclusao() {

                this.urlPaginacao = 'page=1'
                await this.carregarLista()

                this.pagina = this.locacoes.last_page
                this.closeBotao()

            },
            closeAtualizarBotao() {

                this.urlPaginacao = 'page='+this.locacoes.current_page
                this.carregarLista()
                this.closeBotao()

            },
            async closeRemoveBotao() {

                this.pagina = this.locacoes.current_page

                this.urlPaginacao = 'page=1'
                await this.carregarLista()

                this.closeBotao()

            },
            closeBotao() {

                if (this.locacoes.last_page <= this.pagina) {

                    this.urlPaginacao = 'page=' + this.locacoes.last_page

                } else {

                    this.urlPaginacao = 'page=' + this.pagina

                }

                this.carregarLista()

                this.$store.state.item = {}

            }
        },
        created() {

        },
        mounted() {
            this.carregarLista()
        }
    }
</script>
