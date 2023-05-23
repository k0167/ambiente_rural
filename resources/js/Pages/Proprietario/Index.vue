<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import MessageHandler from '@/Components/MessageHandler.vue';
import axios from 'axios';

import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'

</script>

<script>

export default {
    data() {
        return {
            form: {
                cod_proprietario: '',
                nome_proprietario: '',
                fone1: '',
                fone2: '',
                fone3: '',
                tipo: 'PF',
                pessoaF: {
                    cpf_prop: '',
                    nome_pf: '',
                    dt_nasc_pf: '',
                    rg_pf: '',
                    cod_prop_conjuge: ''
                },
                pessoaJ: {
                    cnpj: '',
                    dt_cria_pj: '',
                    razao_social_pj: ''
                }
            },
            editing: false,
            newDono: false,
            donopj: '',
            donos: [],
            message: '',
            isOpen: false,
            itens: [],
            linha: true,
        }
    },
    async mounted() {
        await this.getItens();
    },
    methods: {
        async getItens() {
            await axios.get(route('proprietarios.get'))
                .then(response => {
                    this.itens = response.data;
                })
                .catch(error => {
                    this.message = error.response.data.message; // Handle any errors that occurred during the request
                })
        },
        closeModal() {
            this.isOpen = false
            this.editing = false
            this.reset();
        },
        openModal() {
            this.isOpen = true
        },

        create() {
            axios.post(route('proprietario.store'),
                {
                    nome_proprietario: this.form.nome_proprietario,
                    fone1: this.form.fone1,
                    fone2: this.form.fone2,
                    fone3: this.form.fone3,
                    tipo: this.form.tipo,
                    pessoaF: {
                        cpf_prop: this.form.pessoaF.cpf_prop,
                        nome_pf: this.form.pessoaF.nome_pf,
                        dt_nasc_pf: this.form.pessoaF.dt_nasc_pf,
                        rg_pf: this.form.pessoaF.rg_pf,
                        cod_prop_conjuge: this.form.pessoaF.cod_prop_conjuge
                    },
                    pessoaJ: {
                        cnpj: this.form.pessoaJ.cnpj,
                        dt_cria_pj: this.form.pessoaJ.dt_cria_pj,
                        razao_social_pj: this.form.pessoaJ.razao_social_pj
                    }

                }
            )
                .then(response => {
                    this.getItens();
                    this.reset();
                })
                .catch(error => {
                    this.message = error.response.data.message; // Handle any errors that occurred during the request
                })
                .finally(() => {
                    this.closeModal();
                });
        },


        current(item) {
            this.form.cod_proprietario = item.COD_PROPRIETARIO;
            this.form.nome_proprietario = item.NOME_PROPRIETARIO;
            this.form.fone1 = item.FONE1;
            this.form.fone2 = item.FONE2;
            this.form.fone3 = item.FONE3;
            this.form.tipo = item.TIPO;

            if (item.TIPO == 'PF') {
                this.form.pessoaF.cpf_prop = item.pessoa_f.CPF_PROP;
                this.form.pessoaF.nome_pf = item.pessoa_f.NOME_PF;
                this.form.pessoaF.dt_nasc_pf = item.pessoa_f.DT_NASC_PF;
                this.form.pessoaF.rg_pf = item.pessoa_f.RG_PF;
                this.form.pessoaF.cod_prop_conjuge = item.pessoa_f.COD_PROP_CONJUGE;
            } else {
                this.form.pessoaJ.cnpj = item.pessoa_j.CNPJ;
                this.form.pessoaJ.dt_cria_pj = item.pessoa_j.DT_CRIA_PJ;
                this.form.pessoaJ.razao_social_pj = item.pessoa_j.RAZAO_SOCIAL_PJ;
            }
            this.getDono()
            this.editing = true;
            this.openModal();
        },

        destroy(item) {

            axios.post(route('proprietario.destroy', { id: item.COD_PROPRIETARIO }))
                .then(response => {
                    this.message = response.data.message;
                    this.getItens();
                    this.reset();

                })
                .catch(error => {
                    this.message = error.response.data.message;
                    // Handle any errors that occurred during the request
                });
        },

        update() {

            axios.post(route('proprietario.update'),
                {
                    cod_proprietario: this.form.cod_proprietario,
                    nome_proprietario: this.form.nome_proprietario,
                    fone1: this.form.fone1,
                    fone2: this.form.fone2,
                    fone3: this.form.fone3,
                    tipo: this.form.tipo,
                    pessoaF: {
                        nome_pf: this.form.pessoaF.nome_pf,
                        dt_nasc_pf: this.form.pessoaF.dt_nasc_pf,
                        rg_pf: this.form.pessoaF.rg_pf,
                        cod_prop_conjuge: this.form.pessoaF.cod_prop_conjuge
                    },
                    pessoaJ: {
                        cnpj: this.form.pessoaJ.cnpj,
                        dt_cria_pj: this.form.pessoaJ.dt_cria_pj,
                        razao_social_pj: this.form.pessoaJ.razao_social_pj
                    }

                }
            )
                .then(response => {
                    this.message = response.data.message; // Access the message from the response
                    this.getItens();
                    this.reset();
                })
                .catch(error => {
                    this.message = error.response.data.message;
                })
                .finally(() => {
                    this.closeModal();
                });
        },
        reset() {
            this.form.cod_proprietario = '';
            this.form.nome_proprietario = '';
            this.form.fone1 = '';
            this.form.fone2 = '';
            this.form.fone3 = '';
            this.form.tipo = '';

            this.form.pessoaF.cpf_prop = '';
            this.form.pessoaF.nome_pf = '';
            this.form.pessoaF.dt_nasc_pf = '';
            this.form.pessoaF.rg_pf = '';
            this.form.pessoaF.cod_prop_conjuge = '';

            this.form.pessoaJ.cnpj = '';
            this.form.pessoaJ.dt_cria_pj = '';
            this.form.pessoaJ.razao_social_pj = '';

            this.editing = false;
        },
        stripped() {
            if (this.linha) {
                this.linha = false
                return 'bg-red-100'
            } else {
                this.linha = true
                return 'bg-red-50'
            }
        }, filteredProprietarios() {
            if (this.itens) {
                //return only itens that have pessoa_f array
                return this.itens.filter(item => item.pessoa_f)
            }

        },
        getDono() {
            axios.get(route('proprietariosPJ.get',this.form.cod_proprietario))
                .then(response => {
                    this.donos = response.data;
                })
                .catch(error => {
                    this.message = error.response.data.message;
                });

        },
        addDono() {
            if (!this.newDono) {
                this.newDono = true;
            } else {
                if (this.donopj == '') {
                    return;
                }
                axios.put(route('proprietarioPJ.store'), {
                    cod_prop_pj: this.form.cod_proprietario,
                    cod_prop_pf: this.donopj
                })
                    .then(response => {
                        this.message = response.data.message;
                        this.getDono();
                        this.donopj = '';

                    })
                    .catch(error => {
                        this.message = error.response.data.message;
                        this.closeModal();
                    });

                this.newDono = false;
            }

        }, remDono(item) {
            axios.post(route('proprietarioPJ.destroy',item.COD_DONO_PJ))
                .then(response => {
                    this.message = response.data.message;
                    this.getDono();
                    this.donopj = '';

                })
                .catch(error => {
                    this.message = error.response.data.message;
                    this.closeModal();
                });
        },
        decodeDono(item) {
            //find and return cod_prop_pf from item in itens array
            return this.itens.find(i => i.COD_PROPRIETARIO == item.COD_PROP_PF).NOME_PROPRIETARIO
        },

    }
}


</script>

<template>
    <Head title="Propriedades" />

    <AuthenticatedLayout>
        <MessageHandler :message="message"></MessageHandler>
        <TransitionRoot appear :show="isOpen" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
                <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                    leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black bg-opacity-25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95">
                            <DialogPanel
                                class="w-full max-w-3xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                    {{ editing ? 'Editar Proprietario' : 'Criar Novo Proprietario' }}
                                </DialogTitle>
                                <div class="mt-2">
                                    <form @submit.prevent="editing ? update() : create()">
                                        <div class="grid grid-cols-2 gap-6">
                                            <div>
                                                <div>
                                                    <InputLabel for="nome" value="Nome Proprietario" />

                                                    <TextInput id="nome" type="text" class="mt-1 block w-full"
                                                        v-model="form.nome_proprietario" required autofocus
                                                        autocomplete="off" />
                                                </div>
                                                <div>
                                                    <InputLabel for="nome" value="Fone 1" />

                                                    <TextInput id="nome" type="text" class="mt-1 block w-full"
                                                        v-model="form.fone1" autocomplete="off" />
                                                </div>
                                                <div>
                                                    <InputLabel for="nome" value="Fone 2" />

                                                    <TextInput id="nome" type="text" class="mt-1 block w-full"
                                                        v-model="form.fone2" autocomplete="off" />
                                                </div>
                                                <div>
                                                    <InputLabel for="nome" value="Fone 3" />

                                                    <TextInput id="nome" type="text" class="mt-1 block w-full"
                                                        v-model="form.fone3" autocomplete="off" />
                                                </div>
                                                <div>
                                                    <InputLabel for="nome" value="Tipo" />
                                                    <select :disabled="editing" class="mt-1 block w-full" name="nome"
                                                        v-model="form.tipo">
                                                        <option value="PF">
                                                            Pessoa Fisica
                                                        </option>
                                                        <option value="PJ">
                                                            Pessoa Juridica
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div v-if="form.tipo == 'PF'">
                                                <div>
                                                    <InputLabel for="nome" value="CPF" />

                                                    <TextInput :disabled="editing" id="nome" type="text" class="mt-1 block w-full"
                                                        v-model="form.pessoaF.cpf_prop" required autofocus
                                                        autocomplete="off" />
                                                </div>
                                                <div>
                                                    <InputLabel for="nome" value="Nome PF" />

                                                    <TextInput id="nome" type="text" class="mt-1 block w-full"
                                                        v-model="form.pessoaF.nome_pf" autocomplete="off" />
                                                </div>
                                                <div>
                                                    <InputLabel for="nome" value="Data Nascimento" />

                                                    <TextInput id="nome" type="date" class="mt-1 block w-full"
                                                        v-model="form.pessoaF.dt_nasc_pf" autocomplete="off" />
                                                </div>
                                                <div>
                                                    <InputLabel for="nome" value="RG" />

                                                    <TextInput id="nome" type="text" class="mt-1 block w-full"
                                                        v-model="form.pessoaF.rg_pf" autocomplete="off" />
                                                </div>
                                                <div v-if="filteredProprietarios()">
                                                    <InputLabel for="nome" value="Conjuge" />

                                                    <select class="mt-1 block w-full" name="nome"
                                                        v-model="form.pessoaF.cod_prop_conjuge">
                                                        <option v-for="item in filteredProprietarios()"
                                                            :key="item.COD_PROPRIETARIO" :value="item.pessoa_f.COD_PROP_PF">
                                                            {{ item.pessoa_f.NOME_PF }}
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div v-if="form.tipo == 'PJ'">
                                                <div>
                                                    <InputLabel for="nome" value="CNPJ" />

                                                    <TextInput id="nome" type="text" class="mt-1 block w-full"
                                                        v-model="form.pessoaJ.cnpj" required autofocus autocomplete="off" />
                                                </div>
                                                <div>
                                                    <InputLabel for="nome" value="Razão Social" />

                                                    <TextInput id="nome" type="text" class="mt-1 block w-full"
                                                        v-model="form.pessoaJ.razao_social_pj" autocomplete="off" />
                                                </div>
                                                <div>
                                                    <InputLabel for="nome" value="Data Criação" />

                                                    <TextInput id="nome" type="date" class="mt-1 block w-full"
                                                        v-model="form.pessoaJ.dt_cria_pj" autocomplete="off" />
                                                </div>

                                                <div v-if="editing" class="pt-4">
                                                    <div class="flex flex-wrap">
                                                        <div @click="addDono()"
                                                            class="h-10 w-10 flex justify-center items-center bg-red-800  border border-gray-200 rounded-lg shadow cursor-pointer">
                                                            <div v-if="!newDono" class="h-6 w-6 text-white">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" strokeWidth={1.5}
                                                                    stroke="currentColor" className="w-4 h-4">
                                                                    <path strokeLinecap="round" strokeLinejoin="round"
                                                                        d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </div>
                                                            <div v-if="newDono" class="p-1 h-6 w-6 text-white">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M4.5 12.75l6 6 9-13.5" />
                                                                </svg>
                                                            </div>

                                                        </div>
                                                        <select v-if="newDono" class="ml-2 block w-72 h-10" name="nome"
                                                            v-model="donopj">
                                                            <option v-for="item in filteredProprietarios()"
                                                                :key="item.COD_PROPRIETARIO"
                                                                :value="item.pessoa_f.COD_PROP_PF">
                                                                {{ item.pessoa_f.NOME_PF }}
                                                            </option>

                                                        </select>
                                                    </div>
                                                    <InputLabel for="nome" value="Donos Empresa" />
                                                    <div class="h-36 overflow-y-scroll overflow-x-hidden">
                                                        <table class=" border shadow ">
                                                            <thead>
                                                                <tr class="bg-white text-red-800 text-md text-center">
                                                                    <th class="w-64 bg-gray-100 p-2 m-2">Nome PF</th>
                                                                    <th class="w-24 bg-gray-100 p-2 m-2">Ações</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(item,key) in donos" :key="key" :class="stripped()" class="text-center text-md">
                                                                    <td>{{decodeDono(item)}}</td>
                                                                    <td class="justify-center flex flex-nowrap">
                                                                        <svg @click="remDono(item)"
                                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                                            stroke="currentColor"
                                                                            class="cursor-pointer text-red-800 w-4 h-4">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                        </svg>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-end mt-4">
                                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                                :disabled="form.processing">
                                                {{ editing ? 'Editar' : 'Criar' }}
                                            </PrimaryButton>
                                        </div>
                                    </form>
                                </div>

                                <div class="mt-4">
                                    <button type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="closeModal">
                                        Fechar
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>


        <div @click="openModal()"
            class="h-16 w-16 p-4 bg-white m-2 border border-gray-200 rounded-lg shadow cursor-pointer">
            <div class="h-8 w-8 text-red-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                    stroke="currentColor" className="w-6 h-6">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="flex justify-center">
            <table class="table-auto border shadow">
                <thead>
                    <tr class="bg-white text-red-800 text-lg text-center">
                        <th class="w-20 bg-gray-100 p-2 m-16">ID</th>
                        <th class="w-64 bg-gray-100 p-2 m-16">Nome Proprietario</th>
                        <th class="w-40 bg-gray-100 p-2 m-16">Fone 1</th>
                        <th class="w-40 bg-gray-100 p-2 m-16">Fone 2</th>
                        <th class="w-40 bg-gray-100 p-2 m-16">Fone 3</th>
                        <th class="w-40 bg-gray-100 p-2 m-16">Tipo</th>
                        <th class="w-40 bg-gray-100 p-2 m-16">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr :class="stripped()" class="text-center text-lg" v-for="item in itens" :key="item.COD_PRODUCAO">
                        <td>{{ item.COD_PROPRIETARIO }}</td>
                        <td>{{ item.NOME_PROPRIETARIO }}</td>
                        <td>{{ item.FONE1 }}</td>
                        <td>{{ item.FONE2 }}</td>
                        <td>{{ item.FONE3 }}</td>
                        <td>{{ item.TIPO }}</td>

                        <td class="justify-center flex flex-nowrap">
                            <svg @click="current(item)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="cursor-pointer text-blue-800 w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>

                            <svg @click="destroy(item)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="cursor-pointer text-red-800 w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>


