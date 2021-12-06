<template>
    <!-- div lateral para pesquisa -->
    <div class="form-row ml-2">

        <div class="col-3">

            <!-- início do card de busca -->
            <card-component titulo="Busca de clientes">
                <template v-slot:conteudo>

                    <input-label-component para="inputID" titulo="Informe o ID do cliente">
                        <input
                            type="number"
                            class="form-control"
                            id="inputId"
                            placeholder="ID - opcional"
                            v-model="busca.id">
                    </input-label-component>

                    <input-label-component para="inputNome" titulo="Informe o Nome do cliente">
                        <input
                            type="text"
                            class="form-control"
                            id="inputNome"
                            placeholder="Nome - opcional"
                            v-model="busca.nome">
                    </input-label-component>

                    <input-label-component id="inputTelefone" titulo="Informe o Nº do telefone">
                        <input
                            type="text"
                            class="form-control"
                            id="inputTelefone"
                            placeholder="Telefone - opcional"
                            v-model="busca.telefone">
                    </input-label-component>

                    <input-label-component para="inputCelular" titulo="Informe o Nº do Celular">
                        <input
                            type="text"
                            class="form-control"
                            id="inputCelular"
                            placeholder="Celular - opcional"
                            v-model="busca.celular">
                    </input-label-component>

                    <input-label-component para="inputCpf" titulo="Informe o CPF">
                        <input
                            type="text"
                            class="form-control"
                            id="inputCpf"
                            placeholder="CPF - opcional"
                            v-model="busca.cpf">
                    </input-label-component>

                    <input-label-component para="inputEmail" titulo="Informe o e-mail">
                        <input
                            type="email"
                            class="form-control"
                            id="inputEmail"
                            placeholder="E-Mail - opcional"
                            v-model="busca.email">
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

                <!-- início do card de listagem de clientes -->

                <card-component titulo="Relação de clientes">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="clientes.data"
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
                                nome: {titulo: 'Nome do cliente', tipo: 'texto'},
                                telefone: {titulo: 'Telefone', tipo: 'texto'},
                                celular: {titulo: 'Celular', tipo: 'texto'},
                                cpf: {titulo: 'Cpf', tipo: 'texto'},
                                email: {titulo: 'e-mail', tipo: 'texto'}
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
                                    data-target="#modalClienteAdc"
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

            <modal-component id="modalClienteAdc" titulo="Adicionar | Cliente" tamanho="modal-xl">

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
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
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

            <!-- Fim modal de adicionar cliente -->

            <!-- Início modal de visualizar cliente -->

            <modal-component id="modalClienteVis" titulo="Visualizar | Cliente" tamanho="modal-xl">

                <template v-slot:alertas>
                </template>

                <template v-slot:conteudo>
                    <div class="form-group row">
                        <div class="col-2">
                            <input-container-component titulo="ID">
                                <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-10">
                            <input-container-component titulo="Nome do cliente">
                                <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                            </input-container-component>
                        </div>
                    </div>
                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeBotao()">Fechar</button>
                </template>

            </modal-component>

            <!-- Fim modal de visualizar cliente -->

            <!-- Início modal de atualizar cliente -->

            <modal-component id="modalClienteAtu" titulo="Atualizar | Cliente" tamanho="modal-xl">

                <template v-slot:alertas>
                </template>

                <template v-slot:conteudo>
                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeAtualizarBotao()">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                </template>

            </modal-component>

            <!-- Fim modal de atualizar cliente -->

            <!-- Início modal de remover cliente -->

            <modal-component id="modalClienteRem" titulo="Remover | Cliente" tamanho="modal-xl">

                <template v-slot:alertas>
                </template>

                <template v-slot:conteudo>
                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeRemoveBotao()">Fechar</button>
                    <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
                </template>

            </modal-component>

            <!-- Fim modal de remover cliente -->

        </div>
    </div>
</template>

<script>
import Paginate from '../components/Paginate.vue'
    export default {
        components: { Paginate },
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/cliente',
                urlPaginacao: '',
                urlFiltro: '',
                clientes: { data: [] },
                busca: { id: '', nome: '', telefone: '', celular: '', cpf: '', email: '' },
                dadosInc: { id: '', nome: '', telefone: '', celular: '', cpf: '', email: '' },
                pagina: ''
            }
        },
        methods: {
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
                        this.clientes = response.data
                        this.$store.state.transacao.status = 'lista'
                        this.$store.state.transacao.mensagem = response.data.msg
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.erro
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })

            },
            salvar() {
                let formData = new FormData();
                formData.append('nome', this.dadosInc['nome'])
                formData.append('telefone', this.dadosInc['telefone'])
                formData.append('celular', this.dadosInc['celular'])
                formData.append('cpf', this.dadosInc['cpf'])
                formData.append('email', this.dadosInc['email'])

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

                this.dadosInc = { id: '', nome: '', telefone: '', celular: '', cpf: '', email: '' }

            },
            async closeInclusao() {

                this.urlPaginacao = 'page=1'
                await this.carregarLista()

                this.pagina = this.clientes.last_page
                this.closeBotao()

            },
            closeAtualizarBotao() {

                this.urlPaginacao = 'page='+this.clientes.current_page
                this.carregarLista()
                this.closeBotao()

            },
            async closeRemoveBotao() {

                this.pagina = this.clientes.current_page

                this.urlPaginacao = 'page=1'
                await this.carregarLista()

                this.closeBotao()

            },
            closeBotao() {

                if (this.clientes.last_page <= this.pagina) {

                    this.urlPaginacao = 'page=' + this.clientes.last_page

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
