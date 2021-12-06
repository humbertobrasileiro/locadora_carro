<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="(t,key) in titulos" :key="key" >{{ t.titulo }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="obj,chave in dadosFiltrados" :key="chave">
                <td>{{ obj }}</td>
            </tr>
            <!-- v-for="obj in dados" :key="obj.id">
                <td v-if="campos.includes(chave)" v-for="valor, chave in obj" :key="chave">
                    <span v-if="chave == 'imagem'">
                        <img :src="'/storage/' + valor" width="30" height="30">
                    </span>
                    <span v-else>
                        {{ valor }}
                    </span>
                </td>
            </tr> -->
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['dados', 'titulos'],
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
