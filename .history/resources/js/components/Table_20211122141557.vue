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
                    {{ valor }}
                </td>
                <!--td><img :src="'/storage/' + m.imagem" width="30" height="30"></td-->
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'campos']
    }
</script>
