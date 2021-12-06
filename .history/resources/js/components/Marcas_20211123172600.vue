<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- início do card de busca -->
                <card-component titulo="Busca de marcas">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID da marca">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca" v-model="busca.nome">
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- fim do card de busca -->


                <!-- início do card de listagem de marcas -->
                <card-component titulo="Relação de marcas">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="marcas.data"
                            :visualizar="{
                                view: true,
                                toggle: 'modal',
                                target: '#modalMarcaVis',
                            }"
                            :atualizar="{
                                view: true,
                                toggle: 'modal',
                                target: '#modalMarcaAtu',
                            }"
                            :remover="{
                                view: true,
                                toggle: 'modal',
                                target: '#modalMarcaRem',
                            }"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                nome: {titulo: 'Nome', tipo: 'texto'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                created_at: {titulo: 'Criação', tipo: 'data'},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>

                                    <li v-for="l, key in marcas.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>

                                </paginate-component>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalMarcaAdc">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- fim do card de listagem de marcas -->
            </div>
        </div>


        <!-- Início modal de adicionar marca -->

        <modal-component id="modalMarcaAdc" titulo="Adicionar | marca">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'Adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca" v-if="transacaoStatus == 'Erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="row">
                    <div class="col-2">
                        <img :src="imagem.url" :alt="imagem.titulo">
                    </div>
                    <div class="col-10">
                        <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome da marca">
                            <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da marca" v-model="nomeMarca">
                        </input-container-component>
                    </div>
                </div>
                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                        <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>

        </modal-component>

        <!-- Fim modal de adicionar marca -->

        <!-- Início modal de visualizar marca -->

        <modal-component id="modalMarcaVis" titulo="Visualizar | marca">

            <template v-slot:alertas>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="ID">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>
                </div>
                <div class="form-group">
                    <input-container-component titulo="Nome da marca">
                        <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                    </input-container-component>
                </div>
                <div class="form-group">
                    <input-container-component titulo="Logomarca">
                        <img :src="'/storage/' + $store.state.item.imagem" v-if="$store.state.item.imagem">
                    </input-container-component>
                </div>
                <div class="form-group">
                    <input-container-component titulo="Data criação">
                        <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>

        </modal-component>

        <!-- Fim modal de visualizar marca -->

        <!-- Início modal de atualizar marca -->

        <modal-component id="modalMarcaAtu" titulo="Atualizar | marca">

            <template v-slot:alertas>
            </template>

            <template v-slot:conteudo>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>

        </modal-component>

        <!-- Fim modal de atualizar marca -->

        <!-- Início modal de remover marca -->

        <modal-component id="modalMarcaRem" titulo="Remover | marca">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Sucesso na transação" v-if="transacaoStatus == 'Remover'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro na transação" v-if="transacaoStatus == 'Erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="ID">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>
                </div>
                <div class="form-group">
                    <input-container-component titulo="Nome da marca">
                        <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                    </input-container-component>
                </div>
                <div class="form-group">
                    <input-container-component titulo="Logomarca">
                        <img :src="'/storage/' + $store.state.item.imagem" v-if="$store.state.item.imagem">
                    </input-container-component>
                </div>
                <div class="form-group">
                    <input-container-component titulo="Data criação">
                        <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()">Remover</button>
            </template>

        </modal-component>

        <!-- Fim modal de visualizar marca -->

    </div>
</template>

<script>
import Paginate from './Paginate.vue'
    export default {
  components: { Paginate },
        computed: {
            token() {

                let token = document.cookie.split(';').find(indice => {
                    return indice.includes('token=')
                })

                token = token.split('=')[1]
                token = 'Bearer ' + token

                return token
            }
        },
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/marca',
                urlPaginacao: '',
                urlFiltro: '',
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                marcas: { data: [] },
                busca: { id: '', nome: '' },
                imagem: { url: '', titulo: '' }
            }
        },
        methods: {
            remover() {
                let confirma = confirm('Tem certeza que deseja remover este registro?')

                if (confirma) {
                    let formData = new FormData();
                    formData.append('_method', 'delete')

                    let config = {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': this.token
                        }
                    }

                    let url = this.urlBase + '/' + this.$store.state.item.id

                    axios.post(url, formData, config)
                        .then(response => {
                            this.transacaoStatus = 'Remover'
                            this.transacaoDetalhes = {
                                mensagem: response.data.msg
                            }

                        })
                        .catch(errors => {
                            this.transacaoStatus = 'Erro'
                            this.transacaoDetalhes = {
                                mensagem: errors.response.data.erro,
                                dados: errors.response.data.errors
                            }
                        })

                    this.carregarLista()

                } else {
                    return false
                }
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
                if (l.url) {
                    this.urlPaginacao = l.url.split('?')[1]
                    this.carregarLista()
                }
            },
            carregarLista() {

                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                axios.get(url, config)
                    .then(response => {
                        this.marcas = response.data
                        this.transacaoStatus = 'Lista carregada'
                        this.transacaoDetalhes = {
                            mensagem: 'Dados carregados com sucesso'
                        }
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'Erro'
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        }
                    })
            },
            carregarImagem(e) {
                this.arquivoImagem = e.target.files
                this.imagem['url'] = '../img/imagens_marcas/'+this.arquivoImagem[0].name
                this.imagem['titulo'] = 'imagem do ' + this.arquivoImagem[0].name
            },
            salvar() {
                let formData = new FormData();
                formData.append('nome', this.nomeMarca)
                formData.append('imagem', this.arquivoImagem[0])

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'Adicionado'
                        this.transacaoDetalhes = {
                            mensagem: 'ID do registro: ' + response.data.id
                        }
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'Erro'
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        }
                    })
            }
        },
        mounted() {
            this.carregarLista()
        }
    }
</script>
