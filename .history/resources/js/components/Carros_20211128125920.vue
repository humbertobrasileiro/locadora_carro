<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- início do card de busca -->
                <card-component titulo="Busca de carros">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do carro">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Modelo do carro" id="inputModelo" id-help="modeloHelp" texto-ajuda="Opcional. Informe o ID do modelo do carro">
                                    <input type="text" class="form-control" id="inputModelo" aria-describedby="modeloHelp" placeholder="Modelo do carro" v-model="busca.modelo">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Placa do carro" id="inputPlaca" id-help="placaHelp" texto-ajuda="Opcional. Informe a placa do carro">
                                    <input type="text" class="form-control" id="inputPlaca" aria-describedby="placaHelp" placeholder="Placa do carro" v-model="busca.placa">
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- fim do card de busca -->
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
                marcas: { data: [] },
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

     //           this.carregarLista()
            },
            paginacao(l) {
                if (l) {

                    this.urlPaginacao = l.split('?')[1]
             //       this.carregarLista()

                }
            }
        },
        created() {
       //     this.carregarLista()

        },
        mounted() {
        }
    }
</script>
