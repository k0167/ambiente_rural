<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<script>

export default {
    data() {
        return {
            anual: [],
            juridico: [],
            milho: [],
            linha: true,
            linha2: true,
        }
    }

    , mounted() {
        this.getItens()
    },
    methods: {
        getItens() {
            axios.get(route('dashboard.dashboard'))
                .then(response => {

                    var dados = JSON.parse(response.data)
                    this.anual = dados.anual;
                    this.juridico = dados.juridico;
                    this.milho = dados.milho;

                    console.log(this.milho);
                })
                .catch(error => {
                    console.log(error);
                    this.message = error.response.data.message; // Handle any errors that occurred during the request
                })
        },

        stripped() {
            if (this.linha) {
                this.linha = false
                return 'bg-red-100'
            } else {
                this.linha = true
                return 'bg-red-50'
            }
        },
        stripped2() {
            if (this.linha2) {
                this.linha2 = false
                return 'bg-red-100'
            } else {
                this.linha2 = true
                return 'bg-red-50'
            }
        },

    }
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">DASHBOARDS</h2>
        </template>


        <div class="flex flex-col justify-center ">
            <div class="text-red-800 text-3xl text-center m-6">Produções Anuais 2023</div>
            <table class="table-auto border shadow">
                <thead>
                    <tr class="bg-white text-red-800 text-xl text-center">
                        <th class="w-20 bg-gray-100 p-2 m-16">Nome Propriedade</th>
                        <th class="w-20 bg-gray-100 p-2 m-16">Tamanho</th>
                        <th class="w-56 bg-gray-100 p-2 m-16">Colheita</th>
                    </tr>
                </thead>
                <tbody>
                    <tr :class="stripped()" class="text-center text-2xl" v-for="item in anual">
                        <td>{{ item.nome_prop }} </td>
                        <td>{{ item.tamanho }} Hectares</td>
                        <td>
                            <table class= "table-auto border-separate shadow text-sm">
                                <thead>
                                    <tr class="bg-white text-red-800 text-xs text-center">
                                        <th class="w-44 bg-gray-100 p-2 m-16">Nome </th>
                                        <th class="w-44 bg-gray-100 p-2 m-16">Tamanho</th>
                                        <th class="w-64 bg-gray-100 p-2 m-16">Colheita</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr :class="stripped2()" v-for="colheita in item.colheita">
                                    <td>{{ colheita.nome_prod }}</td>
                                    <td>{{ colheita.qtd }}</td>
                                    <td>{{ colheita.data_prod }}</td>
                                </tr>
                                </tbody>

                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="text-red-800 text-3xl text-center m-6 mt-40">Propriedades PJ</div>
            <table class="table-auto border shadow">
                <thead>
                    <tr class="bg-white text-red-800 text-xl text-center">
                        <th class="w-20 bg-gray-100 p-2 m-16">Nome Propriedade</th>
                        <th class="w-20 bg-gray-100 p-2 m-16">Tamanho</th>
                        <th class="w-20 bg-gray-100 p-2 m-16">Data Aquisição</th>
                        <th class="w-44 bg-gray-100 p-2 m-16">Donos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr :class="stripped()" class="text-center text-2xl" v-for="item in juridico">
                        <td>{{ item.nome_prop }} </td>
                        <td>{{ item.tamanho }} Hectares</td>
                        <td>{{ item.aquisicao }} </td>
                        <td>
                            <table class= "table-auto border-separate shadow text-sm">
                                <thead>
                                    <tr class="bg-white text-red-800 text-xs text-center">
                                        <th class="w-44 bg-gray-100 p-2 m-16">Nome </th>
                                        <th class="w-44 bg-gray-100 p-2 m-16">CPF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr :class="stripped2()" v-for="proprietario in item.proprietarios">
                                    <td>{{ proprietario.nome }}</td>
                                    <td>{{ proprietario.cpf }}</td>
                                </tr>
                                </tbody>

                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="text-red-800 text-3xl text-center m-6 mt-40">Produções de Milho 2022</div>
            <table class="table-auto border shadow mb-40">
                <thead>
                    <tr class="bg-white text-red-800 text-xl text-center">
                        <th class="w-20 bg-gray-100 p-2 m-16">Nome Propriedade</th>
                        <th class="w-20 bg-gray-100 p-2 m-16">Rendimento (qtd/hec)</th>
                        <th class="w-44 bg-gray-100 p-2 m-16">Donos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr :class="stripped()" class="text-center text-2xl" v-for="item in milho">
                        <td>{{ item.nome_prop }} </td>
                        <td>{{ item.rendimento }} </td>
                        <td>
                            <table class= "table-auto border-separate shadow text-sm">
                                <thead>
                                    <tr class="bg-white text-red-800 text-xs text-center">
                                        <th class="w-44 bg-gray-100 p-2 m-16">Nome </th>
                                        <th class="w-44 bg-gray-100 p-2 m-16">CPF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr :class="stripped2()" v-for="proprietario in item.donos">
                                    <td>{{ proprietario.nome }}</td>
                                    <td>{{ proprietario.cpf }}</td>
                                </tr>
                                </tbody>

                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <footer class="flex justify-center">Todos os direitos reservados 2023-2023</footer>
        </div>
    </AuthenticatedLayout>
</template>
