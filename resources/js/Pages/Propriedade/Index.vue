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
                cod_propriedade: '',
                nome_propriedade: '',
                area: '',
                distancia_do_munic: '',
                valor_aquisicao: ''
            },
            editing: false,
            message: '',
            isOpen: false,
            propriedades: [],
        }
    },
    mounted() {
        this.getProp()
    },
    methods: {
        getProp() {
            axios.get(route('propriedades.get'))
                .then(response => {
                    this.propriedades = response.data;
                })
                .catch(error => {
                    this.message = error.response.data.message; // Handle any errors that occurred during the request
                })
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(2).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
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
            axios.post(route('propriedade.store'),
                {
                    nome_propriedade: this.form.nome_propriedade,
                    area: this.form.area,
                    distancia_do_munic: this.form.distancia_do_munic,
                    valor_aquisicao: this.form.valor_aquisicao,
                }
            )
                .then(response => {
                    this.getProp();
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
            this.form.cod_propriedade = item.COD_PROPRIEDADE;
            this.form.nome_propriedade = item.NOME_PROPRIEDADE;
            this.form.area = item.AREA;
            this.form.distancia_do_munic = item.DISTANCIA_DO_MUNIC;
            this.form.valor_aquisicao = item.VALOR_AQUISICAO;
            this.editing = true;
            this.openModal();
        },

        destroy(item) {

            axios.post(route('propriedade.destroy', { id: item.COD_PROPRIEDADE }))
                .then(response => {
                    this.message = response.data.message;
                    this.getProp();
                    this.reset();

                })
                .catch(error => {
                    this.message = error.response.data.message;
                    // Handle any errors that occurred during the request
                });
        },

        update() {

            axios.post(route('propriedade.update'),
                {
                    cod_propriedade: this.form.cod_propriedade,
                    nome_propriedade: this.form.nome_propriedade,
                    area: this.form.area,
                    distancia_do_munic: this.form.distancia_do_munic,
                    valor_aquisicao: this.form.valor_aquisicao,
                }
            )
                .then(response => {
                    this.message = response.data.message; // Access the message from the response
                    this.getProp();
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
            this.form.cod_propriedade = '';
            this.form.nome_propriedade = '';
            this.form.area = '';
            this.form.distancia_do_munic = '';
            this.form.valor_aquisicao = '';
        },
        laVaiEle(prop) {
            this.$inertia.get(route('producao',prop))
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
                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                    {{ editing ? 'Editar Propriedade' : 'Criar Nova Propriedade' }}
                                </DialogTitle>
                                <div class="mt-2">
                                    <form @submit.prevent="editing ? update() : create()">
                                        <div>
                                            <InputLabel for="nome" value="Nome" />

                                            <TextInput id="nome" type="text" class="mt-1 block w-full"
                                                v-model="form.nome_propriedade" required autofocus autocomplete="off" />
                                        </div>
                                        <div>
                                            <InputLabel for="area" value="Area" />

                                            <TextInput id="area" type="text" class="mt-1 block w-full" v-model="form.area"
                                                required autocomplete="off" />

                                        </div>
                                        <div>
                                            <InputLabel for="dist" value="Distancia do Município" />

                                            <TextInput id="dist" type="text" class="mt-1 block w-full"
                                                v-model="form.distancia_do_munic" required autocomplete="off" />
                                        </div>
                                        <div>
                                            <InputLabel for="valor" value="Valor Aquisiçao" />

                                            <TextInput id="valor" type="number" class="mt-1 block w-full"
                                                v-model="form.valor_aquisicao" required autocomplete="off" />

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

        <div class="flex flex-wrap">
            <div @click="openModal()"
                class="h-36 w-36 p-8 bg-white m-2 border border-gray-200 rounded-lg shadow cursor-pointer">
                <div class="h-18 w-18 text-red-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                        stroke="currentColor" className="w-6 h-6">
                        <path strokeLinecap="round" strokeLinejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div v-for="prop in propriedades" :key="prop.COD_PROPRIEDADE">
                <div @dblclick="laVaiEle(prop.COD_PROPRIEDADE)" width="540px"
                    class="h-36 overflow-hidden cursor-pointer px-9 py-6 bg-white m-2 border border-gray-200 rounded-lg shadow ">
                    <div class="container">

                        <div class="text-xl m-1 text-red-800 row overflow-hidden">
                            {{ prop.NOME_PROPRIEDADE }}
                        </div>

                        <div class="text-sm row columns-2 ">
                            <div class="col-6 align-right"> Valor: R$ {{ formatPrice(prop.VALOR_AQUISICAO) }}</div>
                            <div class="col-6 align-left">Dist {{ prop.DISTANCIA_DO_MUNIC }} Km</div>
                        </div>

                        <div class="row ">
                            Area: {{ prop.AREA }} Hec<sup>2</sup>
                        </div>

                        <div class="row flex flex-nowrap justify-end">
                            <svg @click="current(prop)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="cursor-pointer text-blue-800 w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>

                            <svg @click="destroy(prop)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="cursor-pointer text-red-800 w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


