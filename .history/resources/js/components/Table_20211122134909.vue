<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome da marca</th>
                <th scope="col">Imagem</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="m in dados" :key="m.id">
                <th scope="row">{{ m.id }}</th>
                <td>{{ m.nome }}</td>
                <td><img :src="'/storage/' + m.imagem" width="30" height="30"></td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['dados']
    }
</script>
