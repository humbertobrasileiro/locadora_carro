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
            <tr v-for="(e, key) in lista_marcas" :key="key">
                <th scope="row">{{ Key }}</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
            <tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['lista_marcas']
    }
</script>
