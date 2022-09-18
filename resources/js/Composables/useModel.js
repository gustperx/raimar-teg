import { ref, reactive } from "vue";
import axios from "axios";

export const useModel = (type = 1) => {

    const URL = "/models";

    const isOpenModal = ref(false);
    const models = ref([]);
    const modelForm = reactive({
        name: "",
        type,
    });

    const saveModel = () => {

        if (!modelForm.name) {
            alert('Campo nombre vacío');
            return;
        }

        axios
            .post(URL, modelForm)
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
                models.value = data;
            })
            .catch((error) => console.log);
    }

    const resetForm = () => {
        modelForm.name = "";
        modelForm.type = type;
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
        models,
        modelForm,
        isOpenModal,
        openModal,
        closeModal,
        saveModel,
    }
}
