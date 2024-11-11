<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';

const props = defineProps({
   producto: { type: Object }, clientes: { type: Object }
});
</script>

<template>
    <Head title="Producto" />
    <AuthenticatedLayout>
        <template #header>
            <div class="incline-flex overflow-hidden mb-4 w-full">
                {{ producto.nombre }}
                <NavLink :href="route('productos.index')">
                    <DarkButton>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                        </svg>
                    </DarkButton>
                </NavLink>
            </div>
        </template>
        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-g">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <p>Descripción: <span class="text-gray-900 font-semibold">{{ producto.descripcion}}</span></p>
                <p>Precio $: <span class="text-gray-900 font-semibold">{{ producto.precio}}</span></p>
                <p>En existencia: <span class="text-gray-900 font-semibold">{{ producto.stock}}</span></p>
                <p>Clientes: 
                   <span v-for="a,i in clientes " class="text-gray-900 font-semibold">
                      <a v-if="i == (clientes.length-1)">{{ a.apellido+' '+a.nombre }}</a>
                      <a v-else>{{ a.apellido+' '+a.nombre+', ' }}</a>
                   </span>
                </p>
            </div>
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <img :src="'../storage'+producto.image" :alt="producto.nombre" width="500">
            </div>
        </div>
    </AuthenticatedLayout>
</template>