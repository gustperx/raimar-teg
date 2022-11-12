import { ref } from "vue";
import axios from "axios";

export const usePassword = () => {
    const URL = "/users/generate-password";

    const isOpenModal = ref(false);
    const userId = ref();

    const generatePassword = () => {
        if (!userId.value) {
            return;
        }

        axios
            .post(`${URL}/${userId.value}`)
            .then((response) => {
                userId.value = null;
                closeModalPassword();
                location.reload();
            })
            .catch((error) => {
                userId.value = null;
                closeModalPassword();
                console.log(error);
            });
    };

    const closeModalPassword = () => {
        userId.value = null;
        isOpenModal.value = false;
    };

    const confirmGeratePassword = (itemId) => {
        userId.value = null;
        isOpenModal.value = true;
        userId.value = itemId;
    };

    return {
        isOpenModalPassword: isOpenModal,
        closeModalPassword,
        confirmGeratePassword,
        generatePassword,
    };
};
