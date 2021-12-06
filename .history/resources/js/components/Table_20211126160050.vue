<template>
    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="(t,key) in titulos" :key="key" >{{ t.titulo }}</th>
                    <th v-if="visualizar.view || atualizar.view || remover.view"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'texto'">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{ valor | formataDataTempo }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/' + valor" width="30" height="30">
                        </span>
                    </td>
                    <td v-if="visualizar.view || atualizar.view || remover.view">
                        <button
                            v-if="visualizar.view"
                            class="btn btn-outline-secondary btn-sm"
                            :data-toggle="visualizar.toggle"
                            :data-target="visualizar.target"
                            @click="setStore(obj)">
                            Visualizar
                        </button>
                        <button
                            v-if="atualizar.view"
                            class="btn btn-outline-primary btn-sm"
                            :data-toggle="atualizar.toggle"
                            :data-target="atualizar.target"
                            @click="setStore(obj)">
                            Atualizar
                        </button>
                        <button
                            v-if="remover.view"
                            class="btn btn-outline-danger btn-sm"
                            :data-toggle="remover.toggle"
                            :data-target="remover.target"
                            @click="setStore(obj)">
                            Remover
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        filters: {
            formataDataTempo(d) {

                if (!d) {

                    return ''

                } else {

                    d = d.split('T')

                    let data = d[0]
                    let tempo = d[1]

                    data = data.split('-')
                    data = data[2] + '/' + data[1] + '/' + data[0]

                    tempo = tempo.split('.')
                    tempo = tempo[0]

                    return data + ' ás ' + tempo

                }
            }
        },
        props: ['dados', 'visualizar', 'atualizar', 'remover', 'titulos'],
        methods: {
            setStore(obj) {
                this.$store.state.transacao.status = ''
                this.$store.state.transacao.mensagem = ''
                this.$store.state.transacao.dados = ''
                this.$store.state.item = obj
            }
        },
        computed: {
            dadosFiltrados() {

                let campos = Object.keys(this.titulos)

                let dadosFiltrados = []

                this.dados.map((item, chave) => {

                    let itemFiltrado = {}

                    campos.forEach(campo => {
                        itemFiltrado[campo] = item[campo]
                    })

                    dadosFiltrados.push(itemFiltrado)
                })

                return dadosFiltrados
            }
        }
    }
</script>
