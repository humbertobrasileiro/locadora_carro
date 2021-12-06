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
            <tr v-for="(marca, key) in lista_marcas">
                <th scope="row">{{ Key }}</th>
                <td>{{ marca.nome }}</td>
                <td>{{ marca.imagem }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['lista_marcas']
    }
</script>
