<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
   productos: { type: Object }, flash: { type: Object }
});
const form = useForm ({id:'', nombre:''});
const showModalDel = ref(false);
const msj = ref ( (props.flash.success != null) ? props.flash.success:'');
const classMsj = ref ( (props.flash.success != null) ? '' : 'hidden' );

const openModalDel = (p) =>{
    form.id = p.id;
    form.nombre = p.nombre;
    showModalDel.value = true;
}
const closeModalDel = () =>{
    showModalDel.value = false;
}
const deleteProducto = () =>{
    form.delete (route('productos.destroy', form.id),{
        onSuccess: () => {ok('Producto eliminado :(')}
    })
}
const ok = (m) =>{
  closeModalDel();
  form.reset();
  msj.value = m;
  classMsj.value = 'block';
  setTimeout(() => {
    classMsj.value = 'hidden';
  }, 8000);
}
</script>
<template>
    <Head title="Productos" />
    <AuthenticatedLayout>
        <template #header>
            Productos
        </template>
        <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
				<div class="flex justify-center items-center w-12 bg-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
				</div>
				
				<div class="px-4 py-2 -mx-3">
					<div class="mx-3">
						<span class="font-semibold text-blue-500">Success</span>
						<p class="text-sm text-gray-600">{{ msj }}</p>
					</div>
				</div>
			</div>
                    
        <div class="w-full overflow-hidden rounded-lg border shadow-md">
            <div class="w-full overflow-x-auto bg-white">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Descripción</th>
                    <th class="px-4 py-3">Imagen</th>
                    <th class="px-4 py-3">Detalle</th>
                    <th class="px-4 py-3">Editar</th>
                    <th class="px-4 py-3">Eliminar</th>
                     </tr>
                  </thead>
                     <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="p,i in productos.data" :key="p.id" class="text-gray-700">
                            <td class="px-4 py-3 text-sm">
                                {{ (i + 1) }}
                            </td>
                             <td class="px-4 py-3 text-sm">
                                {{ p.nombre }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ p.descripcion }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <img :src="'storage' + p.image" width="60">

                            </td>
                            <td class="px-4 py-3 text-sm">
                                <NavLink :href="route('productos.show', p.id)">
                                <SecondaryButton>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </SecondaryButton>
                            </NavLink>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <NavLink :href="route('productos.edit', p.id)">
                                <WarningButton>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </WarningButton>
                                </NavLink>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <DangerButton  @click="openModalDel(p)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </DangerButton>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
				class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
				<pagination :links="productos.links" />
			</div>
        </div>
        <Modal :show="showModalDel" @close="closeModalDel">
        <div class="p-6">
          <p class="text-xl text-gay-500">
            ¿Estás seguro de eliminar el producto
            <span class="text-2xl font-medium text-gay-900">{{ form.nombre }}</span> ?</p>
            <PrimaryButton @click="deleteProducto">Sí,borrar</PrimaryButton>
        </div>
        <div class="m-6 flex justify-end">
            <SecondaryButton @click="closeModalDel">Cancel</SecondaryButton>
        </div>
      </Modal>
    </AuthenticatedLayout>
</template>