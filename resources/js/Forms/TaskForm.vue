<script setup>
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";

defineProps({
    form: {
        type: Object,
        required: true,
    },
    submitLabel: {
        type: String,
        default: "Save",
    },
    errors: {
        type: Object,
        default: () => ({}),
    },
    title: {
        type: String,
        default: "Task Details",
    },
    description: {
        type: String,
        default: "",
    },
});

defineEmits(["submit"]);
</script>

<template>
    <FormSection @submitted="$emit('submit')">
        <template #title>{{ title }}</template>

        <template #description>{{ description }}</template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Name" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="priority"
                    value="Priority (between 1 and 10)"
                />
                <TextInput
                    id="priority"
                    v-model="form.priority"
                    type="number"
                    class="mt-1 block w-full"
                    min="1"
                    max="10"
                />
                <InputError :message="form.errors.priority" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <label class="flex items-center">
                    <Checkbox
                        id="completed"
                        v-model:checked="form.completed"
                        name="completed"
                    />
                    <InputLabel
                        class="ms-2 text-sm text-gray-600 select-none"
                        for="completed"
                        value="Completed"
                    />
                </label>
            </div>
        </template>
        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                {{ submitLabel }}
            </PrimaryButton>
        </template>
    </FormSection>
</template>
