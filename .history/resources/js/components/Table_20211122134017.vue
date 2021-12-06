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
            <tr v-for="(m, key) in dados" :key="m.id">
                <th scope="row">{{ m.id }}</th>
                <td>{{ m.nome }}</td>
                <td>{{ m.imagem }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['dados']
    }
</script>
