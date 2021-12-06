<template>
    <!-- div lateral para pesquisa -->
    <div class="form-row ml-2">

        <div class="col-3">

            <!-- início do card de busca -->
            <card-component titulo="Busca de modelos de carro">
                <template v-slot:conteudo>

                    <input-label-component para="inputID" titulo="Informe o ID do modelo">
                        <input
                            type="number"
                            class="form-control"
                            id="inputId"
                            placeholder="ID - opcional"
                            v-model="busca.id">
                    </input-label-component>

                    <input-label-component para="inputMarca" titulo="Informe o ID da marca">
                        <select
                            class="form-control"
                            id="inputMarca"
                            v-model="busca.marca_id">
                            <option value=""></option>
                            <option v-for="(marca, key) in marcas" :key="key" v-bind:value="marca.id">{{ marca.nome }}</option>
                        </select>
                    </input-label-component>

                    <input-label-component para="inputNome" titulo="Informe o Nome do modelo">
                        <input
                            type="text"
                            class="form-control"
                            id="inputNome"
                            placeholder="Nome - opcional"
                            v-model="busca.nome">
                    </input-label-component>

                    <input-label-component id="inputNumero_portas" titulo="Informe o Nº Portas">
                        <input
                            type="number"
                            class="form-control"
                            id="inputNumero_portas"
                            placeholder="Portas - opcional"
                            v-model="busca.numero_portas">
                    </input-label-component>

                    <input-label-component para="inputLugares" titulo="Informe o Nº Lugares">
                        <input
                            type="number"
                            class="form-control"
                            id="inputLugares"
                            placeholder="Lugares - opcional"
                            v-model="busca.lugares">
                    </input-label-component>

                    <input-grupo-component label="inputAir_bag" titulo="Se tem Airbag?">
                        <input
                            type="checkbox"
                            id="inputAir_bag"
                            arial-label="Airbag - opcional"
                            v-model="busca.air_bag">
                    </input-grupo-component>

                    <input-grupo-component label="inputAbs" titulo="Se tem Abs?">
                        <input
                            type="checkbox"
                            id="inputAbs"
                            aria-label="Informe se tem freios ABS"
                            v-model="busca.abs">
                    </input-grupo-component>

                </template>

                <template v-slot:rodape>
                    <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                </template>
            </card-component>

            <!-- fim do card de busca -->
        </div>

        <div class="col-9">

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
                                chave: {titulo: '#', tipo: 'texto'},
                                id: {titulo: 'ID', tipo: 'texto'},
                                marca_id: {titulo: 'ID marca', tipo: 'texto'},
                                nome: {titulo: 'Nome do modelo', tipo: 'texto'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                numero_portas: {titulo: 'Portas', tipo: 'texto'},
                                lugares: {titulo: 'Lugares', tipo: 'texto'},
                                air_bag: {titulo: 'Airbag', tipo: 'boolean'},
                                abs: {titulo: 'Abs', tipo: 'boolean'}
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

            <modal-component id="modalModeloAdc" titulo="Adicionar | modelo" tamanho="modal-xl">

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
                            <input-container-component titulo="Nome do modelo" id="newNome" id-help="newNomeHelp" texto-ajuda="Informe o nome do modelo">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="newNome"
                                    aria-describedby="newNomeHelp"
                                    placeholder="Nome do modelo"
                                    v-model="dadosInc.nome">
                            </input-container-component>
                        </div>
                        <div class="col-4">
                            <input-container-component titulo="ID Marca" id="newMarca_id" id-help="newMarca_idHelp" texto-ajuda="Selecione a marca">
                                <select
                                    class="form-control"
                                    id="newMarca_id"
                                    aria-describedby="marca_idHelp"
                                    @change="atuLogo(dadosInc.marca_id)"
                                    v-model="dadosInc.marca_id">
                                    <option value=""></option>
                                    <option v-for="(marca, key) in marcas" :key="key" v-bind:value="marca.id">{{ marca.nome }}</option>
                                </select>
                            </input-container-component>
                        </div>
                        <div class="col-2" v-if="imagem.logo">
                            <img :src="'/storage/' + imagem.logo" width="72" height="auto">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <input-container-component
                                titulo="Modelo da marca"
                                id="newImagem"
                                id-help="newImagemHelp"
                                texto-ajuda="Selecione uma imagem no formato PNG">
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="newImagem"
                                    aria-describedby="novoImagemHelp"
                                    placeholder="Selecione uma imagem"
                                    @change="carregarImagem($event)">
                            </input-container-component>
                        </div>
                        <div class="col-6">
                            <img
                                :src="imagem.url"
                                :alt="imagem.titulo"
                                v-if="imagem.url"
                                display="block"
                                width="420"
                                height="auto">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <input-label-component para="inputNumero_portas" titulo="Informe o Nº de Portas">
                                <input
                                    type="number"
                                    class="form-control"
                                    id="newNumero_portas"
                                    placeholder=""
                                    v-model="dadosInc.numero_portas">
                            </input-label-component>
                        </div>
                        <div class="col-3">
                            <input-label-component para="inputLugares" titulo="Informe o nº de lugares">
                                <input
                                    type="number"
                                    class="form-control"
                                    id="newLugares"
                                    placeholder=""
                                    v-model="dadosInc.lugares">
                            </input-label-component>
                        </div>
                        <div class="col-3">
                            <input-grupo-component label="newAirbag" titulo="tem Airbag?">
                                <input
                                    type="checkbox"
                                    id="newAirbag"
                                    aria-label="Informe Airbag"
                                    v-model="dadosInc.air_bag">
                            </input-grupo-component>
                        </div>
                        <div class="col-3">
                            <input-grupo-component label="air_bag" titulo="tem Abs?">
                                <input
                                    type="checkbox"
                                    id="newAbs"
                                    aria-label="Informe se tem freios ABS"
                                    v-model="dadosInc.abs">
                            </input-grupo-component>
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

            <modal-component id="modalModeloVis" titulo="Visualizar | modelo" tamanho="modal-xl">

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
                            <input-container-component titulo="Nome do modelo">
                                <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                            </input-container-component>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <span>Dados da marca</span>
                        </div>
                    </div>
                    <div class="form-group row" v-if="$store.state.item.chave >= 0">
                        <div class="col-6">
                            <p>
                                <b>ID:</b>
                                {{ $store.state.item.marca_id }} <b>Marca:</b>
                                {{ modelos.data[$store.state.item.chave].marca.nome }}
                            </p>
                        </div>
                        <div class="col-6">
                            <img :src="'/storage/' + modelos.data[$store.state.item.chave].marca.imagem">
                        </div>
                    </div>
                    <div class="form-group">
                        <input-container-component titulo="Imagem do modelo">
                            <img
                                :src="'/storage/' + $store.state.item.imagem"
                                alt="Foto do modelo"
                                v-if="$store.state.item.imagem" width="420" height="auto">
                        </input-container-component>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <input-container-component titulo="Nº de Postas">
                                <input type="text" class="form-control" :value="$store.state.item.numero_portas" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-3">
                            <input-container-component titulo="Nº de Lugares">
                                <input type="text" class="form-control" :value="$store.state.item.lugares" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-3">
                            <input-container-component titulo="Air Bag">
                                <input type="text" class="form-control" :value="$store.state.item.air_bag == 1 ? 'Sim' : 'Nâo'" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-3">
                            <input-container-component titulo="Freios ABS">
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

            <modal-component id="modalModeloAtu" titulo="Atualizar | modelo" tamanho="modal-xl">

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
                        <input type="hidden" name="_imagem" v-show="upLoadImage">
                        <div class="col-2">
                            <input-container-component titulo="ID" id="id" id-help="idHelp" texto-ajuda="ID do modelo">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="id"
                                    aria-describedby="idHelp"
                                    :value="$store.state.item.id" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-5">
                            <input-container-component titulo="Nome do modelo" id="nome" id-help="nomeHelp" texto-ajuda="Informe o nome do modelo">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="nome"
                                    aria-describedby="nomeHelp"
                                    placeholder="Nome do modelo"
                                    v-model="$store.state.item.nome">
                            </input-container-component>
                        </div>
                        <div class="col-3">
                            <input-container-component titulo="ID Marca" id="marca_id" id-help="marca_idHelp" texto-ajuda="Informe o ID da marca">
                                <select
                                    class="form-control"
                                    v-model="$store.state.item.marca_id"
                                    id="marca_id"
                                    aria-describedby="marca_idHelp"
                                    @change="atuLogo($store.state.item.marca_id)">
                                    <option value=""></option>
                                    <option v-for="(marca, key) in marcas" :key="key" v-bind:value="marca.id">{{ marca.nome }}</option>
                                </select>
                            </input-container-component>
                        </div>
                        <div class="col-2" v-if="imagem.logo">
                            <img :src="'/storage/' + imagem.logo" width="72" height="auto">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <input-container-component
                                titulo="Modelo da marca"
                                id="imagem"
                                id-help="imagemHelp"
                                texto-ajuda="Selecione uma imagem no formato PNG">
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="imagem"
                                    aria-describedby="imagemHelp"
                                    placeholder="Selecione uma imagem"
                                    :name="imagem"
                                    @change="carregarImagem($event)">
                            </input-container-component>
                        </div>
                        <div class="col-6">
                            <img
                                :src="imagem.url"
                                :alt="imagem.titulo"
                                v-if="imagem.url"
                                display="block"
                                width="420"
                                height="auto">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <input-label-component para="inputNumeroPortas" titulo="Nº de Portas">
                                <input
                                    type="number"
                                    class="form-control"
                                    id="numero_portas"
                                    placeholder="Nº portas"
                                    v-model="$store.state.item.numero_portas">
                            </input-label-component>
                        </div>
                        <div class="col-3">
                            <input-label-component para="inputLugares" titulo="Nº de Lugares">
                                <input
                                    type="number"
                                    class="form-control"
                                    id="lugares"
                                    placeholder="Nº lugares"
                                    v-model="$store.state.item.lugares">
                            </input-label-component>
                        </div>
                        <div class="col-3">
                            <input-grupo-component label="air_bag" titulo="Informe se tem Airbag">
                                <input
                                    type="checkbox"
                                    aria-label="Informe Airbag"
                                    v-model="$store.state.item.air_bag">
                            </input-grupo-component>
                        </div>
                        <div class="col-3">
                            <input-grupo-component label="abs" titulo="Informe se tem freios ABS">
                                <input
                                    type="checkbox"
                                    aria-label="Informe freios"
                                    v-model="$store.state.item.abs">
                            </input-grupo-component>
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

            <modal-component id="modalModeloRem" titulo="Remover | modelo" tamanho="modal-xl">

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
                        <div class="col-2">
                            <input-container-component titulo="ID">
                                <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-10">
                            <input-container-component titulo="Nome do modelo">
                                <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                            </input-container-component>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <span>Dados da marca</span>
                        </div>
                    </div>
                    <div class="form-group row" v-if="$store.state.item.chave >= 0">
                        <div class="col-6">
                            <p>
                                <b>ID:</b>
                                {{ $store.state.item.marca_id }} <b>Marca:</b>
                                {{ modelos.data[$store.state.item.chave].marca.nome }}
                            </p>
                        </div>
                        <div class="col-6">
                            <img :src="'/storage/' + modelos.data[$store.state.item.chave].marca.imagem">
                        </div>
                    </div>
                    <div class="form-group">
                        <input-container-component titulo="Imagem do modelo">
                            <img
                                :src="'/storage/' + $store.state.item.imagem"
                                alt="Foto do modelo"
                                v-if="$store.state.item.imagem" width="420" height="auto">
                        </input-container-component>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <input-container-component titulo="Nº de Postas">
                                <input type="text" class="form-control" :value="$store.state.item.numero_portas" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-3">
                            <input-container-component titulo="Nº de Lugares">
                                <input type="text" class="form-control" :value="$store.state.item.lugares" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-3">
                            <input-container-component titulo="Air Bag">
                                <input type="text" class="form-control" :value="$store.state.item.air_bag == 1 ? 'Sim' : 'Nâo'" disabled>
                            </input-container-component>
                        </div>
                        <div class="col-3">
                            <input-container-component titulo="Freios ABS">
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
            upLoadImage() {
                if (this.$store.state.item.imagem != null) {

                    this.imagem['caminho'] = '/storage/'
                    this.imagem['arquivo'] =  ''
                    this.imagem['titulo'] = 'imagem do ' + this.$store.state.item.imagem
                    this.imagem['url'] = this.imagem['caminho'] + this.$store.state.item.imagem
                    this.imagem['logo'] = this.modelos.data[this.$store.state.item.chave].marca.imagem

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
                imagem: { caminho: '', arquivo: [], titulo: '', url: '', logo: '' },
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
            atuLogo(e) {
                let m = e

                let minha_marca = this.marcas.filter(function(elem) {
                    if (elem.id == m) return elem.imagem;
                })

                this.imagem['logo'] = minha_marca[0].imagem
            },
            carregarImagem(e) {
                this.$store.state.item.imagem = null

                let arquivo = e.target.files

                this.imagem['caminho'] = '../img/Modelos/'
                this.imagem['arquivo'] = arquivo[0]
                this.imagem['titulo'] = 'imagem do ' + arquivo[0].name
                this.imagem['url'] = this.imagem['caminho'] + arquivo[0].name

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
                            console.log(chave, dado, this.busca[chave])
                        } else {
                            dado = this.busca[chave]
                        }
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
                        this.modelos = response.data
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
                formData.append('nome', this.$store.state.item.nome)
                formData.append('marca_id', this.$store.state.item.marca_id)
                formData.append('numero_portas', this.$store.state.item.numero_portas)
                formData.append('lugares', this.$store.state.item.lugares)
                formData.append('air_bag', this.$store.state.item.air_bag ? 1 : 0)
                formData.append('abs', this.$store.state.item.abs ? 1 : 0)

                if (this.imagem['arquivo'] != '') {

                    formData.append('imagem', this.imagem['arquivo'])

                }

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
                this.closeBotao()

            },
            closeAtualizarBotao() {

                this.urlPaginacao = 'page='+this.modelos.current_page
                this.carregarLista()
                this.closeBotao()

            },
            async closeRemoveBotao() {

                this.pagina = this.modelos.current_page

                this.urlPaginacao = 'page=1'
                await this.carregarLista()

                this.closeBotao()

            },
            closeBotao() {

                if (this.modelos.last_page <= this.pagina) {

                    this.urlPaginacao = 'page=' + this.modelos.last_page

                } else {

                    this.urlPaginacao = 'page=' + this.pagina

                }

                this.carregarLista()

                this.$store.state.item = {}

                this.imagem['caminho'] = ''
                this.imagem['arquivo'] = []
                this.imagem['titulo'] = ''
                this.imagem['url'] = ''
                this.imagem['logo'] = ''

            }
        },
        created() {

        },
        mounted() {
            this.carregarMarcas('')

            this.carregarLista()

        }
    }
</script>
