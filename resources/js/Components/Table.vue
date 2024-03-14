<script setup>
import { computed, useSlots, ref } from "vue";

const props = defineProps({
    headers: {
        type: Array,
        required: true,
    },
    rows: {
        type: Array,
        required: true,
    },
    onRowClick: {
        type: Function,
        default: (row) => {},
    },
    rowClass: {
        type: [String, Function],
        default: "",
    },
    draggable: {
        type: Boolean,
        default: false,
    },
    onDragComplete: {
        type: Function,
        default: (newRows) => {},
    },
});

const hasActions = computed(() => !!useSlots().actions);

const getFieldFromObject = (row, field) => {
    return typeof field === "function" ? field(row) : row[field];
};

const getFieldValue = (row, header) => {
    return getFieldFromObject(row, header.field);
};

const getRowClass = (row) => {
    return typeof props.rowClass === "function"
        ? props.rowClass(row)
        : props.rowClass;
};

const draggedRow = ref(null);
const dragOverIndex = ref(null);
const isDragging = ref(false);

const handleDragStart = (event, row) => {
    draggedRow.value = row;
    isDragging.value = true;
    event.dataTransfer.effectAllowed = "move";
};

const handleDragOver = (event) => {
    event.preventDefault();
    const targetElement = event.target.closest("tr");

    if (targetElement) {
        const draggedOverRow = targetElement.parentNode;
        dragOverIndex.value = Array.from(
            draggedOverRow.parentNode.children
        ).indexOf(draggedOverRow);
    } else {
        dragOverIndex.value = null;
    }
};

const handleDragEnd = () => {
    if (draggedRow.value && dragOverIndex.value !== null) {
        const draggedIndex = props.rows.indexOf(draggedRow.value);

        if (draggedIndex !== dragOverIndex.value) {
            const newRows = [...props.rows];
            newRows.splice(draggedIndex, 1);
            newRows.splice(dragOverIndex.value, 0, draggedRow.value);

            // Emit the new order to the parent component
            props.onDragComplete(newRows); // Optional callback for internal processing
        }
    }

    draggedRow.value = null;
    dragOverIndex.value = null;
    isDragging.value = false;
};
</script>

<template>
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
                class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
            >
                <slot name="top" />
                <div
                    class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg"
                >
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    v-for="(header, index) in headers"
                                    :key="index"
                                    scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                >
                                    {{ header.label }}
                                </th>
                                <th
                                    v-if="hasActions"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr
                                v-for="(row, index) in rows"
                                :key="index"
                                class="hover:bg-gray-100"
                                :class="[
                                    getRowClass(row),
                                    draggable ? 'cursor-move' : '',
                                ]"
                                :draggable="draggable"
                                @dragstart="handleDragStart($event, row)"
                                @dragover="handleDragOver($event, row)"
                                @dragend="handleDragEnd"
                                @click="onRowClick(row)"
                            >
                                <td
                                    v-for="(header, index) in headers"
                                    :key="index"
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                    v-html="getFieldValue(row, header)"
                                ></td>
                                <td
                                    v-if="hasActions"
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                >
                                    <slot name="actions" v-bind="row" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <slot name="bottom" />
            </div>
        </div>
    </div>
</template>
