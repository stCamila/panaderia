<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Bar, Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);
import { ref } from 'vue';

const props = defineProps({
	clientes: { type: Object },
	productos: { type: Array  }
});

const cli = ref([]);
const pro = ref([]);
const charData1 = ref([]);
const charOptions1 = ref([]);
const colors= ref([]);

const random = () => {
	return Math.floor(Math.random() * 256);
}
//Grafica

if (Array.isArray(props.productos)) {
    props.productos.map((row) => (
        pro.value.push(row.producto),
        cli.value.push(row.clientes.length),
        colors.value.push('rgb('+random()+','+random()+','+random()+')')
    ));
}
charOptions1.value = { responsive: true };
charData1.value = {
    labels: pro.value,
    datasets: [{
        label:'Clientes', data:cli.value, backgroundColor: colors
    }]
};
</script>

<template>
	<Head title="Dashboard" />
	
	<AuthenticatedLayout>
		<template #header>
			Dashboard
		</template>
		
		<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
              <!-- Card -->
              <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total de clientes
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ clientes.length }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  						<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
					</svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total de productos
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ productos }}
                  </p>
                </div>
              </div>
			</div>
			  <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-g">
				<div class="min-w-0 p-4 rounded-lg shadow-xs">
					<span class="text-lg p-4">Cliente por Producto</span>
					<div class="flex items-center">
						<Bar :data="charData1" :options="charOptions1"></Bar>
					</div>
				</div>
			</div>
	</AuthenticatedLayout>
</template>
