import { ref, reactive } from "vue";
import axios from "axios";

export const useCategory = (type = 1) => {

    const URL = "/ajax/categories";

    const isOpenModal = ref(false);
    const categories = ref([]);
    const categoryForm = reactive({
        name: "",
        parent_id: type,
    });

    const saveCategory = () => {

        if (!categoryForm.name) {
            alert('Campo nombre vacío');
            return;
        }

        axios
            .post(URL, categoryForm)
            .then((response) => {
                const { data } = response;
                resetForm();
                closeModal();
                loadModels();
            })
            .catch((error) => {
                resetForm();
                closeModal();
                console.log(error);
            });
    }

    const loadModels = () => {
        axios
            .get(`${URL}?type=${type}`)
            .then((response) => {
                const { data } = response;
                categories.value = data;
            })
            .catch((error) => console.log);
    }

    const resetForm = () => {
        categoryForm.name = "";
        categoryForm.parent_id = type;
    }

    const closeModal = () => {
        isOpenModal.value = false;
    };

    const openModal = () => {
        resetForm();
        isOpenModal.value = true;
    };

    loadModels();

    return {
        categories,
        categoryForm,
        isOpenModal,
        openModal,
        closeModal,
        saveCategory,
    }
}
