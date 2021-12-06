<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- início do card de busca -->
                <card-component titulo="Busca de Marcas">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component
                                    id="inputID"
                                    titulo="ID"
                                    idHelp="idHelp"
                                    textoAjuda="Opcional. Informe o ID da marca">
                                    <input type="number" class="form-control" id="inputID" aria-describedby="idHelp" placeholder="ID">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component
                                    id="inputNome"
                                    titulo="Nome da marca"
                                    idHelp="nomeHelp"
                                    textoAjuda="Opcional. Informe o nome da marca">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right">Pesquisar</button>
                    </template>
                </card-component>
                <!-- fim do card de busca -->

                <!-- início do card de listagem de marcas -->
                <card-component titulo="Relação de marcas">
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#adicionarModal">Adicionar</button>
                    </template>
                </card-component>
                <!-- fim do card de listagem de marcas -->

            </div>
        </div>
        <modal-component id="adicionarModal" titulo="Adicionando Marca">
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component
                        id="novoNome"
                        titulo="Nome da marca"
                        idHelp="novoNomeHelp"
                        textoAjuda="Opcional. Informe o nome da marca">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Informe o nome da marca" v-model="nomeMarca">
                    </input-container-component>
                </div>
                <div class="form-group">
                    <input-container-component
                        id="imagem"
                        titulo="Selecione a Logomarca"
                        idHelp="imagemHelp"
                        textoAjuda="Opcional. Selecione o arquivo da Logomarca">
                        <input type="file" class="form-control" id="imagem" aria-describedby="imagemHelp" placeholder="Selecione o arquivo" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Gravar as mudanças</button>
            </template>
        </modal-component>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/marca',
                nomeMarca: '',
                arquivoImagem: []
            }
        },
        methods: {
            carregarImagem(e) {
                this.arquivoImagem = e.target.files
            },
            salvar() {
                let formData = new formData()

                formData.append('nome', this.nomeMarca)
                formData.append('imagem', this.arquivoImagem[0])

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accep': 'application/json'
                    }
                }
                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        console.log(response)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            }
        }
    }
</script>
