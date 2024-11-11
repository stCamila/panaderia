<script setup>
import Form from './Form.vue';

const props = defineProps({
    clientes: { type:Object }, producto: {type:Object}, 
    clientesOfProducto:{ type:Object }
});
</script>

<template>
    <Form :clientes="clientes" :producto="producto" 
          :clientesOfProducto="clientesOfProducto "/>
</template>