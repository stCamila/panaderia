<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { ref } from 'vue';

const props = defineProps({
    clientes: { type: Object }, productos: { type: Object }
});
const form = useForm({nombre:'', apellido:'', id_producto:''});
const v = ref({id:'', nombre:'', apellido:'', producto:[]});
const showModalView = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);
const nombre = ref('');
const operation = ref(1);
const msj = ref('');
const classMsj = ref('hidden');

const openModalView = (a) =>{
    v.value.nombre = a.apellido+' '+a.nombre;
    v.value.producto = a.productos;
    showModalView.value = true;
}
const openModalForm = (op,a) =>{
    showModalForm.value = true;
    operation.value = op;
    if(op === 1){
        nombre.value = 'Crear Cliente';
        form.nombre = '';
        form.apellido = '';
        form.id_producto = '';
    }
    else{
        nombre.value = 'Editar Cliente';
        form.nombre = a.nombre;
        form.apellido = a.apellido;
        form.id_producto = a.productos.length ? a.productos[0].id : '';
        v.value.id = a.id;
    }
}
const openModalDel = (a) =>{
    showModalDel.value = true;
    v.value.id =a.id;
    v.value.nombre = apellido+ ' '+a.nombre;
}
const closeModalView = () =>{
    showModalView.value = false;
}
const closeModalForm = () =>{
    showModalForm.value = false;
    form.reset();
    
}
const closeModalDel = () =>{
    showModalDel.value = false;
    
}
const save = () =>{
   if (operation.value == 1) {
      form.post(route('clientes.store'),{
        onSuccess: () =>{ok('Cliente creado :)')}
   });
  }
  else{
    form.put(route('clientes.update',v.value.id),{
        onSuccess: () =>{ok('Cliente actualizado :)')}
   });
  }
}
const ok = (m) =>{
  if (operation.value == 2) {
    closeModalForm();
  } 
  closeModalDel();
  form.reset();
  msj.value = m;
  classMsj.value = 'block';
  setTimeout(() => {
    classMsj.value = 'hidden';
  }, 8000);
}

const deleteCliente = () =>{
    form.delete(route('clientes.destroy', v.value.id),{
        onSuccess: () => { ok('Cliente eliminado')}
    })
}
</script>

<template>
    <Head title="Clientes" />
    <AuthenticatedLayout>
        <template #header>
            Clientes
            <DarkButton @click="openModalForm(1)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
            </DarkButton>
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
                    <th class="px-4 py-3">Apellido</th>
                    <th class="px-4 py-3">Producto</th>
                    <th class="px-4 py-3">Detalle</th>
                    <th class="px-4 py-3">Editar</th>
                    <th class="px-4 py-3">Eliminar</th>
                     </tr>
                  </thead>
                     <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="a,i in clientes" :key="a.id" class="text-gray-700">
                            <td class="px-4 py-3 text-sm">
                                {{ (i + 1) }}
                            </td>
                             <td class="px-4 py-3 text-sm">
                                {{ a.nombre }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ a.apellido }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                            <span v-for="producto in a.productos" :key="producto.id">
                                {{ producto.nombre }}
                            </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <SecondaryButton @click="openModalView(a)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </SecondaryButton>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <WarningButton  @click="openModalForm(2,a)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </WarningButton>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <DangerButton  @click="openModalDel(a)">
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
        </div>
        <Modal :show="showModalView" @close="closeModalView">
        <div class="p-6">
            <p>Cliente: <span class="text-lg font-medium text-gay-900">{{ v.nombre }}</span></p>
               Compras:
               <ol>
                <li class="text-lg font-medium text-gay-900" v-for="b,i in v.producto">
                    {{ (i+1)+') '+b.nombre }}
                </li>
               </ol>
        </div>
        <div class="m-6 flex justify-end">
            <SecondaryButton @click="closeModalView">Cancel</SecondaryButton>
        </div>
        </Modal>

        <Modal :show="showModalForm" @close="closeModalForm">
         <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">{{ nombre }}</h2>
            <div class="mt-6 mb-6 space-y-6 max-w-xl">
                <InputGroup :text="'Nombre'" :required="'required'" v-model="form.nombre" :type="text">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </InputGroup>
                <InputError class="mt-1" :message="form.errors.nombre"></InputError>
                <InputGroup :text="'Apellido'" :required="'required'" v-model="form.apellido" :type="text">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </InputGroup>
                <InputError class="mt-1" :message="form.errors.apellido"></InputError>
                <SelectInput :text="'Producto'" :required="'required'" v-model="form.id_producto" :options="productos">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                    </svg>
                </SelectInput>
                <InputError class="mt-1" :message="form.errors.id_producto"></InputError>
                <PrimaryButton @click="save">Guardar</PrimaryButton>
            </div>
          </div>
          <div class="m-6 flex justify-end">
            <SecondaryButton @click="closeModalForm">Cancel</SecondaryButton>
           </div>
        </Modal>

        <Modal :show="showModalDel" @close="closeModalDel">
        <div class="p-6">
          <p class="text-xl text-gay-500">
            ¿Estás seguro de eliminar al cliente
            <span class="text-2xl font-medium text-gay-900">{{ v.nombre }}</span> ?</p>
            <PrimaryButton @click="deleteCliente">Sí,borrar</PrimaryButton>
        </div>
        <div class="m-6 flex justify-end">
            <SecondaryButton @click="closeModalDel">Cancel</SecondaryButton>
        </div>
      </Modal>
    </AuthenticatedLayout>
</template>