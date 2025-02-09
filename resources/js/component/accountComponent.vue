<template>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Акаунти</h2>
            <button @click="showAddAccountModal = true" class="btn btn-success btn-lg">
                <i class="bi bi-plus-circle"></i> Додати новий акаунт
            </button>
        </div>

        <div v-if="showAddAccountModal" class="modal fade show" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true" style="display: block;">
            <div class="modal-dialog" style="width: 50%; margin: 0 auto;">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-center" id="addAccountModalLabel">Додати новий акаунт</h5>
                        <button type="button" class="btn-close" @click="showAddAccountModal = false" aria-label="Закрити"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addAccount">
                            <div class="mb-3">
                                <label for="accountName" class="form-label mr-4">Ім'я акаунту</label>
                                <input type="text" v-model="newAccount.Account_Name" class="form-control input-custom" :class="{'is-invalid': errors.Account_Name}" id="accountName" placeholder="Ім'я акаунту" required>
                                <div v-if="errors.Account_Name" class="invalid-feedback">
                                    {{ errors.Account_Name }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="accountPhone" class="form-label mr-4">Телефон</label>
                                <input type="tel" v-model="newAccount.Phone" class="form-control input-custom" :class="{'is-invalid': errors.Phone}" id="accountPhone" placeholder="Телефон" required>
                                <div v-if="errors.Phone" class="invalid-feedback">
                                    {{ errors.Phone }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="accountWebsite" class="form-label mr-4">Веб-сайт</label>
                                <input type="url" v-model="newAccount.Website" class="form-control input-custom" :class="{'is-invalid': errors.Website}" id="accountWebsite" placeholder="Веб-сайт" required>
                                <div v-if="errors.Website" class="invalid-feedback">
                                    {{ errors.Website }}
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Зберегти</button>
                            <button type="button" class="btn btn-secondary ms-3" @click="showAddAccountModal = false">Закрити</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showAddAccountModal" class="modal-backdrop fade show"></div>

        <div v-if="accounts.length" class="table-responsive mt-5">
            <table class="table table-bordered table-hover" style="width: 100%;">
                <thead class="table-dark">
                <tr>
                    <th>Ім'я акаунту</th>
                    <th>Телефон</th>
                    <th>Веб-сайт</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="account in accounts" :key="account.id">
                    <td>{{ account.Account_Name }}</td>
                    <td>{{ account.Phone }}</td>
                    <td>{{ account.Website }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <p v-else class="text-center text-muted">Акаунти не знайдено.</p>
    </div>
</template>

<script lang="ts" setup>
import {defineProps, ref} from 'vue';
import axios from 'axios';
import {Account} from "../object/Accounts";

const showAddAccountModal = ref(false);
const newAccount = ref({
    Account_Name: '',
    Phone: '',
    Website: '',
});
const props = defineProps<{
    accountsProps: Account[];

}>();
const accounts = ref(props.accountsProps);
const errors = ref<{ [key: string]: string }>({});

const addAccount = async () => {
    errors.value = {};

    if (!newAccount.value.Account_Name) {
        errors.value.Account_Name = 'Ім\'я акаунту є обов\'язковим';
    }

    if (!newAccount.value.Phone) {
        errors.value.Phone = 'Телефон є обов\'язковим';
    }

    if (!newAccount.value.Website) {
        errors.value.Website = 'Веб-сайт є обов\'язковим';
    }

    if (Object.keys(errors.value).length > 0) {
        return;
    }

    try {
        const response = await axios.post('/api/createAccount', newAccount.value);
        if (response.status === 201) {
            alert(response.data.message);

            const getResponse = await axios.get('/api/getAccounts');
            accounts.value = getResponse.data;

        } else {
            alert(response.data.message);
        }
    } catch (error) {
        alert(error);
    }

    showAddAccountModal.value = false;
    newAccount.value = { Account_Name: '', Phone: '', Website: '' };
};
</script>

<style scoped>
.invalid-feedback {
    display: block;
    color: #dc3545;
}

.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}
</style>
