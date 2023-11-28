<template>
    <div class="list-table-container">
        <h2>{{ props.title }}</h2>
        <table class="cb-list-table">
        <thead>
            <tr>
            <th>

            </th>
            <th>
                Name
            </th>
            <th>
                Identifier
            </th>
            <th>
                Extension
            </th>
            </tr>
        </thead>
        <tr
            v-for="item in props.items"
            :key="item.identifier"
        >
        <td><img src="../../assets/icons/DefaultContentElementIcon.svg" alt=""></td>
        <td> {{item.name}} </td>
        <td> {{item.identifier}} </td>
        <td> {{item.extension}} </td>
        </tr>
        </table>
    </div>
</template>

<script setup lang="ts">

interface Item {
    name: string;
    identifier: string;
    extension: string;
}

const props = defineProps({
    title: String,
    items: Array<Item>
})

</script>
