import { createRouter, createWebHistory } from 'vue-router'
import SubscriberList from './components/subscriber/SubscriberList.vue'
import SubscriberView from './components/subscriber/SubscriberView.vue'

// todo - add homepage here explaining the project.
const routes = [
  { path: '/subscribers', component: SubscriberList },
  { path: '/subscribers/:email', component: SubscriberView, props: true }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router