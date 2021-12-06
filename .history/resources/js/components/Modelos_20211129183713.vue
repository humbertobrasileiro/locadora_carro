<template>
    <!-- div lateral para pesquisa -->
    <div class="form-row ml-2">

        <div class="col-3">

            <!-- início do card de busca -->
            <card-component titulo="Busca de modelos de carro">
                <template v-slot:conteudo>
                    <input-pesquisa-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do modelo">
                        <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                    </input-pesquisa-component>

                    <input-pesquisa-component titulo="ID da marca" id="inputMarca" id-help="marcaHelp" texto-ajuda="Opcional. Selecione a marca">
                        <select v-model="busca.marca_id">
                            <option value=""></option>
                            <option v-for="(marca, key) in marcas" :key="key" v-bind:value="marca.id">{{ marca.nome }}</option>
                        </select>
                      </input-pesquisa-component>

                    <input-pesquisa-component titulo="Nome do modelo" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome do modelo">
                        <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome do modelo" v-model="busca.nome">
                    </input-pesquisa-component>

                    <input-pesquisa-component titulo="Nº Portas" id="inputNumero_portas" id-help="numero_portasHelp" texto-ajuda="Opcional. Nº de portas">
                        <input type="number" class="form-control" id="inputNumero_portas" aria-describedby="numero_portasHelp" placeholder="Portas" v-model="busca.numero_portas">
                    </input-pesquisa-component>

                    <input-pesquisa-component titulo="Nº Lugares" id="inputLugares" id-help="lugaresHelp" texto-ajuda="Opcional. Nº de lugares">
                        <input type="number" class="form-control" id="inputLugares" aria-describedby="lugaresHelp" placeholder="Lugares" v-model="busca.lugares">
                    </input-pesquisa-component>

                    <input-pesquisa-component titulo="Tem air bag" id="inputAir_bag" id-help="air_bagHelp" texto-ajuda="Opcional. Tem air bag">
                        <input type="checkbox" class="form-control" id="inputAir_bag" aria-describedby="air_bagHelp" placeholder="Air bag" v-model="busca.air_bag">
                    </input-pesquisa-component>

                    <input-pesquisa-component titulo="Tem abs" id="inputAbs" id-help="absHelp" texto-ajuda="Opcional. Tem abs">
                        <input type="checkbox" class="form-check-input" id="inputAbs" aria-describedby="absHelp" placeholder="Abs" v-model="busca.abs">
                    </input-pesquisa-component>
                </template>

                <template v-slot:rodape>
                    <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                </template>
            </card-component>

            <!-- fim do card de busca -->
        </div>

        <div class="col-9">

            <!--div class="row justify-content-center"-->
                <div class="col-md-8">

                    <!-- início do card de listagem de modelos -->

                    <card-component titulo="Relação de Modelos de Carro">
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
                                path="/storage/"
                                :titulos="{
                                    id: {titulo: 'ID', tipo: 'texto'},
                                    marca_id: {titulo: 'ID da marca', tipo: 'texto'},
                                    nome: {titulo: 'Nome do modelo', tipo: 'texto'},
                                    imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                    numero_portas: {titulo: 'Nº portas', tipo: 'texto'},
                                    numero_portas: {titulo: 'Nº portas', tipo: 'texto'},
                                    lugares: {titulo: 'Nº lugares', tipo: 'texto'},
                                    air_bag: {titulo: 'Tem air bag', tipo: 'texto'},
                                    abs: {titulo: 'Tem abs', tipo: 'texto'},
                                    created_at: {titulo: 'Criação', tipo: 'data'}
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

                    <!-- fim do card de listagem de modelos -->

                </div>

                <!-- Início modal de adicionar modelo -->

                <modal-component id="modalModeloAdc" titulo="Adicionar | modelo">

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
                        <div class="row">
                            <div class="col-6">
                                <input-container-component titulo="ID Marca" id="newMarca_id" id-help="newMarca_idHelp" texto-ajuda="Informe o ID da marca">
                                    <select v-model="dadosInc.marca_id">
                                        <option value=""></option>
                                        <option v-for="(marca, key) in marcas" :key="key" v-bind:value="marca.id">{{ marca.nome }}</option>
                                    </select>
                                </input-container-component>
                            </div>
                            <div class="col-6">
                                <input-container-component titulo="Nome do modelo" id="newNome" id-help="newNomeHelp" texto-ajuda="Informe o nome do modelo">
                                    <input type="text" class="form-control" id="newNome" aria-describedby="newNomeHelp" placeholder="Nome do modelo" v-model="dadosInc.nome">
                                </input-container-component>
                            </div>
                        </div>
                        <div class="row">
                            <input-container-component titulo="Imagem" id="newImagem" id-help="newImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="newImagem"
                                    aria-describedby="novoImagemHelp"
                                    placeholder="Selecione uma imagem"
                                    @change="carregarImagem($event)">
                            </input-container-component>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <img :src="imagem.url" :alt="imagem.titulo" v-if="imagem.url">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <input-container-component titulo="Nº Portas" id="newNumero_portas" id-help="newNumero_portasHelp" texto-ajuda="Informe o Nº de Portas">
                                    <input type="number" class="form-control" id="newNumero_portas" aria-describedby="newNumero_portasHelp" placeholder="Nº Portas" v-model="dadosInc.numero_portas">
                                </input-container-component>
                            </div>
                            <div class="col-3">
                                <input-container-component titulo="Nº Lugares" id="newLugares" id-help="newLugaresHelp" texto-ajuda="Informe o nº de lugares">
                                    <input type="text" class="form-control" id="newLugares" aria-describedby="newLugaresHelp" placeholder="Nº Lugares" v-model="dadosInc.lugares">
                                </input-container-component>
                            </div>
                            <div class="col-3">
                                <input-container-component titulo="Tem Air Bag" id="newAir_bag" id-help="newAir_bagHelp" texto-ajuda="Informe se tem air bag">
                                    <input type="checkbox" class="form-control" id="newAir_bag" aria-describedby="newAir_bagHelp" placeholder="Tem air bag" v-model="dadosInc.air_bag">
                                </input-container-component>
                            </div>
                            <div class="col-3">
                                <input-container-component titulo="Tem Abs" id="newAbs" id-help="newAbsHelp" texto-ajuda="Informe se tem freios ABS">
                                    <input type="checkbox" class="form-control" id="newAbs" aria-describedby="newAbsHelp" placeholder="Tem ABS" v-model="dadosInc.abs">
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

                <!-- Fim modal de adicionar modelos -->

                <!-- Início modal de visualizar modelo -->

                <modal-component id="modalModeloVis" titulo="Visualizar | modelo">

                    <template v-slot:alertas>
                        {{ modelos.marca }}
                    </template>

                    <template v-slot:conteudo>
                        <div class="form-group row">
                            <div class="col-4">
                                <input-container-component titulo="ID">
                                    <input
                                        type="text"
                                        class="form-control"
                                        :value="$store.state.item.id" disabled>
                                </input-container-component>
                            </div>
                            <div class="col-8">
                                <input-container-component titulo="ID da marca">
                                    <input
                                        type="text"
                                        class="form-control"
                                        :value="$store.state.item.marca_id" disabled>
                                </input-container-component>
                            </div>
                       </div>
                        <div class="form-group">
                            <input-container-component titulo="Dados da Marca">
                             {{ marca }}
                            </input-container-component>
                        </div>
                        <div class="form-group">
                            <input-container-component titulo="Nome do modelo">
                                <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                            </input-container-component>
                        </div>
                        <div class="form-group">
                            <input-container-component titulo="Imagem do modelo">
                                <img :src="imagem.url" :alt="imagem.titulo" v-if="imagem.url">
                            </input-container-component>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <input-container-component titulo="Nº de Postas">
                                    <input type="text" class="form-control" :value="$store.state.item.numero_portas" disabled>
                                </input-container-component>
                            </div>
                            <div class="col-6">
                                <input-container-component titulo="Nº de Lugares">
                                    <input type="text" class="form-control" :value="$store.state.item.lugares" disabled>
                                </input-container-component>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <input-container-component titulo="Possui Air Bag">
                                    <input type="text" class="form-control" :value="$store.state.item.air_bag == 1 ? 'Sim' : 'Nâo'" disabled>
                                </input-container-component>
                            </div>
                           <div class="col-6">
                                <input-container-component titulo="Possui Freios ABS">
                                    <input type="text" class="form-control" :value="$store.state.item.abs == 1 ? 'Sim' : 'Nâo'" disabled>
                                </input-container-component>
                            </div>
                        </div>
                        <div class="form-group">
                            <input-container-component titulo="Data criação">
                                <input type="text" class="form-control" :value="$store.state.item.created_at | formDataTempG" disabled>
                            </input-container-component>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeBotao()">Fechar</button>
                    </template>

                </modal-component>

                <!-- Fim modal de visualizar modelo -->

                <!-- Início modal de atualizar modelo -->

                <modal-component id="modalModeloAtu" titulo="Atualizar | modelo">

                    <template v-slot:alertas>
                    </template>

                    <template v-slot:conteudo>
                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeAtualizarBotao()">Fechar</button>
                        <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                    </template>

                </modal-component>

                <!-- Fim modal de atualizar modelo -->

                <!-- Início modal de remover modelo -->

                <modal-component id="modalModeloRem" titulo="Remover | modelo">

                    <template v-slot:alertas>
                    </template>

                    <template v-slot:conteudo>
                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeRemoveBotao()">Fechar</button>
                        <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
                    </template>

                </modal-component>

                <!-- Fim modal de remover modelo -->
            <!--/div-->
        </div>
    </div>
</template>

<script>
    import Paginate from './Paginate.vue'
    export default {
        components: { Paginate },
        computed: {
            upLoadImage() {
                if (this.$store.state.item.imagem != null) {

                    this.imagem['caminho'] = '/storage/'
                    this.imagem['arquivo'] =  ''
                    this.imagem['titulo'] = 'imagem do ' + this.$store.state.item.imagem
                    this.imagem['url'] = this.imagem['caminho'] + this.$store.state.item.imagem

                    console.log('imagem', this.imagem)

                }
            }
        },
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/modelo',
                urlPaginacao: '',
                urlFiltro: '',
                dadosInc: { marca_id: '', nome: '', imagem: '', numero_portas: '', lugares: '', air_bag: '', abs: ''},
                modelos: { data: [] },
                busca: { id: '', marca_id: '', nome: '', imagem: '', numero_portas: '', lugares: '', air_bag: '', abs: ''},
                imagem: { caminho: '', arquivo: [], titulo: '', url: '' },
                pagina: '',
                marcas: []
            }
        },
        methods: {
            carregarMarcas() {

                let url = 'http://localhost:8000/api/v1/marcas'

                axios.get(url)
                    .then(response => {
                        this.marcas = response.data.marcas
                        console.log('=>',this.marcas)
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
            carregarImagem(e) {
                this.$store.state.item.imagem = null

                let arquivo = e.target.files

                this.imagem['caminho'] = '../img/Modelos/'
                this.imagem['arquivo'] = arquivo[0]
                this.imagem['titulo'] = 'imagem do ' + arquivo[0].name
                this.imagem['url'] = this.imagem['caminho'] + arquivo[0].name

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
                        this.modelos = response.data
                        console.log('Modelos ', this.modelos)
                        this.$store.state.transacao.status = 'lista'
                        this.$store.state.transacao.mensagem = response.data.msg

                        console.log(this.$store.state.item)
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.erro
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })

            },
            salvar() {
                let formData = new FormData();
                formData.append('marca_id', this.dadosInc['marca_id'])
                formData.append('nome', this.dadosInc['nome'])
                formData.append('imagem', this.imagem['arquivo'])
                formData.append('numero_portas', this.dadosInc['numero_portas'])
                formData.append('lugares', this.dadosInc['lugares'])
                formData.append('air_bag', this.dadosInc['air_bag'] ? 1 : 0)
                formData.append('abs', this.dadosInc['abs'] ? 1 : 0)

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

                this.busca = { id: '', marca_id: '', nome: '', imagem: '', numero_portas: '', lugares: '', air_bag: '', abs: ''}
                this.dadosInc = { marca_id: '', nome: '', imagem: '', numero_portas: '', lugares: '', air_bag: '', abs: ''}
                this.imagem['caminho'] = ''
                this.imagem['arquivo'] = ''
                this.imagem['titulo'] = ''
                this.imagem['url'] = ''

            },
            async closeInclusao() {

                this.urlPaginacao = 'page=1'
                await this.carregarLista()

                this.pagina = this.modelos.last_page
                console.log('apos o carregamento')
                this.closeBotao()

            },
            closeAtualizarBotao() {

                this.urlPaginacao = 'page='+this.modelos.current_page
                this.carregarLista()
                this.closeBotao()


            },
            async closeRemoveBotao() {

                this.pagina = this.modelos.current_page

                console.log('antes da requisicao de atualizacao', this.pagina)

                this.urlPaginacao = 'page=1'
                await this.carregarLista()

                console.log('apos atualizacao da requisicao', this.modelos.last_page)

                this.closeBotao()

            },
            closeBotao() {

                if (this.modelos.last_page <= this.pagina) {

                    this.urlPaginacao = 'page=' + this.modelos.last_page

                } else {

                    this.urlPaginacao = 'page=' + this.pagina

                }

                console.log('indo para ', this.urlPaginacao)

                this.carregarLista()

                console.log('store ', this.$store.state.item )
                this.$store.state.item = {}

                this.imagem['caminho'] = ''
                this.imagem['arquivo'] = []
                this.imagem['titulo'] = ''
                this.imagem['url'] = ''

            }
        },
        created() {

            this.carregarMarcas('')

            this.carregarLista()

        },
        mounted() {

        }
    }
</script>
