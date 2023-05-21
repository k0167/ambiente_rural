<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLogoMin from '@/Components/ApplicationLogo.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Bem Vindo" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-black selection:bg-red-500 selection:text-white">
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
            Main</Link>

            <template v-else>
                <Link :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Log in</Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Register</Link>
            </template>
        </div>

        <div class="m-8 text-white flex justify-center flex-wrap">

            <AppLogoMin class="m-96"></AppLogoMin>

            <div class="m-8">
                Trabalho para a disciplina de Programação Orientada a Objeto com Banco de
                Dados - Criação de ambiente Crud com Laravel e Vue.js | Acesso ao Banco de Dados PostgreSQL
            </div>
            <div class="m-8">
                <div class="max-w-sm rounded overflow-hidden shadow-lg">
                    <div class="flex justify-center">
                        <img class="w-24" src="/img/laravel.png">
                    </div>
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">Laravel</div>
                        <p class="text-gray-400 text-base">
                            Escolher o Laravel traz vantagens devido à sua elegância, vasta documentação, comunidade ativa,
                            recursos avançados, produtividade e segurança.
                        </p>
                    </div>
                </div>
            </div>
            <div class="m-8">
                <div class="max-w-sm rounded overflow-hidden shadow-lg">
                    <div class="flex justify-center">
                        <img class="w-24" src="/img/vue.png">
                    </div>
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">Vue</div>
                        <p class="text-gray-400 text-base">
                            Vue 3 é uma biblioteca JavaScript moderna, com reatividade eficiente, componentes reutilizáveis
                            e uma sintaxe intuitiva, tornando o desenvolvimento de interfaces web rápido e fácil.
                        </p>
                    </div>
                </div>
            </div>
            <div class="m-8">
                <div class="max-w-sm rounded overflow-hidden shadow-lg">
                    <div class="flex justify-center">
                        <img class="w-24" src="/img/postgres.png">
                    </div>
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">PostgreSQL</div>
                        <p class="text-gray-400 text-base">
                            PostgreSQL é um poderoso sistema de gerenciamento de banco de dados relacional de código aberto,
                            conhecido por sua confiabilidade, desempenho, recursos avançados e suporte a SQL completo.
                        </p>
                    </div>
                </div>
            </div>
            <div class="m-8">
                <div class="max-w-sm rounded overflow-hidden shadow-lg">
                    <div class="flex justify-center">
                        <img class="w-24" src="/img/inertia.png">
                    </div>
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">InertiaJS</div>
                        <p class="text-gray-400 text-base">
                            Inertia é uma abordagem moderna para desenvolvimento web que combina o poder do backend (como
                            Laravel) com a interatividade do frontend (como Vue.js), permitindo a criação de interfaces
                            dinâmicas sem APIs separadas.
                        </p>
                    </div>
                </div>
            </div>
            <div class="m-8">
                <div class="max-w-sm rounded overflow-hidden shadow-lg">
                    <div class="flex justify-center">
                        <img class="w-24" src="/img/tailwind.png">
                    </div>
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">Laravel</div>
                        <p class="text-gray-400 text-base">
                            Tailwind CSS é uma biblioteca CSS utilitária para criação rápida de interfaces modernas, com
                            classes pré-definidas que permitem personalização flexível.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}</style>
