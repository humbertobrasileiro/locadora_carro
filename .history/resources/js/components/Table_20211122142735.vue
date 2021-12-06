<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th v-for="(t,key) in titulos" :key="key" scope="col">{{ t }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="obj in dados" :key="obj.id">
                <td v-if="campos.includes(chave)" v-for="valor, chave in obj" :key="chave">
                    <span v-if="chave === 'imagem'"
                        <img :src="'/storage/' + valor" width="30" height="30">
                    </span>
                    <span v-else>
                        {{ valor }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'campos']
    }
</script>
