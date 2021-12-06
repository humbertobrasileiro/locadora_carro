<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- início do card de busca -->
                <card-component titulo="Busca de carros">
                    <template v-slot:conteudo>
                    </template>

                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- fim do card de busca -->
            </div>
        </div>
    </div>
</template>

<script>
    import Paginate from './Paginate.vue'
    export default {
        components: { Paginate },
        data() {

        }
    }
</script>
