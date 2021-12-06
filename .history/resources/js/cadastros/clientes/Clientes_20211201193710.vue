<template>
    <!-- div lateral para pesquisa -->
    <div class="form-row ml-2">

        <div class="col-3">

            <!-- início do card de busca -->
            <card-component titulo="Busca de clientes">
                <template v-slot:conteudo>
                </template>

                <template v-slot:rodape>
                    <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                </template>

            </card-component>

            <!-- fim do card de busca -->
        </div>

        <div class="col-9">
        </div>
    </div>
</template>

<script>
    export default {

    }
</script>
