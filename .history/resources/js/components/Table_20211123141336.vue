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
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/' + valor" width="30" height="30">
                        </span>
                    </td>
                    <td v-if="visualizar.view || atualizar.view || remover.view">
                        <button v-if="visualizar.view" class="btn btn-outline-secondary btn-sm" :data-toggle="visualizar.toggle" :data-target="visualizar.target">Visualizar</button>
                        <button v-if="atualizar.view" class="btn btn-outline-primary btn-sm" :data-toggle="atualizar.toggle" :data-target="atualizar.target">Atualizar</button>
                        <button v-if="remover.view" class="btn btn-outline-danger btn-sm" :data-toggle="remover.toggle" :data-target="remover.target">Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'visualizar', 'atualizar', 'remover', 'titulos'],
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
