<script>
// import { computed, ref, watch } from 'vue';
// paginate phones based on filter
export default {
    props: {
        phones: {
            type: Array,
            required: true
        }
    },
    computed: {
        filteredPhones() {
            return this.phones.filter(phone => {
                return (
                    (this.filter.country === '' || phone.country === this.filter.country) &&
                    (this.filter.valid === '' || phone.valid === this.filter.valid)
                );
            });
        },
        displayedPhones() {
            return this.filteredPhones.slice(
                (this.currentPage - 1) * this.perPage,
                this.currentPage * this.perPage
            );
        },
        totalPages() {
            return Math.ceil(this.filteredPhones.length / this.perPage);
        }
    },
    data() {
        return {
            countries: [...new Set(this.phones.map(phone => phone.country))],


            currentPage: 1,
            perPage: 10,
            filter: {
                country: '',
                valid: '',
            }
        };
    },
    methods: {
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        }
    },
    watch: {
        filter: {
            handler() {
                this.currentPage = 1;
            },
            deep: true
        },

    }
}
</script>

<template>
    <div class="m-5">
        <h1 class="text-left text-3xl">Phone numbers</h1>
    </div>
    <section id="filter">
        <div class="m-5 grid grid-cols-2 gap-4 ">
            <div>
                <label for="country">Country</label>
                <select v-model="filter.country" id="country" class="border rounded w-full">
                    <option value="" selected>All</option>
                    <template v-for="country in countries">
                        <option :value="country">{{ country }}</option>
                    </template>
                </select>
            </div>
            <div>
                <label for="state">State</label>
                <select v-model.number="filter.valid" id="state" class="border rounded w-full">
                    <option value="" selected>All</option>
                    <option value="1">Valid</option>
                    <option value="0">Invalid</option>
                </select>
            </div>
        </div>
    </section>
    <section id="table" class="m-5">
        <table class="table-auto w-full">
            <thead>
                <tr class="text-left border">
                    <th class="px-4 py-2">Country</th>
                    <th class="border px-4 py-2">State</th>
                    <th class="px-4 py-2">Country Code</th>
                    <th class="border px-4 py-2">Phone Number</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="phone in displayedPhones" :key="phone.id">
                    <td class="border px-4 py-2">{{ phone.country }}</td>
                    <td class="border px-4 py-2">{{ phone.valid ? 'OK' : 'NOK' }}</td>
                    <td class="border px-4 py-2">{{ phone.country_code }}</td>
                    <td class="border px-4 ">{{ phone.number }}</td>
                </tr>
            </tbody>
        </table>

        <div class="flex mt-5 justify-end gap-2">
            <button @click="prevPage"
                    :disabled="currentPage === 1"
                    :class="{'opacity-50 cursor-not-allowed': currentPage === 1}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Previous
            </button>
            <button @click="nextPage"
                    :disabled="currentPage === totalPages"
                    :class="{'opacity-50 cursor-not-allowed': currentPage === totalPages}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            >
                Next
            </button>
        </div>
    </section>
</template>
