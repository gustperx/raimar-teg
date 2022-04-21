import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

export const useDeleteModal = (routeText) => {
    const isOpenModal = ref(false);
    const form = useForm({
        itemId: "",
    });

    const deleteItem = () => {
        form.delete(route(routeText, [form.itemId]), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onFinish: () => form.reset(),
        });
    };

    const closeModal = () => {
        isOpenModal.value = false;
        form.reset();
    };

    const confirmDeletion = (itemId) => {
        isOpenModal.value = true;
        form.itemId = itemId;
    };

    return {
        isOpenModal,
        deleteItem,
        closeModal,
        confirmDeletion,
    };
};
