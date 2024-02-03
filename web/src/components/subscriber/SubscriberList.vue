<template>
    <div>
        <div class="pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Subscribers</h1>
        </div>

        <div class="rounded-table">
            <table class="table table-striped">
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
                    <tr v-for="subscriber in subscriberData" :key="subscriber.email">
                        <td>{{ subscriber.email }}</td>
                        <td>{{ subscriber.firstName }}</td>
                        <td>{{ subscriber.lastName }}</td>
                        <td>{{ subscriber.status }}</td>
                        <td>
                            <button class="btn btn-secondary" @click="viewSubscriber(subscriber.email)">View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue'
import { useRouter } from 'vue-router'

export default defineComponent({
  name: 'SubscriberList',
  data() {
    return {
      subscriberData: [
                { email: 'john@example.com', firstName: 'John', lastName: 'Doe', status: 'active' },
                { email: 'jane@example.com', firstName: 'Jane', lastName: 'Doe', status: 'inactive' },
                { email: 'bob@example.com', firstName: 'Bob', lastName: 'Smith', status: 'suspended' },
                { email: 'john@example.com', firstName: 'John', lastName: 'Doe', status: 'active' },
                { email: 'jane@example.com', firstName: 'Jane', lastName: 'Doe', status: 'inactive' },
                { email: 'bob@example.com', firstName: 'Bob', lastName: 'Smith', status: 'suspended' },
                { email: 'john@example.com', firstName: 'John', lastName: 'Doe', status: 'active' },
                { email: 'jane@example.com', firstName: 'Jane', lastName: 'Doe', status: 'inactive' },
                { email: 'bob@example.com', firstName: 'Bob', lastName: 'Smith', status: 'suspended' },
                { email: 'john@example.com', firstName: 'John', lastName: 'Doe', status: 'active' },
      ]
    }
  },
  setup() {
    const router = useRouter()

    const viewSubscriber = (email: string) => {
      router.push(`/subscribers/${email}`)
    }

    return {
      viewSubscriber
    }
  }
})
</script>

<style lang="scss" scoped>
@import '@/assets/styles/theme.scss';

table {
    width: 100%;
}

.rounded-table {
    margin: 2em;
    padding: 1em;
    border-radius: 2px;
    background-color: $white;
}
</style>