<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Table from "@/Components/Table.vue";
import { Link, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
    tasks: Object,
});

const headers = [
    {
        label: "Name",
        field: "name",
    },
    {
        label: "Completed",
        field: function (row) {
            return row.completed ? "Yes" : "No";
        },
    },
    {
        label: "Priority",
        field: "priority",
    },
];

const updatePriorities = async (newRows) => {
    try {
        const form = useForm({
            tasks: newRows,
        });

        form.post(route("tasks.update-priorities"), {
            onSuccess: (response) => {
                console.log(
                    `Updated ordered: ${JSON.stringify(response.props.tasks)}`
                );
            },
        });
    } catch (error) {
        console.error("Error updating priorities:", error);
    }
};

const destroy = async (id) => {
    if (confirm("Are you sure you want to delete this task?")) {
        router.delete(route("tasks.destroy", id));
    }
};
</script>

<template>
    <AppLayout title="Tasks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tasks
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <Table
                    :headers="headers"
                    :rows="tasks"
                    draggable
                    :onDragComplete="updatePriorities"
                >
                    <template #top>
                        <div class="flex justify-end mb-4">
                            <PrimaryButton :href="route('tasks.create')">
                                Create Task
                            </PrimaryButton>
                        </div>
                    </template>

                    <template v-slot:actions="row">
                        <Link
                            :href="`/tasks/${row.id}/edit`"
                            class="cursor-pointer text-indigo-600 hover:text-indigo-900"
                        >
                            Edit
                        </Link>
                        <span class="mx-2">|</span>
                        <Link
                            href=""
                            @click="() => destroy(row.id)"
                            class="cursor-pointer text-red-600 hover:text-red-900"
                            >Delete
                        </Link>
                    </template>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
