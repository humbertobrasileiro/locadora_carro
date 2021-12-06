<template>
    <!-- div lateral para pesquisa -->
    <div class="form-row ml-2">

        <div class="col-3">

            <!-- início do card de busca -->
            <card-component titulo="Busca de clientes">
                <template v-slot:conteudo>
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
                </template>

                <template v-slot:conteudo>
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
                busca: { id: '' },
                dadosInc: { id: '' },
                pagina: ''
            }
        },
        methods: {
        }
    }
</script>
