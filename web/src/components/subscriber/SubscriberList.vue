<template>
    <BasicContainer>
        <div>
            <div class="pt-3 pb-2 mb-3 border-bottom d-flex justify-content-between">
                <span class="title">Subscribers</span>

                <div>
                    <button type="button" class="btn btn-primary me-3 white" @click="refresh">Refresh</button>
                    <button type="button" class="btn btn-secondary" @click="visit('/subscribers/create')">Create</button>

                </div>

            </div>

            <div v-if="loading" class="d-flex justify-content-center align-items-center" style="height: 69vh;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <table v-else class="table">
                <caption></caption>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="subscriber in subscribers" :key="subscriber.email">
                        <td>{{ subscriber.email }}</td>
                        <td>{{ subscriber.name }}</td>
                        <td>{{ subscriber.lastName }}</td>
                        <td>
                            <BasicBadge :status="subscriber.status" />
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary"
                                @click="visit(`/subscribers/${subscriber.email}`)">View</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <nav aria-label="Page navigation" class="d-flex justify-content-between align-items-center">
                <div class="input-group mb-3 page-size-input">
                    <span class="align-self-center page-size-span" id="pageSize">Page size</span>
                    <input type="number" class="form-control" placeholder="10" aria-label="PageSize"
                        aria-describedby="pageSize" v-model="pageSize">
                </div>

                <div>
                    <ul class="pagination">
                        <li class="page-item" :class="{ disabled: page === 1 }">
                            <a class="page-link" href="#" @click.prevent="page--">Previous</a>
                        </li>
                        <li class="page-item" v-for="n in Array.from({ length: 5 }, (_, i) => page - 2 + i)" :key="n"
                            :class="{ active: page === n }">
                            <a class="page-link" href="#" @click.prevent="page = n"
                                v-if="n > 0 && n <= pagination.totalPages">{{ n }}</a>
                        </li>
                        <li class="page-item" :class="{ disabled: page === pagination.totalPages }">
                            <a class="page-link" href="#" @click.prevent="page++">Next</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </BasicContainer>
</template>
<script lang="ts">
import { defineComponent, ref, onMounted, watch, computed } from 'vue'
import { useRouter } from 'vue-router'
import { Subscriber, getAllSubscribers, PaginationMetadata } from '@/services/subscriberService'
import { debounce } from '@/utilities/helper'
import BasicContainer from '@/components/common/BasicContainer.vue'
import BasicBadge from '@/components/common/BasicBadge.vue'

export default defineComponent({
    name: 'SubscriberList',
    components: {
        BasicContainer,
        BasicBadge,
    },
    setup() {
        const subscribers = ref([] as Subscriber[]);
        const pagination = ref({} as PaginationMetadata);
        const page = ref(1);
        const pageSize = ref(10);
        const loading = ref(true);
        const error = ref("");

        const router = useRouter()

        const fetchSubscribers = debounce(async () => {
            loading.value = true;
            try {
                const { metadata, data } = await getAllSubscribers({ page: page.value, pageSize: pageSize.value });
                pagination.value = metadata;
                subscribers.value = data;
            } catch (e: unknown) {
                if (e instanceof Error) {
                    error.value = e.message;
                } else {
                    error.value = "Something happened";
                }
            }
            finally {
                setTimeout(() => {
                    loading.value = false
                }, 500) // Simulate a small delay
            }
        }, 500);

        // Load data at on component mount.
        onMounted(() => fetchSubscribers())

        watch(page, fetchSubscribers);
        watch(pageSize, fetchSubscribers);

        const visit = (destination: string) => {
            router.push(destination)
        }

        const pageNumbers = computed(() => {
            const start = Math.max(1, page.value - 2);
            const end = Math.min(pagination.value.totalPages, page.value + 2);
            return Array.from({ length: end - start + 1 }, (_, i) => start + i);
        })

        return {
            subscribers,
            pagination,
            page,
            pageSize,
            loading,
            error,
            visit,
            refresh: fetchSubscribers,
            pageNumbers,
        }
    }
})
</script>

<style lang="scss" scoped>
@import '@/assets/styles/_variables.scss';

.title {
    align-self: stretch;
    flex-grow: 0;
    line-height: 1.3;
    letter-spacing: normal;
    text-align: left;
    color: $black;

    font: {
        size: 1.75em;
        weight: bold;
        stretch: normal;
        style: normal;
    }
}

.table {
    border-top: 1px solid $gray-150;

    thead th {
        color: lighten($gray-400, 25%);
        border: none;
        padding-left: 0;
    }

    tr {
        max-height: 2.875em;

        &:last-child {
            border-top: 1px solid transparent;
        }

        td {
            color: $gray-400;
            padding: 0.75em 0;
        }
    }
}

.page-size-input {
    width: 150px;

    input {
        border-radius: 5px !important;
        cursor: pointer;
    }
}

.page-size-span {
    color: $gray-400;
    display: block;
    margin-right: 1em;
}

.white {
    color: $white !important;
}
</style>